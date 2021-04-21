<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usertypes extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',utsee,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('usertypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['usertypes'] = $this->Admin_mo->get('usertypes');
		$this->load->view('calenderdate');
		//$data['users'] = $this->Admin_mo->rate('*','users',' where id <> 1');
		$this->load->view('headers/usertypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/usertypes',$data);
		$this->load->view('footers/usertypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'usertypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('usertypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/usertypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/usertypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function add()
	{
		if(strpos($this->loginuser->privileges, ',utadd,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('usertypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		//$data['users'] = $this->Admin_mo->get('users');
		$this->load->view('headers/usertype-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/usertype-add',$data);
		$this->load->view('footers/usertype-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'usertypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('usertypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/usertypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/usertypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',utadd,') !== false)
		{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
		$this->form_validation->set_rules('name', 'نوع المستخدم' , 'trim|required|max_length[255]|is_unique[usertypes.utname]');
		if($this->form_validation->run() == FALSE)
		{
			//$data['admessage'] = 'validation error';
			//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$this->lang->load('usertypes', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$this->load->view('headers/usertype-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/usertype-add',$data);
			$this->load->view('footers/usertype-add');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
			$this->load->library('notifications');
			$data['utid'] = $this->Admin_mo->set('usertypes', array('utuid'=>$this->session->userdata('uid'), 'utname'=>set_value('name'), 'active'=>set_value('active'), 'utctime'=>time()));
			if(empty($data['utid']))
			{
				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				redirect('usertypes/add', 'refresh');
			}
			else
			{
				$this->notifications->addNotify($this->session->userdata('uid'),'',' قام باضافة نوع المستخدم '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,utsee,%" or privileges like "%,utadd,%")');
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('usertypes', 'refresh');
			}
		}
		//redirect('usertypes/add', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'usertypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('usertypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/usertypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/usertypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',utedit,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('usertypes', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['usertype'] = $this->Admin_mo->getrow('usertypes',array('utid'=>$id));
		$this->load->view('headers/usertype-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/usertype-edit',$data);
		$this->load->view('footers/usertype-edit');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'usertypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('usertypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/usertypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/usertypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function editusertype($id)
	{
		if(strpos($this->loginuser->privileges, ',utedit,') !== false)
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('name', 'نوع المستخدم' , 'trim|required|max_length[255]');
			if($this->form_validation->run() == FALSE)
			{
				//$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
				$this->lang->load('usertypes', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['usertype'] = $this->Admin_mo->getrow('usertypes',array('utid'=>$id));
				$this->load->view('headers/usertype-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/usertype-edit',$data);
				$this->load->view('footers/usertype-edit');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				if($this->Admin_mo->exist('usertypes','where utid <> '.$id.' and utname like "'.set_value('name').'"',''))
				{
					$data['admessage'] = 'This user type is exist';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'nameexist';
					redirect('usertypes/edit/'.$id, 'refresh');
				}
				else
				{
					$this->load->library('notifications');
					$update_array = array('utuid'=>$this->session->userdata('uid'), 'utname'=>set_value('name'), 'active'=>set_value('active'), 'utctime'=>time());
					$this->Admin_mo->update('usertypes', $update_array, array('utid'=>$id));
					$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بتعديل نوع المستخدم  '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,utsee,%" or privileges like "%,utedit,%")');
					$data['admessage'] = 'Successfully Saved';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
					redirect('usertypes', 'refresh');
				}
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('usertypes', 'refresh');
		}
		//redirect('usertypes', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'usertypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('usertypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/usertypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/usertypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function del($id)
	{
		if(strpos($this->loginuser->privileges, ',utdelete,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$usertype = $this->Admin_mo->getrow('usertypes', array('utid'=>$id));
		$this->Admin_mo->del('usertypes', array('utid'=>$id));
		$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بحذف نوع المستخدم  '.$usertype->utname,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,utsee,%" or privileges like "%,utdelete,%")');
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('usertypes', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'usertypes';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('usertypes', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/usertypes',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/usertypes');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
}