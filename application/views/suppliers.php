<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						Proveedores
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
							<i class="fa fa-shopping-cart fa-fw "></i> 
								Proveedores 
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Nuevo Proveedor"></i></a>
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
									<h2>Proveedores Registrados</h2>
				
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
													<th data-hide="phone">Dpto - Ciudad</th>
													<th data-hide="phone,tablet">Teléfono</th>
													<th data-hide="phone,tablet">E-mail</th>
													<th data-hide="phone,tablet">Frigoríficos</th>
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['suppliers'] as $key => $value) {

														if($value['id'] != "") {

															$ci = &get_instance();
															$ci->load->model('Proveedores_model','suppliers');
															$query = $ci->suppliers->get_shambles_supplier($value['id']);
															
															$shambles = "<ol>";
															$n = 1;
															foreach ($query->result_array() as $k => $v) {
																if($n == 1) {

																	$shambles .= '<li><a href="'. base_url() .'frigorificos/detalle/'.$v['shamble_id'].'" title="Detalles Frigorífico">'. $v['shamble_name'].'</a></li>';
																} else {
																	$shambles .= '<li><a href="'. base_url() .'frigorificos/detalle/'.$v['shamble_id'].'" title="Detalles Frigorífico">'. $v['shamble_name'].'</a></li>';
																}
																$n++;
															}
															$shambles .= "</ol>";

														?>
															<tr id="tr_<?= $value['id'] ?>">
																<td><?= $value['id']; ?></td>
																<td><?= $value['supplier_name']; ?></td>
																<td><?= $value['department_name'] ." - ".$value['city_name']; ?></td>
																<td><?= $value['phone']; ?></td>
																<td><?= $value['email']; ?></td>
																<td><?= $shambles ?></td>													
																<td>
																	&nbsp;
																	<a href="<?= base_url() . 'proveedores/detalle/' . $value['id']; ?>">
																		<i class="fa fa-eye fa-lg" title="Detalles"></i>
																	</a>
																	&nbsp; 
																	
																	&nbsp;
																	<a href="<?= base_url() . 'proveedores/editar/' . $value['id']; ?>" title="Editar Proveedor">
																		<i class="fa fa-pencil fa-lg"></i>
																	</a>
																	&nbsp;

																	&nbsp;
																	<a href="<?= base_url() . 'proveedores/contactos/' . $value['id']; ?>" title="Personas de Contacto">
																		<i class="fa fa-user fa-lg"></i>
																	</a>
																	&nbsp;

																	&nbsp;
																	<a href="<?= base_url() . 'proveedores/medios_de_pago/' . $value['id']; ?>" title="Medios de pago">
																		<i class="fa fa-credit-card-alt fa-lg"></i>
																	</a>
																	&nbsp;

																	&nbsp;
																	<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Eliminar Proveedor" onclick="javascript:set_modal(<?= $value['id'] ?>)">
																		<i class="fa fa-trash fa-lg"></i>
																	</a>
																	&nbsp;

																</td>
															</tr>
														<?php
														}

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
									<span><i class="fa fa-shopping-cart"></i></span> Nuevo Proveedor
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="new-supplier-form" class="smart-form" action="javascript:new_supplier()">
									<fieldset>
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-user"></i>
													<input type="text" name="tradename" placeholder="Nombre" required>
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-file-text"></i>
													<input type="text" name="rut" placeholder="Rut">
												</label>
											</section>
										</div>

										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-phone"></i>
													<input type="tel" name="phone" placeholder="Teléfono">
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
													<input type="email" name="email" placeholder="E-mail">
												</label>
											</section>
										</div>
										<section>
											<label class="input"> <i class="icon-prepend fa fa-map"></i>
												<input type="text" name="address" placeholder="Dirección">
											</label>
										</section>
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-map-marker"></i>
													<input type="text" name="zip" placeholder="Código postal">
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
										<div class="row">
											<section class="col col-6">
												<label class="input form-group">
													<select name="shamble" id="shamble" multiple style="width: 100%" class="select2" required>
														<optgroup>
														<?php 

														if (empty($datos['shambles']) ){
															?>

															<option value="" selected="" disabled="">No existen frigoríficos registrados</option>

															<?php

														} else {

															foreach ($datos['shambles'] as $key => $value) {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['tradename']; ?></option> 

																<?php
															}

														}

														 ?>
														 </optgroup>
													</select> </label>
											</section>
										</div>	
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input type="text" name="precio_unitario" placeholder="Precio Unitario" amounts="true">
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
													<input type="text" name="month_quantity" placeholder="Cantidad Mensual" amounts="true">
												</label>
											</section>
										</div>
									</fieldset>

									<header><strong>Medio de Pago Principal</strong></header>
									<fieldset>
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-user"></i>
													<input type="text" name="name_method" placeholder="Nombre completo">
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-file-text"></i>
													<input type="text" name="rut_method" placeholder="CC / NIT">
												</label>	
											</section>
										</div>
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-bank"></i>
													<input type="text" name="bankcenter_method" placeholder="Banco / Centro de Pago">
												</label>
											</section>
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-calculator"></i>
													<input type="text" name="account_method" placeholder="Número de cuenta">
												</label>
											</section>
										</div>
										
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewSupplier" class="btn btn-primary">
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
							<span><i class="fa fa-trash"></i></span> <strong>¿Desea ELIMINAR este proveedor?</strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="supplier-delete-form" class="smart-form" action="javascript:delete_supplier()">
							<input type="hidden" name="supplier_delete" value="">
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

		