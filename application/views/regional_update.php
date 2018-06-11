
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				<a href="<?= base_url() ?>regionales">Regionales</a>
			</li>
			<li>
				Editar
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
				<i class="fa-fw fa fa-sitemap"></i> 
					<a href="<?= base_url() ?>regionales">Regionales</a>
				<span>>  
					Editar
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<?php foreach ($datos['regional'] as $key => $value) { 

			?>



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

						<form id="update-regional-form" class="smart-form" novalidate="novalidate" action="javascript:send_form()">
							<input type="hidden" name="id" value="<?= $value['id'] ?>">
							<header>
								<span><i class="fa fa-sitemap"></i></span> <strong><?= $value['name']; ?></strong>
							</header>							
							
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="name" placeholder="Nombre" value="<?= $value['name'] ?>" required>
										</label>
									</section>
									<section class="col col-6">
										<label class="input">
											<select name="city" style="width: 100%" class="select2" required onchange="javascript:hide_locations()">
												<optgroup>
												<option value="" selected="" disabled="">Ciudad</option>

												<?php 


													foreach ($datos['cities'] as $k => $v) {

														
														if($value['city_id'] == $v['id']){
														
														?>
															<option value="<?= $v['id']; ?>" selected><?= $v['name']." - ".$v['department_name']; ?></option>
														<?php
														} else {
														?>
															<option value="<?= $v['id']; ?>"><?= $v['name']." - ".$v['department_name']; ?></option>
														<?php
														}
														
													}


												 ?>
												 </optgroup>
											</select> </label>
									</section>
								</div>

								<div class="row" id="locations">
									<section class="col col-6">
										<label class="label"><strong>Departamento</strong></label>
										<label class="input">
										<select name="department" style="width: 100%" class="select2" disabled required>
											<optgroup>
											<option value="" selected="" disabled="">Departamento</option>

											<?php 


												foreach ($datos['departments'] as $key => $value_dep) {
													
					

													if($value_dep['id'] == $value['department_id']) {
														?>

														<option value="<?= $value_dep['id']; ?>" selected><?= $value_dep['name']; ?></option>

														<?php
													}else {
														?>

														<option value="<?= $value_dep['id']; ?>"><?= $value_dep['name']; ?></option>

														<?php
													}
													

												}


											 ?>
											 </optgroup>
										</select> </label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>País</strong></label>
										<label class="input">
										<select name="country" style="width: 100%" class="select2" disabled required>
											<optgroup>
											<option value="" selected="" disabled="">País</option>

											<?php 


												foreach ($datos['countries'] as $key => $value_country) {
													
											
													if($value_country['id'] == $value['country_id']) {
														?>

														<option value="<?= $value_country['id']; ?>" selected><?= $value_country['name']; ?></option>

														<?php
													}else {
														?>

														<option value="<?= $value_country['id']; ?>"><?= $value_country['name']; ?></option>

														<?php
													}
													

												}


											 ?>
											 </optgroup>
										</select> </label>
									</section>
								</div>
								<section>
									<strong>Nota:</strong> La información del <strong>departamento</strong> y <strong>país</strong> son agregados automáticamente al guardar la ciudad correspondiente.
								</section>
								
							</fieldset>	
							<footer>
								<button type="submit" class="btn btn-primary" id="button">
									Guardar cambios
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
		
		
		<?php } //End foreach ?>


	</div>

	<!-- END ROW -->

</section>
<!-- end widget grid -->

			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		