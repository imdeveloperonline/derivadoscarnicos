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
						Ver/Editar
					</li>
				</ol>
				<!-- end breadcrumb -->

			</div>
			<!-- END RIBBON -->

			<!-- MAIN CONTENT -->
			<div id="content">

				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<h1 class="page-title txt-color-blueDark">
							<i class="fa fa-book fa-fw "></i> 
								Gastos 
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Nuevo Gasto"></i></a>
							</span>
						</h1>
					</div>
					<?php 

					$ci = &get_instance();
					$ci->load->model('Regionales_model','regionals');
					$saldo = $ci->regionals->get_regional_saldo();


					 ?>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<h2 class="page-title txt-color-blueDark pull-right">
								<span>
								Saldo regional
								</span>
								<br>
									<?= number_format($saldo, 2, ",", ".") ?> COP		
						</h2>
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
									<h2 class="hidden-xs">Gastos</h2>
				
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
													<th data-hide="phone,tablet">Regional</th>
													<th data-hide="phone,tablet">Detalles</th>
													<th data-hide="phone,tablet">Acciones</th>
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
																<td><?= $value['regional_name']; ?></td>
																<td><?= $value['detail']; ?></td>
																
																<td>
																	<?php if($_SESSION['profile'] == 1) { ?>
																	&nbsp;
																	<a href="<?= base_url() ?>gastos/editar/<?= $value['id'] ?>" title="Editar Producto">
																		<i class="fa fa-pencil fa-lg"></i>
																	</a>
																	&nbsp;
																	<?php } ?>
																	<?php if($value['file_name'] != "" && $value['file_name'] != NULL) { ?>
																	&nbsp;
																	<a href="#imgModal" data-toggle="modal" title="Ver imagen" onclick="fillImg('<?= $value['file_name'] ?>')">
																		<i class="fa fa-file-photo-o fa-lg"></i>
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
													<input type="text" name="amount" id="amount" placeholder="Monto (COP)" required amounts="true" onkeyup="this.value = numberFront('amount')">
												</label>
											</section>
										</div>

										<div class="row">
											<section class="col col-6">
												<label class="label"><strong>Tipo de Gasto</strong></label>
												<label class="input">
													<select name="type_outgo_id" id="type_outgo_id" style="width: 100%" class="select2" required>
														<optgroup>
														<option value="" selected="" disabled="">Tipo de Gasto</option>

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
												<textarea rows="5" name="detail" id="detail" placeholder="Detalles"></textarea> 
											</label>
										</section>
										<section>
											<label class="label"><strong>Título de la Imagen</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-user"></i>
												<input type="text" name="title" id="title" placeholder="Título de la Imagen">
											</label>
										</section>	
										<section>									
											<div class="input input-file">
												<span class="button"><input id="file" name="file" onchange="this.parentNode.nextSibling.value = this.value" type="file"><i class="fa fa-camera"></i></span><input placeholder="Toma una foto o selecciona un archivo" id="photo" readonly="" type="text" capture img="true">
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

		