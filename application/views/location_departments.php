<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						Lugares
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
							<i class="fa fa-map-marker fa-fw "></i> 
								Lugares 
							<span>>
								Departamentos
							</span>
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Nuevo Departamento"></i></a>
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
									<h2>Departamentos</h2>
				
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
													<th data-class="expand">Departamento</th>
													<th data-hide="phone,tablet">País</th>
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['departments'] as $key => $value) {
															
														?>
															<tr id="tr_<?= $value['id'] ?>">
																<td><?= $value['id']; ?></td>
																<td><?= $value['name']; ?></td>
																<td><?= $value['country_name']; ?></td>												
																<td>													
																	&nbsp;
																	<a href="#update-location-modal" title="Editar Departamento" onclick="set_modal(<?= $value['id'] ?>,'<?= $value['name'] ?>', <?= $value['country_id'] ?>)" data-toggle="modal">
																		<i class="fa fa-pencil fa-lg"></i>
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
									<span><i class="fa fa-map-marker"></i></span> Nuevo Departamento
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="new-location-form" class="smart-form" action="javascript:new_location()">
									<fieldset>
											<section class="col col-6">
												<label class="input">
													<input type="text" name="name" placeholder="Nombre" required>
												</label>
											</section>
											<section class="col col-6">
												<label class="input">
													<select name="country" style="width: 100%" class="select2" required>
														<optgroup>
														<option value="" selected="" disabled="">País</option>

														<?php 


															foreach ($datos['countries'] as $key => $value) {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
																<?php
															}


														 ?>
														 </optgroup>
													</select> </label>
											</section> 
										
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

		<!-- Modal -->
		<div class="modal fade" id="update-location-modal" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" id="close-update" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">
							<span><i class="fa fa-map-marker"></i></span> Editar Departamento
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="update-location-form" class="smart-form" action="javascript:update_location()">
							<input type="hidden" name="department_id" value="">
							<fieldset>
								<section class="col col-6">
									<label class="label"><strong>Nombre</strong></label>
									<label class="input"> <i class="icon-prepend fa fa-map-marker"></i>
										<input type="text" name="department_name" placeholder="Nombre" required>
									</label>
								</section>
									<section class="col col-6">
										<label class="label"><strong>País</strong></label>
										<label class="input">
											<select name="country_department" style="width: 100%" class="select2" required>
												<optgroup>
												<option value="" selected="" disabled="">País</option>

												<?php 

													foreach ($datos['countries'] as $key => $value) {
														?>
															<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
														<?php
													}

												 ?>
												 </optgroup>
											</select> </label>
									</section> 
								
							</fieldset>
							
							<footer>
								<button type="submit" id="buttonUpdate" class="btn btn-primary">
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

		