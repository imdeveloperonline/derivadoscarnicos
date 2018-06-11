
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

		<?php foreach ($datos['reception'] as $key => $value) { 

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
					
					<!-- widget content -->
					<div class="widget-body no-padding">

						<form id="reception-form" class="smart-form" action="javascript:update_reception()">
							<input type="hidden" name="reception_id" value="<?= $value['id'] ?>">
							<input type="hidden" name="ini_method" value="<?= $value['method_id'] ?>">
							<input type="hidden" name="ini_adv" value="<?= $value['advance_supplier_id'] ?>">
							<input type="hidden" name="ini_qua" value="<?= $value['reception_quantity'] ?>">
							<fieldset>
								<div class="row">
									<div class="col col-6">
										<label class="label"><strong>Proveedor</strong></label>
										<label class="input">
											<select name="supplier" style="width:100%;" class="select2" id="supplier" required="required" data-placeholder="Seleccione un proveedor">
												<option></option>		
												<optgroup>
													<?php 
														foreach ($datos['suppliers'] as $k => $v) {
															if($value['supplier_id'] == $v['id']){
															?>
																<option value="<?= $v['id']; ?>" selected="selected"><?= $v['supplier_name']; ?></option>
															<?php
															} else {
															?>
																<option value="<?= $v['id']; ?>"><?= $v['supplier_name']; ?></option>
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
											<select name="method" required>
												<option value="" selected="" disabled="">Método de pago</option>

												<?php 


													foreach ($datos['methods'] as $k => $v) {
														if($value['method_id'] == $v['id']){
														?>
															<option value="<?= $v['id']; ?>" selected="selected"><?= $v['name']; ?></option>
														<?php
														} else {
														?>
															<option value="<?= $v['id']; ?>"><?= $v['name']; ?></option>
														<?php
														}
													}


												 ?>
											</select> <i></i> </label>
									</section>
									
								</div>
								<?php if($value['method_id'] == 3) { 

										$ci = &get_instance();
										$ci->load->model('Finanzas_model','finances');
										$query_adv_by_supplier = $ci->finances->get_adv_by_supplier($value['supplier_id']);

										$query_rest = $ci->finances->get_rest_advance($value['advance_supplier_id']);

									?>
								<div class="row advance">
									<section class="col col-6">
										<label class="label"><strong>Anticipo Correspondiente</strong></label>
										<label class="input" disabled>
											<select name="advance_supplier_id" style="width: 100%" class="select2" required data-placeholder="Seleccione un anticipo">
											<optgroup>
												
												<?php 
												foreach ($query_adv_by_supplier->result_array() as $k => $v) {
													if($v['id'] == $value['advance_supplier_id']) {
														?>
														<option value="<?= $v['id'] ?>" selected="selected"><?= date("d-m-Y",strtotime($v['date']))." | ". $v['quantity'] ." | ".$v['product_name']; ?></option>
														<?php
													} else {
														?>
														<option value="<?= $v['id'] ?>"><?= date("d-m-Y",strtotime($v['date']))." | ". $v['quantity'] ." | ".$v['product_name']; ?></option>
														<?php
													}
												} 
												?>
											</optgroup>
												
											</select> </label>
									</section>

									<section class="col col-6">
										<label class="label"><strong>Producto por recibir</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-window-minimize"></i>
											<input type="text" name="rest" placeholder="Producto por recibir"  required rest="true" readonly="" value="<?= $query_rest->result_array()[0]['rest'] ?>">
										</label>
										<div class="note">
											Este campo es llenado autmáticamente y no puede ser menor a cero (0)
										</div>
									</section>
									
								</div>

								<div class="row advance">
									<section class="col col-6">
										<label class="label"><strong>Cantidad</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
											<input type="text" name="quantity" placeholder="Cantidad" required amounts="true" value="<?= $value['reception_quantity'] ?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Fecha</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="date" id="date" placeholder="Fecha" required value="<?= date("Y-m-d",strtotime($value['reception_date'])) ?>">
										</label>
									</section>
								</div>

								<div class="row credit" style="display: none">
									<section class="col col-6">
										<label class="label"><strong>Producto</strong></label>
										<label class="input">
											<select name="product" style="width: 100%" class="select2" required disabled="" data-placeholder="Seleccione un producto">
												<option></option>
												
												<?php 


													foreach ($datos['products'] as $k => $v) {
														?>
															<option value="<?= $v['id']; ?>"><?= $v['name']; ?></option>
														<?php
													}


												 ?>
											</select> </label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Cantidad</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
											<input type="text" name="quantity_credit" placeholder="Cantidad" required amounts="true" disabled="">
										</label>
									</section>
								</div>
								<div class="row credit" style="display: none">
									<section class="col col-6">
										<label class="label"><strong>Valor (COP)</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-dollar"></i>
											<input type="text" name="amount_credit" placeholder="Valor (COP)" required amounts="true" disabled="">
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Fecha</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="date_credit" id="date_credit" placeholder="Fecha" required disabled="">
										</label>
									</section>
								</div>
								<?php } ?>
								<?php if($value['method_id'] == 1 || $value['method_id'] == 2) { ?>
								<div class="row credit">
									<section class="col col-6">
										<label class="label"><strong>Producto</strong></label>
										<label class="input">
											<select name="product" style="width: 100%" class="select2" required data-placeholder="Seleccione un producto">
												<option></option>
												
												<?php 


													foreach ($datos['products'] as $k => $v) {
														if($v['id'] == $value['product_id']){
														?>
															<option value="<?= $v['id']; ?>" selected="selected"><?= $v['name']; ?></option>
														<?php
														} else {
														?>
															<option value="<?= $v['id']; ?>"><?= $v['name']; ?></option>
														<?php	
														}
													}


												 ?>
											</select> </label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Cantidad</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
											<input type="text" name="quantity_credit" placeholder="Cantidad" required amounts="true" value="<?= $value['reception_quantity'] ?>">
										</label>
									</section>
								</div>
								<div class="row credit">
									<section class="col col-6">
										<label class="label"><strong>Valor (COP)</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-dollar"></i>
											<input type="text" name="amount_credit" placeholder="Valor (COP)" required amounts="true" value="<?= $value['amount'] ?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Fecha</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="date_credit" id="date_credit" placeholder="Fecha" required value="<?= date("Y-m-d",strtotime($value['reception_date'])) ?>">
										</label>
									</section>
								</div>
								<div class="row advance" style="display: none">
									<section class="col col-6">
										<label class="label"><strong>Anticipo Correspondiente</strong></label>
										<label class="input" disabled>
											<select name="advance_supplier_id" style="width: 100%" class="select2" required disabled="" data-placeholder="Seleccione un anticipo">

												
											</select> </label>
									</section>

									<section class="col col-6">
										<label class="label"><strong>Producto por recibir</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-window-minimize"></i>
											<input type="text" name="rest" placeholder="Producto por recibir"  required rest="true" readonly="" disabled="">
										</label>
										<div class="note">
											Este campo es llenado autmáticamente y no puede ser menor a cero (0)
										</div>
									</section>
									
								</div>

								<div class="row advance" style="display: none">
									<section class="col col-6">
										<label class="label"><strong>Cantidad</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
											<input type="text" name="quantity" placeholder="Cantidad" required amounts="true" disabled="">
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Fecha</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="date" id="date" placeholder="Fecha" required disabled="">
										</label>
									</section>
								</div>
								<?php } ?>
								<div class="row shamble">
									<?php 
									$ci = &get_instance();
									$ci->load->model('Proveedores_model','suppliers');
									$query_shambles = $ci->suppliers->get_supplier_shambles_by_regional($value['supplier_id']);

									 ?>
									<section class="col col-6">
										<label class="label"><strong>Frigorífico</strong></label>
										<label class="select">
											<select name="shamble" required>
												<option value="" disabled="" selected="">Seleccione un frigorífico</option>
												<?php 
												foreach ($query_shambles->result_array() as $k => $v) {
													if($v['id'] == $value['shamble_id']) {
														?>
														<option value="<?= $v['id'] ?>" selected="selected"><?= $v['tradename'] ?></option>			
														<?php
													} else {
														?>
														<option value="<?= $v['id'] ?>"><?= $v['tradename'] ?></option>			
														<?php
													}
												}


												 ?>
											</select> <i></i></label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Gasto Frigorífico</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-dollar"></i>
											<input type="text" name="shamble_amount" placeholder="Gasto Frigorífico"  amounts="true" value="<?= $value['shamble_amount'] ?>">
										</label>
									</section>
								</div>

								<section>
									<label class="label"><strong>Marcas</strong></label>
									<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						 
										<textarea rows="5" name="brand" placeholder="Marcas"><?= $value['brand'] ?></textarea> 
									</label>
								<div class="note">
									<strong>Formato:</strong> Cantidad + Espacio + Marca. <strong>Ej:</strong> 10 M5.<br> Para insertar varios registros, separelos con un salto de línea utilizando la tecla ENTER.
								</div>
								</section>
								
								
								<section>
									<label class="label"><strong>Nota</strong></label>
									<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						 
										<textarea rows="5" name="note" placeholder="Nota"><?= $value['note'] ?></textarea> 
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

		