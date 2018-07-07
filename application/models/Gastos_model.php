<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gastos_model extends CI_Model {

	private $regional_filter = "";
	
	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('profile') != 1){
			$this->regional_filter = " WHERE regional_id = ".$this->session->userdata('regional');
		} 
		
	}

	public function get_outgoes()
	{
		$query = $this->db->query('SELECT outgo.id,  date,  amount,  detail,  type_outgo_id, type_outgo.name AS type_outgo,  user_id,  outgo.regional_id, regional.name AS regional_name, file_name FROM outgo INNER JOIN type_outgo ON type_outgo.id = outgo.type_outgo_id INNER JOIN regional ON regional.id = outgo.regional_id LEFT JOIN outgo_img ON outgo_img.outgo_id = outgo.id WHERE outgo.regional_id = ?',array($_SESSION['regional']));
		return $query;
	}

	public function get_generals_outgoes()
	{
		$query = $this->db->query('SELECT general_outgo.id,  date,  amount,  detail,  type_outgo_id, type_outgo.name AS type_outgo FROM general_outgo INNER JOIN type_outgo ON type_outgo.id = general_outgo.type_outgo_id');
		return $query;
	}

	public function get_outgo_types()
	{
		$query = $this->db->query('SELECT id, name FROM type_outgo WHERE deleted = 0');
		return $query;
	}

	public function get_all_outgo_types()
	{
		$query = $this->db->query('SELECT id, name, deleted FROM type_outgo');
		return $query;
	}

	public function set_outgo($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('outgo', $array);
		return $this->db->insert_id();
	}

	public function set_general_outgo($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('general_outgo', $array);
		return $this->db->insert_id();
	}

	public function get_last_outgo()
	{
		$query = $this->db->query('SELECT outgo.id,  date,  amount,  detail,  type_outgo_id, type_outgo.name AS type_outgo,  user_id,  regional_id, regional.name AS regional_name FROM outgo INNER JOIN type_outgo ON type_outgo.id = outgo.type_outgo_id INNER JOIN regional ON regional.id = outgo.regional_id ORDER BY id DESC LIMIT 1');
		return $query;
	}

	public function get_last_general_outgo()
	{
		$query = $this->db->query('SELECT general_outgo.id,  date,  amount,  detail,  type_outgo_id, type_outgo.name AS type_outgo FROM general_outgo INNER JOIN type_outgo ON type_outgo.id = general_outgo.type_outgo_id ORDER BY general_outgo.id DESC LIMIT 1');
		return $query;
	}

	public function set_selectable_outgo($id, $selectable)
	{
		$this->db->where('id', $id);
		$this->db->update('type_outgo', array("deleted" => $selectable));
	}

	public function exist_type_outgo_name($name)
	{
		$query = $this->db->query('SELECT id FROM type_outgo WHERE name = ? COLLATE utf8_bin', array($name));
		return $query->num_rows();
	}

	public function update_outgo_type($id, $name)
	{
		$name = $this->security->xss_clean($name);
		$this->db->where('id', $id);
		$this->db->update('type_outgo', array("name" => $name));
	}

	public function set_outgo_type($name)
	{
		$name = $this->security->xss_clean($name);
		$this->db->insert('type_outgo', array("name" => $name, "deleted" => 0));
		return $this->db->insert_id();
	}

	public function get_last_outgo_type()
	{
		$query = $this->db->query('SELECT id, name, deleted FROM type_outgo ORDER BY id DESC LIMIT 1');
		return $query;		
	}

	public function set_outgo_img($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('outgo_img', $array);
		return $this->db->insert_id();
	}

	public function get_outgoes_imgs()
	{
		$query = $this->db->query('SELECT outgo_img.id, title, description, file_name, regional.name AS regional_name FROM outgo_img LEFT JOIN regional ON regional.id = outgo_img.regional_id WHERE regional_id = ?',array($_SESSION['regional']));
		return $query;
	}

	public function get_outgo_by_id($outgo_id,$is_general =  "")
	{
		if($is_general == 1) {
			$query = $this->db->query('SELECT general_outgo.id,  date,  amount,  detail,  type_outgo_id, type_outgo.name AS type_outgo FROM general_outgo INNER JOIN type_outgo ON type_outgo.id = general_outgo.type_outgo_id WHERE general_outgo.id = ?',array($outgo_id));
			return $query;
		} else {
			$query = $this->db->query('SELECT outgo.id,  date,  amount,  detail,  type_outgo_id, type_outgo.name AS type_outgo,  user_id,  regional_id, regional.name AS regional_name FROM outgo INNER JOIN type_outgo ON type_outgo.id = outgo.type_outgo_id INNER JOIN regional ON regional.id = outgo.regional_id WHERE outgo.id = ?',array($outgo_id));
			return $query;
		}
	}

	public function update_outgo($id,$array,$is_general)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		if($is_general == 1) {
			return $this->db->update('general_outgo', $array);
		} else {
			return $this->db->update('outgo', $array);
		}
	}

}

/* End of file Gastos_model.php */
/* Location: ./application/models/Gastos_model.php */