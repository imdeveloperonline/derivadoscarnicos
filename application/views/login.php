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
		
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>

		<script>
			function submitForm(data) {
				
				document.getElementById("login-form").submit();
			}
		</script> -->

		<style type="text/css">
			body {
				max-width: 100% !important;
				overflow-x: hidden;
			}

			#header > div {
			    display: inline-block;
			    vertical-align: middle;
			    height: 70px;
			    float: left;
			}

			#extr-page #header #logo {
			    margin-top: 6px;
			    margin-left: 0;
			}

			#logo-group > span {
			    display: inline-block;
			    height: 70px;
			    float: left;
			}

			#extr-page #header #logo img {
			    height: 58px;
			    width: auto;

			}

			#logo {
			    display: inline-block;
			    width: 175px;
			    margin-top: 13px;
			    margin-left: 9px;
			}

			#logo img {
			    width: auto;
			    height: 43px;
			    padding-left: 3px;
			}
		</style>
	</head>
	
	<body class="animated fadeInDown">

		<header id="header">

			<div id="logo-group">
				<span id="logo"> 
					<img src="<?= base_url() ?>assets/img/logo.png" alt="Derivados Cárnicos"> 
				</span>
			</div>

		</header>

		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div id="no-logged"></div>

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
						<h1 class="txt-color-red login-header-big">Derivados Cárnicos</h1>
						<div class="hero">

							<div class="pull-left login-desc-box-l">
								<h4 class="paragraph-header">Esta aplicación es de uso privado y sólo puede ser accedida por usuarios autorizados por la administración de la empresa.</h4>
								<br>
								<p><small>En caso de ser un usuario autorizado y tiene problemas para ingresar al sistema, por favor contacte a la administración para reportar el problema.</small></p>
							</div>
							
							<img src="<?= base_url() ?>assets/img/demo/iphoneview.png" class="pull-right display-image" alt="" style="width:210px">

						</div>

					</div>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
						
						<div class="well no-padding">

							<form action="javascript:send_form()" id="login-form" class="smart-form client-form">
								<header>
									Ingresar
								</header>

								<fieldset>
									
									<section>
										<label class="label">E-mail</label>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											<input type="email" name="email" required>
											<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Por favor ingrese un email</b></label>
									</section>

									<section>
										<label class="label">Contraseña</label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="password" required>
											<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Ingrese su contraseña</b> </label>
										<div class="note">
											<a data-toggle="modal" href="#myModal">¿Olvidó su contraseña?</a>
										</div>
									</section>

									<section>
										<label class="checkbox">
											<input type="checkbox" name="remember">
											<i></i>Continuar conectado</label>
									</section>
									<section>
										<div id="resultado"></div>
									</section>
								</fieldset>
								<footer>
									<!-- <button type="submit" id="button" class="btn btn-primary g-recaptcha" data-sitekey="6LcLS0cUAAAAABjNg-HRORQWh5WUlDnTDNlqmO-E" data-callback="submitForm">
										Ingresar
									</button> -->
									<button type="submit" id="button" class="btn btn-primary">
										Ingresar
									</button>
								</footer>
							</form>	

						</div>
						
							
						
					</div>
				</div>
			</div>

		</div>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close">
							&times;
						</button>
						<h4 class="modal-title">
							<img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="Derivados Cárnicos">
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="recover-password" class="smart-form" action="javascript:recover_password()">

							<fieldset>
								<section>
									<div class="row">
										<label class="label col col-2">E-mail</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="email" name="emailRecover">
											</label>
										</div>
									</div>
								</section>
							</fieldset>
							
							<footer>
								<button type="submit" class="btn btn-primary">
									Recuperar contraseña
								</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Cancelar
								</button>

							</footer>
						</form>						
								

					</div>

				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!--================================================== -->	

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script src="<?= base_url() ?>assets/js/plugin/pace/pace.min.js"></script>

	    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script> if (!window.jQuery) { document.write('<script src="<?= base_url() ?>assets/js/libs/jquery-3.2.1.min.js"><\/script>');} </script>

	    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script> if (!window.jQuery.ui) { document.write('<script src="<?= base_url() ?>assets/js/libs/jquery-ui.min.js"><\/script>');} </script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="<?= base_url() ?>assets/js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events 		
		<script src="<?= base_url() ?>assets/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

		<!-- BOOTSTRAP JS -->		
		<script src="<?= base_url() ?>assets/js/bootstrap/bootstrap.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="<?= base_url() ?>assets/js/plugin/jquery-validate/jquery.validate.min.js"></script>
		
		<!-- JQUERY MASKED INPUT -->
		<script src="<?= base_url() ?>assets/js/plugin/masked-input/jquery.maskedinput.min.js"></script>
		
		<!-- MAIN APP JS FILE -->
		<script src="<?= base_url() ?>assets/js/app.min.js"></script>

		<script src="<?= base_url() ?>assets/js/my.js"></script>

		

		<?php if($this->session->flashdata('no-logged')){

			?>

			<script>
				$(window).on("load",function(){
					setTimeout(function(){
						$('<div id="message" class="alert alert-block alert-warning"><p>Debe iniciar sesión</p></div>').appendTo('#no-logged').hide().fadeIn('slow');
					},600);					
				});
				
			</script>
			<?php

		} ?>

		

		<script>
			function send_form() {
				
				var params = {

					"email" : $('input[name="email"]').val(),
					"pass" : $('input[name="password"]').val()/*,
					"response": grecaptcha.getResponse()*/

				};
				
				if( document.getElementsByName('remember')[0].checked ) {
					params.remember = 1;
				}else {
					params.remember = 0;
				}

				$.ajax({										
					data: {data:params},
					url: '<?= base_url() ?>login/signin',
					type: 'post',
					beforeSend: function() {
						$("#button").html("<i class='fa fa-spinner fa-spin'></i>");
					},
					success: function(response) {						
                        $("#message").remove();
						$(response).appendTo('#resultado');
                      	$("#message").hide().fadeIn('slow');
         				$("#button").html("Ingresar");
         				/*grecaptcha.reset();*/

					},
					error:function(error){
					$("#message").remove();

					$('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p>'+JSON.stringify(error)+'</div>').appendTo('#resultado').hide().fadeIn('slow');
					$("#button").html("Ingresar");
					}

				});
			}

			function recover_password() {
				
				var e_params = {

					"email" : $('input[name="emailRecover"]').val()

				};

				$.ajax({										
					data: e_params,
					url: '<?= base_url() ?>login/recover_pass',
					type: 'post',
					success: function(response) {
         				$("#close").click();				
                        $("#message").remove(); 
                        setTimeout(function(){
                        	$(response).appendTo('#no-logged').hide().fadeIn('slow');
                        },700);
						
					}

				});

			}


		</script>

		<script type="text/javascript">
			runAllForms();

			$(function() {
				// Validation
				var errorClass = 'invalid';
		        var errorElement = 'em';		

				$("#login-form").validate({
		            errorClass    : errorClass,
		            errorElement  : errorElement,
		            highlight: function(element) {
		                $(element).parent().removeClass('state-success').addClass("state-error");
		                $(element).removeClass('valid');
		            },
		            unhighlight: function(element) {
		                $(element).parent().removeClass("state-error").addClass('state-success');
		                $(element).addClass('valid');
		            },
		            errorPlacement : function(error, element) {
		              error.insertAfter(element.parent());
		            }
		          }); 

				$("#recover-password").validate({
		            errorClass    : errorClass,
		            errorElement  : errorElement,
		            highlight: function(element) {
		                $(element).parent().removeClass('state-success').addClass("state-error");
		                $(element).removeClass('valid');
		            },
		            unhighlight: function(element) {
		                $(element).parent().removeClass("state-error").addClass('state-success');
		                $(element).addClass('valid');
		            },
		            errorPlacement : function(error, element) {
		              error.insertAfter(element.parent());
		            }
		          }); 
			});
		</script>

	</body>
</html>