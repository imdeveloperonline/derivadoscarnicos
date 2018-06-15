<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saldo_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_advances()
	{
		$query = $this->db->query('SELECT id, amount, supplier_id, unit_price, quantity FROM advance_supplier WHERE payed != 1 AND method_id = 3');
		return $query;

	}

	public function get_receptions($advance_supplier_id)
	{
		$query = $this->db->query('SELECT SUM(quantity) AS total_quantity_reception FROM reception WHERE advance_supplier_id = ? AND deleted != 1',array($advance_supplier_id));
		return $query->result_array()[0]['total_quantity_reception'];
	}

	public function set_saldo($supplier_id,$saldo)
	{
		$saldo = (float) $saldo;
		$saldo = number_format($saldo, 2, '.', '');

		return $this->db->insert('saldo_inicial', array("supplier_id" => $supplier_id, "saldo" => $saldo));
	}

	public function get_saldo_inicial()
	{
		$query = $this->db->query('SELECT supplier_id, SUM(saldo) AS saldo FROM saldo_inicial GROUP BY supplier_id');

		return $query;
	}

	public function set_saldo_final($supplier_id,$saldo)
	{
		return $this->db->insert('saldo_final', array("supplier_id" => $supplier_id, "saldo" => $saldo));
	}

}

/* End of file Saldo_model.php */
/* Location: ./application/models/Saldo_model.php */