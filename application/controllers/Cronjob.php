<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller {

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
	public function endtime()
	{
		$orders = $this->Admin_mo->getwhere('orders',array('endtime <= '=>time(),'accept != '=>'1'));
		foreach($orders as $order)
		{
			$this->Admin_mo->update('orders', array('accept'=>'5'),array('oid'=>$order->oid));
			$this->Admin_mo->update('bills', array('accept'=>'5'),array('boid'=>$order->oid));
			$this->Admin_mo->update('paymentvouchers', array('accept'=>'5'),array('pvoid'=>$order->oid));
			$this->Admin_mo->update('joborders', array('accept'=>'5'),array('jooid'=>$order->oid));
		}
	}
	
	public function deletelogsystem()
	{
		$this->Admin_mo->del('logsystem',array('seen'=>'1'));
	}
	
	public function dbbackup()
	{
		redirect('../fanarab_pdfs/dbbackup', 'refresh');
	}
}