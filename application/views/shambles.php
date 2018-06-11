<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						Frigoríficos
					</li>
					<li>
						Ver/Editar
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
							<i class="fa fa-industry fa-fw "></i> 
								Frigoríficos 
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Nuevo Frigorífico"></i></a>
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
									<h2>Frigoríficos Registrados</h2>
				
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
													<th data-class="expand">Nombre Comercial</th>
													<th data-hide="phone">Dpto - Ciudad</th>
													<th data-hide="phone,tablet">Teléfono</th>
													<th data-hide="phone,tablet">E-mail</th>
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['shambles'] as $key => $value) {

														?>
															<tr id="tr_<?= $value['id'] ?>">
																<td><?= $value['id']; ?></td>
																<td><?= $value['tradename']; ?></td>
																<td><?= $value['department_name'] . " - " . $value['city_name']; ?></td>
																<td><?= $value['phone']; ?></td>
																<td><?= $value['email']; ?></td>												
																<td>
																	&nbsp;
																	<a href="<?= base_url() . 'frigorificos/detalle/' . $value['id']; ?>">
																		<i class="fa fa-eye fa-lg" title="Detalles"></i>
																	</a>
																	&nbsp; 
																	
																	&nbsp;
																	<a href="<?= base_url() . 'frigorificos/editar/' . $value['id']; ?>" title="Editar Frigorífico">
																		<i class="fa fa-pencil fa-lg"></i>
																	</a>
																	&nbsp;

																	&nbsp;
																	<a href="<?= base_url() . 'frigorificos/contactos/' . $value['id']; ?>" title="Personas de Contacto">
																		<i class="fa fa-user fa-lg"></i>
																	</a>
																	&nbsp;

																	&nbsp;
																	<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Eliminar Frigorífico" onclick="javascript:set_modal(<?= $value['id'] ?>)">
																		<i class="fa fa-trash fa-lg"></i>
																	</a>
																	&nbsp;

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
									<span><i class="fa fa-industry"></i></span> Nuevo Frigorífico
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="new-shamble-form" class="smart-form" action="javascript:new_shamble()">
									<fieldset>
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-industry"></i>
													<input type="text" name="tradename" placeholder="Nombre" required>
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-file-text"></i>
													<input type="text" name="rut" placeholder="Rut" >
												</label>
											</section>
										</div>

										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-phone"></i>
													<input type="tel" name="phone" placeholder="Teléfono" >
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
													<input type="email" name="email" placeholder="E-mail" >
												</label>
											</section>
										</div>
										<section>
											<label class="input"> <i class="icon-prepend fa fa-map"></i>
												<input type="text" name="address" placeholder="Dirección" >
											</label>
										</section>
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-map-marker"></i>
													<input type="text" name="zip" placeholder="Código postal" >
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<select name="city" style="width: 100%" class="select2" required>
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
													</select> </label>
											</section>
										</div>
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewShamble" class="btn btn-primary">
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
							<span><i class="fa fa-trash"></i></span> <strong>¿Desea ELIMINAR este frigorífico?</strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="supplier-delete-form" class="smart-form" action="javascript:delete_shamble()">
							<input type="hidden" name="shamble_delete" value="">
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

		