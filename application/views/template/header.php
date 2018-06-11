<?php if(!isset($_COOKIE['SID_ADM_APP'])) {
	redirect('login');
	exit();
} 

header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_ALL,"es_ES.UTF-8");
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> Derivados Cárnicos </title>
		<meta name="description" content="">
		<meta name="author" content="">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/font-awesome.min.css">

		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/smartadmin-production-plugins.min.css">		
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/smartadmin-skins.css">
<!-- SmartAdmin RTL Support  -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css">

		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/demo.min.css">

		<!-- FAVICONS -->
		<link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?= base_url() ?>assets/img/favicon/favicon.ico" type="image/x-icon">

		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/prettyPhoto.css">
		<!-- GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/my.css">


		
		<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">

	</head>
	<body class="">
		<!-- possible classes: minified, fixed-ribbon, fixed-header, fixed-width-->

		<!-- HEADER -->
		<header id="header">
			<div id="logo-group">

				<!-- PLACE YOUR LOGO HERE -->
				<span id="logo">
					<img src="<?= base_url() ?>assets/img/logo.png" alt="Derivados Cárnicos"> 
				</span>
				<!-- END LOGO PLACEHOLDER -->

				
			</div>

			<!-- pulled right: nav area -->
			<div class="pull-right">

				<!-- collapse menu button -->
				<div id="hide-menu" class="btn-header pull-right">
					<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- end collapse menu -->

				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> <a href="<?= base_url() ?>login/logout" title="Salir" data-action="userLogout" data-logout-title="¿Desea Salir?" data-logout-msg=" "><i class="fa fa-sign-out"></i></a> </span>
				</div>
				<!-- end logout button -->

				<!-- logout button -->
				<div id="back" class="btn-header transparent pull-right">
					<span> <a href="javascript:history.back()" title="Volver"><i class="fa fa-undo"></i></a> </span>
				</div>
				<!-- end logout button -->
				<?php 						
				$ci = &get_instance();
				$ci->load->model('Regionales_model','regionals');
				$query = $ci->regionals->get_regionals();
				$regionals = "";
				foreach ($query->result_array() as $key => $value) {
					if($value['id'] == $_SESSION['regional']) {
						$regional_name = $value['name'];
					}

					$regionals .= '<li><a href="javascript:set_regional('. $value['id'] .');"> '. $value['name'] .'</a></li>';
				}

				 ?>
				<div class="project-context">

					<span class="label">Regional</span>
					<span class="project-selector" style="cursor: default;"><?php if(isset($regional_name)) : echo $regional_name; else : echo $_SESSION['regional_name']; endif; ?></span>

				</div>
				
				<?php if(in_array($_SESSION['profile'],array(1,2))) { ?>
				<!-- multiple lang dropdown : find all flags in the flags page -->
				<ul class="header-dropdown-list">
					<li>
						
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span> <?= $regional_name ?>  </span> <i class="fa fa-angle-down"></i> </a>
						<ul class="dropdown-menu pull-right">

							<?= $regionals; ?>			
							
						</ul>
					</li>
				</ul>
				<!-- end multiple lang -->
				<?php } ?>
			</div>
			<!-- end pulled right: nav area -->

		</header>
		<!-- END HEADER -->