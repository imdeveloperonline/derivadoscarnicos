<!DOCTYPE html>
<html lang="es" id="extr-page">
	<head>
		<meta charset="utf-8">
		<title> Derivados Cárnicos</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- #CSS Links -->
		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/smartadmin-rtl.min.css"> 

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?= base_url() ?>assets/img/favicon/favicon.ico" type="image/x-icon">

		<!-- #GOOGLE FONT -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">


	</head>
	<body id="login" class="animated fadeInDown">
		<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
		<header id="header">
			<!--<span id="logo"></span>-->

			<div id="logo-group">
				<span id="logo"> <img src="<?= base_url() ?>assets/img/logo.png" alt="Derivados Cárnicos"> </span>

				<!-- END AJAX-DROPDOWN -->
			</div>

			

		</header>
		
		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div id="no-logged"></div>

				

				<div class="row">
					
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
						<div class="well no-padding">
							<form action="javascript:recover_password()" id="recover-password" class="smart-form client-form">
								<header>
									Recuperar Contraseña
								</header>

								<fieldset>
									
									<section>
										<label class="label">Nueva Contraseña</label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="password" id="password">
											</label>
									</section>

									<section>
										<label class="label">Confirme Su Nueva Contraseña</label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="passwordConfirm">
											 </label>
									</section>
									<section>
										<div id="resultado"></div>
									</section>
								</fieldset>
								<footer>
									<button type="submit" id="button" class="btn btn-primary">
										Recuperar contraseña
									</button>
								</footer>
							</form>



						</div>
						
					</div> <!-- End form -->
				</div>
			</div>

		</div> <!-- END MAIN -->

		<!--================================================== -->	

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="<?= base_url() ?>assets/js/plugin/pace/pace.min.js"></script>-->

	    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script> if (!window.jQuery) { document.write('<script src="<?= base_url() ?>assets/js/libs/jquery-2.0.2.min.js"><\/script>');} </script>

	    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script> if (!window.jQuery.ui) { document.write('<script src="<?= base_url() ?>assets/js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events 		
		<script src="<?= base_url() ?>assets/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

		<!-- BOOTSTRAP JS -->		
		<script src="<?= base_url() ?>assets/js/bootstrap/bootstrap.min.js"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="<?= base_url() ?>assets/js/notification/SmartNotification.min.js"></script>

		<!-- JARVIS WIDGETS -->
		<script src="<?= base_url() ?>assets/js/smartwidgets/jarvis.widget.min.js"></script>
		
		<!-- EASY PIE CHARTS -->
		<script src="<?= base_url() ?>assets/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
		
		<!-- SPARKLINES -->
		<script src="<?= base_url() ?>assets/js/plugin/sparkline/jquery.sparkline.min.js"></script>
		
		<!-- JQUERY VALIDATE -->
		<script src="<?= base_url() ?>assets/js/plugin/jquery-validate/jquery.validate.min.js"></script>
		
		<!-- JQUERY MASKED INPUT -->
		<script src="<?= base_url() ?>assets/js/plugin/masked-input/jquery.maskedinput.min.js"></script>
		
		<!-- JQUERY SELECT2 INPUT -->
		<script src="<?= base_url() ?>assets/js/plugin/select2/select2.min.js"></script>

		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="<?= base_url() ?>assets/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>
		
		<!-- browser msie issue fix -->
		<script src="<?= base_url() ?>assets/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>
		
		<!-- SmartClick: For mobile devices -->
		<script src="<?= base_url() ?>assets/js/plugin/smartclick/smartclick.js"></script>
		
		<!--[if IE 7]>
			
			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
			
		<![endif]-->

		<!-- MAIN APP JS FILE -->
		<script src="<?= base_url() ?>assets/js/app.js"></script>				

		<script>
			

			function recover_password() {

				var params = {

					"pass" : $('input[name="password"]').val()

				};

				$.ajax({										
					data: params,
					url: '<?= base_url() ?>login/set_new_pass/' + '<?= $recover_info[0];?>' + '/' + '<?= $recover_info[1];?>',
					type: 'post',
					beforeSend: function() {
						$("#button").html("<i class='fa fa-spinner fa-spin'></i>");
					},
					success: function(response) {						
                        $("#message").remove();
						$(response).appendTo('#no-logged').hide().fadeIn('400');
						setTimeout(function(){
							location.href = '<?= base_url() ?>';
						},5000);
						$("#button").html("Recuperar contraseña");
					}

				});

			}


		</script>

		<script type="text/javascript">
			runAllForms();

			$(function() {
				// Validation

				$("#recover-password").validate({
					// Rules for form validation
					rules : {
						password : {
							required : true,
							minlength : 3,
							maxlength : 20
						},
						passwordConfirm :{
							required : true,
							minlength : 3,
							maxlength : 20,
							equalTo : '#password'
						}
					},

					// Messages for form validation
					messages : {
						password : {
							required : 'Debe ingresar una contraseña',
							minlength : 'La contraseña debe tener por lo menos 3 caracteres',
							maxlength : 'La contraseña puede tener máximo 20 caracteres'
						},
						passwordConfirm : {
							required : 'Debe confirmar su contraseña',
							equalTo : 'Las contraseñas no coinciden'
						}
					},

					// Do not change code below
					errorPlacement : function(error, element) {
						error.insertAfter(element.parent());
					}
				});
			});
		</script>

	</body>
</html>