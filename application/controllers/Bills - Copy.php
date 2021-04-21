<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bills extends CI_Controller {

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
	public function index()
	{
		if(strpos($this->session->userdata('privileges'), 'bsee') !== false)
		{
		if($this->session->userdata('branch') != '')
		{
		$data['admessage'] = '';
		$this->lang->load('bills', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data = $this->notifys();
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['preporders'] = $this->Admin_mo->getjoinLeft('bills.*,users.username as employee,customers.cname as customer,orders.oid as oid,orders.ocode as ocode,joborders.joitem as joitem,joborders.joprice as joprice,joborders.joquantity as joquantity,items.iname as item','bills',array('users'=>'bills.beid = users.uid','orders'=>'orders.oid = bills.boid','customers'=>'orders.ocid = customers.cid','joborders'=>'joborders.jooid = orders.oid','items'=>'items.iid = joborders.joiid'),'orders.obcid IN ('.substr($this->session->userdata('branch'),1,-1).')');
		if(!empty($data['preporders']))
		{
			for($i=0;$i<count($data['preporders']);$i++)
			{
				//$data['orders'][$data['preporders'][$i]->oid] = new stdClass();
				$data['orders'][$data['preporders'][$i]->bid]['bid'] = $data['preporders'][$i]->bid;
				$data['orders'][$data['preporders'][$i]->bid]['employee'] = $data['preporders'][$i]->employee;
				$data['orders'][$data['preporders'][$i]->bid]['customer'] = $data['preporders'][$i]->customer;
				$data['orders'][$data['preporders'][$i]->bid]['oid'] = $data['preporders'][$i]->oid;
				$data['orders'][$data['preporders'][$i]->bid]['code'] = $data['preporders'][$i]->bcode;
				$data['orders'][$data['preporders'][$i]->bid]['ocode'] = $data['preporders'][$i]->ocode;
				$data['orders'][$data['preporders'][$i]->bid]['btime'] = $data['preporders'][$i]->btime;
				$data['orders'][$data['preporders'][$i]->bid]['notes'] = $data['preporders'][$i]->notes;
				$data['orders'][$data['preporders'][$i]->bid]['total'] = $data['preporders'][$i]->btotal;
				$data['orders'][$data['preporders'][$i]->bid]['discount'] = $data['preporders'][$i]->bdiscount;
				$data['orders'][$data['preporders'][$i]->bid]['accept'] = $data['preporders'][$i]->accept;
				$data['orders'][$data['preporders'][$i]->bid]['items'][$i]['item'] = $data['preporders'][$i]->item;
				$data['orders'][$data['preporders'][$i]->bid]['items'][$i]['joitem'] = $data['preporders'][$i]->joitem;
				$data['orders'][$data['preporders'][$i]->bid]['items'][$i]['price'] = $data['preporders'][$i]->joprice;
				$data['orders'][$data['preporders'][$i]->bid]['items'][$i]['quantity'] = $data['preporders'][$i]->joquantity;
			}
		}
		
		$this->load->view('headers/bills',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/bills',$data);
		$this->load->view('footers/bills');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$data = $this->notifys();
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('bills', 'arabic');
		$this->lang->load('messages', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/bills',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/bills');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$data = $this->notifys();
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('bills', 'arabic');
		$this->lang->load('messages', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/bills',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/bills');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function pdf($id)
	{
		if(strpos($this->session->userdata('privileges'), 'bprint') !== false)
		{
		if($this->session->userdata('branch') != '')
		{
		$id = abs((int)($id));
		$data['bill'] = $this->Admin_mo->getrow('bills',array('bid'=>$id,'accept'=>'1'));
		if(!empty($data['bill']))
		{
			$data['admessage'] = '';
			$this->lang->load('bills', 'arabic');
			$this->lang->load('keys', 'arabic');
			$this->lang->load('menu', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['items'] = $this->Admin_mo->getwhere('items',array('active'=>'1'));
			//$data['users'] = $this->Admin_mo->getwhere('users',array('active'=>'1','uutid'=>'5'));
			$data['preorder'] = $this->Admin_mo->getjoinLeft('bills.*,users.uname as employee,users.uphone as phone,customers.cname as customer,customers.cphone as cphone,orders.oid as oid,orders.ocode as ocode,joborders.joitem as joitem,joborders.joprice as joprice,joborders.joquantity as joquantity,items.icode as icode,items.iname as item','bills',array('users'=>'bills.beid = users.uid','orders'=>'orders.oid = bills.boid','customers'=>'orders.ocid = customers.cid','joborders'=>'joborders.jooid = orders.oid','items'=>'items.iid = joborders.joiid'),'bills.bid = '.$id);
			if(!empty($data['preorder']))
			{
				for($i=0;$i<count($data['preorder']);$i++)
				{
					$data['order']['oid'] = $data['preorder'][$i]->oid;
					$data['order']['customer'] = $data['preorder'][$i]->customer;
					$data['order']['cphone'] = $data['preorder'][$i]->cphone;
					$data['order']['employee'] = $data['preorder'][$i]->employee;
					$data['order']['phone'] = $data['preorder'][$i]->phone;
					$data['order']['code'] = $data['preorder'][$i]->bcode;
					$data['order']['btime'] = $data['preorder'][$i]->btime;
					$data['order']['bnotes'] = $data['preorder'][$i]->notes;
					$data['order']['total'] = $data['preorder'][$i]->btotal;
					$data['order']['discount'] = $data['preorder'][$i]->bdiscount;
					$data['order']['pay'] = $data['preorder'][$i]->bpay;
					$data['order']['rest'] = $data['preorder'][$i]->brest;
					$data['order']['bpaytype'] = $data['preorder'][$i]->bpaytype;
					$data['order']['btype'] = $data['preorder'][$i]->btype;
					$data['order']['accept'] = $data['preorder'][$i]->accept;
					$data['order']['items'][$i]['icode'] = $data['preorder'][$i]->icode;
					$data['order']['items'][$i]['item'] = $data['preorder'][$i]->item;
					$data['order']['items'][$i]['joitem'] = $data['preorder'][$i]->joitem;
					$data['order']['items'][$i]['price'] = $data['preorder'][$i]->joprice;
					$data['order']['items'][$i]['quantity'] = $data['preorder'][$i]->joquantity;
				}
			}
			//$this->load->view('headers/bill-pdf',$data);
			//$this->load->view('sidemenu',$data);
			//$this->load->view('topmenu',$data);
			$this->load->view('admin/bill-pdf',$data);
			//$this->load->view('footers/bill-pdf');
			//$this->load->view('messages');
		}
		else redirect('bills', 'refresh');
		}
		else
		{
		$data = $this->notifys();
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('bills', 'arabic');
		$this->lang->load('messages', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/bills',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/bills');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$data = $this->notifys();
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('bills', 'arabic');
		$this->lang->load('messages', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/bills',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/bills');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function edit($id)
	{
		if(strpos($this->session->userdata('privileges'), 'bedit') !== false)
		{
		if($this->session->userdata('branch') != '')
		{
		$id = abs((int)($id));
		$data = $this->notifys();
		$data['bill'] = $this->Admin_mo->getrow('bills',array('bid'=>$id,'accept'=>'3'));
		if(!empty($data['bill']))
		{
			$data['admessage'] = '';
			$this->lang->load('bills', 'arabic');
			$this->lang->load('keys', 'arabic');
			$this->lang->load('menu', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['items'] = $this->Admin_mo->getwhere('items',array('active'=>'1'));
			//$data['users'] = $this->Admin_mo->getwhere('users',array('active'=>'1','uutid'=>'5'));
			$data['preorder'] = $this->Admin_mo->getjoinLeft('bills.*,customers.cname as customer,orders.oid as oid,orders.notes as onotes,orders.otime as otime,joborders.joitem as joitem,joborders.joprice as joprice,joborders.joquantity as joquantity,items.iname as item','bills',array('orders'=>'orders.oid = bills.boid','customers'=>'orders.ocid = customers.cid','joborders'=>'joborders.jooid = orders.oid','items'=>'items.iid = joborders.joiid'),array('bills.bid'=>$id));
			if(!empty($data['preorder']))
			{
				for($i=0;$i<count($data['preorder']);$i++)
				{
					$data['order']['bid'] = $data['preorder'][$i]->bid;
					$data['order']['customer'] = $data['preorder'][$i]->customer;
					$data['order']['oid'] = $data['preorder'][$i]->oid;
					$data['order']['code'] = $data['preorder'][$i]->bcode;
					$data['order']['btime'] = $data['preorder'][$i]->btime;
					$data['order']['bnotes'] = $data['preorder'][$i]->notes;
					$data['order']['total'] = $data['preorder'][$i]->btotal;
					$data['order']['discount'] = $data['preorder'][$i]->bdiscount;
					$data['order']['bpaytype'] = $data['preorder'][$i]->bpaytype;
					$data['order']['btype'] = $data['preorder'][$i]->btype;
					$data['order']['pay'] = $data['preorder'][$i]->bpay;
					$data['order']['rest'] = $data['preorder'][$i]->brest;
					$data['order']['onotes'] = $data['preorder'][$i]->onotes;
					$data['order']['accept'] = $data['preorder'][$i]->accept;
					$data['order']['items'][$i]['item'] = $data['preorder'][$i]->item;
					$data['order']['items'][$i]['joitem'] = $data['preorder'][$i]->joitem;
					$data['order']['items'][$i]['price'] = $data['preorder'][$i]->joprice;
					$data['order']['items'][$i]['quantity'] = $data['preorder'][$i]->joquantity;
				}
			}
			$this->load->view('headers/bill-edit',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/bill-edit',$data);
			$this->load->view('footers/bill-edit');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else redirect('bills', 'refresh');
		}
		else
		{
		$data = $this->notifys();
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('bills', 'arabic');
		$this->lang->load('messages', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/bills',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/bills');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$data = $this->notifys();
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('bills', 'arabic');
		$this->lang->load('messages', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/bills',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/bills');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function editbill($id,$order)
	{
		if(strpos($this->session->userdata('privileges'), 'bedit') !== false)
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_rules('type', 'Billtype' , 'trim|required');
			$this->form_validation->set_rules('paytype', 'Paytype' , 'trim|required');
			$this->form_validation->set_rules('discount', 'Discount' , 'trim|max_length[11]|decimal');
			$this->form_validation->set_rules('pay', 'Pay' , 'trim|required|max_length[11]|decimal');
			$this->form_validation->set_rules('rest', 'Rest' , 'trim|max_length[11]|decimal');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			}
			else
			{
				$bill = $this->Admin_mo->getrow('bills',array('bid'=>$id));
				$myorder = $this->Admin_mo->getrow('orders',array('oid'=>$order));
				$code = 'B'.$id.'C'.$myorder->ocid.'U'.$this->session->userdata('uid').'T'.number_format(($bill->btotal-set_value('discount')),2);
				$this->Admin_mo->update('bills', array('beid'=>$this->session->userdata('uid'), 'accept'=>'3', 'bdiscount'=>set_value('discount'), 'bpay'=>set_value('pay'), 'brest'=>set_value('rest'), 'bcode'=>$code, 'bpaytype'=>set_value('paytype'), 'btype'=>set_value('type'), 'notes'=>set_value('notes'), 'accept'=>'1', 'bdate'=>date('Y-m-d'), 'btime'=>time()),array('bid'=>$id));
				$this->addNotify($this->session->userdata('uid'),'BL'.$myorder->obcid,' قام بالتعديل غلى فاتورة رقم '.$order,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,bsee,%" or privileges like "%,bedit,%" or privileges like "%,bprint,%") and ubcid like "%,'.$myorder->obcid.',%"');
				//$this->Admin_mo->update('orders', array('accept'=>'2'),array('oid'=>$order));
				//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' قام بالتعديل على الفاتورة رقم  '.$id, 'time'=>time()));
				//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' قام بتغيير حالة الطلب رقم  '.$order, 'time'=>time()));
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
		}
		redirect('bills', 'refresh');
		}
		else redirect('home', 'refresh');
	}

	public function read()
	{
		$this->Admin_mo->updateM1('logsystem',array('seen'=>'1'),'notifyuser = '.$this->session->userdata('uid').' and section like "BL%"');
		//$this->Admin_mo->updateM('logsystem','seen = "1"','where notifyuser = '.$this->session->userdata('uid'));
	}
	
	public function addNotify($user,$section,$action,$where)
	{
		$nusers= $this->Admin_mo->rate('uid','users',$where);
		if(!empty($nusers))
		{
			foreach($nusers as $nuser)
			{
				$this->Admin_mo->set('logsystem', array('user'=>$user, 'notifyuser'=>$nuser->uid, 'section'=>$section, 'action'=>$action, 'time'=>time()));
			}
		}
	}
	
	public function getUnreadNotify($user,$section)
	{
		$result = $this->Admin_mo->getjoinLeftLimit('logsystem.*,users.username as user','logsystem',array('users'=>'logsystem.user=users.uid'),'notifyuser = '.$user.' and section like "'.$section.'"','logsystem.time DESC',15);
		if(!empty($result)) { $count = $this->Admin_mo->rate('count(id) as count','logsystem',' where notifyuser = '.$user.' and section like "'.$section.'" and seen = 0'); $result['count'] = $count[0]->count; }
		return $result;
	}
	
	public function notifys()
	{
		$arr = array();
		if($this->session->userdata('branch') != '')
		{
			$arr['unreadBLs'] = $this->getUnreadNotify($this->session->userdata('uid'),'BL%');
			$arr['unreadORs'] = $this->getUnreadNotify($this->session->userdata('uid'),'OR%');
			$arr['unreadJOs'] = $this->getUnreadNotify($this->session->userdata('uid'),'JO%');
		}
		if($this->session->userdata('store') != '')
		{
			$arr['unreadPVs'] = $this->getUnreadNotify($this->session->userdata('uid'),'PV%');
		}
		$arr['unreadNTs'] = $this->getUnreadNotify($this->session->userdata('uid'),'');
		return $arr;
	}
}