<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frigorificos_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_shambles()
	{
		if($_SESSION['profile'] == 1 || $_SESSION['profile'] == 2) {
			$query = $this->db->query('SELECT shamble.id, shamble.tradename, rut, phone, email, address, zip, city.name AS city_name, department.name AS department_name FROM shamble INNER JOIN city ON shamble.city_id = city.id INNER JOIN department ON department.id = city.department_id WHERE shamble.deleted = 0');
		} else {
			$regional = $this->db->query('SELECT department_id FROM regional INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE regional.id = ?',array($_SESSION['regional']));
			$department_id = $regional->result_array()[0]['department_id'];

			$query = $this->db->query('SELECT shamble.id, shamble.tradename, rut, phone, email, address, zip, city.name AS city_name, department.name AS department_name FROM shamble INNER JOIN city ON shamble.city_id = city.id INNER JOIN department ON department.id = city.department_id WHERE shamble.deleted = 0 AND department_id = ?',array($department_id));
		}
		return $query;
	}

	public function get_last_shamble ()
	{
		$query = $this->db->query('SELECT shamble.id, shamble.tradename, shamble.rut, shamble.email, shamble.phone, shamble.address, shamble.zip, city.name AS city_name FROM shamble INNER JOIN city ON shamble.city_id = city.id WHERE shamble.deleted = 0 ORDER BY shamble.id DESC LIMIT 1');
		return $query;
	}

	public function new_shamble($array) {
 
 		$array = $this->security->xss_clean($array);
		$this->db->insert('shamble',$array);
		return $this->db->insert_id();

	}

	public function exist_shamble_rut($shamble_rut) {

		$query = $this->db->query('SELECT id FROM shamble WHERE rut = "' . $shamble_rut . '" LIMIT 1');
		return $query->num_rows();

	}

	public function get_shamble ($shamble_id)
	{
		$query = $this->db->query('SELECT shamble.id, shamble.tradename, shamble.rut, shamble.email, shamble.phone, shamble.address, shamble.zip, shamble.city_id AS shamble_city_id, city.department_id, department.country_id, city.name AS city_name, department.name AS department_name, country.name AS country_name FROM shamble INNER JOIN city ON shamble.city_id = city.id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id WHERE shamble.deleted = 0 AND shamble.id = ? LIMIT 1',array($shamble_id));
		return $query;
	}

	public function update_shamble ($array, $id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		$this->db->update('shamble', $array);
	}

	public function delete_shamble ($id)
	{
		$this->db->where('id', $id);
		$this->db->update('shamble', array("deleted" => 1));
	}

	public function get_shamble_persons($shamble_id)
	{
		$query = $this->db->query('SELECT shamble.id, tradename, person_id, person_name, person_lastname, person_phone, person_email, person_position FROM shamble LEFT JOIN (SELECT id AS person_id, shamble_id, name AS person_name, lastname AS person_lastname, phone AS person_phone, email AS person_email, position AS person_position FROM person_shamble WHERE deleted = 0) AS person_table ON shamble.id = person_table.shamble_id WHERE shamble.id = ?',array($shamble_id));
		return $query->result_array();
	}

	public function new_person_shamble($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('person_shamble', $array);
		return $this->db->insert_id();
	}

	public function delete_shamble_person($person_shamble_id)
	{
		$this->db->where('id', $person_shamble_id);
		$this->db->update('person_shamble', array("deleted" => 1));
	}

	public function update_shamble_person($array, $id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		$this->db->update('person_shamble', $array);
	}

}

/* End of file Frigorificos_model.php */
/* Location: ./application/models/Frigorificos_model.php */