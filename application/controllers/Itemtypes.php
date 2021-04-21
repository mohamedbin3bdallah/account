<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itemtypes extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',itsee,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('itemtypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['itemtypes'] = $this->Admin_mo->get('itemtypes');
		$this->load->view('calenderdate');
		//$data['itemtypes'] = $this->Admin_mo->rate('*','itemtypes',' where id <> 1');
		$this->load->view('headers/itemtypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/itemtypes',$data);
		$this->load->view('footers/itemtypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemtypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemtypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemtypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemtypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function add()
	{
		if(strpos($this->loginuser->privileges, ',itadd,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('itemtypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		//$data['itemtypes'] = $this->Admin_mo->get('itemtypes');
		$this->load->view('headers/itemtype-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/itemtype-add',$data);
		$this->load->view('footers/itemtype-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemtypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemtypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemtypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemtypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',itadd,') !== false)
		{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
		$this->form_validation->set_rules('name', 'اسم المخزن' , 'trim|required|max_length[255]|is_unique[itemtypes.itname]');
		if($this->form_validation->run() == FALSE)
		{
			//$data['admessage'] = 'validation error';
			//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$this->lang->load('itemtypes', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$this->load->view('headers/itemtype-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/itemtype-add',$data);
			$this->load->view('footers/itemtype-add');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
			$data['itid'] = $this->Admin_mo->set('itemtypes', array('ituid'=>$this->session->userdata('uid'), 'itname'=>set_value('name'), 'active'=>set_value('active'), 'itctime'=>time()));
			if(empty($data['itid']))
			{
				$data['admessage'] = 'Not Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				redirect('itemtypes/add', 'refresh');
			}
			else
			{
				$this->load->library('notifications');
				$itemtypes = $this->Admin_mo->get('itemtypes');
				$aritemtypes = ''; if(!empty($itemtypes)) { foreach($itemtypes as $itemtype) { $aritemtypes .= ','.$itemtype->itid; } $aritemtypes .= ','; }
				$this->Admin_mo->update('users', array('uitid'=>$aritemtypes), array('uid'=>'1'));
				$this->notifications->addNotify($this->session->userdata('uid'),'',' قام باضافة المخزن '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,itsee,%" or privileges like "%,itadd,%")');
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('itemtypes', 'refresh');
			}
		}
		//redirect('itemtypes/add', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemtypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemtypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemtypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemtypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',itedit,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('itemtypes', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['itemtype'] = $this->Admin_mo->getrow('itemtypes',array('itid'=>$id));
		$this->load->view('headers/itemtype-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/itemtype-edit',$data);
		$this->load->view('footers/itemtype-edit');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemtypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemtypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemtypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemtypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edititemtype($id)
	{
		if(strpos($this->loginuser->privileges, ',itedit,') !== false)
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('name', 'اسم المخزن' , 'trim|required|max_length[255]');
			if($this->form_validation->run() == FALSE)
			{
				//$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
				$this->lang->load('itemtypes', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['itemtype'] = $this->Admin_mo->getrow('itemtypes',array('itid'=>$id));
				$this->load->view('headers/itemtype-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/itemtype-edit',$data);
				$this->load->view('footers/itemtype-edit');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				if($this->Admin_mo->exist('itemtypes','where itid <> '.$id.' and itname like "'.set_value('name').'"',''))
				{
					$data['admessage'] = 'This user type is exist';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'nameexist';
					redirect('itemtypes/edit/'.$id, 'refresh');
				}
				else
				{
					$this->load->library('notifications');
					$update_array = array('ituid'=>$this->session->userdata('uid'), 'itname'=>set_value('name'), 'active'=>set_value('active'), 'itctime'=>time());
					$this->Admin_mo->update('itemtypes', $update_array, array('itid'=>$id));
					$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بتعديل المخزن  '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,itsee,%" or privileges like "%,itedit,%")');
					$data['admessage'] = 'Successfully Saved';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
					redirect('itemtypes', 'refresh');
				}
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('itemtypes', 'refresh');
		}
		//redirect('itemtypes', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemtypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemtypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemtypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemtypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function del($id)
	{
		if(strpos($this->loginuser->privileges, ',itdelete,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$admin = $this->Admin_mo->getrow('users', array('uid'=>'1'));
		$this->Admin_mo->update('users', array('uitid'=>str_replace($id.',', '', $admin->uitid)), array('uid'=>'1'));
		$itemtype = $this->Admin_mo->getrow('itemtypes', array('itid'=>$id));
		$this->Admin_mo->del('itemtypes', array('itid'=>$id));
		$itemtypes = $this->Admin_mo->get('itemtypes');
		$aritemtypes = ''; if(!empty($itemtypes)) { foreach($itemtypes as $itemtype) { $aritemtypes .= ','.$itemtype->itid; } $aritemtypes .= ','; }
		$this->Admin_mo->update('users', array('uitid'=>$aritemtypes), array('uid'=>'1'));
		$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بحذف المخزن  '.$itemtype->itname,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,itsee,%" or privileges like "%,itdelete,%")');
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('itemtypes', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemtypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemtypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemtypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemtypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
}