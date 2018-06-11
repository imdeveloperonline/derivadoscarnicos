<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tutorial extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$dato['page'] = "tutorial";
		$this->load->view('home',$dato);
	}

}

/* End of file Tutorial.php */
/* Location: ./application/controllers/Tutorial.php */