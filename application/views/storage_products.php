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
						Productos
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
								Productos
							</span>
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Producto"></i></a>
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
									<h2 class="hidden-xs">Productos</h2>
				
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
													<th data-class="expand">Producto</th>
													<th data-hide="phone,tablet">Seleccionable</th>
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['products'] as $key => $value) {


														?>
															<tr id="tr_<?= $value['id'] ?>">
																<td><?= $value['id']; ?></td>
																<td id="name_edit_<?= $value['id'] ?>" data-edit="<?= $value['name'] ?>"><?= $value['name']; ?></td>
																<td id="selectable_<?= $value['id'] ?>">
																	
																	<?php if($value['deleted'] == 0) { ?>
																	&nbsp;
																	<a href="#" title="Restringir selección" onclick="javascript:selectable(<?= $value['id'] ?>,1)" class="text-success">
																		<i class="fa fa-check fa-lg"></i>
																	</a>
																	&nbsp;
																	<?php } else { ?>
																	&nbsp;
																	<a href="#" title="Habilitar selección" onclick="javascript:selectable(<?= $value['id'] ?>,0)" class="text-danger">
																		<i class="fa fa-close fa-lg"></i>
																	</a>
																	&nbsp;
																	<?php } ?>
																</td>
																<td>
																	
																	&nbsp;
																	<a href="#modal-edit" data-toggle="modal" title="Editar Producto" onclick="javascript:set_modal(<?= $value['id'] ?>)">
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
									<span><i class="fa fa-truck"></i></span> Nuevo producto
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="product-form" class="smart-form" action="javascript:new_product()">

									<fieldset>
										<section>
											<label class="label"><strong>Nombre</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
												<input type="text" name="name" placeholder="Nombre" required>
											</label>
										</section>
										
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewProduct" class="btn btn-primary">
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
				<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" id="close-edit" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">
									<span><i class="fa fa-comment"></i></span> Editar producto
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="edit-product-form" class="smart-form" action="javascript:edit_product()">
									<input type="hidden" name="id_edit" value="">
									<fieldset>									
										
										<section>
											<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
												<input type="text" name="name_edit" placeholder="Nombre" required>
											</label>
										</section>	
										
									</fieldset>

									<footer>
										<button type="submit" id="buttonEditProduct" class="btn btn-primary">
											Guardar cambios
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

		