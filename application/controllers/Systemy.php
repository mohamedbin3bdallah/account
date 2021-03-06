<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Systemy extends CI_Controller {

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
		if($this->loginuser->uutid == '1')
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('system', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/system',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/system',$data);
		$this->load->view('footers/system');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'system';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('system', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/system',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/system');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function edit()
	{
		if($this->loginuser->uutid == '1')
		{
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span></button>', '</div>');
			$this->form_validation->set_rules('website', '?????? ????????????' , 'trim|required|max_length[255]');
			$this->form_validation->set_rules('currency', '????????????' , 'trim|required|max_length[9]');
			$this->form_validation->set_rules('calendar', '??????????????' , 'trim|required');
			if(isset($_FILES['file']['error']) && $_FILES['file']['error'] == 0) $this->form_validation->set_rules('file', '????????????' , 'callback_imageSize|callback_imageType');
			if($this->form_validation->run() == FALSE)
			{
				//$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));				
				$this->lang->load('system', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$this->load->view('headers/system',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/system',$data);
				$this->load->view('footers/system');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				$this->load->library('notifications');
				$update_array = array('website'=>set_value('website'), 'currency'=>set_value('currency'), 'calendar'=>set_value('calendar'));
				if(isset($_FILES['file']['error']) && $_FILES['file']['error'] == 0)
				{
					//$newname = mt_rand();
					$file = $this->uploadimg('file', 'imgs', array('gif', 'jpg', 'jpeg', 'png'), mt_rand());
					if($file)
					{
						if(set_value('oldlogo') != '') unlink('imgs/'.set_value('oldlogo'));
						$update_array['logo'] = $file;
					}
				}
				$this->Admin_mo->update('system', $update_array, array('id'=>'1'));
				$this->notifications->addNotify($this->session->userdata('uid'),'',' ?????? ???????????????? ?????? ???????????? ????????????','where uid <> '.$this->session->userdata('uid').' and uutid = 1');
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
				redirect('systemy', 'refresh');
			}
			//redirect('systemy', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'system';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('system', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/system',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/system');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function imageSize()
	{
		if ($_FILES['file']['size'] > 1024000)
		{
			//$this->form_validation->set_message('imageSize', '?????? ???? ???????? ?????? ???????????? 1 ???????? ???? ??????');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function imageType()
	{
		if (!in_array(strtoupper(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)),array('JPG','JPEG','PNG','JIF','BMP','TIF')))
		{
			//$this->form_validation->set_message('imageType', '?????? ???? ???????? ?????? ?????????? ?????????????? ???????? ???? ?????? ?????????????? : JPG,JPEG,PIG,JIF,BMP,TIF');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function uploadimg($inputfilename,$image_director,$extensions,$newname)
	{
		$file_extn = pathinfo($_FILES[$inputfilename]['name'], PATHINFO_EXTENSION);
		if(in_array($file_extn,$extensions))
		{			
			if(!is_dir($image_director)) $create_image_director = mkdir($image_director);
			$name = $newname.".".$file_extn;
			move_uploaded_file($_FILES[$inputfilename]["tmp_name"], $image_director.'/'.$name);		
			return $name;
		}
		else return '';
	}
}