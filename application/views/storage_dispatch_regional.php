
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				Bodega
			</li>
			<li>
				Despacho regional
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
				<i class="fa-fw fa fa-archive"></i> 
					Bodega
				<span>>  
					Despacho regional
				</span>
				<span>>  
					N° <?= $datos['regional_dispatch'][0]['id']; ?>
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<?php foreach ($datos['regional_dispatch'] as $key => $value) { 

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
								<span><i class="fa fa-archive"></i></span> <strong>Despacho regional N° <?= $value['id']; ?></strong>
							</header>							
							
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Regional</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" placeholder="Nombre" value="<?= $value['regional_name'] ?>" readonly>
										</label>										
									</section>
									<section class="col col-6">
										<label class="label"><strong>Destino</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" placeholder="Destino" value="<?= $value['to_regional_name'] ?>" readonly>
										</label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Producto</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-archive"></i>
											<input type="text" placeholder="Producto" value="<?= $value['product_name'] ?>" readonly>
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Cantidad</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-tasks"></i>
											<input type="text" placeholder="Cantidad" value="<?= $value['quantity'] ?>" readonly>
										</label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Fecha</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" placeholder="Fecha" value="<?= $value['date']  ?>" readonly>
										</label>
									</section>
								</div>

								

								<section>
									<label class="label">Nota de despacho</label>
									<label class="textarea"><i class="icon-prepend fa fa-comment"></i>
										<textarea rows="5" placeholder="Nota despacho" readonly=""><?= $value['dispatch_note'] ?></textarea> 
									</label>
								</section>

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

		