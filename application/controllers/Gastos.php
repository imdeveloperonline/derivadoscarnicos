<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gastos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Gastos_model', 'outgoes');
	}

	public function index()
	{
		/******** Consultar Gastos *******/
		$result_outgoes = $this->outgoes->get_outgoes();

		/******** Consultar Tipo de Gastos *******/
		$outgo_types = $this->outgoes->get_outgo_types();

		/******** Consultar Ciudades para formulario de registro *******/
		/*$this->load->model('Location_model');
		$result_cities = $this->Location_model->get_cities();*/

		$dato['recursos'] = array(
				"outgoes" => $result_outgoes->result_array(),
				"outgo_types" => $outgo_types->result_array()
			);		

		$dato['page'] = "outgoes";
		$dato['footer'] = array('outgoes');
		$this->load->view('home',$dato);
	}

	public function generales()
	{
		/******** Consultar Gastos *******/
		$result_outgoes = $this->outgoes->get_generals_outgoes();

		/******** Consultar Tipo de Gastos *******/
		$outgo_types = $this->outgoes->get_outgo_types();

		/******** Consultar Ciudades para formulario de registro *******/
		/*$this->load->model('Location_model');
		$result_cities = $this->Location_model->get_cities();*/

		$dato['recursos'] = array(
				"outgoes" => $result_outgoes->result_array(),
				"outgo_types" => $outgo_types->result_array()
			);		

		$dato['page'] = "outgoes_generals";
		$dato['footer'] = array('outgoes_generals');
		$this->load->view('home',$dato);
	}

	public function set_outgo()
	{

		$params = [];
		$params['date'] = $_POST['date'];
		$params['amount'] = $_POST['amount'];
		$params['type_outgo_id'] = $_POST['type_outgo_id'];
		$params['detail'] = $_POST['detail'];


		$params['user_id'] = $this->session->userdata('id'); 
		$params['regional_id'] = $this->session->userdata('regional'); 

		$outgo_id = $this->outgoes->set_outgo($params);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $outgo_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Gasto Regional"

			);

			$this->users->set_user_operation($array);

			if(isset($_FILES['file'])){

				$name = date("YmdHis",time()) . "_rg" . $_SESSION['regional'] . "_usr" . $_SESSION['id'] . ".jpg";

			 	$config['upload_path'] = "./assets/supports/outgoes";
		        $config['file_name'] = $name;
		        $config['file_ext_tolower'] = true;
		        $config['allowed_types'] = "jpg";
		        $config['max_size'] = "10000";
		        $config['max_width'] = "5000";
		        $config['max_height'] = "5000";

		        $this->load->library('upload', $config);
		        
		        if (!$this->upload->do_upload('file')) {
		        	?>
						<div id="message" class="alert alert-block alert-warning">
							<a class="close" data-dismiss="alert" href="#">×</a>
							<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Alerta!</h4>
							<p>
								El gasto se ha registrado EXITOSAMENTE, pero la imagen no pudo ser procesada.
							</p>
						</div>
						<script>
							setTimeout(function() {
								$('#message').fadeOut('slow',function() { 
									$('#message').remove(); 
								});
							}, 5000);
							fillTable();
						</script>
					<?php

		        } else {
	        		$file_info = $this->upload->data();
	        		$thumb = $this->_create_thumbnail($file_info['file_name']);

		            $params = array(
		            	"title" => $_POST['title'],
		            	"description" => $_POST['detail'],
		            	"file_name" => $file_info['file_name'],
		            	"regional_id" => $_SESSION['regional'],
		            	"outgo_id" => $outgo_id
		            );
	            	$outgo_img_id = $this->outgoes->set_outgo_img($params);

		            	if($this->db->affected_rows() > 0) {
		            		$this->load->model('Usuarios_model', 'users');
							$array = array(
								"date" => date("Y-m-d H:i:s"),
								"record_id" => $outgo_img_id,
								"user_id" => $_SESSION['id'],
								"operation_id" => 1,
								"table" => "Soporte de Gasto"

							);

							$this->users->set_user_operation($array);
						}
		        	?>
						<div id="message" class="alert alert-block alert-success">
							<a class="close" data-dismiss="alert" href="#">×</a>
							<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
							<p>
								El gasto se ha registrado EXITOSAMENTE
							</p>
						</div>
						<script>
							setTimeout(function() {
								$('#message').fadeOut('slow',function() { 
									$('#message').remove(); 
								});
							}, 5000);
							fillTable();
						</script>
					<?php
				
		        }

	    	} else {
	    		?>
					<div id="message" class="alert alert-block alert-success">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
						<p>
							El gasto se ha registrado EXITOSAMENTE. <i>No se encontró imagen para procesar</i>
						</p>
					</div>
					<script>
						setTimeout(function() {
							$('#message').fadeOut('slow',function() { 
								$('#message').remove(); 
							});
						}, 5000);
						fillTable();
					</script>
				<?php
	    	}

			

		} else {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar el gasto. La página se recargará para intentar corregirlo.
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

	public function get_last_outgo()
	{
		$query = $this->outgoes->get_last_outgo();

		foreach ($query->result_array() as $key => $value) {
			?>
			<tr id="tr_<?= $value['id'] ?>">
				<td><?= $value['id']; ?></td>
				<td><?= strftime('%A %d-%m-%Y',strtotime($value['date'])); ?></td>
				<td><?= $value['amount']; ?></td>
				<td><?= $value['type_outgo']; ?></td>
				<td><?= $value['regional_name']; ?></td>
				<td><?= $value['detail']; ?></td>
				&nbsp;
				<a href="<?= base_url() ?>gastos/editar/<?= $value['id'] ?>" title="Editar Producto">
					<i class="fa fa-pencil fa-lg"></i>
				</a>
				&nbsp;
			</tr>
			<?php
		}
	}

	public function editar($outgo_id,$is_general = "")
	{
		/******** Consultar Gastos *******/
		$outgo = $this->outgoes->get_outgo_by_id($outgo_id,$is_general);

		/******** Consultar Tipo de Gastos *******/
		$outgo_types = $this->outgoes->get_outgo_types();

		$this->load->model('Regionales_model', 'regionals');
		$regionals = $this->regionals->get_regionals();

		$dato['recursos'] = array(
				"outgo" => $outgo->result_array(),
				"outgo_types" => $outgo_types->result_array(),
				"is_general" => $is_general,
				"regionals" => $regionals->result_array()
			);		

		$dato['page'] = "outgo_update";
		$dato['footer'] = array('outgo_update');
		$this->load->view('home',$dato);
	}

	public function update_outgo()
	{
		$params = $_POST['data'];
		$id = $params['id'];
		unset($params['id']);
		$is_general = $params['is_general'];
		unset($params['is_general']);

		if($is_general == 1) {
			unset($params['regional_id']);
		}

		$update = $this->outgoes->update_outgo($id,$params,$is_general);

		if($update) {

			if($is_general == 1) {
				$table = "Gasto general";
			} else {
				$table = "Gasto regional";
			}

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => $table

			);

			$this->users->set_user_operation($array);
			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El gasto se ha actualizado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
						});
					}, 5000);
				</script>
			<?php

		}else{
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al actualizar el gasto. La página se recargará para intentar corregirlo.
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

	public function set_general_outgo()
	{
		$params = [];
		parse_str($_POST['data'],$params);

		$general_outgo_id = $this->outgoes->set_general_outgo($params);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $general_outgo_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Gasto General"

			);

			$this->users->set_user_operation($array);
			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El gasto se ha registrado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('new-outgo-form').reset(); });
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
					Ha ocurrido un error al registrar el gasto. La página se recargará para intentar corregirlo.
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

	public function get_last_general_outgo()
	{
		$query = $this->outgoes->get_last_general_outgo();

		foreach ($query->result_array() as $key => $value) {
			?>
			<tr id="tr_<?= $value['id'] ?>">
				<td><?= $value['id']; ?></td>
				<td><?= strftime('%A %d-%m-%Y',strtotime($value['date'])); ?></td>
				<td><?= $value['amount']; ?></td>
				<td><?= $value['type_outgo']; ?></td>
				<td><?= $value['detail']; ?></td>
			</tr>
			<?php
		}
	}

	public function tipos()
	{
		
		$outgoes_types = $this->outgoes->get_all_outgo_types();

		$dato['recursos'] = array(
				"outgoes_types" => $outgoes_types->result_array()
			);		

		$dato['page'] = "outgoes_types";
		$dato['footer'] = array('outgoes_types');
		$this->load->view('home',$dato);
	}

	public function set_selectable_outgo()
	{
		$params = $_POST['data'];

		$this->outgoes->set_selectable_outgo($params['id'],$params['selectable']);

		if($this->db->affected_rows() > 0){

			if($params['selectable'] == 0) {
				?>
				&nbsp;
				<a href="#" title="Restringir selección" onclick="javascript:selectable(<?= $params['id'] ?>,1)" class="text-success">
					<i class="fa fa-check fa-lg"></i>
				</a>
				&nbsp;
				<?php
			} else {
				?>
				&nbsp;
				<a href="#" title="Habilitar selección" onclick="javascript:selectable(<?= $params['id'] ?>,0)" class="text-danger">
					<i class="fa fa-close fa-lg"></i>
				</a>
				&nbsp;
				<?php
			}
				
			

		} else {
			?>
			<span>Error. Recargaremos la página.</span>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php
		}
	}

	public function update_outgo_type()
	{
		$params = $_POST['data'];

		$exist_type_outgo_name = $this->outgoes->exist_type_outgo_name($params['name']);

		if($exist_type_outgo_name > 0 ) {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ya existe un tipo de gasto con este nombre. Por favor ingrese uno diferente.
				</p>
			</div>
			<?php

			exit();
		}

		$this->outgoes->update_outgo_type($params['id'],$params['name']);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $params['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Tipo de Gasto"

			);

			$this->users->set_user_operation($array);
			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El tipo de gasto ha sido actualizado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('edit-oType-form').reset(); 
							window.location.reload();
						});
					}, 5000);
				</script>
			<?php

		}else{
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al editar el tipo de gasto. La página se recargará para intentar corregirlo.
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

	public function set_outgo_type()
	{
		$params = $_POST['data'];

		$exist_type_outgo_name = $this->outgoes->exist_type_outgo_name($params['name']);

		if($exist_type_outgo_name > 0 ) {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ya existe un tipo de gasto con este nombre. Por favor ingrese uno diferente.
				</p>
			</div>
			<?php

			exit();
		}

		$outgo_type_id = $this->outgoes->set_outgo_type($params['name']);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $outgo_type_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Tipo de Gasto"

			);

			$this->users->set_user_operation($array);

			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El tipo de gasto ha sido registrado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('otype-form').reset(); 
						});
					}, 5000);
					fillTable();
				</script>
			<?php

		}else{
			?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al registrar el tipo de gato. La página se recargará para intentar corregirlo.
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

	public function get_last_outgo_type()
	{
		$query = $this->outgoes->get_last_outgo_type();

		foreach ($query->result_array() as $key => $value) {
			?>
			<tr id="tr_<?= $value['id'] ?>">
				<td><?= $value['id']; ?></td>
				<td id="name_edit_<?= $value['id'] ?>" data-edit="<?= $value['name'] ?>"><?= $value['name']; ?></td>
				<td id="selectable_<?= $value['id'] ?>">
					
					<?php if($value['deleted'] == 0) { ?>
					&nbsp;
					<a href="#" title="Restringir selección" onclick="javascript:selectable(<?= $value['id'] ?>,1)" class="text-success">
						<i class="fa fa-check fa-lg"></i>
					</a>
					&nbsp;
					<?php } else { ?>
					&nbsp;
					<a href="#" title="Habilitar selección" onclick="javascript:selectable(<?= $value['id'] ?>,0)" class="text-danger">
						<i class="fa fa-close fa-lg"></i>
					</a>
					&nbsp;
					<?php } ?>
				</td>
				<td>
					
					&nbsp;
					<a href="#modal-edit" data-toggle="modal" title="Editar Producto" onclick="javascript:set_modal(<?= $value['id'] ?>)">
						<i class="fa fa-pencil fa-lg"></i>
					</a>
					&nbsp;

				</td>											
			</tr>
			<?php
		}
	}

	public function soporte_gastos()
	{
		$outgoes_imgs = $this->outgoes->get_outgoes_imgs();

		$dato['recursos'] = array(
				"outgoes_imgs" => $outgoes_imgs->result_array()
			);

		$dato['page'] = "outgoes_img_support";
		$dato['footer'] = array('outgoes_img_support');
		$this->load->view('home',$dato);
	}

	public function set_outgo_support()
	{
		$name = date("YmdHis",time()) . "_rg" . $_SESSION['regional'] . "_usr" . $_SESSION['id'] . ".jpg";

	 	$config['upload_path'] = "./assets/supports/outgoes";
        $config['file_name'] = $name;
        $config['file_ext_tolower'] = true;
        $config['allowed_types'] = "jpg";
        $config['max_size'] = "10000";
        $config['max_width'] = "5000";
        $config['max_height'] = "5000";

        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('file')) {
            //*** ocurrio un error
            /*$data['uploadError'] = $this->upload->display_errors();
            echo "error: " . $this->upload->display_errors();
            return;*/
            ?>
			<div id="message" class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ha ocurrido un error al subir la imagen. La página se recargará para intentar corregirlo.
				</p>
			</div>
			<script>
				setTimeout(function(){
					window.location.reload();
				},5000);
			</script>

			<?php

        } else {

        	$file_info = $this->upload->data();
            $thumb = $this->_create_thumbnail($file_info['file_name']);

            if($thumb){

	            $params = array(
	            	"title" => $_POST['title'],
	            	"description" => $_POST['description'],
	            	"file_name" => $file_info['file_name'],
	            	"regional_id" => $_SESSION['regional']
	            );
            	$outgo_img_id = $this->outgoes->set_outgo_img($params);

            	if($this->db->affected_rows() > 0) {
            		$this->load->model('Usuarios_model', 'users');
					$array = array(
						"date" => date("Y-m-d H:i:s"),
						"record_id" => $outgo_img_id,
						"user_id" => $_SESSION['id'],
						"operation_id" => 1,
						"table" => "Soporte de Gasto"

					);

					$this->users->set_user_operation($array);

					?>
						<div id="message" class="alert alert-block alert-success">
							<a class="close" data-dismiss="alert" href="#">×</a>
							<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
							<p>
								La imagen ha sido guardada EXITOSAMENTE. La página se recargará para mostrar el registro.
							</p>
						</div>
						<script>
							setTimeout(function() {
								$('#message').fadeOut('slow',function() { 
									$('#message').remove(); 
									document.getElementById('support-form').reset();
									window.location.reload(); 
								});
							}, 5000);
						</script>
					<?php

				}else{
					?>
					<div id="message" class="alert alert-block alert-danger">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
						<p>
							Ha ocurrido un error al registrar el producto. La página se recargará para intentar corregirlo.
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

	}

	public function _create_thumbnail($filename){
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'assets/supports/outgoes/'.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config["thumb_marker"] = "";
        $config['new_image']='assets/supports/outgoes/thumbs/';
        $config['width'] = 150;
        $config['height'] = 150;
        $this->load->library('image_lib', $config); 
        return $this->image_lib->resize();
    }

}

/* End of file Gastos.php */
/* Location: ./application/controllers/Gastos.php */