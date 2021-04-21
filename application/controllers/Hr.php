<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr extends CI_Controller {

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

	public function salaries()
	{
		if(strpos($this->loginuser->privileges, ',slsee,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('salaries', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$branches = $this->Admin_mo->get('branches');
		$data['branches'] = array(); foreach($branches as $branch) { $data['branches'][$branch->bcid] = $branch->bcname; }
		$stores = $this->Admin_mo->get('itemtypes');
		$data['stores'] = array(); foreach($stores as $store) { $data['stores'][$store->itid] = $store->itname; }
		$data['users'] = $this->Admin_mo->getjoinLeftLimit('salaries.*,users.uid as id,users.uuid as uuid,users.uctime as uctime,users.uname as uname,users.username as username,users.uemail as uemail,users.uphone as uphone,users.ubcid as ubcid,users.uitid as uitid,users.active as active,usertypes.utname as utname','salaries',array('users'=>'salaries.sleid = users.uid','usertypes'=>'users.uutid = usertypes.utid'),array('users.uid != '=>'1'),'slyear'.$data['system']->calendar.',slmonth'.$data['system']->calendar.' DESC','');
		$this->load->view('calenderdate');
		$this->load->view('headers/salaries',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/salaries',$data);
		$this->load->view('footers/salaries');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'salaries';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('salaries', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/salaries',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/salaries');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function salaryshow($id)
	{
		if(strpos($this->loginuser->privileges, ',sledit,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('salaries', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$branches = $this->Admin_mo->get('branches');
		$data['branches'] = array(); foreach($branches as $branch) { $data['branches'][$branch->bcid] = $branch->bcname; }
		$stores = $this->Admin_mo->get('itemtypes');
		$data['stores'] = array(); foreach($stores as $store) { $data['stores'][$store->itid] = $store->itname; }
		$data['user'] = $this->Admin_mo->getrowjoinLeftLimit('salaries.*,users.uid as id,users.uuid as uuid,users.uctime as uctime,users.uname as uname,users.username as username,users.uemail as uemail,users.uphone as uphone,users.ubcid as ubcid,users.uitid as uitid,users.active as active,usertypes.utname as utname','salaries',array('users'=>'salaries.sleid = users.uid','usertypes'=>'users.uutid = usertypes.utid'),array('users.uid != '=>'1','salaries.slid'=>$id),'slyear'.$data['system']->calendar.',slmonth'.$data['system']->calendar.' DESC','');
		if(!empty($data['user']))
		{
			$this->load->view('headers/salary-edit',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/salary-edit',$data);
			$this->load->view('footers/salary-edit');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'salaries';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('salaries', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/salaries',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/salaries');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'salaries';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('salaries', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/salaries',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/salaries');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function salaryedit($id)
	{
		if(strpos($this->loginuser->privileges, ',sledit,') !== false)
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
				$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
				$branches = $this->Admin_mo->get('branches');
				$data['branches'] = array(); foreach($branches as $branch) { $data['branches'][$branch->bcid] = $branch->bcname; }
				$stores = $this->Admin_mo->get('itemtypes');
				$data['stores'] = array(); foreach($stores as $store) { $data['stores'][$store->itid] = $store->itname; }
				$data['user'] = $this->Admin_mo->getrowjoinLeftLimit('salaries.*,users.uid as id,users.uuid as uuid,users.uctime as uctime,users.uname as uname,users.username as username,users.uemail as uemail,users.uphone as uphone,users.ubcid as ubcid,users.uitid as uitid,users.active as active,usertypes.utname as utname','salaries',array('users'=>'salaries.sleid = users.uid','usertypes'=>'users.uutid = usertypes.utid'),array('users.uid != '=>'1','salaries.slid'=>$id),'slyear'.$data['system']->calendar.',slmonth'.$data['system']->calendar.' DESC','');
				if(!empty($data['user']))
				{
					$data['admessage'] = '';
					$this->lang->load('salaries', 'arabic');
					$this->load->view('headers/salary-edit',$data);
					$this->load->view('sidemenu',$data);
					$this->load->view('topmenu',$data);
					$this->load->view('admin/salary-edit',$data);
					$this->load->view('footers/salary-edit');
					$this->load->view('notifys');
					$this->load->view('messages');
				}
				else
				{
				$data['title'] = 'salaries';
				$data['admessage'] = 'youhavenoprivls';
				$this->lang->load('salaries', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$this->load->view('headers/salaries',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/messages',$data);
				$this->load->view('footers/salaries');
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

				//$this->Admin_mo->update('salaries', $update_array, array('sleid'=>$id,'slyear'.$data['system']->calendar=>$currentyear,'slmonth'.$data['system']->calendar=>$currentmonth));
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
		$data['title'] = 'salaries';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('salaries', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/salaries',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/salaries');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function certificates()
	{
		if(strpos($this->loginuser->privileges, ',cfsee,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('certificates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['users'] = $this->Admin_mo->getjoinLeftLimit('certificates.*,users.uid as id,users.uuid as uuid,users.uname as uname,users.username as username','certificates',array('users'=>'certificates.cfeid = users.uid'),array('users.uid != '=>'1'),'','');
		$this->load->view('calenderdate');
		$this->load->view('headers/certificates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/certificates',$data);
		$this->load->view('footers/certificates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'certificates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('certificates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/certificates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/certificates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function addcertificate()
	{
		if(strpos($this->loginuser->privileges, ',cfadd,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('certificates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['users'] = $this->Admin_mo->rate('uid,uname','users','where uid != 1 and active = 1 order by uname ASC');
		$this->load->view('headers/certificate-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/certificate-add',$data);
		$this->load->view('footers/certificate-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'certificates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('certificates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/certificates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/certificates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function createcertificate()
	{
		if(strpos($this->loginuser->privileges, ',cfadd,') !== false)
		{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
		$this->form_validation->set_rules('user', 'المستخدم' , 'trim|required|integer');
		$this->form_validation->set_rules('title', 'العنوان' , 'trim|required|max_length[255]');
		$this->form_validation->set_rules('file', 'الملف' , 'callback_fSize|callback_fType');
		if($this->form_validation->run() == FALSE)
		{
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$this->lang->load('certificates', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['users'] = $this->Admin_mo->rate('uid,uname','users','where uid != 1 and active = 1 order by uname ASC');
			$this->load->view('headers/certificate-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/certificate-add',$data);
			$this->load->view('footers/certificate-add');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
			$this->load->library('notifications');
			$insert_array = array('cfeid'=>set_value('user'), 'cfuid'=>$this->session->userdata('uid'), 'cftitle'=>set_value('title'), 'cftime'=>time());
			$file = $this->uploadimg('file', 'imgs/users/'.set_value('user').'/', mt_rand());
			if($file)	$insert_array['cflink'] = $file;
			$cfid = $this->Admin_mo->set('certificates', $insert_array);
			if(empty($cfid))
			{
				if($file) unlink($file);
				$_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong';
				redirect('hr/addcertificate', 'refresh');
			}
			else
			{
				$user = $this->Admin_mo->getrow('users',array('uid'=>set_value('user')));
				$this->notifications->addNotify($this->session->userdata('uid'),'',' اضاف شهادة الى المستخدم '.$user->uname,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,cfsee,%" or privileges like "%,cfadd,%")');
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('hr/certificates', 'refresh');
			}
		}
		//redirect('usertypes/add', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'certificates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('certificates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/certificates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/certificates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function editcertificate($id)
	{
		if(strpos($this->loginuser->privileges, ',cfedit,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('certificates', 'arabic');
		$data['certificate'] = $this->Admin_mo->getrow('certificates',array('cfid'=>$id));
		if(!empty($data['certificate']))
		{
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['users'] = $this->Admin_mo->rate('uid,uname','users','where uid != 1 and active = 1 order by uname ASC');
			$this->load->view('headers/certificate-edit',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/certificate-edit',$data);
			$this->load->view('footers/certificate-edit');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
			$data['title'] = 'certificates';
			$data['admessage'] = 'youhavenoprivls';
			$this->lang->load('certificates', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$this->load->view('headers/certificates',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/certificates');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'certificates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('certificates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/certificates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/certificates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function updatecertificate($id)
	{
		if(strpos($this->loginuser->privileges, ',cfedit,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['certificate'] = $this->Admin_mo->getrow('certificates',array('cfid'=>$id));
		if(!empty($data['certificate']))
		{
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('user', 'المستخدم' , 'trim|required|integer');
			$this->form_validation->set_rules('title', 'العنوان' , 'trim|required|max_length[255]');
			if(isset($_FILES['file']['error']) && $_FILES['file']['error'] == 0) $this->form_validation->set_rules('file', 'الملف' , 'callback_fSize|callback_fType');
			if($this->form_validation->run() == FALSE)
			{
				$this->lang->load('certificates', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['users'] = $this->Admin_mo->rate('uid,uname','users','where uid != 1 and active = 1 order by uname ASC');
				$this->load->view('headers/certificate-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/certificate-edit',$data);
				$this->load->view('footers/certificate-edit');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				$update_array = array('cfeid'=>set_value('user'), 'cfuid'=>$this->session->userdata('uid'), 'cftitle'=>set_value('title'), 'cftime'=>time());
				if(isset($_FILES['file']['error']) && $_FILES['file']['error'] == 0)
				{
					$file = $this->uploadimg('file', 'imgs/users/'.set_value('user').'/', mt_rand());
					if($file)	$update_array['cflink'] = $file;
				}
				$this->Admin_mo->update('certificates', $update_array, array('cfid'=>$id));

					if(isset($file) && $file) unlink(set_value('oldfile'));
					$user = $this->Admin_mo->getrow('users',array('uid'=>set_value('user')));
					$this->notifications->addNotify($this->session->userdata('uid'),'',' تعديل شهادة الى المستخدم '.$user->uname,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,cfsee,%" or privileges like "%,cfedit,%")');
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
					redirect('hr/certificates', 'refresh');
				
			}
		}
		else
		{
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$data['title'] = 'certificates';
			$data['admessage'] = 'youhavenoprivls';
			$this->lang->load('certificates', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$this->load->view('headers/certificates',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/messages',$data);
			$this->load->view('footers/certificates');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'certificates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('certificates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/certificates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/certificates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function deletecertificate($id)
	{
		if(strpos($this->loginuser->privileges, ',cfdelete,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$certificate = $this->Admin_mo->getrowjoinLeftLimit('certificates.cftitle as cftitle,certificates.cflink as cflink,users.username as username','certificates',array('users'=>'certificates.cfeid = users.uid'),array('certificates.cfid'=>$id),'','');
		$this->Admin_mo->del('certificates', array('cfid'=>$id));
		unlink($certificate->cflink);
		$this->notifications->addNotify($this->session->userdata('uid'),'',' حذف شهادة '.$certificate->cftitle.' للمستخدم  '.$certificate->username,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,cfsee,%" or privileges like "%,cfdelete,%")');
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('hr/certificates', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'certificates';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('certificates', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/certificates',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/certificates');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function fSize()
	{
		if ($_FILES['file']['size'] > 1024000)
		{
			//$this->form_validation->set_message('imageSize', 'يجب ان يكون حجم الصورة 1 ميجا او اقل');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function fType()
	{
		if (!in_array(strtoupper(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)),array('JPG','JPEG','PNG','JIF','BMP','TIF','PDF','DOC','DOCX')))
		{
			//$this->form_validation->set_message('imageType', 'يجب ان يكون نوع الملف المرفوع واحد من هذه الانواع : JPG,JPEG,PIG,JIF,BMP,TIF');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function uploadimg($inputfilename,$image_director,$newname)
	{
		$file_extn = pathinfo($_FILES[$inputfilename]['name'], PATHINFO_EXTENSION);
		if(!is_dir($image_director)) $create_image_director = mkdir($image_director);
		$name = $newname.'.'.$file_extn;
		if(move_uploaded_file($_FILES[$inputfilename]["tmp_name"], $image_director.$name)) return $image_director.$name;
		else return 0;
	}
}