<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('latin_format_number'))
{
	function latin_format_number($number)
	{
		$number = number_format($number, 2, ',', '.');
		return $number;
	}
}