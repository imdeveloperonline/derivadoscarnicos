 <!-- PAGE RELATED PLUGIN(S) -->
		<script src="<?= base_url() ?>assets/js/plugin/jquery-form/jquery-form.min.js"></script>


		<script>
        $(".btn-address").hide();
      
        function actionButtons(n,edit){

          $("#buttonCancel"+n).toggle();
          $("#buttonEdit"+n).toggle();
          $("#buttonChanges"+n).toggle();
          $("#buttonDeleted"+n).toggle();

          if(edit == 1){
            $("input[name='address"+n+"']").prop('disabled',false);
            $("input[name='zip"+n+"']").prop('disabled',false);
            $("select[name='city"+n+"']").prop('disabled',false);
          }else if (edit == 2) {
            $("input[name='address"+n+"']").prop('disabled',true);
            $("input[name='zip"+n+"']").prop('disabled',true);
            $("select[name='city"+n+"']").prop('disabled',true);

            $("input[name='address"+n+"']").removeClass('valid invalid');
            $("input[name='zip"+n+"']").removeClass('valid invalid');
            $("select[name='city"+n+"']").removeClass('valid invalid');

            $(".input").removeClass('state-success state-error');
             $(".select").removeClass('state-success state-error');
          } else {
            
            $("input[name='address"+n+"']").prop('disabled',true);
            $("input[name='zip"+n+"']").prop('disabled',true);
            $("select[name='city"+n+"']").prop('disabled',true);

            $( ".address-form" ).validate().resetForm();

            $("input[name='address"+n+"']").removeClass('valid invalid');
            $("input[name='zip"+n+"']").removeClass('valid invalid');
            $("select[name='city"+n+"']").removeClass('valid invalid');

            $(".input").removeClass('state-success state-error');
            $(".select").removeClass('state-success state-error');

            $("#append_message"+n).fadeOut('400').remove();
            $("#location"+n).fadeIn('400');
          
          }
        }
        
        function validForm(n) {
          
          form = $("#new-address-client-form"+n);

          var errorClass = 'invalid';
          var errorElement = 'em';

          form.validate({
            errorClass    : errorClass,
            errorElement  : errorElement,
            ignore : [],
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

         if(form.valid()){
            form.submit();            
         }

        }

			
			function update_address (n) {
          
          var params = {
                "id" : $('input[name="address_id'+n+'"]').val(),
                "address" : $('input[name="address'+n+'"]').val(),
                "zip" : $('input[name="zip'+n+'"]').val(),
                "city_id" : $('select[name="city'+n+'"]').val()
            
          };
          
				 $.ajax({
                      data:  {data:params},
                      url:   '<?= base_url(); ?>clientes/update_client_address',
                      type:  'post',
                      beforeSend: function () {
                              $("#buttonChanges"+n+"").html("<i class='fa fa-spinner fa-spin'></i>");
                      },
                      success:  function (response) {
                              $("#message").remove();
                              $(response).appendTo('#resultado');
                              $("#message").hide().fadeIn('slow');
                              $("#buttonChanges"+n+"").html("Guardar cambios");
                              actionButtons(n,2);

                      },
                      error:function(error){
                        $("#message").remove();

                        $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');

                        $("#buttonChanges").html("Guardar cambios");
                        actionButtons(n,0);
                      }
              });

			}

		</script>

    <script>
      function set_modal (n) {
        var address_id = $('input[name="address_id'+n+'"]').val();

        $('input[name="address_delete"]').val(address_id);
        $('input[name="address_delete_n"]').val(n);

      }
    </script>
    <script>
      function delete_address() {
        

        var params = {
          "id" : $('input[name="address_delete"]').val()
        }

        var n = $('input[name="address_delete_n"]').val()

        $.ajax({
              data:  {data:params},
              url:   '<?= base_url(); ?>clientes/delete_client_address',
              type:  'post',
              success:  function (response) {
                      $("#message").remove();
                      $(response).appendTo('#resultado');
                      $("#message").hide().fadeIn('slow');
                      $("#close").click();
                      $("#article"+n).fadeOut('slow');
              },
              error:function(error){
                $("#message").remove();

                $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');

                $("#close").click();
              }
        });

      }
    </script>

    <script>
      
      function new_address_client(client_id) {

          var params = {

                "address" : $('input[name="address"]').val(),
                "zip" : $('input[name="zip"]').val(),
                "city_id" : $('select[name="city"]').val()
            
          };
          
         $.ajax({
                data:  {data:params},
                url:   '<?= base_url(); ?>clientes/new_address_client/'+client_id,
                type:  'post',
                beforeSend: function () {
                        $("#buttonNewAddress").html("<i class='fa fa-spinner fa-spin'></i>");
                },
                success:  function (response) {
                        $("#message").remove();
                        $(response).appendTo('#resultado');
                        $("#message").hide().fadeIn('slow');
                        $("#buttonNewAddress").html("Registrar");
                        $("#close-modal-new-address").click();

                },
                error:function(error){
                  $("#message").remove();

                  $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');

                  $("#buttonNewPerson").html("Registrar");
                  $("#close-modal-new-address").click();
                }
        });

      }


    </script>

    <script>
      
      function location_message(n) {
          var message = "<section id='append_message"+n+"'><strong>Nota:</strong> La información del <strong>departamento</strong> y <strong>país</strong> son agregados automáticamente al guardar la ciudad correspondiente.</section>";

          $("#location"+n).fadeOut('400', function() {
            $(message).appendTo("#location_message"+n).hide().fadeIn('400');
          });
          
      }
    </script>

