<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

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
	public function index()
	{
		if(in_array($this->session->userdata('userType'),array('4','5')))
		{
		$data['admessage'] = '';
		$this->lang->load('orders', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		//$data['orders'] = $this->Admin_mo->get('orders');
		$data['orders'] = $this->Admin_mo->getjoinLeft('orders.*,shops.shopName as shop,shops.shopImage as shopImage,users.name as user,drivers.name as driver','orders',array('shops'=>'orders.shopId = shops.shopId','users'=>'orders.userId = users.id','drivers'=>'orders.driverId = drivers.driverId'),array());
		$this->load->view('headers/orders',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/orders',$data);
		$this->load->view('footers/orders');
		}
		else redirect('home', 'refresh');
	}

	public function add()
	{
		if(in_array($this->session->userdata('userType'),array('4','5')))
		{
		$data['admessage'] = '';
		$this->lang->load('orders', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['users'] = $this->Admin_mo->get('users');
		$data['shops'] = $this->Admin_mo->get('shops');
		//$data['items'] = $this->Admin_mo->get('items');
		$this->load->view('headers/order-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/order-add',$data);
		$this->load->view('footers/order-add',$data);
		}
		else redirect('home', 'refresh');
	}
	
	public function getitems($shopId)
	{
		if(in_array($this->session->userdata('userType'),array('4','5')))
		{
		$data['admessage'] = '';
		$this->lang->load('orders', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['users'] = $this->Admin_mo->get('users');
		$data['shops'] = $this->Admin_mo->get('shops');
		$data['items'] = $this->Admin_mo->getwhere('items',array('shopId'=>$shopId));
		$data['drivers'] = $this->Admin_mo->getwhere('drivers',array('shopId'=>$shopId));
		$data['selectedshop'] = $shopId;
		$this->load->view('headers/order-add',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/order-add',$data);
		$this->load->view('footers/order-add',$data);
		}
		else redirect('home', 'refresh');
	}
	
	public function create()
	{
		if(in_array($this->session->userdata('userType'),array('4','5')))
		{
		$this->form_validation->set_rules('shop', 'Shop' , 'trim|required');
		$this->form_validation->set_rules('user', 'User' , 'trim|required');
		$this->form_validation->set_rules('lat', 'Lat' , 'trim|required|max_length[255]');
		$this->form_validation->set_rules('lng', 'Lng' , 'trim|required|max_length[255]');
		$this->form_validation->set_rules('status', 'Status' , 'trim|required');
		$this->form_validation->set_rules('driver', 'Driver' , 'trim|required');
		$this->form_validation->set_rules('item[]', 'Item' , 'trim|required');
		$this->form_validation->set_rules('price[]', 'Price' , 'trim|required|max_length[11]|decimal');
		$this->form_validation->set_rules('quantity[]', 'Quantity' , 'trim|required|max_length[11]|integer');
		if($this->form_validation->run() == FALSE)
		{
			$data['admessage'] = 'validation error';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
		}
		else
		{
			$data['orderId'] = $this->Admin_mo->set('orders', array('userId'=>set_value('user'), 'shopId'=>set_value('shop'), 'create_time'=>time(), 'location_lat'=>set_value('lat'), 'location_lng'=>set_value('lng'), 'driverId'=>set_value('driver'), 'status'=>set_value('status'), 'active'=>set_value('active')));
			if(empty($data['orderId'])) { $data['admessage'] = 'Not Saved'; $_SESSION['time'] = time(); $_SESSION['message'] = 'somthingwrong'; }
			else
			{
				for($i=0;$i<count(set_value('item'));$i++)
				{
					$this->Admin_mo->set('orderitems', array('orderId'=>$data['orderId'], 'itemId'=>set_value('item')[$i], 'unitPrice'=>set_value('price')[$i], 'quantity'=>set_value('quantity')[$i]));
				}
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
		}
		redirect('orders/add', 'refresh');
		}
		else redirect('home', 'refresh');
	}

	public function edit($id)
	{
		if(in_array($this->session->userdata('userType'),array('4','5')))
		{
		$data['admessage'] = '';
		$this->lang->load('orders', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$id = abs((int)($id));
		$data['order'] = $this->Admin_mo->getjoin('orders.*,orderitems.*','orderitems','orders','orderitems.orderId = orders.orderId',array('orders.orderId'=>$id));
		if(!empty($data['order']))
		{
		for($i=0;$i<count($data['order']);$i++)
		{
			$data['myorder']['orderId'] = $data['order'][$i]->orderId;
			$data['myorder']['userId'] = $data['order'][$i]->userId;
			$data['myorder']['shopId'] = $data['order'][$i]->shopId;
			$data['myorder']['driverId'] = $data['order'][$i]->driverId;
			$data['myorder']['lat'] = $data['order'][$i]->location_lat;
			$data['myorder']['lng'] = $data['order'][$i]->location_lng;
			$data['myorder']['status'] = $data['order'][$i]->status;
			$data['myorder']['active'] = $data['order'][$i]->active;
			$data['myorder']['time'] = $data['order'][$i]->create_time;
			$data['myorder']['items'][$i]['itemId'] = $data['order'][$i]->itemId;
			$data['myorder']['items'][$i]['unitPrice'] = $data['order'][$i]->unitPrice;
			$data['myorder']['items'][$i]['quantity'] = $data['order'][$i]->quantity;
		}
		$data['users'] = $this->Admin_mo->get('users');
		$data['shops'] = $this->Admin_mo->get('shops');
		$data['drivers'] = $this->Admin_mo->getwhere('drivers',array('shopId'=>$data['myorder']['shopId']));
		$data['items'] = $this->Admin_mo->getwhere('items',array('shopId'=>$data['myorder']['shopId']));
		$this->load->view('headers/order-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/order-edit',$data);
		$this->load->view('footers/order-edit');
		}
		else redirect('orders', 'refresh');
		}
		else redirect('home', 'refresh');
	}
	
	public function getitemsedit($id,$shopId,$userId,$lat,$lng,$status,$active)
	{
		if(in_array($this->session->userdata('userType'),array('4','5')))
		{
		$data['myorder']['orderId'] = $id;
		$data['myorder']['userId'] = $userId;
		$data['myorder']['lat'] = $lat;
		$data['myorder']['lng'] = $lng;
		$data['myorder']['status'] = $status;
		$data['myorder']['active'] = $active;
		$data['admessage'] = '';
		$this->lang->load('orders', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['users'] = $this->Admin_mo->get('users');
		$data['shops'] = $this->Admin_mo->get('shops');
		$data['items'] = $this->Admin_mo->getwhere('items',array('shopId'=>$shopId));
		$data['drivers'] = $this->Admin_mo->getwhere('drivers',array('shopId'=>$shopId));
		$data['selectedshop'] = $shopId;
		$this->load->view('headers/order-edit',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/order-edit',$data);
		$this->load->view('footers/order-edit',$data);
		}
		else redirect('home', 'refresh');
	}
	
	public function editorder($id)
	{
		if(in_array($this->session->userdata('userType'),array('4','5')))
		{
		$id = abs((int)($id));
		if($id != '')
		{
			$this->form_validation->set_rules('shop', 'Shop' , 'trim|required');
			$this->form_validation->set_rules('user', 'User' , 'trim|required');
			$this->form_validation->set_rules('lat', 'Lat' , 'trim|required|max_length[255]');
			$this->form_validation->set_rules('lng', 'Lng' , 'trim|required|max_length[255]');
			$this->form_validation->set_rules('status', 'Status' , 'trim|required');
			$this->form_validation->set_rules('driver', 'Driver' , 'trim|required');
			$this->form_validation->set_rules('item[]', 'Item' , 'trim|required');
			$this->form_validation->set_rules('price[]', 'Price' , 'trim|required|max_length[11]|decimal');
			$this->form_validation->set_rules('quantity[]', 'Quantity' , 'trim|required|max_length[11]|integer');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
			}
			else
			{
				$this->Admin_mo->update('orders', array('userId'=>set_value('user'), 'shopId'=>set_value('shop'), 'create_time'=>time(), 'location_lat'=>set_value('lat'), 'location_lng'=>set_value('lng'), 'driverId'=>set_value('driver'), 'status'=>set_value('status'), 'active'=>set_value('active')),array('orderId'=>$id));
				$this->Admin_mo->del('orderitems', array('orderId'=>$id));
				for($i=0;$i<count(set_value('item'));$i++)
				{
					$this->Admin_mo->set('orderitems', array('orderId'=>$id, 'itemId'=>set_value('item')[$i], 'unitPrice'=>set_value('price')[$i], 'quantity'=>set_value('quantity')[$i]));
				}
				$data['admessage'] = 'Successfully Saved';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
			}
		}
		else
		{
			$data['admessage'] = 'Not Saved';
			$_SESSION['time'] = time(); $_SESSION['message'] = 'invalidinput';
		}
		redirect('orders/edit/'.$id, 'refresh');		
		}
		else redirect('home', 'refresh');
	}
	
	public function del($id)
	{
		if(in_array($this->session->userdata('userType'),array('4','5')))
		{
		$id = abs((int)($id));
		$this->Admin_mo->del('orders', array('orderId'=>$id));
		$this->Admin_mo->del('orderitems', array('orderId'=>$id));
		$_SESSION['time'] = time(); $_SESSION['message'] = 'success';
		redirect('orders', 'refresh');
		}
		else redirect('home', 'refresh');
	}
}