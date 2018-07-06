<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finanzas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Finanzas_model', 'finances');
	}

	public function index()
	{
		
	}

	public function anticipos_proveedores()
	{
		/******** Consultar Proveedores *******/
		$adv_suppliers = $this->finances->get_adv_suppliers(3);

		$this->load->model('Proveedores_model', 'suppliers');		
		$suppliers = $this->suppliers->get_suppliers();

		$this->load->model('Bodega_model', 'storage');		
		$products = $this->storage->get_products();

		$dato['recursos'] = array(
				"adv_suppliers" => $adv_suppliers->result_array(),
				"suppliers" => $suppliers->result_array(),
				"products" => $products->result_array()
			);		

		$dato['page'] = "fin_adv_suppliers";
		$dato['footer'] = array('fin_adv_suppliers');
		$this->load->view('home',$dato);
	}

	public function decontado_proveedores()
	{
		/******** Consultar Proveedores *******/
		$adv_suppliers = $this->finances->get_adv_suppliers(1);

		$this->load->model('Proveedores_model', 'suppliers');		
		$suppliers = $this->suppliers->get_suppliers();

		$this->load->model('Bodega_model', 'storage');		
		$products = $this->storage->get_products();

		$dato['recursos'] = array(
				"adv_suppliers" => $adv_suppliers->result_array(),
				"suppliers" => $suppliers->result_array(),
				"products" => $products->result_array()
			);		

		$dato['page'] = "fin_cash_suppliers";
		$dato['footer'] = array('fin_adv_suppliers');
		$this->load->view('home',$dato);
	}

	public function credito_proveedores()
	{
		/******** Consultar Proveedores *******/
		$adv_suppliers = $this->finances->get_adv_suppliers(2);

		$this->load->model('Proveedores_model', 'suppliers');		
		$suppliers = $this->suppliers->get_suppliers();

		$this->load->model('Bodega_model', 'storage');		
		$products = $this->storage->get_products();

		$dato['recursos'] = array(
				"adv_suppliers" => $adv_suppliers->result_array(),
				"suppliers" => $suppliers->result_array(),
				"products" => $products->result_array()
			);		

		$dato['page'] = "fin_credit_suppliers";
		$dato['footer'] = array('fin_credit_suppliers');
		$this->load->view('home',$dato);
	}

	public function registrar_pago($advance_supplier_id)
	{
		
		$credit_payments = $this->finances->get_credit_payments($advance_supplier_id);

		$dato['recursos'] = array(
				"credit_payments" => $credit_payments->result_array()
		);

		$dato['page'] = "fin_credit_pay_register";
		$dato['footer'] = array('fin_credit_pay_register');
		$this->load->view('home',$dato);
	}

	public function editar_anticipo_proveedor($advance_supplier_id)
	{
		/******** Consultar Proveedores *******/
		$adv_supplier = $this->finances->get_adv_supplier($advance_supplier_id);

		$this->load->model('Proveedores_model', 'suppliers');		
		$suppliers = $this->suppliers->get_suppliers();

		$this->load->model('Bodega_model', 'storage');		
		$products = $this->storage->get_products();

		$dato['recursos'] = array(
				"advance_supplier" => $adv_supplier->result_array(),
				"suppliers" => $suppliers->result_array(),
				"products" => $products->result_array()
			);		

		$dato['page'] = "fin_adv_supplier_update";
		$dato['footer'] = array('fin_adv_supplier_update');
		$this->load->view('home',$dato);
	}

	public function update_adv_supplier()
	{
		$params = $_POST['data'];
		$id = $params['id'];
		unset($params['id']);

		$update = $this->finances->update_adv_supplier($id,$params);

		if ($update) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Anticipo a Proveedor"

			);

			$this->users->set_user_operation($array);


			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					Se ha actualizado el registro EXITOSAMENTE
				</p>
			</div>
			<script>
				setTimeout(function() {
					$('#message').fadeOut('slow',function() { 
						$('#message').remove(); 
						document.getElementById('update-form').reset(); });
				}, 5000);
			</script>

			<?php
		} else {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ocurrió un error al actualizar el registro. La página se recargará para intentar conrregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php
		}
	}

	public function update_pay_adv_client()
	{
		$params = $_POST['data'];
		$id = $params['id'];
		unset($params['id']);

		$this->finances->update_pay_adv_client($id,$params);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Pago Transacción Cliente"

			);

			$this->users->set_user_operation($array);


			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					Se ha actualizado el registro EXITOSAMENTE
				</p>
			</div>
			<script>
				setTimeout(function() {
					$('#message').fadeOut('slow',function() { 
						$('#message').remove(); 
						document.getElementById('update-form').reset(); });
				}, 5000);
				$("#amount_<?= $id ?>").html("<?= $params['amount'] ?>");
				$("#date_<?= $id ?>").html("<?= $params['date'] ?>");
			</script>

			<?php
		} else {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ocurrió un error al actualizar el registro. La página se recargará para intentar conrregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php
		}
	}

	public function set_credit_payment()
	{
		$params = [];
		parse_str($_POST['data'],$params);

		$query = $this->finances->get_credit_balance($params['advance_supplier_id']);
		$credit_balance = $query->result_array()[0]['balance'];

		if(($credit_balance - $params['amount']) < 0) {
			?>
				<div id="message" class="alert alert-block alert-danger">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
					<p>
						El monto de pago no puede ser mayor a la deuda
					</p>
				</div>
			<?php
			exit();
		}

		$credit_payment_id = $this->finances->set_credit_payment($params);

		if($this->db->affected_rows() > 0) {

			if(($credit_balance - $params['amount']) == 0) {
				$this->finances->set_paid_account_credit($params['advance_supplier_id']);
			}

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $credit_payment_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Pago Crédito Proveedor"

			);

			$this->users->set_user_operation($array);

			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El pago ha sido registrado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('pay-form').reset(); });
					}, 5000);
					fillTable("<?= $params['advance_supplier_id'] ?>");
				</script>
			<?php

		}else{
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar el pago. La página se recargará para intentar corregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php


		} 

	}

	public function set_pay_adv_client()
	{
		$params = [];
		parse_str($_POST['data'],$params);
		$advance_client_id = $params['advance_client_id'];
		$amount = $params['amount'];
		$date = $params['date'];

		$payment_adv_client_id = $this->finances->set_pay_adv_client($advance_client_id, $amount, $date);

		if($this->db->affected_rows() > 0) {


			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $payment_adv_client_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Pago Transacción Cliente"

			);

			$this->users->set_user_operation($array);
			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El pago ha sido registrado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('pay-form').reset(); });
					}, 5000);
					fillTable("<?= $params['advance_client_id'] ?>");
				</script>
			<?php

		}else{
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar el pago. La página se recargará para intentar corregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php


		} 

	}

	public function get_last_credit_payment($advance_supplier_id)
	{
		$query = $this->finances->get_last_credit_payment($advance_supplier_id);

		foreach ($query->result_array() as $key => $value) {
			$date = date("Y-m-d",strtotime($value['date']));
														?>
			<tr id="tr_<?= $value['id'] ?>">
				<td><?= $value['id']; ?></td>
				<td><span id="date_<?= $value['id'] ?>"><?= $date; ?></span></td> 
				<td><span id="amount_<?= $value['id'] ?>"><?= $value['amount']; ?></span></td>
				
				<td>
					&nbsp;
						<a href="#modal-update" title="Editar" data-toggle="modal" onclick="set_modal('<?= $value["id"]?>','<?= $date ?>','<?= $value["amount"]?>')">
							<i class="fa fa-lg fa-fw fa-pencil"></i>
						</a>
					&nbsp;

				</td>
			</tr>
			<?php
		}
	}

	public function get_last_pay_adv_client($advance_client_id)
	{
		$query = $this->finances->get_last_pay_adv_client($advance_client_id);

		foreach ($query->result_array() as $key => $value) {
			$date = strftime("%A %d-%m-%Y",strtotime($value['date']));
			?>
					<tr id="tr_<?= $value['id'] ?>">
						<td><?= $value['id']; ?></td>
						<td><span id="date_<?= $value['id'] ?>"><?= $date; ?></span></td>
						<td><span id="amount_<?= $value['id'] ?>"><?= $value['amount']; ?></span></td>
						
						<td>
							&nbsp;
								<a href="#modal-update" title="Editar" data-toggle="modal" onclick="set_modal('<?= $value["id"]?>','<?= $date ?>','<?= $value["amount"]?>')">
									<i class="fa fa-lg fa-fw fa-pencil"></i>
								</a>
							&nbsp;

						</td>
					</tr>
			<?php
		}
	}

	public function update_credit_payment()
	{
		$params = $_POST['data'];
		$id = $params['id'];
		unset($params['id']);

		$this->finances->update_credit_payment($id,$params);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Pago Crédito Proveedor"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					Se ha actualizado el registro EXITOSAMENTE
				</p>
			</div>
			<script>
				setTimeout(function() {
					$('#message').fadeOut('slow',function() { 
						$('#message').remove(); 
						document.getElementById('update-form').reset(); });
				}, 5000);
				$("#amount_<?= $id ?>").html("<?= $params['amount'] ?>");
				$("#date_<?= $id ?>").html("<?= $params['date'] ?>");
			</script>

			<?php
		} else {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ocurrió un error al actualizar el registro. La página se recargará para intentar conrregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php
		}
	}

	public function new_adv_supplier()
	{
		$advance = $_POST['data'];
		$advance['user_id'] = $this->session->userdata('id');
		$advance['regional_id'] = $this->session->userdata('regional');
		$advance['payed'] = 0;
		$advance['archived'] = 0;
		$advance['method_id'] = 3;
		$advance['new_mod'] = 1;

		$advance = $this->security->xss_clean($advance);

		$active_credit = $this->finances->get_credit_active_by_supplier($advance['supplier_id']);

		if(!empty($active_credit->result_array())) {

			$total = 0;
			foreach ($active_credit->result_array() as $key => $value) {
				$balance = $this->finances->get_credit_balance($value['id']);
				$total = $total + $balance->result_array()[0]['balance'];
			}

			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					El proveedor tiene un saldo de <?= $total ?> en créditos activos. No se pueden registrar anticipos hasta realizar el pago.
				</p>
			</div>

			<?php
			exit();
		}
		
		$adv_supplier_id = $this->finances->new_adv_supplier($advance);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $adv_supplier_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Transacción Proveedor"

			);

			$this->users->set_user_operation($array);

			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El anticipo ha sido registrado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('adv-supplier-form').reset(); });
					}, 5000);
					fillTable();
				</script>
			<?php

		}else{
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar el anticipo. La página se recargará para intentar corregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php


		} 

	}

	public function get_last_adv_supplier()
	{
		$query = $this->finances->get_last_adv_supplier();

		foreach ($query->result_array() as $key => $value) {

			
			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['supplier_name']; ?></td>
					<td><?= $value['amount']; ?></td>
					<td><?= $value['product_name']; ?></td>
					<td><?= $value['quantity']; ?></td>
					<td><?= strftime('%A %d-%m-%Y',strtotime($value['date'])); ?></td>
					<td><?= $value['method_name']; ?></td>
					<td><?= $value['quantity']; ?></td>													
					<td>
						<?php if($_SESSION['profile'] == 1) { ?>
						&nbsp;
						<a href="<?= base_url() ?>finanzas/editar_anticipo_proveedor/<?= $value['id'] ?>" >
							<i class="fa fa-pencil fa-lg" title="Editar Anticipo"></i>
						</a>
						&nbsp; 
						&nbsp;
						<a data-toggle="modal" href="#archive-modal" onclick="javascript:set_modal(<?= $value['id'] ?>)">
							<i class="fa fa-folder-open fa-lg" title="Archivar"></i>
						</a>
						&nbsp; 
						<?php } ?>
						
						&nbsp;
						<a href="<?= base_url() . 'bodega/recepciones_anticipo/' . $value['id']; ?>" title="Ver recepciones">
							<i class="fa fa-truck fa-lg"></i>
						</a>
						&nbsp;

					</td>
				</tr>
			<?php

		}
	}

	public function get_rest_advance()
	{
		$advance_id = $_POST['id'];

		$query = $this->finances->get_rest_advance($advance_id);
		$rest = $query->result_array()[0]['rest'];

		if($rest == NULL) {
			$rest = $query->result_array()[0]['quantity'];
		}

		echo $rest;
	}

	public function get_supplier_balance()
	{
		$supplier_id = $_POST['supplier_id'];

		$balance = $this->finances->get_supplier_balance($supplier_id);
		
		echo $balance;
	}

	public function get_rest_advance_exclude_this()
	{
		$advance_id = $_POST['advance_id'];
		$reception_id = $_POST['reception_id'];

		$query = $this->finances->get_rest_advance_exclude_this($advance_id,$reception_id);
		$rest = $query->result_array()[0]['rest'];

		if($rest == NULL) {
			$rest = $query->result_array()[0]['quantity'];
		}

		echo $rest;
	}

	public function archivar()
	{

		$params = $_POST['data'];
		$this->finances->archivar($params['id']);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $params['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Archivar Transacción Proveedor"

			);

			$this->users->set_user_operation($array);

			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El registro ha sido archivado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
					}, 5000);
				</script>
			<?php

		}else{
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al archivar el registro. La página se recargará para intentar corregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php


		}
	}

	public function anticipos_clientes()
	{
		/******** Consultar Proveedores *******/
		$adv_clients = $this->finances->get_adv_clients();

		$this->load->model('Client_model', 'clients');		
		$clients = $this->clients->get_clients();

		$this->load->model('Bodega_model', 'storage');		
		$products = $this->storage->get_products();

		$dato['recursos'] = array(
				"adv_clients" => $adv_clients->result_array(),
				"clients" => $clients->result_array(),
				"products" => $products->result_array()
			);		

		$dato['page'] = "fin_adv_clients";
		$dato['footer'] = array('fin_adv_clients');
		$this->load->view('home',$dato);
	}

	public function new_adv_client()
	{
		$advance = $_POST['data'];
		$advance['user_id'] = $this->session->userdata('id');
		$advance['regional_id'] = $this->session->userdata('regional');
		$advance['payed'] = 0;
		$advance['archived'] = 0;

		$advance = $this->security->xss_clean($advance);		
		$advance_id = $this->finances->new_adv_client($advance);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $advance_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Transacción Cliente"

			);

			$this->users->set_user_operation($array);

			$this->finances->set_pay_adv_client($advance_id, $advance['amount'], $advance['date']);

			if($this->db->affected_rows() < 1) {
				?>
				<div id="message" class="alert alert-block alert-warning">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						Los datos de la venta se han registrado EXITOSAMENTE. Sin embargo el pago inicial del anticipo no pudo ser registrado. Debe ser registrado manualmente utilizando la functión correspondiente. 
					</p>
				</div>

				<?php
				exit();
			}

			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						La transacción ha sido registrado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('adv-client-form').reset(); });
					}, 5000);
					fillTable();
				</script>
			<?php

		}else{
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar la transacción. La página se recargará para intentar corregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php


		} 

	}

	public function get_last_adv_client()
	{
		$query = $this->finances->get_last_adv_client();

		foreach ($query->result_array() as $key => $value) {

			
			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['client_name']; ?></td>
					<td><?= $value['total']; ?></td>
					<td><?= $value['product_name']; ?></td>
					<td><?= $value['quantity']; ?></td>
					<td><?= strftime('%A %d-%m-%Y',strtotime($value['date'])); ?></td>
					<td><?= $value['quantity']; ?></td>
					<td><?= $value['total']-$value['amount'] ?></td>													
					<td>
						&nbsp;
						<a data-toggle="modal" href="#archive-modal" onclick="javascript:set_modal(<?= $value['id'] ?>)">
							<i class="fa fa-folder-open fa-lg" title="Archivar"></i>
						</a>
						&nbsp; 
						
						&nbsp;
						<a href="<?= base_url() . 'bodega/despachos_anticipo/' . $value['id']; ?>" title="Ver despachos">
							<i class="fa fa-truck fa-lg"></i>
						</a>
						&nbsp;

						&nbsp;
						<a href="<?= base_url() . 'finanzas/pagos_clientes_transaccion/' . $value['id']; ?>" title="Ver/Registrar Pagos">
							<i class="fa fa-bank fa-lg"></i>
						</a>
						&nbsp;

					</td>
				</tr>
			<?php

		}
	}

	public function archive_adv_client()
	{

		$params = $_POST['data'];
		$this->finances->archive_adv_client($params['id']);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $params['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Archivar Transacción Cliente"

			);

			$this->users->set_user_operation($array);

			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El registro ha sido archivado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
					}, 5000);
				</script>
			<?php

		}else{
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al archivar el registro. La página se recargará para intentar corregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php


		}
	}

	public function pagos_clientes_transaccion($advance_client_id)
	{
		$pays = $this->finances->get_pays_adv_client($advance_client_id);

		$dato['recursos'] = array(
				"pays" => $pays->result_array()
			);		

		$dato['page'] = "fin_pays_adv_client";
		$dato['footer'] = array('fin_pays_adv_client');
		$this->load->view('home',$dato);
	}

	public function get_rest_advance_dispatch_client()
	{
		$advance_id = $_POST['id'];

		$query = $this->finances->get_rest_advance_dispatch_client($advance_id);
		$rest = $query->result_array()[0]['rest'];

		if($rest == NULL) {
			$rest = $query->result_array()[0]['quantity'];
		}

		echo $rest;
	}

	public function transacciones_proveedores_archivados()
	{
		/******** Consultar Proveedores *******/
		$adv_suppliers = $this->finances->get_adv_suppliers_archived();

		$this->load->model('Proveedores_model', 'suppliers');		
		$suppliers = $this->suppliers->get_suppliers();

		$this->load->model('Bodega_model', 'storage');		
		$products = $this->storage->get_products();

		$dato['recursos'] = array(
				"adv_suppliers" => $adv_suppliers->result_array(),
				"suppliers" => $suppliers->result_array(),
				"products" => $products->result_array()
			);		

		$dato['page'] = "fin_adv_suppliers_archived";
		$dato['footer'] = array('fin_adv_suppliers');
		$this->load->view('home',$dato);
	}

	public function anticipos_clientes_archivados()
	{
		/******** Consultar Proveedores *******/
		$adv_clients = $this->finances->get_adv_clients_archived();

		$this->load->model('Client_model', 'clients');		
		$clients = $this->clients->get_clients();

		$this->load->model('Bodega_model', 'storage');		
		$products = $this->storage->get_products();

		$dato['recursos'] = array(
				"adv_clients" => $adv_clients->result_array(),
				"clients" => $clients->result_array(),
				"products" => $products->result_array()
			);		

		$dato['page'] = "fin_adv_clients_archived";
		$dato['footer'] = array('fin_adv_clients');
		$this->load->view('home',$dato);
	}

	public function get_adv_by_supplier()
	{
		$supplier_id = $_POST['supplier_id'];

		$query = $this->finances->get_adv_by_supplier($supplier_id);

		?>
		<option value="" disabled="" selected="">Seleccione un anticipo</option>
		<?php


		if(!empty($query->result_array())) {
			foreach ($query->result_array() as $key => $value) {
				?>
				<option value="<?= $value['id'] ?>"><?= date("d-m-Y",strtotime($value['date']))." | ". $value['quantity'] ." | ".$value['product_name']; ?></option>

				<?php
			}
		} else {
			?>
			<option value="" disabled="" selected="">No existen anticipos</option>

			<?php
		}
	}

	public function get_precio_unitario_supplier()
	{
		$supplier_id = $_POST['supplier_id'];

		$query = $this->finances->get_precio_unitario_supplier($supplier_id);

		echo $query->result_array()[0]['precio_unitario'];
	}

	public function get_active_adv_supplier()
	{
		$supplier_id = $_POST['supplier_id'];

		$has_active_adv = $this->finances->get_active_adv_supplier($supplier_id);

		echo $has_active_adv;
	}

	public function get_credit_active_by_supplier()
	{
		$supplier_id = $_POST['supplier_id'];

		$active_credit = $this->finances->get_credit_active_by_supplier($supplier_id);

		if(!empty($active_credit->result_array())) {
			$total = 0;
			foreach ($active_credit->result_array() as $key => $value) {
				$balance = $this->finances->get_credit_balance($value['id']);
				$total = $total + $balance->result_array()[0]['balance'];
			}

			?>
			<div id="message-form" class="alert alert-block alert-warning">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-triangle-exclamation"></i> ¡Alerta!</h4>
				<p>
					El proveedor tiene un saldo de <?= $total ?> en créditos activos
				</p>
			</div>

			<?php

		} else {
			echo 0;
		}
	}

	public function pay_credits()
	{
		$advances = $_POST['advances'];

		$this->load->model('Usuarios_model', 'users');

		$query_total = $this->finances->get_total_by_supplier_in_these_advances($advances);

		foreach ($advances as $advance_supplier_id) {
			$query_balance = $this->finances->get_credit_balance($advance_supplier_id);
			$balance = $query_balance->result_array()[0]['balance'];
			$insert = $this->finances->set_complete_credit_pay($advance_supplier_id, $balance);	

			if($insert) {
				$insert_id = $this->db->insert_id();

				$array = array(
					"date" => date("Y-m-d H:i:s"),
					"record_id" => $insert_id,
					"user_id" => $_SESSION['id'],
					"operation_id" => 1,
					"table" => "Pago multiple de creditos"

				);

				$this->users->set_user_operation($array);
			} 

			$balance = "";

		}

		$table = "<table style='border: 1px solid black; border-collapse: collapse;'>";
		$table .= "";
		$table .= "<tr>";
			$table .= "<th style='border: 1px solid black;padding: 5px;'>ID</th>";
			$table .= "<th style='border: 1px solid black;padding: 5px;'>Proveedor</th>";
			$table .= "<th style='border: 1px solid black;padding: 5px;'>Pago</th>";
			$table .= "<th style='border: 1px solid black;padding: 5px;'>Nombre</th>";
			$table .= "<th style='border: 1px solid black;padding: 5px;'>CC o Rut</th>";
			$table .= "<th style='border: 1px solid black;padding: 5px;'>Banco o Centro</th>";
			$table .= "<th style='border: 1px solid black;padding: 5px;'>Cuenta</th>";
		$table .= "</tr>";
		$table .= "";
		$table .= "<tbody>";
		foreach ($query_total->result_array() as $key => $value) {
			
			$table .= "<tr>";
			$table .= "<td style='border: 1px solid black;padding: 5px;'>".$value['supplier_id']."</td>";
			$table .= "<td style='border: 1px solid black;padding: 5px;'>".$value['tradename']."</td>";
			$table .= "<td style='border: 1px solid black;padding: 5px;'>".$value['total']."</td>";
			$table .= "<td style='border: 1px solid black;padding: 5px;'>".$value['name_method']."</td>";
			$table .= "<td style='border: 1px solid black;padding: 5px;'>".$value['rut_method']."</td>";
			$table .= "<td style='border: 1px solid black;padding: 5px;'>".$value['bankcenter_method']."</td>";			
			$table .= "<td style='border: 1px solid black;padding: 5px;'>".$value['account_method']."</td>";
			$table .= "</tr>";
		}
		$table .= "</tbody>";
		$table .= "</table>";

		echo $table;
		?>
		<div style="padding-top: 10px; padding-bottom: 10px;">
			<form id="report_form" action="<?= base_url() ?>reportes/export_report" method="post" target="_blank">
				<input type="hidden" name="html_data" id="html_data" value="<?= $table ?>">
				<button type="submit" class="btn btn-primary center-block">
					Exportar PDF
					<i class="fa fa-external-link"></i>
				</button>
			</form>			
		</div>

		<?php
		


	}

}

/* End of file Finanzas.php */
/* Location: ./application/controllers/Finanzas.php */