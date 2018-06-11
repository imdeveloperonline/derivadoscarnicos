<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						Gastos Generales
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
							<i class="fa fa-book fa-fw "></i> 
								Gastos Generales 
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Nuevo Gasto"></i></a>
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
									<h2 class="hidden-xs">Gastos Generales</h2>
				
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
													<th data-hide="phone">Monto</th>
													<th data-hide="phone,tablet">Tipo</th>
													<th data-hide="phone,tablet">Detalles</th>
													<?php if($_SESSION['profile'] == 1) { ?>
													<th data-hide="phone,tablet">Acciones</th>
													<?php } ?>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['outgoes'] as $key => $value) {

														?>
															<tr id="tr_<?= $value['id'] ?>">
																<td><?= $value['id']; ?></td>
																<td><?= strftime('%A %d-%m-%Y',strtotime($value['date'])); ?></td>
																<td><?= $value['amount']; ?></td>
																<td><?= $value['type_outgo']; ?></td>
																<td><?= $value['detail']; ?></td>
																<?php if($_SESSION['profile'] == 1) { ?>
																<td>
																	&nbsp;
																	<a href="<?= base_url() ?>gastos/editar/<?= $value['id'] ?>/1" title="Editar Producto">
																		<i class="fa fa-pencil fa-lg"></i>
																	</a>
																	&nbsp;
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
									<span><i class="fa fa-book"></i></span> Nuevo Gasto
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="new-outgo-form" class="smart-form" action="javascript:new_outgo()">
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

										<div class="row">
											<section class="col col-6">
												<label class="label"><strong>Tipo de Gasto</strong></label>
												<label class="input">
													<select name="type_outgo_id" style="width: 100%" class="select2" required data-placeholder="Seleccione un tipo de gasto">
														<option></option>
														<optgroup>

														<?php 


															foreach ($datos['outgo_types'] as $key => $value) {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['name'] ?></option>
																<?php
															}


														 ?>
														 </optgroup>
													</select> </label>
											</section>
										</div>
										<section>
											<label class="label"><strong>Detalles</strong></label>
											<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						
												<textarea rows="5" name="detail" placeholder="Detalles"></textarea> 
											</label>
										</section>	
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewOutgo" class="btn btn-primary">
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

		