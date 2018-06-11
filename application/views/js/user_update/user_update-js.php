 <!-- PAGE RELATED PLUGIN(S) -->
		<script src="<?= base_url() ?>assets/js/plugin/jquery-form/jquery-form.min.js"></script>


		<script>
			
			function send_form () {

          var params = {
                "id" : $('input[name="id"]').val(),
                "name" : $('input[name="name"]').val(),
                "lastname" : $('input[name="lastname"]').val(),
                "phone" : $('input[name="phone"]').val(),
                "email" : $('input[name="email"]').val(),
                "position" : $('input[name="position"]').val(),
                "regional_id" : $('select[name="regional"]').val(),
                "user_profile_id" : $('select[name="profile"]').val()
            
          };
          
				 $.ajax({
                      data:  {data:params},
                      url:   '<?= base_url(); ?>usuarios/update_user',
                      type:  'post',
                      beforeSend: function () {
                              $("#button").html("<i class='fa fa-spinner fa-spin'></i>");
                      },
                      success:  function (response) {
                              $("#message").remove();
                              $(response).appendTo('#resultado');
                              $("#message").hide().fadeIn('slow');
                              $("#button").html("Guardar cambios");

                      },
                      error:function(error){
                        $("#message").remove();

                        $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');

                        $("#buttonChanges").html("Guardar cambios");
                      }
              });

			}

		</script>
       

