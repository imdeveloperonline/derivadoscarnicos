<?php
if (!defined( 'BASEPATH')) exit('No direct script access allowed'); 
class Login
{
 private $ci;
 public function __construct()
 {
 $this->ci = &get_instance();
 !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
 !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
 } 
 
	public function check_login()
	{
	 	$uri = $_SERVER["REQUEST_URI"];

	 	if(preg_match("/\bcron_alert\b/i",$uri)){
			
		} else {
			if(!isset($_SESSION['logged']) && !isset($_COOKIE['SID_ADM_APP']))
			 {
			 	$this->ci->session->set_flashdata('no-logged',1);
			 	redirect(base_url('login'));
			 } 		 
	 	}

	}
}
/*
/end hooks/home.php
*/