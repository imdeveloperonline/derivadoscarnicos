
		<!-- MAIN PANEL -->
		<div id="main" role="main">
			
			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onClick="window.location.href= '<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>
				
				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>Inicio</li><li>Escritorio</li>
				</ol>
				<!-- end breadcrumb -->

			</div>
			<!-- END RIBBON -->
			
			<!-- MAIN CONTENT -->
			<div id="content">

				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Escritorio <span>> Herramientas</span></h1>
					</div>
					
				</div>				

				<?php if(in_array($_SESSION['profile'],array(1))) { ?>
				<div class="row">

					<article class="col-sm-12 col-md-12 col-lg-12">
						<div class="col-sm-12 well"> 
							<div class="col-sm-6">
								<table class="highchart table table-hover table-bordered" data-graph-container=".. .. .highchart-container2" data-graph-type="column">
									<?php 
									if(date('m') >= 1 && date('m') <= 4) : $n = "I"; endif;
									if(date('m') >= 5 && date('m') <= 8) : $n = "II"; endif;
									if(date('m') >= 9 && date('m') <= 12) : $n = "III"; endif;
									 ?>
					              <caption><?= $n; ?> Periodo - Año <?= date('Y') ?></caption>
					              <thead>
					                <tr>
					                  <th>Mes</th>
					                  <th class="">Ingresos</th>
					                  <th class="">Egresos</th>
					                  <th class="">Haber</th>
					                </tr>
					              </thead>
					              <tbody>
					              	<?php if(date('m') >= 1 && date('m') <= 4) {?>
					                <tr>
					                  <td>Enero</td>
										<?php 
											$ingresos1 = $datos['january']['ingresos'][0]['income'];
											$egresos1 = $datos['january']['egresos'][0]['egress'];
											$haber1 = $datos['january']['ingresos'][0]['income'] - $datos['january']['egresos'][0]['egress'];

										 ?>

					                  <td class=""><?= $ingresos1 ?></td>
					                  <td class=""><?= $egresos1 ?></td>
					                  <td class=""><?= $haber1 ?></td>
					                </tr>
					                <tr>
					                  <td>Febrero</td>
					                  <?php 
											$ingresos2 = $datos['february']['ingresos'][0]['income'];
											$egresos2 = $datos['february']['egresos'][0]['egress'];
											$haber2 = $datos['february']['ingresos'][0]['income'] - $datos['february']['egresos'][0]['egress'];

										 ?>
					                  <td class=""><?= $ingresos2 ?></td>
					                  <td class=""><?= $egresos2 ?></td>
					                  <td class=""><?= $haber2 ?></td>
					                </tr>
					                <tr>
					                  <td>Marzo</td>
					                  <?php 
											$ingresos3 = $datos['march']['ingresos'][0]['income'];
											$egresos3 = $datos['march']['egresos'][0]['egress'];
											$haber3 = $datos['march']['ingresos'][0]['income'] - $datos['march']['egresos'][0]['egress'];

										 ?>
					                  <td class=""><?= $ingresos3 ?></td>
					                  <td class=""><?= $egresos3 ?></td>
					                  <td class=""><?= $haber3 ?></td>
					                </tr>
					                <tr>
					                  <td>Abril</td>
					                  <?php 
											$ingresos4 = $datos['april']['ingresos'][0]['income'];
											$egresos4 = $datos['april']['egresos'][0]['egress'];
											$haber4 = $datos['april']['ingresos'][0]['income'] - $datos['april']['egresos'][0]['egress'];

										 ?>
					                  <td class=""><?= $ingresos4 ?></td>
					                  <td class=""><?= $egresos4 ?></td>
					                  <td class=""><?= $haber4 ?></td>
					                </tr>
					                <tr>
					                  <td><strong>Total periodo</strong></td>
					                  <td class=""><?= $ingresos1 + $ingresos2 + $ingresos3 + $ingresos4 ?></td>
					                  <td class=""><?= $egresos1 + $egresos2 + $egresos3 + $egresos4 ?></td>
					                  <td class=""><?= $haber1 + $haber2 + $haber3 + $haber4 ?></td>
					                </tr>
					             	<?php } ?>
					             	<?php if(date('m') >= 5 && date('m') <= 8) {?>
					                <tr>
					                  <td>Mayo</td>
										<?php 
											$ingresos1 = $datos['may']['ingresos'][0]['income'];
											$egresos1 = $datos['may']['egresos'][0]['egress'];
											$haber1 = $datos['may']['ingresos'][0]['income'] - $datos['may']['egresos'][0]['egress'];

										 ?>

					                  <td class=""><?= $ingresos1 ?></td>
					                  <td class=""><?= $egresos1 ?></td>
					                  <td class=""><?= $haber1 ?></td>
					                </tr>
					                <tr>
					                  <td>Junio</td>
					                  <?php 
											$ingresos2 = $datos['june']['ingresos'][0]['income'];
											$egresos2 = $datos['june']['egresos'][0]['egress'];
											$haber2 = $datos['june']['ingresos'][0]['income'] - $datos['june']['egresos'][0]['egress'];

										 ?>
					                  <td class=""><?= $ingresos2 ?></td>
					                  <td class=""><?= $egresos2 ?></td>
					                  <td class=""><?= $haber2 ?></td>
					                </tr>
					                <tr>
					                  <td>Julio</td>
					                  <?php 
											$ingresos3 = $datos['july']['ingresos'][0]['income'];
											$egresos3 = $datos['july']['egresos'][0]['egress'];
											$haber3 = $datos['july']['ingresos'][0]['income'] - $datos['july']['egresos'][0]['egress'];

										 ?>
					                  <td class=""><?= $ingresos3 ?></td>
					                  <td class=""><?= $egresos3 ?></td>
					                  <td class=""><?= $haber3 ?></td>
					                </tr>
					                <tr>
					                  <td>Agosto</td>
					                  <?php 
											$ingresos4 = $datos['august']['ingresos'][0]['income'];
											$egresos4 = $datos['august']['egresos'][0]['egress'];
											$haber4 = $datos['august']['ingresos'][0]['income'] - $datos['august']['egresos'][0]['egress'];

										 ?>
					                  <td class=""><?= $ingresos4 ?></td>
					                  <td class=""><?= $egresos4 ?></td>
					                  <td class=""><?= $haber4 ?></td>
					                </tr>
					                <tr>
					                  <td><strong>Total periodo</strong></td>
					                  <td class=""><?= $ingresos1 + $ingresos2 + $ingresos3 + $ingresos4 ?></td>
					                  <td class=""><?= $egresos1 + $egresos2 + $egresos3 + $egresos4 ?></td>
					                  <td class=""><?= $haber1 + $haber2 + $haber3 + $haber4 ?></td>
					                </tr>
					                <?php } ?>
					                <?php if(date('m') >= 9 && date('m') <= 12) {?>
					                <tr>
					                  <td>Septiembre</td>
										<?php 
											$ingresos1 = $datos['september']['ingresos'][0]['income'];
											$egresos1 = $datos['september']['egresos'][0]['egress'];
											$haber1 = $datos['september']['ingresos'][0]['income'] - $datos['september']['egresos'][0]['egress'];

										 ?>

					                  <td class=""><?= $ingresos1 ?></td>
					                  <td class=""><?= $egresos1 ?></td>
					                  <td class=""><?= $haber1 ?></td>
					                </tr>
					                <tr>
					                  <td>Octubre</td>
					                  <?php 
											$ingresos2 = $datos['october']['ingresos'][0]['income'];
											$egresos2 = $datos['october']['egresos'][0]['egress'];
											$haber2 = $datos['october']['ingresos'][0]['income'] - $datos['october']['egresos'][0]['egress'];

										 ?>
					                  <td class=""><?= $ingresos2 ?></td>
					                  <td class=""><?= $egresos2 ?></td>
					                  <td class=""><?= $haber2 ?></td>
					                </tr>
					                <tr>
					                  <td>Noviembre</td>
					                  <?php 
											$ingresos3 = $datos['november']['ingresos'][0]['income'];
											$egresos3 = $datos['november']['egresos'][0]['egress'];
											$haber3 = $datos['november']['ingresos'][0]['income'] - $datos['november']['egresos'][0]['egress'];

										 ?>
					                  <td class=""><?= $ingresos3 ?></td>
					                  <td class=""><?= $egresos3 ?></td>
					                  <td class=""><?= $haber3 ?></td>
					                </tr>
					                <tr>
					                  <td>Diciembre</td>
					                  <?php 
											$ingresos4 = $datos['december']['ingresos'][0]['income'];
											$egresos4 = $datos['december']['egresos'][0]['egress'];
											$haber4 = $datos['december']['ingresos'][0]['income'] - $datos['december']['egresos'][0]['egress'];

										 ?>
					                  <td class=""><?= $ingresos4 ?></td>
					                  <td class=""><?= $egresos4 ?></td>
					                  <td class=""><?= $haber4 ?></td>
					                </tr>
					                <tr>
					                  <td><strong>Total periodo</strong></td>
					                  <td class=""><?= $ingresos1 + $ingresos2 + $ingresos3 + $ingresos4 ?></td>
					                  <td class=""><?= $egresos1 + $egresos2 + $egresos3 + $egresos4 ?></td>
					                  <td class=""><?= $haber1 + $haber2 + $haber3 + $haber4 ?></td>
					                </tr>
					                <?php } ?>
					              </tbody>
					            </table>
							</div>
							<div class="col-sm-6">
								<div class="highchart-container2"></div>
							</div>
						</div>
					</article>
				</div>
				
				<div class="row">
					
					<article class="col-sm-12 col-md-6 col-lg-6">
						<!-- new widget -->
						<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">

							<!-- widget options:
							usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

							data-widget-colorbutton="false"
							data-widget-editbutton="false"
							data-widget-togglebutton="false"
							data-widget-deletebutton="false"
							data-widget-fullscreenbutton="false"
							data-widget-custombutton="false"
							data-widget-collapsed="true"
							data-widget-sortable="false"

							-->

							<header>
								<span class="widget-icon"> <i class="fa fa-map-marker"></i> </span>
								<h2>Gastos por departamento (<?= ucfirst(strftime("%B", time())); ?>)</h2>
							</header>

							<script>
						
								data_array = <?= $datos['map_outgoes'] ?> 
							</script>

							<!-- widget div-->
							<div>
								<!-- widget edit box -->
								<div class="jarviswidget-editbox">
									<div>
										<label>Title:</label>
										<input type="text" />
									</div>
								</div>
								<!-- end widget edit box -->

								<div class="widget-body no-padding">
									<!-- content goes here -->

									<div id="vector-map" class="vector-map"></div>
									<div id="heat-fill">
										<span class="fill-a">-</span>

										<span class="fill-b">+</span>
									</div>

									

									<!-- end content -->

								</div>

							</div>
							<!-- end widget div -->
						</div>
						<!-- end widget -->
					</article>

					<!-- NEW WIDGET START -->
						<article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget" id="wid-id-6" data-widget-editbutton="false">
								<!-- widget options:
								usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

								data-widget-colorbutton="false"
								data-widget-editbutton="false"
								data-widget-togglebutton="false"
								data-widget-deletebutton="false"
								data-widget-fullscreenbutton="false"
								data-widget-custombutton="false"
								data-widget-collapsed="true"
								data-widget-sortable="false"

								-->
								<header>
									<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
									<h2>Gastos</h2>

								</header>
								
								<script>
									data_pie  = <?= $datos['data_pie'] ?>;
								</script>
								<!-- widget div-->
								<div>

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
									<!-- end widget edit box -->

									<!-- widget content -->
									<div class="widget-body no-padding">

										<div id="pie-chart" class="chart"></div>

									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
							<!-- end widget -->

						</article>
						<!-- WIDGET END -->
				</div>
				<?php } ?>
			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		

