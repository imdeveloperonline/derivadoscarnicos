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
					<li>
						Empleado
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
							<i class="fa fa-building fa-fw"></i>
								Regional 
							<span>>
								Recursos humanos
							</span>
							<span>>
								<?= $datos['employee'][0]['name']. " " . $datos['employee'][0]['lastname'] ?>
							</span>
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Nuevo Periodo"></i></a>
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
									<h2 class="hidden-xs"><?= $datos['employee'][0]['name']. " " . $datos['employee'][0]['lastname'] ?></h2>
				
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
													<th data-class="expand">Cargo</th>
													<th data-hide="phone">Fecha de Ingreso</th>
													<th data-hide="phone,tablet">Fecha de Egreso</th>
													<th data-hide="phone,tablet">Salario (COP)</th>	
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['periods'] as $key => $value) {

														if(date("Y",strtotime($value['date_end'])) == "-0001"){
															$date_end = "En curso";
														} else {
															$date_end = strftime('%A %d-%m-%Y',strtotime($value['date_end']));
														}
														?>
															<tr id="tr_<?= $value['id'] ?>">
																<td><?= $value['id']; ?></td>
																<td><?= $value['position']; ?></td>
																<td><?= strftime('%A %d-%m-%Y',strtotime($value['date_start'])); ?></td>
																<td><span id="date_end_<?= $value['id'] ?>"><?= $date_end; ?></span></td>
																<td><?= $value['salary']; ?></td>
																<?php if($date_end == "En curso") { ?>
																<td>													
																	&nbsp;
																	<span id="calendar_button_<?= $value['id'] ?>">
																	<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Registrar Egreso" onclick="javascript:set_modal(<?= $value['id'] ?>)">
																		<i class="fa fa-calendar fa-lg"></i>
																	</a>
																	</span>
																	&nbsp;

																</td>
																<?php } else { ?>
																<td>
																	Finalizado
																</td>
																<?php } ?>
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
									<span><i class="fa fa-briefcase"></i></span> Alta <i>para</i> <strong><?= $datos['employee'][0]['name']. " " . $datos['employee'][0]['lastname'] ?></strong>
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="new-period-form" class="smart-form" action="javascript:new_period()">
									<input type="hidden" name="employee_id" value="<?= $datos['employee'][0]['id'] ?>">
											<fieldset>
												<div class="row">
													<section class="col col-6">
														<label class="input"> <i class="icon-prepend fa fa-briefcase"></i>
															<input type="text" name="position" placeholder="Cargo" required>
														</label>
													</section>
													<section class="col col-6">
														<label class="input"> <i class="icon-prepend fa fa-money"></i>
															<input type="text" name="salary" placeholder="Salario" required amounts="true">
														</label>
													</section>
												</div>

												<div class="row">
													<section class="col col-6">
														<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
															<input type="text" name="date_start" id="date_start" placeholder="Fecha de Alta" required>
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
							<span><i class="fa fa-calendar"></i></span> Fecha de Egreso <i>para</i> <strong><?= $datos['employee'][0]['name'] . " " . $datos['employee'][0]['lastname'] ?></strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="employee-delete-form" class="smart-form" action="javascript:end_period()">
							<input type="hidden" name="end_period_id" value="">

							<fieldset>
								<section>
									<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
										<input type="text" name="date_end" id="date_end" placeholder="Fecha de Egreso" required>
									</label>
								</section>
							</fieldset>
							<footer>
								<button type="submit" class="btn btn-danger">
									Registrar Egreso
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

		