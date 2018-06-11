<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						Finanzas
					</li>
					<li>
						Anticipo de Clientes
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
							<i class="fa fa-line-chart fa-fw "></i> 
								Finanzas 
							<span>>
								Anticipos de Clientes
							</span>
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Anticipo"></i></a>
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
									<h2 class="hidden-xs">Anticipos de Clientes</h2>
				
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
													<th data-hide="phone">Valor de Venta (COP)</th>
													<th data-hide="phone,tablet">Producto</th>
													<th data-hide="phone,tablet">Cantidad</th>
													<th data-hide="phone,tablet">Fecha</th>
													<th data-hide="phone,tablet">Producto por enviar</th>
													<th data-hide="phone,tablet">Deuda Cliente</th>
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['adv_clients'] as $key => $value) {

														$ci = &get_instance();
														$ci->load->model('Finanzas_model','finances');
														$query = $ci->finances->get_rest_advance_client($value['id']);
														$rest = $query->result_array();

														if($rest[0]['rest'] == 0){
															$pagado = '<i class="fa fa-check fa-lg text-success"></i>';
														} else {
															$pagado = "";
														}

														if($rest[0]['rest'] == NULL){
															$rest[0]['rest'] = $value['quantity'];
															$pagado = "";
														}

														$query_pays = $ci->finances->get_total_pay_adv_client($value['id']);

														$total_pays = $query_pays->result_array()[0]['total_pays'];
														$due = $value['total'] - $total_pays;

														?>
															<tr id="tr_<?= $value['id'] ?>">
																<td><?= $value['id']; ?></td>
																<td><?= $value['client_name']; ?></td>
																<td><?= $value['total']; ?></td>
																<td><?= $value['product_name']; ?></td>
																<td><?= $value['quantity']; ?></td>
																<td><?= strftime('%A %d-%m-%Y',strtotime($value['date'])); ?></td>
																<td><?= $rest[0]['rest'].' '.$pagado; ?></td>
																<td><?= $due ?></td>													
																<td>
																	&nbsp;
																	<a data-toggle="modal" href="#archive-modal" onclick="javascript:set_modal(<?= $value['id'] ?>)">
																		<i class="fa fa-folder-open fa-lg" title="Archivar"></i>
																	</a>
																	&nbsp; 
																	
																	&nbsp;
																	<a href="<?= base_url() . 'bodega/despachos_anticipo/' . $value['id']; ?>" title="Ver despachos">
																		<i class="fa fa-truck fa-lg"></i>
																	</a>
																	&nbsp;

																	&nbsp;
																	<a href="<?= base_url() . 'finanzas/pagos_clientes_transaccion/' . $value['id']; ?>" title="Ver/Registrar Pagos">
																		<i class="fa fa-bank fa-lg"></i>
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
									<span><i class="fa fa-line-chart"></i></span> Registrar Anticipo de	Cliente
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="adv-client-form" class="smart-form" action="javascript:new_adv_client()">
									<fieldset>
										<div class="row">
											<section class="col col-6">
												<label class="label"><strong>Cliente</strong></label>
												<label class="input">
													<select name="client" style="width: 100%" class="select2" required>
														<optgroup>
														<option value="" selected="" disabled="">Cliente</option>

														<?php 


															foreach ($datos['clients'] as $key => $value) {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['tradename']; ?></option>
																<?php
															}


														 ?>
														 </optgroup>
													</select> </label>
											</section>
											<section class="col col-6">
												<label class="label"><strong>Valor Total de Venta (COP)</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input type="text" name="total" placeholder="Valor Total de Venta (COP)" required  amounts="true">
												</label>
											</section>
										</div>

										<div class="row">
											<section class="col col-6">
												<label class="label"><strong>Producto</strong></label>
												<label class="input">
													<select name="product" style="width: 100%" class="select2" required>
														<option value="" selected="" disabled="">Producto</option>
														<optgroup>

														<?php 


															foreach ($datos['products'] as $key => $value) {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
																<?php
															}


														 ?>
														 </optgroup>
													</select> </label>
											</section>
											<section class="col col-6">
												<label class="label"><strong>Cantidad</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
													<input type="text" name="quantity" placeholder="Cantidad" required amounts="true">
												</label>
											</section>
										</div>
										<div class="row">
											<section class="col col-6">
												<label class="label"><strong>Monto Anticipo (COP)</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input type="text" name="amount" placeholder="Monto Anticipo (COP)"  required amounts="true">
												</label>
											</section>
											<section class="col col-6">
												<label class="label"><strong>Fecha</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
													<input type="text" name="date" id="date" placeholder="Fecha" required>
												</label>
											</section>
											<section class="col col-6">
												<label class="label"><strong>Precio unitario (COP)</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input type="text" name="unit_price" placeholder="Precio unitario (COP)" disabled required amounts="true">
												</label>
											</section>											
										</div>
										<section>
											<label class="label"><strong>Detalles</strong></label>
											<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						
												<textarea rows="5" name="details" placeholder="Detalles"></textarea> 
											</label>
										</section>										
										<div class="note">
											Los valores de monto y cantidad deben ser enteros o decimales de dos (2) dígitos separados por un punto (.)
										</div>
										
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewAdv" class="btn btn-primary">
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

				<!-- Modal ARCHIVAR -->
				<div class="modal fade" id="archive-modal" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" id="close-archived-modal" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">
									<span><i class="fa fa-folder-open"></i></span> ¿Está seguro que desea ARCHIVAR este registro?
								</h4>
								<div class="note">
									Podrá acceder a la información desde los registros archivados
								</div>
							</div>
							<div class="modal-body no-padding">

								<form id="archived-form" class="smart-form" action="javascript:archived()">
									<input type="hidden" name="archived_id" value="">					
									<footer>
										<button type="submit" id="buttonArchived" class="btn btn-primary">
											Archivar
										</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">
											Cancelar
										</button>

									</footer>
								</form>		
							</div>

						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal ARCHIVAR -->


			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		

		