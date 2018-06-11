
		<!-- MAIN PANEL -->
		<div id="main" role="main">
			
			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment" onClick="window.location.href= '<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>
				
				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>Inicio</li><li>Tutorial</li>
				</ol>
				<!-- end breadcrumb -->

			</div>
			<!-- END RIBBON -->
			
			<!-- MAIN CONTENT -->
			<div id="content">

				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Tutorial</h1>
					</div>
					
				</div>				

				<div class="row">
					<video width="80%" height="auto" style="margin-left: 10%" controls>
						<?php if($_SESSION['profile'] == 1 || $_SESSION['profile'] == 2) { ?>
						<source src="<?= base_url() ?>assets/tutorial/socios.mp4" type="video/mp4">
						<?php } else if($_SESSION['profile'] == 3) { ?>
						<source src="<?= base_url() ?>assets/tutorial/administrador_regional.mp4" type="video/mp4">
						<?php } else {?>
						<source src="<?= base_url() ?>assets/tutorial/colaborador.mp4" type="video/mp4">
						<?php } ?>
					</video>
				</div>
			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		

