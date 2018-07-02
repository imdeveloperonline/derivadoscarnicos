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
						Despachos a Clientes
					</li>
				</ol>
				<!-- end breadcrumb -->

			</div>
			<!-- END RIBBON -->

			<!-- MAIN CONTENT -->
			<div id="content">

				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
						<h1 class="page-title txt-color-blueDark">
							<i class="fa fa-truck fa-fw "></i> 
								Despachos a Clientes 
							<span>>
								<?= $datos['advance_dispatches'][0]['client_name'] ?> (Anticipo N° <?= $datos['advance_dispatches'][0]['advance_client_id'] ?>)
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
									<h2 class="hidden-xs">Despachos (<?= $datos['advance_dispatches'][0]['client_name'] ?>)</h2>
				
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
													<th data-class="expand">Cliente</th>
													<th data-hide="phone,tablet">Anticipo N°</th>
													<th data-hide="phone,tablet">Producto</th>
													<th data-hide="phone,tablet">Cantidad</th>
													<th data-hide="phone,tablet">Fecha</th>
													<th data-hide="phone,tablet">Producto por enviar</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['advance_dispatches'] as $key => $value) {

														if($value['id'] != NULL) {

															$ci = &get_instance();
															$ci->load->model('Bodega_model', 'storage');
															$query = $ci->storage->rest_on_this_disátch_client($value['id'],$value['advance_client_id']);

															$rest = $value['advance_quantity'] - $value['dispatch_quantity'] - $query->result_array()[0]['rest'];
															$rest = number_format($rest, 2, '.', ' ');

															if($rest == 0){
																$pagado = '<i class="fa fa-check fa-lg text-success"></i>';
															} else {
																$pagado = "";
															}

															?>
																<tr id="tr_<?= $value['id'] ?>">
																	<td><?= $value['id']; ?></td>
																	<td><?= $value['client_name']; ?></td>
																	<td><?= $value['advance_client_id']; ?></td>
																	<td><?= $value['product_name']; ?></td>
																	<td><?= $value['dispatch_quantity']; ?></td>
																	<td><?= strftime('%A %d-%m-%Y',strtotime($value['dispatch_date'])); ?></td>

																	<td><?= $rest.' '.$pagado; ?></td>												
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
									<span><i class="fa fa-truck"></i></span> Nuevo despacho
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="dispatches-client-form" class="smart-form" action="javascript:new_dispatch_client()">
									<fieldset>
										<div class="row">
											<section class="col col-6">
												<label class="label"><strong>Anticipo Correspondiente</strong></label>
												<label class="input">
													<select name="advance_client_id" style="width: 100%" class="select2" required>
														<optgroup>
														<option value="" selected="" disabled="">Anticipo Correspondiente</option>

														<?php 


															foreach ($datos['client_advances'] as $key => $value) {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['client_name'].' | Cantidad: '.$value['quantity'].' | Fecha: '.date('d-m-Y',strtotime($value['date'])); ?></option>
																<?php
															}


														 ?>
														 </optgroup>
													</select> </label>
											</section>

											<section class="col col-6">
												<label class="label"><strong>Producto por enviar</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-window-minimize"></i>
													<input type="text" name="rest" placeholder="Producto por enviar"  required rest="true" readonly="">
												</label>
												<div class="note">
													Este campo es llenado autmáticamente y no puede ser menor a cero (0)
												</div>
											</section>
											
										</div>

										<div class="row">
											<section class="col col-6">
												<label class="label"><strong>Cantidad</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
													<input type="text" name="quantity" placeholder="Cantidad" required amounts="true">
												</label>
											</section>
											<section class="col col-6">
												<label class="label"><strong>Fecha</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
													<input type="text" name="date" id="date" placeholder="Fecha" required>
												</label>
											</section>
										</div>

										<section>
											<label class="label"><strong>Dirección de envio</strong></label>
											<label class="select">
												<select name="send_address_id" required>
													<option value="" selected="" disabled="">Dirección de envio</option>
												</select> <i></i> </label>
										</section>	
										
										<section>
											<label class="label"><strong>Nota</strong></label>
											<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						
												<textarea rows="5" name="note" placeholder="Nota"></textarea> 
											</label>
										</section>										
										<div class="note">
											El valor de <i>CANTIDAD</i> debe ser entero o decimal de dos (2) dígitos separados por un punto (.)
										</div>
										
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewDis" class="btn btn-primary">
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


		