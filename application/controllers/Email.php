<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->library("email");
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'martinrmf@gmail.com',
			'smtp_pass' => 'Password.2015',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
			);    
 
		 //cargamos la configuración para enviar con gmail
		 $this->email->initialize($configGmail);
		 
		 $this->email->from('info@derivadoscarnicos.com');
		 $this->email->to("martinrmf@gmail.com");
		 $this->email->subject('Otra prueba');
		 $this->email->message('<h2>Enviando emails</h2><hr><br>');
		 $this->email->send();
		 //con esto podemos ver el resultado
		 /*var_dump($this->email->print_debugger());*/
		 if(! $this->email->send()) {
		 	echo "no se envio";
		 } else {
		 	echo "Su mensaje ha sido enviado";
		 }
	}

	public function phpmailer()
	{
		$this->load->library("phpmailer_library");

        $this->phpmailer_library->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->phpmailer_library->SMTPDebug = 2;
        //Set the hostname of the mail server
        $this->phpmailer_library->Host = 'smtp.gmail.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $this->phpmailer_library->Port = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $this->phpmailer_library->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $this->phpmailer_library->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $this->phpmailer_library->Username = "martinrmf@gmail.com";
        //Password to use for SMTP authentication
        $this->phpmailer_library->Password = "Password.2015";
		
		$this->phpmailer_library->CharSet="UTF-8";                             // TCP port to connect to

		$this->phpmailer_library->From = 'contacto@encargate.org';
		$this->phpmailer_library->FromName = 'Encargate WebSite';
		$this->phpmailer_library->addAddress('martinrmf@gmail.com');     // Add a recipient
		$this->phpmailer_library->addReplyTo('contacto@encargate.org');
		//$mail->addCC('info@tucanoagenciadigital.com');
		// $mail->addBCC('martinrmf@gmail.com');

		// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$this->phpmailer_library->isHTML(true);                                  // Set email format to HTML

		$this->phpmailer_library->Subject = 'Contacto www.encargate.org';
		$this->phpmailer_library->Body    = '<b>Tienes una nueva solicitud en tu página web</b><br><br>Nombre: <br>Correo: <br>Télefono: <br>Solicitud: <br><br>';
		// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$this->phpmailer_library->send()) {
			echo "<p style='color: #dc0f0f; text-align: right'>No pudimos enviar su mensaje</p>";
		} else {
			echo "<p style='color: #2CBE2C; text-align: right'>Su mensaje ha sido enviado</p>";
		}
		/*namespace PHPMailer\PHPMailer;*/
	}

}

/* End of file Email.php */
/* Location: ./application/controllers/Email.php */