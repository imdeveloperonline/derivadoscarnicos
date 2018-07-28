
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				<a href="<?= base_url() ?>bodega/recepciones">Bodega</a>
			</li>
			<li>
				Editar
			</li>
		</ol>

	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">


	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">
				
				<!-- PAGE HEADER -->
				<i class="fa-fw fa fa-shopping-cart"></i> 
					<a href="<?= base_url() ?>bodega/recepciones">Bodega</a>
				<span>>  
					Editar
				</span>
				<span>>  
					Recepción <strong class="text-uppercase">N° <?= $datos['reception'][0]['id']; ?></strong>
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<?php foreach ($datos['reception'] as $clave => $valor) { 

			?>


 
		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-8 col-lg-offset-2">
			
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-custombutton="false">

				<!-- widget div-->
				<div>
					
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
						
					</div>
					<!-- end widget edit box -->
					<?php $ci = &get_instance();
					$ci->load->helper('numbers');
					 ?>
					<script type="text/javascript">
						var supplier_id_ini = <?= $valor['supplier_id'] ?>;
						var method_id = <?= $valor['method_id'] ?>;
					</script>
					<!-- widget content -->
					<div class="widget-body no-padding">

						<form id="reception-form" class="smart-form" action="javascript:update_reception()">
							<input type="hidden" name="reception_id" value="<?= $valor['id'] ?>">
							<div id="form-alert"></div>
							<fieldset>
								<div class="row">
									<div class="col col-6">
										<label class="label"><strong>Proveedor</strong></label>
										<label class="input">
											<select name="supplier" style="width:100%;" class="select2" id="supplier" required="required" data-placeholder="Seleccione un proveedor" disabled="disabled">
												<option></option>		
												<optgroup>
													<?php 
														foreach ($datos['suppliers'] as $key => $value) {
															if($value['id'] == $valor['supplier_id']){
															?>
																<option value="<?= $value['id']; ?>" selected="selected"><?= $value['supplier_name']; ?></option>
															<?php
															} else {
															?>
																<option value="<?= $value['id']; ?>"><?= $value['supplier_name']; ?></option>
															<?php
															}
														}


													 ?>
												</optgroup>
											</select>
										</label>
									</div>

									<section class="col col-6">
										<label class="label"><strong>Método de pago</strong></label>
										<label class="select">
											<select name="method" required disabled="">
												<option value="" selected="" disabled="">Método de pago</option>

												<?php 


													foreach ($datos['methods'] as $key => $value) {
														if($value['id'] == $valor['method_id']){

															if($value['id'] != 2){
																?>
																	<option value="<?= $value['id']; ?>" selected="selected"><?= $value['name']; ?></option>
																<?php
																} else {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
																<?php
																}
															}
													}


												 ?>
											</select> <i></i> </label>
									</section>
									
								</div>

								<?php 
								if($valor['method_id'] != 3) {
									$dnone_adv = 'style="display:none"';
									$disabled_adv = 'disabled="disabled"';
								} else {
									$dnone_adv = '';
									$disabled_adv = '';
								}
								?>

								<div class="row unit_price">
									<section class="col col-6">
										<label class="label"><strong>Precio Unitario</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-dollar"></i>
											<input type="text" name="unit_price" placeholder="Precio Unitario"  required readonly="" value="">
										</label>
										<div class="note">
											Este campo es llenado automáticamente con la información del proveedor
										</div>
									</section>

									<section class="col col-6 advance" <?= $dnone_adv ?>>
										<label class="label"><strong>Saldo proveedor</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-window-minimize"></i>
											<input type="text" name="adv_balance" placeholder="Saldo proveedor" required  readonly="" <?= $disabled_adv ?>>
										</label>
										<div class="note">
											Este campo es llenado automáticamente y no puede ser menor a cero (0)
										</div>
									</section>
								</div>
								
								

								<div class="row advance" <?= $dnone_adv ?>>
									<section class="col col-6">
										<label class="label"><strong>Cantidad</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
											<input type="text" name="quantity" placeholder="Cantidad" required amounts="true" <?= $disabled_adv ?> value="<?= latin_format_number($valor['reception_quantity']) ?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Fecha</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="date" id="date" placeholder="Fecha" required <?= $disabled_adv ?> value="<?= date('Y-m-d',strtotime($valor['reception_date'])) ?>">
										</label>
									</section>
								</div>

								<div class="row advance" <?= $dnone_adv ?>>
									<section class="col col-6">
										<label class="label"><strong>Producto</strong></label>
										<label class="input">
											<select name="product_advance" style="width: 100%" class="select2" required <?= $disabled_adv ?> data-placeholder="Seleccione un producto">
												<option></option>
												
												<?php 


													foreach ($datos['products'] as $key => $value) {
														if($value['id'] == $valor['product_id']){
															?>
																<option value="<?= $value['id']; ?>" selected="selected"><?= $value['name']; ?></option>
															<?php
															} else {
															?>
																<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
															<?php
															}
													}


												 ?>
											</select> </label>
									</section>
								</div>

								<?php 
								if($valor['method_id'] != 2 && $valor['method_id'] != 1) {
									$dnone_credit = 'style="display:none"';
									$disabled_credit = 'disabled="disabled"';
								}  else {
									$dnone_credit = '';
									$disabled_credit = '';
								}

								 ?>
								<input type="hidden" name="advance_supplier_id" value="<?= $valor['advance_supplier_id'] ?>">
								<div class="row credit" <?= $dnone_credit ?>>
									<section class="col col-6">
										<label class="label"><strong>Producto</strong></label>
										<label class="input">
											<select name="product_credit" style="width: 100%" class="select2" required <?= $disabled_credit ?> data-placeholder="Seleccione un producto">
												<option></option>
												
												<?php 


													foreach ($datos['products'] as $key => $value) {
														if($value['id'] == $valor['product_id']){
															?>
																<option value="<?= $value['id']; ?>" selected="selected"><?= $value['name']; ?></option>
															<?php
															} else {
															?>
																<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
															<?php
															}
													}


												 ?>
											</select> </label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Cantidad</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
											<input type="text" name="quantity_credit" placeholder="Cantidad" required amounts="true" <?= $disabled_credit ?> value="<?= latin_format_number($valor['reception_quantity']) ?>">
										</label>
									</section>
								</div>
								<div class="row credit" <?= $dnone_credit ?>>
									<section class="col col-6">
										<label class="label"><strong>Valor (COP)</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-dollar"></i>
											<input type="text" name="amount_credit" placeholder="Valor (COP)" required amounts="true" <?= $disabled_credit ?> onkeyup="this.value = numberFront('amount_credit')" value="<?= latin_format_number($valor['reception_amount']) ?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Fecha</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="date_credit" id="date_credit" placeholder="Fecha" required <?= $disabled_credit ?> value="<?= date('Y-m-d',strtotime($valor['reception_date'])) ?>">
										</label>
									</section>
								</div>

								<?php 
								
								$ci->load->model("Proveedores_model","suppliers");

								$query_shambles = $ci->suppliers->get_supplier_shambles_by_regional($valor['supplier_id']);
								 ?>
								<div class="row shamble">
									<section class="col col-6">
										<label class="label"><strong>Frigorífico</strong></label>
										<label class="select">
											<select name="shamble" required>
												<option value="" disabled="" selected="">Seleccione un frigorífico</option>
												<?php 


													foreach ($query_shambles->result_array() as $key => $value) {
														if($value['id'] == $valor['shamble_id']){
															?>
																<option value="<?= $value['id']; ?>" selected="selected"><?= $value['tradename']; ?></option>
															<?php
															} else {
															?>
																<option value="<?= $value['id']; ?>"><?= $value['tradename']; ?></option>
															<?php
															}
													}


												 ?>
											</select> <i></i></label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Gasto Frigorífico</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-dollar"></i>
											<input type="text" name="shamble_amount" placeholder="Gasto Frigorífico" onkeyup="this.value = numberFront('shamble_amount')" value="<?= latin_format_number($valor['shamble_amount']) ?>">
										</label>
									</section>
								</div>

								<section>
									<label class="label"><strong>Marcas</strong></label>
									<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						 
										<textarea rows="5" name="brand" placeholder="Marcas"><?= $valor['brand'] ?></textarea> 
									</label>
								<div class="note">
									<strong>Formato:</strong> Cantidad + Espacio + Marca. <strong>Ej:</strong> 10 M5.<br> Para insertar varios registros, separelos con un salto de línea utilizando la tecla ENTER.
								</div>
								</section>
								
								
								<section>
									<label class="label"><strong>Nota</strong></label>
									<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						 
										<textarea rows="5" name="note" placeholder="Nota"><?= $valor['note'] ?></textarea> 
									</label>																		
								<div class="note">
									El valor de <i>CANTIDAD</i> debe ser entero o decimal de dos (2) dígitos separados por un punto (.)
								</div>
								</section>	
								
							</fieldset>
							
							<footer>
								<button type="submit" id="button" class="btn btn-primary">
									Guardar Cambios
								</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Cancelar
								</button>

							</footer>
						</form>		
						
					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->
										


		</article>
		<!-- END COL -->
		
		
		<?php } //End foreach ?>


	</div>

	<!-- END ROW -->

</section>
<!-- end widget grid -->

			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		