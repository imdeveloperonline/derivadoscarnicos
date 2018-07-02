<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function signin($array) {

		$sql = 'SELECT user.id, user.name, lastname, email, pass, user_profile_id, regional_id, block, user.deleted, regional.name AS regional_name FROM user INNER JOIN regional ON regional.id = user.regional_id WHERE user.deleted = 0 AND email = ? ORDER BY id DESC LIMIT 1';
		$query = $this->db->query($sql,$array);		
		return $query;

	}

	public function set_connection($array) {

		$this->db->insert('connection', $array);

		$query = $this->db->query('SELECT MAX(id) AS id FROM connection WHERE user_id = ?', array($_SESSION['id']));
		return $query;
	}

	public function verify_connection($array) {

		return $this->db->query('SELECT user.id, user.name, lastname, email, user_profile_id, regional_id, block, user.deleted, active, regional.name AS regional_name FROM connection INNER JOIN user ON user.id = connection.user_id INNER JOIN regional ON regional.id = user.regional_id WHERE connection.id = ?',$array);
	}

	public function set_recover_pass($email, $recover_pass)
	{
		$sql = 'UPDATE user SET recover_pass = "'.$recover_pass.'" WHERE email = ?';
		$query = $this->db->query($sql, array($email));
		return $query;
	}

	public function get_recover_pass($email)
	{
		$query = $this->db->query('SELECT id FROM user WHERE deleted = 0 AND email = ? ORDER BY id DESC LIMIT 1',array($email));
		return $query;

	}

	public function check_fails($email)
	{
		$query = $this->db->query('SELECT fail FROM user WHERE email = ? ORDER BY id DESC LIMIT 1', $email);
		return $query;
	}

	public function block_user($email)
	{
		$this->db->where('email', $email);
		$this->db->update('user', array('block' => 1));
	}

	public function add_fail($email,$fail)
	{
		$this->db->where('email', $email);
		$this->db->update('user', array('fail' => $fail));
	}

	public function reset_fails($email)
	{
		$this->db->where('email', $email);
		$this->db->update('user', array('fail' => 0));
	}

	public function check_if_block($email)
	{
		return $this->db->query('SELECT block FROM user WHERE deleted = 0 AND email = ? ORDER BY id DESC LIMIT 1',$email);
	}

	public function sendmail_recover_pass($email,$id,$recover_pass)
	{
		$this->load->library("email");

		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.derivadoscarnicos.com',
			'smtp_port' => 26,
			'smtp_user' => 'no-reply@derivadoscarnicos.com',
			'smtp_pass' => '71@u[OhS%=}6',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
			);  
 		/*Load configuration*/
		 $this->email->initialize($configGmail);
		 
		 $this->email->from('no-reply@derivadoscarnicos.com');
		 $this->email->to("".$email."");
		 $this->email->subject('Recuperar Contraseña');

		 $link = base_url() . 'login/recover/' . $id . '/' . $recover_pass;
		 $this->email->message('<h2>Información de recuperación de contraseña</h2><br><p>Para recuperar su contraseña haga click en el siguiente enlace y siga las instrucciones:</p><br><br><a href="' .  $link . '">' .  $link . '</a><br><br><p>Si tiene algún para recuperar la contraseña por favor contacte al administrador.</p>');
		 
		 /*var_dump($this->email->print_debugger());*/
		 if($this->email->send()) {
		 	return TRUE;
		 } else {
		 	return FALSE;
		 }
	}

	public function set_new_pass($id,$recover_pass,$new_pass)
	{
		$new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
		$sql = 'UPDATE user SET pass = "'. $new_pass . '", recover_pass = "" WHERE id = ? AND recover_pass = ?';
		$query = $this->db->query($sql,array($id, $recover_pass));
		return $query;
	}

	public function get_last_login() 
	{
		$query = $this->db->query('SELECT date FROM connection WHERE user_id = ? ORDER BY id DESC LIMIT 1,1', array($this->session->userdata('id')));
		return $query->result_array();
	}

	public function get_user_by_email($email)
	{
		$query = $this->db->query('SELECT id FROM user WHERE email = ?',array($email));
		return $query;
	}
}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */