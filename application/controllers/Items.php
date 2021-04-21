<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

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
		if(strpos($this->loginuser->privileges, ',isee,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('items', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$employees = $this->Admin_mo->get('users'); foreach($employees as $employee) { $data['employees'][$employee->uid] = $employee->username; }
		$data['items'] = $this->Admin_mo->getjoinLeft('items.*,itemtypes.itname as type,itemmodels.imname as model,delegates.dname as delegate','items',array('itemtypes'=>'items.iitid=itemtypes.itid', 'itemmodels'=>'items.iimid=itemmodels.imid', 'delegates'=>'items.idid=delegates.did'),array());
		$this->load->view('calenderdate');
		$this->load->view('headers/items',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/items',$data);
		$this->load->view('footers/items');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'items';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('items', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/items',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/items');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}

	public function add()
	{
		if(strpos($this->loginuser->privileges, ',iadd,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('items', 'arabic');
		//$data['sections'] = $this->Admin_mo->getwhere('sections',array('active'=>'1'));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['itemtypes'] = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
		$data['itemmodels'] = $this->Admin_mo->getwhere('itemmodels',array('active'=>'1'));
		$data['delegates'] = $this->Admin_mo->getwhere('delegates',array('active'=>'1'));
		$this->load->view('headers/item-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/item-add',$data);
		$this->load->view('footers/item-add');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'items';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('items', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/items',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/items');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function iprint($id)
	{
		if(isset($id) && $id != '' && set_value('codes') != '')
		{
			$item = $this->Admin_mo->getrow('items',array('iid'=>$id));
			if(!empty($item))
			{
				$itemcodes = explode(',',$item->inprint);
				$itemcodes = array_diff($itemcodes, set_value('codes'));
				$inpcodes = implode(',',$itemcodes);
				if($item->iprint != '') $ipcodes = $item->iprint.','.implode(',',set_value('codes'));
				else $ipcodes = implode(',',set_value('codes'));
				$this->Admin_mo->update('items', array('iprint'=>$ipcodes,'inprint'=>$inpcodes), array('iid'=>$id));
				$data['printcodes'] = set_value('codes');
				$data['itemcode'] = $item->icode;
				$this->load->view('printcodes',$data);
			}
			else redirect('items', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'items';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('items', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/items',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/items');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function getmodels()
	{
		$data['admessage'] = '';
		$type = $_POST['val'];
		$data['itemmodels'] = $this->Admin_mo->getwhere('itemmodels',array('active'=>'1','imitid'=>$type));
		if(!empty($data['itemmodels']))
		{
			foreach($data['itemmodels'] as $model)
			{
				echo '<option value="'.$model->imid.'">'.$model->imname.'</option>';
			}
		}
		else echo 0;
	}
	
	public function create()
	{
		if(strpos($this->loginuser->privileges, ',iadd,') !== false)
		{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
		$this->form_validation->set_rules('name', 'اسم الصنف' , 'trim|required|max_length[255]');
		//$this->form_validation->set_rules('code', 'Code' , 'trim|required|max_length[255]|is_unique[items.icode]');
		$this->form_validation->set_rules('type', 'المخزن' , 'trim|required');
		$this->form_validation->set_rules('model', 'نوع الصنف' , 'trim|required');
		$this->form_validation->set_rules('delegate', 'المورد' , 'trim|required');
		$this->form_validation->set_rules('bill', 'الفاتورة' , 'trim|required|max_length[50]');
		$this->form_validation->set_rules('buyprice', 'سعر الشراء' , 'trim|required|max_length[11]|decimal');
		$this->form_validation->set_rules('wholesaleprice', 'سعر الجملة' , 'trim|required|max_length[11]|decimal');
		$this->form_validation->set_rules('retailprice', 'سعر التجزئة' , 'trim|required|max_length[11]|decimal');
		$this->form_validation->set_rules('quantity', 'الكمية المتاحة' , 'trim|required|greater_than[0]|less_than[1000000000]|integer');
		$this->form_validation->set_rules('minrange', 'الحد الادنى' , 'trim|required|greater_than[0]|less_than[1000000000]|integer');
		$this->form_validation->set_rules('maxrange', 'الحد الاقصى' , 'trim|required|greater_than[0]|less_than[1000000000]|integer');
		if($this->form_validation->run() == FALSE)
		{
			//$data['admessage'] = 'validation error';
			//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$this->lang->load('items', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$data['itemtypes'] = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
			$data['itemmodels'] = $this->Admin_mo->getwhere('itemmodels',array('active'=>'1'));
			$data['delegates'] = $this->Admin_mo->getwhere('delegates',array('active'=>'1'));
			$this->load->view('headers/item-add',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/item-add',$data);
			$this->load->view('footers/item-add');
			$this->load->view('notifys');
			$this->load->view('messages');
		}
		else
		{
			$this->load->library('notifications');
			$inprint = '1'; for($count=2;$count<(set_value('quantity')+1);$count++) { $inprint .= ','.$count; }
			$data['iid'] = $this->Admin_mo->set('items', array('iuid'=>$this->session->userdata('uid'), 'bin'=>set_value('bill'), 'iitid'=>set_value('type'), 'iimid'=>set_value('model'), 'idid'=>set_value('delegate'), 'iname'=>set_value('name'), 'ibuyprice'=>set_value('buyprice'), 'iwholesaleprice'=>set_value('wholesaleprice'), 'iretailprice'=>set_value('retailprice'), 'iquantity'=>set_value('quantity'), 'itquantity'=>set_value('quantity'), 'iminrange'=>set_value('minrange'), 'imaxrange'=>set_value('maxrange'), 'inprint'=>$inprint, 'active'=>set_value('active'), 'ictime'=>time()));
			if(empty($data['iid']))	{ $data['admessage'] = 'Not Saved'; $_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong'; redirect('items/add', 'refresh'); }
			else { $this->notifications->addNotify($this->session->userdata('uid'),'',' قام باضافة المنتج '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,isee,%" or privileges like "%,iadd,%")'); $this->Admin_mo->update('items', array('icode'=>'SR'.set_value('type').'IT'.set_value('model').'I'.$data['iid'].'Q'.set_value('quantity').'D'.set_value('delegate').'U'.$this->session->userdata('uid')), array('iid'=>$data['iid'])); $data['admessage'] = 'Successfully Saved'; $_SESSION['time'] = time(); $_SESSION['message'] = 'success'; redirect('items', 'refresh'); }
		}
		
		//redirect('items/add', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'items';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('items', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/items',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/items');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edit($id)
	{
		if(strpos($this->loginuser->privileges, ',iedit,') !== false)
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['admessage'] = '';
		$this->lang->load('items', 'arabic');
		$id = abs((int)($id));
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['itemtypes'] = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
		$data['itemmodels'] = $this->Admin_mo->getwhere('itemmodels',array('active'=>'1'));
		$data['delegates'] = $this->Admin_mo->getwhere('delegates',array('active'=>'1'));
		$data['item'] = $this->Admin_mo->getrow('items',array('iid'=>$id));
		$this->load->view('headers/item-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/item-edit',$data);
		$this->load->view('footers/item-edit');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'items';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('items', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/items',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/items');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function edititem($id)
	{
		if(strpos($this->loginuser->privileges, ',iedit,') !== false)
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>', '</div>');
			$this->form_validation->set_rules('name', 'اسم الصنف' , 'trim|required|max_length[255]');
			//$this->form_validation->set_rules('code', 'Code' , 'trim|required|max_length[255]');
			$this->form_validation->set_rules('type', 'المخزن' , 'trim|required');
			$this->form_validation->set_rules('model', 'نوع الصنف' , 'trim|required');
			$this->form_validation->set_rules('delegate', 'المورد' , 'trim|required');
			$this->form_validation->set_rules('bill', 'الفاتورة' , 'trim|required|max_length[50]');
			$this->form_validation->set_rules('buyprice', 'سعر الشراء' , 'trim|required|max_length[11]|decimal');
			$this->form_validation->set_rules('wholesaleprice', 'سعر الجملة' , 'trim|required|max_length[11]|decimal');
			$this->form_validation->set_rules('retailprice', 'سعر التجزئة' , 'trim|required|max_length[11]|decimal');
			$this->form_validation->set_rules('quantity', 'الكمية المتاحة' , 'trim|required|greater_than[0]|less_than[1000000000]|integer');
			$this->form_validation->set_rules('minrange', 'الحد الادنى' , 'trim|required|greater_than[0]|less_than[1000000000]|integer');
			$this->form_validation->set_rules('maxrange', 'الحد الاقصى' , 'trim|required|greater_than[0]|less_than[1000000000]|integer');
			if($this->form_validation->run() == FALSE)
			{
				//$data['admessage'] = 'validation error';
				//$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
				$this->lang->load('items', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$data['itemtypes'] = $this->Admin_mo->getwhere('itemtypes',array('active'=>'1'));
				$data['itemmodels'] = $this->Admin_mo->getwhere('itemmodels',array('active'=>'1'));
				$data['delegates'] = $this->Admin_mo->getwhere('delegates',array('active'=>'1'));
				$data['item'] = $this->Admin_mo->getrow('items',array('iid'=>$id));
				$this->load->view('headers/item-edit',$data);
				$this->load->view('sidemenu',$data);
				$this->load->view('topmenu',$data);
				$this->load->view('admin/item-edit',$data);
				$this->load->view('footers/item-edit');
				$this->load->view('notifys');
				$this->load->view('messages');
			}
			else
			{
				if($this->Admin_mo->exist('items','where iid <> '.$id.' and iname like "'.set_value('name').'" and iitid = '.set_value('type').' and iimid = '.set_value('model'),''))
				{
					echo $data['admessage'] = 'This Name is exist';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'nameexist';
					redirect('items/edit/'.$id, 'refresh');
				}
				/*if($this->Admin_mo->exist('items','where iid <> '.$id.' and icode like "'.set_value('code').'" and iitid = '.set_value('type').' and iimid = '.set_value('model'),''))
				{
					echo $data['admessage'] = 'This Code is exist';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'codeexist';
				}*/
				else
				{
					$this->load->library('notifications');
					$update_array = array('iuid'=>$this->session->userdata('uid'), 'bin'=>set_value('bill'), 'iname'=>set_value('name'), 'iitid'=>set_value('type'), 'iimid'=>set_value('model'), 'icode'=>'SR'.set_value('type').'IT'.set_value('model').'I'.$id.'Q'.set_value('quantity').'D'.set_value('delegate').'U'.$this->session->userdata('uid'), 'idid'=>set_value('delegate'), 'iquantity'=>set_value('quantity'), 'iminrange'=>set_value('minrange'), 'imaxrange'=>set_value('maxrange'), 'ibuyprice'=>set_value('buyprice'), 'iwholesaleprice'=>set_value('wholesaleprice'), 'iretailprice'=>set_value('retailprice'), 'ictime'=>time(), 'active'=>set_value('active'));
					if(set_value('quantity') > set_value('oldquantity'))
					{
						if(set_value('oldnprint') == '') { $inprint = set_value('oldtquantity')+1; for($count=(set_value('oldtquantity')+2);$count<(set_value('oldtquantity')+set_value('quantity')-set_value('oldquantity')+1);$count++) { $inprint .= ','.$count; } }
						else { $inprint = set_value('oldnprint').','.(set_value('oldtquantity')+1); for($count=(set_value('oldtquantity')+2);$count<(set_value('oldtquantity')+set_value('quantity')-set_value('oldquantity')+1);$count++) { $inprint .= ','.$count; } }
						$update_array['itquantity'] = set_value('oldtquantity')+set_value('quantity')-set_value('oldquantity');
						$update_array['inprint'] = $inprint;
					}
					$this->Admin_mo->update('items', $update_array, array('iid'=>$id));
					$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بتعديل المنتج  '.set_value('name'),'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,isee,%" or privileges like "%,iedit,%")');
					$data['admessage'] = 'Successfully Saved';
					$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
					redirect('items', 'refresh');
				}
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'invalidinput';
			redirect('items', 'refresh');
		}
		
		//redirect('items', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'items';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('items', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/items',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/items');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
	
	public function del($id)
	{
		if(strpos($this->loginuser->privileges, ',idelete,') !== false)
		{
		$id = abs((int)($id));
		$this->load->library('notifications');
		$item = $this->Admin_mo->getrow('items', array('iid'=>$id));
		$this->Admin_mo->del('items', array('iid'=>$id));
		$this->notifications->addNotify($this->session->userdata('uid'),'',' قام بحذف المنتج  '.$item->iname,'where uid <> '.$this->session->userdata('uid').' and (uutid = 1 or privileges like "%,isee,%" or privileges like "%,idelete,%")');
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('items', 'refresh');
		}
		else
		{
		$this->load->library('notifications');
		$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
		$data['title'] = 'items';
		$data['admessage'] = 'youhavenoprivls';
		$this->lang->load('items', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/items',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/messages',$data);
		$this->load->view('footers/items');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
	}
}