<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saldo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Saldo_model", 'saldo');
	}

	public function index()
	{
		$query = $this->saldo->get_advances();

		?>

		<table>
			<thead>
				<tr>
					<th>Anticipo</th>
					<th>Proveedor</th>
					<th>Monto</th>
					<th>Precio Unitario</th>
					<th>Cantidad anticipo</th>
					<th>Cantidad recibida</th>
					<th>Saldo</th>
				</tr>
			</thead>
		<?php

		$n = 0;
		foreach ($query->result_array() as $key => $value) {
			
			$total_receptions_quantity = $this->saldo->get_receptions($value['id']);

			$saldo = (float) $value['amount'] - ( (float) $value['unit_price'] * (float) $total_receptions_quantity);

			$saldo = number_format($saldo, 2, '.', '');

			?>
			<tr style="border: 1px solid black;padding: 5px 10px; text-align: center;">
				<td style="border: 1px solid black;padding: 5px 10px; text-align: center;"><?= $value['id'] ?></td>
				<td style="border: 1px solid black;padding: 5px 10px; text-align: center;"><?= $value['supplier_id'] ?></td>
				<td style="border: 1px solid black;padding: 5px 10px; text-align: center;"><?= $value['amount'] ?></td>
				<td style="border: 1px solid black;padding: 5px 10px; text-align: center;"><?= $value['unit_price'] ?></td>
				<td style="border: 1px solid black;padding: 5px 10px; text-align: center;"><?= $value['quantity'] ?></td>
				<td style="border: 1px solid black;padding: 5px 10px; text-align: center;"><?= $total_receptions_quantity ?></td>
				<td style="border: 1px solid black;padding: 5px 10px; text-align: center;"><?= $saldo ?></td>
			</tr>

			<?php

			$insert = $this->saldo->set_saldo($value['supplier_id'], (float) $saldo);

			$saldo = "";

			if($insert) {
				$n++;
			}

		}


		?>
		</table>

		<p><?= $n ?></p>
		<?php
	}

	public function total()
	{
		$query = $this->saldo->get_saldo_inicial();

		?>

		<table>
			<thead>
				<tr>
					<th>Proveedor</th>
					<th>Saldo</th>
				</tr>
			</thead>
		<?php
		$n = 0;
		foreach ($query->result_array() as $key => $value) {
			
			$insert = $this->saldo->set_saldo_final($value['supplier_id'],$value['saldo']);

			?>
			<tr style="border: 1px solid black;padding: 5px 10px; text-align: center;">
				<td style="border: 1px solid black;padding: 5px 10px; text-align: center;"><?= $value['supplier_id'] ?></td>
				<td style="border: 1px solid black;padding: 5px 10px; text-align: center;"><?= $value['saldo'] ?>
			</tr>

			<?php

			if($insert) {
				$n++;
			}

		}

		?>
		</table>

		<p><?= $n ?></p>
		<?php
	}

}

/* End of file Saldo.php */
/* Location: ./application/controllers/Saldo.php */