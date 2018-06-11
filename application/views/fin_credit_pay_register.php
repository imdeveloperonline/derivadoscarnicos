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
						Ver/Editar
					</li>
				</ol>
				<!-- end breadcrumb -->

			</div>
			<!-- END RIBBON -->

			<!-- MAIN CONTENT -->
			<div id="content">

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h1 class="page-title txt-color-blueDark">
							<i class="fa fa-line-chart fa-fw"></i> 
								Finanzas 
							<span>>
								Créditos a proveedores
							</span>
							<span>>
								Transacción N° <?= $datos['credit_payments'][0]['advance_supplier_id'] ?>
							</span>
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Pago"></i></a>
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
									<h2 class="hidden-xs">Pagos</h2>
				
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
													<th data-class="expand">Fecha</th>
													<th data-hide="phone,tablet">Monto (COP)</th>
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['credit_payments'] as $key => $value) {

														if($value['id'] != "") {
															$date = date("Y-m-d",strtotime($value['date']));
														?>
																<tr id="tr_<?= $value['id'] ?>">
																	<td><?= $value['id']; ?></td>
																	<td><span id="date_<?= $value['id'] ?>"><?= $date; ?></span></td>
																	<td><span id="amount_<?= $value['id'] ?>"><?= $value['amount']; ?></span></td>
																	
																	<td>
																		&nbsp;
																			<a href="#modal-update" title="Editar" data-toggle="modal" onclick="set_modal('<?= $value["id"]?>','<?= $date ?>','<?= $value["amount"]?>')">
																				<i class="fa fa-lg fa-fw fa-pencil"></i>
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
									<span><i class="fa fa-book"></i></span> Registrar pago Transacción N° <?= $datos['credit_payments'][0]['advance_supplier_id']; ?>
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="pay-form" class="smart-form" action="javascript:new_pay()">
									<input type="hidden" name="advance_supplier_id" value="<?= $datos['credit_payments'][0]['advance_supplier_id']; ?>">
									
									<fieldset>
										
										<div class="row">
											<section class="col col-6">
												<label class="label"><strong>Fecha</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
													<input type="text" name="date" id="date" placeholder="Fecha" required>
												</label>
											</section>
											<section class="col col-6">
												<label class="label"><strong>Monto (COP)</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-dollar"></i>
													<input type="text" name="amount" placeholder="Monto (COP)" required amounts="true">
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
		<div class="modal fade" id="modal-update" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close-update">
							&times;
						</button>
						<h4 class="modal-title">
							<span><i class="fa fa-trash"></i></span> Editar registro
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="update-form" class="smart-form" action="javascript:update_pay()">
							<input type="hidden" name="pay_id" value="">

							<fieldset>
										
								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Fecha</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="pay_date" id="date-update" placeholder="Fecha" required>
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Monto (COP)</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-dollar"></i>
											<input type="text" name="pay_amount" placeholder="Monto (COP)" required amounts="true">
										</label>
									</section>
								</div>

								
							</fieldset>
							<footer>
								<button type="submit" class="btn btn-primary">
									Guardar cambios
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

		