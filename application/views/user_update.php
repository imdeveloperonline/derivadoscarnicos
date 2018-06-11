
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				<a href="<?= base_url() ?>usuarios">Usuarios</a>
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
				<i class="fa-fw fa fa-briefcase"></i> 
					<a href="<?= base_url() ?>usuarios">Usuarios</a>
				<span>>  
					Editar
				</span>
				<span>>  
					<strong class="text-uppercase"><?= $datos['user'][0]['name'].' '.$datos['user'][0]['lastname']; ?></strong>
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<?php foreach ($datos['user'] as $key => $value) { 

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

						<form id="update-user-form" class="smart-form" novalidate="novalidate" action="javascript:send_form()">
							<input type="hidden" name="id" value="<?= $value['id'] ?>">
							<header>
								<span><i class="fa fa-user"></i></span> <strong><?= $value['name'].' '.$value['lastname']; ?></strong>
							</header>							
							
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Nombre</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="name" placeholder="Nombre" value="<?= $value['name'] ?>" required>
										</label>										
									</section>
									<section class="col col-6">
										<label class="label"><strong>Apellido</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="lastname" placeholder="Apellido" value="<?= $value['lastname'] ?>">
										</label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Teléfono</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-phone"></i>
											<input type="tel" name="phone" placeholder="Teléfono" value="<?= $value['phone'] ?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>E-mail</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
											<input type="email" name="email" placeholder="E-mail" value="<?= $value['email'] ?>" required>
										</label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Cargo</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-briefcase"></i>
											<input type="text" name="position" placeholder="Cargo" value="<?= $value['position'] ?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Regional</strong></label>
										<label class="input">
										<select name="regional" style="width: 100%" class="select2" required>
											<optgroup>
											<option value="" selected="" disabled="">Regional</option>

											<?php 

												foreach ($datos['regionals'] as $key_regional => $value_regional) {				

														if($value['regional_id'] == $value_regional['id']) {
															?>

															<option value="<?= $value_regional['id']; ?>" selected><?= $value_regional['name']; ?></option>

															<?php
														}else {
															?>

															<option value="<?= $value_regional['id']; ?>"><?= $value_regional['name']; ?></option>

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
										<label class="label"><strong>Perfil</strong></label>
										<label class="input">
										<select name="profile" style="width: 100%" class="select2" required>
											<optgroup>
											<option value="" selected="" disabled="">Perfil</option>

											<?php 

												foreach ($datos['profiles'] as $key_profile => $value_profile) {				

														if($value['user_profile_id'] == $value_profile['id']) {
															?>

															<option value="<?= $value_profile['id']; ?>" selected><?= $value_profile['name']; ?></option>

															<?php
														}else {
															?>

															<option value="<?= $value_profile['id']; ?>"><?= $value_profile['name']; ?></option>

															<?php
														}													

												}

											 ?>
											 </optgroup>
										</select> </label>
									</section>
								</div>

								<section>
									<strong>Nota:</strong> En caso de haber perdido la contraseña, el usuario debera utilizar el sistema de recuperación en la página de ingreso.El sistema enviará un link de recuperación de contraseña para el usuario, al email registrado en este formulario.
								</section>

								<footer>
									<button type="submit" class="btn btn-primary" id="button">
										Guardar cambios
									</button>
								</footer>

							</fieldset>	
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

		