
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				<a href="<?= base_url() ?>proveedores">Proveedores</a>
			</li>
			<li>
				Medios de pago
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
					<a href="<?= base_url() ?>proveedores">Proveedores</a>
				<span>>  
					Medios de pago
				</span>
				<span>>  
					<strong class="text-uppercase"><?= $datos['supplier'][0]['supplier_name']; ?></strong>
				</span>
				
			</h1>
		</div>	
	</div>

<div id="resultado-1"></div>

<!-- widget grid -->
<section id="widget-grid" class="">

	<header style="font-size: 16px; margin-bottom: 10px">
		<i class="fa fa-bank"></i>
		<strong>CUENTAS DE BANCO</strong>
		<span>
			<a href="#modal-bank" data-toggle="modal"><i class="fa fa-plus-circle"></i></a>
		</span>
	</header>

	<!-- START ROW -->

	<div class="row">

		<?php $n = 1; ?>
		<?php 


		if(!empty($datos['banks'])){

		foreach ($datos['banks'] as $key => $value) { 			

			?>

		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-6" id="article-<?= $n ?>">
			
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

						<form id="update-form<?= $n ?>" class="smart-form registry-form" novalidate="novalidate" action="javascript:update(<?= $n ?>,1)">
							<input type="hidden" name="id<?= $n ?>" value="<?= $value['id'] ?>">
							<input type="hidden" name="type_registry<?= $n ?>" value="1">
							<header>
								<span><i class="fa fa-bank"></i></span> <strong>Cuenta de Banco</strong>
							</header>
							
							<div id="bank_supplier">
								<fieldset>
									<section>
										<label class="label"><strong>Nombre o razón social</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="name<?= $n ?>" placeholder="Nombre o razón social" value="<?= $value['name']; ?>" disabled required>
										</label>
									</section>
									<div class="row">
										<section class="col col-6">
											<label class="label"><strong>Cédula o NIT</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-file-text"></i>
												<input type="text" name="rut<?= $n ?>" placeholder="Cédula o NIT" value="<?= $value['rut']; ?>" disabled>
											</label>
										</section>
										<section class="col col-6">
											<label class="label"><strong>Tipo de Cuenta</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-bars"></i>
												<input type="text" name="type_account<?= $n ?>" placeholder="Tipo de Cuenta" value="<?= $value['type_account']; ?>" disabled>
											</label>
										</section>
									</div>
									<section>
										<label class="label"><strong>Banco</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-bank"></i>
											<input type="text" name="bank<?= $n ?>" placeholder="Banco" value="<?= $value['bank']; ?>" disabled required>
										</label>
									</section>
									<section>
										<label class="label"><strong>Número de Cuenta</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calculator"></i>
											<input type="text" name="account<?= $n ?>" placeholder="Número de Cuenta" value="<?= $value['account']; ?>" disabled required>
										</label>
									</section>
								</fieldset>	
							</div>
												

							<footer>
								<button type="button" class="btn btn-primary" id="buttonEdit<?= $n ?>" onclick="javascript:actionButtons(<?= $n ?>,1)" data-toggle="modal" href="#modal-warning">
									Editar
								</button>
								<button type="button" onclick="validForm(<?= $n ?>)" class="btn btn-primary btn-person" id="buttonChanges<?= $n ?>">
									Guardar Cambios
								</button>
								<button type="button" class="btn btn-default btn-person" id="buttonCancel<?= $n ?>" onclick="javascript:actionButtons(<?= $n ?>,0)">
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
			$n++;
				} //End foreach
			}//End if
				else {
					?>
					<div id="content">
						<div id="message-info" class="alert alert-block alert-info">
							<h4 class="alert-heading"><i class="fa fa-info-circle"></i> No hay información para mostrar</h4>
							<p>
								No existen cuentas de banco registradas para este proveedor
							</p>
						</div>
					</div>
					
		<?php } //End ifelse ?>


	</div>

	<!-- END ROW -->
	<div id="resultado-2"></div>

	<header style="font-size: 16px; margin-bottom: 10px">
		<i class="fa fa-money"></i>
		<strong>CENTROS DE PAGO</strong>
		<span>
			<a href="#modal-center" data-toggle="modal"><i class="fa fa-plus-circle"></i></a>
		</span>
	</header>


	<!-- START ROW -->

	<div class="row">

		<?php 


		if(!empty($datos['centers'])){

		foreach ($datos['centers'] as $key => $value) { 

			

			?>

		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-6" id="article-<?= $n ?>">
			
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

						<form id="update-form<?= $n ?>" class="smart-form registry-form" novalidate="novalidate" action="javascript:update(<?= $n ?>,2)">
							<input type="hidden" name="id<?= $n ?>" value="<?= $value['id'] ?>">
							<input type="hidden" name="type_registry<?= $n ?>" value="2">
							<header>
								<span><i class="fa fa-money"></i></span> <strong>Centro de pago</strong>
							</header>
							
							<div id="center_supplier">
								<fieldset>
									<section>
										<label class="label"><strong>Nombre completo</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="name<?= $n ?>" placeholder="Nombre completo" value="<?= $value['name']; ?>" disabled required>
										</label>
									</section>
									<div class="row">										
										<section class="col col-6">
											<label class="label"><strong>Cédula o NIT</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-file-text"></i>
												<input type="text" name="rut<?= $n ?>" placeholder="Cédula o NIT" value="<?= $value['rut']; ?>" disabled required>
											</label>
										</section>
										<section class="col col-6">
											<label class="label"><strong>Compañia de Pago</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-phone"></i>
												<input type="text" name="center<?= $n ?>" placeholder="Compañia de Pago" value="<?= $value['center']; ?>" disabled required>
											</label>
										</section>
									</div>

									<div class="row">
										<section class="col col-6">
											<label class="label"><strong>Lugar de recepción</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
												<input type="text" name="location<?= $n ?>" placeholder="Lugar de recepción" value="<?= $value['location']; ?>" disabled>
											</label>
										</section>
									</div>
								</fieldset>	
							</div>
												

							<footer>
								<button type="button" class="btn btn-primary" id="buttonEdit<?= $n ?>" onclick="javascript:actionButtons(<?= $n ?>,1)" data-toggle="modal" href="#modal-warning">
									Editar
								</button>
								<button type="button" onclick="validForm(<?= $n ?>)" class="btn btn-primary btn-person" id="buttonChanges<?= $n ?>">
									Guardar Cambios
								</button>
								<button type="button" class="btn btn-default btn-person" id="buttonCancel<?= $n ?>" onclick="javascript:actionButtons(<?= $n ?>,0)">
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
				$n++;
				} //End foreach
			}//End if
				else {
					?>
					<div id="content">
						<div id="message-info" class="alert alert-block alert-info">
							<h4 class="alert-heading"><i class="fa fa-info-circle"></i> No hay información para mostrar</h4>
							<p>
								No existen centros de pago registradas para este proveedor
							</p>
						</div>
					</div>
					
		<?php } //End ifelse ?>


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

						<form id="delete-form" class="smart-form" action="javascript:delete_registry()">
							<input type="hidden" name="registry_delete" value="">
							<input type="hidden" name="registry_delete_n" value="">
							<input type="hidden" name="type_registry" value="">
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
		<div class="modal fade" id="modal-bank" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" id="close-modal-bank" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">
							<span><i class="fa fa-credit-card"></i></span> Nueva Cuenta de Banco <i>para</i> <strong class="text-uppercase"><?= $datos['supplier'][0]['supplier_name']; ?></strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="new-bank-form" class="smart-form" action="javascript:new_bank(<?= $datos['supplier'][0]['id']; ?>)">
									<fieldset>
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-user"></i>
													<input type="text" name="name" placeholder="Nombre o razón social" required>
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-file-text"></i>
													<input type="text" name="rut" placeholder="Cédula o NIT">
												</label>
											</section>
										</div>

										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-bank"></i>
													<input type="text" name="bank" placeholder="Banco" required>
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-calculator"></i>
													<input type="text" name="account" placeholder="Número de cuenta" required>
												</label>
											</section>
										</div>

										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-bars"></i>
													<input type="text" name="type_account" placeholder="Tipo de cuenta" required>
												</label>
											</section>											
										</div>
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewBank" class="btn btn-primary">
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

		<!-- Modal -->
		<div class="modal fade" id="modal-center" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" id="close-modal-center" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">
							<span><i class="fa fa-money"></i></span> Nuevo Centro de Pago <i>para</i> <strong class="text-uppercase"><?= $datos['supplier'][0]['supplier_name']; ?></strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="new-center-form" class="smart-form" action="javascript:new_center(<?= $datos['supplier'][0]['id']; ?>)">
									<fieldset>
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-user"></i>
													<input type="text" name="center_name" placeholder="Nombre completo" required>
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-file-text"></i>
													<input type="text" name="center_rut" placeholder="Cédula o NIT" required>
												</label>
											</section>
										</div>

										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input type="text" name="center" placeholder="Compañia de Pago" required>
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-map-marker"></i>
													<input type="text" name="location" placeholder="Lugar de recepción" >
												</label>
											</section>
										</div>
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewCenter" class="btn btn-primary">
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

		