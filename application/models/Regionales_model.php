<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Regionales_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_regionals()
	{
		$query = $this->db->query('SELECT regional.id, regional.name, city_id, city.name AS city_name, department.name AS department_name FROM regional INNER JOIN city ON regional.city_id = city.id INNER JOIN department ON department.id = city.department_id WHERE regional.deleted = 0');
		return $query;
	}

	public function get_regionals_for_regional_dispatches()
	{
		$query = $this->db->query('SELECT regional.id, regional.name, city_id, city.name AS city_name, department.name AS department_name FROM regional INNER JOIN city ON regional.city_id = city.id INNER JOIN department ON department.id = city.department_id WHERE regional.deleted = 0 AND regional.id = 1');
		return $query;
	}

	public function set_new_regional($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('regional', $array);
		return $this->db->insert_id();
	}

	public function get_last_regional()
	{
		$query = $this->db->query('SELECT regional.id, regional.name, city_id, city.name AS city_name, department.name AS department_name FROM regional INNER JOIN city ON regional.city_id = city.id INNER JOIN department ON department.id = city.department_id WHERE regional.deleted = 0 ORDER BY id DESC LIMIT 1');
		return $query;
	}

	public function delete_regional($id)
	{
		$this->db->where('id', $id);
		$this->db->update('regional', array('deleted' => 1));
	}

	public function get_regional($id)
	{
		$query = $this->db->query('SELECT regional.id, regional.name, city_id, city.name AS city_name, department.id AS department_id, department.name AS department_name, department.country_id AS country_id, country.name AS country_name FROM regional INNER JOIN city ON regional.city_id = city.id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id WHERE regional.deleted = 0 AND regional.id = ?',array($id));
		return $query;
	}

	public function update_regional($array, $id)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		$this->db->update('regional', $array);
	}

	public function get_employees()
	{
		$query = $this->db->query('SELECT regional_employees.id, regional_employees.name, lastname, dni, phone, email, creation_date, regional_id, active, regional.name AS regional_name FROM regional_employees INNER JOIN regional ON regional.id = regional_employees.regional_id WHERE regional_employees.deleted = 0');
		return $query;
	}

	public function set_new_employee($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('regional_employees', $array);
		return $this->db->insert_id();
	}

	public function get_last_employee()
	{
		$query = $this->db->query('SELECT regional_employees.id, regional_employees.name, lastname, dni, phone, email, creation_date, regional_id, active, regional.name AS regional_name FROM regional_employees INNER JOIN regional ON regional.id = regional_employees.regional_id WHERE regional_employees.deleted = 0 ORDER BY id DESC LIMIT 1');
		return $query;
	}

	public function delete_employee($id)
	{
		$this->db->where('id', $id);
		$this->db->update('regional_employees', array('deleted' => 1));
	}

	public function get_employee($id)
	{
		$query = $this->db->query('SELECT regional_employees.id, regional_employees.name, lastname, dni, phone, email, creation_date, regional_id, active, regional.name AS regional_name FROM regional_employees INNER JOIN regional ON regional.id = regional_employees.regional_id WHERE regional_employees.deleted = 0 AND regional_employees.id = ?',array($id));
		return $query;
	}

	public function get_periods($id)
	{
		$query = $this->db->query('SELECT id, position, salary, date_start, date_end FROM period WHERE regional_employees_id = ?', array($id));
		return $query;
	}

	public function set_employee_active($id)
	{
		$this->db->where('id', $id);
		$this->db->update('regional_employees', array("active" => 1));
	}

	public function set_new_employee_period($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('period', $array);
		return $this->db->insert_id();
	}

	public function get_last_employee_period($id)
	{
		$query = $this->db->query('SELECT id, position, salary, date_start, date_end FROM period WHERE regional_employees_id = ? ORDER BY id DESC LIMIT 1', array($id));
		return $query;
	}

	public function end_employee_period($id, $date)
	{
		$this->db->where('id', $id);
		$this->db->update('period', array("date_end" => $date));
	}

	public function set_employee_no_active($id)
	{
		$this->db->where('id', $id);
		$this->db->update('regional_employees', array("active" => 0));
	}

	public function check_active($id)
	{
		$query = $this->db->query('SELECT active FROM regional_employees WHERE id = ?',array($id));
		return $query;
	}

	public function exist_date_start($id,$date)
	{
		$query = $this->db->query('SELECT COUNT(id) AS count FROM period WHERE regional_employees_id = ? AND date_start = ?',array($id,$date));
		return $query;
	}

	public function exist_date_end($id,$date)
	{
		$query = $this->db->query('SELECT COUNT(id) AS count FROM period WHERE regional_employees_id = ? AND date_end = ?',array($id,$date));
		return $query;
	}

	public function update_employee($id, $array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		$this->db->update('regional_employees', $array);
	}

	public function new_adv_regional($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('regional_advances', $array);
		return $this->db->insert_id();
	}

	public function get_advances($id)
	{
		$query = $this->db->query('SELECT regional_advances.id, amount, date, detail, regional.name AS regional_name, regional.id AS regional_id FROM regional_advances RIGHT JOIN regional ON regional.id = regional_advances.regional_id WHERE regional.id = ?',array($id));
		return $query;
	}

	public function get_last_adv_regional($id)
	{
		$query = $this->db->query('SELECT regional_advances.id, amount, date, detail, regional.name AS regional_name, regional.id AS regional_id FROM regional_advances RIGHT JOIN regional ON regional.id = regional_advances.regional_id WHERE regional.id = ? ORDER BY regional_advances.id DESC LIMIT 1',array($id));
		return $query;
	}

	public function get_advance($id)
	{
		$query = $this->db->query('SELECT regional_advances.id, amount, date, detail, regional.name AS regional_name, regional.id AS regional_id FROM regional_advances RIGHT JOIN regional ON regional.id = regional_advances.regional_id WHERE regional_advances.id = ? ',array($id));
		return $query;
	}

	public function get_saldo()
	{

		$query = $this->db->query('SELECT IFNULL(total_advance,0)-IFNULL(total_outgo,0) AS balance, outgo_table.regional_id AS re_out_id, advance_table.regional_id AS re_adv_id FROM (SELECT SUM(outgo.amount) AS total_outgo, regional_id FROM outgo INNER JOIN regional ON regional.id = outgo.regional_id WHERE regional.deleted = 0 GROUP BY outgo.regional_id) AS outgo_table RIGHT OUTER JOIN (SELECT SUM(regional_advances.amount) AS total_advance, regional_id FROM regional_advances INNER JOIN regional ON regional.id = regional_advances.regional_id WHERE regional.deleted = 0 GROUP BY regional_advances.regional_id) AS advance_table ON outgo_table.regional_id = advance_table.regional_id GROUP BY outgo_table.regional_id, advance_table.regional_id UNION SELECT IFNULL(total_advance,0)-IFNULL(total_outgo,0) AS balance, outgo_table.regional_id AS re_out_id, advance_table.regional_id AS re_adv_id FROM (SELECT SUM(outgo.amount) AS total_outgo, regional_id FROM outgo INNER JOIN regional ON regional.id = outgo.regional_id WHERE regional.deleted = 0 GROUP BY outgo.regional_id) AS outgo_table LEFT OUTER JOIN (SELECT SUM(regional_advances.amount) AS total_advance, regional_id FROM regional_advances INNER JOIN regional ON regional.id = regional_advances.regional_id WHERE regional.deleted = 0 GROUP BY regional_advances.regional_id) AS advance_table ON outgo_table.regional_id = advance_table.regional_id GROUP BY outgo_table.regional_id, advance_table.regional_id');

		$balance = [];
		foreach ($query->result_array() as $key => $value) {

			if($value['re_adv_id'] != NULL) {
				$regional_id = $value['re_adv_id'];
			} else {
				$regional_id = $value['re_out_id'];
			}

			$array = array(
				"regional_id" => $regional_id,
				"saldo" => $value['balance']
			);
			$balance[] = $array;

			/*if($value['re_ad_id'] == $value['re_eg_id']) {

				$array = array(
					"regional_id" => $value['re_ad_id'],
					"saldo" => $value['total_advance'] - $value['total_out']
				);
				$balance[] = $array;
			}
			else if($value['re_ad_id'] == NULL && $value['re_eg_id'] != NULL) {
				$array = array(
					"regional_id" => $value['re_eg_id'],
					"saldo" => 0 - $value['total_out']
				);
				$balance[] = $array;
			}

			else if ($value['re_ad_id'] != NULL && $value['re_eg_id'] == NULL) {
				$array = array(
					"regional_id" => $value['re_ad_id'],
					"saldo" => $value['total_advance']
				);
				$balance[] = $array;
			}*/
		}
		
		
		return $balance;
	}

	public function update_advance($id, $array)
	{
		$this->db->where('id', $id);
		$this->db->update('regional_advances', $array);
	}

	public function get_regional_saldo()
	{
		$advances = $this->db->query('SELECT SUM(regional_advances.amount) AS total_advance FROM regional_advances WHERE regional_advances.regional_id = ?',array($_SESSION['regional']));
		$outgoes = $this->db->query('SELECT SUM(outgo.amount) AS total_outgo FROM outgo WHERE outgo.regional_id = ?',array($_SESSION['regional']));

		$saldo = $advances->result_array()[0]['total_advance'] - $outgoes->result_array()[0]['total_outgo'];
		return $saldo;
	}

}

/* End of file Regionales_model.php */
/* Location: ./application/models/Regionales_model.php */