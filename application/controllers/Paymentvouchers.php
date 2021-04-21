<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentvouchers extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	/*public function index()
	{
		if(strpos($this->loginuser->privileges, 'pvsee') !== false)
		{
		$data['admessage'] = '';
		$this->lang->load('paymentvouchers', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['paymentvouchers'] = $this->Admin_mo->getjoinLeft('paymentvouchers.*,items.iname as item,items.iquantity as iquantity,itemmodels.imname as model,itemtypes.itname as type','paymentvouchers',array('items'=>'paymentvouchers.pviid=items.iid', 'itemmodels'=>'items.iimid=itemmodels.imid', 'itemtypes'=>'itemmodels.imitid=itemtypes.itid'),array());
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/paymentvouchers',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('messages');
		}
		else redirect('home', 'refresh');
	}*/

	function __construct()
    {
		parent::__construct();
	    if(!$this->session->userdata('uid'))
	    { 
			redirect('home');
	    }
		else
		{
			$this->loginuser = $this->Admin_mo->getrow('users',array('uid'=>$this->session->userdata('uid')));
		}
	}

	public function index()
	{
		if(strpos($this->loginuser->privileges, ',pvsee,') !== false)
		{
		if($this->loginuser->uitid != '')
		{
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$data['admessage'] = '';
			$data['admessagearr'] = array();
			$this->lang->load('paymentvouchers', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['paymentvouchers'] = $this->Admin_mo->getjoinLeft('paymentvouchers.*,users.username as user,orders.endtime as endtime,items.iname as item,itemtypes.itname as type,itemmodels.imname as model','paymentvouchers',array('users'=>'paymentvouchers.pvuid=users.uid','orders'=>'paymentvouchers.pvoid=orders.oid','items'=>'paymentvouchers.pviid=items.iid','itemmodels'=>'items.iimid=itemmodels.imid','itemtypes'=>'items.iitid=itemtypes.itid'),'itemtypes.itid IN ('.substr($this->loginuser->uitid,1,-1).')');
		
			$this->form_validation->set_rules('table_records[]', 'PV_Records' , 'trim|required');
			$this->form_validation->set_rules('submit', 'Submit' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			}
			else
			{
			if(strpos($this->loginuser->privileges, ',pvedit,') !== false)
			{
				$items = $this->Admin_mo->rate('iid,iitid','items','');
				$stores = array(); foreach($items as $it) { $stores[$it->iid] = $it->iitid; }
				
				if(set_value('submit') == '1')
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$item[$i] = $this->Admin_mo->getrow('items', array('iid'=>$paymentvoucher[$i]->pviid));
						if($paymentvoucher[$i]->pvquantity <= $item[$i]->iquantity)
						{
							$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
							$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
							$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
							$this->Admin_mo->update('items', array('iquantity'=>(($item[$i]->iquantity)-($paymentvoucher[$i]->pvquantity))), array('iid'=>$paymentvoucher[$i]->pviid));
							$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى موافقة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
							
							$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid,'');
							$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid.' and  accept = '.set_value('submit'),'');
							if($joocount == $jooacount)
							{
								$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
								//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
								//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill[$i]->bid));
								//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
								//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
								if($order[$i]->accept != set_value('submit'))
								{
									$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
									$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى موافقة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
								}
							}
						}
						else
						{
							$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-danger fade in" style="text-align:center;"><strong>'.'الكمية غير متوفرة'.'</strong></div>';
						}
						}
					}
				}
				elseif(set_value('submit') == '0')
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
						$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
						$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
						$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى رفض','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
						
						$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid,'');
						$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid.' and  accept = '.set_value('submit'),'');
						if($joocount == $jooacount)
						{
							$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
							//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
							//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill[$i]->bid));
							//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
							//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
							if($order[$i]->accept != set_value('submit'))
							{
								$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
								$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى رفض','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
							}
						}
						}
					}
				}
				else
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
						$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
						$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
						
						$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
						//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
						//$this->Admin_mo->update('bills', array('accept'=>'3'), array('bid'=>$bill[$i]->bid));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
						$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
						if($order[$i]->accept != set_value('submit'))
						{
							$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
							$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
						}
						}
					}
				}
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
			}
			$this->load->view('calenderdate');
			$this->load->view('headers/paymentvouchersuser',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/paymentvouchersusers',$data);
			$this->load->view('footers/paymentvouchersuser');
			$this->load->view('notifys');
			$this->load->view('messages');
			//redirect('paymentvouchers/edit/'.$id, 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenostore';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function add()
	{
		if(strpos($this->loginuser->privileges, ',pvadd,') !== false)
		{
		if($this->loginuser->uitid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		//$data['sections'] = $this->Admin_mo->getwhere('sections',array('active'=>'1'));
		$data['itemtypes'] = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
		$data['itemmodels'] = $this->Admin_mo->getwhere('itemmodels',array('active'=>'1'));
		$data['items'] = $this->Admin_mo->getwhere('items',array('active'=>'1'));
		$this->load->view('headers/paymentvoucher-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/paymentvoucher-add',$data);
		$this->load->view('footers/paymentvoucher-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenostore';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function getmodels()
	{
		$data['admessage'] = '';
		$type = $_POST['val'];
		$data['itemmodels'] = $this->Admin_mo->getwhere('itemmodels',array('active'=>'1','imitid'=>$type));
		if(!empty($data['itemmodels']))
		{
			echo '<option value="">اختر</option>';
			foreach($data['itemmodels'] as $model)
			{
				echo '<option value="'.$model->imid.'">'.$model->imname.'</option>';
			}
		}
		else echo 0;
	}
	
	public function getitems()
	{
		$data['admessage'] = '';
		$model = $_POST['val'];
		$data['items'] = $this->Admin_mo->getwhere('items',array('active'=>'1','iimid'=>$model));
		if(!empty($data['items']))
		{
			echo '<option value="">اختر</option>';
			foreach($data['items'] as $item)
			{
				echo '<option value="'.$item->iid.'" quantity="'.$item->iquantity.'">'.$item->iname.'</option>';
			}
		}
		else echo 0;
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',pvadd,') !== false)
		{
		$this->form_validation->set_rules('type', 'Type' , 'trim|required');
		$this->form_validation->set_rules('model', 'Model' , 'trim|required');
		$this->form_validation->set_rules('item', 'Item' , 'trim|required');
		$this->form_validation->set_rules('quantity', 'Quantity' , 'trim|required|max_length[255]|integer');
		if($this->form_validation->run() == FALSE)
		{
			$data['admessage'] = 'validation error';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
		}
		else
		{
			$data['pvid'] = $this->Admin_mo->set('paymentvouchers', array('pvuid'=>$this->session->userdata('uid'), 'pviid'=>set_value('item'), 'pvquantity'=>set_value('quantity'), 'pvtime'=>time()));
			if(empty($data['pvid']))	{ $data['admessage'] = 'Not Saved'; $_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong'; }
			else { $data['admessage'] = 'Successfully Saved'; $_SESSION['time'] = time(); $_SESSION['message'] = 'success'; }
		}
		
		redirect('paymentvouchers', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',pvedit,') !== false)
		{
		if($this->loginuser->uitid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('paymentvouchers', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['paymentvouchers'] = $this->Admin_mo->getjoinLeft('paymentvouchers.*,items.iname as item,items.iquantity as iquantity,items.iimid as modelid,itemmodels.imitid as typeid,itemmodels.imname as model,itemtypes.itname as type','paymentvouchers',array('items'=>'paymentvouchers.pviid=items.iid', 'itemmodels'=>'items.iimid=itemmodels.imid', 'itemtypes'=>'itemmodels.imitid=itemtypes.itid'),array('paymentvouchers.pvid'=>$id,'paymentvouchers.accept'=>'3'));
		$data['paymentvoucher'] = $data['paymentvouchers'][0];
		$data['itemtypes'] = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
		$data['itemmodels'] = $this->Admin_mo->getwhere('itemmodels',array('active'=>'1','imitid'=>$data['paymentvoucher']->typeid));
		$data['items'] = $this->Admin_mo->getwhere('items',array('active'=>'1','iimid'=>$data['paymentvoucher']->modelid));
		//$data['paymentvoucher'] = $this->Admin_mo->getrow('items',array('pvid'=>$id));
		//if(!empty($data['paymentvoucher'])) $data['itemmodels'] = $this->Admin_mo->getwhere('itemmodels',array('active'=>'1','imitid'=>$data['item']->iitid));
		$this->load->view('headers/paymentvoucher-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/paymentvoucher-edit',$data);
		$this->load->view('footers/paymentvoucher-edit');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenostore';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function editpaymentvoucher($id)
	{
		if(strpos($this->loginuser->privileges, ',pvedit,') !== false)
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_rules('type', 'Type' , 'trim|required');
			$this->form_validation->set_rules('model', 'Model' , 'trim|required');
			$this->form_validation->set_rules('item', 'Item' , 'trim|required');
			$this->form_validation->set_rules('quantity', 'Quantity' , 'trim|required|max_length[255]|integer');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			}
			else
			{
				$update_array = array('pvuid'=>$this->session->userdata('uid'), 'pviid'=>set_value('item'), 'pvquantity'=>set_value('quantity'), 'pvtime'=>time());
				$this->Admin_mo->update('paymentvouchers', $update_array, array('pvid'=>$id,'accept'=>'3'));
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'invalidinput';
		}
		
		redirect('paymentvouchers', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function item($id)
	{
		if(strpos($this->loginuser->privileges, ',pvsee,') !== false)
		{
		if($this->loginuser->uitid != '')
		{
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$data['admessage'] = '';
			$data['admessagearr'] = array();
			$this->lang->load('paymentvouchers', 'arabic');
			$id = abs((int)($id));
			$data['id'] = $id;
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['item'] = $this->Admin_mo->getrow('items',array('iid'=>$id));
			if(!empty($data['item']) && strpos($this->loginuser->uitid,','.$data['item']->iitid.',') !== false)
			{
			$data['paymentvouchers'] = $this->Admin_mo->getjoinLeft('paymentvouchers.*,users.username as user,orders.endtime as endtime','paymentvouchers',array('users'=>'paymentvouchers.pvuid=users.uid','orders'=>'paymentvouchers.pvoid=orders.oid'),'paymentvouchers.pviid = '.$id);
			//$data['item'] = $this->Admin_mo->getrow('items',array('iid'=>$id));
		
			$this->form_validation->set_rules('table_records[]', 'PV_Records' , 'trim|required');
			$this->form_validation->set_rules('submit', 'Submit' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			}
			else
			{
			if(strpos($this->loginuser->privileges, ',pvedit,') !== false)
			{
				$items = $this->Admin_mo->rate('iid,iitid','items','');
				$stores = array(); foreach($items as $it) { $stores[$it->iid] = $it->iitid; }
				
				if(set_value('submit') == '1')
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$item[$i] = $this->Admin_mo->getrow('items', array('iid'=>$paymentvoucher[$i]->pviid));
						if($paymentvoucher[$i]->pvquantity <= $item[$i]->iquantity)
						{
							$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
							$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
							$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
							$this->Admin_mo->update('items', array('iquantity'=>(($item[$i]->iquantity)-($paymentvoucher[$i]->pvquantity))), array('iid'=>$paymentvoucher[$i]->pviid));
							$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى موافقة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
							
							$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid,'');
							$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid.' and  accept = '.set_value('submit'),'');
							if($joocount == $jooacount)
							{
								$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
								//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
								//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill[$i]->bid));
								//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
								//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
								if($order[$i]->accept != set_value('submit'))
								{
									$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
									$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى موافقة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
								}
							}
						}
						else
						{
							$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-danger fade in" style="text-align:center;"><strong>'.'الكمية غير متوفرة'.'</strong></div>';
						}
						}
					}
				}
				elseif(set_value('submit') == '0')
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
						$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
						$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
						$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى رفض','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
						
						$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid,'');
						$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid.' and  accept = '.set_value('submit'),'');
						if($joocount == $jooacount)
						{
							$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
							//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
							//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill[$i]->bid));
							//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
							//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
							if($order[$i]->accept != set_value('submit'))
							{
								$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
								$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى رفض','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
							}
						}
						}
					}
				}
				else
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
						$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
						$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
						
						$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
						//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
						//$this->Admin_mo->update('bills', array('accept'=>'3'), array('bid'=>$bill[$i]->bid));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
						$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
						if($order[$i]->accept != set_value('submit'))
						{
							$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
							$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
						}
						}
					}
				}
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
			}
			$this->load->view('calenderdate');
			$this->load->view('headers/paymentvouchersitem',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/paymentvouchersitem',$data);
			$this->load->view('footers/paymentvouchersitem');
			$this->load->view('notifys');
			$this->load->view('messages');
			//redirect('paymentvouchers/edit/'.$id, 'refresh');
			}
			else
			{
			$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$data['title'] = 'paymentvouchers';
			$data['admessage'] = 'youhavenothisstore';
			$this->lang->load('paymentvouchers', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$this->load->view('headers/paymentvouchers',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/paymentvouchers');
			$this->load->view('notifys');
			$this->load->view('messages');
			}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenostore';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function user($id)
	{
		if(strpos($this->loginuser->privileges, ',pvsee,') !== false)
		{
		if($this->loginuser->uitid != '')
		{
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$data['admessage'] = '';
			$data['admessagearr'] = array();
			$this->lang->load('paymentvouchers', 'arabic');
			$id = abs((int)($id));
			$data['id'] = $id;
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['user'] = $this->Admin_mo->getrow('users',array('uid'=>$id));
			//if(!empty($data['user']))
			if(!empty($data['user']))
			{
			$data['paymentvouchers'] = $this->Admin_mo->getjoinLeft('paymentvouchers.*,orders.endtime as endtime,items.iname as item,itemtypes.itname as type,itemmodels.imname as model','paymentvouchers',array('orders'=>'paymentvouchers.pvoid=orders.oid','items'=>'paymentvouchers.pviid=items.iid','itemmodels'=>'items.iimid=itemmodels.imid','itemtypes'=>'items.iitid=itemtypes.itid'),'items.iitid IN ('.substr($this->loginuser->uitid,1,-1).') and paymentvouchers.pvuid = '.$data['user']->uid);
			//$data['user'] = $this->Admin_mo->getrow('users',array('uid'=>$id));
		
			$this->form_validation->set_rules('table_records[]', 'PV_Records' , 'trim|required');
			$this->form_validation->set_rules('submit', 'Submit' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			}
			else
			{
			if(strpos($this->loginuser->privileges, ',pvedit,') !== false)
			{
				$items = $this->Admin_mo->rate('iid,iitid','items','');
				$stores = array(); foreach($items as $it) { $stores[$it->iid] = $it->iitid; }

				if(set_value('submit') == '1')
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$item[$i] = $this->Admin_mo->getrow('items', array('iid'=>$paymentvoucher[$i]->pviid));
						if($paymentvoucher[$i]->pvquantity <= $item[$i]->iquantity)
						{
							$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
							$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
							$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
							$this->Admin_mo->update('items', array('iquantity'=>(($item[$i]->iquantity)-($paymentvoucher[$i]->pvquantity))), array('iid'=>$paymentvoucher[$i]->pviid));
							$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى موافقة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
							
							$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid,'');
							$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid.' and  accept = '.set_value('submit'),'');
							if($joocount == $jooacount)
							{
								$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
								//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
								//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill[$i]->bid));
								//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
								//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
								if($order[$i]->accept != set_value('submit'))
								{
									$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
									$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى موافقة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
								}
							}
						}
						else
						{
							$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-danger fade in" style="text-align:center;"><strong>'.'الكمية غير متوفرة'.'</strong></div>';
						}
						}
					}
				}
				elseif(set_value('submit') == '0')
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
						$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
						$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
						$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى رفض','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');

						$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid,'');
						$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid.' and  accept = '.set_value('submit'),'');
						if($joocount == $jooacount)
						{
							$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
							//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
							//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill[$i]->bid));
							//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
							//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
							if($order[$i]->accept != set_value('submit'))
							{
								$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
								$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى رفض','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
							}
						}
						}
					}
				}
				else
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
						$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
						$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
						
						$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
						//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
						//$this->Admin_mo->update('bills', array('accept'=>'3'), array('bid'=>$bill[$i]->bid));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
						$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
						if($order[$i]->accept != set_value('submit'))
						{
							$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
							$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
						}
						}
					}
				}
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
			}
			$this->load->view('calenderdate');
			$this->load->view('headers/paymentvouchersuser',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/paymentvouchersuser',$data);
			$this->load->view('footers/paymentvouchersuser');
			$this->load->view('notifys');
			$this->load->view('messages');
			//redirect('paymentvouchers/edit/'.$id, 'refresh');
			}
			else
			{
			$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$data['title'] = 'paymentvouchers';
			$data['admessage'] = 'youhavenoprivls';
			$this->lang->load('paymentvouchers', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$this->load->view('headers/paymentvouchers',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/paymentvouchers');
			$this->load->view('notifys');
			$this->load->view('messages');
			}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenostore';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function date($id)
	{
		if(strpos($this->loginuser->privileges, ',pvsee,') !== false)
		{
		if($this->loginuser->uitid != '')
		{
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$data['admessage'] = '';
			$data['admessagearr'] = array();
			$this->lang->load('paymentvouchers', 'arabic');
			//$id = abs((int)($id));
			$data['id'] = $id;
			$id = strtotime($id);
			$id1 = $id+(60*60*24);
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['paymentvouchers'] = $this->Admin_mo->getjoinLeft('paymentvouchers.*,users.username as user,orders.endtime as endtime,items.iname as item,itemtypes.itname as type,itemmodels.imname as model','paymentvouchers',array('users'=>'paymentvouchers.pvuid=users.uid','orders'=>'paymentvouchers.pvoid=orders.oid','items'=>'paymentvouchers.pviid=items.iid','itemmodels'=>'items.iimid=itemmodels.imid','itemtypes'=>'items.iitid=itemtypes.itid'),'itemtypes.itid IN ('.substr($this->loginuser->uitid,1,-1).') and paymentvouchers.pvtime > '.$id.' and paymentvouchers.pvtime < '.$id1);
		
			$this->form_validation->set_rules('table_records[]', 'PV_Records' , 'trim|required');
			$this->form_validation->set_rules('submit', 'Submit' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			}
			else
			{
			if(strpos($this->loginuser->privileges, ',pvedit,') !== false)
			{
				$items = $this->Admin_mo->rate('iid,iitid','items','');
				$stores = array(); foreach($items as $it) { $stores[$it->iid] = $it->iitid; }
				
				if(set_value('submit') == '1')
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$item[$i] = $this->Admin_mo->getrow('items', array('iid'=>$paymentvoucher[$i]->pviid));
						if($paymentvoucher[$i]->pvquantity <= $item[$i]->iquantity)
						{
							$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
							$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
							$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
							$this->Admin_mo->update('items', array('iquantity'=>(($item[$i]->iquantity)-($paymentvoucher[$i]->pvquantity))), array('iid'=>$paymentvoucher[$i]->pviid));
							$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى موافقة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
							
							$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid,'');
							$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid.' and  accept = '.set_value('submit'),'');
							if($joocount == $jooacount)
							{
								$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
								//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
								//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill[$i]->bid));
								//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
								//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
								if($order[$i]->accept != set_value('submit'))
								{
									$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
									$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى موافقة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
								}
							}
						}
						else
						{
							$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-danger fade in" style="text-align:center;"><strong>'.'الكمية غير متوفرة'.'</strong></div>';
						}
						}
					}
				}
				elseif(set_value('submit') == '0')
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
						$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
						$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
						$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى رفض','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
						
						$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid,'');
						$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid.' and  accept = '.set_value('submit'),'');
						if($joocount == $jooacount)
						{
							$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
							//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
							//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill[$i]->bid));
							//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
							//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
							if($order[$i]->accept != set_value('submit'))
							{
								$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
								$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى رفض','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
							}
						}
						}
					}
				}
				else
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
						$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
						$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
						
						$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
						//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
						//$this->Admin_mo->update('bills', array('accept'=>'3'), array('bid'=>$bill[$i]->bid));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
						$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
						if($order[$i]->accept != set_value('submit'))
						{
							$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
							$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
						}
						}
					}
				}
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
			}
			$this->load->view('calenderdate');
			$this->load->view('headers/paymentvouchersdate',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/paymentvouchersdate',$data);
			$this->load->view('footers/paymentvouchersdate');
			$this->load->view('notifys');
			$this->load->view('messages');
			//redirect('paymentvouchers/edit/'.$id, 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenostore';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function status()
	{
		if(strpos($this->loginuser->privileges, ',pvsee,') !== false)
		{
		if($this->loginuser->uitid != '')
		{
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$data['admessage'] = '';
			$data['admessagearr'] = array();
			$this->lang->load('paymentvouchers', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['paymentvouchers'] = $this->Admin_mo->getjoinLeft('paymentvouchers.*,users.username as user,orders.endtime as endtime,items.iname as item,itemtypes.itname as type,itemmodels.imname as model','paymentvouchers',array('users'=>'paymentvouchers.pvuid=users.uid','orders'=>'paymentvouchers.pvoid=orders.oid','items'=>'paymentvouchers.pviid=items.iid','itemmodels'=>'items.iimid=itemmodels.imid','itemtypes'=>'items.iitid=itemtypes.itid'),'items.iitid IN ('.substr($this->loginuser->uitid,1,-1).')');
			
			$this->form_validation->set_rules('table_records[]', 'PV_Records' , 'trim|required');
			$this->form_validation->set_rules('submit', 'Submit' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			}
			else
			{
			if(strpos($this->loginuser->privileges, ',pvedit,') !== false)
			{
				$items = $this->Admin_mo->rate('iid,iitid','items','');
				$stores = array(); foreach($items as $it) { $stores[$it->iid] = $it->iitid; }

				if(set_value('submit') == '1')
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$item[$i] = $this->Admin_mo->getrow('items', array('iid'=>$paymentvoucher[$i]->pviid));
						if($paymentvoucher[$i]->pvquantity <= $item[$i]->iquantity)
						{
							$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
							$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
							$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
							$this->Admin_mo->update('items', array('iquantity'=>(($item[$i]->iquantity)-($paymentvoucher[$i]->pvquantity))), array('iid'=>$paymentvoucher[$i]->pviid));
							$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى موافقة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
							
							$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid,'');
							$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid.' and  accept = '.set_value('submit'),'');
							if($joocount == $jooacount)
							{
								$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
								//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
								//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill[$i]->bid));
								//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
								//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
								if($order[$i]->accept != set_value('submit'))
								{
									$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
									$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى موافقة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
								}
							}
						}
						else
						{
							$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-danger fade in" style="text-align:center;"><strong>'.'الكمية غير متوفرة'.'</strong></div>';
						}
						}
					}
				}
				elseif(set_value('submit') == '0')
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
						$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
						$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
						$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى رفض','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
						
						$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid,'');
						$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$paymentvoucher[$i]->pvoid.' and  accept = '.set_value('submit'),'');
						if($joocount == $jooacount)
						{
							$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
							//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
							//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill[$i]->bid));
							//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
							//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
							if($order[$i]->accept != set_value('submit'))
							{
								$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
								$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى رفض','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
							}
						}
						}
					}
				}
				else
				{
					for($i=0;$i<count(set_value('table_records'));$i++)
					{
						$paymentvoucher[$i] = $this->Admin_mo->getrow('paymentvouchers', array('pvid'=>set_value('table_records')[$i]));
						if($paymentvoucher[$i]->accept == set_value('submit')) { $data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-warning fade in" style="text-align:center;"><strong>'.'نفس الحالة السابقة'.'</strong></div>'; }
						else
						{
						$data['admessagearr'][set_value('table_records')[$i]] = '<div class="alert-success fade in" style="text-align:center;"><strong>'.'تم بنجاح'.'</strong></div>';
						$this->Admin_mo->update('paymentvouchers', array('accept'=>set_value('submit'),'pvuid'=>$this->session->userdata('uid'),'pvtime'=>time()), array('pvid'=>set_value('table_records')[$i]));
						$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'),'joeid'=>$this->session->userdata('uid'),'accept'=>set_value('submit')), array('joid'=>$paymentvoucher[$i]->pvjoid));
						
						$order[$i] = $this->Admin_mo->getrow('orders', array('oid'=>$paymentvoucher[$i]->pvoid));
						//$bill[$i] = $this->Admin_mo->getrow('bills', array('boid'=>$paymentvoucher[$i]->pvoid));
						//$this->Admin_mo->update('bills', array('accept'=>'3'), array('bid'=>$bill[$i]->bid));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill[$i]->bid, 'time'=>time()));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid, 'time'=>time()));
						$this->notifications->addNotify($this->session->userdata('uid'),'PV'.$stores[$paymentvoucher[$i]->pviid],' تغيير حالة سند صرف رقم '.set_value('table_records')[$i].' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[$paymentvoucher[$i]->pviid].',%"');
						if($order[$i]->accept != set_value('submit'))
						{
							$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$paymentvoucher[$i]->pvoid));
							$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$order[$i]->obcid,' تغيير حالة الطلب رقم '.$paymentvoucher[$i]->pvoid.' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$order[$i]->obcid.',%"');
						}
						}
					}
				}
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
			}
			$this->load->view('calenderdate');
			$this->load->view('headers/paymentvouchersstatus',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/paymentvouchersstatus',$data);
			$this->load->view('footers/paymentvouchersstatus');
			$this->load->view('notifys');
			$this->load->view('messages');
			//redirect('paymentvouchers/edit/'.$id, 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenostore';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'paymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('paymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/paymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/paymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function read()
	{
		$this->Admin_mo->updateM1('logsystem',array('seen'=>'1'),'notifyuser = '.$this->session->userdata('uid').' and section like "PV%"');
	}
}