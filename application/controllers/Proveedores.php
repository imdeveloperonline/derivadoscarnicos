<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Proveedores_model','suppliers');
	}

	public function index()
	{
		/******** Consultar Proveedores *******/
		$result_suppliers = $this->suppliers->get_suppliers();

		/******** Consultar Frigoríficos *******/
		$this->load->model('Frigorificos_model','shambles');
		$result_shambles = $this->shambles->get_shambles();

		/******** Consultar Ciudades para formulario de registro *******/
		$this->load->model('Location_model');
		$result_cities = $this->Location_model->get_cities();				

		$dato['recursos'] = array(
				"suppliers" => $result_suppliers->result_array(),
				"cities" => $result_cities->result_array(),
				"shambles" => $result_shambles->result_array()
			);		

		$dato['page'] = "suppliers";
		$dato['footer'] = array('suppliers');
		$this->load->view('home',$dato);
	}

	public function new_supplier() {

		$params = $_POST['data'];

		$params['deleted'] = 0;

		$exist_supplier_rut = $this->suppliers->exist_supplier_rut($params['rut']);

		if($params['rut'] != "" && $exist_supplier_rut > 0){



			?>
				<div id="message" class="alert alert-block alert-warning">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Ya existe</h4>
					<p>
						Este proveedor (<?= $params['rut'] ?>) ya existe en la base de datos
					</p>
				</div>

			<?php

		}else{
			
			$shambles = $params['shamble_id'];
			unset($params['shamble_id']);

			$supplier_id = $this->suppliers->new_supplier($params);


			if($this->db->affected_rows() > 0) {


				$this->load->model('Usuarios_model', 'users');
				$array = array(
					"date" => date("Y-m-d H:i:s"),
					"record_id" => $supplier_id,
					"user_id" => $_SESSION['id'],
					"operation_id" => 1,
					"table" => "Proveedor"

				);

				$this->users->set_user_operation($array);

				$shamble_inserts = $this->suppliers->set_supplier_shambles($supplier_id, $shambles);

				if($shamble_inserts < 1){
					?>
					<div id="message" class="alert alert-block alert-warning">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
						<p>
							El proveedor ha sido registrado EXITOSAMENTE. Sin embargo ocurrió un error al registrar los frigoríficos. Por favor utilice la function de edición para agregar los frigoríficos.
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
							El proveedor ha sido registrado EXITOSAMENTE. <?= $shamble_inserts ?> frigorífico(s) registrado(s)
						</p>
					</div>
					<script>
						setTimeout(function() {
							$('#message').fadeOut('slow',function() { 
								$('#message').remove(); 
								document.getElementById('new-supplier-form').reset(); });
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
						Ha ocurrido un error al registrar el proveedor. La página se recargará para intentar corregirlo.
					</p>
				</div>
				<script>
					setTimeout(function(){
						window.location.reload();
					},5000);
				</script>

				<?php


			} //End ifelse affected rows
		} //End ifelse $EXIST_SUPPLIER_RUT

		
		
	}

	public function get_last_supplier ()
	{
		$query = $this->suppliers->get_last_supplier();
		$result = $query->result_array();

		foreach ($result as $key => $value) {

			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['supplier_name']; ?></td>
					<td><?= $value['city_name']; ?></td>
					<td><?= $value['phone']; ?></td>
					<td><?= $value['email']; ?></td>
					<td><?= $value['shamble_name']; ?></td>													
					<td>
						&nbsp;
						<a href="<?= base_url() . 'proveedores/detalle/' . $value['id']; ?>">
							<i class="fa fa-eye fa-lg" title="Detalles"></i>
						</a>
						&nbsp; 
						
						&nbsp;
						<a href="<?= base_url() . 'proveedores/editar/' . $value['id']; ?>" title="Editar Proveedor">
							<i class="fa fa-pencil fa-lg"></i>
						</a>
						&nbsp;

						&nbsp;
						<a href="<?= base_url() . 'proveedores/contactos/' . $value['id']; ?>" title="Personas de Contacto">
							<i class="fa fa-user fa-lg"></i>
						</a>
						&nbsp;

						&nbsp;
						<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Eliminar Proveedor" onclick="javascript:set_modal(<?= $value['id'] ?>)">
							<i class="fa fa-trash fa-lg"></i>
						</a>
						&nbsp;

					</td>
				</tr>
			<?php

		}	 //End foreach
	}

	public function detalle ($supplier_id)
	{
		$supplier = $this->suppliers->get_supplier($supplier_id);
		$data['recursos'] = $supplier->result_array();
		
		$data['page'] = 'supplier_details';
		$this->load->view('home', $data);
	}

	public function editar ($supplier_id)
	{
		$supplier = $this->suppliers->get_supplier($supplier_id);

		$shambles_supplier = $this->suppliers->get_shambles_supplier($supplier_id);

		$this->load->model('Frigorificos_model','shambles');
		$shambles = $this->shambles->get_shambles();

		$this->load->model('Location_model');
		$cities = $this->Location_model->get_cities();
		$departments = $this->Location_model->get_departments();
		$countries = $this->Location_model->get_countries();

		$data['recursos'] = array(
				"supplier" => $supplier->result_array(),
				"shambles" => $shambles->result_array(),
				"cities" => $cities->result_array(),
				"departments" => $departments->result_array(),
				"countries" => $countries->result_array(),
				"shambles_supplier" => $shambles_supplier->result_array()
			);
		
		$data['page'] = 'supplier_update';
		$data['footer'] = array('supplier_update');
		$this->load->view('home', $data);
	}

	public function update_supplier ()
	{
		$supplier = $_POST['data'];

		$supplier_id = $supplier['id'];
		unset($supplier['id']);

		$shambles = $supplier['shamble_id'];
		unset($supplier['shamble_id']);

		$update = $this->suppliers->update_supplier($supplier,$supplier_id);

		if ($update) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $supplier_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Proveedor"

			);

			$this->users->set_user_operation($array);

			$shambles_insert = $this->suppliers->update_shambles_supplier($supplier_id, $shambles);

			if($shambles_insert < 1) {
				?>
				<div id="message" class="alert alert-block alert-warning">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El proveedor ha sido ACTUALIZADO exitosamente. Sin embargo los frigoríficos NO fueron registrados. Por favor recargue la página e intente nuevamente.
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
					El proveedor ha sido ACTUALIZADO exitosamente. <?= $shambles_insert ?> frigorífico(s) registrado(s)
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						window.location.reload();
					});
				},5000);
			</script>
			<?php
		} else {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al tratar de actualizar este registro. La página se recargará para intentar corregirlo.
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

	public function delete_supplier ()
	{
		$id = $_POST['id'];

		$this->suppliers->delete_supplier($id);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Proveedor"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El proveedor ha sido ELIMINADO exitosamente
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php
		} else {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al tratar de eliminar este registro. La página se recargará para intentar corregirlo.
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

	public function contactos ($supplier_id)
	{
		$data['recursos'] = $this->suppliers->get_supplier_persons($supplier_id);
		
		$data['page'] = 'supplier_person';
		$data['footer'] = array('supplier_person');
		$this->load->view('home', $data);
	}

	public function new_person_supplier ($supplier_id)
	{
		$person_array = $_POST['data'];

		$person_array['deleted'] = 0;
		$person_array['supplier_id'] = $supplier_id;

		$person_supplier_id = $this->suppliers->new_person_supplier($person_array);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $person_supplier_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Persona de Contacto Proveedor"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					La persona de contacto ha sido REGISTRADA exitosamente
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						window.location.reload();
					});
				},5000);
			</script>
			<?php
		} else {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al tratar de realizar este registro. La página se recargará para intentar corregirlo.
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

	public function delete_supplier_person () 
	{
		$person_supplier_id = $_POST['data'];

		$this->suppliers->delete_supplier_person($person_supplier_id['id']);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $person_supplier_id['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Persona de Contacto Proveedor"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					La persona de contacto ha sido ELIMINADA exitosamente
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php
		} else {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al tratar de ELIMINAR este registro. La página se recargará para intentar corregirlo.
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

	public function update_supplier_person()
	{
		$person_array = $_POST['data'];

		$supplier_person_id = $person_array['id'];
		unset($person_array['id']);

		$query = $this->suppliers->update_supplier_person($person_array,$supplier_person_id);

		if($this->db->affected_rows() > 0) {


			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $supplier_person_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Persona de Contacto Proveedor"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					La persona de contacto ha sido actualizada exitosamente
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php

		} else {

			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al actualizar la persona de contacto. La página se recargará para intentar corregirlo.
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

	public function medios_de_pago ($supplier_id)
	{
		$supplier = $this->suppliers->get_supplier($supplier_id);
		$banks = $this->suppliers->get_supplier_banks($supplier_id);
		$centers = $this->suppliers->get_supplier_centers($supplier_id);
		
		$data['recursos'] = array(
					"supplier" => $supplier->result_array(),
					"banks" => $banks->result_array(),
					"centers" => $centers->result_array()
			);
		
		$data['page'] = 'supplier_paymentinfo';
		$data['footer'] = array('supplier_paymentinfo');
		$this->load->view('home', $data);
	}

	public function new_bank_supplier($supplier_id)
	{
		$bank = $_POST['data'];

		$bank['deleted'] = 0;
		$bank['supplier_id'] = $supplier_id;

		$bank_supplier_id = $this->suppliers->new_bank_supplier($bank);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $bank_supplier_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Cuenta de Banco Proveedor"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					La nueva cuenta de banco ha sido REGISTRADA exitosamente
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						window.location.reload();
					});
				},5000);
			</script>
			<?php
		} else {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al tratar de realizar este registro. La página se recargará para intentar corregirlo.
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

	public function new_center_supplier($supplier_id)
	{
		$center = $_POST['data'];

		$center['deleted'] = 0;
		$center['supplier_id'] = $supplier_id;

		$center_supplier_id = $this->suppliers->new_center_supplier($center);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $center_supplier_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Centro de Pago Proveedor"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El nuevo centro de pago ha sido REGISTRADO exitosamente
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						window.location.reload();
					});
				},5000);
			</script>
			<?php
		} else {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al tratar de realizar este registro. La página se recargará para intentar corregirlo.
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

	public function update_supplier_bank()
	{
		$bank_array = $_POST['data'];

		$supplier_bank_id = $bank_array['id'];
		unset($bank_array['id']);

		$query = $this->suppliers->update_supplier_bank($bank_array,$supplier_bank_id);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $supplier_bank_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Cuenta de Banco Proveedor"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El registro ha sido actualizada exitosamente
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php

		} else {

			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al actualizar este registro. La página se recargará para intentar corregirlo.
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

	public function update_supplier_center()
	{
		$center_array = $_POST['data'];

		$supplier_center_id = $center_array['id'];
		unset($center_array['id']);

		$query = $this->suppliers->update_supplier_center($center_array,$supplier_center_id);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $supplier_center_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Centro de Pago Proveedor"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El registro ha sido actualizada exitosamente
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php

		} else {

			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al actualizar este registro. La página se recargará para intentar corregirlo.
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

	public function delete_supplier_bank () 
	{
		$supplier_bank_id = $_POST['data'];

		$this->suppliers->delete_supplier_bank($supplier_bank_id['id']);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $supplier_bank_id['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Cuenta de Banco Proveedor"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El registro ha sido ELIMINADO exitosamente
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php
		} else {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al tratar de ELIMINAR este registro. La página se recargará para intentar corregirlo.
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

	public function delete_supplier_center () 
	{
		$supplier_center_id = $_POST['data'];

		$this->suppliers->delete_supplier_center($supplier_center_id['id']);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $supplier_center_id['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Centro de Pago Proveedor"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El registro ha sido ELIMINADO exitosamente
				</p>
			</div>
			<script>
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php
		} else {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al tratar de ELIMINAR este registro. La página se recargará para intentar corregirlo.
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

	public function get_supplier_shambles_by_regional()
	{
		$supplier_id = $_POST['supplier_id'];

		$query = $this->suppliers->get_supplier_shambles_by_regional($supplier_id);

		if(count($query->result_array()) > 0){
			$shambles = "<option value='' disabled='' selected=''>Seleccione un frigorífico</option>";
			foreach ($query->result_array() as $key => $value) {
				$shambles .= "<option value='".$value['id']."'>".$value['tradename']."</option>";
			}
		} else {
			$shambles = "<option value='' disabled='' selected=''>No se encontraron frigoríficos registrados para este proveedor</option>";
		}		

		echo $shambles;

	}

}

/* End of file Proveedores.php */
/* Location: ./application/controllers/Proveedores.php */