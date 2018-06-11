
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				<a href="<?= base_url() ?>clientes">Clientes</a>
			</li>
			<li>
				Direcciones de envío
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
				<i class="fa-fw fa fa-briefcase"></i> 
					<a href="<?= base_url() ?>clientes">Clientes</a>
				<span>>  
					Direcciones de Envío
				</span>
				<span>>  
					<strong class="text-uppercase"><?= $datos['client_addresses'][0]['tradename']; ?></strong>
				</span>
				<span>
					<a href="#modal-new-address" data-toggle="modal"><i class="fa fa-plus-circle"></i></a>
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<?php $n = 1; ?>
		<?php foreach ($datos['client_addresses'] as $key => $value) { 

			if($value['address_id'] != NULL) {

			?>



		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-6" id="article<?= $n ?>">
			
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

						<form id="new-address-client-form<?= $n ?>" class="smart-form address-form" novalidate="novalidate" action="javascript:update_address(<?= $n ?>)">
							<input type="hidden" name="address_id<?= $n ?>" value="<?= $value['address_id'] ?>">
							<header>
								<span><i class="fa fa-ship"></i></span> <strong>Dirección de Envío</strong>
							</header>
							
							<div id="address_client">
								<fieldset>
									<section>
										<label class="label"><strong>Dirección</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-map"></i>
											<input type="text" name="address<?= $n ?>" placeholder="Dirección" value="<?= $value['send_address']; ?>" disabled required>
										</label>
									</section>

									<div class="row">
										<section class="col col-6">
											<label class="label"><strong>Código postal</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-user"></i>
												<input type="text" name="zip<?= $n ?>" placeholder="Nombre" value="<?= $value['address_zip']; ?>" disabled>
											</label>
										</section>
										<div class="col col-6">
											<label class="label"><strong>Ciudad</strong></label>
											<label class="input">
											<select name="city<?= $n ?>" style="width: 100%" class="select2" disabled required onchange="javascript:location_message(<?= $n ?>)">
												<optgroup>
												<option value="" selected="" disabled="">Ciudad</option>

												<?php 


													foreach ($datos['cities'] as $key_city => $value_city) {
														

														

															if($value['city_id'] == $value_city['id']) {
																?>

																<option value="<?= $value_city['id']; ?>" selected><?= $value_city['name']." - ".$value_city['department_name']; ?></option>

																<?php
															}else {
																?>

																<option value="<?= $value_city['id']; ?>"><?= $value_city['name']." - ".$value_city['department_name']; ?></option>

																<?php
															}
														

													}


												 ?>
												 </optgroup>
											</select> </label>
										</div>
									</div>

									<div id="location_message<?= $n ?>"></div>

									<div class="row" id="location<?= $n ?>">
										<section class="col col-6">
											<label class="label"><strong>Departamento</strong></label>
											<label class="select">
											<select name="department<?= $n ?>" disabled required>
												<option value="" selected="" disabled="">Departamento</option>

												<?php 


													foreach ($datos['departments'] as $key => $value_dep) {
														
						

														if($value_dep['id'] == $value['department_id']) {
															?>

															<option value="<?= $value_dep['id']; ?>" selected><?= $value_dep['name']; ?></option>

															<?php
														}else {
															?>

															<option value="<?= $value_dep['id']; ?>"><?= $value_dep['name']; ?></option>

															<?php
														}
														

													}


												 ?>
											</select> <i></i> </label>
										</section>
										<section class="col col-6">
											<label class="label"><strong>País</strong></label>
											<label class="select">
											<select name="country<?= $n ?>" disabled required>
												<option value="" selected="" disabled="">País</option>

												<?php 


													foreach ($datos['countries'] as $key => $value_country) {
														
												
														if($value_country['id'] == $value['country_id']) {
															?>

															<option value="<?= $value_country['id']; ?>" selected><?= $value_country['name']; ?></option>

															<?php
														}else {
															?>

															<option value="<?= $value_country['id']; ?>"><?= $value_country['name']; ?></option>

															<?php
														}
														

													}


												 ?>
											</select> <i></i> </label>
										</section>
									</div>
								</fieldset>	
							</div>
												

							<footer>
								<button type="button" class="btn btn-primary" id="buttonEdit<?= $n ?>" onclick="javascript:actionButtons(<?= $n ?>,1)" data-toggle="modal" href="#modal-warning">
									Editar
								</button>
								<button type="button" onclick="validForm(<?= $n ?>)" class="btn btn-primary btn-address" id="buttonChanges<?= $n ?>">
									Guardar Cambios
								</button>
								<button type="button" class="btn btn-default btn-address" id="buttonCancel<?= $n ?>" onclick="javascript:actionButtons(<?= $n ?>,0)">
									Cancelar
								</button>
								<button type="button" class="btn btn-danger" id="buttonDeleted<?= $n ?>" data-toggle="modal" href="#modal-delete" onclick="javascript:set_modal(<?= $n ?>)">
									Eliminar
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
		
		<?php 
				}//End if
				else {
					?>
					<div id="content">
						<div id="message" class="alert alert-block alert-info">
							<h4 class="alert-heading"><i class="fa fa-info-circle"></i> No hay información para mostrar</h4>
							<p>
								No existen direcciones de envío registradas para este cliente
							</p>
						</div>
					</div>
					<?php
				}
		$n++ ?>
		<?php } //End foreach ?>


	</div>

	<!-- END ROW -->

