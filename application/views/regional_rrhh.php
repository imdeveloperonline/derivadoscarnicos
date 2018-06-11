<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						Regional
					</li>
					<li>
						Recursos Humanos
					</li>
				</ol>
				<!-- end breadcrumb -->

			</div>
			<!-- END RIBBON -->

			<!-- MAIN CONTENT -->
			<div id="content">

				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title txt-color-blueDark">
							<i class="fa fa-building fa-fw"></i>
								Regional 
							<span>>
								Recursos humanos
							</span>
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Nuevo Empleado"></i></a>
							</span>
						</h1>
					</div>
					
				</div>
				<div id="resultado"></div>

				<!-- widget grid -->
				<section id="widget-grid" class="">
				
					<!-- row -->
					<div class="row">
				
						<!-- NEW WIDGET START -->
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false" data-widget-deletebutton="false">
								<header>
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2>Empleados</h2>
				
								</header>
				
								<!-- widget div-->
								<div>
				
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->
				
									</div>
									<!-- end widget edit box -->
				
									<!-- widget content -->
									<div class="widget-body no-padding">
										<table id="datatable_tabletools" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<th data-hide="phone">ID</th>
													<th data-class="expand">Nombre</th>
													<th data-hide="phone">Cédula</th>
													<th data-hide="phone,tablet">Teléfono</th>
													<th data-hide="phone,tablet">E-mail</th>				
													<th data-hide="phone,tablet">Regional</th>
													<th data-hide="phone,tablet">Activo</th>
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['employees'] as $key => $value) {

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

													}											


												?>					
																								
											</tbody>
										</table>
				
									</div>
									<!-- end widget content -->
				
								</div>
								<!-- end widget div -->
				
							</div>
							<!-- end widget -->
				
						</article>
						<!-- WIDGET END -->
				
					</div>
				
					<!-- end row -->
				
				</section>
				<!-- end widget grid -->


				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" id="close" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">
									<span><i class="fa fa-briefcase"></i></span> Nuevo Empleado
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="new-employee-form" class="smart-form" action="javascript:new_employee()">
											<fieldset>
												<div class="row">
													<section class="col col-6">
														<label class="input"> <i class="icon-prepend fa fa-user"></i>
															<input type="text" name="name" placeholder="Nombre" required>
														</label>
													</section>
													<section class="col col-6">
														<label class="input"> <i class="icon-prepend fa fa-user"></i>
															<input type="text" name="lastname" placeholder="Apellido" required>
														</label>
													</section>
												</div>

												<div class="row">
													<section class="col col-6">
														<label class="input"> <i class="icon-prepend fa fa-phone"></i>
															<input type="tel" name="phone" placeholder="Teléfono" required>
														</label>
													</section>
													<section class="col col-6">
														<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
															<input type="email" name="email" placeholder="E-mail" required>
														</label>
													</section>
												</div>

												<div class="row">
													<section class="col col-6">
														<label class="input"> <i class="icon-prepend fa fa-address-book"></i>
															<input type="text" name="dni" placeholder="Cédula" required>
														</label>
													</section>
												</div>
											</fieldset>
											
											<footer>
												<button type="submit" id="button" class="btn btn-primary">
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


			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		<!-- Modal-deleted -->
		<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close-delete">
							&times;
						</button>
						<h4 class="modal-title">
							<span><i class="fa fa-trash"></i></span> <strong>¿Desea ELIMINAR este empleado?</strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="employee-delete-form" class="smart-form" action="javascript:delete_employee()">
							<input type="hidden" name="employee_delete" value="">
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

		