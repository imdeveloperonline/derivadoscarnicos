<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model', 'dashboardmod');
		if(!isset($_SESSION['logged']) || $_SESSION['logged'] != TRUE) {
			redirect("login/logout");
		}
	}

	public function index()
	{
		$query = $this->dashboardmod;

		$data['recursos'] = array(
				"january" => array(

					"ingresos" => $query->get_ingresos("01")->result_array(),
					"egresos" => $query->get_egresos("01")->result_array()

				),
				"february" => array(

					"ingresos" => $query->get_ingresos("02")->result_array(),
					"egresos" => $query->get_egresos("02")->result_array()

				),
				"march" => array(

					"ingresos" => $query->get_ingresos("03")->result_array(),
					"egresos" => $query->get_egresos("03")->result_array()

				),
				"april" => array(

					"ingresos" => $query->get_ingresos("04")->result_array(),
					"egresos" => $query->get_egresos("04")->result_array()

				),
				"may" => array(

					"ingresos" => $query->get_ingresos("05")->result_array(),
					"egresos" => $query->get_egresos("05")->result_array()

				),
				"june" => array(

					"ingresos" => $query->get_ingresos("06")->result_array(),
					"egresos" => $query->get_egresos("06")->result_array()

				),
				"july" => array(

					"ingresos" => $query->get_ingresos("07")->result_array(),
					"egresos" => $query->get_egresos("07")->result_array()

				),
				"august" => array(

					"ingresos" => $query->get_ingresos("08")->result_array(),
					"egresos" => $query->get_egresos("08")->result_array()

				),
				"september" => array(

					"ingresos" => $query->get_ingresos("09")->result_array(),
					"egresos" => $query->get_egresos("09")->result_array()

				),
				"october" => array(

					"ingresos" => $query->get_ingresos("10")->result_array(),
					"egresos" => $query->get_egresos("10")->result_array()

				),
				"november" => array(

					"ingresos" => $query->get_ingresos("11")->result_array(),
					"egresos" => $query->get_egresos("11")->result_array()

				),
				"december" => array(

					"ingresos" => $query->get_ingresos("12")->result_array(),
					"egresos" => $query->get_egresos("12")->result_array()

				),
				"map_dispatch" => $query->get_dispatches_by_department(),
				"map_outgoes" => $query->get_outgoes_by_department(),
				"data_pie" => $query->get_outgoes_by_types()

			);

		$data['page'] = "dashboard";
		$data['footer'] = array("dashboard");
		$this->load->view('home',$data);
	}

}