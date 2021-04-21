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
		if(strpos($this->loginuser->privileges, ',bsee,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$data['admessage'] = '';
		$this->lang->load('bills', 'arabic');
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['preporders'] = $this->Admin_mo->getjoinLeft('bills.*,users.username as employee,customers.cname as customer,orders.oid as oid,orders.ocode as ocode,joborders.joitem as joitem,joborders.joprice as joprice,joborders.joquantity as joquantity,joborders.addtobill as addtobill,items.iname as item','bills',array('users'=>'bills.beid = users.uid','orders'=>'orders.oid = bills.boid','customers'=>'orders.ocid = customers.cid','joborders'=>'joborders.jooid = orders.oid','items'=>'items.iid = joborders.joiid'),'orders.obcid IN ('.substr($this->loginuser->ubcid,1,-1).')');
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
				$data['orders'][$data['preporders'][$i]->bid]['newtotal'] = $data['preporders'][$i]->bnewtotal;
				$data['orders'][$data['preporders'][$i]->bid]['discount'] = $data['preporders'][$i]->bdiscount;
				$data['orders'][$data['preporders'][$i]->bid]['accept'] = $data['preporders'][$i]->accept;
				if($data['preporders'][$i]->addtobill == '1')
				{
					$data['orders'][$data['preporders'][$i]->bid]['items'][$i]['item'] = $data['preporders'][$i]->item;
					$data['orders'][$data['preporders'][$i]->bid]['items'][$i]['joitem'] = $data['preporders'][$i]->joitem;
					$data['orders'][$data['preporders'][$i]->bid]['items'][$i]['price'] = $data['preporders'][$i]->joprice;
					$data['orders'][$data['preporders'][$i]->bid]['items'][$i]['quantity'] = $data['preporders'][$i]->joquantity;
				}
			}
		}
		$this->load->view('calenderdate');
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
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('bills', 'arabic');
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
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('bills', 'arabic');
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
		if(strpos($this->loginuser->privileges, ',bprint,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$id = abs((int)($id));
		$data['bill'] = $this->Admin_mo->getrow('bills',array('bid'=>$id,'accept'=>'1'));
		if(!empty($data['bill']))
		{
			redirect('../fanarab_pdfs/bill_pdf/'.$id, 'refresh');
		}
		else redirect('bills', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('bills', 'arabic');
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
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('bills', 'arabic');
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
		if(strpos($this->loginuser->privileges, ',bedit,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['bill'] = $this->Admin_mo->getrow('bills',array('bid'=>$id,'accept'=>'3'));
		if(!empty($data['bill']))
		{
			$data['admessage'] = '';
			$this->lang->load('bills', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['items'] = $this->Admin_mo->getwhere('items',array('active'=>'1'));
			//$data['users'] = $this->Admin_mo->getwhere('users',array('active'=>'1','uutid'=>'5'));
			$data['preorder'] = $this->Admin_mo->getjoinLeft('bills.*,customers.cname as customer,orders.oid as oid,orders.ocode as ocode,orders.notes as onotes,orders.otime as otime,joborders.joitem as joitem,joborders.joprice as joprice,joborders.joquantity as joquantity,joborders.addtobill as addtobill,items.iname as item','bills',array('orders'=>'orders.oid = bills.boid','customers'=>'orders.ocid = customers.cid','joborders'=>'joborders.jooid = orders.oid','items'=>'items.iid = joborders.joiid'),array('bills.bid'=>$id));
			if(!empty($data['preorder']))
			{
				for($i=0;$i<count($data['preorder']);$i++)
				{
					$data['order']['bid'] = $data['preorder'][$i]->bid;
					$data['order']['customer'] = $data['preorder'][$i]->customer;
					$data['order']['oid'] = $data['preorder'][$i]->oid;
					$data['order']['code'] = $data['preorder'][$i]->ocode;
					$data['order']['btime'] = $data['preorder'][$i]->btime;
					$data['order']['bnotes'] = $data['preorder'][$i]->notes;
					$data['order']['total'] = $data['preorder'][$i]->btotal;
					$data['order']['newtotal'] = $data['preorder'][$i]->bnewtotal;
					$data['order']['discount'] = $data['preorder'][$i]->bdiscount;
					$data['order']['bpaytype'] = $data['preorder'][$i]->bpaytype;
					$data['order']['btype'] = $data['preorder'][$i]->btype;
					$data['order']['pay'] = $data['preorder'][$i]->bpay;
					$data['order']['rest'] = $data['preorder'][$i]->brest;
					$data['order']['onotes'] = $data['preorder'][$i]->onotes;
					$data['order']['accept'] = $data['preorder'][$i]->accept;
					if($data['preorder'][$i]->addtobill == '1')
					{
						$data['order']['items'][$i]['item'] = $data['preorder'][$i]->item;
						$data['order']['items'][$i]['joitem'] = $data['preorder'][$i]->joitem;
						$data['order']['items'][$i]['price'] = $data['preorder'][$i]->joprice;
						$data['order']['items'][$i]['quantity'] = $data['preorder'][$i]->joquantity;
					}
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
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('bills', 'arabic');
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
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('bills', 'arabic');
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
		if(strpos($this->loginuser->privileges, ',bedit,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$id = abs((int)($id));
		$bill = $this->Admin_mo->getrow('bills',array('bid'=>$id));
		if($id != '' && !empty($bill))
		{
			$myorder = $this->Admin_mo->getrow('orders',array('oid'=>$order));

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('type', 'نوع الفاتورة' , 'trim|required');
			$this->form_validation->set_rules('paytype', 'طريقة الدفع' , 'trim|required');
			$this->form_validation->set_rules('discount', 'الخصم' , 'trim|max_length[11]|decimal');
			$this->form_validation->set_rules('pay', 'المدفوع' , 'trim|required|max_length[11]|decimal');
			$this->form_validation->set_rules('rest', 'الباقي' , 'trim|max_length[11]|decimal');
			$this->form_validation->set_rules('total', 'لاجمالي غير صحيح' , number_format((set_value('newtotal')-set_value('discount')),2) == number_format((set_value('pay')-set_value('rest')),2));
			if($this->form_validation->run() == FALSE)
			{
				//$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				$this->lang->load('bills', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['items'] = $this->Admin_mo->getwhere('items',array('active'=>'1'));
				$data['preorder'] = $this->Admin_mo->getjoinLeft('bills.*,customers.cname as customer,orders.oid as oid,orders.ocode as ocode,orders.notes as onotes,orders.otime as otime,joborders.joitem as joitem,joborders.joprice as joprice,joborders.joquantity as joquantity,joborders.addtobill as addtobill,items.iname as item','bills',array('orders'=>'orders.oid = bills.boid','customers'=>'orders.ocid = customers.cid','joborders'=>'joborders.jooid = orders.oid','items'=>'items.iid = joborders.joiid'),array('bills.bid'=>$id));
				for($i=0;$i<count($data['preorder']);$i++)
				{
					$data['order']['bid'] = $data['preorder'][$i]->bid;
					$data['order']['customer'] = $data['preorder'][$i]->customer;
					$data['order']['oid'] = $data['preorder'][$i]->oid;
					$data['order']['code'] = $data['preorder'][$i]->ocode;
					$data['order']['btime'] = $data['preorder'][$i]->btime;
					$data['order']['bnotes'] = $data['preorder'][$i]->notes;
					$data['order']['total'] = $data['preorder'][$i]->btotal;
					$data['order']['newtotal'] = $data['preorder'][$i]->bnewtotal;
					$data['order']['discount'] = $data['preorder'][$i]->bdiscount;
					$data['order']['bpaytype'] = $data['preorder'][$i]->bpaytype;
					$data['order']['btype'] = $data['preorder'][$i]->btype;
					$data['order']['pay'] = $data['preorder'][$i]->bpay;
					$data['order']['rest'] = $data['preorder'][$i]->brest;
					$data['order']['onotes'] = $data['preorder'][$i]->onotes;
					$data['order']['accept'] = $data['preorder'][$i]->accept;
					if($data['preorder'][$i]->addtobill == '1')
					{
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
			else
			{
				$this->load->library('arabictools');
				$this->load->library('notifications');
				$code = 'B'.$id.'C'.$myorder->ocid.'U'.$this->session->userdata('uid').'T'.number_format(($bill->btotal-set_value('discount')),2);
				$this->Admin_mo->update('bills', array('beid'=>$this->session->userdata('uid'), 'accept'=>'3', 'bdiscount'=>set_value('discount'), 'bpay'=>set_value('pay'), 'brest'=>set_value('rest'), 'bcode'=>$code, 'bpaytype'=>set_value('paytype'), 'btype'=>set_value('type'), 'notes'=>set_value('notes'), 'accept'=>'1', 'bdate'=>date('Y-m-d'), 'bhdate'=>$this->arabictools->arabicDate('hj Y-m-d', time()), 'btime'=>time()),array('bid'=>$id));
				$this->Admin_mo->update('orders', array('billdone'=>'1'),array('oid'=>$order));
				$this->notifications->addNotify($this->session->userdata('uid'),'BL'.$myorder->obcid,' قام بالتعديل غلى فاتورة رقم '.$order,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,bsee,%" or privileges like "%,bedit,%" or privileges like "%,bprint,%") and ubcid like "%,'.$myorder->obcid.',%"');
				//$this->Admin_mo->update('orders', array('accept'=>'2'),array('oid'=>$order));
				//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' قام بالتعديل على الفاتورة رقم  '.$id, 'time'=>time()));
				//$this->Admin_mo->set('logsystem', array('user'=>$this->session->userdata('uid'), 'action'=>' قام بتغيير حالة الطلب رقم  '.$order, 'time'=>time()));
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('bills', 'refresh');
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('bills', 'refresh');
		}
		//redirect('bills', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'bills';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('bills', 'arabic');
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

	public function read()
	{
		$this->Admin_mo->updateM1('logsystem',array('seen'=>'1'),'notifyuser = '.$this->session->userdata('uid').' and section like "BL%"');
		//$this->Admin_mo->updateM('logsystem','seen = "1"','where notifyuser = '.$this->session->userdata('uid'));
	}
}