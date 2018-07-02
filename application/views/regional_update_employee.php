
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
				<a href="<?= base_url() ?>regional/recursos_humanos">Recursos Humanos</a>
			</li>
			<li>
				Editar empleado
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
				<i class="fa-fw fa fa-user"></i> 
					Regional
				<span>>  
					<a href="<?= base_url() ?>regionales/recursos_humanos">Recursos Humanos</a>
				</span>
				<span>>  
					<strong class="text-uppercase"><?= $datos['employee'][0]['name'] . " " . $datos['employee'][0]['lastname']; ?></strong>
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<?php foreach ($datos['employee'] as $key => $value) { 

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

						<form id="update-employee-form" class="smart-form" novalidate="novalidate" action="javascript:send_form()">
							<input type="hidden" name="id" value="<?= $value['id'] ?>">
							<header>
								<span><i class="fa fa-briefcase"></i></span> <strong><?= $value['name'] . " " . $value['lastname']; ?></strong>
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
											<input type="text" name="lastname" placeholder="Apellido" value="<?= $value['lastname'] ?>" required>
										</label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Teléfono</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-phone"></i>
											<input type="text" name="phone" placeholder="Teléfono" value="<?= $value['phone'] ?>" required>
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
										<label class="label"><strong>Cédula</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-briefcase"></i>
											<input type="text" name="dni" placeholder="Cédula" value="<?= $value['dni'] ?>" required>
										</label>
									</section>
								</div>

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

		