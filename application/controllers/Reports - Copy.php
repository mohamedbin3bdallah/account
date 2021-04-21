<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

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
		redirect('home', 'refresh');
	}

	public function type()
	{
		$arr = array();
		if($_POST['val'] == 'D')
		{
			$arr['from'] = '<input type="date" class="form-control" name="from" />';
			$arr['to'] = '<input type="date" class="form-control" name="to" />';
		}
		elseif($_POST['val'] == 'M')
		{
			$arr['from'] = '<select class="form-control" name="from" id="from"><option value="">اختر</option>';
			for($m=1;$m<13;$m++) { $arr['from'] .= '<option value="'.$m.'">'.$m.'</option>'; }
			$arr['from'] .= '</select>';
			$arr['to'] = '<select class="form-control" name="to" id="to"><option value="">اختر</option>';
			for($m=1;$m<13;$m++) { $arr['to'] .= '<option value="'.$m.'">'.$m.'</option>'; }
			$arr['to'] .= '</select>';
		}
		elseif($_POST['val'] == 'Y')
		{
			$arr['from'] = '<select class="form-control" name="from" id="from"><option value="">اختر</option>';
			for($y=2016;$y<2033;$y++) { $arr['from'] .= '<option value="'.$y.'">'.$y.'</option>'; }
			$arr['from'] .= '</select>';
			$arr['to'] = '<select class="form-control" name="to" id="to"><option value="">اختر</option>';
			for($y=2016;$y<2033;$y++) { $arr['to'] .= '<option value="'.$y.'">'.$y.'</option>'; }
			$arr['to'] .= '</select>';
		}
		echo json_encode($arr);
		//echo 1;
		//print_r($arr);
	}
	
	public function general()
	{
		if(strpos($this->session->userdata('privileges'), 'generalreport') !== false)
		{
		$data = $this->notifys();
		$data['title'] = 'generalreport';
		$data['admessage'] = '';
		$this->lang->load('reports', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$this->load->view('headers/reports',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/generalr',$data);
		$this->load->view('footers/reports');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else redirect('home', 'refresh');
	}
	
	public function general_pdf()
	{
		if(strpos($this->session->userdata('privileges'), 'generalreport') !== false)
		{
			$this->form_validation->set_rules('type', 'Type' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				redirect('reports/general', 'refresh');
			}
			else
			{
				$data['admessage'] = '';
				$where = '';
				$this->lang->load('reports', 'arabic');
				$this->lang->load('privileges', 'arabic');
				$this->lang->load('keys', 'arabic');
				$this->lang->load('menu', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));

				if(set_value('type') == 'UT')
				{
					$data['data'] = $this->Admin_mo->getjoinLeftLimit('usertypes.*,users.uname as user','usertypes',array('users'=>'usertypes.utuid=users.uid'),array(),'usertypes.utctime DESC','');
					$file = 'gusertypes_pdf';
				}
				elseif(set_value('type') == 'U')
				{
					$branches = $this->Admin_mo->get('branches');
					$data['branches'] = array(); foreach($branches as $branch) { $data['branches'][$branch->bcid] = $branch->bcname; }
					$stores = $this->Admin_mo->get('itemtypes');
					$data['stores'] = array(); foreach($stores as $store) { $data['stores'][$store->itid] = $store->itname; }
					$data['data'] = $this->Admin_mo->getjoinLeftLimit('users.*,usertypes.utname as usertype','users',array('usertypes'=>'users.uutid=usertypes.utid'),array(),'users.uctime DESC','');
					$file = 'gusers_pdf';
				}
				elseif(set_value('type') == 'BC')
				{
					$data['data'] = $this->Admin_mo->getjoinLeftLimit('branches.*,users.uname as user','branches',array('users'=>'branches.bcuid=users.uid'),array(),'branches.bctime DESC','');
					$file = 'gbranches_pdf';
				}
				elseif(set_value('type') == 'C')
				{
					$data['data'] = $this->Admin_mo->getjoinLeftLimit('customers.*,users.uname as user','customers',array('users'=>'customers.cuid=users.uid'),array(),'customers.cctime DESC','');
					$file = 'gcustomers_pdf';
				}
				elseif(set_value('type') == 'D')
				{
					$data['data'] = $this->Admin_mo->getjoinLeftLimit('delegates.*,users.uname as user','delegates',array('users'=>'delegates.duid=users.uid'),array(),'delegates.dctime DESC','');
					$file = 'gdelegates_pdf';
				}
				elseif(set_value('type') == 'IT')
				{
					$data['data'] = $this->Admin_mo->getjoinLeftLimit('itemtypes.*,users.uname as user','itemtypes',array('users'=>'itemtypes.ituid=users.uid'),array(),'itemtypes.itctime DESC','');
					$file = 'gitemtypes_pdf';
				}
				elseif(set_value('type') == 'IM')
				{
					$data['data'] = $this->Admin_mo->getjoinLeftLimit('itemmodels.*,users.uname as user,itemtypes.itname as store','itemmodels',array('users'=>'itemmodels.imuid=users.uid','itemtypes'=>'itemmodels.imitid=itemtypes.itid'),array(),'itemmodels.imctime DESC,itemtypes.itid ASC','');
					$file = 'gitemmodels_pdf';
				}
				else $data['data'] = '';
				
				if(!empty($data['data'])) $this->load->view('admin/'.$file,$data);
				else redirect('reports/general', 'refresh');
			}
		}
		else redirect('home', 'refresh');
	}

	public function incomes()
	{
		if(strpos($this->session->userdata('privileges'), 'incomesreport') !== false)
		{
		$data = $this->notifys();
		$data['title'] = 'incomes';
		$data['admessage'] = '';
		$this->lang->load('reports', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['branches'] = $this->Admin_mo->get('branches');
		$this->load->view('headers/reports',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/incomes',$data);
		$this->load->view('footers/reports');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else redirect('home', 'refresh');
	}

	public function incomes_pdf()
	{
		if(strpos($this->session->userdata('privileges'), 'incomesreport') !== false)
		{
			$this->form_validation->set_rules('type', 'Type' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				redirect('reports/incomes', 'refresh');
			}
			else
			{
				$data['admessage'] = '';
				$where = '';
				$this->lang->load('reports', 'arabic');
				$this->lang->load('keys', 'arabic');
				$this->lang->load('menu', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				
				if(set_value('branch') != 0) $branch = ' and orders.obcid = '.set_value('branch'); else $branch = '';
				$myselect = 'sum(bills.btotal) as total,sum(bills.bdiscount) as discount';
				$join = 'LEFT OUTER JOIN orders on bills.boid = orders.oid LEFT OUTER JOIN branches on orders.obcid = branches.bcid';
				
				if(set_value('from') != '' && set_value('to') != '' && set_value('from') <= set_value('to'))
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',bills.bdate as date'; $where .= $join.' where bills.bdate between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; $group = 'bills.bdate'; }
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) = '.date('Y').' and month(bills.bdate) between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; $group = 'month(bills.bdate)'; }
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; $group = 'year(bills.bdate)'; }
				}
				elseif(set_value('from') != '')
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',bills.bdate as date'; $where .= $join.' where bills.bdate >= "'.set_value('from').'"'.$branch; $group = 'bills.bdate'; }
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) = '.date('Y').' and month(bills.bdate) >= "'.set_value('from').'"'.$branch; $group = 'month(bills.bdate)'; }
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) >= "'.set_value('from').'"'.$branch; $group = 'year(bills.bdate)'; }
				}
				elseif(set_value('to') != '')
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',bills.bdate as date'; $where .= $join.' where bills.bdate <= "'.set_value('to').'"'.$branch; $group = 'bills.bdate'; }
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) = '.date('Y').' and month(bills.bdate) <= "'.set_value('to').'"'.$branch; $group = 'month(bills.bdate)'; }
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) <= "'.set_value('to').'"'.$branch; $group = 'year(bills.bdate)'; }
				}
				else
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',bills.bdate as date'; $where .= $join.' where bills.bdate <> "0000-00-00"'.$branch; $group = 'bills.bdate'; }
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) = '.date('Y').' and month(bills.bdate) <> "00"'.$branch; $group = 'month(bills.bdate)'; }
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) <> "00"'.$branch; $group = 'year(bills.bdate)'; }
				}
				$where .= ' group by '.$group.' order by '.$group.' ASC';
				$data['data'] = $this->Admin_mo->rate($select,'bills',$where);
				if(!empty($data['data'])) $this->load->view('admin/incomes_pdf',$data);
				else redirect('reports/incomes', 'refresh');
			}
		}
		else redirect('home', 'refresh');
	}

	public function outcomes()
	{
		if(strpos($this->session->userdata('privileges'), 'outcomesreport') !== false)
		{
		$data = $this->notifys();
		$data['title'] = 'outcomes';
		$data['admessage'] = '';
		$this->lang->load('reports', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['branches'] = $this->Admin_mo->get('branches');
		$data['itemtypes'] = $this->Admin_mo->get('itemtypes');
		$this->load->view('headers/reports',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/outcomes',$data);
		$this->load->view('footers/reports');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else redirect('home', 'refresh');
	}

	public function outcomes_pdf()
	{
		if(strpos($this->session->userdata('privileges'), 'outcomesreport') !== false)
		{
			$this->form_validation->set_rules('type', 'Type' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				redirect('reports/outcomes', 'refresh');
			}
			else
			{
				$data['admessage'] = '';
				$where = '';
				$this->lang->load('reports', 'arabic');
				$this->lang->load('keys', 'arabic');
				$this->lang->load('menu', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				
				if(set_value('branch') != "0")
				{
					if(substr(set_value('branch'),0,1) == 'S')
					{
						$branch = ' and items.iitid = '.substr(set_value('branch'),1);
						$join = ' inner join items on joborders.joiid = items.iid';
					}
					else
					{
						$branch = ' and orders.obcid = '.substr(set_value('branch'),1);
						$join = '';
					}
				}
				else 
				{
					$branch = '';
					$join = '';
				}
				
				if(set_value('from') != '' && set_value('to') != '' && set_value('from') <= set_value('to'))
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = 'sum(joborders.joprice) as total,orders.odate as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where orders.odate between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; $group = 'orders.odate'; }
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = 'sum(joborders.joprice) as total,month(orders.odate) as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where year(orders.odate) = '.date('Y').' and month(orders.odate) between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; $group = 'month(orders.odate)'; }
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = 'sum(joborders.joprice) as total,year(orders.odate) as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where year(orders.odate) between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; $group = 'year(orders.odate)'; }
				}
				elseif(set_value('from') != '')
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = 'sum(joborders.joprice) as total,orders.odate as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where orders.odate >= "'.set_value('from').'"'.$branch; $group = 'orders.odate'; }
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = 'sum(joborders.joprice) as total,month(orders.odate) as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where year(orders.odate) = '.date('Y').' and month(orders.odate) >= "'.set_value('from').'"'.$branch; $group = 'month(orders.odate)'; }
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = 'sum(joborders.joprice) as total,year(orders.odate) as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where year(orders.odate) >= "'.set_value('from').'"'.$branch; $group = 'year(orders.odate)'; }
				}
				elseif(set_value('to') != '')
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = 'sum(joborders.joprice) as total,orders.odate as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where orders.odate <= "'.set_value('to').'"'.$branch; $group = 'orders.odate'; }
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = 'sum(joborders.joprice) as total,month(orders.odate) as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where year(orders.odate) = '.date('Y').' and month(orders.odate) <= "'.set_value('to').'"'.$branch; $group = 'month(orders.odate)'; }
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = 'sum(joborders.joprice) as total,year(orders.odate) as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where year(orders.odate) <= "'.set_value('to').'"'.$branch; $group = 'year(orders.odate)'; }
				}
				else
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = 'sum(joborders.joprice) as total,orders.odate as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where orders.odate <> "0000-00-00"'.$branch; $group = 'orders.odate'; }
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = 'sum(joborders.joprice) as total,month(orders.odate) as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where year(orders.odate) = '.date('Y').' and month(orders.odate) <> "00"'.$branch; $group = 'month(orders.odate)'; }
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = 'sum(joborders.joprice) as total,year(orders.odate) as date'; $where .= 'inner join joborders on orders.oid = joborders.jooid'.$join.' where year(orders.odate) <> "00"'.$branch; $group = 'year(orders.odate)'; }
				}
				$where .= ' group by '.$group.' order by '.$group.' ASC';
				$data['data'] = $this->Admin_mo->rate($select,'orders',$where);
				$this->load->view('admin/outcomes_pdf',$data);
			}
		}
		else redirect('home', 'refresh');
	}
	
	public function stores()
	{
		if(strpos($this->session->userdata('privileges'), 'itreport') !== false)
		{
		$data = $this->notifys();
		$data['title'] = 'itemtypes';
		$data['admessage'] = '';
		$this->lang->load('reports', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['stores'] = $this->Admin_mo->get('itemtypes');
		$this->load->view('headers/reports',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/stores',$data);
		$this->load->view('footers/reports');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else redirect('home', 'refresh');
	}
	
	public function stores_pdf()
	{
		if(strpos($this->session->userdata('privileges'), 'itreport') !== false)
		{
			if(set_value('store') == '0') $where = array();
			else $where = array('items.iitid'=>set_value('store'));
			$data['data'] = $this->Admin_mo->getjoinLeftLimit('items.*,itemtypes.itname as type,itemmodels.imname as model,delegates.dname as delegate,users.uname as user','items',array('itemtypes'=>'items.iitid=itemtypes.itid', 'itemmodels'=>'items.iimid=itemmodels.imid', 'delegates'=>'items.idid=delegates.did', 'users'=>'items.iuid=users.uid'),$where,'items.iitid,items.iimid ASC','');
			if(!empty($data['data']))
			{
				$data['admessage'] = '';
				$this->lang->load('reports', 'arabic');
				$this->lang->load('items', 'arabic');
				$this->lang->load('keys', 'arabic');
				$this->lang->load('menu', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				$this->load->view('admin/stores_pdf',$data);
			}
			else redirect('reports/stores', 'refresh');
		}
		else redirect('home', 'refresh');
	}
	
	public function bills()
	{
		if(strpos($this->session->userdata('privileges'), 'breport') !== false)
		{
		$data = $this->notifys();
		$data['title'] = 'bills';
		$data['admessage'] = '';
		$this->lang->load('reports', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['branches'] = $this->Admin_mo->get('branches');
		$this->load->view('headers/reports',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/billsr',$data);
		$this->load->view('footers/reports');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else redirect('home', 'refresh');
	}

	public function bills_pdf()
	{
		if(strpos($this->session->userdata('privileges'), 'breport') !== false)
		{
			$this->form_validation->set_rules('type', 'Type' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				redirect('reports/bills', 'refresh');
			}
			else
			{
				$data['admessage'] = '';
				$where = '';
				$this->lang->load('reports', 'arabic');
				$this->lang->load('bills', 'arabic');
				$this->lang->load('keys', 'arabic');
				$this->lang->load('menu', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				
				if(set_value('branch') != 0) $branch = ' and orders.obcid = '.set_value('branch'); else $branch = '';
				$myselect = 'joborders.joiid as joiid,joborders.joitem as joitem,joborders.joprice as joprice,joborders.joquantity as joquantity,users.uname as employee,users.uphone as uphone,customers.cname as customer,customers.cphone as cphone,items.iname as item,items.icode as icode,branches.bcid as branch,bills.bid as bid,bills.btotal as total,bills.bdiscount as discount,bills.bpay as pay,bills.brest as rest,bills.bcode as code,bills.bpaytype as paytype,bills.btype as type,bills.boid as oid,bills.btime as time,bills.notes as notes';
				$join = 'LEFT OUTER JOIN users on bills.beid = users.uid LEFT OUTER JOIN joborders on bills.boid = joborders.jooid LEFT OUTER JOIN items on joborders.joiid = items.iid LEFT OUTER JOIN orders on bills.boid = orders.oid LEFT OUTER JOIN customers on orders.ocid = customers.cid LEFT OUTER JOIN branches on orders.obcid = branches.bcid';
				if(set_value('from') != '' && set_value('to') != '' && set_value('from') <= set_value('to'))
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',bills.bdate as date'; $where .= $join.' where bills.bdate between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; /*$group = 'bills.bdate'; */}
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) = '.date('Y').' and month(bills.bdate) between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; /*$group = 'month(bills.bdate)'; */}
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; /*$group = 'year(bills.bdate)'; */}
				}
				elseif(set_value('from') != '')
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',bills.bdate as date'; $where .= $join.' where bills.bdate >= "'.set_value('from').'"'.$branch; /*$group = 'bills.bdate'; */}
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) = '.date('Y').' and month(bills.bdate) >= "'.set_value('from').'"'.$branch; /*$group = 'month(bills.bdate)'; */}
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) >= "'.set_value('from').'"'.$branch; /*$group = 'year(bills.bdate)'; */}
				}
				elseif(set_value('to') != '')
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',bills.bdate as date'; $where .= $join.' where bills.bdate <= "'.set_value('to').'"'.$branch; /*$group = 'bills.bdate'; */}
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) = '.date('Y').' and month(bills.bdate) <= "'.set_value('to').'"'.$branch; /*$group = 'month(bills.bdate)'; */}
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) <= "'.set_value('to').'"'.$branch; /*$group = 'year(bills.bdate)'; */}
				}
				else
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',bills.bdate as date'; $where .= $join.' where bills.bdate <> "0000-00-00"'.$branch; /*$group = 'bills.bdate'; */}
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) = '.date('Y').' and month(bills.bdate) <> "00"'.$branch; /*$group = 'month(bills.bdate)'; */}
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(bills.bdate) as date'; $where .= $join.' where year(bills.bdate) <> "00"'.$branch; /*$group = 'year(bills.bdate)'; */}
				}
				//$where .= ' group by '.$group.' order by '.$group.' ASC';
				$bills = $this->Admin_mo->rate($select,'bills',$where);
				if(!empty($bills))
				{
					for($i=0;$i<count($bills);$i++)
					{
						$data['data'][$bills[$i]->bid]['bid'] = $bills[$i]->bid;
						$data['data'][$bills[$i]->bid]['employee'] = $bills[$i]->employee;
						$data['data'][$bills[$i]->bid]['uphone'] = $bills[$i]->uphone;
						$data['data'][$bills[$i]->bid]['customer'] = $bills[$i]->customer;
						$data['data'][$bills[$i]->bid]['cphone'] = $bills[$i]->cphone;
						$data['data'][$bills[$i]->bid]['oid'] = $bills[$i]->oid;
						$data['data'][$bills[$i]->bid]['code'] = $bills[$i]->code;
						$data['data'][$bills[$i]->bid]['time'] = $bills[$i]->time;
						$data['data'][$bills[$i]->bid]['notes'] = $bills[$i]->notes;
						$data['data'][$bills[$i]->bid]['total'] = $bills[$i]->total;
						$data['data'][$bills[$i]->bid]['discount'] = $bills[$i]->discount;
						$data['data'][$bills[$i]->bid]['pay'] = $bills[$i]->pay;
						$data['data'][$bills[$i]->bid]['rest'] = $bills[$i]->rest;
						$data['data'][$bills[$i]->bid]['paytype'] = $bills[$i]->paytype;
						$data['data'][$bills[$i]->bid]['type'] = $bills[$i]->type;
						$data['data'][$bills[$i]->bid]['items'][$i]['item'] = $bills[$i]->item;
						$data['data'][$bills[$i]->bid]['items'][$i]['joitem'] = $bills[$i]->joitem;
						$data['data'][$bills[$i]->bid]['items'][$i]['icode'] = $bills[$i]->icode;
						$data['data'][$bills[$i]->bid]['items'][$i]['price'] = $bills[$i]->joprice;
						$data['data'][$bills[$i]->bid]['items'][$i]['quantity'] = $bills[$i]->joquantity;
					}
					$this->load->view('admin/bills_pdf',$data);
				}
				else redirect('reports/bills', 'refresh');
			}
		}
		else redirect('home', 'refresh');
	}
	
	public function orders()
	{
		if(strpos($this->session->userdata('privileges'), 'oreport') !== false)
		{
		$data = $this->notifys();
		$data['title'] = 'orders';
		$data['admessage'] = '';
		$this->lang->load('reports', 'arabic');
		$this->lang->load('keys', 'arabic');
		$this->lang->load('menu', 'arabic');
		$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
		$data['branches'] = $this->Admin_mo->get('branches');
		$this->load->view('headers/reports',$data);
		$this->load->view('sidemenu',$data);
		$this->load->view('topmenu',$data);
		$this->load->view('admin/ordersr',$data);
		$this->load->view('footers/reports');
		$this->load->view('notifys');
		$this->load->view('messages');
		}
		else redirect('home', 'refresh');
	}

	public function orders_pdf()
	{
		if(strpos($this->session->userdata('privileges'), 'oreport') !== false)
		{
			$this->form_validation->set_rules('type', 'Type' , 'trim|required');
			if($this->form_validation->run() == FALSE)
			{
				$data['admessage'] = 'validation error';
				$_SESSION['time'] = time(); $_SESSION['message'] = 'inputnotcorrect';
				redirect('reports/orders', 'refresh');
			}
			else
			{
				$data['admessage'] = '';
				$where = '';
				$this->lang->load('reports', 'arabic');
				$this->lang->load('orders', 'arabic');
				$this->lang->load('keys', 'arabic');
				$this->lang->load('menu', 'arabic');
				$data['system'] = $this->Admin_mo->getrow('system',array('id'=>'1'));
				
				if(set_value('branch') != 0) $branch = ' and orders.obcid = '.set_value('branch'); else $branch = '';
				$myselect = 'orders.*,joborders.joiid as joiid,joborders.joitem as joitem,joborders.joprice as joprice,joborders.joquantity as joquantity,users.uname as employee,users.uphone as uphone,customers.cname as customer,customers.cphone as cphone,items.iname as item,items.icode as icode,branches.bcid as branch,bills.btotal as total';
				$join = 'LEFT OUTER JOIN users on orders.ouid = users.uid LEFT OUTER JOIN joborders on orders.oid = joborders.jooid LEFT OUTER JOIN items on joborders.joiid = items.iid LEFT OUTER JOIN bills on orders.oid = bills.boid LEFT OUTER JOIN customers on orders.ocid = customers.cid LEFT OUTER JOIN branches on orders.obcid = branches.bcid';
				if(set_value('from') != '' && set_value('to') != '' && set_value('from') <= set_value('to'))
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',orders.odate as date'; $where .= $join.' where orders.odate between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; /*$group = 'orders.odate'; */}
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(orders.odate) as date'; $where .= $join.' where year(orders.odate) = '.date('Y').' and month(orders.odate) between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; /*$group = 'month(orders.odate)'; */}
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(orders.odate) as date'; $where .= $join.' where year(orders.odate) between "'.set_value('from').'" and "'.set_value('to').'"'.$branch; /*$group = 'year(orders.odate)'; */}
				}
				elseif(set_value('from') != '')
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',orders.odate as date'; $where .= $join.' where orders.odate >= "'.set_value('from').'"'.$branch; /*$group = 'orders.odate'; */}
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(orders.odate) as date'; $where .= $join.' where year(orders.odate) = '.date('Y').' and month(orders.odate) >= "'.set_value('from').'"'.$branch; /*$group = 'month(orders.odate)'; */}
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(orders.odate) as date'; $where .= $join.' where year(orders.odate) >= "'.set_value('from').'"'.$branch; /*$group = 'year(orders.odate)'; */}
				}
				elseif(set_value('to') != '')
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',orders.odate as date'; $where .= $join.' where orders.odate <= "'.set_value('to').'"'.$branch; /*$group = 'orders.odate'; */}
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(orders.odate) as date'; $where .= $join.' where year(orders.odate) = '.date('Y').' and month(orders.odate) <= "'.set_value('to').'"'.$branch; /*$group = 'month(orders.odate)'; */}
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(orders.odate) as date'; $where .= $join.' where year(orders.odate) <= "'.set_value('to').'"'.$branch; /*$group = 'year(orders.odate)'; */}
				}
				else
				{
					if(set_value('type') == 'D') { $data['type'] = 'daily'; $select = $myselect.',orders.odate as date'; $where .= $join.' where orders.odate <> "0000-00-00"'.$branch; /*$group = 'orders.odate'; */}
					elseif(set_value('type') == 'M') { $data['type'] = 'monthly'; $select = $myselect.',month(orders.odate) as date'; $where .= $join.' where year(orders.odate) = '.date('Y').' and month(orders.odate) <> "00"'.$branch; /*$group = 'month(orders.odate)'; */}
					elseif(set_value('type') == 'Y') { $data['type'] = 'yearly'; $select = $myselect.',year(orders.odate) as date'; $where .= $join.' where year(orders.odate) <> "00"'.$branch; /*$group = 'year(orders.odate)'; */}
				}
				//$where .= ' group by '.$group.' order by '.$group.' ASC';
				$orders = $this->Admin_mo->rate($select,'orders',$where);
				if(!empty($orders))
				{
					for($i=0;$i<count($orders);$i++)
					{
						$data['data'][$orders[$i]->oid]['oid'] = $orders[$i]->oid;
						$data['data'][$orders[$i]->oid]['employee'] = $orders[$i]->employee;
						$data['data'][$orders[$i]->oid]['uphone'] = $orders[$i]->uphone;
						$data['data'][$orders[$i]->oid]['customer'] = $orders[$i]->customer;
						$data['data'][$orders[$i]->oid]['cphone'] = $orders[$i]->cphone;
						$data['data'][$orders[$i]->oid]['code'] = $orders[$i]->ocode;
						$data['data'][$orders[$i]->oid]['time'] = $orders[$i]->otime;
						$data['data'][$orders[$i]->oid]['notes'] = $orders[$i]->notes;
						$data['data'][$orders[$i]->oid]['total'] = $orders[$i]->total;
						$data['data'][$orders[$i]->oid]['items'][$i]['item'] = $orders[$i]->item;
						$data['data'][$orders[$i]->oid]['items'][$i]['joitem'] = $orders[$i]->joitem;
						$data['data'][$orders[$i]->oid]['items'][$i]['icode'] = $orders[$i]->icode;
						$data['data'][$orders[$i]->oid]['items'][$i]['price'] = $orders[$i]->joprice;
						$data['data'][$orders[$i]->oid]['items'][$i]['quantity'] = $orders[$i]->joquantity;
					}
					?><pre><?php //print_r($data['data']); ?></pre><?php 
					$this->load->view('admin/orders_pdf',$data);
				}
				else redirect('reports/orders', 'refresh');
			}
		}
		else redirect('home', 'refresh');
	}

	public function addNotify($user,$section,$action,$where)
	{
		$nusers= $this->Admin_mo->rate('uid','users',$where);
		if(!empty($nusers))
		{
			foreach($nusers as $nuser)
			{
				$this->Admin_mo->set('logsystem', array('user'=>$user, 'notifyuser'=>$nuser->uid, 'section'=>$section, 'action'=>$action, 'time'=>time()));
			}
		}
	}
	
	public function getUnreadNotify($user,$section)
	{
		$result = $this->Admin_mo->getjoinLeftLimit('logsystem.*,users.username as user','logsystem',array('users'=>'logsystem.user=users.uid'),'notifyuser = '.$user.' and section like "'.$section.'"','logsystem.time DESC',15);
		if(!empty($result)) { $count = $this->Admin_mo->rate('count(id) as count','logsystem',' where notifyuser = '.$user.' and section like "'.$section.'" and seen = 0'); $result['count'] = $count[0]->count; }
		return $result;
	}
	
	public function notifys()
	{
		$arr = array();
		if($this->session->userdata('branch') != '')
		{
			$arr['unreadBLs'] = $this->getUnreadNotify($this->session->userdata('uid'),'BL%');
			$arr['unreadORs'] = $this->getUnreadNotify($this->session->userdata('uid'),'OR%');
			$arr['unreadJOs'] = $this->getUnreadNotify($this->session->userdata('uid'),'JO%');
		}
		if($this->session->userdata('store') != '')
		{
			$arr['unreadPVs'] = $this->getUnreadNotify($this->session->userdata('uid'),'PV%');
		}
		$arr['unreadNTs'] = $this->getUnreadNotify($this->session->userdata('uid'),'');
		return $arr;
	}
}