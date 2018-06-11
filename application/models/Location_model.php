<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_cities()
	{
		$query = $this->db->query('SELECT city.id, city.name, department_id, department.name AS department_name, country.name AS country_name FROM city INNER JOIN department ON city.department_id = department.id INNER JOIN country ON country.id = department.country_id ORDER BY city.name ASC');
		return $query;
	}

	public function exist_city($name, $department_id)
	{
		$query = $this->db->query('SELECT id FROM city WHERE department_id = ? AND name = ? COLLATE utf8_bin', array($department_id,$name));
		return $query->num_rows();	
	}

	public function set_city($name, $department_id)
	{
		$name = $this->security->xss_clean($name);
		$this->db->insert('city', array("name" => $name, "department_id" => $department_id));
		return $this->db->insert_id();
	}

	public function update_city($id, $name, $department_id)
	{
		$name = $this->security->xss_clean($name);
		$this->db->where('id', $id);
		$this->db->update('city', array("name" => $name, "department_id" => $department_id));
	}

	public function get_departments()
	{
		$query = $this->db->query('SELECT department.id, department.name, country_id, country.name AS country_name FROM department INNER JOIN country ON country.id = department.country_id ORDER BY name ASC');
		return $query;
	}

	public function exist_department($name, $country_id)
	{
		$query = $this->db->query('SELECT id FROM department WHERE country_id = ? AND name = ? COLLATE utf8_bin', array($country_id,$name));
		return $query->num_rows();	
	}

	public function set_department($name, $country_id)
	{
		$name = $this->security->xss_clean($name);
		$this->db->insert('department', array("name" => $name, "country_id" => $country_id));
		return $this->db->insert_id();
	}

	public function update_department($id, $name, $country_id)
	{
		$name = $this->security->xss_clean($name);
		$this->db->where('id', $id);
		$this->db->update('department', array("name" => $name, "country_id" => $country_id));
		return $this->db->insert_id();
	}

	public function get_countries()
	{
		$query = $this->db->query('SELECT id, name FROM country ORDER BY name ASC');
		return $query;
	}

	public function exist_country($name)
	{
		$query = $this->db->query('SELECT id FROM country WHERE name = ? COLLATE utf8_bin', array($name));
		return $query->num_rows();	
	}

	public function set_country($name)
	{
		$name = $this->security->xss_clean($name);
		$this->db->insert('country', array("name" => $name));
		return $this->db->insert_id();
	}

	public function update_country($id, $name)
	{
		$name = $this->security->xss_clean($name);
		$this->db->where('id', $id);
		$this->db->update('country', array("name" => $name));
	}

	public function get_department_by_id($department_id)
	{
		$query = $this->db->query('SELECT name FROM department WHERE id = ?',array($department_id));
		return $query;
	}

}

/* End of file Location_model.php */
/* Location: ./application/models/Location_model.php */