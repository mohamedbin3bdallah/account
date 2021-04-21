<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accpaymentvouchers extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',pvaccsee,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['preporders'] = $this->Admin_mo->getjoinLeft('accpaymentvouchers.*,accpvitems.*,branches.bcname as branch','accpvitems',array('accpaymentvouchers'=>'accpvitems.apviapvid = accpaymentvouchers.apvid','branches'=>'accpaymentvouchers.apvbcid = branches.bcid'),'branches.bcid IN ('.substr($this->loginuser->ubcid,1,-1).')');
		if(!empty($data['preporders']))
		{
			for($i=0;$i<count($data['preporders']);$i++)
			{
				//$data['orders'][$data['preporders'][$i]->oid] = new stdClass();
				$data['orders'][$data['preporders'][$i]->apvid]['apvid'] = $data['preporders'][$i]->apvid;
				$data['orders'][$data['preporders'][$i]->apvid]['apvuid'] = $data['preporders'][$i]->apvuid;
				$data['orders'][$data['preporders'][$i]->apvid]['branch'] = $data['preporders'][$i]->branch;
				$data['orders'][$data['preporders'][$i]->apvid]['customer'] = $data['preporders'][$i]->apvcustomer;
				$data['orders'][$data['preporders'][$i]->apvid]['code'] = $data['preporders'][$i]->apvcode;
				$data['orders'][$data['preporders'][$i]->apvid]['time'] = $data['preporders'][$i]->apvtime;
				$data['orders'][$data['preporders'][$i]->apvid]['notes'] = $data['preporders'][$i]->notes;
				$data['orders'][$data['preporders'][$i]->apvid]['total'] = $data['preporders'][$i]->total;
				$data['orders'][$data['preporders'][$i]->apvid]['items'][$i]['item'] = $data['preporders'][$i]->apviitem;
				$data['orders'][$data['preporders'][$i]->apvid]['items'][$i]['price'] = $data['preporders'][$i]->apviprice;
				$data['orders'][$data['preporders'][$i]->apvid]['items'][$i]['quantity'] = $data['preporders'][$i]->apviquantity;
			}
		}
		$this->load->view('calenderdate');
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/accpaymentvouchers',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function add()
	{
		if(strpos($this->loginuser->privileges, ',pvaccadd,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['branches'] = $this->Admin_mo->rate('*','branches','where active = "1" and bcid IN ('.substr($this->loginuser->ubcid,1,-1).')');
		$this->load->view('headers/accpaymentvoucher-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/accpaymentvoucher-add',$data);
		$this->load->view('footers/accpaymentvoucher-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',pvaccadd,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->form_validation->set_rules('customer', 'Customer' , 'trim|required');
		$this->form_validation->set_rules('branch', 'Branch' , 'trim|required');
		$this->form_validation->set_rules('item[]', 'Item' , 'trim|required');
		$this->form_validation->set_rules('price[]', 'Price' , 'trim|required|max_length[11]|decimal');
		$this->form_validation->set_rules('quantity[]', 'Quantity' , 'trim|required|max_length[11]|integer');
		$this->form_validation->set_rules('total', 'Total' , 'trim|required');
		if($this->form_validation->run() == FALSE)
		{
			$data['admessage'] = 'validation error';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
		}
		else
		{
			$this->load->library('arabictools');
			$data['apvid'] = $this->Admin_mo->set('accpaymentvouchers', array('apvuid'=>$this->session->userdata('uid'), 'apvbcid'=>set_value('branch'), 'apvcustomer'=>set_value('customer'), 'total'=>set_value('total'), 'notes'=>set_value('notes'), 'date'=>date('Y-m-d'), 'hdate'=>$this->arabictools->arabicDate('hj Y-m-d', time()), 'apvtime'=>time()));
			if(empty($data['apvid']))
			{
				$data['admessage'] = 'Not Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			}
			else
			{
				$this->load->library('notifications');
				$this->Admin_mo->update('accpaymentvouchers', array('apvcode'=>'ACCPV'.$data['apvid'].'BC'.set_value('branch').'T'.set_value('total')), array('apvid'=>$data['apvid']));
				for($i=0;$i<count(set_value('item'));$i++)
				{
					$apvid = $this->Admin_mo->set('accpvitems', array('apviapvid'=>$data['apvid'], 'apviitem'=>set_value('item')[$i], 'apviprice'=>set_value('price')[$i], 'apviquantity'=>set_value('quantity')[$i]));
					//$this->addNotify($this->session->userdata('uid'),'PV'.$stores[array_search(set_value('item')[$i], $items)],' اضاف سند صرف رقم '.$pvid,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvsee,%" or privileges like "%,pvedit,%") and uitid like "%,'.$stores[array_search(set_value('item')[$i], $items)].'%"');
				}
				$this->notifications->addNotify($this->session->userdata('uid'),'BL'.set_value('branch'),' قام باضافة سند صرف رقم '.$data['apvid'],'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvaccsee,%" or privileges like "%,pvaccadd,%") and ubcid like "%,'.set_value('branch').',%"');
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
		}
		redirect('accpaymentvouchers', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',pvaccedit,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['branches'] = $this->Admin_mo->rate('*','branches','where active = "1" and bcid IN ('.substr($this->loginuser->ubcid,1,-1).')');
		$data['preporders'] = $this->Admin_mo->getjoinLeft('accpaymentvouchers.*,accpvitems.*','accpvitems',array('accpaymentvouchers'=>'accpvitems.apviapvid = accpaymentvouchers.apvid','branches'=>'accpaymentvouchers.apvbcid = branches.bcid'),'branches.bcid IN ('.substr($this->loginuser->ubcid,1,-1).') and accpaymentvouchers.apvid = '.$id);
		if(!empty($data['preporders']))
		{
			for($i=0;$i<count($data['preporders']);$i++)
			{
				$data['order']['apvid'] = $data['preporders'][$i]->apvid;
				$data['order']['apvbcid'] = $data['preporders'][$i]->apvbcid;
				$data['order']['customer'] = $data['preporders'][$i]->apvcustomer;
				$data['order']['code'] = $data['preporders'][$i]->apvcode;
				$data['order']['time'] = $data['preporders'][$i]->apvtime;
				$data['order']['notes'] = $data['preporders'][$i]->notes;
				$data['order']['total'] = $data['preporders'][$i]->total;
				$data['order']['items'][$i]['item'] = $data['preporders'][$i]->apviitem;
				$data['order']['items'][$i]['price'] = $data['preporders'][$i]->apviprice;
				$data['order']['items'][$i]['quantity'] = $data['preporders'][$i]->apviquantity;
			}
		}
		$this->load->view('headers/accpaymentvoucher-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/accpaymentvoucher-edit',$data);
		$this->load->view('footers/accpaymentvoucher-edit');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function editapv($id)
	{
		if(strpos($this->loginuser->privileges, ',pvaccedit,') !== false)
		{
		if($this->loginuser->ubcid != '')
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_rules('customer', 'Customer' , 'trim|required');
			$this->form_validation->set_rules('branch', 'Branch' , 'trim|required');
			$this->form_validation->set_rules('item[]', 'Item' , 'trim|required');
			$this->form_validation->set_rules('price[]', 'Price' , 'trim|required|max_length[11]|decimal');
			$this->form_validation->set_rules('quantity[]', 'Quantity' , 'trim|required|max_length[11]|integer');
			$this->form_validation->set_rules('total', 'Total' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			}
			else
			{
				$this->load->library('arabictools');
				$this->load->library('notifications');
				$update_array = array('apvuid'=>$this->session->userdata('uid'), 'apvbcid'=>set_value('branch'), 'apvcode'=>'ACCPV'.$id.'BC'.set_value('branch').'T'.set_value('total'), 'apvcustomer'=>set_value('customer'), 'total'=>set_value('total'), 'notes'=>set_value('notes'), 'date'=>date('Y-m-d'), 'hdate'=>$this->arabictools->arabicDate('hj Y-m-d', time()), 'apvtime'=>time());
				$this->Admin_mo->update('accpaymentvouchers', $update_array, array('apvid'=>$id));
				$this->Admin_mo->del('accpvitems', array('apviapvid'=>$id));
				for($i=0;$i<count(set_value('item'));$i++)
				{
					$apvid = $this->Admin_mo->set('accpvitems', array('apviapvid'=>$id, 'apviitem'=>set_value('item')[$i], 'apviprice'=>set_value('price')[$i], 'apviquantity'=>set_value('quantity')[$i]));
				}
				$this->notifications->addNotify($this->session->userdata('uid'),'BL'.set_value('branch'),' قام بالتعديل على سند صرف رقم '.$id,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,pvaccsee,%" or privileges like "%,pvaccedit,%") and ubcid like "%,'.set_value('branch').',%"');
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
		}
		redirect('accpaymentvouchers', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenobranch';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function del($id)
	{
		if(strpos($this->loginuser->privileges, ',pvaccdelete,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$accpaymentvoucher = $this->Admin_mo->getrow('accpaymentvouchers', array('apvid'=>$id));
		$this->Admin_mo->del('accpaymentvouchers', array('apvid'=>$id));
		$this->Admin_mo->del('accpvitems', array('apviapvid'=>$id));
		$this->addNotify($this->session->userdata('uid'),'BL'.$accpaymentvoucher->apvbcid,' قام بحذف سند الصرف رقم '.$id,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,wvsee,%" or privileges like "%,wvdelete,%") and ubcid like "%,'.$accpaymentvoucher->apvbcid.',%"');
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('accpaymentvouchers', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'accpaymentvouchers';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('accpaymentvouchers', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/accpaymentvouchers',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/accpaymentvouchers');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
}