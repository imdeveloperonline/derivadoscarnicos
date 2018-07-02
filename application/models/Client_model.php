<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model {

	//public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function set_new_client($array = "") {

		$array = $this->security->xss_clean($array);
		$this->db->insert('client',$array);
		return $this->db->insert_id();;

	}

	public function exist_client_rut($client_rut) {

		$query = $this->db->query('SELECT id FROM client WHERE rut = "' . $client_rut . '" LIMIT 1');
		return $query->num_rows();

	}

	public function get_clients($array = "") {
		$sql = "SELECT client.id, client.tradename, person_id, person_name, person_lastname, person_phone, person_email, city.name AS city_name, department.name AS department_name FROM client LEFT JOIN (SELECT id AS person_id, name AS person_name, lastname AS person_lastname, phone AS person_phone, email AS person_email, client_id FROM `person_client` WHERE deleted = 0) AS persons ON client.id = persons.client_id INNER JOIN city ON client.city_id = city.id INNER JOIN department ON department.id = city.department_id WHERE client.deleted = 0 GROUP BY client.id";
		$query = $this->db->query($sql);
		return $query;
	}

	public function get_last_client ()
	{
		$query = $this->db->query('SELECT client.id, client.tradename, person_id, person_name, person_lastname, person_phone, person_email, city.name AS city_name FROM client LEFT JOIN (SELECT id AS person_id, name AS person_name, lastname AS person_lastname, phone AS person_phone, email AS person_email, client_id FROM `person_client` WHERE deleted = 0) AS persons ON client.id = persons.client_id INNER JOIN city ON client.city_id = city.id WHERE client.deleted = 0 ORDER BY client.id DESC LIMIT 1');
		return $query;
	}

	public function update_client_person($array, $id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		$this->db->update('person_client', $array);
	}

	public function delete_client_person($person_client_id)
	{
		$this->db->where('id', $person_client_id);
		$this->db->update('person_client', array("deleted" => 1));
	}

	public function get_client_persons($client_id)
	{
		$query = $this->db->query('SELECT client.id AS client_id, tradename AS client_name, person_id, person_name, person_lastname, person_phone, person_email, person_position FROM client LEFT JOIN (SELECT id AS person_id, client_id, name AS person_name, lastname AS person_lastname, person_client.phone AS person_phone, person_client.email AS person_email, position AS person_position FROM person_client WHERE deleted = 0) AS person_table ON client.id = person_table.client_id WHERE client.id = ?',array($client_id));
		return $query->result_array();
	}

	public function get_client ($client_id)
	{
		$query = $this->db->query('SELECT client.id, tradename, rut, email, phone, zip, address, client.city_id AS client_city_id, city.name AS city_name, city.department_id, department.name AS department_name, department.country_id, country.name AS country_name FROM client INNER JOIN city ON client.city_id = city.id INNER JOIN department ON city.department_id = department.id INNER JOIN country ON department.country_id = country.id WHERE deleted = 0 AND client.id = ?',array($client_id));
		return $query;
	}

	public function new_person_client($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('person_client', $array);
		return $this->db->insert_id();
	}

	public function get_client_addresses($client_id)
	{
		$query = $this->db->query('SELECT client.id AS client_id, tradename, address_id, address_zip, send_address, address_table.city_id, address_city, department.id AS department_id, department.name AS department_name, country.id AS country_id, country.name AS country_name FROM client LEFT JOIN (SELECT send_address.id AS address_id, zip AS address_zip, address AS send_address, department_id,city.id AS city_id, city.name AS address_city, client_id FROM send_address LEFT JOIN city ON send_address.city_id = city.id WHERE deleted = 0) AS address_table ON client.id = address_table.client_id LEFT JOIN department ON address_table.department_id = department.id LEFT JOIN country ON department.country_id = country.id WHERE client.id = ?',array($client_id));
		return $query;
	}

	public function update_client_address($array,$id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		$this->db->update('send_address', $array);
	}

	public function delete_client_address($address_client_id)
	{
		$this->db->where('id', $address_client_id);
		$this->db->update('send_address', array("deleted" => 1));
	}

	public function new_address_client($array='')
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('send_address',$array);
		return $this->db->insert_id();
	}

	public function update_client ($array, $id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		$this->db->update('client', $array);
	}

	public function delete_client ($id)
	{
		$this->db->where('id', $id);
		$this->db->update('client', array("deleted" => 1));
	}

}

/* End of file Cliente.php */
/* Location: ./application/models/Cliente.php */