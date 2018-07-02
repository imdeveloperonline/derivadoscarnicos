
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
				Personas de Contacto
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
					Personas de Contacto
				</span>
				<span>>  
					<strong class="text-uppercase"><?= $datos[0]['client_name']; ?></strong>
				</span>
				<span>
					<a href="#modal-new-person" data-toggle="modal"><i class="fa fa-plus-circle"></i></a>
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
		<?php foreach ($datos as $key => $value) { 

			if($value['person_id'] != NULL) {

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

						<form id="new-person-client-form<?= $n ?>" class="smart-form person-form" novalidate="novalidate" action="javascript:update_person(<?= $n ?>)">
							<input type="hidden" name="person_id<?= $n ?>" value="<?= $value['person_id'] ?>">
							<header>
								<span><i class="fa fa-user"></i></span> <strong>Persona de Contacto</strong>
							</header>
							
							<div id="person_client">
								<fieldset>
									<div class="row">
										<section class="col col-6">
											<label class="label"><strong>Nombre</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-user"></i>
												<input type="text" name="person_name<?= $n ?>" placeholder="Nombre" value="<?= $value['person_name']; ?>" disabled required>
											</label>
										</section>
										<section class="col col-6">
											<label class="label"><strong>Apellido</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-user"></i>
												<input type="text" name="person_lastname<?= $n ?>" placeholder="Apellido" value="<?= $value['person_lastname']; ?>" disabled>
											</label>
										</section>
									</div>

									<div class="row">
										<section class="col col-6">
											<label class="label"><strong>Teléfono</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-phone"></i>
												<input type="tel" name="person_phone<?= $n ?>" placeholder="Teléfono" value="<?= $value['person_phone']; ?>" disabled>
											</label>
										</section>
										<section class="col col-6">
											<label class="label"><strong>E-mail</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
												<input type="email" name="person_email<?= $n ?>" placeholder="E-mail" value="<?= $value['person_email']; ?>" disabled>
											</label>
										</section>
									</div>

									<div class="row">
										<section class="col col-6">
											<label class="label"><strong>Cargo</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-briefcase"></i>
												<input type="text" name="person_position<?= $n ?>" placeholder="Cargo" value="<?= $value['person_position']; ?>" disabled>
											</label>
										</section>
									</div>
								</fieldset>	
							</div>
												

							<footer>
								<button type="button" class="btn btn-primary" id="buttonEdit<?= $n ?>" onclick="javascript:actionButtons(<?= $n ?>,1)">
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
				}//End if
				else {
					?>
					<div id="content">
						<div id="message" class="alert alert-block alert-info">
							<h4 class="alert-heading"><i class="fa fa-info-circle"></i> No hay información para mostrar</h4>
							<p>
								No existen personas de contacto registradas para este cliente
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

						<form id="person-delete-form" class="smart-form" action="javascript:delete_person()">
							<input type="hidden" name="person_delete" value="">
							<input type="hidden" name="person_delete_n" value="">
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
		<div class="modal fade" id="modal-new-person" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" id="close-modal-new-person" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">
							<span><i class="fa fa-user"></i></span> Nueva Persona de Contacto <i>para</i> <strong class="text-uppercase"><?= $datos[0]['client_name']; ?></strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="new-person-client-form" class="smart-form" action="javascript:new_person_client(<?= $datos[0]['client_id']; ?>)">
									<fieldset>
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-user"></i>
													<input type="text" name="person_name" placeholder="Nombre" required>
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-user"></i>
													<input type="text" name="person_lastname" placeholder="Apellido">
												</label>
											</section>
										</div>

										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-phone"></i>
													<input type="tel" name="person_phone" placeholder="Teléfono">
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
													<input type="email" name="person_email" placeholder="E-mail">
												</label>
											</section>
										</div>

										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-briefcase"></i>
													<input type="text" name="person_position" placeholder="Cargo">
												</label>
											</section>											
										</div>
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewPerson" class="btn btn-primary">
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

		