</section>
<!-- end widget grid -->

			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->
 

		<!-- Modal-deleted -->
		<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close">
							&times;
						</button>
						<h4 class="modal-title">
							<span><i class="fa fa-trash"></i></span> <strong>¿Desea ELIMINAR este registro?</strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="address-delete-form" class="smart-form" action="javascript:delete_address()">
							<input type="hidden" name="address_delete" value="">
							<input type="hidden" name="address_delete_n" value="">
							<footer>
								<button type="submit" class="btn btn-danger">
									Eliminar
								</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Cancelar
								</button>

							</footer>
						</form>						
								

					</div>

				</div><!-- /.modal-deleted-content -->
			</div><!-- /.modal-deleted-dialog -->
		</div><!-- /.modal-deleted -->


		<!-- Modal -->
		<div class="modal fade" id="modal-new-address" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" id="close-modal-new-address" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">
							<span><i class="fa fa-ship"></i></span> Nueva Dirección de Envío <i>para</i> <strong class="text-uppercase"><?= $datos['client_addresses'][0]['tradename']; ?></strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="new-address-client-form" class="smart-form" action="javascript:new_address_client(<?= $datos['client_addresses'][0]['client_id']; ?>)">
									<fieldset>
										<section>
											<label class="label"><strong>Dirección</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-map"></i>
												<input type="text" name="address" placeholder="Dirección" required>
											</label>
										</section>
										<div class="row">
											<section class="col col-6">
												<label class="label"><strong>Código Postal</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-location-arrow"></i>
													<input type="text" name="zip" placeholder="Código Postal">
												</label>
											</section>
											<div class="col col-6">
												<label class="label"><strong>Ciudad</strong></label>
												<label class="input">
													<select name="city" style="width:100%;" class="select2" required="required">
														<optgroup>
															<option value="" selected="" disabled="">Ciudad</option>

															<?php 


																foreach ($datos['cities'] as $key => $value) {
																	
																	?>

																	<option value="<?= $value['id']; ?>"><?= $value['name']." - ".$value['department_name']; ?></option>

																	<?php

																}


															 ?>
														</optgroup>
													</select>
												</label>
											</div>
										</div>
										<section>
											<strong>Nota:</strong> La información del <strong>departamento</strong> y <strong>país</strong> son agregados automáticamente al guardar la ciudad correspondiente.
										</section>

									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewAddress" class="btn btn-primary">
											Registrar
										</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">
											Cancelar
										</button>

									</footer>
								</form>						
								

					</div>

				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- Modal-warning -->
		<div class="modal fade" id="modal-warning" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body no-padding">
						<div style="margin: 20px">
							<div id="message" class="alert alert-block alert-warning">
								<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Advertencia</h4>
								<p>
									Por la fidelidad del histórico de las transacciones, estos datos solo deben ser editados en caso de error. Si desea realizar un registro nuevo, por favor utilice la función correspondiente.
								</p>
							</div>
						</div>

						<form id="" class="smart-form" action="#">
							<footer>
								<button type="button" class="btn btn-warning" data-dismiss="modal">
									<i class="fa fa-exclamation-triangle"></i>
									Entendido
								</button>

							</footer>
						</form>						
								

					</div>

				</div><!-- /.modal-deleted-content -->
			</div><!-- /.modal-deleted-dialog -->
		</div><!-- /.modal-warning -->

		