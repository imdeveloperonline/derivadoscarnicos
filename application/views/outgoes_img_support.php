<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						Gastos
					</li>
					<li>
						Soportes
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
							<i class="fa fa-line-chart fa-fw"></i>
								Gastos 
							<span>>
								Soportes
							</span>
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Nuevo Soporte"></i></a>
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
									<h2 class="hidden-xs">Soportes</h2>
				
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
													<th data-hide="phone">Imagen</th>
													<th data-class="expand">Título</th>
													<th data-hide="phone,tablet">Descripción</th>
													<th data-hide="phone,tablet">Regional</th>
												</tr>
											</thead>
											<tbody id="tbody">
												<?php 
												foreach ($datos['outgoes_imgs'] as $key => $value) {
													
													?>
													<tr id="tr_<?= $value['id'] ?>">
														<td><?= $value['id'] ?></td>
														<td>
															<span>
															<a href="#imgModal" data-toggle="modal" onclick="fillImg('<?= $value['file_name'] ?>')"><img style="height: 75px;width: auto;display: block;margin-left: auto; margin-right: auto;" src="<?= base_url() ?>assets/supports/outgoes/thumbs/<?= $value['file_name'] ?>"></a>
															</span>

														</td>
														<td><?= $value['title'] ?></td>
														<td><?= $value['description'] ?></td>
														<td><?= $value['regional_name'] ?></td>
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
									<span><i class="fa fa-file-image-o"></i></span> Nuevo Soporte
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="support-form" class="smart-form" action="javascript:new_support()">
											<fieldset>
												<section>
													<label class="input"> <i class="icon-prepend fa fa-user"></i>
														<input type="text" name="title" id="title" placeholder="Titulo" required>
													</label>
												</section>

												<section>
													<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>
														<textarea rows="5" name="description" id="description" placeholder="Descripción"></textarea>
													</label>
												</section>
												<section>									
													<div class="input input-file">
														<span class="button"><input id="file" name="file" onchange="this.parentNode.nextSibling.value = this.value" type="file"><i class="fa fa-camera"></i></span><input placeholder="Toma una foto o selecciona un archivo" id="photo" readonly="" type="text" capture img="true" required>
													</div>
													<div class="note">
														El formato de la imagen debe ser jpg
													</div>												
												</section>

												<section>
													<img src="" id="imgSalida" style="max-width: 100%;height: auto; max-height: 300px; display: block; margin-left: auto; margin-right: auto;">
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


				<!-- Modal Img -->
				<div class="modal fade" id="imgModal" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-body">
								<button type="button" id="close" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<div id="fullimg" style="text-align: center;"></div>

														
										

							</div>

						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal Img -->


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

		