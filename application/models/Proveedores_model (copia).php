<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_suppliers()
	{
		$sql = "SELECT supplier.id, supplier.tradename AS supplier_name, supplier.rut, supplier.email, supplier.phone, supplier.address, supplier.zip, city.name AS city_name, department.name AS department_name FROM supplier INNER JOIN city ON supplier.city_id = city.id INNER JOIN department ON department.id = city.department_id WHERE supplier.deleted = 0";
		$query = $this->db->query($sql);
		return $query;
	}

	public function get_suppliers_by_regional()
	{
		$regional = $this->db->query('SELECT department_id FROM regional INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE regional.id = ?',array($_SESSION['regional']));
		$department_id = $regional->result_array()[0]['department_id'];

		$sql = "SELECT supplier.id, supplier.tradename AS supplier_name, supplier.rut, supplier.email, supplier.phone, supplier.address, supplier.zip, city.name AS city_name, department.name AS department_name, shamble.tradename AS shamble_name, shamble.id AS shamble_id FROM supplier INNER JOIN supplier_has_shamble ON supplier.id = supplier_has_shamble.supplier_id INNER JOIN shamble ON supplier_has_shamble.shamble_id = shamble.id INNER JOIN city ON shamble.city_id = city.id INNER JOIN department ON department.id = city.department_id WHERE supplier.deleted = 0 AND department_id = ? GROUP BY supplier.id";
		$query = $this->db->query($sql,array($department_id));
		return $query;
	}

	public function get_last_supplier ()
	{
		$query = $this->db->query('SELECT supplier.id, supplier.tradename AS supplier_name, supplier.rut, supplier.email, supplier.phone, supplier.address, supplier.zip, city.name AS city_name, FROM supplier INNER JOIN city ON supplier.city_id = city.id WHERE supplier.deleted = 0 ORDER BY supplier.id DESC LIMIT 1');
		return $query;
	}

	public function new_supplier($array) {
 
 		$array = $this->security->xss_clean($array);
		$this->db->insert('supplier',$array);
		return $this->db->insert_id();

	}

	public function exist_supplier_rut($supplier_rut) {

		$query = $this->db->query('SELECT id FROM supplier WHERE rut = "' . $supplier_rut . '" LIMIT 1');
		return $query->num_rows();

	}

	public function get_supplier ($supplier_id)
	{
		$query = $this->db->query('SELECT supplier.id, supplier.tradename AS supplier_name, supplier.rut, supplier.email, supplier.phone, supplier.address, supplier.zip, supplier.city_id AS supplier_city_id, city.department_id, department.country_id, city.name AS city_name, department.name AS department_name, country.name AS country_name FROM supplier INNER JOIN city ON supplier.city_id = city.id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id WHERE supplier.deleted = 0 AND supplier.id = ? LIMIT 1',array($supplier_id));
		return $query;
	}

	public function update_supplier ($array, $id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		return $this->db->update('supplier', $array);
	}

	public function delete_supplier ($id)
	{
		$this->db->where('id', $id);
		$this->db->update('supplier', array("deleted" => 1));
	}

	public function get_supplier_persons($supplier_id)
	{
		$query = $this->db->query('SELECT supplier.id AS supplier_id, tradename AS supplier_name, person_id, person_name, person_lastname, person_phone, person_email, person_position FROM supplier LEFT JOIN (SELECT id AS person_id, supplier_id, name AS person_name, lastname AS person_lastname, person_supplier.phone AS person_phone, person_supplier.email AS person_email, position AS person_position FROM person_supplier WHERE deleted = 0) AS person_table ON supplier.id = person_table.supplier_id WHERE supplier.id = ?',array($supplier_id));
		return $query->result_array();
	}

	public function new_person_supplier($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('person_supplier', $array);
		return $this->db->insert_id();
	}

	public function delete_supplier_person($person_supplier_id)
	{
		$this->db->where('id', $person_supplier_id);
		$this->db->update('person_supplier', array("deleted" => 1));
	}

	public function update_supplier_person($array, $id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		$this->db->update('person_supplier', $array);
	}

	public function get_supplier_banks ($supplier_id)
	{
		$query = $this->db->query('SELECT id, bank, name, rut, account, type_account FROM supplier_bank WHERE deleted = 0 AND supplier_id = ?',array($supplier_id));
		return $query;
	}

	public function get_supplier_centers ($supplier_id)
	{
		$query = $this->db->query('SELECT id, center, name, rut, location FROM supplier_center WHERE deleted = 0 AND supplier_id = ?',array($supplier_id));
		return $query;
	}

	public function new_bank_supplier($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('supplier_bank', $array);
		return $this->db->insert_id();
	}

	public function new_center_supplier($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('supplier_center', $array);
		return $this->db->insert_id();
	}

	public function update_supplier_bank($array, $id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		$this->db->update('supplier_bank', $array);
	}

	public function update_supplier_center($array, $id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		$this->db->update('supplier_center', $array);
	}

	public function delete_supplier_bank($supplier_bank_id)
	{
		$this->db->where('id', $supplier_bank_id);
		$this->db->update('supplier_bank', array("deleted" => 1));
	}

	public function delete_supplier_center($supplier_bank_id)
	{
		$this->db->where('id', $supplier_bank_id);
		$this->db->update('supplier_center', array("deleted" => 1));
	}

	public function set_supplier_shambles($supplier_id, $shambles)
	{
		$n = 0;
		foreach ($shambles as $shamble) {
			$this->db->insert('supplier_has_shamble', array("supplier_id" => $supplier_id, "shamble_id" => $shamble));
			if($this->db->affected_rows()>0) {
				$n++;
			}
		}

		return $n;

	}

	public function get_shambles_supplier($supplier_id)
	{
		$query = $this->db->query('SELECT shamble_id, shamble.tradename AS shamble_name FROM supplier_has_shamble INNER JOIN shamble ON shamble.id = supplier_has_shamble.shamble_id WHERE shamble.deleted != 1 AND supplier_id = ?',array($supplier_id));
		return $query;
	}

	public function update_shambles_supplier($supplier_id, $shambles)
	{
		if($this->db->delete('supplier_has_shamble', array("supplier_id" => $supplier_id)))
		{
			$n = 0;
			foreach ($shambles as $shamble) {
				$this->db->insert('supplier_has_shamble', array("supplier_id" => $supplier_id, "shamble_id" => $shamble));
				$n++;
			}

			return $n;			
		} else {
			return 0;
		}

	}

	public function get_supplier_shambles_by_regional($supplier_id)
	{
		$regional_department_query = $this->db->query('SELECT department_id FROM regional INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE regional.id = ?',array($_SESSION['regional']));
		$regional_department =  $regional_department_query->result_array()[0]['department_id'];

		$query = $this->db->query('SELECT shamble.id, shamble.tradename FROM shamble INNER JOIN supplier_has_shamble ON shamble.id = supplier_has_shamble.shamble_id INNER JOIN city ON city.id = shamble.city_id INNER JOIN department ON department.id = city.department_id WHERE supplier_id = ? AND department_id = ?', array($supplier_id,$regional_department));
		return $query;
	}

}

/* End of file Proveedores_model.php */
/* Location: ./application/models/Proveedores_model.php */