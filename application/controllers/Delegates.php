<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delegates extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',dsee,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('delegates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['delegates'] = $this->Admin_mo->get('delegates');
		$this->load->view('calenderdate');
		//$data['users'] = $this->Admin_mo->rate('*','users',' where id <> 1');
		$this->load->view('headers/delegates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/delegates',$data);
		$this->load->view('footers/delegates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'delegates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('delegates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/delegates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/delegates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function add()
	{
		if(strpos($this->loginuser->privileges, ',dadd,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('delegates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		//$data['users'] = $this->Admin_mo->get('users');
		$this->load->view('headers/delegate-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/delegate-add',$data);
		$this->load->view('footers/delegate-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'delegates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('delegates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/delegates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/delegates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',dadd,') !== false)
		{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
		$this->form_validation->set_rules('name', 'اسم المندوب' , 'trim|required|max_length[255]|is_unique[delegates.dname]');
		$this->form_validation->set_rules('phone', 'موبايل المندوب' , 'trim|max_length[255]|numeric');
		if($this->form_validation->run() == FALSE)
		{
			//$data['admessage'] = 'validation error';
			//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$this->lang->load('delegates', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$this->load->view('headers/delegate-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/delegate-add',$data);
			$this->load->view('footers/delegate-add');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
			$data['did'] = $this->Admin_mo->set('delegates', array('duid'=>$this->session->userdata('uid'), 'dname'=>set_value('name'), 'dphone'=>set_value('phone'), 'ddesc'=>set_value('desc'), 'active'=>set_value('active'), 'dctime'=>time()));
			if(empty($data['did']))
			{
				$data['admessage'] = 'Not Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				redirect('delegates/add', 'refresh');
			}
			else
			{
				$this->load->library('notifications');
				$this->notifications->addNotify($this->session->userdata('uid'),'',' قام باضافة مندوب جديد '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,dsee,%" or privileges like "%,dadd,%")');
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('delegates', 'refresh');
			}
		}
		//redirect('delegates/add', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'delegates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('delegates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/delegates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/delegates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',dedit,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('delegates', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['delegate'] = $this->Admin_mo->getrow('delegates',array('did'=>$id));
		$this->load->view('headers/delegate-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/delegate-edit',$data);
		$this->load->view('footers/delegate-edit');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'delegates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('delegates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/delegates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/delegates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function editdelegate($id)
	{
		if(strpos($this->loginuser->privileges, ',dedit,') !== false)
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('name', 'اسم المندوب' , 'trim|required|max_length[255]');
			$this->form_validation->set_rules('phone', 'موبايل المندوب' , 'trim|max_length[255]|numeric');
			if($this->form_validation->run() == FALSE)
			{
				//$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
				$this->lang->load('delegates', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['delegate'] = $this->Admin_mo->getrow('delegates',array('did'=>$id));
				$this->load->view('headers/delegate-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/delegate-edit',$data);
				$this->load->view('footers/delegate-edit');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				if($this->Admin_mo->exist('delegates','where did <> '.$id.' and dname like "'.set_value('name').'"',''))
				{
					$data['admessage'] = 'This user type is exist';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'nameexist';
					redirect('delegates/edit/'.$id, 'refresh');
				}
				else
				{
					$this->load->library('notifications');
					$update_array = array('duid'=>$this->session->userdata('uid'), 'dname'=>set_value('name'), 'dphone'=>set_value('phone'), 'ddesc'=>set_value('desc'), 'active'=>set_value('active'), 'dctime'=>time());
					$this->Admin_mo->update('delegates', $update_array, array('did'=>$id));
					$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بتعديل المندوب  '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,dsee,%" or privileges like "%,dedit,%")');
					$data['admessage'] = 'Successfully Saved';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
					redirect('delegates', 'refresh');
				}
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('delegates', 'refresh');
		}
		//redirect('delegates', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'delegates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('delegates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/delegates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/delegates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function del($id)
	{
		if(strpos($this->loginuser->privileges, ',ddelete,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$delegate = $this->Admin_mo->getrow('delegates', array('did'=>$id));
		$this->Admin_mo->del('delegates', array('did'=>$id));
		$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بحذف المندوب  '.$delegate->dname,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,dsee,%" or privileges like "%,ddelete,%")');
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('delegates', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'delegates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('delegates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/delegates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/delegates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
}