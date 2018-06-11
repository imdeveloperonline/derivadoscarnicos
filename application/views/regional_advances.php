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
						Anticipo a Regional
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
							<i class="fa fa-building fa-fw "></i> 
								Regional 
							<span>>
								Anticipos
							</span>
							<span>>
								<strong><?= $datos['advances'][0]['regional_name'] ?></strong>
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
									<h2>Anticipos a Regionales</h2>
				
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
													<th data-hide="phone,tablet">Regional</th>
													<th data-hide="phone">Monto (COP)</th>
													<th data-class="expand">Fecha</th>
													<th data-hide="phone,tablet">Detalle</th>
													<th data-hide="phone,tablet">Acciones</th>
												</tr>
											</thead>
											<tbody id="tbody">

												<?php 

													foreach ($datos['advances'] as $key => $value) {

														/*$ci = &get_instance();
														$ci->load->model('Finanzas_model','finances');
														$query = $ci->finances->get_rest_advance($value['id']);
														$rest = $query->result_array();

														if($rest[0]['rest'] == 0){
															$pagado = '<i class="fa fa-check fa-lg text-success"></i>';
														} else {
															$pagado = "";
														}

														if($rest[0]['rest'] == NULL){
															$rest[0]['rest'] = $value['quantity'];
															$pagado = "";
														}*/
														if($value['detail'] != "") {
															$note = '<a onclick="javascript:set_modal('.$value['id'].')"  href="#noteModal" data-toggle="modal"  id="note_'.$value['id'] .'" data-note="'.$value['detail'] .'"><i class="fa fa-comment"></i></a>';
														}else {
															$note = "Vacio";
														}

														if($value['id'] != ""){
														?>
															<tr id="tr_<?= $value['id'] ?>">
																<td><?= $value['id']; ?></td>
																<td><?= $value['regional_name']; ?></td>
																<td><?= $value['amount']; ?></td>
																<td><?= ucfirst(strftime("%A %d-%m-%Y",strtotime($value['date']))) ?></td>
																<td><?= $note; ?></td>											
																<td>
																	
																	&nbsp;
																	<a href="<?= base_url() . 'regionales/editar_anticipo/' . $value['id']; ?>" title="Editar Anticipo">
																		<i class="fa fa-pencil fa-lg"></i>
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
									<span><i class="fa fa-bank"></i></span> Anticipo <i>para</i> <?= $datos['advances'][0]['regional_name'] ?>
								</h4>
							</div>
							<div class="modal-body no-padding">

								<form id="adv-regional-form" class="smart-form" action="javascript:new_adv_regional()">
									<input type="hidden" name="regional_id" value="<?= $datos['advances'][0]['regional_id'] ?>">
									<fieldset>
										<div class="row">											
											<section class="col col-6">
												<label class="label"><strong>Monto (COP)</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-money"></i>
													<input type="text" name="amount" placeholder="Monto (COP)" required  amounts="true">
												</label>
											</section>
											<section class="col col-6">
												<label class="label"><strong>Fecha</strong></label>
												<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
													<input type="text" name="date" id="date" placeholder="Fecha" required>
												</label>
											</section>	
										</div>

										<div class="row">
																				
										</div>
										<section>
											<label class="label"><strong>Detalles</strong></label>
											<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						
												<textarea rows="5" name="detail" placeholder="Detalles"></textarea> 
											</label>
										</section>	
										
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

				<!-- Modal Note -->
				<div class="modal fade" id="noteModal" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">
									<span><i class="fa fa-comment"></i></span> Detalle
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

		

		