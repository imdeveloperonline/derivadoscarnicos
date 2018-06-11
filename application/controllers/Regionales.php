<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Regionales extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Regionales_model', 'regionals');
	}

	public function index() 
	{
		if(!in_array($_SESSION['profile'], array(1,2))) { 
			exit("Database Error");
		}
		/******** Consultar Regionales *******/
		$regionals = $this->regionals->get_regionals();

		$saldo = $this->regionals->get_saldo();

		/******** Consultar Ciudades para formulario de registro *******/
		$this->load->model('Location_model');
		$result_cities = $this->Location_model->get_cities();

		$dato['recursos'] = array(
				"regionals" => $regionals->result_array(), 
				"cities" => $result_cities->result_array(),
				"saldo" => $saldo
			);
		

		$dato['page'] = "regionals";
		$dato['footer'] = array('regionals');
		$this->load->view('home',$dato);
	}

	public function set_new_regional()
	{
		$params = $_POST['data'];

		/*** Datos del Regional ***/
		$regional = $params;
		$regional['deleted'] = 0;

		/*** Registro Nuevo Regional ****/
		$regional_id = $this->regionals->set_new_regional($regional);

		if($this->db->affected_rows() > 0) { // If el ciente fue registrado exitosamente //
								
			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $regional_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Regional"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El regional ha sido registrado correctamente
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
					Ha ocurrido un error al registrar el regional. La página se recargará para intentar corregirlo.
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

	public function get_last_regional ()
	{
		$query = $this->regionals->get_last_regional();
		$result = $query->result_array();

		foreach ($result as $key => $value) {
		?>

			<tr id="tr_<?= $value['id'] ?>">
				<td><?= $value['id']; ?></td>
				<td><?= $value['name']; ?></td>
				<td><?= $value['department_name'] . " - " .$value['city_name']; ?></td>
				<td>0</td>												
				<td>													
					&nbsp;
					<a href="<?= base_url() ?>regionales/editar/<?= $value['id'] ?>" title="Editar Regional">
						<i class="fa fa-pencil fa-lg"></i>
					</a>
					&nbsp;

					&nbsp;
					<a href="<?= base_url() ?>regionales/anticipos/<?= $value['id'] ?>" title="Anticipos">
						<i class="fa fa-bank fa-lg"></i>
					</a>
					&nbsp;

					&nbsp;
					<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Eliminar Regional" onclick="javascript:set_modal(<?= $value['id'] ?>)">
						<i class="fa fa-trash fa-lg"></i>
					</a>
					&nbsp;

				</td>
			</tr>

		<?php
		} //End foreach
	}

	public function delete_regional ()
	{
		$id = $_POST['id'];

		$this->regionals->delete_regional($id);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Regional"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El regional ha sido ELIMINADO exitosamente
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

	public function editar ($id)
	{
		$regional = $this->regionals->get_regional($id);

		$this->load->model('Location_model');
		$cities = $this->Location_model->get_cities();
		$departments = $this->Location_model->get_departments();
		$countries = $this->Location_model->get_countries();

		$data['recursos'] = array(
				"regional" => $regional->result_array(),
				"cities" => $cities->result_array(),
				"departments" => $departments->result_array(),
				"countries" => $countries->result_array()
			);
		
		$data['page'] = 'regional_update';
		$data['footer'] = array('regional_update');
		$this->load->view('home', $data);
	}

	public function update_regional ()
	{
		$array_regional = $_POST['data'];
		$regional_id = $array_regional['id'];
		unset($array_regional['id']);

		$this->regionals->update_regional($array_regional,$regional_id);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $regional_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Regional"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El regional ha sido ACTUALIZADO exitosamente
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

	public function recursos_humanos()
	{
		$employees = $this->regionals->get_employees();

		/******** Consultar Ciudades para formulario de registro *******/
		$this->load->model('Location_model');
		$result_cities = $this->Location_model->get_cities();

		$dato['recursos'] = array(
				"employees" => $employees->result_array(), 
				"cities" => $result_cities->result_array()
			);
		

		$dato['page'] = "regional_rrhh";
		$dato['footer'] = array('regional_rrhh');
		$this->load->view('home',$dato);
	}

	public function set_new_employee()
	{
		$params = $_POST['data'];

		/*** Datos del Regional ***/
		$regional = $params;
		$regional['deleted'] = 0;
		$regional['active'] = 0;
		$regional['creation_date'] = date("Y-m-d");
		$regional['regional_id'] = $_SESSION['regional'];

		/*** Registro Nuevo Regional ****/
		$employee_id = $this->regionals->set_new_employee($regional);

		if($this->db->affected_rows() > 0) { // If el ciente fue registrado exitosamente //
			
			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $employee_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Empleado Regional"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El empleado ha sido registrado correctamente
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
					Ha ocurrido un error al registrar el empleado. La página se recargará para intentar corregirlo.
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

	public function get_last_employee ()
	{
		$query = $this->regionals->get_last_employee();
		$result = $query->result_array();

		foreach ($result as $key => $value) {
			if($value['active'] == 1) {
				$active = '<i class="fa fa-check fa-lg text-success"></i>';
			} else {
				$active = '<i class="fa fa-close fa-lg text-danger"></i>';
			}
			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['name']." ".$value['lastname']; ?></td>
					<td><?= $value['dni']; ?></td>
					<td><?= $value['phone']; ?></td>
					<td><?= $value['email']; ?></td>
					<td><?= $value['regional_name']; ?></td>
					<td><?= $active; ?></td>
					<td>
						&nbsp;
						<a href="<?= base_url() . 'regionales/periodo_empleado/' . $value['id']; ?>">
							<i class="fa fa-calendar fa-lg" title="Periodo Laboral"></i>
						</a>
						&nbsp; 
						<?php if(in_array($_SESSION['profile'],array(1,2))) { ?>
						&nbsp;
						<a href="<?= base_url() . 'regionales/editar_empleado/' . $value['id']; ?>" title="Editar Cliente">
							<i class="fa fa-pencil fa-lg"></i>
						</a>
						&nbsp;
						&nbsp;
						<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Eliminar Empleado" onclick="javascript:set_modal(<?= $value['id'] ?>)">
							<i class="fa fa-trash fa-lg"></i>
						</a>
						&nbsp;
						<?php } ?>
					</td>
				</tr>
			<?php
		} //End foreach
	}

	public function delete_employee ()
	{
		$params = $_POST['data'];

		$this->regionals->delete_employee($params['id']);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $params['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Empleado Regional"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El empleado ha sido ELIMINADO exitosamente
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
					Ha ocurrido un error al tratar de eliminar este empleado. La página se recargará para intentar corregirlo.
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

	public function periodo_empleado($id)
	{
		$employee = $this->regionals->get_employee($id);

		$periods = $this->regionals->get_periods($id);

		$dato['recursos'] = array(
				"employee" => $employee->result_array(),
				"periods" => $periods->result_array()
			);

		$dato['page'] = "regional_period_employee";
		$dato['footer'] = array('regional_period_employee');
		$this->load->view('home',$dato);
	}

	public function set_new_employee_period()
	{
		$params = $_POST['data'];

		$params['date_end'] = NULL;


		$is_active = $this->regionals->check_active($params['regional_employees_id']);

		if($is_active->result_array()[0]['active'] == 1) {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Para iniciar otro periodo laboral debe haber finalizado el periodo actual.
				</p>
			</div>
			<?php

			exit();
		}

		$exist_date_start = $this->regionals->exist_date_start($params['regional_employees_id'],$params['date_start']);

		if($exist_date_start->result_array()[0]['count'] > 0) {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					El empleado ya inició un periodo en esta fecha. Imposible repetir.
				</p>
			</div>
			<?php

			exit();
		}

		$employee_period_id = $this->regionals->set_new_employee_period($params);

		if($this->db->affected_rows() > 0) { 

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $employee_period_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Periodo Empleado Regional"

			);

			$this->users->set_user_operation($array);
			
			$this->regionals->set_employee_active($params['regional_employees_id']);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El empleado ha sido dado de alta correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('new-client-form').reset();
					});
				},5000);
              	fillTable(<?= $params['regional_employees_id'] ?>);
			</script>				
			<?php 
				
			
		} else { 
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al dar de alta el empleado. La página se recargará para intentar corregirlo.
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

	public function get_last_employee_period ($id)
	{
		$query = $this->regionals->get_last_employee_period($id);
		$result = $query->result_array();

		foreach ($result as $key => $value) {
			if(date("Y",strtotime($value['date_end'])) == "-0001"){
				$date_end = "En curso";
			} else {
				$date_end = date("d-m-Y",strtotime($value['date_end']));
			}
			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['position']; ?></td>
					<td><?= $value['date_start']; ?></td>
					<td><span id="date_end_<?= $value['id'] ?>"><?= $date_end; ?></span></td>
					<td><?= $value['salary']; ?></td>
					<td>					
						&nbsp;
						<span id="calendar_button_<?= $value['id'] ?>">
						<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Registrar Egreso" onclick="javascript:set_modal(<?= $value['id'] ?>)">
							<i class="fa fa-calendar fa-lg"></i>
						</a>
						</span>
						&nbsp;
					</td>
				</tr>
			<?php
		} //End foreach
	}

	public function end_employee_period()
	{
		$params = $_POST['data'];


		$exist_date_end = $this->regionals->exist_date_end($params['employee_id'],$params['date_end']);

		if($exist_date_end->result_array()[0]['count'] > 0) {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					El empleado ya terminó un periodo en esta fecha. Imposible repetir.
				</p>
			</div>
			<?php

			exit();
		}

		$query = $this->regionals->end_employee_period($params['id'],$params['date_end']);

		if($this->db->affected_rows() > 0) { 

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $params['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Terminar Periodo Empleado Regional"

			);

			$this->users->set_user_operation($array);
			
			$this->regionals->set_employee_no_active($params['employee_id']);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					Se ha registrado el egreso del empleado correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('employee-delete-form').reset();
					});
				},5000);
              	change_end_date(<?= $params['id'] ?>,"<?= $params['date_end'] ?>");
			</script>				
			<?php 
				
			
		} else { // If el cliente no fue registrado correctamente
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error registrar el egreso del empleado. La página se recargará para intentar corregirlo.
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

	public function editar_empleado($id)
	{
		$employee = $this->regionals->get_employee($id);

		$dato['recursos'] = array(
				"employee" => $employee->result_array()
			);

		$dato['page'] = "regional_update_employee";
		$dato['footer'] = array('regional_update_employee');
		$this->load->view('home',$dato);
	}

	public function update_employee()
	{
		$params = $_POST['data'];

		$id = $params['id'];
		unset($params['id']);

		$this->regionals->update_employee($id,$params);

		if($this->db->affected_rows() > 0) { 

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Empleado Regional"

			);

			$this->users->set_user_operation($array);
			
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El empleado ha sido actualizado correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('employee-delete-form').reset();
					});
				},5000);
			</script>				
			<?php 
				
			
		} else { // If el cliente no fue registrado correctamente
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al actualizar el empleado. La página se recargará para intentar corregirlo.
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

	public function anticipos($id)
	{
		$advances = $this->regionals->get_advances($id);

		$regionals = $this->regionals->get_regionals();

		$dato['recursos'] = array(
				"advances" => $advances->result_array(),
				"regionals" => $regionals->result_array()
			);

		$dato['page'] = "regional_advances";
		$dato['footer'] = array('regional_advances');
		$this->load->view('home',$dato);
	}

	public function new_adv_regional()
	{
		$params = $_POST['data'];

		$params['user_id'] = $_SESSION['id'];

		$adv_regional_id = $this->regionals->new_adv_regional($params);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $adv_regional_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Anticipo Regional"

			);

			$this->users->set_user_operation($array);
			
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El avance ha sido registrado correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('adv-regional-form').reset();
					});
				},5000);
              	fillTable(<?= $params['regional_id'] ?>);
			</script>				
			<?php 
				
			
		} else { 
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar el avance. La página se recargará para intentar corregirlo.
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

	public function get_last_adv_regional($id)
	{
		$query = $this->regionals->get_last_adv_regional($id);
		$result = $query->result_array();

		foreach ($result as $key => $value) {

			if($value['detail'] != "") {
				$note = '<a onclick="javascript:set_modal('.$value['id'].')"  href="#noteModal" data-toggle="modal"  id="note_'.$value['id'] .'" data-note="'.$value['detail'] .'"><i class="fa fa-comment"></i></a>';
			}else {
				$note = "Vacio";
			}

			if($value['id'] != ""){
			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['regional_name']; ?></td>
					<td><?= $value['amount']; ?></td>
					<td><?= ucfirst(strftime("%A %d-%m-%Y",strtotime($value['date']))) ?></td>
					<td><?= $note; ?></td>		
					<td>
						&nbsp;
						<a href="<?= base_url() . 'regionales/editar_anticipo/' . $value['id']; ?>" title="Editar Anticipo">
							<i class="fa fa-pencil fa-lg"></i>
						</a>
						&nbsp;

					</td>
				</tr>
			<?php
			}
		}
	}

	public function editar_anticipo($id)
	{
		$advance = $this->regionals->get_advance($id);

		$dato['recursos'] = array(
				"advance" => $advance->result_array()
			);

		$dato['page'] = "regional_update_advance";
		$dato['footer'] = array('regional_update_advance');
		$this->load->view('home',$dato);
	}

	public function update_advance()
	{
		$params = $_POST['data'];

		$id = $params['id'];
		unset($params['id']);

		$this->regionals->update_advance($id,$params);

		if($this->db->affected_rows() > 0) { 

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Anticipo regional"

			);

			$this->users->set_user_operation($array);
			
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El anticipo ha sido actualizado correctamente
				</p>
			</div>
			<script type="text/javascript">
				setTimeout(function(){
					$('#message').fadeOut('slow', function() {
						$(this).remove(); 
						document.getElementById('employee-delete-form').reset();
					});
				},5000);
			</script>				
			<?php 
				
			
		} else { // If el cliente no fue registrado correctamente
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al actualizar el anticipo. La página se recargará para intentar corregirlo.
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

/* End of file Regionales.php */
/* Location: ./application/controllers/Regionales.php */