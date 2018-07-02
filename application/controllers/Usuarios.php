<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('Usuarios_model');
	}

	public function index()
	{
		/******** Consultar Usuarios *******/
		$result_users = $this->Usuarios_model->get_users();

		$regionals = $this->Usuarios_model->get_regionales();

		$profiles = $this->Usuarios_model->get_profiles();

		/******** Consultar Ciudades para formulario de registro *******/
		$this->load->model('Location_model');
		$result_cities = $this->Location_model->get_cities();

		$dato['recursos'] = array(
				"users" => $result_users->result_array(),
				"profiles" => $profiles->result_array(),
				"regionals" => $regionals->result_array()
			);		

		$dato['page'] = "users";
		$dato['footer'] = array('users');
		$this->load->view('home',$dato);
	}

	public function detalle ($user_id)
	{
		$user = $this->Usuarios_model->get_user($user_id);
		$data['recursos'] = $user->result_array();
		
		$data['page'] = 'user_details';
		//$data['footer'] = array('user_details');
		$this->load->view('home', $data);
	}

	public function editar ($user_id)
	{
		$user = $this->Usuarios_model->get_user($user_id);

		$regionals = $this->Usuarios_model->get_regionales();

		$profiles = $this->Usuarios_model->get_profiles();

		$data['recursos'] = array(
				"user" => $user->result_array(),
				"regionals" => $regionals->result_array(),
				"profiles" => $profiles->result_array()
			);
		
		$data['page'] = 'user_update';
		$data['footer'] = array('user_update');
		$this->load->view('home', $data);
	}

	public function update_user ()
	{
		$array_user = $_POST['data'];

		$user_id = $array_user['id'];
		unset($array_user['id']);

		$query = $this->Usuarios_model->update_user($array_user,$user_id);

		if ($query) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $user_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Usuario del Sistema"

			);

			$this->users->set_user_operation($array);
			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El usuario ha sido ACTUALIZADO exitosamente
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

	public function access_user()
	{
		$this->Usuarios_model->access_user($_POST['id'],$_POST['block']);

		if ($this->db->affected_rows() > 0) {

			if($_POST['block'] == 0) {
				$block = "Desbloquear";
			}else {
				$block = "Bloquear";
			}

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $_POST['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => $block." Usuario del Sistema"

			);

			$this->users->set_user_operation($array);

			if($_POST['block'] == 0) { 
				
				?>
				<a class="e_access_<?= $_POST['id'] ?>" href="javascript:userAccess(<?= $_POST['id'] ?>,1)" title="Bloquear acceso">
					<i class="fa fa-unlock fa-lg text-success"></i>
				</a>
				<?php
			 } 
			 if($_POST['block'] == 1) { 
			 	?>
				<a class="e_access_<?= $_POST['id'] ?>" href="javascript:userAccess(<?= $_POST['id'] ?>,0)" title="Desbloquear acceso">
					<i class="fa fa-lock fa-lg text-danger"></i>
				</a>
				<?php
			 } 
		} else {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Error en la operación. La página se recargará para intentar corregirlo.
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

	public function delete_user ()
	{
		$id = $_POST['id'];

		$this->Usuarios_model->delete_user($id);

		if ($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Usuario del Sistema"

			);

			$this->users->set_user_operation($array);

			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					El usuario ha sido ELIMINADO exitosamente
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

	public function new_user() {

		$params = $_POST['data'];

		$params['creation_date'] = date('Y-m-d H:i:s');
		$params['block'] = 0;
		$params['deleted'] = 0;

		$exist_email = $this->Usuarios_model->exist_email($params['email']);

		if($exist_email > 0){



			?>
				<div id="message" class="alert alert-block alert-warning">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Ya existe</h4>
					<p>
						Este email (<?= $params['email'] ?>) ya existe en la base de datos
					</p>
				</div>

			<?php

		}else{
			$params['pass'] = password_hash($params['pass'], PASSWORD_DEFAULT);
			
			$user_id = $this->Usuarios_model->new_user($params);


			if($this->db->affected_rows() > 0) {

				$this->load->model('Usuarios_model', 'users');
				$array = array(
					"date" => date("Y-m-d H:i:s"),
					"record_id" => $user_id,
					"user_id" => $_SESSION['id'],
					"operation_id" => 1,
					"table" => "Usuario del Sistema"

				);

				$this->users->set_user_operation($array);
				?>
					<div id="message" class="alert alert-block alert-success">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
						<p>
							El usuario ha sido registrado EXITOSAMENTE
						</p>
					</div>
					<script>
						setTimeout(function() {
							$('#message').fadeOut('slow',function() { $('#message').remove(); document.getElementById('register-form').reset(); });
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
						Ha ocurrido un error al registrar el usuario. La página se recargará para intentar corregirlo.
					</p>
				</div>
				<script>
					setTimeout(function(){
						window.location.reload();
					},5000);
				</script>

				<?php


			} //End ifelse affected rows
		} //End ifelse $EXIST_EMAIL

		
		
	}

	public function get_last_user ()
	{
		$query = $this->Usuarios_model->get_last_user();
		$result = $query->result_array();

		foreach ($result as $key => $value) {
		?>

			<tr id="tr_<?= $value['id'] ?>">
				<td><?= $value['id']; ?></td>
				<td><?= $value['name'].' '.$value['lastname']; ?></td>
				<td><?= $value['regional_name']; ?></td>
				<td><?= $value['position']; ?></td>
				<td><?= $value['phone']; ?></td>
				<td><?= $value['email']; ?></td>
				<td id="td_access_<?= $value['id'] ?>">
				<?php if($value['block'] == 0) { ?>
					<a class="e_access_<?= $value['id'] ?>" href="javascript:userAccess(<?= $value['id'] ?>,1)" title="Bloquear acceso">
						<i class="fa fa-unlock fa-lg text-success"></i>
					</a>
				<?php } else { ?>
					<a class="e_access_<?= $value['id'] ?>" href="javascript:userAccess(<?= $value['id'] ?>,0)" title="Desbloquear acceso">
						<i class="fa fa-lock fa-lg text-danger"></i>
					</a>
				<?php } ?>
				</td>
				<td>
					&nbsp;
					<a href="<?= base_url() . 'usuarios/detalle/' . $value['id']; ?>">
						<i class="fa fa-eye fa-lg" title="Detalles"></i>
					</a>
					&nbsp; 
					
					&nbsp;
					<a href="<?= base_url() . 'usuarios/editar/' . $value['id']; ?>" title="Editar Usuario">
						<i class="fa fa-pencil fa-lg"></i>
					</a>
					&nbsp;

					&nbsp;
					<a href="<?= base_url() . 'usuarios/conexiones/' . $value['id']; ?>" title="Conexiones">
						<i class="fa fa-plug fa-lg"></i>
					</a>
					&nbsp;

					&nbsp;
					<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Eliminar Usuario" onclick="javascript:set_modal(<?= $value['id'] ?>)">
						<i class="fa fa-trash fa-lg"></i>
					</a>
					&nbsp;

				</td>
			</tr>

		<?php
		} //End foreach
	}

	public function conexiones ($user_id)
	{
		$user_connections = $this->Usuarios_model->get_connections($user_id);

		$data['recursos'] = array(
				"connections" => $user_connections->result_array()
			);
		
		$data['page'] = 'user_connections';
		$data['footer'] = array('user_connections');
		$this->load->view('home', $data);
	}

	public function alertas()
	{
		if($_SESSION['profile'] !=  1) {
			exit("Database Error");
		}

		$users_alert = $this->Usuarios_model->get_users_alert();
		$users = $this->Usuarios_model->get_users();

		$data['recursos'] = array(
				"users_alert" => $users_alert->result_array(),
				"users" => $users->result_array()
			);
		
		$data['page'] = 'users_alert';
		$data['footer'] = array('users_alert');
		$this->load->view('home', $data);
	}

	public function update_users_alert() {

		$params = $_POST['data'];

		$count_params = count($params);
		$array_users = [];
		foreach ($params as $value) {
			
			$array_users[] = array("user_id" => $value);

		}


		$this->Usuarios_model->set_users_alert($array_users);

		if($this->db->affected_rows() > 0) {

			if($this->db->affected_rows() != $count_params) {
				?>
				<div id="message" class="alert alert-block alert-warning">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> Advertencia</h4>
					<p>
						Puede que algunos usuarios no fueron registrardos correctamente para recibir las alertas. Por favor recargue la página e intente nuevamente. 
					</p>
				</div>
				<?php
				

				$this->load->model('Usuarios_model', 'users');
				$array = array(
					"date" => date("Y-m-d H:i:s"),
					"record_id" => 1,
					"user_id" => $_SESSION['id'],
					"operation_id" => 2,
					"table" => "Usuarios Alerta del Sistema"

				);

				$this->users->set_user_operation($array);
				exit();
			}
			
				$this->load->model('Usuarios_model', 'users');
				$array = array(
					"date" => date("Y-m-d H:i:s"),
					"record_id" => 1,
					"user_id" => $_SESSION['id'],
					"operation_id" => 2,
					"table" => "Usuarios Alerta del Sistema"

				);

				$this->users->set_user_operation($array);
			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						Las direcciones de alerta han sido configuradas EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { $('#message').remove(); });
					}, 5000);
				</script>
			<?php

		}else{
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar las direcciones de alerta. La página se recargará para intentar corregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php


		} //End ifelse affected rows

		
		
	}

	public function cambiar_contrasena()
	{
		
		$data['page'] = 'user_update_pass';
		$data['footer'] = array('user_update_pass');
		$this->load->view('home', $data);
	}

	public function update_pass()
	{
		$params = $_POST['data'];

		$query = $this->Usuarios_model->check_pass();

		if(password_verify($params['old_pass'], $query->result_array()[0]['pass'])) {

			$pass = password_hash($params['pass'], PASSWORD_DEFAULT);

			$this->Usuarios_model->update_pass($pass);

			if($this->db->affected_rows() > 0){
				?>
					<div id="message" class="alert alert-block alert-success">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
						<p>
							La contraseña ha sido cambiada EXITOSAMENTE
						</p>
					</div>
					<script>
						setTimeout(function() {
							$('#message').fadeOut('slow',function() { $('#message').remove(); document.getElementById('update-form').reset(); });
						}, 5000);
					</script>
				<?php
			} else {
				?>
				<div id="message" class="alert alert-block alert-danger">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
					<p>
						Ocurrió un error al cambiar la contraseña. La página se recargará para intentar corregirlo.
					</p>
				</div>
				<script>
					setTimeout(function() {
						window.location.reload();
					}, 5000);
				</script>
			
				<?php
			}

		} else {
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					La contraseña actual es incorrecta
				</p>
			</div>
			<script>
				setTimeout(function() {
					$('#message').fadeOut('slow',function() { $('#message').remove(); });
				}, 5000);
			</script>
		
			<?php
		}
	}

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */