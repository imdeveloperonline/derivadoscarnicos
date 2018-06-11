
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				<a href="<?= base_url() ?>clientes">Clientes</a>
			</li>
			<li>
				Detalle
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
					<a href="<?= base_url() ?>clientes">Clientes</a>
				<span>>  
					Detalle
				</span>
				<span>>  
					<strong><?= $datos[0]['tradename']; ?></strong>
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<?php foreach ($datos as $key => $value) { 

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

						<form id="checkout-form" class="smart-form person-form" novalidate="novalidate" action="javascript:void(0)">

							<header>
								<span><i class="fa fa-briefcase"></i></span> <strong><?= $value['tradename']; ?></strong>
							</header>							
							
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Nombre Comercial</strong></label>
										<i class="fa fa-briefcase"></i> <?= $value['tradename'] ?>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Rut</strong></label>
										<i class="fa fa-file-text"></i> <?= $value['rut'] ?>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Teléfono</strong></label>
										<i class="fa fa-phone"></i> <?= $value['phone'] ?>
									</section>
									<section class="col col-6">
										<label class="label"><strong>E-mail</strong></label>
										<i class="fa fa-envelope"></i> <?= $value['email'] ?>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Código Postal</strong></label>
										<i class="fa fa-location-arrow"></i> <?= $value['zip'] ?>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Ciudad</strong></label>
										<i class="fa fa-map-marker"></i> <?= $value['city_name'] ?>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Departamento</strong></label>
										<i class="fa fa-globe"></i> <?= $value['department_name'] ?>
									</section>
									<section class="col col-6">
										<label class="label"><strong>País</strong></label>
										<i class="fa fa-globe"></i> <?= $value['country_name'] ?>
									</section>
								</div>
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

		