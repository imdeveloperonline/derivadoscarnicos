<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frigorificos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Frigorificos_model','shambles');
	}

	public function index()
	{
		$result_shambles = $this->shambles->get_shambles();

		/******** Consultar Ciudades para formulario de registro *******/
		$this->load->model('Location_model');
		$result_cities = $this->Location_model->get_cities();

		$dato['recursos'] = array(
				"cities" => $result_cities->result_array(),
				"shambles" => $result_shambles->result_array()
			);		

		$dato['page'] = "shambles";
		$dato['footer'] = array('shambles');
		$this->load->view('home',$dato);
	}

	public function new_shamble() {

		$params = $_POST['data'];

		$params['deleted'] = 0;

		$exist_shamble_rut = $this->shambles->exist_shamble_rut($params['rut']);

		if($exist_shamble_rut > 0){



			?>
				<div id="message" class="alert alert-block alert-warning">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Ya existe</h4>
					<p>
						Este frigorífico (<?= $params['rut'] ?>) ya existe en la base de datos
					</p>
				</div>

			<?php

		}else{
			
			$shamble_id = $this->shambles->new_shamble($params);


			if($this->db->affected_rows() > 0) {

				$this->load->model('Usuarios_model', 'users');
				$array = array(
					"date" => date("Y-m-d H:i:s"),
					"record_id" => $shamble_id,
					"user_id" => $_SESSION['id'],
					"operation_id" => 1,
					"table" => "Frigorífico"

				);

				$this->users->set_user_operation($array);
				?>
					<div id="message" class="alert alert-block alert-success">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
						<p>
							El frigorífico ha sido registrado EXITOSAMENTE
						</p>
					</div>
					<script>
						setTimeout(function() {
							$('#message').fadeOut('slow',function() { 
								$('#message').remove(); 
								document.getElementById('new-shamble-form').reset(); });
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
						Ha ocurrido un error al registrar el frigorífico. La página se recargará para intentar corregirlo.
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

	public function get_last_shamble ()
	{
		$query = $this->shambles->get_last_shamble();
		$result = $query->result_array();

		foreach ($result as $key => $value) {

			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['tradename']; ?></td>
					<td><?= $value['city_name']; ?></td>
					<td><?= $value['phone']; ?></td>
					<td><?= $value['email']; ?></td>												
					<td>
						&nbsp;
						<a href="<?= base_url() . 'frigorificos/detalle/' . $value['id']; ?>">
							<i class="fa fa-eye fa-lg" title="Detalles"></i>
						</a>
						&nbsp; 
						
						&nbsp;
						<a href="<?= base_url() . 'frigorificos/editar/' . $value['id']; ?>" title="Editar Frigorífico">
							<i class="fa fa-pencil fa-lg"></i>
						</a>
						&nbsp;

						&nbsp;
						<a href="<?= base_url() . 'frigorificos/contactos/' . $value['id']; ?>" title="Personas de Contacto">
							<i class="fa fa-user fa-lg"></i>
						</a>
						&nbsp;

						&nbsp;
						<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Eliminar Frigorífico" onclick="javascript:set_modal(<?= $value['id'] ?>)">
							<i class="fa fa-trash fa-lg"></i>
						</a>
						&nbsp;

					</td>
				</tr>
			<?php

		}	 //End foreach
	}

	public function detalle ($shamble_id)
	{
		$shamble = $this->shambles->get_shamble($shamble_id);
		$data['recursos'] = $shamble->result_array();
		
		$data['page'] = 'shamble_details';
		$this->load->view('home', $data);
	}

	public function editar ($shamble_id)
	{
		$shamble = $this->shambles->get_shamble($shamble_id);

		$this->load->model('Location_model');
		$cities = $this->Location_model->get_cities();
		$departments = $this->Location_model->get_departments();
		$countries = $this->Location_model->get_countries();

		$data['recursos'] = array(
				"shamble" => $shamble->result_array(),
				"cities" => $cities->result_array(),
				"departments" => $departments->result_array(),
				"countries" => $countries->result_array()
			);
		
		$data['page'] = 'shamble_update';
		$data['footer'] = array('shamble_update');
		$this->load->view('home', $data);
	}

	public function update_shamble ()
	{
		$shamble = $_POST['data'];
		$shamble_id = $shamble['id'];
		unset($shamble['id']);

		$this->shambles->update_shamble($shamble,$shamble_id);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $shamble_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Frigorífico"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El frigorífico ha sido ACTUALIZADO exitosamente
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

	public function delete_shamble ()
	{
		$id = $_POST['id'];

		$this->shambles->delete_shamble($id);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Frigorífico"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El frigorífico ha sido ELIMINADO exitosamente
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

	public function contactos ($shamble_id)
	{
		$data['recursos'] = $this->shambles->get_shamble_persons($shamble_id);
		
		$data['page'] = 'shamble_person';
		$data['footer'] = array('shamble_person');
		$this->load->view('home', $data);
	}

	public function new_person_shamble ($shamble_id)
	{
		$person_array = $_POST['data'];

		$person_array['deleted'] = 0;
		$person_array['shamble_id'] = $shamble_id;

		$person_shamble_id = $this->shambles->new_person_shamble($person_array);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $person_shamble_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Persona de Contacto Frigorífico"

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

	public function delete_shamble_person () 
	{
		$person_id = $_POST['data'];

		$this->shambles->delete_shamble_person($person_id['id']);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $person_id['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Persona de Contacto Frigorífico"

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

	public function update_shamble_person()
	{
		$person_array = $_POST['data'];

		$shamble_person_id = $person_array['id'];
		unset($person_array['id']);

		$query = $this->shambles->update_shamble_person($person_array,$shamble_person_id);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $shamble_person_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Persona de Contacto Frigorífico"

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

}

/* End of file Frigorificos.php */
/* Location: ./application/controllers/Frigorificos.php */