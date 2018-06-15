<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						Bodega
					</li>
					<li>
						Recepciones
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
							<i class="fa fa-archive fa-fw "></i> 
								Bodega 
							<span>>
								Recepciones
							</span>
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Recepción"></i></a>
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
									<h2 class="hidden-xs">Recepciones</h2>
				
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
													<th data-class="expand">Proveedor</th>
													<th data-hide="phone,tablet">Fecha</th>
													<th data-hide="phone,tablet">Tipo Trans.</th>
													<th data-hide="phone,tablet">Producto</th>
													<th data-hide="phone,tablet">Cantidad</th>
													<th data-hide="phone,tablet">Valor</th>
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['receptions'] as $key => $value) {

														$ci = &get_instance();
														$ci->load->model('Bodega_model', 'storage');

														/*$query = $ci->storage->rest_on_this_reception($value['id'],$value['advance_supplier_id']);

														$rest = $value['advance_quantity'] - $value['reception_quantity'] - $query->result_array()[0]['rest'];
														$rest = number_format($rest, 2, '.', ' ');

														if($rest == 0){
															$complete = '<i class="fa fa-check fa-lg text-success"></i>';
														} else {
															$complete = "";
														}*/

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
									<span><i class="fa fa-truck"></i></span> Nueva recepción
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="reception-form" class="smart-form" action="javascript:new_reception()">
									<div id="form-alert"></div>
									<fieldset>
										<div class="row">
											<div class="col col-6">
												<label class="label"><strong>Proveedor</strong></label>
												<label class="input">
													<select name="supplier" style="width:100%;" class="select2" id="supplier" required="required" data-placeholder="Seleccione un proveedor">
														<option></option>		
														<optgroup>
															<?php 
																foreach ($datos['suppliers'] as $key => $value) {
																	?>
																		<option value="<?= $value['id']; ?>"><?= $value['supplier_name']; ?></option>
																	<?php
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


															foreach ($datos['methods'] as $key => $value) {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
																<?php
															}


														 ?>
													</select> <i></i> </label>
											</section>
											
										</div>
										<div class="row unit_price" style="display: none;">
											<section class="col col-6">
												<label class="label"><strong>Precio Unitario</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-dollar"></i>
													<input type="text" name="unit_price" placeholder="Precio Unitario"  required readonly="">
												</label>
												<div class="note">
													Este campo es llenado automáticamente con la información del proveedor
												</div>
											</section>

											<section class="col col-6 advance" style="display: none">
												<label class="label"><strong>Saldo proveedor</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-window-minimize"></i>
													<input type="text" name="adv_balance" placeholder="Saldo proveedor"  required rest="true" readonly="" disabled="">
												</label>
												<div class="note">
													Este campo es llenado automáticamente y no puede ser menor a cero (0)
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

										<div class="row advance" style="display: none">
											<section class="col col-6">
												<label class="label"><strong>Producto</strong></label>
												<label class="input">
													<select name="product_advance" style="width: 100%" class="select2" required disabled="" data-placeholder="Seleccione un producto">
														<option></option>
														
														<?php 


															foreach ($datos['products'] as $key => $value) {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
																<?php
															}


														 ?>
													</select> </label>
											</section>
										</div>

										<div class="row credit" style="display: none">
											<section class="col col-6">
												<label class="label"><strong>Producto</strong></label>
												<label class="input">
													<select name="product" style="width: 100%" class="select2" required disabled="" data-placeholder="Seleccione un producto">
														<option></option>
														
														<?php 


															foreach ($datos['products'] as $key => $value) {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
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

										<div class="row shamble" style="display: none">
											<section class="col col-6">
												<label class="label"><strong>Frigorífico</strong></label>
												<label class="select">
													<select name="shamble" required>
														<option value="" disabled="" selected="">Seleccione un frigorífico</option>
														
													</select> <i></i></label>
											</section>
											<section class="col col-6">
												<label class="label"><strong>Gasto Frigorífico</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-dollar"></i>
													<input type="text" name="shamble_amount" placeholder="Gasto Frigorífico" >
												</label>
											</section>
										</div>

										<section>
											<label class="label"><strong>Marcas</strong></label>
											<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						 
												<textarea rows="5" name="brand" placeholder="Marcas"></textarea> 
											</label>
										<div class="note">
											<strong>Formato:</strong> Cantidad + Espacio + Marca. <strong>Ej:</strong> 10 M5.<br> Para insertar varios registros, separelos con un salto de línea utilizando la tecla ENTER.
										</div>
										</section>
										
										
										<section>
											<label class="label"><strong>Nota</strong></label>
											<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						 
												<textarea rows="5" name="note" placeholder="Nota"></textarea> 
											</label>																		
										<div class="note">
											El valor de <i>CANTIDAD</i> debe ser entero o decimal de dos (2) dígitos separados por un punto (.)
										</div>
										</section>	
										
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewRec" class="btn btn-primary">
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
				<div class="modal fade" id="noteModal" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">
									<span><i class="fa fa-comment"></i></span> Nota
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form class="smart-form" >
									<fieldset>
										
										
										<section>
											<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						 
												<textarea rows="5" name="note_message" id="note_message" placeholder="Nota" readonly=""></textarea> 
											</label>
										</section>	
										
									</fieldset>
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
							<span><i class="fa fa-trash"></i></span> <strong>¿Desea ELIMINAR esta recepción?</strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="delete-form" class="smart-form" action="javascript:delete_reception()">
							<input type="hidden" name="reception_delete" value="">
							<input type="hidden" name="reception_method" value="">
							<input type="hidden" name="reception_advance" value="">
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

		