<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reportes_model', 'reports');
		if($_SESSION['logged'] != TRUE || !isset($_SESSION['logged'])) {
			redirect('login/logout');
		}
		if(!in_array($_SESSION['profile'],array(1,2))) {
			exit("Database Error");
		}
	}

	public function index()
	{
		
	}

	public function clientes()
	{
		$this->load->model('Client_model', 'clients');

		$clients = $this->clients->get_clients();

		$dato['recursos'] = array(
				"clients" => $clients->result_array()
			);
		$dato['page'] = "report_clients";
		$dato['footer'] = array('report_clients');
		$this->load->view('home',$dato);
	}

	public function get_client_report()
	{
		$startdate = $_POST['data']['startdate'];
		$finishdate = $_POST['data']['finishdate'];
		$client_id = $_POST['data']['client_id'];

		$query = $this->reports->get_client_report($client_id,$startdate,$finishdate);
			
		?>
		<div style="padding-top: 10px; padding-bottom: 10px;">
			<form id="report_form" action="<?= base_url() ?>reportes/export_report" method="post" target="_blank">
				<input type="hidden" name="html_data" id="html_data" value="">
			<button type="submit" class="btn btn-primary center-block">
				Reporte PDF
				<i class="fa fa-external-link"></i>
			</button>
			</form>
			
		</div>

		<div id="report_pdf" style="display: none">
			<div class="title">
				<h1>Reporte de Cliente</h1>
				<p>Desde: <?= ucfirst(strftime("%A %d-%m-%Y",strtotime($startdate))) ?> Hasta: <?= ucfirst(strftime("%A %d-%m-%Y",strtotime($finishdate))) ?></p>
			</div>

			<h2>Datos del Cliente</h2>
			<?php foreach ($query['client'] as $key => $value) { ?>
			<table>
				<tr>
					<td>
						<div><strong>Nombre:</strong> <?= $value['tradename'] ?></div>
						<div><strong>Rut:</strong> <?= $value['rut'] ?></div>
						<div><strong>Teléfono:</strong> <?= $value['phone'] ?></div>
						<div><strong>E-mail:</strong> <?= $value['email'] ?></div>
					</td>
					<td>
						<div><strong>Dirección:</strong> <?= $value['address'] ?></div>
						<div><strong>Código Postal:</strong> <?= $value['zip'] ?></div>
						<div><strong>Ciudad:</strong> <?= $value['city_name'] ?></div>
						<div><strong>Departamento:</strong> <?= $value['department_name'] ?></div>
						<div><strong>País:</strong> <?= $value['country_name'] ?></div>
					</td>
				</tr>
			</table>
			<?php } ?>

			<h2>Anticipos</h2>
			
			<table class="table table-responsive">
				<thead>
					<tr>
						<th data-hide="phone">ID</th>
						<th data-class="expand">Fecha</th>
						<th data-hide="phone,tablet">Producto</th>
						<th data-hide="phone,tablet">Cantidad</th>
						<th data-hide="phone,tablet">Producto enviado hasta hoy</th>
						<th data-hide="phone,tablet">Producto por enviar hasta hoy</th>
						<th data-hide="phone,tablet">Valor de Venta (COP)</th>
						<th data-hide="phone,tablet">Pago hasta hoy (COP)</th>
						<th data-hide="phone,tablet">Deuda hasta hoy (COP)</th>
					</tr>
				</thead>
				<tbody id="tbody">

					<?php 

					foreach ($query['advances'] as $key => $value) {
						
						$query_payments = $this->reports->get_total_pay_adv_client($value['id']);
						$total_in_pays = $query_payments->result_array()[0]['total_pays'];

						$query_dispatches = $this->reports->get_total_in_dispatch_adv_client($value['id']);
						$total_in_dispatches = $query_dispatches->result_array()[0]['total_in_dispatches'];
						?>
							<tr id="tr_<?= $value['id'] ?>">
								<td><?= $value['id']; ?></td>
								<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
								<td><?= $value['product_name']; ?></td>
								<td><?= $value['quantity']; ?></td>
								<td><?= $total_in_dispatches ?></td>
								<td><?= $value['quantity']-$total_in_dispatches ?></td>
								<td><?= $value['total']; ?></td>
								<td><?= $total_in_pays; ?></td>
								<td><?= $value['total']-$total_in_pays; ?></td>
							</tr>
						<?php

					}											


					?>					
																	
				</tbody>

			</table>

			<h2>Despachos</h2>

			<table class="table table-responsive">
				<thead>
					<tr>
						<th data-hide="phone">ID</th>
						<th data-class="expand">Fecha</th>
						<th data-hide="phone,tablet">Producto</th>
						<th data-hide="phone,tablet">Cantidad</th>
						<th data-hide="phone,tablet">ID Anticipo</th>
					</tr>
				</thead>
				<tbody id="tbody">

					<?php 

					foreach ($query['dispatches'] as $key => $value) {
						?>
							<tr id="tr_<?= $value['id'] ?>">
								<td><?= $value['id']; ?></td>
								<td><?= strftime("%A %d-%m-%Y", strtotime($value['dispatch_date']))?></td>
								<td><?= $value['product_name']; ?></td>
								<td><?= $value['dispatch_quantity']; ?></td>
								<td><?= $value['advance_client_id']; ?></td>
							</tr>
						<?php

					}											


					?>					
																	
				</tbody>

			</table>


		</div>
		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-8 col-lg-offset-2">
			
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">

				<!-- widget div-->
				<div>
					
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
						
					</div>
					<!-- end widget edit box -->

					<?php foreach ($query['client'] as $key => $value) { ?>
					
					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<form id="new-client-form" class="smart-form" action="javascript:new_client()">
							<header>
								<i class="fa fa-briefcase"></i>
								<strong>
									Detalle del cliente									
								</strong>
							</header>
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Nombre Comercial</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-briefcase"></i>
											<input type="text" name="tradename" placeholder="Nombre Comercial" value="<?= $value['tradename'] ?>" readonly>
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Rut</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-file-text"></i>
											<input type="text" name="rut" placeholder="Rut" value="<?= $value['rut'] ?>" readonly>
										</label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Teléfono</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-phone"></i>
											<input type="tel" name="phone" placeholder="Teléfono" value="<?= $value['phone'] ?>" readonly>
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>E-mail</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-envelope"></i>
											<input type="email" name="email" placeholder="E-mail" value="<?= $value['email'] ?>" readonly>
										</label>
									</section>
								</div>
								
								<section>
									<label class="label"><strong>Dirección</strong></label>
									<label class="input"> <i class="icon-prepend fa fa-map"></i>
										<input type="text" name="address" placeholder="Dirección" value="<?= $value['address'] ?>" readonly>
									</label>
								</section>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Código Postal</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-location-arrow"></i>
											<input type="tel" name="zip" placeholder="Código Postal" value="<?= $value['zip'] ?>" readonly>
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>Ciudad</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-map-marker"></i>
											<input type="tel" name="zip" placeholder="Ciudad" value="<?= $value['city_name'] ?>" readonly>
										</label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6">
										<label class="label"><strong>Departamento</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-map-marker"></i>
											<input type="tel" name="zip" placeholder="Departamento" value="<?= $value['department_name'] ?>" readonly>
										</label>
									</section>
									<section class="col col-6">
										<label class="label"><strong>País</strong></label>
										<label class="input"> <i class="icon-prepend fa fa-map-marker"></i>
											<input type="tel" name="zip" placeholder="País" value="<?= $value['country_name'] ?>" readonly>
										</label>
									</section>
								</div>
							</fieldset>
						</form>	
					</div>
					<!-- end widget content -->

					<?php } ?>
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->
										


		</article>
		<!-- END COL -->

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Anticipos de Clientes</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_1" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">Cantidad</th>
									<th data-hide="phone,tablet">Producto enviado hasta hoy</th>
									<th data-hide="phone,tablet">Producto por enviar hasta hoy</th>
									<th data-hide="phone,tablet">Valor de Venta (COP)</th>
									<th data-hide="phone,tablet">Pago hasta hoy (COP)</th>
									<th data-hide="phone,tablet">Deuda hasta hoy (COP)</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['advances'] as $key => $value) {
									
									$query_payments = $this->reports->get_total_pay_adv_client($value['id']);
									$total_in_pays = $query_payments->result_array()[0]['total_pays'];

									$query_dispatches = $this->reports->get_total_in_dispatch_adv_client($value['id']);
									$total_in_dispatches = $query_dispatches->result_array()[0]['total_in_dispatches'];
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['product_name']; ?></td>
											<td><?= $value['quantity']; ?></td>
											<td><?= $total_in_dispatches ?></td>
											<td><?= $value['quantity']-$total_in_dispatches ?></td>
											<td><?= $value['total']; ?></td>
											<td><?= $total_in_pays; ?></td>
											<td><?= $value['total']-$total_in_pays; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Despachos</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_2" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">Cantidad</th>
									<th data-hide="phone,tablet">ID Anticipo</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['dispatches'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['dispatch_date']))?></td>
											<td><?= $value['product_name']; ?></td>
											<td><?= $value['dispatch_quantity']; ?></td>
											<td><?= $value['advance_client_id']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->
		<script>
			var html = $("#report_pdf").html();
			
			$("#html_data").val(html);
			tableReload(1);
			tableReload(2);
		</script>
		<?php

	}

	public function export_report()
	{
		$data['content'] = $_POST['html_data'];

		$pdfFilePath = FCPATH . "assets/pdf/prueba1.pdf";

		$html = $this->load->view('pdf_template', $data, true); // render the view into HTML
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

		$this->load->library('pdf');

		$pdf = $this->pdf->load();

		// $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure ;)

		$pdf->WriteHTML($html); // write the HTML into the PDF

		$pdf->Output($pdfFilePath, 'I');

	}

	public function departamentos()
	{
		$this->load->model('Location_model', 'locations');

		$departments = $this->locations->get_departments();

		$dato['recursos'] = array(
				"departments" => $departments->result_array()
			);
		$dato['page'] = "report_departments";
		$dato['footer'] = array('report_departments');
		$this->load->view('home',$dato);
	}

	public function get_department_report()
	{
		$startdate = $_POST['data']['startdate'];
		$finishdate = $_POST['data']['finishdate'];
		$department_id = $_POST['data']['department_id'];

		$this->load->model('Location_model', 'locations');
		$department = $this->locations->get_department_by_id($department_id);
		$department_name = $department->result_array()[0]['name'];

		$query = $this->reports->get_department_report($department_id,$startdate,$finishdate);
			
		?>
		<div style="padding-top: 10px; padding-bottom: 10px;">
			<form id="report_form" action="<?= base_url() ?>reportes/export_report" method="post" target="_blank">
				<input type="hidden" name="html_data" id="html_data" value="">
			<button type="submit" class="btn btn-primary center-block">
				Reporte PDF
				<i class="fa fa-external-link"></i>
			</button>
			</form>
			
		</div>
		<div id="report_pdf">
			<div class="title">
				<h1>Reporte Departamento</h1>
				<h3><?= $department_name ?></h3>
				<p>Desde: <?= ucfirst(strftime("%A %d-%m-%Y",strtotime($startdate))) ?> Hasta: <?= ucfirst(strftime("%A %d-%m-%Y",strtotime($finishdate))) ?></p>
			</div>
			<div class="report_resume">

				<?php 
				$received_product = 0;
				foreach ($query['receptions'] as $key => $value) {
					$received_product = $received_product + $value['quantity'];
				} ?>

				<?php 
				$total_amount_outgoes = 0;
				foreach ($query['outgoes'] as $key => $value) {
					$total_amount_outgoes = $total_amount_outgoes + $value['amount'];
				} ?>

				<h2 style="text-align: center;">Resumen</h2>
				<hr>
				<div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Proveedores:</strong> 
						<hr>
						<?= count($query['suppliers']) ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Recepciones:</strong> 
						<hr>
						<?= count($query['receptions']) ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Producto recibido:</strong> 
						<hr>
						<?= $received_product ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Gastos:</strong> 
						<hr>
						<?= count($query['outgoes']) ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Total en Gastos:</strong> 
						<hr>
						<?= $total_amount_outgoes ?> COP
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Tipos de Gastos:</strong> 
						<hr>
						<?php foreach ($query['types_outgoes'] as $key => $value) {
							?>
							<div><strong><?= ucfirst(strtolower($value['type_outgo'])) ?>:</strong> <?= $value['amount'] ?> COP</div>
							
							<?php
						} ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Transacciones:</strong> 
						<hr>
						<?php foreach ($query['types_transactions'] as $key => $value) {
							?>
							<div><strong><?= ucfirst(strtolower($value['method_name'])) ?>:</strong> <?= $value['count'] ?></div>
							
							<?php
						} ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Total de Contado:</strong> 
						<hr>
						<?php foreach ($query['types_transactions'] as $key => $value) {
							if($value['method_id'] == 1){ 
								?>

								<div> <?= $value['amount'] ?> COP</div>
								
								<?php
							}
						} ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Total Crédito:</strong> 
						<hr>
						<?php foreach ($query['types_transactions'] as $key => $value) {
							if($value['method_id'] == 2){ 
								?>

								<div> <?= $value['amount'] ?> COP</div>
								
								<?php
							}
						} ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Total Anticipos:</strong> 
						<hr>
						<?php foreach ($query['types_transactions'] as $key => $value) {
							if($value['method_id'] == 3){ 
								?>

								<div> <?= $value['amount'] ?> COP</div>
								
								<?php
							}
						} ?>
					</div>

				</div>

			</div>
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Proveedores</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_1" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-class="expand">Nombre Comercial</th>
									<th data-hide="phone,tablet">Rut</th>
									<th data-hide="phone,tablet">Teléfono</th>
									<th data-hide="phone,tablet">E-mail</th>
									<th data-hide="phone,tablet">Frigorífico</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['suppliers'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= $value['tradename']?></td>
											<td><?= $value['rut']?></td>
											<td><?= $value['phone']; ?></td>
											<td><?= $value['email']; ?></td>
											<td></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Recepciones</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_2" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Cantidad</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">ID Anticipo</th>
									<th data-hide="phone,tablet">Proveedor</th>
									<th data-hide="phone,tablet">Frigorífico</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['receptions'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['quantity']?></td>
											<td><?= $value['product_name']; ?></td>
											<td><?= $value['advance_supplier_id']; ?></td>
											<td><?= $value['supplier_name']; ?></td>
											<td><?= $value['shamble_name']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Gastos</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_3" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-hide="phone,tablet">Regional</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Monto (COP)</th>
									<th data-hide="phone,tablet">Tipo de gasto</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['outgoes'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= $value['regional_name']?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['amount']?></td>
											<td><?= $value['type_outgo']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Transacciones proveedores</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_4" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-hide="phone,tablet">Proveedor</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Monto (COP)</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">Cantidad</th>
									<th data-hide="phone,tablet">Regional</th>
									<th data-hide="phone,tablet">Método de Pago</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['transactions'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= $value['supplier_name']?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['amount']?></td>
											<td><?= $value['product_name']; ?></td>
											<td><?= $value['quantity']; ?></td>
											<td><?= $value['regional_name']; ?></td>
											<td><?= $value['method_name']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->
			
		</div>
		<script>
			var html = $("#report_pdf").html();
			
			$("#html_data").val(html);
			tableReload(1);
			tableReload(2);
			tableReload(3);
			tableReload(4);
		</script>
		<?php

	}

	public function proveedores()
	{
		$this->load->model('Proveedores_model', 'suppliers');

		$suppliers = $this->suppliers->get_suppliers();

		$dato['recursos'] = array(
				"suppliers" => $suppliers->result_array()
			);
		$dato['page'] = "report_suppliers";
		$dato['footer'] = array('report_suppliers');
		$this->load->view('home',$dato);
	}

	public function get_supplier_report()
	{
		$startdate = $_POST['data']['startdate'];
		$finishdate = $_POST['data']['finishdate'];
		$supplier_id = $_POST['data']['supplier_id'];

		$query = $this->reports->get_supplier_report($supplier_id,$startdate,$finishdate);
			
		?>
		<div style="padding-top: 10px; padding-bottom: 10px;">
			<form id="report_form" action="<?= base_url() ?>reportes/export_report" method="post" target="_blank">
				<input type="hidden" name="html_data" id="html_data" value="">
			<button type="submit" class="btn btn-primary center-block">
				Reporte PDF
				<i class="fa fa-external-link"></i>
			</button>
			</form>
			
		</div>
		<div id="report_pdf">
			<div class="title">
				<h1>Reporte Proveedor</h1>
				<h3><?= $query['supplier'][0]['tradename'] ?></h3>
				<p>Desde: <?= ucfirst(strftime("%A %d-%m-%Y",strtotime($startdate))) ?> Hasta: <?= ucfirst(strftime("%A %d-%m-%Y",strtotime($finishdate))) ?></p>
			</div>
			<div class="report_resume">

				<h2 style="text-align: center;">Detalles del Proveedor</h2>
				<hr>
				<?php foreach ($query['supplier'] as $key => $value) { ?>
				<div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Nombre:</strong> 
						<hr>
						<?= $value['tradename'] ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Rut:</strong> 
						<hr>
						<div><?php if(empty($value['rut'])) : echo "NULL"; else : echo $value['rut']; endif; ?></div>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Teléfono:</strong> 
						<hr>
						<div><?php if(empty($value['phone'])) : echo "NULL"; else : echo $value['phone']; endif; ?></div>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>E-mail:</strong> 
						<hr>
						<div><?php if(empty($value['email'])) : echo "NULL"; else : echo $value['email']; endif; ?></div>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Dirección:</strong> 
						<hr>
						<div><?php if(empty($value['address'])) : echo "NULL"; else : echo $value['address']; endif; ?></div>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Código Postal:</strong> 
						<hr>
						<div><?php if(empty($value['zip'])) : echo "NULL"; else : echo $value['zip']; endif; ?></div>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Ciudad:</strong> 
						<hr>
						<div><?= $value['city_name'] ?></div>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Departamento:</strong> 
						<hr>
						<div><?= $value['department_name'] ?></div>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>País:</strong> 
						<hr>
						<div> <?= $value['country_name'] ?></div>
					</div>

				</div>
				<?php } ?>
			</div>

			 <div class="report_resume">

				<h2 style="text-align: center;">Resumen</h2>
				<hr>
				<div>
					<div class="col-lg-4 text-center" style="padding: 10px 5px 10px 5px;">
						<?php 
						
						
						$this->load->model('Finanzas_model','finances');
						$cash_amount = 0;
						$cash_count = 0;
						$cash_quantity = 0;
						$credit_count = 0;
						$credit_amount = 0;
						$credit_quantity = 0;
						$adv_amount = 0;
						$adv_count = 0;
						$adv_quantity = 0;
						$adv_rest = 0;
						$adv_due = 0;

						foreach ($query['transactions'] as $key => $value) {
							if($value['method_id'] == 1){
								$cash_amount = $value['amount'] + $cash_amount;
								$cash_quantity = $value['quantity'] + $cash_quantity;
								$cash_count++;
							}
							if($value['method_id'] == 2){
								$credit_amount = $value['amount'] + $credit_amount;
								$credit_quantity = $value['quantity'] + $credit_quantity;
								$credit_count++;
							}
							if($value['method_id'] == 3){
								$adv_amount = $value['amount'] + $adv_amount;
								$adv_quantity = $value['quantity'] + $adv_quantity;
								$adv_count++;

								if($value['payed'] == 0) {
									if($value['payed'] == 0) {
										$rest_query = $this->finances->get_rest_advance($value['id']);
										$rest = $rest_query->result_array()[0]['rest'];
									} else {
										$rest = 0;
									}
									$adv_due = ($rest*$value['unit_price']) + $adv_due;
									$adv_rest = $adv_rest + $rest;
								}
							}

						}
						$credit_payment = 0;
						foreach ($query['credit_payment'] as $key => $value) {
							$credit_payment = $value['amount'] + $credit_payment;
						}

						 ?>
						<strong>Producto de Contado (<?= $cash_count ?>):</strong> 
						<hr>
						<div>Cantidad Producto: <?= $cash_quantity ?></div>
						<div>Valor: <?= $cash_amount ?> COP</div>
					</div>
					<div class="col-lg-4 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Producto a Crédito (<?= $credit_count ?>):</strong> 
						<hr>
						<div>Cantidad Producto: <?= $credit_quantity ?></div>
						<div>Valor: <?= $credit_amount ?> COP</div>
						<div>Pago: <?= $credit_payment ?> COP</div>
						<div>Deuda: <?= $credit_amount-$credit_payment ?> COP</div>
					</div>
					<div class="col-lg-4 text-center" style="padding: 10px 5px 10px 5px;">
						<strong>Producto en Anticipo (<?= $adv_count ?>):</strong> 
						<hr>
						<div>Cantidad Producto: <?= $adv_quantity ?></div>
						<div>Valor: <?= $adv_amount ?> COP</div>
						<div>Falta: <?= $adv_rest ?> </div>
						<div>Deuda: <?= $adv_due ?> COP</div>
					</div>

				</div>
			</div> 
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Recepciones</h2>
					
				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_1" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">Cantidad</th>
									<th data-hide="phone,tablet">Marcas</th>
									<th data-hide="phone,tablet">Trans. N°</th>
									<th data-hide="phone,tablet">Método de Pago</th>
									<th data-hide="phone,tablet">Frigorífico</th>
									<th data-hide="phone,tablet">Monto frigorífico (COP)</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 
								$this->load->model('Bodega_model', 'storage');

								foreach ($query['receptions'] as $key => $value) {

									$brands = $this->storage->get_brands_reception($value['id']);

									if(count($brands->result_array()) > 0){
										$receptions_brands = "";
										foreach ($brands->result_array() as $k => $v) {
											$receptions_brands .= $v['quantity']." ".$v['brand']."<br/>";
										}
									} else {
										$receptions_brands = "NULL";
									}

									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= ucfirst(strftime("%A %d-%m-%Y",strtotime($value['date']))) ?></td>
											<td><?= $value['product_name']?></td>
											<td><?= $value['quantity']; ?></td>
											<td><?= $receptions_brands; ?></td>
											<td><?= $value['advance_supplier_id']; ?></td>
											<td><?= $value['method_name']; ?></td>
											<td><?= $value['shamble_name']; ?></td>
											<td><?= $value['shamble_amount']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

		<div class="report_resume">
			<h2 style="text-align: center;">Total Marcas</h2>
			<hr>
			<?php 
			if(!empty($query['total_brands'])){

				foreach ($query['total_brands'] as $key => $value) {
					?>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;">
						<strong> <?= $value['brand'] ?></strong> <br/> <?= $value['quantity'] ?>
					</div>
				
					<?php
				} 
			} else {
				echo "NULL";
			}
			?>
		</div>

			

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Transacciones</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_2" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-hide="phone,tablet">Proveedor</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Monto (COP)</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">Cantidad</th>
									<th data-hide="phone,tablet">Recibido</th>
									<th data-hide="phone,tablet">Falta</th>
									<th data-hide="phone,tablet">Deuda (COP)</th>
									<th data-hide="phone,tablet">Regional</th>
									<th data-hide="phone,tablet">Método de Pago</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['transactions'] as $key => $value) {

									if($value['payed'] == 0) {
										$rest_query = $this->finances->get_rest_advance($value['id']);
										$rest = $rest_query->result_array()[0]['rest'];
										$total_recivied = $rest_query->result_array()[0]['total_reception_quantity'];
									} else {
										$rest = 0;
										$total_recivied = $value['quantity'];
									}
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= $value['supplier_name']?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['amount']?></td>
											<td><?= $value['product_name']; ?></td>
											<td><?= $value['quantity']; ?></td>
											<td><?= $total_recivied ?></td>
											<td><?= $rest ?></td>
											<td><?= $rest*$value['unit_price'] ?></td>
											<td><?= $value['regional_name']; ?></td>
											<td><?= $value['method_name']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

		<!-- NEW WIDGET START -->
		<!-- <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-4" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Pagos de Créditos</h2>

				</header>

				<div>

					<div class="jarviswidget-editbox">

					</div>
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_3" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-hide="phone,tablet">Trans N°</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Monto (COP)</th>
								</tr>
							</thead>
							<tbody id="tbody"> -->

								<?php 

							/*	foreach ($query['credit_payment'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= $value['advance_supplier_id']?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['amount']?></td>
										</tr>
									<?php

								}*/											


								?>					
																				
							<!-- </tbody>
						</table>

					</div>

				</div>

			</div>

		</article> -->
		<!-- END WIDGET -->
			
		</div>
		<script>
			var html = $("#report_pdf").html();
			
			$("#html_data").val(html);
			tableReload(1);
			tableReload(2);
			/*tableReload(3);*/
		</script>
		<?php

	}

	public function finanzas()
	{
		$this->load->model('Location_model', 'locations');
		$departments = $this->locations->get_departments();

		$this->load->model('Regionales_model', 'regionals');
		$regionals = $this->regionals->get_regionals();

		$dato['recursos'] = array(
				"departments" => $departments->result_array(),
				"regionals" => $regionals->result_array()
			);
		$dato['page'] = "report_finances";
		$dato['footer'] = array('report_finances');
		$this->load->view('home',$dato);
	}

	public function get_regionals_by_department()
	{
		$department_id = $_POST['department_id'];

		$query = $this->reports->get_regionals_by_department($department_id);

		$regionals = "<optgroup><option value='0' selected='selected'>Todos los regionales</option>";


		if(!empty($query->result_array())) {
			
			foreach ($query->result_array() as $key => $value) {
				$regionals .= "<option value='".$value['id']."'>".$value['name']."</option>";
			}
			$regionals .= "</optgroup>";
		} else {
			$regionals .= "<option value=''>No hay regionales registrados</option></optgroup>";
		}

		echo $regionals;
	}


	public function get_finances_report()
	{
		$startdate = $_POST['data']['startdate'];
		$finishdate = $_POST['data']['finishdate'];
		/*$department_id = $_POST['data']['department_id'];
		$regional_id = $_POST['data']['regional_id'];*/

		$query = $this->reports->get_finances_report($startdate,$finishdate);
			
		?>
		<div style="padding-top: 10px; padding-bottom: 10px;">
			<form id="report_form" action="<?= base_url() ?>reportes/export_report" method="post" target="_blank">
				<input type="hidden" name="html_data" id="html_data" value="">
			<button type="submit" class="btn btn-primary center-block">
				Reporte PDF
				<i class="fa fa-external-link"></i>
			</button>
			</form>
			
		</div>
		<div id="report_pdf">
			<div class="title">
				<h1>Reporte Finanzas</h1>
				<p>Desde: <?= ucfirst(strftime("%A %d-%m-%Y",strtotime($startdate))) ?> Hasta: <?= ucfirst(strftime("%A %d-%m-%Y",strtotime($finishdate))) ?></p>
			</div>
			<div class="report_resume">

				<?php 
				$total_advances = 0;
				$total_in_pays = 0;
				foreach ($query['advances'] as $key => $value) {
					$total_advances = $total_advances + $value['total'];

					$query_payments = $this->reports->get_total_pay_adv_client($value['id']);
					$total_in_pays = $total_in_pays + $query_payments->result_array()[0]['total_pays'];
				} ?>

				<?php 
				$total_amount_general_outgoes = 0;
				foreach ($query['general_outgoes'] as $key => $value) {
					$total_amount_general_outgoes = $total_amount_general_outgoes + $value['amount'];
				} ?>

				<?php 
				$total_regional_advances = 0;
				foreach ($query['regional_advances'] as $key => $value) {
					$total_regional_advances = $total_regional_advances + $value['amount'];
				} ?>

				<?php 
				$total_advance_suppliers = 0;
				$total_cash_supplier = 0;
				$total_credit_supplier = 0;
				$total_pay_credit_supplier = 0;
				foreach ($query['transactions'] as $key => $value) {
					if($value['method_id'] == 3) {
						$total_advance_suppliers = $total_advance_suppliers + $value['amount'];
					}
					if($value['method_id'] == 1) {
						$total_cash_supplier = $total_cash_supplier + $value['amount'];
					}
					if($value['method_id'] == 2) {
						$total_credit_supplier = $total_credit_supplier + $value['amount'];
						$query_credit_pay = $this->reports->get_pays_credit_suppliers($value['id']);
						if(!empty($query_credit_pay->result_array())){
							$total_pay_credit_supplier = $total_pay_credit_supplier + $query_credit_pay->result_array()[0]['total_pay'];
						}

					}
				} ?>

				<h2 style="text-align: center;">Resumen</h2>
				<hr>
				<div>					
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total en Venta:</strong> 
						<hr>
						<?= number_format($total_advances, 2, ",", "."); ?> COP
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total Recíbido en Pagos de Clientes:</strong> 
						<hr>
						<?= number_format($total_in_pays, 2, ",", "."); ?> COP
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total en Deuda de Clientes:</strong> 
						<hr>
						<?= number_format($total_advances - $total_in_pays, 2, ",", "."); ?> COP
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total en Gastos Generales:</strong> 
						<hr>
						<?= number_format($total_amount_general_outgoes, 2, ",", "."); ?> COP
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total en Avances Regionales:</strong> 
						<hr>
						<?= number_format($total_regional_advances, 2, ",", "."); ?> COP
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total Anticipo a Proveedores:</strong> 
						<hr>
						<?= number_format($total_advance_suppliers, 2, ",", "."); ?> COP
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total Contado a Proveedores:</strong> 
						<hr>
						<?= number_format($total_cash_supplier, 2, ",", "."); ?> COP
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total en Deuda a Proveedores:</strong> 
						<hr>
						<?= number_format($total_credit_supplier - $total_pay_credit_supplier, 2, ",", "."); ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Saldo Total:</strong> 
						<hr>
						<?= number_format($total_in_pays - $total_amount_general_outgoes - $total_regional_advances - $total_advance_suppliers - $total_cash_supplier, 2, ",", "."); ?>
					</div>

				</div>

			</div>
		

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Anticipos de Clientes</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_1" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">Cantidad</th>
									<th data-hide="phone,tablet">Producto enviado hasta hoy</th>
									<th data-hide="phone,tablet">Producto por enviar hasta hoy</th>
									<th data-hide="phone,tablet">Valor de Venta (COP)</th>
									<th data-hide="phone,tablet">Pago hasta hoy (COP)</th>
									<th data-hide="phone,tablet">Deuda hasta hoy (COP)</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['advances'] as $key => $value) {
									
									$query_payments = $this->reports->get_total_pay_adv_client($value['id']);
									$total_in_pays = $query_payments->result_array()[0]['total_pays'];

									$query_dispatches = $this->reports->get_total_in_dispatch_adv_client($value['id']);
									$total_in_dispatches = $query_dispatches->result_array()[0]['total_in_dispatches'];
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['product_name']; ?></td>
											<td><?= $value['quantity']; ?></td>
											<td><?= $total_in_dispatches ?></td>
											<td><?= $value['quantity']-$total_in_dispatches ?></td>
											<td><?= $value['total']; ?></td>
											<td><?= $total_in_pays; ?></td>
											<td><?= $value['total']-$total_in_pays; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Transacciones Proveedores</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_2" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-hide="phone,tablet">Proveedor</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Monto (COP)</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">Cantidad</th>
									<th data-hide="phone,tablet">Regional</th>
									<th data-hide="phone,tablet">Método de Pago</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['transactions'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= $value['supplier_name']?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['amount']?></td>
											<td><?= $value['product_name']; ?></td>
											<td><?= $value['quantity']; ?></td>
											<td><?= $value['regional_name']; ?></td>
											<td><?= $value['method_name']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-5" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Gastos Generales</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_4" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Monto (COP)</th>
									<th data-hide="phone,tablet">Tipo de gasto</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['general_outgoes'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['amount']?></td>
											<td><?= $value['type_outgo']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-6" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Anticipos a Regionales</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_5" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-hide="phone,tablet">Regional</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Monto (COP)</th>
									<th data-hide="phone,tablet">Dpto - Ciudad</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['regional_advances'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= $value['regional_name']?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['amount']?></td>
											<td><?= $value['department_name']." - ".$value['city_name']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->
			
		</div>
		<script>
			var html = $("#report_pdf").html();
			
			$("#html_data").val(html);
			tableReload(1);
			tableReload(2);
			/*tableReload(3);*/
			tableReload(4);
			tableReload(5);
		</script>
		<?php

	}

	public function bodega()
	{
		$this->load->model('Regionales_model', 'regionals');

		$regionals = $this->regionals->get_regionals();

		$dato['recursos'] = array(
				"regionals" => $regionals->result_array()
			);
		$dato['page'] = "report_storage";
		$dato['footer'] = array('report_storage');
		$this->load->view('home',$dato);
	}

	public function get_storage_report()
	{
		$startdate = $_POST['data']['startdate'];
		$finishdate = $_POST['data']['finishdate'];
		$regional_id = $_POST['data']['regional_id'];

		$query = $this->reports->get_storage_report($regional_id,$startdate,$finishdate);
			
		?>
		<div style="padding-top: 10px; padding-bottom: 10px;">
			<form id="report_form" action="<?= base_url() ?>reportes/export_report" method="post" target="_blank">
				<input type="hidden" name="html_data" id="html_data" value="">
			<button type="submit" class="btn btn-primary center-block">
				Reporte PDF
				<i class="fa fa-external-link"></i>
			</button>
			</form>
			
		</div>
		<div id="report_pdf">
			<div class="title">
				<h1>Reporte Bodega</h1>
				<?php if($regional_id == 0){ ?>
				<h3>Todos los regionales</h3>
				<?php } else { ?>
				<h3><?= $query['receptions'][0]['regional_name'] ?></h3>
				<?php } ?>
				<p>Desde: <?= ucfirst(strftime("%A %d-%m-%Y",strtotime($startdate))) ?> Hasta: <?= ucfirst(strftime("%A %d-%m-%Y",strtotime($finishdate))) ?></p>
			</div>
			<div class="report_resume">

				<?php 
					/*if($reception_id == 0) {
						$total_reception = 0;
						foreach ($query['receptions'] as $key => $value) {
							$total_reception = $total_reception + $value['quantity'];
						} 

						$total_dispatches = 0;
						foreach ($query['dispatches'] as $key => $value) {
							$total_dispatches = $total_dispatches + $value['quantity'];
						}
					}*/ 
				?>

				<!-- <h2 style="text-align: center;">Resumen</h2>
				<hr>
				<div>					
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total Producto Recibido:</strong> 
						<hr>
						<?= $total_reception ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total Producto Despachado:</strong> 
						<hr>
						<?= $total_dispatches ?>
					</div>
					<div class="col-lg-2 text-center" style="padding: 10px 5px 10px 5px;min-height: 150px;">
						<strong>Total en Bodega:</strong> 
						<hr>
						<?= $total_reception - $total_dispatches ?>
					</div>
					

				</div> -->

			</div>
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Recepciones</h2>
					
				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_1" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">Cantidad</th>
									<th data-hide="phone,tablet">Marcas</th>
									<th data-hide="phone,tablet">Trans. N°</th>
									<th data-hide="phone,tablet">Método de Pago</th>
									<th data-hide="phone,tablet">Frigorífico</th>
									<th data-hide="phone,tablet">Monto frigorífico (COP)</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 
								$this->load->model('Bodega_model', 'storage');
								foreach ($query['receptions'] as $key => $value) {

									$brands = $this->storage->get_brands_reception($value['id']);

									if(count($brands->result_array()) > 0){
										$receptions_brands = "";
										foreach ($brands->result_array() as $k => $v) {
											$receptions_brands .= $v['quantity']." ".$v['brand']."<br/>";
										}
									} else {
										$receptions_brands = "NULL";
									}


									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= ucfirst(strftime("%A %d-%m-%Y",strtotime($startdate))) ?></td>
											<td><?= $value['product_name']?></td>
											<td><?= $value['quantity']; ?></td>
											<td><?= $receptions_brands; ?></td>
											<td><?= $value['advance_supplier_id']; ?></td>
											<td><?= $value['method_name']; ?></td>
											<td><?= $value['shamble_name']; ?></td>
											<td><?= $value['shamble_amount']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->
	
		<?php if($regional_id == 0 || $regional_id == 1) { ?>

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Despachos a Clientes</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_2" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">Cantidad</th>
									<th data-hide="phone,tablet">ID Anticipo</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['dispatches'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['dispatch_date']))?></td>
											<td><?= $value['product_name']; ?></td>
											<td><?= $value['dispatch_quantity']; ?></td>
											<td><?= $value['advance_client_id']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

		<?php } ?>

		<?php if($regional_id != 0 && $regional_id != 1) { ?>

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Despachos Regionales</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">
						<table id="datatable_tabletools_2" class="table tableR table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th data-hide="phone">ID</th>
									<th data-class="expand">Fecha</th>
									<th data-hide="phone,tablet">Producto</th>
									<th data-hide="phone,tablet">Cantidad</th>
								</tr>
							</thead>
							<tbody id="tbody">

								<?php 

								foreach ($query['regional_dispatches'] as $key => $value) {
									?>
										<tr id="tr_<?= $value['id'] ?>">
											<td><?= $value['id']; ?></td>
											<td><?= strftime("%A %d-%m-%Y", strtotime($value['date']))?></td>
											<td><?= $value['product_name']; ?></td>
											<td><?= $value['quantity']; ?></td>
										</tr>
									<?php

								}											


								?>					
																				
							</tbody>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

		<?php } ?>
			
		</div>
		<script>
			var html = $("#report_pdf").html();
			
			$("#html_data").val(html);
			tableReload(1);
			tableReload(2);
		</script>
		<?php

	}

}

/* End of file Reportes.php */
/* Location: ./application/controllers/Reportes.php */