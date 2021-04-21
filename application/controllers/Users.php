<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',usee,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		//$data['users'] = $this->Admin_mo->rate('users');
		//$data['users'] = $this->Admin_mo->getwhere('users',array('uid != '=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$branches = $this->Admin_mo->get('branches');
		$data['branches'] = array(); foreach($branches as $branch) { $data['branches'][$branch->bcid] = $branch->bcname; }
		$stores = $this->Admin_mo->get('itemtypes');
		$data['stores'] = array(); foreach($stores as $store) { $data['stores'][$store->itid] = $store->itname; }
		$data['users'] = $this->Admin_mo->getjoinLeft('users.uid as id,users.uuid as uuid,users.uctime as uctime,users.privileges as privileges,users.uname as uname,users.username as username,users.uemail as uemail,users.uphone as uphone,users.ubcid as ubcid,users.uitid as uitid,users.active as active,usertypes.utname as utname','users',array('usertypes'=>'users.uutid = usertypes.utid'),array('users.uid != '=>'1'));
		$this->load->view('calenderdate');
		$this->load->view('headers/users',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/users',$data);
		$this->load->view('footers/users');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'users';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/users',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/users');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function name_validation()
	{
		if($_POST['val'] != '' && $_POST['val'] != ' ')
		{
			if(isset($_POST['id']) && $_POST['id'] != '') $where = 'uid <> '.$_POST['id'].' and';
			else $where = '';
			 
			if(!preg_match('/[^0-9 ]/',$_POST['val'])) echo 5;
			elseif(strlen($_POST['val']) < 5) echo 2;
			elseif(strlen($_POST['val']) > 255) echo 3;
			elseif($this->Admin_mo->exist('users','where '.$where.' uname like "'.$_POST['val'].'"','')) echo 4;
			else echo 1;
		}
		else echo 0;
	}

	public function email_validation()
	{
		if($_POST['val'] != '' && $_POST['val'] != ' ')
		{
			if(isset($_POST['id']) && $_POST['id'] != '') $where = 'uid <> '.$_POST['id'].' and';
			else $where = '';
			
			if(filter_var($_POST['val'], FILTER_VALIDATE_EMAIL) === false) echo 2;
			elseif($this->Admin_mo->exist('users','where '.$where.' uemail like "'.$_POST['val'].'"','')) echo 4;
			else echo 1;
		}
		else echo 0;
	}
	
	public function password_validation()
	{
		if($_POST['val1'] != '')
		{
			if(strlen($_POST['val1']) < 6) echo 2;
			elseif(strlen($_POST['val1']) > 255) echo 3;
			elseif($_POST['val2'] != '' && $_POST['val2'] != ' ' && $_POST['val1'] != $_POST['val2']) echo 4;
			elseif($_POST['val2'] != '' && $_POST['val2'] != ' ' && $_POST['val1'] == $_POST['val2']) echo 5;
			else echo 1;
		}
		else echo 0;
	}
	
	public function cnfpassword_validation()
	{
		if($_POST['val1'] != '' && $_POST['val2'] != '')
		{
			if($_POST['val1'] != $_POST['val2']) echo 4;
			else echo 1;
		}
		else echo 0;
	}
	
	public function username_validation()
	{
		if($_POST['val'] != '' && $_POST['val'] != ' ')
		{
			if(isset($_POST['id']) && $_POST['id'] != '') $where = 'uid <> '.$_POST['id'].' and';
			else $where = '';
			
			if(preg_match('/[^a-z]/',$_POST['val'])) echo 2;
			elseif(strlen($_POST['val']) < 5) echo 3;
			elseif(strlen($_POST['val']) >= 255) echo 5;
			elseif($this->Admin_mo->exist('users','where '.$where.' username like "'.$_POST['val'].'"','')) echo 4;
			else echo 1;
		}
		else echo 0;
	}	

	public function getstores()
	{
		$stores = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
		if(!empty($stores))
		{
			echo ' <div id="storesdiv"><label for="store" class="control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12">المخزن <span class="required">*</span></label><div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12"><select class="form-control multiuserselect1" name="store[]" required="required" multiple>';
			foreach($stores as $store)
			{
				echo '<option value="'.$store->itid.'">'.$store->itname.'</option>';
			}
			echo '</select></div></div>';
		}
		else echo '';
	}

	public function add()
	{
		if(strpos($this->loginuser->privileges, ',uadd,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['usertypes'] = $this->Admin_mo->getwhere('usertypes',array('active'=>'1'));
		$data['branches'] = $this->Admin_mo->getwhere('branches',array('active'=>'1'));
		$this->load->view('headers/user-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/user-add',$data);
		$this->load->view('footers/user-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'users';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/users',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/users');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',uadd,') !== false)
		{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
		$this->form_validation->set_rules('username', 'اسم المستخدم' , 'trim|alpha|required|max_length[255]|is_unique[users.username]');
		$this->form_validation->set_rules('name', 'الاسم' , 'trim|required|max_length[255]|is_unique[users.uname]');
		$this->form_validation->set_rules('email', 'البريد الاكتروني' , 'trim|required|max_length[255]|valid_email|is_unique[users.uemail]');
		$this->form_validation->set_rules('password', 'كلمة المرور', 'trim|required|min_length[6]|max_length[255]');
		$this->form_validation->set_rules('cnfpassword', 'تاكيد كلمة المرور', 'trim|required|matches[password]');
		$this->form_validation->set_rules('phone', 'الموبايل' , 'trim|max_length[255]|numeric');
		$this->form_validation->set_rules('address', 'العنوان' , 'trim|max_length[255]');
		$this->form_validation->set_rules('usertype', 'نوع المستخدم' , 'trim|required');
		$this->form_validation->set_rules('privileges[]', 'الصلاحيات' , 'trim');
		if($this->form_validation->run() == FALSE)
		{
			//$data['admessage'] = 'validation error';
			//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$data['title'] = 'users';
			$this->lang->load('users', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['usertypes'] = $this->Admin_mo->getwhere('usertypes',array('active'=>'1'));
			$data['branches'] = $this->Admin_mo->getwhere('branches',array('active'=>'1'));
			$this->load->view('headers/user-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/user-add',$data);
			$this->load->view('footers/user-add');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
			$set_arr = array('uuid'=>$this->session->userdata('uid'), 'username'=>set_value('username'), 'uname'=>set_value('name'), 'uemail'=>set_value('email'), 'password'=>password_hash(set_value('password'), PASSWORD_BCRYPT, array('cost'=>10)), 'uutid'=>set_value('usertype'), 'uphone'=>set_value('phone'), 'uaddress'=>set_value('address'), 'active'=>set_value('active'), 'uctime'=>time());
			if(is_array(set_value('store')) && set_value('usertype') == 2) $set_arr['uitid'] = ','.implode(',',set_value('store')).','; else $set_arr['uitid'] = '';
			if(is_array(set_value('branch'))) $set_arr['ubcid'] = ','.implode(',',set_value('branch')).','; else $set_arr['ubcid'] = '';
			if(is_array(set_value('privileges'))) $set_arr['privileges'] = ','.implode(',',set_value('privileges')).','; else $set_arr['privileges'] = '';
			$data['uid'] = $this->Admin_mo->set('users', $set_arr);
			if(empty($data['uid']))
			{
				$data['admessage'] = 'Not Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				redirect('users/add', 'refresh');
			}
			else
			{
				$this->load->library('notifications');
				$this->notifications->addNotify($this->session->userdata('uid'),'',' قام باضافة المستخدم '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,usee,%" or privileges like "%,uadd,%")');
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('users', 'refresh');
			}
		}
		//redirect('users/add', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'users';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/users',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/users');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',uedit,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('users', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['usertypes'] = $this->Admin_mo->getwhere('usertypes',array('active'=>'1'));
		$data['stores'] = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
		$data['branches'] = $this->Admin_mo->getwhere('branches',array('active'=>'1'));
		$data['user'] = $this->Admin_mo->getrow('users',array('uid'=>$id));
		$this->load->view('headers/user-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/user-edit',$data);
		$this->load->view('footers/user-edit');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'users';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/users',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/users');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edituser($id)
	{
		if(strpos($this->loginuser->privileges, ',uedit,') !== false)
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('username', 'اسم المستخدم' , 'trim|alpha|required|max_length[255]');
			$this->form_validation->set_rules('name', 'الاسم' , 'trim|required|max_length[255]');
			$this->form_validation->set_rules('email', 'البريد الاكتروني' , 'trim|required|max_length[255]|valid_email');
			$this->form_validation->set_rules('password', 'كلمة المرور', 'trim|min_length[6]|max_length[255]');
			$this->form_validation->set_rules('cnfpassword', 'تاكيد كلمة المرور', 'trim|matches[password]');
			$this->form_validation->set_rules('phone', 'الموبايل' , 'trim|max_length[255]|numeric');
			$this->form_validation->set_rules('address', 'العنوان' , 'trim|max_length[255]');
			$this->form_validation->set_rules('usertype', 'نوع المستخدم' , 'trim|required');
			$this->form_validation->set_rules('privileges[]', 'الصلاحيات' , 'trim');
			if($this->form_validation->run() == FALSE)
			{
				//$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
				$this->lang->load('users', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['usertypes'] = $this->Admin_mo->getwhere('usertypes',array('active'=>'1'));
				$data['stores'] = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
				$data['branches'] = $this->Admin_mo->getwhere('branches',array('active'=>'1'));
				$data['user'] = $this->Admin_mo->getrow('users',array('uid'=>$id));
				$this->load->view('headers/user-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/user-edit',$data);
				$this->load->view('footers/user-edit');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				if($this->Admin_mo->exist('users','where uid <> '.$id.' and username like "'.set_value('username').'"',''))
				{
					$data['admessage'] = 'This Name is exist';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'usernameexist';
					redirect('users/edit/'.$id, 'refresh');
				}
				if($this->Admin_mo->exist('users','where uid <> '.$id.' and uname like "'.set_value('name').'"',''))
				{
					$data['admessage'] = 'This Name is exist';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'nameexist';
					redirect('users/edit/'.$id, 'refresh');
				}
				if($this->Admin_mo->exist('users','where uid <> '.$id.' and uemail like "'.set_value('email').'"',''))
				{
					$data['admessage'] = 'This Email is exist';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'emailexist';
					redirect('users/edit/'.$id, 'refresh');
				}
				else
				{
					$this->load->library('notifications');
					$update_array = array('uuid'=>$this->session->userdata('uid'), 'username'=>set_value('username'), 'uname'=>set_value('name'), 'uemail'=>set_value('email'), 'uutid'=>set_value('usertype'), 'uphone'=>set_value('phone'), 'uaddress'=>set_value('address'), 'active'=>set_value('active'), 'uctime'=>time());
					if(set_value('password') != '' && set_value('password') != ' ')  $update_array['password'] = password_hash(set_value('password'), PASSWORD_BCRYPT, array('cost'=>10));
					if(is_array(set_value('store')) && set_value('usertype') == 2) $update_array['uitid'] = ','.implode(',',set_value('store')).','; else $update_array['uitid'] = '';
					if(is_array(set_value('branch'))) $update_array['ubcid'] = ','.implode(',',set_value('branch')).','; else $update_array['ubcid'] = '';
					if(is_array(set_value('privileges'))) $update_array['privileges'] = ','.implode(',',set_value('privileges')).','; else $update_array['privileges'] = '';
					$this->Admin_mo->update('users', $update_array, array('uid'=>$id));
					$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بتعديل المستخدم  '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,usee,%" or privileges like "%,uedit,%")');
					$data['admessage'] = 'Successfully Saved';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
					redirect('users', 'refresh');
				}
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
			redirect('users', 'refresh');
		}
		//redirect('users', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'users';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/users',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/users');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function info($id)
	{
		if(strpos($this->loginuser->privileges, ',uinfo,') !== false)
		{
		$this->load->library('notifications');
		$this->load->library('arabictools');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['currentmonth'] = $this->arabictools->arabicDate($data['system']->calendar.' m', time());
		$data['currentyear'] = $this->arabictools->arabicDate($data['system']->calendar.' Y', time());
		$data['salaries'] = $this->Admin_mo->getjoinLeftLimit('salaries.*,users.uid as uid,users.uname as uname,users.username as username,users.usalary as usalary','salaries',array('users'=>'salaries.sluid = users.uid'),array('users.uid '=>$id,'slyear'.$data['system']->calendar=>$data['currentyear'],'slmonth'.$data['system']->calendar.' <= '=>$data['currentmonth']),'slmonth'.$data['system']->calendar.' ASC','');
		//$data['salaries'] = $this->Admin_mo->getjoinLeftLimit('salaries.*,users.uid as uid,users.uname as uname,users.username as username,users.usalary as usalary','salaries',array('users'=>'salaries.sluid = users.uid'),array('users.uid '=>$id),'','');
		if(!empty($data['salaries']))
		{
			$data['admessage'] = '';
			$this->lang->load('users', 'arabic');
			$this->load->view('headers/user-info',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/user-info',$data);
			$this->load->view('footers/user-info');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'users';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/users',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/users');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'users';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/users',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/users');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function salary($id)
	{
		if(strpos($this->loginuser->privileges, ',uinfo,') !== false)
		{
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('sleid', 'المستخدم' , 'trim|required|integer');
			$this->form_validation->set_rules('slename', 'المستخدم' , 'trim|required');
			$this->form_validation->set_rules('usalary', 'المرتب' , 'trim|required');
			$this->form_validation->set_rules('salaryitems[]', 'مفردة المرتب' , 'trim|required|max_length[255]');
			$this->form_validation->set_rules('values[]', 'القيمة' , 'trim|required|decimal|max_length[25]');
			$this->form_validation->set_rules('bonuse', 'العلاوة' , 'trim|max_length[11]|decimal');
			$this->form_validation->set_rules('gift', 'المكافئة' , 'trim|max_length[11]|decimal');
			$this->form_validation->set_rules('delay', 'التاخير' , 'trim|max_length[11]|decimal');
			$this->form_validation->set_rules('vacation', 'الاجازة' , 'trim|less_than[31]|integer');
			$this->form_validation->set_rules('sanction', 'الجزاء' , 'trim|less_than[31]|integer');
			$this->form_validation->set_rules('absence', 'الغياب' , 'trim|less_than[31]|integer');
			if($this->form_validation->run() == FALSE)
			{
				$this->load->library('notifications');
				$this->load->library('arabictools');
				$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
				$id = abs((int)($id));
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['currentmonth'] = $this->arabictools->arabicDate($data['system']->calendar.' m', time());
				$data['currentyear'] = $this->arabictools->arabicDate($data['system']->calendar.' Y', time());
				$data['salaries'] = $this->Admin_mo->getjoinLeftLimit('salaries.*,users.uid as uid,users.uname as uname,users.username as username,users.usalary as usalary','salaries',array('users'=>'salaries.sluid = users.uid'),array('users.uid '=>$id,'slyear'.$data['system']->calendar=>$data['currentyear'],'slmonth'.$data['system']->calendar.' <= '=>$data['currentmonth']),'slmonth'.$data['system']->calendar.' ASC','');
				//$data['salaries'] = $this->Admin_mo->getjoinLeftLimit('salaries.*,users.uid as uid,users.uname as uname,users.username as username,users.usalary as usalary','salaries',array('users'=>'salaries.sluid = users.uid'),array('users.uid '=>$id),'','');
				if(!empty($data['salaries']))
				{
					$data['admessage'] = '';
					$this->lang->load('users', 'arabic');
					$this->load->view('headers/user-info',$data);
					$this->load->view('sidemenu',$data);
					$this->load->view('topmenu',$data);
					$this->load->view('admin/user-info',$data);
					$this->load->view('footers/user-info');
					$this->load->view('notifys');
					$this->load->view('messages');
				}
				else
				{
				$this->load->library('notifications');
				$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
				$data['title'] = 'users';
				$data['admessage'] = 'youhavenoprivls';
				$this->lang->load('users', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$this->load->view('headers/users',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/messages',$data);
				$this->load->view('footers/users');
				$this->load->view('notifys');
				$this->load->view('messages');
				}
			}
			else
			{
				$this->load->library('notifications');
				$this->load->library('arabictools');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$currentmonth = $this->arabictools->arabicDate($data['system']->calendar.' m', time());
				$currentyear = $this->arabictools->arabicDate($data['system']->calendar.' Y', time());
				$slsalary = set_value('usalary');
				if(set_value('bonuse') != '00.00') $slsalary = ($slsalary+set_value('bonuse'));
				if(set_value('gift') != '00.00') $slsalary = ($slsalary+set_value('gift'));
				if(set_value('delay') != '00.00') $slsalary = ($slsalary-set_value('delay'));
				if(set_value('vacation') != 0) $slsalary = ($slsalary-(set_value('usalary')/30*set_value('vacation')));
				if(set_value('sanction') != 0) $slsalary = ($slsalary-(set_value('usalary')/30*set_value('sanction')));echo $currentmonth;
				if(set_value('absence') != 0) $slsalary = ($slsalary-(set_value('usalary')/30*set_value('absence')));
				$update_array = array('slsalary'=>$slsalary, 'sluid'=>$this->session->userdata('uid'), 'sleid'=>set_value('sleid'), 'slbonuse'=>set_value('bonuse'), 'slgift'=>set_value('gift'), 'sldelay'=>set_value('delay'), 'slvacation'=>set_value('vacation'), 'slsanction'=>set_value('sanction'), 'slabsence'=>set_value('absence'), 'sltime'=>time());
				if(is_array(set_value('salaryitems')))
				{
					$arr = array();
					for($i=0;$i<count(set_value('salaryitems'));$i++)
					{
						$arr[] = set_value('salaryitems')[$i].'-'.set_value('values')[$i];
					}
					$update_array['salaryitems'] = implode(',',$arr);
				}

				$this->Admin_mo->update('salaries', $update_array, array('sleid'=>$id,'slyear'.$data['system']->calendar=>$currentyear,'slmonth'.$data['system']->calendar=>$currentmonth));
				//$this->notifications->addNotify($this->session->userdata('uid'),'',' عدل مفردات مرتب المستخدم '.set_value('slename'),'where uid <> '.$this->session->userdata('uid').' and uutid = 1 or privileges like "%,uinfo,%"');
				//$data['admessage'] = 'Successfully Saved';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				//redirect('users', 'refresh');
			}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'users';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/users',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/users');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function del($id)
	{
		if(strpos($this->loginuser->privileges, ',udelete,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$user = $this->Admin_mo->getrow('users', array('uid'=>$id));
		$this->Admin_mo->del('users', array('uid'=>$id));
		$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بحذف المستخدم  '.$user->username,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,usee,%" or privileges like "%,udelete,%")');
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('users', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'users';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('users', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/users',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/users');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
}