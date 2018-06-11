
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				Sistema
			</li>
			<li>
				Reportes
			</li>
			<li>
				Finanzas
			</li>
		</ol>

	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">


	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">
				
				<!-- PAGE HEADER -->
				<i class="fa-fw fa fa-cogs"></i> 
					Sistema
				<span>>  
					Reportes
				</span>
				<span>>  
					<strong>Finanzas</strong>
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-8 col-lg-offset-2">
			
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-custombutton="false">

				<!-- widget div-->
				<div>
					
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
						
					</div>
					<!-- end widget edit box -->
					
					<!-- widget content -->
					<div class="widget-body no-padding">

						<form id="report-form" class="smart-form" novalidate="novalidate" action="javascript:send_form()">
							<header>
								<span><i class="fa fa-pie-chart"></i></span> Seleccione un rango de fechas
							</header>							
							
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Desde</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="startdate" id="startdate" placeholder="Desde" date="true" required>
										</label>										
									</section>
									<section class="col col-6">
										<label class="label"><strong>Hasta</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="finishdate" id="finishdate" placeholder="Hasta" date="true" required>
										</label>
									</section>
								</div>
								<!-- <section>
									<label class="label"><strong>Seleccione un departamento</strong></label>
									<label class="input">
										<select name="department" style="width:100%;" class="select2" required="required" data-placeholder="Ningún departamento seleccionado">
											<option></option>
											<optgroup>	
												<option value="0">Todos los departamentos</option>																
												<?php 
													foreach ($datos['departments'] as $key => $value) {
														?>
															<option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
														<?php
													}


												 ?>
											</optgroup>
										</select>
									</label>
								</section>

								<section id="regionals" style="display: none">
									<label class="label"><strong>Seleccione un regional</strong></label>
									<label class="input">
										<select name="regional" style="width:100%;" class="select2" required="required" data-placeholder="Ningún regional seleccionado">
											<option></option>
											<optgroup>
												<option value="0">Todos los regionales</option>
											</optgroup>
										</select>
									</label>
								</section> -->
					

							</fieldset>							

							<footer>
								<button type="submit" class="btn btn-primary" id="button">
									Generar reporte
								</button>
							</footer>
						</form>
						
					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->
										


		</article>
		<!-- END COL -->

	</div>

	<!-- END ROW -->

	<div class="row">
		<div id="loading" class="text-center" style="padding-top: 25px; padding-bottom: 25px;">
			
		</div>
		<div id="report">
			
		</div>
		
	</div>

</section>
<!-- end widget grid -->

			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		