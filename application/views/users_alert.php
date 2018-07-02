
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
				Recepción de Alertas
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
				<i class="fa-fw fa fa-exclamation-triangle"></i> 
					Usuarios
				<span>>  
					Recepción de Alertas
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

						<form id="update-form" class="smart-form" novalidate="novalidate" action="javascript:send_form()">
							<header>
								<span><i class="fa fa-exclamation-triangle"></i></span> Estos usuarios recibirán las alertas del sistema en su correo electrónico
							</header>							
							
							<fieldset>

								<section>

									<label class="label"><strong>Usuarios que recibirán alertas</strong></label>
									<label class="input">
									<select multiple name="user_alert" id="user_alert" style="width: 100%" class="select2">
										<optgroup>

										<?php 							
											/*obtener ids shambles*/
											foreach ($datos['users_alert'] as $k => $v) {
												$users_alert[] = $v['user_id'];
											}


											foreach ($datos['users'] as $key => $value) {

												
												
													if(in_array($value['id'], $users_alert)) {
														?>

														<option value="<?= $value['id']; ?>" selected><?= $value['name']." ".$value['lastname']." (".$value['email'].")"; ?></option>

														<?php
													}else {
														?>

														<option value="<?= $value['id']; ?>"><?= $value['name']." ".$value['lastname']." (".$value['email'].")"; ?></option>

														<?php
													}	


												
											}																								


										 ?>
										 </optgroup>
									</select> </label>
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


	</div>

	<!-- END ROW -->

</section>
<!-- end widget grid -->

			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		