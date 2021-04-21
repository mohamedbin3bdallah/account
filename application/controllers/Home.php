<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		if($this->session->userdata('uid') != FALSE)
		{
			$this->loginuser = $this->Admin_mo->getrow('users',array('uid'=>$this->session->userdata('uid')));
			$this->load->library('arabictools');
			$this->load->library('notifications');
			$data = $this->notifications->notifys($this->loginuser->ubcid,$this->loginuser->uitid,$this->session->userdata('uid'));
			$data['admessage'] = '';
			$this->lang->load('home', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			$calender = array('ar'=>'date','hj'=>'hdate');
			$currentyear = $this->arabictools->arabicDate($data['system']->calendar.' Y', time());

			$tables = array('o'=>'orders','apv'=>'accpaymentvouchers');
			$data['outcomes'] = array(1=>'',2=>'',3=>'',4=>'',5=>'',6=>'',7=>'',8=>'',9=>'',10=>'',11=>'',12=>'');
			foreach($tables as $tkey => $table)
			{
				//$oprepare = $this->Admin_mo->rate('sum('.$table.'.total) as total,month('.$table.'.date) as date',$table,' where year('.$table.'.date) = '.date('Y').' and '.$table.'.date <> "0000-00-00"  group by month('.$table.'.date) order by month('.$table.'.date) ASC');
				$oprepare = $this->Admin_mo->rate('sum('.$table.'.total) as total,month('.$table.'.'.$calender[$data['system']->calendar].') as date',$table,' where year('.$table.'.'.$calender[$data['system']->calendar].') = '.$currentyear.' and '.$table.'.'.$calender[$data['system']->calendar].' <> "0000-00-00"  group by month('.$table.'.'.$calender[$data['system']->calendar].') order by month('.$table.'.'.$calender[$data['system']->calendar].') ASC');
				foreach ($oprepare as $ovalue)
				{
					$data['outcomes'][$ovalue->date] += $ovalue->total;
				}
				
			}

			$data['incomes'] = array(1=>'',2=>'',3=>'',4=>'',5=>'',6=>'',7=>'',8=>'',9=>'',10=>'',11=>'',12=>'');
			//$iprepare = $this->Admin_mo->rate('sum(bills.btotal) as total,sum(bills.bdiscount) as discount,month(bills.bdate) as date','bills',' LEFT OUTER JOIN orders on bills.boid = orders.oid LEFT OUTER JOIN branches on orders.obcid = branches.bcid where year(bills.bdate) = '.date('Y').' and month(bills.bdate) <> "00"  group by month(bills.bdate) order by month(bills.bdate) ASC');
			$iprepare = $this->Admin_mo->rate('sum(bills.btotal) as total,sum(bills.bdiscount) as discount,month(bills.b'.$calender[$data['system']->calendar].') as date','bills',' LEFT OUTER JOIN orders on bills.boid = orders.oid LEFT OUTER JOIN branches on orders.obcid = branches.bcid where year(bills.b'.$calender[$data['system']->calendar].') = '.$currentyear.' and month(bills.b'.$calender[$data['system']->calendar].') <> "00"  group by month(bills.b'.$calender[$data['system']->calendar].') order by month(bills.b'.$calender[$data['system']->calendar].') ASC');
			foreach ($iprepare as $ivalue)
			{
				$data['incomes'][$ivalue->date] += $ivalue->total - $ivalue->discount;
			}

			$data['itemtypes'] = array(0=>array('item'=>'','sum'=>0),1=>array('item'=>'','sum'=>0),2=>array('item'=>'','sum'=>0),3=>array('item'=>'','sum'=>0),4=>array('item'=>'','sum'=>0));
			$itprepare = $this->Admin_mo->rate('items.iname as item,itemtypes.itname as store,SUM(paymentvouchers.pvquantity) as sum','paymentvouchers','LEFT OUTER JOIN items ON paymentvouchers.pviid = items.iid LEFT OUTER JOIN itemtypes ON items.iitid = itemtypes.itid where paymentvouchers.accept = "1" GROUP BY paymentvouchers.pviid limit 5');
			foreach ($itprepare as $itkey => $itvalue)
			{
				$data['itemtypes'][$itkey]['item'] = $itvalue->item.' - '.$itvalue->store;
				$data['itemtypes'][$itkey]['sum'] = $itvalue->sum;
			}
			
			$data['customers'] = array(0=>array('name'=>'','count'=>0),1=>array('name'=>'','count'=>0),2=>array('name'=>'','count'=>0),3=>array('name'=>'','count'=>0),4=>array('name'=>'','count'=>0));
			$cprepare = $this->Admin_mo->rate('customers.cname as name,COUNT(orders.oid) as count','orders','LEFT OUTER JOIN customers ON orders.ocid = customers.cid GROUP BY orders.ocid limit 5');
			foreach ($cprepare as $ckey => $cvalue)
			{
				$data['customers'][$ckey]['name'] = $cvalue->name;
				$data['customers'][$ckey]['count'] = $cvalue->count;
			}
			
			$data['activeusers'] = array(0=>array('name'=>'','count'=>0),1=>array('name'=>'','count'=>0),2=>array('name'=>'','count'=>0),3=>array('name'=>'','count'=>0),4=>array('name'=>'','count'=>0));
			$uprepare = $this->Admin_mo->rate('users.uname as name,COUNT(logsystem.id) as count','logsystem','LEFT OUTER JOIN users ON users.uid = logsystem.user GROUP BY logsystem.user limit 5');
			foreach ($uprepare as $ukey => $uvalue)
			{
				$data['activeusers'][$ukey]['name'] = $uvalue->name;
				$data['activeusers'][$ukey]['count'] = $uvalue->count;
			}

			$data['users'] = $this->Admin_mo->get('users');		
			$this->load->view('headers/home',$data);
			$this->load->view('sidemenu',$data);
			$this->load->view('topmenu',$data);
			$this->load->view('admin/home',$data);
			$this->load->view('footers/home');
			$this->load->view('notifys');
		}
		else
		{
			$data['message'] = '';
			$this->lang->load('home', 'arabic');
			$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
			//$this->lang->load('nemu', 'arabic');
			$this->load->view('headers/login',$data);
			$this->load->view('admin/login',$data);
			$this->load->view('footers/login');
		}
	}
	
	public function login()
	{
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->form_validation->set_rules('username', 'Username' , 'trim|required|alpha');
		$this->form_validation->set_rules('password', 'Password' , 'required');
		if($this->form_validation->run() == FALSE)
		{
			$this->lang->load('home', 'arabic');
			$data['message'] = 'all_inputs_required';
			$this->load->view('headers/login',$data);
			$this->load->view('admin/login',$data);
			$this->load->view('footers/login');
		}
		else
		{
			$data['result'] = $this->Admin_mo->getrow('users', array('username'=>set_value('username')));
			if(empty($data['result'])) 
			{
				$this->lang->load('home', 'arabic');
				$data['message'] = 'user_not_exist';
				$this->load->view('headers/login',$data);
				$this->load->view('admin/login',$data);
				$this->load->view('footers/login');
			}
			elseif(!password_verify(set_value('password'), $data['result']->password))
			{
				$this->lang->load('home', 'arabic');
				$data['message'] = 'wrong_password';
				$this->load->view('headers/login',$data);
				$this->load->view('admin/login',$data);
				$this->load->view('footers/login');
			}
			elseif($data['result']->active != '1')
			{
				$this->lang->load('home', 'arabic');
				$data['message'] = 'account_ot_Active';
				$this->load->view('headers/login',$data);
				$this->load->view('admin/login',$data);
				$this->load->view('footers/login');
			}
			else
			{
				$this->session->set_userdata('uid', $data['result']->uid);
				/*$this->session->set_userdata('privileges', $data['result']->privileges);
				$this->session->set_userdata('usertype', $data['result']->uutid);
				$this->session->set_userdata('branch', $data['result']->ubcid);
				$this->session->set_userdata('store', $data['result']->uitid);
				$this->session->set_userdata('username', $data['result']->username);
				$this->session->set_userdata('userimg', $data['result']->uimage);*/
				redirect('home', 'refresh');
			}
		}
	}
	
	public function logout()
	{
		unset(
			$_SESSION['uid']
			/*$_SESSION['privileges'],
			$_SESSION['usertype'],
			$_SESSION['branch'],
			$_SESSION['store'],
			$_SESSION['username'],
			$_SESSION['userimg']*/
		);
		redirect('home', 'refresh');
	}
	
	public function read()
	{
		$this->Admin_mo->updateM1('logsystem',array('seen'=>'1'),'notifyuser = '.$this->session->userdata('uid').' and section like ""');
	}
}
