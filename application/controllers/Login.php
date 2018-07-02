<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model');
	}

	public function index()
	{

		if (isset($_COOKIE['SID_ADM_APP'])){

			$query = $this->Login_model->verify_connection(array($_COOKIE['SID_ADM_APP']));
			$resultado = $query->result_array();
			$status_connection = $resultado[0]['active'];

			if($status_connection == 1){

				foreach ($resultado as $key => $value) {
					$userdata = array(
							'id' => $value['id'],
					        'name'  => $value['name'],
					        'lastname' => $value['lastname'],
					        'email'     => $value['email'],
					        'profile' => $value['user_profile_id'],
					        'regional' => $value['regional_id'],
					        'regional_name' => $value['regional_name'],
					        'logged' => TRUE
					);
				}				

				$this->session->set_userdata($userdata);

				$connection = array(
						'date' => date('Y-m-d H:i:s'), 
						'user_id' => $_SESSION['id'], 
						'agent' => $this->agent->browser().' '.$this->agent->version(),
						'so' => $this->agent->platform(),
						'ip' => $this->input->ip_address(),
						'active' => 1
					);
				$query_connection = $this->Login_model->set_connection($connection);

			} 
			redirect('dashboard');
		}else{
			session_destroy();
			$this->load->view('login');
		}
		
		
	}

	public function signin() {

		$data = $_POST['data'];

		/******************  ReCaptcha Functions  *********************/
		/*$post = array(
		    'secret' => '6LcLS0cUAAAAAJRXSJxpKetPA-JvQ5KmYlEuAkdt',
		    'response' => $data['response']
		);
		function httpPost($url, $curl_data)
		{
		    $curl = curl_init($url);
		    curl_setopt($curl, CURLOPT_POST, true);
		    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($curl_data));
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    $response = curl_exec($curl);
		    curl_close($curl);
		    return $response;
		}
				
		$captcha = httpPost("https://www.google.com/recaptcha/api/siteverify", $post);
		$captcha = json_decode($captcha);

		if($captcha->success == false)
		{          
		   ?>
			<div id="message" class="alert alert-block alert-danger"><p>Protegido por ReCaptcha</p></div>
			<?php

			exit();
		}

		unset($data['response']);*/
		/****************** End ReCaptcha Functions  *********************/


		/*Remember session*/
		$remember = $data['remember'];
		unset($data['remember']);
		/*Unset pass for avoid query error*/
		$pass = $data['pass'];
		unset($data['pass']);	
	

		/*Query*/
		$query = $this->Login_model->signin($data);



		if($query->num_rows() > 0){
			/*Denegar acceso si está bloqueado*/
			if($query->result_array()[0]['block'] == 1 ) {
				?>
				<div id="message" class="alert alert-block alert-danger"><p>Su usuario ha sido bloqueado. Contacte al administrador</p></div>
				<?php

				exit();
			}
			/*Denegar acceso si está bloqueado*/

			foreach ($query->result_array() as $key => $value) {
				$hash = $value['pass'];
			}

			if(password_verify($pass,$hash)) {

				foreach ($query->result_array() as $key => $value) {
					$userdata = array(
							'id' => $value['id'],
					        'name'  => $value['name'],
					        'lastname' => $value['lastname'],
					        'email'     => $value['email'],
					        'profile' => $value['user_profile_id'],
					        'regional' => $value['regional_id'],
					        'regional_name' => $value['regional_name'],
					        'logged' => TRUE
					);
				}				

				$this->session->set_userdata($userdata);

				$connection = array(
						'date' => date('Y-m-d H:i:s'), 
						'user_id' => $_SESSION['id'], 
						'agent' => $this->agent->browser().' '.$this->agent->version(),
						'so' => $this->agent->platform(),
						'ip' => $this->input->ip_address(),
						'active' => $remember
					);

				$query_connection = $this->Login_model->set_connection($connection);
				$resultado = $query_connection->result_array();
				$session_id = $resultado[0]['id'];

				if($remember == 1){
					setcookie('SID_ADM_APP', $session_id, time()+60*60*24*30, '/');
				}else{
					setcookie('SID_ADM_APP', $session_id,0,'/');
				}

				$this->Login_model->reset_fails($data['email']);

				?>
					<div id="message" class="alert alert-block alert-success"><p>BIENVENIDO</p></div>
					<script>
						setTimeout(function(){
							location.href="<?= base_url() ?>dashboard";
						},1500);
					</script>
				<?php

			}else{


				$query = $this->Login_model->check_fails($data);

				$fails = $query->result_array()[0]['fail'];

				
				$fail = $fails+1;

				if($fail == 3) {
					$this->Login_model->block_user($data['email']);
					$this->Login_model->add_fail($data['email'],$fail);
					?>
					<div id="message" class="alert alert-block alert-danger"><p>Su usuario ha sido bloqueado. Contacte al administrador</p></div>
					<?php
				} else {
					$this->Login_model->add_fail($data['email'],$fail);
					?>
					<div id="message" class="alert alert-block alert-danger"><p>Email o contraseña invalido.<br><i>Su usuario será bloqueado después de 3 intentos fallidos.</i></p></div>
					<?php
				}					
				

			}

		}else{

			?>
				<div id="message" class="alert alert-block alert-danger"><p>Email o contraseña invalido</p></div>
			<?php
		}
		
		


	}

	public function logout()
	{
		session_destroy();
		setcookie('SID_ADM_APP', null, -1, '/');
		redirect('login');
	}

	public function recover_pass()
	{
		$email = $_POST['email'];

		$query = $this->Login_model->check_if_block($email);



		/*Denegar acceso si está bloqueado*/
		if(!empty($query)) {
			if($query->result_array()[0]['block'] == 1 ) {
				?>
				<div id="message" class="alert alert-block alert-danger"><p>Su usuario ha sido bloqueado. Contacte al administrador</p></div>
				<?php

				exit();
			}
		}
		/*Denegar acceso si está bloqueado*/
		
		$this->load->helper('string');
		$recover_pass = random_string('alnum', 16);

		$query = $this->Login_model->set_recover_pass($email, $recover_pass);

		if($this->db->affected_rows() > 0) {

			$select_query = $this->Login_model->get_recover_pass($email);
			$resultado = $select_query->result_array();

			$id = $resultado[0]['id'];

			$sendmail = $this->Login_model->sendmail_recover_pass($email,$id,$recover_pass);

			if($sendmail == TRUE) {
				$query = $this->Login_model->get_user_by_email($email);

				$this->load->model('Usuarios_model', 'users');
				$array = array(
					"date" => date("Y-m-d H:i:s"),
					"record_id" => 0,
					"user_id" => $query->result_array()[0]['id'],
					"operation_id" => 2,
					"table" => "Recuperación de Contraseña"

				);

				$this->users->set_user_operation($array);

			?>
				<div id="message" class="alert alert-block alert-info"><p>Se ha enviado la información de recuperación a su correo electrónico</p></div>
			<?php

			} else {

				?>
				<div id="message" class="alert alert-block alert-danger"><p>Ocurrió un problema al recuperar la contraseña. Si el problema persiste por favor contacte al administrador.</p></div>
				<?php


			}

		}
	}

	public function recover(int $id, string $recover_pass)
	{

		$data['recover_info'] = array($id, $recover_pass);
		$this->load->view('recover-pass',$data);

	}

	public function set_new_pass(int $id, string $recover_pass)
	{
		$new_pass = $_POST['pass'];

		$query = $this->Login_model->set_new_pass($id,$recover_pass,$new_pass);

		if($this->db->affected_rows() > 0) {
			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => 0,
				"user_id" => $id,
				"operation_id" => 2,
				"table" => "Nueva Contraseña"

			);

			$this->users->set_user_operation($array);
			?>
				<div id="message" class="alert alert-block alert-success"><p>Su contraseña fue configurada conrrectamente. Será redirigido en 5 segundos al formulario de ingreso.</p></div>
			<?php
		} else {
			?>
				<div id="message" class="alert alert-block alert-danger"><p>Ocurrió un problema al configurar la  nueva contraseña. Si el problema persiste por favor contacte al administrador.</p></div>
			<?php
		}
	}

	public function set_regional()
	{
		$regional_id = $_POST['id'];

		$this->session->set_userdata("regional",$regional_id);

		echo 1;

	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */