<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						Regionales
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
							<i class="fa fa-sitemap fa-fw "></i> 
								Regionales 
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Nuevo Regional"></i></a>
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
									<h2>Regionales Registrados</h2>
				
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
													<th data-hide="phone">Dpto - Ciudads</th>
													<th data-hide="phone">Saldo (COP)</th>
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php  

													foreach ($datos['regionals'] as $key => $value) {

															$saldo = 0;
															foreach ($datos['saldo'] as $k => $v) {
																if($value['id'] == $v['regional_id']) {
																	$saldo = $v['saldo'];
																} 
															}


														
														?>
															<tr id="tr_<?= $value['id'] ?>">
																<td><?= $value['id']; ?></td>
																<td><?= $value['name']; ?></td>
																<td><?= $value['department_name'] . " - " .$value['city_name']; ?></td>
																<td><?= $saldo; ?></td>												
																<td>													
																	&nbsp;
																	<a href="<?= base_url() ?>regionales/editar/<?= $value['id'] ?>" title="Editar Regional">
																		<i class="fa fa-pencil fa-lg"></i>
																	</a>
																	&nbsp;

																	&nbsp;
																	<a href="<?= base_url() ?>regionales/anticipos/<?= $value['id'] ?>" title="Anticipos">
																		<i class="fa fa-bank fa-lg"></i>
																	</a>
																	&nbsp;

																	&nbsp;
																	<a class="text-danger" href="#modal-delete" data-toggle="modal" title="Eliminar Regional" onclick="javascript:set_modal(<?= $value['id'] ?>)">
																		<i class="fa fa-trash fa-lg"></i>
																	</a>
																	&nbsp;

																</td>
															</tr>
														<?php

															$saldo = 0;
															
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
									<span><i class="fa fa-sitemap"></i></span> Nuevo Regional
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="new-regional-form" class="smart-form" action="javascript:new_regional()">
									<fieldset>
										<div class="row">
											<section class="col col-6">
												<label class="input"> <i class="icon-prepend fa fa-user"></i>
													<input type="text" name="name" placeholder="Nombre" required>
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
										<button type="submit" id="buttonNewRegional" class="btn btn-primary">
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
							<span><i class="fa fa-trash"></i></span> <strong>¿Desea ELIMINAR este regional?</strong>
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="supplier-delete-form" class="smart-form" action="javascript:delete_regional()">
							<input type="hidden" name="regional_delete" value="">
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
		<div class="modal fade" id="update-regional-modal" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" id="close-update" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">
							<span><i class="fa fa-sitemap"></i></span> Editar Regional
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="update-regional-form" class="smart-form" action="javascript:update_regional()">
							<input type="hidden" name="regional_id" value="">
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Nombre</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-sitemap"></i>
											<input type="text" name="regional_name" placeholder="Nombre" required>
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Ciudad</strong></label>
										<label class="input">
											<select name="regional_city" style="width: 100%" class="select2" required>
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
								<button type="submit" id="buttonUpdateRegional" class="btn btn-primary">
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

		