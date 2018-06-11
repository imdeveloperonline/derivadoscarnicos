<?php
$this->load->library('ciqrcode');
$qr_image=rand().'.png';
$params['data'] = "http://imdeveloper.me";
$params['level'] = 'H';
$params['size'] = 8;
$params['savename'] =FCPATH."assets/uploads/".$qr_image;
if($this->ciqrcode->generate($params))
{
	$qr = $qr_image;
}