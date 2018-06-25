<!-- PAGE FOOTER -->
		<div class="page-footer">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<span class="txt-color-white">Desarrollado por <span> <a href="http://www.imdeveloper.me" target="_blank"><i>ImDeveoper.me</i></a></span> </span>
				</div>

				<?php 
				$ci = &get_instance();
				$ci->load->model('Login_model','login');

				$query = $ci->login->get_last_login();

				 ?>

				<div class="col-xs-6 col-sm-6 text-right hidden-xs">
					<div class="txt-color-white inline-block">
						<i class="txt-color-blueLight">Última conexión <i class="fa fa-clock-o"></i> <strong><?php if(isset($query[0]['date'])) : echo $query[0]['date']; endif; ?> &nbsp;</strong> </i>
							
					</div>
				</div>

				<div class="col-xs-12 hidden-sm hidden-lg">
					<div class="txt-color-white inline-block">
						<i class="txt-color-blueLight">Última conexión <i class="fa fa-clock-o"></i> <strong><?php if(isset($query[0]['date'])) : echo $query[0]['date']; endif; ?> &nbsp;</strong> </i>
							
					</div>
				</div>
			</div>
		</div>
		
		<!--================================================== -->

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="<?= base_url() ?>assets/js/plugin/pace/pace.min.js"></script>

		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script>
			if (!window.jQuery) {
				document.write('<script src="<?= base_url() ?>assets/js/libs/jquery-3.2.1.min.js"><\/script>');
			}
		</script>

		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script>
			if (!window.jQuery.ui) {
				document.write('<script src="<?= base_url() ?>assets/js/libs/jquery-ui.min.js"><\/script>');
			}
		</script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="<?= base_url() ?>assets/js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="<?= base_url() ?>assets/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

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

		<!-- FastClick: For mobile devices -->
		<script src="<?= base_url() ?>assets/js/plugin/fastclick/fastclick.min.js"></script>

		<!-- MAIN APP JS FILE -->
		<script src="<?= base_url() ?>assets/js/app.min.js"></script>

		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
		<!-- Voice command : plugin -->
		<script src="<?= base_url() ?>assets/js/speech/voicecommand.min.js"></script>

		<!-- SmartChat UI : plugin -->
		<script src="<?= base_url() ?>assets/js/smart-chat-ui/smart.chat.ui.min.js"></script>
		<script src="<?= base_url() ?>assets/js/smart-chat-ui/smart.chat.manager.min.js"></script>

		<script src="<?= base_url() ?>assets/js/my.js?ver=1.1"></script>
		
		<?php echo $js ?>

		<script>

			$(function() {

				// DO NOT REMOVE : GLOBAL FUNCTIONS!
				pageSetUp();

				// FIX SELECT2 ON MODAL ISSUE
				$.fn.modal.Constructor.prototype.enforceFocus = function() {};

				
				 <?php echo $script ?>
				
				

			});

		</script>

		<?php if($_SESSION['profile'] == 1 || $_SESSION['profile'] == 2) { ?>
		<script>
			function set_regional(id) {
				$.ajax({
					data : {id:id},
					url: "<?= base_url() ?>login/set_regional",
					type : "post",
					success : function(response) {
						if(response == 1) {
							window.location.reload();
						} else {
							alert("Error al cambiar regional");
						}
					}

				});
			}

		</script>
		<?php } ?>
	</body>

</html>
