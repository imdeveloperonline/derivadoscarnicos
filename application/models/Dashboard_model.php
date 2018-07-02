<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_ingresos($month)
	{
		$query = $this->db->query('SELECT SUM(amount) AS income FROM advance_client WHERE MONTH(date) = '.$month.' AND YEAR(date) = '.date("Y").'');
		return $query;
	}

	public function get_egresos($month)
	{
		$query = $this->db->query('SELECT SUM(advance_supplier.amount) + outgo_amount AS egress FROM advance_supplier INNER JOIN (SELECT SUM(outgo.amount) AS outgo_amount FROM outgo WHERE MONTH(date) = '.$month.' AND YEAR(date) = '.date("Y").') AS outgo_table WHERE MONTH(date) = '.$month.' AND YEAR(date) = '.date("Y").'');
		return $query;
	}

	public function get_dispatches_by_department()
	{
		
		$query = $this->db->query('SELECT department.name AS department_name, regional.name AS regional_name, SUM(quantity) AS quantity, map_code FROM dispatch INNER JOIN regional ON regional.id = dispatch.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id WHERE department.country_id = 49 AND YEAR(date) = '.date('Y').' GROUP BY department.id');
		
		$map_format = "{";
		$n = 1;
		foreach ($query->result_array() as $key => $value) {
			if($n == 1) {
				$coma = "";
			}else {
				$coma = ",";
			}
			$map_format .= ''.$coma.' "'.$value['map_code'].'" : '.$value['quantity'];

			$n++;
		}

		$map_format .= "};";

		return $map_format;
	}

	public function get_outgoes_by_department()
	{
		
		$query = $this->db->query('SELECT map_code, SUM(amount) AS outgoes_amount, department_id FROM outgo INNER JOIN regional ON regional.id = outgo.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE country_id = 49 AND YEAR(date) = '.date("Y").' AND MONTH(date) = '.date("m").' GROUP BY department_id');
		
		$map_format = "{";
		$n = 1;
		foreach ($query->result_array() as $key => $value) {
			if($n == 1) {
				$coma = "";
			}else {
				$coma = ",";
			}
			$map_format .= ''.$coma.' "'.$value['map_code'].'" : '.$value['outgoes_amount'];

			$n++;
		}

		$map_format .= "};";

		return $map_format;
	}

	public function get_outgoes_by_types()
	{
		$query = $this->db->query('SELECT type_outgo.name, IFNULL(SUM(amount),0) AS amount FROM outgo INNER JOIN regional ON regional.id = outgo.regional_id INNER JOIN type_outgo ON type_outgo.id = outgo.type_outgo_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE country_id = 49 AND YEAR(date) = '.date("Y").' AND MONTH(date) = '.date("m").' GROUP BY type_outgo_id');


		$data_pie = [];
		foreach ($query->result_array() as $key => $value) {
			
			$data_pie[] = array("label" => $value['name'],"data" => $value['amount']);
		}

		return json_encode($data_pie);
	}

}

/* End of file Dashboard_model.php */
/* Location: ./application/models/Dashboard_model.php */