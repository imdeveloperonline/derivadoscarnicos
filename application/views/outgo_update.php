
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				Gastos
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
				<i class="fa-fw fa fa-book"></i> 
					Gastos
				<span>>  
					Editar 
				</span>
				<span>>  
					<strong>N° <?= $datos['outgo'][0]['id']; ?> </strong>
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<?php foreach ($datos['outgo'] as $key => $value) { 

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

						<form id="update-form" class="smart-form" novalidate="novalidate" action="javascript:send_form()">
							<input type="hidden" name="id" value="<?= $value['id'] ?>">
							<input type="hidden" name="is_general" value="<?= $datos['is_general'] ?>">
							<header>
								<span><i class="fa fa-bank"></i></span> Anticipo <strong>N° <?= $datos['outgo'][0]['id']; ?> </strong>
							</header>							
							
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Monto (COP)</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-briefcase"></i>
											<input type="text" name="amount" placeholder="Monto (COP)" value="<?= $value['amount'] ?>" required amounts="true">
										</label>										
									</section>
									<section class="col col-6">
										<label class="label"><strong>Fecha</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="date" id="date" placeholder="Fecha" value="<?= date('Y-m-d',strtotime($value['date'])) ?>" required>
										</label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Tipo de Gasto</strong></label>
										<label class="input">
											<select name="type_outgo" style="width: 100%" class="select2" required data-placeholder="Seleccione un tipo de gasto">
												<optgroup>

												<?php 


													foreach ($datos['outgo_types'] as $k => $v) {
														if($value['type_outgo_id'] == $v['id']){
														?>
															<option value="<?= $v['id']; ?>" selected="selected"><?= $v['name']; ?></option>
														<?php
														} else {
														?>
															<option value="<?= $v['id']; ?>"><?= $v['name']; ?></option>
														<?php
														}
													}


												 ?>
												 </optgroup>
											</select> </label>
									</section>
									<?php if($datos['is_general'] != 1) { ?>
									<section class="col col-6">
										<label class="label"><strong>Regional</strong></label>
										<label class="input">
											<select name="regional" style="width: 100%" class="select2" required data-placeholder="Seleccione un regional">
												<optgroup>

												<?php 


													foreach ($datos['regionals'] as $k => $v) {
														if($value['regional_id'] == $v['id']){
														?>
															<option value="<?= $v['id']; ?>" selected="selected"><?= $v['name']; ?></option>
														<?php
														} else {
														?>
															<option value="<?= $v['id']; ?>"><?= $v['name']; ?></option>
														<?php
														}
													}


												 ?>
												 </optgroup>
											</select> </label>
									</section>
									<?php } ?>
								</div>

								<section>
									<label class="label"><strong>Detalle</strong></label>
									<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>
										<textarea rows="5" name="detail" placeholder="Detalle"><?= $value['detail']; ?></textarea>
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
		
		
		<?php } //End foreach ?>


	</div>

	<!-- END ROW -->

</section>
<!-- end widget grid -->

			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		