<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branches extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',bcsee,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$this->lang->load('branches', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['branches'] = $this->Admin_mo->get('branches');
		$this->load->view('calenderdate');
		//$data['users'] = $this->Admin_mo->rate('*','users',' where id <> 1');
		$this->load->view('headers/branches',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/branches',$data);
		$this->load->view('footers/branches');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'branches';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('branches', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/branches',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/branches');
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
		$this->lang->load('branches', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		//$data['users'] = $this->Admin_mo->get('users');
		$this->load->view('headers/branch-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/branch-add',$data);
		$this->load->view('footers/branch-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'branches';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('branches', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/branches',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/branches');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',bcadd,') !== false)
		{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
		$this->form_validation->set_rules('name', 'اسم الفرع' , 'trim|required|max_length[255]|is_unique[branches.bcname]');
		if($this->form_validation->run() == FALSE)
		{
			//$data['admessage'] = 'validation error';
			//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$this->lang->load('branches', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$this->load->view('headers/branch-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/branch-add',$data);
			$this->load->view('footers/branch-add');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
			$this->load->library('notifications');
			$data['bcid'] = $this->Admin_mo->set('branches', array('bcuid'=>$this->session->userdata('uid'), 'bcname'=>set_value('name'), 'active'=>set_value('active'), 'bctime'=>time()));
			if(empty($data['bcid']))
			{
				$data['admessage'] = 'Not Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				redirect('branches/add', 'refresh');
			}
			else
			{
				$branches = $this->Admin_mo->get('branches');
				$arbranches = ''; if(!empty($branches)) { foreach($branches as $branch) { $arbranches .= ','.$branch->bcid; } $arbranches .= ','; }
				$this->Admin_mo->update('users', array('ubcid'=>$arbranches), array('uid'=>'1'));
				$this->notifications->addNotify($this->session->userdata('uid'),'',' قام باضافة الفرع الجديد '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,bcsee,%" or privileges like "%,bcadd,%")');
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('branches', 'refresh');
			}
		}
		//redirect('branches/add', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'branches';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('branches', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/branches',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/branches');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',bcedit,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('branches', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['branch'] = $this->Admin_mo->getrow('branches',array('bcid'=>$id));
		$this->load->view('headers/branch-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/branch-edit',$data);
		$this->load->view('footers/branch-edit');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'branches';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('branches', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/branches',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/branches');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function editbranch($id)
	{
		if(strpos($this->loginuser->privileges, ',bcedit,') !== false)
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('name', 'اسم الفرع' , 'trim|required|max_length[255]');
			if($this->form_validation->run() == FALSE)
			{
				//$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				$data = $this->notifys();
				$this->lang->load('branches', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['branch'] = $this->Admin_mo->getrow('branches',array('bcid'=>$id));
				$this->load->view('headers/branch-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/branch-edit',$data);
				$this->load->view('footers/branch-edit');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				$this->load->library('notifications');
				if($this->Admin_mo->exist('branches','where bcid <> '.$id.' and bcname like "'.set_value('name').'"',''))
				{
					$data['admessage'] = 'This user type is exist';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'nameexist';
					redirect('branches/edit/'.$id, 'refresh');
				}
				else
				{
					$update_array = array('bcuid'=>$this->session->userdata('uid'), 'bcname'=>set_value('name'), 'active'=>set_value('active'), 'bctime'=>time());
					$this->Admin_mo->update('branches', $update_array, array('bcid'=>$id));
					$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بالتعديل الفرع  '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,bcsee,%" or privileges like "%,bcedit,%")');
					$data['admessage'] = 'Successfully Saved';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
					redirect('branches', 'refresh');
				}
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('branches', 'refresh');
		}
		//redirect('branches', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'branches';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('branches', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/branches',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/branches');
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
		$admin = $this->Admin_mo->getrow('users', array('uid'=>'1'));
		$this->Admin_mo->update('users', array('ubcid'=>str_replace($id.',', '', $admin->ubcid)), array('uid'=>'1'));
		$branche = $this->Admin_mo->getrow('branches', array('bcid'=>$id));
		$this->Admin_mo->del('branches', array('bcid'=>$id));
		$branches = $this->Admin_mo->get('branches');
		$arbranches = ''; if(!empty($branches)) { foreach($branches as $branch) { $arbranches .= ','.$branch->bcid; } $arbranches .= ','; }
		$this->Admin_mo->update('users', array('ubcid'=>$arbranches), array('uid'=>'1'));
		$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بحذف الفرع  '.$branche->bcname,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,bcsee,%" or privileges like "%,bcdelete,%")');
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('branches', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'branches';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('branches', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/branches',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/branches');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
}