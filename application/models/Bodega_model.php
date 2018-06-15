<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bodega_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_products()
	{
		$query = $this->db->query('SELECT id,name FROM product WHERE deleted = 0');
		return $query;
	}

	public function get_all_products()
	{
		$query = $this->db->query('SELECT id,name, deleted FROM product');
		return $query;
	}

	public function get_receptions()
	{
		$query = $this->db->query('SELECT reception.id, reception.date AS reception_date, reception.quantity AS reception_quantity, note, supplier.tradename AS supplier_name, reception.brand, reception.method_id, method.name AS method_name, method_id, advance_supplier_id, product.name AS product_name, reception_amount FROM reception LEFT JOIN product ON product.id = reception.product_id INNER JOIN supplier ON supplier.id = reception.supplier_id INNER JOIN method ON method.id = reception.method_id INNER JOIN regional ON reception.regional_id = regional.id INNER JOIN city ON city.id = regional.city_id WHERE reception.deleted != 1 AND reception.regional_id = ?',array($_SESSION['regional']));
		return $query;
	}

	public function get_reception($reception_id)
	{
		$query = $this->db->query('SELECT reception.id, reception.date AS reception_date, reception.quantity AS reception_quantity, advance_supplier_id, advance_supplier.product_id, advance_supplier.quantity AS advance_quantity, note, unit_price, amount, detail, product_id, product.name AS product_name, advance_supplier.supplier_id, supplier.tradename AS supplier_name, reception.brand, reception.method_id, method.name AS method_name, shamble_id, shamble_amount, city.name AS city_name, department.name AS department_name, name_method, rut_method, bankcenter_method, account_method FROM reception INNER JOIN advance_supplier ON advance_supplier.id = reception.advance_supplier_id INNER JOIN product ON advance_supplier.product_id = product.id INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN method ON method.id = reception.method_id INNER JOIN regional ON regional.id = reception.regional_id INNER JOIN city ON city.id = regional.city_id INNER JOIN department ON department.id = city.department_id WHERE advance_supplier.archived = 0 AND reception.deleted != 1 AND reception.id = ?',array($reception_id));
		return $query;
	}

	public function set_reception($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('reception', $array);
		return $this->db->insert_id();
	}

	public function delete_reception($reception_id)
	{
		$this->db->where('id', $reception_id);
		$this->db->update('reception', array("deleted" => 1));
	}

	public function update_reception($id,$array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->where('id', $id);
		return $this->db->update('reception', $array);
	}

	public function rest_on_this_reception($id, $advance_supplier_id)
	{
		$query = $this->db->query('SELECT SUM(quantity) AS rest FROM reception WHERE reception.deleted != 1 AND id < ? AND advance_supplier_id = ?',array($id,$advance_supplier_id));
		return $query;
	}

	public function rest_on_this_disátch_client($id, $advance_client_id)
	{
		$query = $this->db->query('SELECT SUM(quantity) AS rest FROM dispatch WHERE id < ? AND advance_client_id = ?',array($id,$advance_client_id));
		return $query;
	}

	public function get_last_reception()
	{
		$query = $this->db->query('SELECT reception.id, reception.date AS reception_date, reception.quantity AS reception_quantity, reception.brand, advance_supplier_id, advance_supplier.product_id, advance_supplier.quantity AS advance_quantity, note, advance_supplier.unit_price, amount, detail, advance_supplier.supplier_id, product.name AS product_name, supplier.tradename AS supplier_name, department.name AS department_name, city.name AS city_name, reception.method_id, method.name AS method_name, name_method, rut_method, bankcenter_method, account_method FROM reception INNER JOIN advance_supplier ON advance_supplier.id = reception.advance_supplier_id INNER JOIN product ON advance_supplier.product_id = product.id INNER JOIN supplier ON supplier.id = advance_supplier.supplier_id INNER JOIN city ON city.id = supplier.city_id INNER JOIN department ON department.id = city.department_id INNER JOIN method ON method.id = reception.method_id ORDER BY reception.id DESC LIMIT 1');
		return $query;
	}

	public function rest_on_this_dispatch_client($id, $advance_client_id)
	{
		$query = $this->db->query('SELECT SUM(quantity) AS rest FROM dispatch WHERE id < ? AND advance_client_id = ?',array($id,$advance_client_id));
		return $query;
	}

	public function get_dispatches()
	{
		$query = $this->db->query('SELECT dispatch.id, dispatch.date AS dispatch_date, dispatch.quantity AS dispatch_quantity, advance_client_id, advance_client.product_id, advance_client.quantity AS advance_quantity, note, unit_price, amount, detail, product.name AS product_name, client.tradename AS client_name, dispatch.note FROM dispatch INNER JOIN advance_client ON advance_client.id = dispatch.advance_client_id INNER JOIN product ON advance_client.product_id = product.id INNER JOIN client ON client.id = advance_client.client_id WHERE advance_client.archived = 0');
		return $query;
	}

	public function set_dispatch_client($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('dispatch', $array);
		return $this->db->insert_id();
	}

	public function get_last_dispatch_client()
	{
		$query = $this->db->query('SELECT dispatch.id, dispatch.date AS dispatch_date, dispatch.quantity AS dispatch_quantity, advance_client_id, advance_client.product_id, advance_client.quantity AS advance_quantity, note, unit_price, amount, detail, product.name AS product_name, client.tradename AS client_name FROM dispatch INNER JOIN advance_client ON advance_client.id = dispatch.advance_client_id INNER JOIN product ON advance_client.product_id = product.id INNER JOIN client ON client.id = advance_client.client_id ORDER BY dispatch.id DESC LIMIT 1');
		return $query;
	}

	public function get_advance_dispatches($advance_client_id)
	{
		$query = $this->db->query('SELECT dispatch.id, dispatch.date AS dispatch_date, advance_client.id AS advance_client_id, client.tradename AS client_name, advance_client.quantity AS advance_quantity, dispatch.quantity AS dispatch_quantity, product.name AS product_name FROM advance_client LEFT JOIN client ON client.id = advance_client.client_id LEFT JOIN dispatch ON advance_client.id = dispatch.advance_client_id LEFT JOIN product ON product.id = advance_client.product_id WHERE advance_client.id = ?',array($advance_client_id));
		return $query;
	}

	public function get_advance_receptions($advance_supplier_id)
	{
		$query = $this->db->query('SELECT reception.id, reception.date AS reception_date, advance_supplier.id AS advance_supplier_id, supplier.tradename AS supplier_name, advance_supplier.quantity AS advance_quantity, reception.quantity AS reception_quantity, product.name AS product_name, reception.brand, reception.note FROM advance_supplier LEFT JOIN supplier ON supplier.id = advance_supplier.supplier_id LEFT JOIN reception ON advance_supplier.id = reception.advance_supplier_id LEFT JOIN product ON product.id = advance_supplier.product_id WHERE advance_supplier.id = ? AND reception.deleted != 1',array($advance_supplier_id));
		return $query;
	}

	public function get_receptions_central()
	{
		$query = $this->db->query('SELECT reception_central.id, reception_central.date AS reception_date, reception_central.quantity AS reception_quantity, note_reception, product.name AS product_name, dispatch_regional_id, regional.name AS regional_name FROM reception_central INNER JOIN dispatch_regional ON dispatch_regional.id = reception_central.dispatch_regional_id INNER JOIN product ON dispatch_regional.product_id = product.id INNER JOIN regional ON regional.id = reception_central.regional_id');
		return $query;
	}

	public function get_regional_dispatches($regional_id)
	{
		$query = $this->db->query('SELECT dispatch_regional.id, date, quantity, product.name AS product_name, dispatch_note FROM dispatch_regional INNER JOIN product ON product.id = dispatch_regional.product_id WHERE dispatch_status_id = 1 AND regional_id = ? AND to_id = ?', array($regional_id, $this->session->userdata('regional')));
		return $query;
	}

	public function get_dispatch_note($dispatch_id)
	{
		$query = $this->db->query('SELECT dispatch_note FROM dispatch_regional WHERE id = ?',array($dispatch_id));
		return $query;
	}

	public function set_reception_central($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('reception_central', $array);
		return $this->db->insert_id();
	}

	public function set_dispatch_status($id,$status)
	{
		$this->db->where('id', $id);
		$this->db->update('dispatch_regional', array("dispatch_status_id" => $status));
	}

	public function get_last_reception_central()
	{
		$query = $this->db->query('SELECT reception_central.id, reception_central.date AS reception_date, reception_central.quantity AS reception_quantity, note_reception, product.name AS product_name, dispatch_regional_id, regional.name AS regional_name FROM reception_central INNER JOIN dispatch_regional ON dispatch_regional.id = reception_central.dispatch_regional_id INNER JOIN product ON dispatch_regional.product_id = product.id INNER JOIN regional ON regional.id = reception_central.regional_id ORDER BY reception_central.id DESC LIMIT 1');
		return $query;
	}

	public function get_my_regional_dispatches()
	{
		$query = $this->db->query('SELECT dispatch_regional.id, date, quantity, product.name AS product_name, dispatch_note, regional.name AS regional_name, to_id, to_name, dispatch_status.name AS status FROM dispatch_regional INNER JOIN (SELECT regional.name AS to_name FROM dispatch_regional INNER JOIN regional ON regional.id = dispatch_regional.to_id) AS to_table INNER JOIN product ON product.id = dispatch_regional.product_id INNER JOIN regional ON regional.id = dispatch_regional.regional_id INNER JOIN dispatch_status ON dispatch_status.id = dispatch_regional.dispatch_status_id WHERE regional_id = '.$_SESSION['regional'].' GROUP BY dispatch_regional.id');
		return $query;
	}

	public function set_brands_reception($array)
	{
		$this->db->insert('brand_reception', $array);
	}

	public function get_brands_reception($id)
	{
		$query = $this->db->query('SELECT id, brand, quantity FROM brand_reception WHERE reception_id = ?', array($id));
		return $query;
	}

	public function set_selectable_product($id, $selectable)
	{
		$this->db->where('id', $id);
		$this->db->update('product', array("deleted" => $selectable));
	}

	public function update_product($id, $name)
	{
		$name = $this->security->xss_clean($name);
		$this->db->where('id', $id);
		$this->db->update('product', array("name" => $name));
	}

	public function exist_product_name($name)
	{
		$query = $this->db->query('SELECT id FROM product WHERE name = ? COLLATE utf8_bin', array($name));
		return $query->num_rows();
	}

	public function set_product($name)
	{
		$name = $this->security->xss_clean($name);
		$this->db->insert('product', array("name" => $name, "deleted" => 0));
		return $this->db->insert_id();
	}

	public function get_last_product()
	{
		$query = $this->db->query('SELECT id, name, deleted FROM product ORDER BY id DESC LIMIT 1');
		return $query;		
	}

	public function get_regional_dispatches_by_id($id = "")
	{
		$query = $this->db->query('SELECT dispatch_regional.id, date, quantity, product.name AS product_name, dispatch_note, regional_id, regional.name AS regional_name, product_id, product.name AS product_name, to_regional_name FROM dispatch_regional INNER JOIN product ON product.id = dispatch_regional.product_id INNER JOIN regional ON regional.id = dispatch_regional.regional_id INNER JOIN (SELECT regional.name AS to_regional_name FROM dispatch_regional INNER JOIN regional ON regional.id = dispatch_regional.to_id WHERE dispatch_regional.id = '.$id.') AS to_regional WHERE dispatch_regional.id = ?', array($id));
		return $query;
	}

	public function set_dispatch_regional($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert("dispatch_regional", $array);
		return $this->db->insert_id();
	}

	public function get_last_dispatch_regional()
	{
		$query = $this->db->query('SELECT dispatch_regional.id, date, quantity, product.name AS product_name, dispatch_note, regional.name AS regional_name, to_id, to_name, dispatch_status.name AS status FROM dispatch_regional INNER JOIN (SELECT regional.name AS to_name FROM dispatch_regional INNER JOIN regional ON regional.id = dispatch_regional.to_id) AS to_table INNER JOIN product ON product.id = dispatch_regional.product_id INNER JOIN regional ON regional.id = dispatch_regional.regional_id INNER JOIN dispatch_status ON dispatch_status.id = dispatch_regional.dispatch_status_id WHERE regional_id = '.$_SESSION['regional'].' GROUP BY dispatch_regional.id ORDER BY id DESC LIMIT 1');
		return $query;		
	}

	public function send_low_rest_alert($reception_array, $new_balance)
	{
		foreach ($reception_array as $key => $value) {
			$reception_id = $value['id'];
			$advance_id = $value['advance_supplier_id'];
			$supplier = $value['supplier_name'];
			$department = $value['department_name'];
			$city = $value['city_name'];
			$product = $value['product_name'];
			$supplier_id = $value['supplier_id'];
			$name_method = $value['name_method'];
			$rut_method = $value['rut_method'];
			$bankcenter_method = $value['bankcenter_method'];
			$account_method = $value['account_method'];

		}

		$this->load->model('Proveedores_model', 'suppliers');
		$query_banks = $this->suppliers->get_supplier_banks($supplier_id);	
		$query_centers = $this->suppliers->get_supplier_centers($supplier_id);	

		$banks = "";
		if(!empty($query_banks->result_array())) {

			foreach ($query_banks->result_array() as $key => $value) {
				$banks .= "<p>Banco: ".$value['bank']."</p>";
				$banks .= "<p>Nombre: ".$value['name']."</p>";
				$banks .= "<p>CC / NIT: ".$value['rut']."</p>";
				$banks .= "<p>Cuenta: ".$value['account']."</p>";
				$banks .= "<p>Tipo de Cuenta: ".$value['type_account']."</p>";
				$banks .= "<br>";
			}
		}

		$centers = "";
		if(!empty($query_centers->result_array())) {

			foreach ($query_centers->result_array() as $key => $value) {
				$centers .= "<p>Centro de Pago: ".$value['center']."</p>";
				$centers .= "<p>Nombre: ".$value['name']."</p>";
				$centers .= "<p>CC / NIT: ".$value['rut']."</p>";
				$centers .= "<p>Lugar: ".$value['location']."</p>";
				$centers .= "<br>";
			}
		}

		if($banks == "" && $centers == "") {
			$banks = "Sin datos de pago adicionales registrados<br>";
		}

		$this->load->model('Usuarios_model', 'users');
		$users_alert = $this->users->get_users_alert();

		$array_emails = [];
		foreach ($users_alert->result_array() as $key => $value) {
			$array_emails[] = $value['email'];
		}
		 
		$this->load->library("email");

		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.derivadoscarnicos.com',
			'smtp_port' => 26,
			'smtp_user' => 'no-reply@derivadoscarnicos.com',
			'smtp_pass' => '71@u[OhS%=}6',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
			);  

 		/*Load configuration*/
		 $this->email->initialize($configGmail);
		 
		 $this->email->from('no-reply@derivadoscarnicos.com');
		 $this->email->to($array_emails);
		 $this->email->subject('Alerta de Derivados Cárnicos');

		 $this->email->message('<h2>El siguiente proveedor tiene saldo igual o menor a 100.000 pesos en anticipos</h2><br><br><p>Proveedor: '.$supplier.'</p><p>Dpto - Ciudad: '.$department.' - '.$city.'</p><p>Saldo actual: '.$new_balance.'</p><p>Recepción N°: '.$reception_id.'</p><br><b>DATOS DE PAGO: </b><br>Medio de Pago Principal:<br>Nombre: '.$name_method.'<br>CC / NIT: '.$rut_method.'<br>Banco / Centro de Pago: '.$bankcenter_method.'<br>Cuenta: '.$account_method.'<br><br>'.$banks.$centers.'<p>Este mensaje es generado automáticamente</p>');
		 
		 /*var_dump($this->email->print_debugger());*/
		 if($this->email->send()) {
		 	return TRUE;
		 } else {
		 	return FALSE;
		 }

	}

	public function set_reception_img($array)
	{
		$array = $this->security->xss_clean($array);
		$this->db->insert('reception_img', $array);
		return $this->db->insert_id();
	}

	public function get_receptions_imgs()
	{
		$query = $this->db->query('SELECT id, title, description, file_name FROM reception_img');
		return $query;
	}

	public function remove_brands($reception_id)
	{
		$this->db->delete('brand_reception', array("reception_id" => $reception_id));
	}

}

/* End of file Bodega_model.php */
/* Location: ./application/models/Bodega_model.php */