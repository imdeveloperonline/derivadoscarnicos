<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lugares extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Location_model', 'locations');
	}

	public function index()
	{
		
	}

	public function paises()
	{
		$countries = $this->locations->get_countries();

		$dato['recursos'] = array(
				"countries" => $countries->result_array()
			);		

		$dato['page'] = "location_countries";
		$dato['footer'] = array('location_countries');
		$this->load->view('home',$dato);
	}

	public function set_country()
	{
		$params = $_POST['data'];

		$exist_country = $this->locations->exist_country($params['name']);

		if($exist_country > 0) {
			
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					El nombre del país ya existe en la base de datos. Imposible repetir.
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php

			exit();
		}

		$country_id = $this->locations->set_country($params['name']);


		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $country_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "País"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El país ha sido registrado correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('new-location-form').reset();
						window.location.reload();
					});
				},5000);
			</script>				
			<?php 
				
			
		} else { // If el cliente no fue registrado correctamente
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar el país. La página se recargará para intentar corregirlo.
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

	public function update_country()
	{
		$params = $_POST['data'];

		$exist_country = $this->locations->exist_country($params['name']);

		if($exist_country > 0) {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					El nombre del país ya existe en la base de datos. Imposible repetir.
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php

			exit();
		}
		
		$this->locations->update_country($params['id'],$params['name']);


		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $params['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "País"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El país ha sido actualizado correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('new-location-form').reset();
						window.location.reload();
					});
				},5000);
			</script>				
			<?php 
				
			
		} else { // If el cliente no fue registrado correctamente
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al actualizar el registro. La página se recargará para intentar corregirlo.
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

	public function departamentos()
	{
		$departments = $this->locations->get_departments();

		$countries = $this->locations->get_countries();

		$dato['recursos'] = array(
				"departments" => $departments->result_array(),
				"countries" => $countries->result_array()
			);		

		$dato['page'] = "location_departments";
		$dato['footer'] = array('location_departments');
		$this->load->view('home',$dato);
	}

	public function set_department()
	{
		$params = $_POST['data'];

		$exist_department = $this->locations->exist_department($params['name'],$params['country_id']);

		if($exist_department > 0) {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					El nombre del departmento ya existe en la base de datos. Imposible repetir.
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php

			exit();
		}

		$department_id = $this->locations->set_department($params['name'],$params['country_id']);


		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $department_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Departamento"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El departmento ha sido registrado correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('new-location-form').reset();
						window.location.reload();
					});
				},5000);
			</script>				
			<?php 
				
			
		} else { // If el cliente no fue registrado correctamente
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar el departamento. La página se recargará para intentar corregirlo.
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

	public function update_department()
	{
		$params = $_POST['data'];

		$exist_department = $this->locations->exist_department($params['name'],$params['country_id']);

		if($exist_department > 0) {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					El nombre del departmento ya existe en la base de datos. Imposible repetir.
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php

			exit();
		}
		
		$department_id = $this->locations->update_department($params['id'],$params['name'],$params['country_id']);


		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $department_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Departamento"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El departmento ha sido actualizado correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('new-location-form').reset();
						window.location.reload();
					});
				},5000);
			</script>				
			<?php 
				
			
		} else { // If el cliente no fue registrado correctamente
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al actualizar el registro. La página se recargará para intentar corregirlo.
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

	public function ciudades()
	{
		$cities = $this->locations->get_cities();
		$departments = $this->locations->get_departments();

		$dato['recursos'] = array(
				"cities" => $cities->result_array(),
				"departments" => $departments->result_array()
			);		

		$dato['page'] = "location_cities";
		$dato['footer'] = array('location_cities');
		$this->load->view('home',$dato);
	}


	public function set_city()
	{
		$params = $_POST['data'];

		$exist_city = $this->locations->exist_city($params['name'],$params['department_id']);

		if($exist_city > 0) {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					El nombre de la ciudad ya existe en la base de datos. Imposible repetir.
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php

			exit();
		}

		$city_id = $this->locations->set_city($params['name'],$params['department_id']);


		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $city_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Ciudad"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					La ciudad ha sido registrado correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('new-location-form').reset();
						window.location.reload();
					});
				},5000);
			</script>				
			<?php 
				
			
		} else { // If el cliente no fue registrado correctamente
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar la ciudad. La página se recargará para intentar corregirlo.
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

	public function update_city()
	{
		$params = $_POST['data'];

		$exist_city = $this->locations->exist_city($params['name'],$params['department_id']);

		if($exist_city > 0) {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					El nombre de la ciudad ya existe en la base de datos. Imposible repetir.
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
					});
				},5000);
			</script>
			<?php

			exit();
		}
		
		$this->locations->update_city($params['id'],$params['name'],$params['department_id']);


		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $params['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Ciudad"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					La ciudad ha sido actualizada correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('new-location-form').reset();
						window.location.reload();
					});
				},5000);
			</script>				
			<?php 
				
			
		} else { // If el cliente no fue registrado correctamente
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al actualizar el registro. La página se recargará para intentar corregirlo.
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

/* End of file Lugares.php */
/* Location: ./application/controllers/Lugares.php */