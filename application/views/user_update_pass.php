
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
				Cambiar contraseña
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
					Usuarios
				<span>>  
					Cambiar contraseña
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
		<article class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
			
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
							<input type="hidden" name="id" value="<?= $_SESSION['id'] ?>">
							<header>
								<span><i class="fa fa-cogs"></i></span> Cambiar contraseña
							</header>							
							
							<fieldset>
								<section>
									<label class="label"><strong>Contraseña actual</strong></label>
									<label class="input"> <i class="icon-prepend fa fa-lock"></i>
										<input type="password" name="old_pass" placeholder="Contraseña actual" required>
									</label>										
								</section>

								<section>
									<label class="label"><strong>Nueva contraseña</strong></label>
									<label class="input"> <i class="icon-prepend fa fa-lock"></i>
										<input type="password" name="pass" id="pass" placeholder="Nueva contraseña" required>
									</label>
								</section>
								<section>
									<label class="label"><strong>Repita la nueva contraeña</strong></label>
									<label class="input"> <i class="icon-prepend fa fa-lock"></i>
										<input type="password" name="passConfirm" placeholder="Repita la nueva contraeña" required equalTo="#pass">
									</label>
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

		