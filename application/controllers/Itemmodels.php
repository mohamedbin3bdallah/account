<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class itemmodels extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',imsee,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('itemmodels', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['itemmodels'] = $this->Admin_mo->get('itemmodels');
		$this->load->view('calenderdate');
		//$data['shoprate'] = $this->Admin_mo->rate('count(orderId) as num , sum(shoprate) as irate,shopId','orders',"where shoprate <> '' GROUP BY shopId");
		//foreach($data['shoprate'] as $rate) { $data['rate'][$rate->shopId] = number_format(intval($rate->irate)/intval($rate->num),2); }
		$this->load->view('headers/itemmodels',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/itemmodels',$data);
		$this->load->view('footers/itemmodels');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemmodels';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemmodels', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemmodels',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemmodels');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function add()
	{
		if(strpos($this->loginuser->privileges, ',imadd,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('itemmodels', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		//$data['sections'] = $this->Admin_mo->getwhere('sections',array('active'=>'1'));
		$data['itemtypes'] = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
		$this->load->view('headers/itemmodel-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/itemmodel-add',$data);
		$this->load->view('footers/itemmodel-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemmodels';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemmodels', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemmodels',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemmodels');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',imadd,') !== false)
		{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
		$this->form_validation->set_rules('name', 'نوع الاصناف' , 'trim|required|max_length[255]|is_unique[itemmodels.imname]');
		if($this->form_validation->run() == FALSE)
		{
			//$data['admessage'] = 'validation error';
			//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$this->lang->load('itemmodels', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['itemtypes'] = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
			$this->load->view('headers/itemmodel-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/itemmodel-add',$data);
			$this->load->view('footers/itemmodel-add');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
			$this->load->library('notifications');
			$data['imid'] = $this->Admin_mo->set('itemmodels', array('imuid'=>$this->session->userdata('uid'), 'imdesc'=>set_value('desc'), 'imname'=>set_value('name'), 'active'=>set_value('active'), 'imctime'=>time()));			
			if(empty($data['imid'])) { $data['admessage'] = 'Not Saved'; $_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong'; redirect('itemmodels/add', 'refresh');	}
			else  { $this->notifications->addNotify($this->session->userdata('uid'),'',' قام باضافة نوع المنتج الجديد '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,imsee,%" or privileges like "%,imadd,%")'); $data['admessage'] = 'Successfully Saved';	$_SESSION['time'] = time(); $_SESSION['message'] = 'success'; redirect('itemmodels', 'refresh'); }
		}
		
		//redirect('itemmodels/add', 'refresh');		
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemmodels';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemmodels', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemmodels',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemmodels');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',imedit,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('itemmodels', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		//$data['sections'] = $this->Admin_mo->getwhere('sections',array('active'=>'1'));
		$data['itemmodel'] = $this->Admin_mo->getrow('itemmodels',array('imid'=>$id));
		$this->load->view('headers/itemmodel-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/itemmodel-edit',$data);
		$this->load->view('footers/itemmodel-edit');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemmodels';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemmodels', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemmodels',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemmodels');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edititemmodel($id)
	{
		if(strpos($this->loginuser->privileges, ',imedit,') !== false)
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('name', 'نوع الاصناف' , 'trim|required|max_length[255]');
			if($this->form_validation->run() == FALSE)
			{
				//$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
				$this->lang->load('itemmodels', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['itemmodel'] = $this->Admin_mo->getrow('itemmodels',array('imid'=>$id));
				$this->load->view('headers/itemmodel-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/itemmodel-edit',$data);
				$this->load->view('footers/itemmodel-edit');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				if($this->Admin_mo->exist('itemmodels','where imid <> '.$id.' and imname like "'.set_value('name').'"',''))
				{
					$data['admessage'] = 'This Name is exist';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'nameexist';
					redirect('itemmodels/edit/'.$id, 'refresh');
				}	
				else
				{
					$this->load->library('notifications');
					$update_array = array('imuid'=>$this->session->userdata('uid'), 'imname'=>set_value('name'), 'imdesc'=>set_value('desc'), 'active'=>set_value('active'), 'imctime'=>time());
					$this->Admin_mo->update('itemmodels', $update_array, array('imid'=>$id));
					$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بتعديل نوع المنتج  '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,imsee,%" or privileges like "%,imedit,%")');
					$data['admessage'] = 'Successfully Saved';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
					redirect('itemmodels', 'refresh');
				}
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'invalidinput';
			redirect('itemmodels', 'refresh');
		}
		
		//redirect('itemmodels', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemmodels';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemmodels', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemmodels',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemmodels');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function del($id)
	{
		if(strpos($this->loginuser->privileges, ',imdelete,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$itemmodel = $this->Admin_mo->getrow('itemmodels', array('imid'=>$id));
		$this->Admin_mo->del('itemmodels', array('imid'=>$id));
		$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بحذف نوع المنتج  '.$itemmodel->imname,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,imsee,%" or privileges like "%,imdelete,%")');
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('itemmodels', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'itemmodels';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('itemmodels', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/itemmodels',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/itemmodels');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
}