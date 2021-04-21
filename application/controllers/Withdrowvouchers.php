<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withdrowvouchers extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',wvsee,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['withdrowvouchers'] = $this->Admin_mo->getjoinLeft('withdrowvouchers.*,bills.btotal as btotal,bills.bnewtotal as bnewtotal,orders.ocode as ocode,customers.cname as customer','withdrowvouchers',array('bills'=>'withdrowvouchers.wvoid = bills.boid','orders'=>'bills.boid = orders.oid','customers'=>'orders.ocid = customers.cid'),'orders.obcid IN ('.substr($this->loginuser->ubcid,1,-1).')');
		$this->load->view('calenderdate');
		$this->load->view('headers/withdrowvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/withdrowvouchers',$data);
		$this->load->view('footers/withdrowvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'withdrowvouchers';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/withdrowvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/withdrowvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'withdrowvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/withdrowvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/withdrowvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function add()
	{
		if(strpos($this->loginuser->privileges, ',wvadd,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['bills'] = $this->Admin_mo->getjoinLeft('bills.bid as bid,bills.boid as boid,bills.btotal as btotal,bills.bnewtotal as bnewtotal,orders.ocode as ocode,customers.cname as customer','bills',array('orders'=>'bills.boid = orders.oid','customers'=>'orders.ocid = customers.cid'),'orders.obcid IN ('.substr($this->loginuser->ubcid,1,-1).') and bills.bnewtotal > 0 and bills.accept <> "1"');
		$this->load->view('headers/withdrowvoucher-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/withdrowvoucher-add',$data);
		$this->load->view('footers/withdrowvoucher-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'withdrowvouchers';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/withdrowvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/withdrowvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'withdrowvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/withdrowvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/withdrowvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function create()
	{
		if(strpos($this->loginuser->privileges, ',wvadd,') !== false)
		{
		//$this->form_validation->set_rules('bill', 'Bill' , 'trim|required');
		$this->form_validation->set_rules('order', 'Order' , 'trim|required');
		$this->form_validation->set_rules('payment', 'Payment' , 'trim|required');
		$this->form_validation->set_rules('newtotal', 'New Total' , 'trim|required');
		if($this->form_validation->run() == FALSE)
		{
			$data['admessage'] = 'validation error';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			redirect('withdrowvouchers', 'refresh');
		}
		else
		{
			if(set_value('payment') <= set_value('newtotal'))
			{
			$data['wvid'] = $this->Admin_mo->set('withdrowvouchers', array('wvuid'=>$this->session->userdata('uid'), 'wvoid'=>set_value('order'), 'wvtotal'=>number_format(set_value('payment'),2), 'notes'=>set_value('notes'), 'wvtime'=>time()));
			if(empty($data['wvid']))
			{
				$data['admessage'] = 'Not Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				redirect('withdrowvouchers', 'refresh');
			}
			else
			{
				$this->load->library('notifications');
				$order = $this->Admin_mo->getrow('orders', array('oid'=>set_value('order')));
				$this->Admin_mo->update('bills', array('bnewtotal'=>number_format((set_value('newtotal')-set_value('payment')),2)), array('boid'=>set_value('order')));
				$this->Admin_mo->update('orders', array('wvdone'=>'1'), array('oid'=>set_value('order')));
				$this->notifications->addNotify($this->session->userdata('uid'),'BL'.$order->obcid,' قام باضافة سند قبض رقم '.$data['wvid'].' على فاتورة رقم '.set_value('order'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,wvsee,%" or privileges like "%,wvadd,%") and ubcid like "%,'.$order->obcid.',%"');
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('../fanarab_pdfs/withdrowvoucher_pdf/'.$data['wvid'], 'refresh');
			}
			}
			else { $_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong'; redirect('withdrowvouchers', 'refresh'); }
		}
		//redirect('withdrowvouchers', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'withdrowvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/withdrowvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/withdrowvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',wvedit,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('withdrowvouchers', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['bills'] = $this->Admin_mo->getjoinLeft('bills.bid as bid,bills.boid as boid,bills.btotal as btotal,bills.bnewtotal as bnewtotal,orders.ocode as ocode,customers.cname as customer','bills',array('orders'=>'bills.boid = orders.oid','customers'=>'orders.ocid = customers.cid'),'orders.obcid IN ('.substr($this->loginuser->ubcid,1,-1).') and bills.bnewtotal > 0 and bills.accept <> "1"');
		$withdrowvoucher = $this->Admin_mo->getjoinLeft('withdrowvouchers.*,bills.bnewtotal as total,customers.cname as customer','withdrowvouchers',array('bills'=>'withdrowvouchers.wvoid = bills.boid','orders'=>'bills.boid = orders.oid','customers'=>'orders.ocid = customers.cid'),'withdrowvouchers.wvid = '.$id);
		$data['withdrowvoucher'] = $withdrowvoucher[0];
		$this->load->view('headers/withdrowvoucher-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/withdrowvoucher-edit',$data);
		$this->load->view('footers/withdrowvoucher-edit');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'withdrowvouchers';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/withdrowvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/withdrowvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'withdrowvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/withdrowvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/withdrowvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function editwv($id)
	{
		if(strpos($this->loginuser->privileges, ',wvedit,') !== false)
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_rules('oldorder', 'OldOrder' , 'trim|required');
			$this->form_validation->set_rules('order', 'Order' , 'trim|required');
			$this->form_validation->set_rules('oldpayment', 'OldPayment' , 'trim|required');
			$this->form_validation->set_rules('payment', 'Payment' , 'trim|required');
			$this->form_validation->set_rules('newtotal', 'New Total' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				redirect('withdrowvouchers', 'refresh');
			}
			else
			{
				$this->load->library('notifications');
				if(set_value('payment') <= set_value('newtotal'))
				{
					$order = $this->Admin_mo->getrow('orders', array('oid'=>set_value('order')));
					if(set_value('order') == set_value('oldorder')) $this->Admin_mo->update('bills', array('bnewtotal'=>number_format((set_value('newtotal')+set_value('oldpayment')-set_value('payment')),2)), array('boid'=>set_value('order')));
					else
					{
						$bill = $this->Admin_mo->getrow('bills', array('boid'=>set_value('oldorder')));
						$this->Admin_mo->update('bills', array('bnewtotal'=>number_format(($bill->bnewtotal+set_value('oldpayment')),2)), array('boid'=>set_value('oldorder')));
						$this->Admin_mo->update('bills', array('bnewtotal'=>number_format((set_value('newtotal')-set_value('payment')),2)), array('boid'=>set_value('order')));
						$this->Admin_mo->update('orders', array('wvdone'=>'1'), array('oid'=>set_value('order')));
					}

					$this->Admin_mo->update('withdrowvouchers', array('wvuid'=>$this->session->userdata('uid'), 'wvoid'=>set_value('order'), 'wvtotal'=>number_format(set_value('payment'),2), 'notes'=>set_value('notes'), 'wvtime'=>time()), array('wvid'=>$id));
					if(!$this->Admin_mo->exist('withdrowvouchers','where wvoid = '.set_value('oldorder'),'')) $this->Admin_mo->update('orders', array('wvdone'=>'0'), array('oid'=>set_value('oldorder')));
					$this->notifications->addNotify($this->session->userdata('uid'),'BL'.$order->obcid,' قام بتعديل سند قبض رقم '.$id.' على فاتورة رقم '.set_value('order'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,wvsee,%" or privileges like "%,wvedit,%") and ubcid like "%,'.$order->obcid.',%"');
					$data['admessage'] = 'Successfully Saved';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
					redirect('../fanarab_pdfs/withdrowvoucher_pdf/'.$id, 'refresh');
				}
				else { $_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong'; redirect('withdrowvouchers', 'refresh'); }
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('withdrowvouchers', 'refresh');
		}
		//redirect('withdrowvouchers', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'withdrowvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/withdrowvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/withdrowvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function del($id)
	{
		if(strpos($this->loginuser->privileges, ',wvdelete,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$withdrowvoucher = $this->Admin_mo->getjoinLeft('withdrowvouchers.wvoid as wvoid,withdrowvouchers.wvtotal as wvtotal,bills.bnewtotal as bnewtotal','withdrowvouchers',array('bills'=>'withdrowvouchers.wvoid = bills.boid'),'withdrowvouchers.wvid = '.$id);
		$order = $this->Admin_mo->getrow('orders', array('oid'=>$withdrowvoucher[0]->wvoid));
		$this->Admin_mo->del('withdrowvouchers', array('wvid'=>$id));
		$withdrowvouchers = $this->Admin_mo->getwhere('withdrowvouchers', array('wvoid'=>$withdrowvoucher[0]->wvoid));
		if(!empty($withdrowvouchers)) $this->Admin_mo->update('orders', array('wvdone'=>'0'), array('oid'=>$withdrowvoucher[0]->wvoid));
		$this->Admin_mo->update('bills', array('bnewtotal'=>number_format(($withdrowvoucher[0]->wvtotal + $withdrowvoucher[0]->bnewtotal),2)), array('boid'=>$withdrowvoucher[0]->wvoid));
		$this->notifications->addNotify($this->session->userdata('uid'),'BL'.$order->obcid,' قام بحذف سند القبض رقم '.$id,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,wvsee,%" or privileges like "%,wvdelete,%") and ubcid like "%,'.$order->obcid.',%"');
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('withdrowvouchers', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'withdrowvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('withdrowvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/withdrowvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/withdrowvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
}