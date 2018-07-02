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
						Recepciones Central
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
								Recepciones Central
							</span>
							<span>
								<a data-toggle="modal" href="#myModal"><i class="fa fa-plus-circle" title="Registrar Recepción Central"></i></a>
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
									<h2 class="hidden-xs">Recepciones Central</h2>
				
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
													<th data-class="expand">Regional</th>
													<th data-class="expand">Despacho</th>
													<th data-hide="phone,tablet">Producto</th>
													<th data-hide="phone,tablet">Cantidad</th>
													<th data-hide="phone,tablet">Fecha</th>
													<th data-hide="phone,tablet">Nota</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['receptions'] as $key => $value) {

														if($value['note_reception'] != "") {
															$note = '<a onclick="javascript:set_modal('.$value['id'].')"  href="#noteModal" data-toggle="modal"  id="note_'.$value['id'] .'" data-note="'.$value['note_reception'] .'"><i class="fa fa-comment"></i></a>';
														}else {
															$note = "Vacio";
														}
														?>
															<tr id="tr_<?= $value['id'] ?>">
																<td><?= $value['id']; ?></td>
																<td><?= $value['regional_name']; ?></td>
																<td>
																	<a href="<?= base_url() ?>bodega/despachos_regionales/<?= $value['dispatch_regional_id']; ?>">
																	<?= $value['dispatch_regional_id']; ?>
																	</a>	
																</td>
																<td><?= $value['product_name']; ?></td>
																<td><?= $value['reception_quantity']; ?></td>
																<td><?= strftime('%A %d-%m-%Y',strtotime($value['reception_date'])); ?></td>
																<td><?= $note; ?></td>											
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
									<span><i class="fa fa-truck"></i></span> Nueva recepción central
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="reception-form" class="smart-form" action="javascript:new_reception()">
									<fieldset>
										<div class="row">
											<section class="col col-6">
												<label class="label"><strong>Regional</strong></label>
												<label class="input">
													<select name="regional_id" style="width: 100%" class="select2" required>
														<optgroup>
														<option value="" selected="" disabled="">Regional</option>

														<?php 


															foreach ($datos['regionals'] as $key => $value) {
																?>
																	<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
																<?php
															}


														 ?>
														 </optgroup>
													</select> </label>
											</section>

											<section class="col col-6">
												<label class="label"><strong>Despacho Regional</strong></label>
												<label class="input">
													<select name="dispatch_regional_id" style="width: 100%" class="select2" required>
														<option value="" selected="" disabled="">Despacho Regional</option>
													</select> </label>
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
											<label class="label"><strong>Nota despacho</strong></label>
											<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						
												<textarea rows="5" name="dispatch_note" placeholder="Nota despacho" readonly=""></textarea> 
											</label>
										</section>
										<section>
											<label class="label"><strong>Nota recepción</strong></label>
											<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						
												<textarea rows="5" name="note_reception" placeholder="Nota recepción"></textarea> 
											</label>
										</section>	
										
									</fieldset>
									
									<footer>
										<button type="submit" id="buttonNewRec" class="btn btn-primary">
											Recibido
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


				<!-- Modal Note -->
				<div class="modal fade" id="noteModal" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">
									<span><i class="fa fa-comment"></i></span> Nota
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form class="smart-form" >
									<fieldset>
										
										
										<section>
											<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						 
												<textarea rows="5" name="note_message" id="note_message" placeholder="Nota" readonly=""></textarea> 
											</label>
										</section>	
										
									</fieldset>
								</form>		
							</div>

						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal Note -->


			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		