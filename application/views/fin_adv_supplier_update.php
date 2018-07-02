
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment" onclick="window.location.href='<?= base_url() ?>'"> <span class="btn btn-ribbon"><i class="fa fa-home"></i></span> </span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>
				Finanzas
			</li>
			<li>
				Editar
			</li>
			<li>
				Anticipo Proveedor
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
				<i class="fa-fw fa fa-line-chart"></i> 
					Finanzas
				<span>>  
					Editar
				</span>
				<span>>  
					Anticipo Proveedor <strong class="text-uppercase"> N° <?= $datos['advance_supplier'][0]['id'] ?></strong>
				</span>
			</h1>
		</div>	
	</div>

<div id="resultado"></div>

<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- START ROW -->

	<div class="row">

		<?php foreach ($datos['advance_supplier'] as $key => $value) { 

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

						<form id="adv-supplier-form" class="smart-form" novalidate="novalidate" action="javascript:update_adv_supplier()">
							<input type="hidden" name="id" value="<?= $value['id'] ?>">
							<header>
								<span><i class="fa fa-line-chart"></i></span>Anticipo Proveedor <strong>N° <?= $value['id']; ?></strong>
							</header>							
							
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Proveedor</strong></label>
										<label class="input">
										<select name="supplier" style="width: 100%" class="select2" required data-placeholder="Seleccione un proveedor">
											<option value="" selected="" disabled=""></option>

											<?php 

												foreach ($datos['suppliers'] as $k => $v) {		

													if($value['supplier_id'] == $v['id']) {									
														?>
														<option value="<?= $v['id']; ?>" selected="selected"><?= $v['supplier_name']; ?></option>
														<?php			
													} else {
														?>
														<option value="<?= $v['id']; ?>"><?= $v['supplier_name']; ?></option>
														<?php	
													}									

												}

											 ?>
										</select>  </label>										
									</section>
									<section class="col col-6">
										<label class="label"><strong>Monto (COP)</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-money"></i>
											<input type="text" name="amount" placeholder="Monto (COP)" value="<?= $value['amount'] ?>" amounts="true">
										</label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Producto</strong></label>
										<label class="input">
										<select name="product" style="width: 100%" class="select2" required data-placeholder="Seleccione un producto">
											<option value="" selected="" disabled=""></option>

											<?php 

												foreach ($datos['products'] as $k => $v) {															
													if($value['product_id'] == $v['id']) {									
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
										</select>  </label>	
									</section>
									<section class="col col-6">
										<label class="label"><strong>Cantidad</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
											<input type="text" name="quantity" placeholder="Cantidad" value="<?= $value['quantity'] ?>" amounts="true">
										</label>
									</section>
								</div>								

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Fecha</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="date" id="date" placeholder="Fecha" value="<?= date('Y-m-d',strtotime($value['date'])) ?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Precio Unitario</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
											<input type="text" name="unit_price" placeholder="Precio Unitario" value="<?= $value['unit_price'] ?>">
										</label>
									</section>
								</div>

								<section>
									<label class="label"><strong>Detalles</strong></label>
									<label class="textarea"> <i class="icon-prepend fa fa-comment"></i>						
										<textarea rows="5" name="details" placeholder="Detalles"><?= $value['detail'] ?></textarea> 
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

		