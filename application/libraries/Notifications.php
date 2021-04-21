<?php
class Notifications {
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function addNotify($user,$section,$action,$where)
	{
		$this->CI->load->model('Admin_mo');
		$nusers= $this->CI->Admin_mo->rate('uid','users',$where);
		if(!empty($nusers))
		{
			foreach($nusers as $nuser)
			{
				$this->CI->Admin_mo->set('logsystem', array('user'=>$user, 'notifyuser'=>$nuser->uid, 'section'=>$section, 'action'=>$action, 'time'=>time()));
			}
		}
	}
	
	public function getUnreadNotify($user,$section)
	{
		$this->CI->load->model('Admin_mo');
		$result = $this->CI->Admin_mo->getjoinLeftLimit('logsystem.*,users.username as user,users.uimage as image','logsystem',array('users'=>'logsystem.user=users.uid'),'notifyuser = '.$user.' and section like "'.$section.'"','logsystem.time DESC',9);
		if(!empty($result)) { $count = $this->CI->Admin_mo->rate('count(id) as count','logsystem',' where notifyuser = '.$user.' and section like "'.$section.'" and seen = 0'); $result['count'] = $count[0]->count; }
		return $result;
	}
	
	public function notifys($branch,$store,$user)
	{
		$arr = array();
		if($branch != '')
		{
			$arr['unreadBLs'] = $this->getUnreadNotify($user,'BL%');
			$arr['unreadORs'] = $this->getUnreadNotify($user,'OR%');
			$arr['unreadJOs'] = $this->getUnreadNotify($user,'JO%');
		}
		if($store != '')
		{
			$arr['unreadPVs'] = $this->getUnreadNotify($user,'PV%');
		}
		$arr['unreadNTs'] = $this->getUnreadNotify($user,'');
		return $arr;
	}
}
?>