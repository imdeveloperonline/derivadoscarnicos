<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_mail extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->library("email");

		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.imdeveloper.me',
			'smtp_port' => 587,
			'smtp_user' => 'martin@imdeveloper.me',
			'smtp_pass' => 'Password.2016',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
			);  
 		/*Load configuration*/
		 $this->email->initialize($configGmail);
		 
		 $this->email->from('martin@imdeveloper.me');
		 $this->email->to("martinrmf@gmail.com");
		 $this->email->subject('Alerta de Derivados Cárnicos');

		 $this->email->message('Hola');
		 
		 /*var_dump($this->email->print_debugger());*/
		 if($this->email->send()) {
		 	echo "Send";
		 } else {
		 	echo "Not Send";
		 }
	}

}

/* End of file Send_mail.php */
/* Location: ./application/controllers/Send_mail.php */