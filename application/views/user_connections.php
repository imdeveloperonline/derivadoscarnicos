<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						Usuarios
					</li>
					<li>
						Conexiones
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
							<i class="fa fa-users fa-fw "></i> 
								Usuarios 
							<span>>
								Conexiones
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
									<h2><?= $datos['connections'][0]['email'].' ('.$datos['connections'][0]['name'].' '.$datos['connections'][0]['lastname'].') '; ?></h2>
				
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
													<th data-hide="phone,tablet">Hora</th>
													<th data-hide="phone,tablet">Ip</th>
													<th data-hide="phone,tablet">Navegador</th>
													<th data-hide="phone,tablet">SO</th>
													<th data-hide="phone,tablet">Mantener conectado</th>
												</tr>
											</thead>

											<tbody id="tbody">

												<?php 

													foreach ($datos['connections'] as $key => $value) {

														if($value['id'] != NULL){
															
															if($value['active'] == 0){
																$mantener = '<i class="fa fa-close fa-lg text-danger"></i>';
															} 
															else if ($value['active'] == 1){
																$mantener = '<i class="fa fa-check fa-lg text-success"></i>';
															}
															

															?>
																<tr id="tr_<?= $value['id'] ?>">
																	<td><?= $value['id']; ?></td>
																	<td><?= strftime('%A %d-%m-%Y',strtotime($value['date'])); ?></td>
																	<td><?= date('H:i:s',strtotime($value['date'])); ?></td>
																	<td><?= $value['ip']; ?></td>
																	<td><?= $value['agent']; ?></td>
																	<td><?= $value['so']; ?></td>
																	<td><?= $mantener; ?></td>
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

			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		

		