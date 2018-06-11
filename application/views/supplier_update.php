
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				<a href="<?= base_url() ?>proveedores">Proveedores</a>
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
				<i class="fa-fw fa fa-shopping-cart"></i> 
					<a href="<?= base_url() ?>proveedores">Proveedores</a>
				<span>>  
					Editar
				</span>
				<span>>  
					<strong class="text-uppercase"><?= $datos['supplier'][0]['supplier_name']; ?></strong>
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<?php foreach ($datos['supplier'] as $key => $value) { 

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

						<form id="update-supplier-form" class="smart-form" novalidate="novalidate" action="javascript:send_form()">
							<input type="hidden" name="id" value="<?= $value['id'] ?>">
							<header>
								<span><i class="fa fa-shopping-cart"></i></span> <strong><?= $value['supplier_name']; ?></strong>
							</header>							
							
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Nombre</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-shopping-cart"></i>
											<input type="text" name="tradename" placeholder="Nombre" value="<?= $value['supplier_name'] ?>" required>
										</label>										
									</section>
									<section class="col col-6">
										<label class="label"><strong>Rut</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-file-text"></i>
											<input type="text" name="rut" placeholder="Rut" value="<?= $value['rut'] ?>" >
										</label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Teléfono</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-phone"></i>
											<input type="text" name="phone" placeholder="Teléfono" value="<?= $value['phone'] ?>" >
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>E-mail</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
											<input type="email" name="email" placeholder="E-mail" value="<?= $value['email'] ?>" >
										</label>
									</section>
								</div>

								<section>
									<label class="label"><strong>Dirección</strong></label>
									<label class="input"> <i class="icon-prepend fa fa-map"></i>
										<input type="text" name="address" placeholder="Dirección" value="<?= $value['address'] ?>" >
									</label>
								</section>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Código Postal</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-location-arrow"></i>
											<input type="text" name="zip" placeholder="Código Postal" value="<?= $value['zip'] ?>" >
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Ciudad</strong></label>
										<label class="input">
										<select name="city" style="width: 100%" class="select2" required onchange="javascript:hide_locations()">
											<optgroup>
											<option value="" selected="" disabled="">Ciudad</option>

											<?php 

												foreach ($datos['cities'] as $key_city => $value_city) {				

														if($value['supplier_city_id'] == $value_city['id']) {
															?>

															<option value="<?= $value_city['id']; ?>" selected><?= $value_city['name']." - ".$value_city['department_name']; ?></option>

															<?php
														}else {
															?>

															<option value="<?= $value_city['id']; ?>"><?= $value_city['name']." - ".$value_city['department_name']; ?></option>

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
											<label class="select">
											<select name="department" disabled required>
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
											</select> <i></i> </label>
										</section>
										<section class="col col-6">
											<label class="label"><strong>País</strong></label>
											<label class="select">
											<select name="country" disabled required>
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
											</select> <i></i> </label>
										</section>
									</div>

									<div class="row">
										<section class="col col-6">

											<label class="label"><strong>Frigoríficos</strong></label>
											<label class="input">
											<select multiple name="shamble" id="shamble" style="width: 100%" class="select2" required>
												<optgroup>

												<?php 							
													/*obtener ids shambles*/
													foreach ($datos['shambles_supplier'] as $k => $v) {
														$shambles[] = $v['shamble_id'];
													}


													foreach ($datos['shambles'] as $key_shamble => $value_shamble) {

														
														
															if(in_array($value_shamble['id'], $shambles)) {
																?>

																<option value="<?= $value_shamble['id']; ?>" selected><?= $value_shamble['tradename']; ?></option>

																<?php
															}else {
																?>

																<option value="<?= $value_shamble['id']; ?>"><?= $value_shamble['tradename']; ?></option>

																<?php
															}	


														
													}																								


												 ?>
												 </optgroup>
											</select> </label>
										</section>
									</div>

									<div class="row">
										<section class="col col-6">
											<label class="label"><strong>Precio Unitario</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-money"></i>
												<input type="text" name="precio_unitario" placeholder="Precio Unitario" value="<?= $value['precio_unitario'] ?>" amounts="true">
											</label>
										</section>
										<section class="col col-6">
											<label class="label"><strong>Cantidad Mensual</strong></label>
											<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
												<input type="text" name="month_quantity" placeholder="Cantidad Mensual" value="<?= $value['month_quantity'] ?>" >
											</label>
										</section>
									</div>

								<section>
									<strong>Nota:</strong> La información del <strong>departamento</strong> y <strong>país</strong> son agregados automáticamente al guardar la ciudad correspondiente.
								</section>								

							</fieldset>	

							<header><strong>Medio de Pago Principal</strong></header>
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="name_method" placeholder="Nombre completo" value="<?= $value['name_method'] ?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="input"> <i class="icon-prepend fa fa-file-text"></i>
											<input type="text" name="rut_method" placeholder="CC / NIT" value="<?= $value['rut_method'] ?>">
										</label>	
									</section>
								</div>
								<div class="row">
									<section class="col col-6">
										<label class="input"> <i class="icon-prepend fa fa-bank"></i>
											<input type="text" name="bankcenter_method" placeholder="Banco / Centro de Pago" value="<?= $value['bankcenter_method'] ?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="input"> <i class="icon-prepend fa fa-calculator"></i>
											<input type="text" name="account_method" placeholder="Número de cuenta" value="<?= $value['account_method'] ?>">
										</label>
									</section>
								</div>
								
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

		