    <!-- PAGE RELATED PLUGIN(S) -->
		<script src="js/plugin/jquery-form/jquery-form.min.js"></script>


		<script>
			
			function send_form() {

				var parametros = {
                      "name" : $('input[name="fname"]').val(),
                      "lastname" : $('input[name="lname"]').val(),
                      "email" : $('input[name="email"]').val(),
                      "phone" : $('input[name="phone"]').val(),
                      "regional_id" : $('select[name="regional"]').val(),
                      "position" : $('input[name="position"]').val(),
                      "user_profile_id" : $('select[name="profile"]').val(),
                      "pass" : $('input[name="password"]').val()
              };
				 $.ajax({
                      data:  {array:parametros},
                      url:   '<?= base_url(); ?>usuarios/new_user',
                      type:  'post',
                      beforeSend: function () {
                              $("#button").html("<i class='fa fa-spinner fa-spin'></i>");
                      },
                      success:  function (response) {
                              $("#resultado").html(response);
                              $("#button").html("Cargar formulario");
                      }
              });

			}

		</script>