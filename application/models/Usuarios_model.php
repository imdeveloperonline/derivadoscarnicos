<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	/*public $variable;*/

	public function __construct()
	{
		
		parent::__construct();
		
	}

	public function get_users()
	{
		if($_SESSION['profile'] != 1) {
			$and_where = " AND user_profile_id != 1";
		} else {
			$and_where = "";
		}
		$query = $this->db->query('SELECT user.id, user.name, lastname, position, phone, email, creation_date, regional_id, user_profile_id, block, regional.name AS regional_name FROM user LEFT JOIN regional ON user.regional_id = regional.id WHERE user.deleted = 0'.$and_where.'');
		return $query;
	}

	public function get_user($id)
	{
		$query = $this->db->query('SELECT user.id, user.name, lastname, position, phone, email, creation_date, regional_id, user_profile_id, user_profile.name AS user_profile_name, block, regional.name AS regional_name FROM user LEFT JOIN regional ON user.regional_id = regional.id LEFT JOIN user_profile ON user.user_profile_id = user_profile.id WHERE user.deleted = 0 AND user.id = ?',array($id));
		return $query;
	}

	public function update_user ($array, $id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		return $this->db->update('user', $array);
	}

	public function access_user ($id,$block)
	{
		$this->db->where('id', $id);
		$this->db->update('user', array("block" => $block));
	}

	public function delete_user ($id)
	{
		$this->db->where('id', $id);
		$this->db->update('user', array("block" => 1, "deleted" => 1));
	}

	public function get_last_user ()
	{
		$query = $this->db->query('SELECT user.id, user.name, lastname, position, phone, email, creation_date, regional_id, user_profile_id, user_profile.name AS user_profile_name, block, regional.name AS regional_name FROM user LEFT JOIN regional ON user.regional_id = regional.id LEFT JOIN user_profile ON user.user_profile_id = user_profile.id WHERE user.deleted = 0 ORDER BY user.id DESC LIMIT 1');
		return $query;
	}

	public function get_regionales() {

		$query = $this->db->query('SELECT id, name FROM regional WHERE deleted = 0');
		return $query;

	}

	public function get_profiles() {

		$query = $this->db->query('SELECT id, name FROM user_profile');
		return $query;

	}

	public function new_user($array) {
 
 		$array = $this->security->xss_clean($array);
		$this->db->insert('user',$array);
		return $this->db->insert_id();

	}

	public function exist_email($email) {

		$query = $this->db->query('SELECT * FROM user WHERE email = "' . $email . '" LIMIT 1');
		return $query->num_rows();

	}

	public function get_connections($id)
	{
		$query = $this->db->query('SELECT connection.id, date, active, name, lastname, email, ip, so, agent FROM user LEFT JOIN connection ON user.id = connection.user_id WHERE user.id = ?',array($id));
		return $query;
	}


	public function set_user_operation($array)
	{
		$this->db->insert('user_operation', $array);
	}

	public function get_users_alert()
	{
		$query = $this->db->query('SELECT user_id, email FROM user_alert INNER JOIN user ON user.id = user_alert.user_id');
		return $query;
	}

	public function set_users_alert($array)
	{
		$this->db->truncate('user_alert');
		$this->db->insert_batch('user_alert', $array);
	}

	public function check_pass()
	{
		$query = $this->db->query('SELECT pass FROM user WHERE id = ?',array($_SESSION['id']));
		return $query;
	}

	public function update_pass($pass)
	{
		$this->db->where('id', $_SESSION['id']);
		$this->db->update('user', array("pass" => $pass));
	}
}

/* End of file Usuarios_model */
/* Location: ./application/models/Usuarios_model */
