<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Pdf {

	public function __construct()

	{

		$CI = &get_instance();

		log_message('Debug', 'mPDF class is loaded.');

	}

	public function load()

	{

		include_once APPPATH.'third_party/mpdf/vendor/autoload.php';

		return new Mpdf\Mpdf();

	}

}