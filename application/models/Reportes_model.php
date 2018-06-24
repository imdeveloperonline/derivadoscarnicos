<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_regional_report($regional_id, $startdate, $finishdate)
	{
		$regional = $this->db->query('SELECT regional.name AS regional_name, city.name AS city_name, department.name AS department_name FROM regional INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE regional.id = ?',array($regional_id));

		$receptions = $this->db->query('SELECT reception.id, reception.date, reception.quantity, reception.note, reception.method_id, regional.name AS regional_name, city.name AS city_name, department.name AS department_name, country.name AS country_name, method.name AS method_name, shamble.tradename AS shamble_name, shamble_amount, product.name AS product_name, advance_supplier_id, brand, supplier.tradename AS supplier_name FROM reception INNER JOIN supplier ON supplier.id = reception.supplier_id INNER JOIN advance_supplier ON advance_supplier.id = reception.advance_supplier_id INNER JOIN product ON product.id = advance_supplier.product_id INNER JOIN regional ON regional.id = reception.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id INNER JOIN method ON method.id = reception.method_id INNER JOIN shamble ON shamble.id = reception.shamble_id WHERE reception.deleted != 1 AND reception.regional_id = ? AND reception.date >= ? AND reception.date <= ?',array($regional_id,$startdate,$finishdate)); 


		$total_brands = $this->db->query('SELECT brand_reception.brand, SUM(brand_reception.quantity) AS quantity FROM brand_reception INNER JOIN reception ON reception.id = brand_reception.reception_id WHERE reception.deleted != 1 AND reception.regional_id = ? AND reception.date >= ? AND reception.date <= ? GROUP BY brand_reception.brand',array($regional_id,$startdate,$finishdate));

		$outgoes = $this->db->query('SELECT outgo.id, amount, date, regional.name AS regional_name, type_outgo.name AS type_outgo FROM outgo INNER JOIN type_outgo ON type_outgo.id = outgo.type_outgo_id INNER JOIN regional ON regional.id = outgo.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE outgo.regional_id = ? AND outgo.date >= ? AND outgo.date <= ?',array($regional_id, $startdate, $finishdate));

		$types_outgoes = $this->db->query('SELECT IFNULL(SUM(amount),0) AS amount, type_outgo.name AS type_outgo FROM outgo INNER JOIN type_outgo ON type_outgo.id = outgo.type_outgo_id INNER JOIN regional ON regional.id = outgo.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE regional_id = ? AND date >= ? AND date <= ? GROUP BY type_outgo_id',array($regional_id, $startdate, $finishdate));


		$array = array(
				"receptions" => $receptions->result_array(),
				"total_brands" => $total_brands->result_array(),
				"outgoes" => $outgoes->result_array(),
				"types_outgoes" => $types_outgoes->result_array(),
				"regional" => $regional->result_array()
			);

		return $array;
	}

	public function get_unit_price_adv_supplier($advance_supplier_id)
	{
		$query = $this->db->query('SELECT unit_price FROM advance_supplier WHERE id = ?',array($advance_supplier_id));
		return $query->result_array()[0]['unit_price'];
	}

	public function get_client_report($client_id, $startdate, $finishdate)
	{
		$client = $this->db->query('SELECT client.id, tradename, rut, phone, email, address, zip, city_id, city.name AS city_name, department.name AS department_name, country.name AS country_name FROM client INNER JOIN city ON city.id = client.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id WHERE client.id = ?',array($client_id));

		$advances = $this->db->query('SELECT advance_client.id, date, amount, unit_price, quantity, product_id, payed, product.name AS product_name, total FROM advance_client INNER JOIN product ON product.id = advance_client.product_id WHERE client_id = ? AND date >= ? AND date <= ?',array($client_id, $startdate, $finishdate));

		$dispatches = $this->db->query('SELECT dispatch.id, dispatch.date AS dispatch_date, dispatch.quantity AS dispatch_quantity, advance_client_id, advance_client.product_id, advance_client.quantity AS advance_quantity, note, unit_price, amount, detail, product.name AS product_name, dispatch.note FROM dispatch INNER JOIN advance_client ON advance_client.id = dispatch.advance_client_id INNER JOIN product ON advance_client.product_id = product.id WHERE client_id = ? AND dispatch.date >= ? AND dispatch.date <= ?',array($client_id, $startdate, $finishdate));

		$result = array(
				"client" => $client->result_array(),
				"advances" => $advances->result_array(),
				"dispatches" => $dispatches->result_array()
			);

		return $result;
	}

	public function get_department_report($department_id, $startdate, $finishdate)
	{
		$suppliers = $this->db->query('SELECT supplier.id, supplier.tradename, supplier.rut, supplier.phone, supplier.email, supplier.address, supplier.zip, supplier.city_id, city.name AS city_name, department.name AS department_name, country.name AS country_name FROM supplier INNER JOIN city ON city.id = supplier.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id WHERE department.id = ?',array($department_id));

		$receptions = $this->db->query('SELECT reception.id, reception.date, reception.quantity, reception.note, advance_supplier_id, regional.name AS regional_name, product.name AS product_name, supplier.tradename AS supplier_name, shamble.tradename AS shamble_name FROM reception LEFT JOIN shamble ON shamble.id = reception.shamble_id INNER JOIN advance_supplier ON advance_supplier.id = reception.advance_supplier_id INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN product ON product.id = advance_supplier.product_id INNER JOIN regional ON regional.id = reception.regional_id INNER JOIN city ON city.id = supplier.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id WHERE reception.deleted != 1 AND department.id = ? AND reception.date >= ? AND reception.date <= ?',array($department_id, $startdate, $finishdate));

		$outgoes = $this->db->query('SELECT outgo.id, amount, date, regional.name AS regional_name, type_outgo.name AS type_outgo FROM outgo INNER JOIN type_outgo ON type_outgo.id = outgo.type_outgo_id INNER JOIN regional ON regional.id = outgo.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE department_id = ? AND date >= ? AND date <= ?',array($department_id, $startdate, $finishdate));

		$types_outgoes = $this->db->query('SELECT IFNULL(SUM(amount),0) AS amount, type_outgo.name AS type_outgo FROM outgo INNER JOIN type_outgo ON type_outgo.id = outgo.type_outgo_id INNER JOIN regional ON regional.id = outgo.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE department_id = ? AND date >= ? AND date <= ? GROUP BY type_outgo_id',array($department_id, $startdate, $finishdate));

		$transactions = $this->db->query('SELECT advance_supplier.id, date, amount, quantity, supplier.tradename AS supplier_name, regional.name AS regional_name, method.name AS method_name, product.name AS product_name FROM advance_supplier INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN method ON method.id = advance_supplier.method_id INNER JOIN product ON product.id = advance_supplier.product_id INNER JOIN regional ON regional.id = advance_supplier.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE department_id = ? AND date >= ? AND date <= ?',array($department_id, $startdate, $finishdate));

		$types_transactions = $this->db->query('SELECT COUNT(advance_supplier.id) AS count, IFNULL(SUM(amount),0) AS amount, method_id, method.name AS method_name FROM advance_supplier INNER JOIN method ON method.id = advance_supplier.method_id INNER JOIN regional ON regional.id = advance_supplier.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE department_id = ? AND date >= ? AND date <= ? GROUP BY method_id',array($department_id, $startdate, $finishdate));
		
		$result = array(
				"suppliers" => $suppliers->result_array(),
				"receptions" => $receptions->result_array(),
				"outgoes" => $outgoes->result_array(),
				"types_outgoes" => $types_outgoes->result_array(),
				"transactions" => $transactions->result_array(),
				"types_transactions" => $types_transactions->result_array()
			);

		return $result;
	}

	public function get_total_pay_adv_client($advance_client_id)
	{
		$query = $this->db->query('SELECT IFNULL(SUM(amount),0) AS total_pays FROM payment_adv_client WHERE advance_client_id = ?',array($advance_client_id));
		return $query;
	}

	public function get_total_in_dispatch_adv_client($advance_client_id)
	{
		$query = $this->db->query('SELECT IFNULL(SUM(quantity),0) AS total_in_dispatches FROM dispatch WHERE advance_client_id = ?',array($advance_client_id));
		return $query;
	}

	public function get_supplier_report($supplier_id, $startdate, $finishdate)
	{
		$supplier = $this->db->query('SELECT supplier.id, supplier.tradename, rut, phone, email, address, zip, city.name AS city_name, department.name AS department_name, country.name AS country_name, precio_unitario, month_quantity FROM supplier INNER JOIN city ON city.id = supplier.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id WHERE supplier.id = ?',array($supplier_id));

		$shambles = $this->db->query('SELECT shamble.id, shamble.tradename, rut, phone, email, address, zip, city.name AS city_name, department.name AS department_name, country.name AS country_name FROM shamble INNER JOIN supplier_has_shamble ON supplier_has_shamble.shamble_id = shamble.id INNER JOIN city ON city.id = shamble.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id WHERE supplier_id = ?',array($supplier_id));

		$receptions = $this->db->query('SELECT reception.id, reception.date, reception.quantity, reception.note, regional.name AS regional_name, city.name AS city_name, department.name AS department_name, country.name AS country_name, method.name AS method_name, shamble.tradename AS shamble_name, shamble_amount, advance_supplier_id, brand, product.name AS product_name FROM reception INNER JOIN regional ON regional.id = reception.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id INNER JOIN method ON method.id = reception.method_id INNER JOIN shamble ON shamble.id = reception.shamble_id LEFT JOIN product ON product.id = reception.product_id WHERE reception.deleted != 1 AND reception.supplier_id = ? AND reception.date >= ? AND reception.date <= ?',array($supplier_id,$startdate,$finishdate)); 


		$total_brands = $this->db->query('SELECT brand_reception.brand, SUM(brand_reception.quantity) AS quantity FROM brand_reception INNER JOIN reception ON reception.id = brand_reception.reception_id WHERE reception.deleted != 1 AND reception.supplier_id = ? AND reception.date >= ? AND reception.date <= ? GROUP BY brand_reception.brand',array($supplier_id,$startdate,$finishdate));

		$transactions = $this->db->query('SELECT advance_supplier.id, date, amount, quantity, supplier.tradename AS supplier_name, regional.name AS regional_name, method.name AS method_name, product.name AS product_name, method_id, payed, unit_price FROM advance_supplier INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN method ON method.id = advance_supplier.method_id INNER JOIN product ON product.id = advance_supplier.product_id INNER JOIN regional ON regional.id = advance_supplier.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE supplier_id = ? AND date >= ? AND date <= ? OR payed = 0 AND supplier_id = ?',array($supplier_id, $startdate, $finishdate,$supplier_id));

		$credit_payment = $this->db->query('SELECT credit_payment.id, credit_payment.date, credit_payment.amount, advance_supplier_id FROM credit_payment INNER JOIN advance_supplier ON advance_supplier.id = credit_payment.advance_supplier_id WHERE supplier_id = ? AND advance_supplier.date >= ? AND advance_supplier.date <= ?',array($supplier_id, $startdate, $finishdate));


		$advances_balance = $this->db->query('SELECT SUM(amount) AS total_amount FROM advance_supplier WHERE new_mod = 1 AND supplier_id = ? AND method_id = 3',array($supplier_id));
		$receptions_balance = $this->db->query('SELECT SUM(reception_amount) AS total_amount FROM reception WHERE new_mod = 1 AND reception.deleted != 1 AND method_id = 3 AND supplier_id = ?',array($supplier_id));
		$saldo_inicial = $this->db->query('SELECT saldo FROM saldo_final WHERE supplier_id = ?',array($supplier_id));

		if(!empty($saldo_inicial->result_array())){
			$saldo_inicial = $saldo_inicial->result_array()[0]['saldo'];
			
		} else {
			$saldo_inicial = 0;
		}
		
		$amount_advances = $advances_balance->result_array()[0]['total_amount'];
		$amount_receptions = $receptions_balance->result_array()[0]['total_amount'];

		$balance = $saldo_inicial + $amount_advances - $amount_receptions;
		$balance = number_format($balance, 2, '.', '');

		$array = array(
				"supplier" => $supplier->result_array(),
				"shambles" => $shambles->result_array(),
				"receptions" => $receptions->result_array(),
				"total_brands" => $total_brands->result_array(),
				"transactions" => $transactions->result_array(),
				"credit_payment" => $credit_payment->result_array(),
				"balance" => $balance
			);

		return $array;
	}

	public function get_regionals_by_department($department_id)
	{
		$query = $this->db->query('SELECT regional.id, regional.name FROM regional INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE department_id = ?',array($department_id));
		return $query;
	}

	public function get_finances_report($startdate, $finishdate)
	{
		
		$transactions = $this->db->query('SELECT advance_supplier.id, date, amount, quantity, supplier.tradename AS supplier_name, regional.name AS regional_name, method_id, method.name AS method_name, product.name AS product_name FROM advance_supplier INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN method ON method.id = advance_supplier.method_id INNER JOIN product ON product.id = advance_supplier.product_id INNER JOIN regional ON regional.id = advance_supplier.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE date >= ? AND date <= ?',array($startdate, $finishdate));

		/*$outgoes = $this->db->query('SELECT outgo.id, amount, date, regional.name AS regional_name, type_outgo.name AS type_outgo FROM outgo INNER JOIN type_outgo ON type_outgo.id = outgo.type_outgo_id INNER JOIN regional ON regional.id = outgo.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE date >= ? AND date <= ?',array($startdate, $finishdate));*/

		$general_outgoes = $this->db->query('SELECT general_outgo.id, amount, date, type_outgo.name AS type_outgo FROM general_outgo INNER JOIN type_outgo ON type_outgo.id = general_outgo.type_outgo_id WHERE date >= ? AND date <= ?',array($startdate, $finishdate));

		$advances = $this->db->query('SELECT advance_client.id, date, total,amount, unit_price, quantity, product_id, payed, product.name AS product_name, total FROM advance_client INNER JOIN product ON product.id = advance_client.product_id WHERE date >= ? AND date <= ?',array($startdate, $finishdate));

		$regional_advances = $this->db->query('SELECT regional_advances.id, regional_advances.amount, regional_advances.date, regional_advances.detail, regional_id, regional.name AS regional_name, city.name AS city_name, department.name AS department_name FROM regional_advances INNER JOIN regional ON regional.id = regional_advances.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE date >= ? AND date <= ?',array($startdate,$finishdate));


		$array = array(
			"transactions" => $transactions->result_array(),
			/*"outgoes" => $outgoes->result_array(),*/
			"advances" => $advances->result_array(),
			"general_outgoes" => $general_outgoes->result_array(),
			"regional_advances" => $regional_advances->result_array(),
		);

		return $array;

	}

	public function get_pays_credit_suppliers($advance_supplier_id)
	{
		$query = $this->db->query('SELECT IFNULL(SUM(amount),0) AS total_pay FROM credit_payment WHERE advance_supplier_id = ? GROUP BY advance_supplier_id',array($advance_supplier_id));	
		return $query;

	}

	public function get_storage_report($regional_id,$startdate,$finishdate)
	{
		if($regional_id == 0){
			$where_regional = "";
		} else {
			$where_regional = " AND reception.regional_id = $regional_id";
		}

		if($regional_id == 0) {
			$receptions = $this->db->query('SELECT reception.id, reception.date, reception.quantity, regional.name AS regional_name, city.name AS city_name, department.name AS department_name, country.name AS country_name, method.name AS method_name, shamble.tradename AS shamble_name, shamble_amount, product.name AS product_name, advance_supplier_id, brand FROM reception INNER JOIN advance_supplier ON advance_supplier.id = reception.advance_supplier_id INNER JOIN product ON product.id = advance_supplier.product_id INNER JOIN regional ON regional.id = reception.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id INNER JOIN method ON method.id = reception.method_id INNER JOIN shamble ON shamble.id = reception.shamble_id WHERE reception.deleted != 1 AND reception.date >= ? AND reception.date <= ?'.$where_regional,array($startdate,$finishdate));

			$dispatches = $this->db->query('SELECT dispatch.id, dispatch.date AS dispatch_date, dispatch.quantity AS dispatch_quantity, advance_client_id, advance_client.product_id, advance_client.quantity AS advance_quantity, note, unit_price, amount, detail, product.name AS product_name, dispatch.note FROM dispatch INNER JOIN advance_client ON advance_client.id = dispatch.advance_client_id INNER JOIN product ON advance_client.product_id = product.id WHERE dispatch.date >= ? AND dispatch.date <= ?',array($startdate, $finishdate));
		} else if($regional_id == 1){
			$receptions = $this->db->query('SELECT reception.id, reception.date, reception.quantity, regional.name AS regional_name, city.name AS city_name, department.name AS department_name, country.name AS country_name, method.name AS method_name, shamble.tradename AS shamble_name, shamble_amount, product.name AS product_name, advance_supplier_id, brand FROM reception INNER JOIN advance_supplier ON advance_supplier.id = reception.advance_supplier_id INNER JOIN product ON product.id = advance_supplier.product_id INNER JOIN regional ON regional.id = reception.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id INNER JOIN method ON method.id = reception.method_id INNER JOIN shamble ON shamble.id = reception.shamble_id WHERE reception.deleted != 1 AND reception.date >= ? AND reception.date <= ?'.$where_regional,array($startdate,$finishdate));

			$central_receptions = $this->db->query('SELECT reception_central.id, reception_central.date, reception_central.quantity FROM reception_central WHERE reception_central.date >= ? AND reception_central.date <= ?',array($startdate, $finishdate));

			$dispatches = $this->db->query('SELECT dispatch.id, dispatch.date AS dispatch_date, dispatch.quantity AS dispatch_quantity, advance_client_id, advance_client.product_id, advance_client.quantity AS advance_quantity, note, unit_price, amount, detail, product.name AS product_name, dispatch.note FROM dispatch INNER JOIN advance_client ON advance_client.id = dispatch.advance_client_id INNER JOIN product ON advance_client.product_id = product.id WHERE dispatch.date >= ? AND dispatch.date <= ?',array($startdate, $finishdate));


		} else {
			$receptions = $this->db->query('SELECT reception.id, reception.date, reception.quantity, regional.name AS regional_name, city.name AS city_name, department.name AS department_name, country.name AS country_name, method.name AS method_name, shamble.tradename AS shamble_name, shamble_amount, product.name AS product_name, advance_supplier_id, brand FROM reception INNER JOIN advance_supplier ON advance_supplier.id = reception.advance_supplier_id INNER JOIN product ON product.id = advance_supplier.product_id INNER JOIN regional ON regional.id = reception.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN country ON country.id = department.country_id INNER JOIN method ON method.id = reception.method_id INNER JOIN shamble ON shamble.id = reception.shamble_id WHERE reception.deleted != 1 AND reception.date >= ? AND reception.date <= ?'.$where_regional,array($startdate,$finishdate));

			$regional_dispatches = $this->db->query('SELECT dispatch_regional.id, dispatch_regional.date, dispatch_regional.quantity, product.name AS product_name FROM dispatch_regional INNER JOIN product ON product.id = dispatch_regional.product_id WHERE dispatch_regional.date >= ? AND dispatch_regional.date <= ?',array($startdate,$finishdate));
		}
		

		if($regional_id == 0) {
			$array = array(
				"receptions" => $receptions->result_array(),
				"dispatches" => $dispatches->result_array()
			);
		} else if($regional_id == 1) {
			$array = array (
				"receptions" => $receptions->result_array(),
				"central_receptions" => $central_receptions->result_array(),
				"dispatches" => $dispatches->result_array()
			);
		} else {
			$array = array (
				"receptions" => $receptions->result_array(),
				"regional_dispatches" => $regional_dispatches->result_array()
			);
		}

		return $array;


	}

}

/* End of file Reportes_model.php */
/* Location: ./application/models/Reportes_model.php */