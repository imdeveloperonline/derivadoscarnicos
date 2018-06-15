<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bodega extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Bodega_model', 'storage');
	}

	public function index()
	{
		
	}

	public function recepciones()
	{
		/******** Consultar recepciones *******/
		$receptions = $this->storage->get_receptions();

		$products = $this->storage->get_products();

		$this->load->model('Finanzas_model', 'finances');		
		$supplier_advances = $this->finances->get_supplier_advances();

		$methods = $this->finances->get_methods();

		$this->load->model('Proveedores_model', 'suppliers');		
		$suppliers = $this->suppliers->get_suppliers_by_regional();

		$dato['recursos'] = array(
				"receptions" => $receptions->result_array(),
				"supplier_advances" => $supplier_advances->result_array(),
				"suppliers" => $suppliers->result_array(),
				"methods" => $methods->result_array(),
				"products" => $products->result_array()
			);		

		$dato['page'] = "storage_receptions";
		$dato['footer'] = array('storage_receptions');
		$this->load->view('home',$dato);
	}

	public function set_reception ()
	{
		$params = $_POST['data'];
		
		if($params['note'] != "") {
			$detail = "(Nota de recepción) " . $params['note'];
		} else {
			$detail = "Sin nota de recepción";
		}

		if($params['method_id'] == 1) {
			$payed = 1;
			$paid_account = 1;
		} else {
			$payed = 0;
			$paid_account = 0;
		}

		if($params['method_id'] != 3) {

			$array_advance = array(
				"archived" => 0,
				"unit_price" => $params['unit_price'],
				"detail" => $detail,
				"payed" => $payed,
				"paid_account" => $paid_account,
				"user_id" => $_SESSION['id'],
				"regional_id" => $_SESSION['regional'],
				"date" => $params['date'],
				"amount" => $params['amount'],
				"quantity" => $params['quantity'],
				"supplier_id" => $params['supplier_id'],
				"product_id" => $params['product_id'],
				"method_id" => $params['method_id']

			);

		}

		$array_reception = array(
			"note" => $params['note'],
			"brand" => $params['brand'],
			"deleted" => 0,
			"shamble_id" => $params['shamble_id'],
			"shamble_amount" => $params['shamble_amount'],
			"user_id" => $_SESSION['id'],
			"regional_id" => $_SESSION['regional'],
			"date" => $params['date'],
			"quantity" => $params['quantity'],
			"supplier_id" => $params['supplier_id'],
			"method_id" => $params['method_id'],
			"reception_amount" => $params['reception_amount'],
			"unit_price" => $params['unit_price'],
			"product_id" => $params['product_id']

		); 

		/****** Brands Check Functions *******/
		if($params['brand'] != "") {
			$rows = explode("\n", $params['brand']);

			$count = count($rows);

			$brand_sum = 0;

			for ($i=0; $i < $count ; $i++) { 
				
				if($rows[$i] != ""){
					$row = explode(" ", $rows[$i]);
					$row = array_map('trim',$row);

					if(!is_numeric($row[0])){
						?>
						<div id="message" class="alert alert-block alert-danger">
							<a class="close" data-dismiss="alert" href="#">×</a>
							<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
							<p>
								No se pudo realizar la suma de las marcas. Asegurese de estar ingresando los datos en el formato correcto.
							</p>
						</div>

						<?php

						exit();
					} 
					
					$brand_sum = $brand_sum + $row[0];

				}
				
				
			}
			

			if($params['quantity'] != $brand_sum){

				?>
				<div id="message" class="alert alert-block alert-danger">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
					<p>
						La suma de las marcas no corresponde a la cantidad recibida. Asegurese de estar ingresando los datos en el formato correcto.
					</p>
				</div>

				<?php

				exit();
			} 
		}
		
		/****** Brands Check Functions END *******/

		if($params['method_id'] == 3) {
			// Rest verify
			$this->load->model('Finanzas_model', 'finances');
			$balance = $this->finances->get_supplier_balance($params['supplier_id']);
			
			$new_balance = $balance - ($params['quantity']*$params['unit_price']);
			

			if ($new_balance < 0) {
				?>
				<div id="message" class="alert alert-block alert-danger">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
					<p>
						El saldo del proveedor no puede ser menor que cero (0)
					</p>
				</div>

				<?php
				exit();
			}

		} else {
				$this->load->model('Finanzas_model', 'finances');

				/*if($params['method_id'] == 2) {

					$balance = $this->finances->get_supplier_balance($params['supplier_id']);

					if($balance > 0) {
						?>
						<div id="message" class="alert alert-block alert-danger">
							<a class="close" data-dismiss="alert" href="#">×</a>
							<h4 class="alert-heading"><i class="fa fa-times-circle"></i> Función no permitida</h4>
							<p>
								Este proveedor tiene saldo en anticipos vigente y no puede registrarse un crédito hasta no ser cumplido.
							</p>
						</div>

						<?php
						exit();
					}
			
				}*/

				
				$array_reception['advance_supplier_id'] = $this->finances->new_adv_supplier($array_advance);



				$new_balance = "";

		}	

		$reception_id = $this->storage->set_reception($array_reception);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $_SESSION['regional'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Recepción Regional"

			);

			$this->users->set_user_operation($array);



			/******* Si se recibe todo el producto se marca para no volverlo a mostrar en el combo *******/
			/*if($rest == 0){
				$this->finances->set_advance_payed($params['advance_supplier_id']);
			}*/

			/******* Si el proveedor tiene 100.000 pesos o menos de saldo se envía alerta al correo *******/
			if($new_balance <= 100000 && $params['method_id'] == 3 && base_url() != "http//localhost/codeigniter/" ) {
				$reception_query = $this->storage->get_last_reception();
				$this->storage->send_low_rest_alert($reception_query->result_array(), $new_balance);
			}

			/***** Insert Recepction Brands *****/
			if($params['brand'] != ""){
				$reception_id_query = $this->storage->get_last_reception();
				$reception_id = $reception_id_query->result_array()[0]['id'];					

				for ($i=0; $i < $count ; $i++) { 
			
					if($rows[$i] != ""){
						$row = explode(" ", $rows[$i]);
						$array = array("reception_id" => $reception_id, "quantity" => $row[0], "brand" => $row[1]);
						$this->storage->set_brands_reception($array);

					}					
					
				}
			}
			/***** Insert Recepction Brands *****/



			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						Se ha registrado la recepción EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('reception-form').reset(); });
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
					Ha ocurrido un error al registrar la recepción. La página se recargará para intentar corregirlo.
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

	public function delete_reception()
	{
		$reception_id = $_POST['id'];
		$method_id = $_POST['method'];
		$advance_supplier_id = $_POST['advance'];

		$this->storage->delete_reception($reception_id);

		if($this->db->affected_rows() > 0) {

			if($method_id == 1 || $method_id == 2) {
				$this->load->model('Finanzas_model', 'finances');
				$this->finances->remove_adv_supplier($advance_supplier_id);
			}

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $reception_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 3,
				"table" => "Recepciones"

			);

			$this->users->set_user_operation($array);


			?>
			<div id="message" class="alert alert-block alert-success">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
				<p>
					La recepción ha sido ELIMINADA exitosamente
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

	public function editar_recepcion ($reception_id)
	{
		$reception = $this->storage->get_reception($reception_id);

		$products = $this->storage->get_products();

		$this->load->model('Finanzas_model', 'finances');		
		$methods = $this->finances->get_methods();

		$this->load->model('Proveedores_model', 'suppliers');		
		$suppliers = $this->suppliers->get_suppliers_by_regional();

		$data['recursos'] = array(
				"reception" => $reception->result_array(),
				"suppliers" => $suppliers->result_array(),
				"methods" => $methods->result_array(),
				"products" => $products->result_array()
			);	


		
		$data['page'] = 'storage_reception_update';
		$data['footer'] = array('storage_reception_update');
		$this->load->view('home', $data);
	}

	public function update_reception ()
	{
		$params = $_POST['data'];
		$ini_method = $params['ini_method'];
		unset($params['ini_method']);
		$reception_id = $params['reception_id'];
		unset($params['reception_id']);
		$ini_adv = $params['ini_adv'];
		unset($params['ini_adv']);
		$ini_qua = $params['ini_qua'];
		unset($params['ini_qua']);
		$params['user_id'] = $_SESSION['id'];
		$params['regional_id'] = $_SESSION['regional'];


		$this->load->model('Finanzas_model', 'finances');

		/****** Brands Check Functions *******/
		if($params['brand'] != "") {
			$rows = explode("\n", $params['brand']);

			$count = count($rows);

			$brand_sum = 0;

			for ($i=0; $i < $count ; $i++) { 
				
				if($rows[$i] != ""){
					$row = explode(" ", $rows[$i]);
					$row = array_map('trim',$row);

					if(!is_numeric($row[0])){
						?>
						<div id="message" class="alert alert-block alert-danger">
							<a class="close" data-dismiss="alert" href="#">×</a>
							<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
							<p>
								No se pudo realizar la suma de las marcas. Asegurese de estar ingresando los datos en el formato correcto.
							</p>
						</div>

						<?php

						exit();
					} 
					
					$brand_sum = $brand_sum + $row[0];
				}				
				
			}
			

			if($params['quantity'] != $brand_sum){

				?>
				<div id="message" class="alert alert-block alert-danger">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
					<p>
						La suma de las marcas no corresponde a la cantidad recibida. Asegurese de estar ingresando los datos en el formato correcto.
					</p>
				</div>

				<?php

				exit();
			} 
		}
		
		/****** Brands Check Functions END *******/


		if($params['method_id'] == $ini_method) {

			if($params['method_id'] == 3) {
				// Rest verify
				
				$query = $this->finances->get_rest_advance($params['advance_supplier_id']);
				$rest_advance = $query->result_array()[0]['total_reception_quantity'];
				$quantity_advance = $query->result_array()[0]['quantity'];
				if($rest_advance == NULL){
					$rest_advance = 0;
				}
				$rest =  $quantity_advance - $rest_advance - $params['quantity'] + $ini_qua;

				if ($rest < 0) {
					?>
					<div id="message" class="alert alert-block alert-danger">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
						<p>
							La CANTIDAD FALTANTE no puede ser menor que cero (0)
						</p>
					</div>

					<?php
					exit();
				}
			} else {
				$rest = 0;
			}
			
			$query = $this->storage->update_reception($reception_id,$params);
			if ($query) {
				$this->load->model('Usuarios_model', 'users');
				$array = array(
					"date" => date("Y-m-d H:i:s"),
					"record_id" => $reception_id,
					"user_id" => $_SESSION['id'],
					"operation_id" => 2,
					"table" => "Recepción"

				);

				$this->users->set_user_operation($array);

				if($params['method_id'] == 1 || $params['method_id'] == 2) {
					$params['archived'] = 0;
					$params['unit_price'] = (float) $params['amount'] / (float) $params['quantity'];
					$params['detail'] = "(Nota de recepción) " . $params['note'];		
					$note = $params['note'];		
					unset($params['note']);
					$brand = $params['brand'];
					unset($params['brand']);
					unset($params['deleted']);

					$shamble_id = $params['shamble_id'];
					$shamble_amount = $params['shamble_amount'];
					unset($params['shamble_id']);
					unset($params['shamble_amount']);

					if($params['method_id'] == 1) {
						$params['payed'] = 1;
					} else {
						$params['payed'] = 0;
					}

					$update = $this->finances->update_adv_supplier($ini_adv,$params);
					if($update){
						$this->finances->set_advance_payed($ini_adv);
					}
				} else {
					/******* Si se recibe todo el producto se marca para no volverlo a mostrar en el combo *******/
					if($rest == 0){
						$this->finances->set_advance_payed($params['advance_supplier_id']);
					}
					
					/******* Si faltan 10 o menos producto por recibir DE UN ANTICIPO se envía alerta al correo *******/
					if($rest <= 10 && $params['method_id'] == 3 ) {
						$reception_query = $this->storage->get_reception($reception_id);
						$sendmail = $this->storage->send_low_rest_alert($reception_query->result_array(), $rest);
						
					}
				}

				

				/***** Insert Recepction Brands *****/
				$this->storage->remove_brands($reception_id);
				if($params['brand'] != ""){					

					for ($i=0; $i < $count ; $i++) { 
				
						if($rows[$i] != ""){
							$row = explode(" ", $rows[$i]);
							$row = array_map('trim',$row);
							$array = array("reception_id" => $reception_id, "quantity" => $row[0], "brand" => $row[1]);
							$this->storage->set_brands_reception($array);

						}					
						
					}
				}
				/***** Insert Recepction Brands *****/
				?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						La recepción ha sido ACTUALIZADA exitosamente.
					</p>
				</div>
				<script>
					setTimeout(function(){
						window.location.reload();
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
			

		} else {

			$this->load->model('Finanzas_model', 'finances');

			if($ini_method == 3) {

				$params['archived'] = 0;
				$params['unit_price'] = (float) $params['amount'] / (float) $params['quantity'];
				$params['detail'] = "(Nota de recepción) " . $params['note'];		
				$note = $params['note'];		
				unset($params['note']);
				$brand = $params['brand'];
				unset($params['brand']);
				unset($params['deleted']);

				$shamble_id = $params['shamble_id'];
				$shamble_amount = $params['shamble_amount'];
				unset($params['shamble_id']);
				unset($params['shamble_amount']);

				if($params['method_id'] == 1) {
					$params['payed'] = 1;
				} else {
					$params['payed'] = 0;
				}

				$params['advance_supplier_id'] = $this->finances->new_adv_supplier($params);

				unset($params['amount']);
				unset($params['unit_price']);
				$params['note'] = $note;
				unset($params['detail']);
				$params['brand'] = $brand;
				unset($params['product_id']);
				unset($params['archived']);
				unset($params['payed']);
				$params['shamble_id'] = $shamble_id;
				$params['shamble_amount'] = $shamble_amount;
				$params['deleted'] = 0;

				

				$query = $this->storage->update_reception($reception_id,$params);
				if ($query) {
					$this->load->model('Usuarios_model', 'users');
					$array = array(
						"date" => date("Y-m-d H:i:s"),
						"record_id" => $reception_id,
						"user_id" => $_SESSION['id'],
						"operation_id" => 2,
						"table" => "Recepción"

					);

					$this->users->set_user_operation($array);

					/***** Insert Recepction Brands *****/
					$this->storage->remove_brands($reception_id);
					if($params['brand'] != ""){					

						for ($i=0; $i < $count ; $i++) { 
					
							if($rows[$i] != ""){
								$row = explode(" ", $rows[$i]);
								$row = array_map('trim',$row);
								$array = array("reception_id" => $reception_id, "quantity" => $row[0], "brand" => $row[1]);
								$this->storage->set_brands_reception($array);

							}					
							
						}
					}
					/***** Insert Recepction Brands *****/
					?>
					<div id="message" class="alert alert-block alert-success">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
						<p>
							La recepción ha sido ACTUALIZADA exitosamente
						</p>
					</div>
					<script>
						setTimeout(function(){
							window.location.reload();
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

	
			/*** Si era Crédito o Débito y ahora es Anticipo ****/
			if($params['method_id'] == 3 && ($ini_method == 1 || $ini_method == 2)){


				// Rest verify
				
				$query = $this->finances->get_rest_advance($params['advance_supplier_id']);
				$rest_advance = $query->result_array()[0]['total_reception_quantity'];
				$quantity_advance = $query->result_array()[0]['quantity'];
				if($rest_advance == NULL){
					$rest_advance = 0;
				}
				$rest =  $quantity_advance - $rest_advance - $params['quantity'] + $ini_qua;

				if ($rest < 0) {
					?>
					<div id="message" class="alert alert-block alert-danger">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
						<p>
							La CANTIDAD FALTANTE no puede ser menor que cero (0)
						</p>
					</div>

					<?php
					exit();
				}

				$this->finances->remove_adv_supplier($ini_adv);

				$query = $this->storage->update_reception($reception_id,$params);
				if ($query) {
					$this->load->model('Usuarios_model', 'users');
					$array = array(
						"date" => date("Y-m-d H:i:s"),
						"record_id" => $reception_id,
						"user_id" => $_SESSION['id'],
						"operation_id" => 2,
						"table" => "Recepción"

					);

					$this->users->set_user_operation($array);

					/******* Si se recibe todo el producto se marca para no volverlo a mostrar en el combo *******/
					if($rest == 0){
						$this->finances->set_advance_payed($params['advance_supplier_id']);
					}
					
					/******* Si faltan 10 o menos producto por recibir DE UN ANTICIPO se envía alerta al correo *******/
					if($rest <= 10 && $params['method_id'] == 3 ) {
						$reception_query = $this->storage->get_reception($reception_id);
						$sendmail = $this->storage->send_low_rest_alert($reception_query->result_array(), $rest);
						
					}

					/***** Insert Recepction Brands *****/
					$this->storage->remove_brands($reception_id);
					if($params['brand'] != ""){					

						for ($i=0; $i < $count ; $i++) { 
					
							if($rows[$i] != ""){
								$row = explode(" ", $rows[$i]);
								$row = array_map('trim',$row);
								$array = array("reception_id" => $reception_id, "quantity" => $row[0], "brand" => $row[1]);
								$this->storage->set_brands_reception($array);

							}					
							
						}
					}
					/***** Insert Recepction Brands *****/
					?>
					<div id="message" class="alert alert-block alert-success">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
						<p>
							La recepción ha sido ACTUALIZADA exitosamente
						</p>
					</div>
					<script>
						setTimeout(function(){
							window.location.reload();
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

			if(($ini_method == 1 && $params['method_id'] == 2) || ($ini_method == 2 && $params['method_id'] == 1)) {
				
				$product_id = $params['product_id'];
				unset($params['product_id']);
				$amount = $params['amount'];
				unset($params['amount']);

				$query = $this->storage->update_reception($reception_id,$params);
				if ($query) {
					$this->load->model('Usuarios_model', 'users');
					$array = array(
						"date" => date("Y-m-d H:i:s"),
						"record_id" => $reception_id,
						"user_id" => $_SESSION['id'],
						"operation_id" => 2,
						"table" => "Recepción"

					);

					$this->users->set_user_operation($array);

					$params['amount'] = $amount;
					$params['product_id'] = $product_id;
					$params['archived'] = 0;
					$params['unit_price'] = (float) $params['amount'] / (float) $params['quantity'];
					$params['detail'] = "(Nota de recepción) " . $params['note'];		
					$note = $params['note'];		
					unset($params['note']);
					$brand = $params['brand'];
					unset($params['brand']);
					unset($params['deleted']);

					$shamble_id = $params['shamble_id'];
					$shamble_amount = $params['shamble_amount'];
					unset($params['shamble_id']);
					unset($params['shamble_amount']);

					if($params['method_id'] == 1) {
						$params['payed'] = 1;
					} else {
						$params['payed'] = 0;
					}

					$update = $this->finances->update_adv_supplier($ini_adv,$params);

					/***** Insert Recepction Brands *****/
					$this->storage->remove_brands($reception_id);
					if($params['brand'] != ""){					

						for ($i=0; $i < $count ; $i++) { 
					
							if($rows[$i] != ""){
								$row = explode(" ", $rows[$i]);
								$row = array_map('trim',$row);
								$array = array("reception_id" => $reception_id, "quantity" => $row[0], "brand" => $row[1]);
								$this->storage->set_brands_reception($array);

							}					
							
						}
					}
					/***** Insert Recepction Brands *****/
					?>
					<div id="message" class="alert alert-block alert-success">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
						<p>
							La recepción ha sido ACTUALIZADA exitosamente
						</p>
					</div>
					<script>
						setTimeout(function(){
							window.location.reload();
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


		}
		
	}

	public function get_last_reception()
	{
		$query = $this->storage->get_last_reception();

		foreach ($query->result_array() as $key => $value) {
			
			$complete = "";

			if($value['method_id'] == 1 || $value['method_id'] == 2){

				$adv_id = "(ID: ".$value['advance_supplier_id'].")";

			} else {
				$adv_id = "";
			}

			if($value['brand'] != ""){
				$brands = "(";
				$brands .= str_replace("\n", ", ", $value['brand']);
				$brands .= ")";
			}else {
				$brands = "";
			}

			if($value['note'] != "") {
				$note = '<a onclick="javascript:set_modal('.$value['id'].')"  href="#noteModal" data-toggle="modal"  id="note_'.$value['id'] .'" data-note="'.$value['note'] .'"><i class="fa fa-comment"></i></a>';
			}else {
				$note = "";
			}

			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['supplier_name']; ?></td>		
					<td><?= ucfirst(strftime("%A %d-%m-%Y", strtotime($value['reception_date']))); ?></td>		
					<td><?= $value['method_name'] ?> <?= $adv_id ?></td>
					<td><?= $value['product_name']; ?></td>
					<td><?= $value['reception_quantity']."<br>".$brands; ?></td>
					<td><?= $value['reception_amount']; ?></td>	
					<td>
						&nbsp;
						<?= $note; ?>
						&nbsp;
						<?php if($_SESSION['profile'] == 1){ ?>
						&nbsp;
						<a href="<?= base_url() ?>bodega/editar_recepcion/<?= $value['id'] ?>" title="Editar Recepción">
							<i class="fa fa-pencil fa-lg"></i>
						</a>
						&nbsp;	
						&nbsp;
						<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Eliminar Recepción" onclick="javascript:set_modal_delete(<?= $value['id'] ?>)">
							<i class="fa fa-trash fa-lg"></i>
						</a>
						&nbsp;													
						<?php } ?>	
					</td>											
				</tr>
			<?php

		} //End foreach
	}

	public function despachos_clientes()
	{
		/******** Consultar despachos *******/
		$dispatches = $this->storage->get_dispatches();

		$this->load->model('Finanzas_model', 'finances');		
		$client_advances = $this->finances->get_client_advances();

		$dato['recursos'] = array(
				"dispatches" => $dispatches->result_array(),
				"client_advances" => $client_advances->result_array()
			);		

		$dato['page'] = "storage_dispatches_client";
		$dato['footer'] = array('storage_dispatches_client');
		$this->load->view('home',$dato);
	}

	public function set_dispatch_client ()
	{
		$params = [];
		parse_str($_POST['data'],$params);

		$this->load->model('Finanzas_model', 'finances');
		$query = $this->finances->get_rest_advance_dispatch_client($params['advance_client_id']);
		$rest_advance = $query->result_array()[0]['total_dispatch_client_rest'];
		$quantity_advance = $query->result_array()[0]['quantity'];
		if($rest_advance == NULL){
			$rest_advance = 0;
		}
		$rest =  $quantity_advance - $rest_advance - $params['quantity'];

		/******* Si ha despachado todo el producto se marca para no volverlo a mostra en el combo *******/
		if($rest == 0){
			$this->finances->set_advance_client_payed($params['advance_client_id']);
		}

		if ($rest < 0) {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					La CANTIDAD FALTANTE no puede ser menor que cero (0)
				</p>
			</div>

			<?php
		} else {

			$params['user_id'] = $this->session->userdata('id'); 
			$params['regional_id'] = $this->session->userdata('regional'); 

			unset($params['rest']);

			$dispatch_client_id = $this->storage->set_dispatch_client($params);

			if($this->db->affected_rows() > 0) {

				$this->load->model('Usuarios_model', 'users');
				$array = array(
					"date" => date("Y-m-d H:i:s"),
					"record_id" => $dispatch_client_id,
					"user_id" => $_SESSION['id'],
					"operation_id" => 1,
					"table" => "Despacho Cliente"

				);

				$this->users->set_user_operation($array);

				?>
					<div id="message" class="alert alert-block alert-success">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
						<p>
							El despacho se ha registrado EXITOSAMENTE
						</p>
					</div>
					<script>
						setTimeout(function() {
							$('#message').fadeOut('slow',function() { 
								$('#message').remove(); 
								document.getElementById('dispatches-client-form').reset(); });
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
						Ha ocurrido un error al registrar el despacho. La página se recargará para intentar corregirlo.
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

	public function get_last_dispatch_client()
	{
		$query = $this->storage->get_last_dispatch_client();

		foreach ($query->result_array() as $key => $value) {
			
			$query_rest = $this->storage->rest_on_this_disátch_client($value['id'],$value['advance_client_id']);

			$rest = $value['advance_quantity'] - $value['dispatch_quantity'] - $query_rest->result_array()[0]['rest'];
			$rest = number_format($rest, 2, '.', ' ');

			if($rest == 0){
				$pagado = '<i class="fa fa-check fa-lg text-success"></i>';
			} else {
				$pagado = "";
			}

			if($value['note'] != "") {
				$note = '<a onclick="javascript:set_modal('.$value['id'].')"  href="#noteModal" data-toggle="modal"  id="note_'.$value['id'] .'" data-note="'.$value['note'] .'"><i class="fa fa-comment"></i></a>';
			}else {
				$note = "Vacio";
			}

			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['client_name']; ?></td>
					<td><?= $value['advance_client_id']; ?></td>
					<td><?= $value['product_name']; ?></td>
					<td><?= $value['dispatch_quantity']; ?></td>
					<td><?= date('d-m-Y',strtotime($value['dispatch_date'])); ?></td>

					<td><?= $rest.' '.$pagado; ?></td>
					<td><?= $note; ?></td>												
				</tr>
			<?php

		} //End foreach
	}

	public function set_dispatch_regional ()
	{
		$params = [];
		parse_str($_POST['data'],$params);

		$params['user_id'] = $this->session->userdata('id'); 
		$params['regional_id'] = $this->session->userdata('regional');
		$params['dispatch_status_id'] = 1;  
		

		$dispatch_regional_id = $this->storage->set_dispatch_regional($params);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $dispatch_regional_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Despacho Regional"

			);

			$this->users->set_user_operation($array);

			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El despacho se ha registrado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('dispatches-client-form').reset(); });
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
					Ha ocurrido un error al registrar el despacho. La página se recargará para intentar corregirlo.
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

	public function get_last_dispatch_regional()
	{
		$query = $this->storage->get_last_dispatch_regional();

		foreach ($query->result_array() as $key => $value) {
			
			if($value['dispatch_note'] != "") {
				$note = '<a onclick="javascript:set_modal('.$value['id'].')"  href="#noteModal" data-toggle="modal"  id="note_'.$value['id'] .'" data-note="'.$value['note'] .'"><i class="fa fa-comment"></i></a>';
			}else {
				$note = "Vacio";
			}

			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['regional_name']; ?></td>
					<td><?= $value['to_name']; ?></td>
					<td><?= $value['product_name']; ?></td>
					<td><?= $value['quantity']; ?></td>
					<td><?= date('d-m-Y',strtotime($value['date'])); ?></td>

					<td><?= $value['status']; ?></td>	
					<td><?= $note; ?></td>											
				</tr>
			<?php

		} //End foreach
	}

	public function despachos_anticipo($advance_client_id)
	{
		$dispatches = $this->storage->get_advance_dispatches($advance_client_id);

		$dato['recursos'] = array(
				"advance_dispatches" => $dispatches->result_array()
			);

		$dato['page'] = "storage_advance_dispatches";
		$dato['footer'] = array("storage_advance_dispatches");
		$this->load->view('home', $dato);
	}

	public function recepciones_anticipo($advance_supplier_id)
	{
		$receptions = $this->storage->get_advance_receptions($advance_supplier_id);

		$dato['recursos'] = array(
				"advance_receptions" => $receptions->result_array()
			);

		$dato['page'] = "storage_advance_receptions";
		$dato['footer'] = array("storage_advance_receptions");
		$this->load->view('home', $dato);
	}

	public function recepciones_central() 
	{
		/******** Consultar recepciones *******/
		$receptions = $this->storage->get_receptions_central();

		$this->load->model('Regionales_model', 'regional');		
		$regionals = $this->regional->get_regionals();

		$dato['recursos'] = array(
				"receptions" => $receptions->result_array(),
				"regionals" => $regionals->result_array()
			);		

		$dato['page'] = "storage_receptions_central";
		$dato['footer'] = array('storage_receptions_central');
		$this->load->view('home',$dato);
	}

	public function get_regional_dispatches($option)
	{
		

		if($option == 1) {

			$regional_id = $_POST['data'];
			$query = $this->storage->get_regional_dispatches($regional_id);

			if(!empty($query->result_array())){

				?>
				<option value="" selected="" disabled="">Seleccione un despacho</option>
				<?php

				foreach ($query->result_array() as $key => $value) {
					?>
					<option value="<?= $value['id'] ?>"><?= $value['quantity'] ?> <?= $value['product_name'] ?> | <?= date('d-m-Y H:i',strtotime($value['date'])) ?></option>
					
					<?php
				}

			} else {
				?>
				<option value="" selected="" disabled="">No existe ningún despacho</option>

				<?php
			}
		}

		if($option == 2){

			$dispatch_id = $_POST['data'];
			$query = $this->storage->get_dispatch_note($dispatch_id);
			echo $query->result_array()[0]['dispatch_note'];
		}
	}

	public function set_reception_central()
	{
		$params = [];
		parse_str($_POST['data'],$params);

		unset($params['dispatch_note']);
		$params['user_id'] = $this->session->userdata('id');


		$reception_central_id = $this->storage->set_reception_central($params);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $reception_central_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Recepción Central"

			);

			$this->users->set_user_operation($array);

			$query_id = $this->storage->get_last_reception_central();
			$id = $query_id->result_array()[0]['dispatch_regional_id'];
			$this->storage->set_dispatch_status($id,2);
			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						La recepción se ha registrado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('reception-form').reset(); });
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
					Ha ocurrido un error al registrar la recepción. La página se recargará para intentar corregirlo.
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

	public function get_last_reception_central()
	{
		$query = $this->storage->get_last_reception_central();

		foreach ($query->result_array() as $key => $value) {
				
			if($value['note_reception'] != "") {
				$note = '<a onclick="javascript:set_modal('.$value['id'].')"  href="#noteModal" data-toggle="modal"  id="note_'.$value['id'] .'" data-note="'.$value['note'] .'"><i class="fa fa-comment"></i></a>';
			}else {
				$note = "Vacio";
			}
			?>
				<tr id="tr_<?= $value['id'] ?>">
					<td><?= $value['id']; ?></td>
					<td><?= $value['regional_name']; ?></td>
					<td>
						<a href="<?= base_url() ?>bodega/despachos_regionales/<?= $value['dispatch_regional_id']; ?>">
						<?= $value['dispatch_regional_id']; ?>
						</a>	
					</td>
					<td><?= $value['product_name']; ?></td>
					<td><?= $value['reception_quantity']; ?></td>
					<td><?= date('d-m-Y',strtotime($value['reception_date'])); ?></td>
					<td><?= $note; ?></td>											
				</tr>
			<?php

		} //End foreach
	}

	public function despachos_regionales($id = "")
	{
		if($id == ""){
			/******** Consultar recepciones *******/
			$regional_dispatches = $this->storage->get_my_regional_dispatches();

			$this->load->model('Regionales_model', 'regional');		
			$regionals = $this->regional->get_regionals_for_regional_dispatches();

			$products = $this->storage->get_products();

			$dato['recursos'] = array(
					"regional_dispatches" => $regional_dispatches->result_array(),
					"regionals" => $regionals->result_array(),
					"products" => $products->result_array()
				);		

			$dato['page'] = "storage_dispatches_regional";
			$dato['footer'] = array('storage_dispatches_regional');
			$this->load->view('home',$dato);
		} else {

			/******** Consultar recepciones *******/
			$regional_dispatch = $this->storage->get_regional_dispatches_by_id($id);

			$this->load->model('Regionales_model', 'regional');		
			$regionals = $this->regional->get_regionals();

			$products = $this->storage->get_products();

			$dato['recursos'] = array(
					"regional_dispatch" => $regional_dispatch->result_array(),
					"regionals" => $regionals->result_array(),
					"products" => $products->result_array()
				);		

			$dato['page'] = "storage_dispatch_regional";
			$this->load->view('home',$dato);
		}

	}

	public function productos()
	{
		/******** Consultar recepciones *******/
		$products = $this->storage->get_all_products();

		$dato['recursos'] = array(
				"products" => $products->result_array()
			);		

		$dato['page'] = "storage_products";
		$dato['footer'] = array('storage_products');
		$this->load->view('home',$dato);
	}

	public function set_selectable_product()
	{
		$params = $_POST['data'];

		$this->storage->set_selectable_product($params['id'],$params['selectable']);

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

	public function update_product()
	{
		$params = $_POST['data'];

		$exist_product = $this->storage->exist_product_name($params['name']);

		if($exist_product > 0 ) {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ya existe un producto con este nombre. Por favor ingrese uno diferente.
				</p>
			</div>
			<?php

			exit();
		}

		$this->storage->update_product($params['id'],$params['name']);

		if($this->db->affected_rows() > 0) {
			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $params['id'],
				"user_id" => $_SESSION['id'],
				"operation_id" => 2,
				"table" => "Producto"

			);

			$this->users->set_user_operation($array);
			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El producto ha sido actualizado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('edit-product-form').reset(); 
							window.location.reload();
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
					Ha ocurrido un error al editar el producto. La página se recargará para intentar corregirlo.
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

	public function set_product()
	{
		$params = $_POST['data'];

		$exist_product = $this->storage->exist_product_name($params['name']);

		if($exist_product > 0 ) {
			?>
			<div class="alert alert-block alert-danger">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error!</h4>
				<p>
					Ya existe un producto con este nombre. Por favor ingrese uno diferente.
				</p>
			</div>
			<?php

			exit();
		}

		$product_id = $this->storage->set_product($params['name']);

		if($this->db->affected_rows() > 0) {

			$this->load->model('Usuarios_model', 'users');
			$array = array(
				"date" => date("Y-m-d H:i:s"),
				"record_id" => $product_id,
				"user_id" => $_SESSION['id'],
				"operation_id" => 1,
				"table" => "Producto"

			);

			$this->users->set_user_operation($array);

			?>
				<div id="message" class="alert alert-block alert-success">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> ¡Exito!</h4>
					<p>
						El producto ha sido registrado EXITOSAMENTE
					</p>
				</div>
				<script>
					setTimeout(function() {
						$('#message').fadeOut('slow',function() { 
							$('#message').remove(); 
							document.getElementById('product-form').reset(); 
						});
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

	public function get_last_product()
	{
		$query = $this->storage->get_last_product();

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

	public function soporte_recepciones()
	{
		$receptions_imgs = $this->storage->get_receptions_imgs();

		$dato['recursos'] = array(
				"receptions_imgs" => $receptions_imgs->result_array()
			);

		$dato['page'] = "storage_reception_img_support";
		$dato['footer'] = array('storage_reception_img_support');
		$this->load->view('home',$dato);
	}

	public function set_reception_support()
	{
		$name = date("YmdHis",time()) . "_rg" . $_SESSION['regional'] . "_usr" . $_SESSION['id'] . ".jpg";

	 	$config['upload_path'] = "./assets/supports/receptions";
        $config['file_name'] = $name;
        //$config['file_ext_tolower'] = true;
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
	            	"file_name" => $file_info['file_name']
	            );
            	$reception_img_id = $this->storage->set_reception_img($params);

            	if($this->db->affected_rows() > 0) {

            		$this->load->model('Usuarios_model', 'users');
					$array = array(
						"date" => date("Y-m-d H:i:s"),
						"record_id" => $reception_img_id,
						"user_id" => $_SESSION['id'],
						"operation_id" => 1,
						"table" => "Soporte Recepción"

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
        $config['source_image'] = 'assets/supports/receptions/'.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config["thumb_marker"] = "";
        $config['new_image']='assets/supports/receptions/thumbs/';
        $config['width'] = 150;
        $config['height'] = 150;
        $this->load->library('image_lib', $config); 
        return $this->image_lib->resize();
    }

}

/* End of file Bodega.php */
/* Location: ./application/controllers/Bodega.php */