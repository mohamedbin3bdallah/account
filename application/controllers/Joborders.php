<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Joborders extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',joorder,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$users = $this->Admin_mo->getwhere('users',array());
		foreach($users as $user) { $data['users'][$user->uid] = $user->username; }
		$data['preporders'] = $this->Admin_mo->getjoinLeft('joborders.*,orders.oid as oid,orders.ocode as ocode,orders.endtime as endtime,orders.otime as otime,items.iname as item','joborders',array('orders'=>'orders.oid = joborders.jooid','items'=>'items.iid = joborders.joiid'),'orders.obcid IN ('.substr($this->loginuser->ubcid,1,-1).') and joborders.joiid = "0"');
		if(!empty($data['preporders']))
		{
			for($i=0;$i<count($data['preporders']);$i++)
			{
				//$data['orders'][$data['preporders'][$i]->oid] = new stdClass();
				$data['orders'][$data['preporders'][$i]->joid]['joid'] = $data['preporders'][$i]->joid;
				$data['orders'][$data['preporders'][$i]->joid]['follower'] = $data['preporders'][$i]->jouid;
				$data['orders'][$data['preporders'][$i]->joid]['employee'] = $data['preporders'][$i]->joeid;
				$data['orders'][$data['preporders'][$i]->joid]['oid'] = $data['preporders'][$i]->oid;
				$data['orders'][$data['preporders'][$i]->joid]['endtime'] = $data['preporders'][$i]->endtime;
				$data['orders'][$data['preporders'][$i]->joid]['ocode'] = $data['preporders'][$i]->ocode;
				$data['orders'][$data['preporders'][$i]->joid]['time'] = $data['preporders'][$i]->jotime;
				$data['orders'][$data['preporders'][$i]->joid]['notes'] = $data['preporders'][$i]->notes;
				$data['orders'][$data['preporders'][$i]->joid]['accept'] = $data['preporders'][$i]->accept;
				$data['orders'][$data['preporders'][$i]->joid]['item'] = $data['preporders'][$i]->item;
				$data['orders'][$data['preporders'][$i]->joid]['joitem'] = $data['preporders'][$i]->joitem;
				$data['orders'][$data['preporders'][$i]->joid]['price'] = $data['preporders'][$i]->joprice;
				$data['orders'][$data['preporders'][$i]->joid]['quantity'] = $data['preporders'][$i]->joquantity;
			}
		}
		$this->load->view('calenderdate');
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/joborders',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function user()
	{
		if(strpos($this->loginuser->privileges, ',josee,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$users = $this->Admin_mo->getwhere('users',array());
		foreach($users as $user) { $data['users'][$user->uid] = $user->username; }
		
		if($this->loginuser->uutid == '1') $data['preporders'] = $this->Admin_mo->rate('joborders.*,orders.oid as oid,orders.ocode as ocode,orders.endtime as endtime,items.iname as item','joborders',' LEFT OUTER JOIN orders on orders.oid = joborders.jooid LEFT OUTER JOIN items on items.iid = joborders.joiid where orders.obcid IN ('.substr($this->loginuser->ubcid,1,-1).') and joborders.joiid = 0');
		else $data['preporders'] = $this->Admin_mo->rate('joborders.*,orders.oid as oid,orders.ocode as ocode,orders.endtime as endtime,items.iname as item','joborders',' LEFT OUTER JOIN orders on orders.oid = joborders.jooid LEFT OUTER JOIN items on items.iid = joborders.joiid where (joborders.joeid = '.$this->session->userdata('uid').' or joborders.jouid = '.$this->session->userdata('uid').') and joborders.joiid = 0');

		if(!empty($data['preporders']))
		{
			for($i=0;$i<count($data['preporders']);$i++)
			{
				//$data['orders'][$data['preporders'][$i]->oid] = new stdClass();
				$data['orders'][$data['preporders'][$i]->joid]['joid'] = $data['preporders'][$i]->joid;
				$data['orders'][$data['preporders'][$i]->joid]['oid'] = $data['preporders'][$i]->oid;
				$data['orders'][$data['preporders'][$i]->joid]['follower'] = $data['preporders'][$i]->jouid;
				$data['orders'][$data['preporders'][$i]->joid]['employee'] = $data['preporders'][$i]->joeid;
				$data['orders'][$data['preporders'][$i]->joid]['ocode'] = $data['preporders'][$i]->ocode;
				$data['orders'][$data['preporders'][$i]->joid]['endtime'] = $data['preporders'][$i]->endtime;
				$data['orders'][$data['preporders'][$i]->joid]['time'] = $data['preporders'][$i]->jotime;
				$data['orders'][$data['preporders'][$i]->joid]['notes'] = $data['preporders'][$i]->notes;
				$data['orders'][$data['preporders'][$i]->joid]['accept'] = $data['preporders'][$i]->accept;
				$data['orders'][$data['preporders'][$i]->joid]['item'] = $data['preporders'][$i]->item;
				$data['orders'][$data['preporders'][$i]->joid]['joitem'] = $data['preporders'][$i]->joitem;
				$data['orders'][$data['preporders'][$i]->joid]['price'] = $data['preporders'][$i]->joprice;
				$data['orders'][$data['preporders'][$i]->joid]['quantity'] = $data['preporders'][$i]->joquantity;
			}
		}
		$this->load->view('calenderdate');
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/jobordersuser',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function pdf($id)
	{
		if(strpos($this->loginuser->privileges, ',josee,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$id = abs((int)($id));
		$data['joid'] = $this->Admin_mo->getrow('joborders',array('joid'=>$id));
		if(!empty($data['joid']))
		{
			redirect('../fanarab_pdfs/joborder_pdf/'.$id, 'refresh');
		}
		else redirect('joborders/user', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function records($id)
	{
		if(strpos($this->loginuser->privileges, ',joedit,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
			$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$id = abs((int)($id));
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			
			if($this->loginuser->uutid == '1') $data['joborder'] = $this->Admin_mo->rate('joborders.*,orders.obcid as branch,orders.endtime as endtime','joborders','inner join orders on joborders.jooid=orders.oid where joborders.joid = '.$id.' and orders.obcid IN ('.substr($this->loginuser->ubcid,1,-1).')');
			else $data['joborder'] = $this->Admin_mo->rate('joborders.*,orders.obcid as branch,orders.endtime as endtime','joborders','inner join orders on joborders.jooid=orders.oid where joborders.joid = '.$id.' and (joborders.joeid = '.$this->session->userdata('uid').' or joborders.jouid = '.$this->session->userdata('uid').')');
			if(!empty($data['joborder']))
			{
				$data['admessage'] = '';
				$data['admessagearr'] = array();
				$this->lang->load('joborders', 'arabic');
				$this->load->view('calenderdate');
				$data['id'] = $id;

				/*if(isset($POST['submit']))
				{
					unset($POST['submit']);*/
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
					$this->form_validation->set_rules('notes', 'الملاحظات' , 'trim|required');
					if($this->form_validation->run() == FALSE)
					{
						//$data['admessage'] = 'validationerror';
					}
					else
					{
						$data['jorid'] = $this->Admin_mo->set('jorecords', array('joruid'=>$this->session->userdata('uid'), 'jorjoid'=>$id, 'notes'=>set_value('notes'), 'jortime'=>time()));
						
						if($this->session->userdata('uid') == $data['joborder'][0]->jouid) $uid = 'uid = '.$data['joborder'][0]->joeid;
						elseif($this->session->userdata('uid') == $data['joborder'][0]->joeid) $uid = 'uid = '.$data['joborder'][0]->jouid;
						else $uid = 'uid IN ('.$data['joborder'][0]->jouid.','.$data['joborder'][0]->joeid.')';
						
						if(is_null($data['jorid'])) $data['admessage'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>لم يتم الحفظ</div>';
						else $data['admessage'] = '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>تم الجفظ</div>';
						//else { $data['admessage'] = 'saved'; $this->addNotify($this->session->userdata('uid'),'JO'.$data['joborder'][0]->branch,' اضاف ملاحظات على امر شغل رقم '.$id,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or '.$uid.') and ubcid like "%,'.$data['joborder'][0]->branch.',%"'); redirect('joborders/records/'.$id, 'refresh'); }
					}
				//}

				$data['records'] = $this->Admin_mo->getjoinLeft('jorecords.notes as notes,jorecords.jortime as time,users.username as user','jorecords',array('users'=>'users.uid=jorecords.joruid'),array('jorecords.jorjoid'=>$id));

				$this->load->view('headers/joborderrecords',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/joborderrecords',$data);
				$this->load->view('footers/joborderrecords');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
				$data['title'] = 'joborders';
				$data['admessage'] = 'youhavenoprivls';
				$this->lang->load('joborders', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$this->load->view('headers/joborders',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/messages',$data);
				$this->load->view('footers/joborders');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function done($id,$order)
	{
		if(strpos($this->loginuser->privileges, ',joedit,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
			$id = abs((int)($id));
			$order = abs((int)($order));
			$joborder = $this->Admin_mo->getrow('joborders', array('joid'=>$id));
			$myorder = $this->Admin_mo->getrow('orders', array('oid'=>$order));
			$this->form_validation->set_rules('submit', 'Submit' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
			}
			else
			{
				$this->load->library('notifications');
				if(set_value('submit') != '2')
				{
					$this->Admin_mo->update('joborders', array('accept'=>set_value('submit')), array('joid'=>$id));
					$joocount = $this->Admin_mo->exist('joborders','where jooid = '.$order,'');
					$jooacount = $this->Admin_mo->exist('joborders','where jooid = '.$order.' and  accept = '.set_value('submit'),'');
					if($joocount == $jooacount)
					{
						//$bill = $this->Admin_mo->getrow('bills', array('boid'=>$order));
						//$this->Admin_mo->update('bills', array('accept'=>set_value('submit')), array('bid'=>$bill->bid));
						$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$order));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill->bid, 'time'=>time()));
						//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$order, 'time'=>time()));
						$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$myorder->obcid,' غير حالة الطلب رقم '.$order,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$myorder->obcid.',%"');
					}
					//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة امر الشغل رقم '.$id, 'time'=>time()));
					$this->notifications->addNotify($this->session->userdata('uid'),'JO'.$myorder->obcid,' اغلق متابعة امر الشغل رقم '.$id,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or uid = '.$joborder->jouid.' or uid = '.$joborder->joeid.') and ubcid like "%,'.$myorder->obcid.',%"');
				}
				else
				{
					//$bill = $this->Admin_mo->getrow('bills', array('boid'=>$order));
					$this->Admin_mo->update('joborders', array('accept'=>set_value('submit')), array('joid'=>$id));
					//$this->Admin_mo->update('bills', array('accept'=>'3'), array('bid'=>$bill->bid));
					$this->Admin_mo->update('orders', array('accept'=>set_value('submit')), array('oid'=>$order));
					//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الفاتورة رقم '.$bill->bid, 'time'=>time()));
					//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة الطلب رقم '.$order, 'time'=>time()));
					//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' غير حالة امر الشغل رقم '.$id, 'time'=>time()));
					$this->notifications->addNotify($this->session->userdata('uid'),'OR'.$myorder->obcid,' غير حالة الطلب رقم '.$order.' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,osee,%" or privileges like "%,oadd,%") and ubcid like "%,'.$myorder->obcid.',%"');
					$this->notifications->addNotify($this->session->userdata('uid'),'JO'.$myorder->obcid,' غير حالة متابعة امر الشغل رقم '.$id.' الى متابعة','where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or uid = '.$joborder->jouid.' or uid = '.$joborder->joeid.') and ubcid like "%,'.$myorder->obcid.',%"');
					
				}
			}
			redirect('joborders/records/'.$id, 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',joorder,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$id = abs((int)($id));
		$data['joborder'] = $this->Admin_mo->getrow('joborders',array('joid'=>$id,'accept'=>'3'));
		if(!empty($data['joborder']))
		{
			$data['admessage'] = '';
			$this->lang->load('joborders', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$order = $this->Admin_mo->getrow('orders',array('oid'=>$data['joborder']->jooid));
			$data['items'] = $this->Admin_mo->getwhere('items',array('active'=>'1'));
			$data['users'] = $this->Admin_mo->getwhere('users',array('active'=>'1','uutid'=>$data['joborder']->joutid,'ubcid like '=>"%,".$order->obcid.",%"));
			$data['preorder'] = $this->Admin_mo->getjoinLeft('joborders.*,orders.oid as oid,orders.ocode as ocode,orders.notes as onotes,orders.otime as otime,items.iname as item','joborders',array('orders'=>'orders.oid = joborders.jooid','items'=>'items.iid = joborders.joiid'),array('joborders.joid'=>$id));
			if(!empty($data['preorder']))
			{
				for($i=0;$i<count($data['preorder']);$i++)
				{
					$data['order']['joid'] = $data['preorder'][$i]->joid;
					$data['order']['joeid'] = $data['preorder'][$i]->joeid;
					$data['order']['oid'] = $data['preorder'][$i]->oid;
					$data['order']['ocode'] = $data['preorder'][$i]->ocode;
					$data['order']['time'] = $data['preorder'][$i]->jotime;
					$data['order']['jonotes'] = $data['preorder'][$i]->notes;
					$data['order']['onotes'] = $data['preorder'][$i]->onotes;
					$data['order']['accept'] = $data['preorder'][$i]->accept;
					$data['order']['item'] = $data['preorder'][$i]->item;
					$data['order']['joitem'] = $data['preorder'][$i]->joitem;
					$data['order']['price'] = $data['preorder'][$i]->joprice;
					$data['order']['quantity'] = $data['preorder'][$i]->joquantity;
				}
			}
			$this->load->view('headers/joborder-edit',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/joborder-edit',$data);
			$this->load->view('footers/joborder-edit');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function editjoborder($id)
	{
		if(strpos($this->loginuser->privileges, ',joorder,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$id = abs((int)($id));
		$data['joborder'] = $this->Admin_mo->getrow('joborders', array('joid'=>$id));
		if(!empty($data['joborder']))
		{
			$order = $this->Admin_mo->getrow('orders', array('oid'=>$data['joborder']->jooid));
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('employee', 'الموظف الموجه اليه' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				//$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				$this->lang->load('joborders', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['items'] = $this->Admin_mo->getwhere('items',array('active'=>'1'));
				$data['users'] = $this->Admin_mo->getwhere('users',array('active'=>'1','uutid'=>$data['joborder']->joutid,'ubcid like '=>"%,".$order->obcid.",%"));
				$data['preorder'] = $this->Admin_mo->getjoinLeft('joborders.*,orders.oid as oid,orders.ocode as ocode,orders.notes as onotes,orders.otime as otime,items.iname as item','joborders',array('orders'=>'orders.oid = joborders.jooid','items'=>'items.iid = joborders.joiid'),array('joborders.joid'=>$id));
				for($i=0;$i<count($data['preorder']);$i++)
				{
					$data['order']['joid'] = $data['preorder'][$i]->joid;
					$data['order']['joeid'] = $data['preorder'][$i]->joeid;
					$data['order']['oid'] = $data['preorder'][$i]->oid;
					$data['order']['ocode'] = $data['preorder'][$i]->ocode;
					$data['order']['time'] = $data['preorder'][$i]->jotime;
					$data['order']['jonotes'] = $data['preorder'][$i]->notes;
					$data['order']['onotes'] = $data['preorder'][$i]->onotes;
					$data['order']['accept'] = $data['preorder'][$i]->accept;
					$data['order']['item'] = $data['preorder'][$i]->item;
					$data['order']['joitem'] = $data['preorder'][$i]->joitem;
					$data['order']['price'] = $data['preorder'][$i]->joprice;
					$data['order']['quantity'] = $data['preorder'][$i]->joquantity;
				}
				$this->load->view('headers/joborder-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/joborder-edit',$data);
				$this->load->view('footers/joborder-edit');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				$this->load->library('notifications');
				$employee = $this->Admin_mo->getrow('users', array('uid'=>set_value('employee')));
				$this->Admin_mo->update('joborders', array('jouid'=>$this->session->userdata('uid'), 'joeid'=>set_value('employee'), 'accept'=>'2', 'notes'=>set_value('notes'), 'jotime'=>time()),array('joid'=>$id));
				$this->notifications->addNotify($this->session->userdata('uid'),'JO'.$order->obcid,' اضاف الموظف '.$employee->username.' على متابعة امر شغل رقم  '.$id,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or uid = '.set_value('employee').' or uid = '.$this->session->userdata('uid').') and ubcid like "%,'.$order->obcid.',%"');
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('joborders', 'refresh');
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('joborders', 'refresh');
		}
		//redirect('joborders', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'joborders';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('joborders', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/joborders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/joborders');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function read()
	{
		$this->Admin_mo->updateM1('logsystem',array('seen'=>'1'),'notifyuser = '.$this->session->userdata('uid').' and section like "JO%"');
	}
}