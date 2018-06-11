<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Client_model');
	}

	public function index()
	{
		/******** Consultar Clientes *******/
		$result_clients = $this->Client_model->get_clients();

		/******** Consultar Ciudades para formulario de registro *******/
		$this->load->model('Location_model');
		$result_cities = $this->Location_model->get_cities();

		$dato['recursos'] = array(
				"clients" => $result_clients->result_array(), 
				"cities" => $result_cities->result_array()
			);
		

		$dato['page'] = "clientes";
		$dato['footer'] = array('datatables');
		$this->load->view('home',$dato);
	}

	public function set_new_client()
	{
		$params = $_POST['data'];

		/*** Datos del Cliente ***/
		$client = $params;
		$client['deleted'] = 0;

		$exist_client_rut = $this->Client_model->exist_client_rut($params['rut']);

		if($exist_client_rut > 0){



			?>
				<div id="message" class="alert alert-block alert-warning">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Ya existe</h4>
					<p>
						Este cliente (<?= $params['rut'] ?>) ya existe en la base de datos
					</p>
				</div>

			<?php

		}else {

			/*** Registro Nuevo Cliente ****/
			$client_id = $this->Client_model->set_new_client($client);

			if($this->db->affected_rows() > 0) { // If el ciente fue registrado exitosamente //
				
				$this->load->model('Usuarios_model', 'users');
				$array = array(
					"date" => date("Y-m-d H:i:s"),
					"record_id" => $client_id,
					"user_id" => $_SESSION['id'],
					"operation_id" => 1,
					"table" => "Cliente"

				);

				$this->users->set_user_operation($array);
				
				?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El cliente ha sido registrado correctamente
					</p>
				</div>
				<script type="text/javascript">
					setTimeout(function(){
						$('#message').fadeOut('slow', function() {
							$(this).remove(); 
							document.getElementById('new-client-form').reset();
						});
					},5000);
                  	fillTable();
				</script>				
				<?php 
					
				
			} else { // If el cliente no fue registrado correctamente
				?>
				<div class="alert alert-block alert-danger">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
					<p>
						Ha ocurrido un error al registrar el cliente. La página se recargará para intentar corregirlo.
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

		

	} // End function

	public function get_last_client ()
	{
		$query = $this->Client_model->get_last_client();
		$result = $query->result_array();

		foreach ($result as $key => $value) {
		?>

			<tr id="tr_<?= $value['id'] ?>">
				<td><?= $value['id']; ?></td>
				<td><?= $value['tradename']; ?></td>
				<td><?= $value['city_name']; ?></td>
				<td><?= $value['person_name'] . " " . $value['person_lastname']; ?></td>
				<td><?= $value['person_phone']; ?></td>
				<td><?= $value['person_email']; ?></td>
				<td>
					&nbsp;
					<a href="<?= base_url() . 'clientes/detalle/' . $value['id']; ?>">
						<i class="fa fa-eye fa-lg" title="Detalles"></i>
					</a>
					&nbsp; 
					&nbsp;
					<a href="<?= base_url() . 'clientes/contactos/' . $value['id']; ?>" title="Personas de Contacto">
						<i class="fa fa-user fa-lg"></i>
					</a>
					&nbsp;
					&nbsp;
					<a href="<?= base_url() . 'clientes/direcciones/' . $value['id']; ?>" title="Direcciones de Envío">
						<i class="fa fa-ship fa-lg"></i>
					</a>
					&nbsp; 
					&nbsp;
					<a href="<?= base_url() . 'clientes/editar/' . $value['id']; ?>" title="Editar Cliente">
						<i class="fa fa-pencil fa-lg"></i>
					</a>
					&nbsp;
					&nbsp;
					<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Eliminar Cliente" onclick="javascript:set_modal(<?= $value['id'] ?>)">
						<i class="fa fa-trash fa-lg"></i>
					</a>
					&nbsp;
				</td>
			</tr>

		<?php
		} //End foreach
	}

	public function detalle ($client_id)
	{
		$client = $this->Client_model->get_client($client_id);
		$data['recursos'] = $client->result_array();
		
		$data['page'] = 'client_details';
		$data['footer'] = array('client_person');
		$this->load->view('home', $data);
	}

	public function contactos ($client_id)
	{
		$data['recursos'] = $this->Client_model->get_client_persons($client_id);
		
		$data['page'] = 'client_person';
		$data['footer'] = array('client_person');
		$this->load->view('home', $data);
	}

	public function update_client_person()
	{
		$client_person_array = $_POST['data'];

		$client_person_id = $client_person_array['id'];
		unset($client_person_array['id']);

		$query = $this->Client_model->update_client_person($client_person_array,$client_person_id);

		if($this->db->affected_rows() > 0) {


			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $client_person_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Persona de Contacto Cliente"

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

	public function delete_client_person () 
	{
		$person_client_id = $_POST['data'];

		$this->Client_model->delete_client_person($person_client_id['id']);

		if($this->db->affected_rows() > 0) {
			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $person_client_id['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Persona de Contacto Cliente"

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

	public function new_person_client ($client_id)
	{
		$person_client_array = $_POST['data'];

		$person_client_array['deleted'] = 0;
		$person_client_array['client_id'] = $client_id;

		$person_client_id = $this->Client_model->new_person_client($person_client_array);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $person_client_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Persona de Contacto Cliente"

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

	public function direcciones ($client_id)
	{
		$this->load->model('Location_model');
		$result_cities = $this->Location_model->get_cities();
		$result_departments = $this->Location_model->get_departments();
		$result_countries = $this->Location_model->get_countries();

		$result_client_addresses = $this->Client_model->get_client_addresses($client_id);

		$data['recursos'] = array(
				"cities" => $result_cities->result_array(),
				"departments" => $result_departments->result_array(),
				"countries" => $result_countries->result_array(),
				"client_addresses" => $result_client_addresses->result_array()
			);

		
		$data['page'] = 'client_address';
		$data['footer'] = array('client_address');
		$this->load->view('home', $data);
	}

	public function update_client_address()
	{
		$array_address = $_POST['data'];

		$address_id = $array_address['id'];
		unset($array_address['id']);

		$this->Client_model->update_client_address($array_address,$address_id);
		

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $address_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Dirección de Envío Cliente"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					La dirección de envío ha sido ACTUALIZADA exitosamente
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

	public function delete_client_address () 
	{
		$address_client_id = $_POST['data'];

		$this->Client_model->delete_client_address($address_client_id['id']);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $address_client_id['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Dirección de Envío Cliente"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					La dirección de envío ha sido ELIMINADA exitosamente
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

	public function new_address_client ($client_id)
	{
		$address_client_array = $_POST['data'];

		$address_client_array['deleted'] = 0;
		$address_client_array['client_id'] = $client_id;

		$address_client_id = $this->Client_model->new_address_client($address_client_array);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $address_client_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Dirección de Envío Cliente"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					La nueva dirección de envío ha sido REGISTRADA exitosamente
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
	
	public function editar ($client_id)
	{
		$client = $this->Client_model->get_client($client_id);

		$this->load->model('Location_model');
		$cities = $this->Location_model->get_cities();
		$departments = $this->Location_model->get_departments();
		$countries = $this->Location_model->get_countries();

		$data['recursos'] = array(
				"client" => $client->result_array(),
				"cities" => $cities->result_array(),
				"departments" => $departments->result_array(),
				"countries" => $countries->result_array()
			);
		
		$data['page'] = 'client_update';
		$data['footer'] = array('client_update');
		$this->load->view('home', $data);
	}

	public function update_client ()
	{
		$array_client = $_POST['data'];
		$client_id = $array_client['id'];
		unset($array_client['id']);

		$this->Client_model->update_client($array_client,$client_id);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $client_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Cliente"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El cliente ha sido ACTUALIZADO exitosamente
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

	public function delete_client ()
	{
		$id = $_POST['data']['id'];

		$this->Client_model->delete_client($id);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Cliente"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El cliente ha sido ELIMINADO exitosamente
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

	public function get_client_addresses($advance_client_id)
	{
		$this->load->model('Finanzas_model', 'finances');
		$client_id = $this->finances->get_client_by_advance($advance_client_id);

		$client_addresses = $this->Client_model->get_client_addresses($client_id->result_array()[0]['client_id']);

		if($client_addresses->result_array()[0]['address_id'] != NULL){

				?>
				<option value="" selected="" disabled="">Seleccione una dirección de envio</option>

				<?php
			foreach ($client_addresses->result_array() as $key => $value) {
				?>
				<option value="<?= $value['address_id'] ?>"><?= $value['send_address'] ?>, <?= $value['address_zip'] ?>, <?= $value['address_city'] ?>, <?= $value['department_name'] ?>, <?= $value['country_name'] ?> </option>

				<?php
			}
		}else {
			?>
			<option value="" selected="" disabled="">Debe registrar una dirección de envio para este cliente</option>

			<?php
		}

		
	}

}

/* End of file Cliente.php */
/* Location: ./application/controllers/Cliente.php */