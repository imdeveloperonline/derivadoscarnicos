<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finanzas_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_methods()
	{
		$query = $this->db->query('SELECT id, name FROM method');
		return $query;
	}

	public function get_adv_suppliers($method = "")
	{
		if($method != "") {
			$method = ' AND method_id = '.$method;
		}

		

		$query = $this->db->query('SELECT advance_supplier.id, date, amount, unit_price, quantity, product_id, payed, advance_supplier.detail, product.name AS product_name, advance_supplier.supplier_id, user_id, regional_id, regional.name AS regional_name, supplier.tradename AS supplier_name, method.name AS method_name FROM advance_supplier INNER JOIN regional ON regional.id = advance_supplier.regional_id INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN supplier_has_shamble ON supplier.id = supplier_has_shamble.supplier_id INNER JOIN shamble ON supplier_has_shamble.shamble_id = shamble.id INNER JOIN city ON shamble.city_id = city.id INNER JOIN department ON department.id = city.department_id INNER JOIN product ON product.id = advance_supplier.product_id LEFT JOIN method ON method.id = advance_supplier.method_id WHERE regional_id = ? AND archived = 0 '.$method.' GROUP BY advance_supplier.id', array($_SESSION['regional']));

		return $query;
	}

	public function get_adv_supplier($advance_supplier_id)
	{
		$query = $this->db->query('SELECT advance_supplier.id, date, amount, unit_price, quantity, product_id, payed, advance_supplier.detail, product.name AS product_name, supplier_id, user_id, regional_id, supplier.tradename AS supplier_name, method.name AS method_name FROM advance_supplier INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN product ON product.id = advance_supplier.product_id LEFT JOIN method ON method.id = advance_supplier.method_id WHERE advance_supplier.id = ?',array($advance_supplier_id));
		return $query;
	}

	public function get_adv_by_supplier($supplier_id)
	{
		$query = $this->db->query('SELECT advance_supplier.id, date, amount, unit_price, quantity, product_id, payed, product.name AS product_name, supplier_id, user_id, regional_id, supplier.tradename AS supplier_name FROM advance_supplier INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN product ON product.id = advance_supplier.product_id WHERE payed = 0 AND advance_supplier.method_id = 3 AND supplier_id = ?',array($supplier_id));
		return $query;
	}

	public function get_adv_suppliers_archived()
	{
		$query = $this->db->query('SELECT advance_supplier.id, date, amount, unit_price, quantity, product_id, payed, product.name AS product_name, supplier_id, user_id, regional_id, supplier.tradename AS supplier_name, method.name AS method_name FROM advance_supplier INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN product ON product.id = advance_supplier.product_id LEFT JOIN method ON method.id = advance_supplier.method_id WHERE archived = 1');
		return $query;
	}

	public function new_adv_supplier($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('advance_supplier', $array);
		return $this->db->insert_id();
	}

	public function get_last_adv_supplier()
	{
		$query = $this->db->query('SELECT advance_supplier.id, date, amount, unit_price, quantity, product_id, product.name AS product_name, supplier_id, user_id, regional_id, supplier.tradename AS supplier_name, method.name AS method_name FROM advance_supplier INNER JOIN method ON method.id = advance_supplier.method_id INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN product ON product.id = advance_supplier.product_id ORDER BY advance_supplier.id DESC LIMIT 1');
		return $query;
	}

	public function get_supplier_advances()
	{
		$query = $this->db->query('SELECT advance_supplier.id, date, supplier_id, supplier.tradename AS supplier_name, quantity, product.name AS product_name FROM advance_supplier INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN product ON product.id = advance_supplier.product_id WHERE payed = 0');
		return $query;
	}

	public function get_rest_advance($advance_id)
	{
		$query = $this->db->query('SELECT quantity-total_reception_quantity AS rest, total_reception_quantity, quantity FROM advance_supplier INNER JOIN (SELECT SUM(quantity) AS total_reception_quantity FROM reception WHERE advance_supplier_id = '.$advance_id.' AND reception.deleted != 1) AS quantity_reception_table WHERE id = ?',array($advance_id));
		return $query;
	}

	public function get_rest_amount_advance($advance_supplier_id)
	{
		$query = $this->db->query('SELECT reception.quantity, reception.unit_price AS reception_unit_price, amount, supplier.precio_unitario AS supplier_unit_price FROM reception INNER JOIN advance_supplier ON advance_supplier.id = reception.advance_supplier_id INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id WHERE advance_supplier_id = ?',array($advance_supplier_id));

		$count = count($query->result_array());
		$recieved_amount = 0;
		foreach ($query->result_array() as $key => $value) {
			$amount_row = $value['quantity'] * $value['reception_unit_price'];
			$recieved_amount = $amount_row + $recieved_amount;
		}

		$advance_amount = $query->result_array()[0]['amount'];
		$supplier_unit_price = $query->result_array()[0]['supplier_unit_price'];


		return array($advance_amount,$recieved_amount,$supplier_unit_price);
	}

	public function get_rest_advance_exclude_this($advance_id,$reception_id)
	{
		$query = $this->db->query('SELECT quantity-total_reception_quantity AS rest, total_reception_quantity, quantity FROM advance_supplier INNER JOIN (SELECT SUM(quantity) AS total_reception_quantity FROM reception WHERE advance_supplier_id = '.$advance_id.' AND reception.deleted != 1 AND reception.id != '.$reception_id.') AS quantity_reception_table WHERE id = ?',array($advance_id));
		return $query;
	}

	public function get_rest_advance_client ($advance_id)
	{
		$query = $this->db->query('SELECT quantity-total_dispatch_quantity AS rest, total_dispatch_quantity, quantity FROM advance_client INNER JOIN (SELECT SUM(quantity) AS total_dispatch_quantity FROM dispatch WHERE advance_client_id = '.$advance_id.') AS quantity_dispatch_table WHERE id = ?',array($advance_id));
		return $query;
	}

	public function set_advance_payed($advance_id)
	{
		$this->db->where('id', $advance_id);
		$this->db->update('advance_supplier', array("payed" => 1));
	}

	public function archivar($advance_id)
	{
		$this->db->where('id', $advance_id);
		$this->db->update('advance_supplier', array("archived" => 1));
	}

	public function get_adv_clients()
	{
		$query = $this->db->query('SELECT advance_client.id, date, total, amount, unit_price, quantity, product_id, payed, product.name AS product_name, client_id, user_id, regional_id, client.tradename AS client_name FROM advance_client INNER JOIN client ON client.id = advance_client.client_id INNER JOIN product ON product.id = advance_client.product_id WHERE archived = 0');
		return $query;
	}

	public function get_adv_clients_archived()
	{
		$query = $this->db->query('SELECT advance_client.id, date, total, amount, unit_price, quantity, product_id, payed, product.name AS product_name, client_id, user_id, regional_id, client.tradename AS client_name FROM advance_client INNER JOIN client ON client.id = advance_client.client_id INNER JOIN product ON product.id = advance_client.product_id WHERE archived = 1');
		return $query;
	}

	public function new_adv_client($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('advance_client', $array);
		return $this->db->insert_id();
	}

	public function get_last_adv_client()
	{
		$query = $this->db->query('SELECT advance_client.id, date, amount, total, unit_price, quantity, product_id, payed, product.name AS product_name, client_id, user_id, regional_id, client.tradename AS client_name FROM advance_client INNER JOIN client ON client.id = advance_client.client_id INNER JOIN product ON product.id = advance_client.product_id ORDER BY advance_client.id DESC LIMIT 1');
		return $query;
	}

	public function archive_adv_client($advance_id)
	{
		$this->db->where('id', $advance_id);
		$this->db->update('advance_client', array("archived" => 1));
	}

	public function get_client_advances()
	{
		$query = $this->db->query('SELECT advance_client.id, date, client_id, client.tradename AS client_name, quantity, product.name AS product_name FROM advance_client INNER JOIN client ON client.id = advance_client.client_id INNER JOIN product ON product.id = advance_client.product_id WHERE archived = 0');
		return $query;
	}

	public function get_rest_advance_dispatch_client($advance_id)
	{
		$query = $this->db->query('SELECT quantity-total_dispatch_client_rest AS rest, total_dispatch_client_rest, quantity FROM advance_client INNER JOIN (SELECT SUM(quantity) AS total_dispatch_client_rest FROM dispatch WHERE advance_client_id = '.$advance_id.') AS quantity_dispatch_client_table WHERE id = ?',array($advance_id));
		return $query;
	}

	public function set_advance_client_payed($advance_id)
	{
		$this->db->where('id', $advance_id);
		$this->db->update('advance_client', array("payed" => 1));
	}

	public function get_client_by_advance($advance_client_id)
	{
		$query = $this->db->query('SELECT client_id FROM advance_client WHERE id = ?',array($advance_client_id));
		return $query;
	}

	public function get_credit_payments($advance_supplier_id)
	{
		$query = $this->db->query('SELECT credit_payment.id, credit_payment.date, credit_payment.amount, advance_supplier.id AS advance_supplier_id FROM credit_payment RIGHT JOIN advance_supplier ON advance_supplier.id = credit_payment.advance_supplier_id WHERE advance_supplier.id = ?',array($advance_supplier_id));
		return $query;
	}

	public function set_credit_payment($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('credit_payment', $array);
		return $this->db->insert_id();
	}

	public function get_last_credit_payment($advance_supplier_id)
	{
		$query = $this->db->query('SELECT credit_payment.id, credit_payment.date, credit_payment.amount, advance_supplier.id AS advance_supplier_id FROM credit_payment RIGHT JOIN advance_supplier ON advance_supplier.id = credit_payment.advance_supplier_id WHERE advance_supplier_id = ? ORDER BY credit_payment.id DESC LIMIT 1',array($advance_supplier_id));
		return $query;
	}

	public function update_credit_payment($credit_payment_id, $array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $credit_payment_id);
		$this->db->update('credit_payment', $array);
	}

	public function update_pay_adv_client($payment_adv_client_id, $array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $payment_adv_client_id);
		$this->db->update('payment_adv_client', $array);
	}

	public function get_credit_balance($advance_supplier_id)
	{
		$query = $this->db->query('SELECT advance_supplier.amount - IFNULL(SUM(credit_payment.amount),0) AS balance FROM advance_supplier LEFT JOIN credit_payment ON advance_supplier.id = credit_payment.advance_supplier_id WHERE advance_supplier.id = ?',array($advance_supplier_id));
		return $query;
	}

	public function set_pay_adv_client($advance_client_id, $amount, $date)
	{
		$this->db->insert('payment_adv_client', array("amount" => $amount, "date" => $date, "advance_client_id" => $advance_client_id));
		return $this->db->insert_id();
	}

	public function get_total_pay_adv_client($advance_client_id)
	{
		$query = $this->db->query('SELECT IFNULL(SUM(amount),0) AS total_pays FROM payment_adv_client WHERE advance_client_id = ?',array($advance_client_id));
		return $query;
	}

	public function get_pays_adv_client($advance_client_id)
	{
		$query = $this->db->query('SELECT id, date, amount, advance_client_id FROM payment_adv_client WHERE advance_client_id = ?',array($advance_client_id));
		return $query;
	}

	public function get_last_pay_adv_client($advance_client_id)
	{
		$query = $this->db->query('SELECT id, date, amount, advance_client_id FROM payment_adv_client WHERE advance_client_id = ? ORDER BY id DESC LIMIT 1',array($advance_client_id));
		return $query;
	}

	public function remove_adv_supplier($advance_supplier_id)
	{
		$this->db->delete('advance_supplier', array("id" => $advance_supplier_id));
	}

	public function update_adv_supplier($advance_supplier_id,$array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $advance_supplier_id);
		return $this->db->update('advance_supplier', $array);
	}

	public function get_precio_unitario_supplier($supplier_id)
	{
		$query = $this->db->query('SELECT precio_unitario FROM supplier WHERE id = ?',array($supplier_id));
		return $query;
	}

	public function get_active_adv_supplier($supplier_id)
	{
		$query = $this->db->query('SELECT EXISTS (SELECT id FROM advance_supplier WHERE supplier_id = ? AND regional_id = ? AND payed = 0 AND method_id = 3) AS is_active',array($supplier_id,$_SESSION['regional']));
		return $query->result_array()[0]['is_active'];
	}

	public function set_paid_account_credit($advance_supplier_id)
	{
		$this->db->where('id', $advance_supplier_id);
		return $this->db->update('advance_supplier', array("paid_account" => 1));
	}

	public function get_credit_active_by_supplier($supplier_id)
	{
		$query = $this->db->query('SELECT id FROM advance_supplier WHERE supplier_id = ? AND paid_account != 1 AND paid_account IS NOT NULL AND method_id = 2',array($supplier_id));
		return $query;	
	}

	public function get_supplier_balance($supplier_id)
	{
		$advances = $this->db->query('SELECT SUM(amount) AS total_amount FROM advance_supplier WHERE new_mod = 1 AND method_id = 3 AND supplier_id = ?',array($supplier_id));
		$receptions = $this->db->query('SELECT SUM(reception_amount) AS total_amount FROM reception WHERE new_mod = 1 AND reception.deleted != 1 AND method_id = 3 AND supplier_id = ?',array($supplier_id));
		$saldo_inicial = $this->db->query('SELECT saldo FROM saldo_final WHERE supplier_id = ?',array($supplier_id));

		if(!empty($saldo_inicial->result_array())){
			$saldo_inicial = $saldo_inicial->result_array()[0]['saldo'];
			
		} else {
			$saldo_inicial = 0;
		}
		
		$amount_advances = $advances->result_array()[0]['total_amount'];
		$amount_receptions = $receptions->result_array()[0]['total_amount'];

		$balance = $saldo_inicial + $amount_advances - $amount_receptions;

		$balance = number_format($balance, 2, '.', '');
		return $balance;
	}

}

/* End of file Finanzas_model.php */
/* Location: ./application/models/Finanzas_model.php */