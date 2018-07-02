 <!-- PAGE RELATED PLUGIN(S) -->
		<script src="<?= base_url() ?>assets/js/plugin/jquery-form/jquery-form.min.js"></script>


		<script>
        $(".btn-person").hide();
      
        function actionButtons(n,edit){

          $("#buttonCancel"+n).toggle();
          $("#buttonEdit"+n).toggle();
          $("#buttonChanges"+n).toggle();
          $("#buttonDeleted"+n).toggle();

          if(edit == 1){
            $("input[name='person_name"+n+"']").prop('disabled',false);
            $("input[name='person_lastname"+n+"']").prop('disabled',false);
            $("input[name='person_phone"+n+"']").prop('disabled',false);
            $("input[name='person_email"+n+"']").prop('disabled',false);
            $("input[name='person_position"+n+"']").prop('disabled',false);
          }else if (edit == 2) {
            $("input[name='person_name"+n+"']").prop('disabled',true);
            $("input[name='person_lastname"+n+"']").prop('disabled',true);
            $("input[name='person_phone"+n+"']").prop('disabled',true);
            $("input[name='person_email"+n+"']").prop('disabled',true);
            $("input[name='person_position"+n+"']").prop('disabled',true);

            $("input[name='person_name"+n+"']").removeClass('valid invalid');
            $("input[name='person_lastname"+n+"']").removeClass('valid invalid');
            $("input[name='person_phone"+n+"']").removeClass('valid invalid');
            $("input[name='person_email"+n+"']").removeClass('valid invalid');
            $("input[name='person_position"+n+"']").removeClass('valid invalid');
            $(".input").removeClass('state-success state-error');
          } else {
            
            $("input[name='person_name"+n+"']").prop('disabled',true);
            $("input[name='person_lastname"+n+"']").prop('disabled',true);
            $("input[name='person_phone"+n+"']").prop('disabled',true);
            $("input[name='person_email"+n+"']").prop('disabled',true);
            $("input[name='person_position"+n+"']").prop('disabled',true);

            $( ".person-form" ).validate().resetForm();

            $("input[name='person_name"+n+"']").removeClass('valid invalid');
            $("input[name='person_lastname"+n+"']").removeClass('valid invalid');
            $("input[name='person_phone"+n+"']").removeClass('valid invalid');
            $("input[name='person_email"+n+"']").removeClass('valid invalid');
            $("input[name='person_position"+n+"']").removeClass('valid invalid');
            $(".input").removeClass('state-success state-error');
          
          }
        }
        
        function validForm(n) {

          form = $("#update-person-form"+n);

          var errorClass = 'invalid';
          var errorElement = 'em';

          form.validate({
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

         if(form.valid()){
            form.submit();            
         }

        }

			
			function update_person (n) {

          var params = {
                "id" : $('input[name="person_id'+n+'"]').val(),
                "name" : $('input[name="person_name'+n+'"]').val(),
                "lastname" : $('input[name="person_lastname'+n+'"]').val(),
                "phone" : $('input[name="person_phone'+n+'"]').val(),
                "email" : $('input[name="person_email'+n+'"]').val(),
                "position" : $('input[name="person_position'+n+'"]').val()
            
          };
          
				 $.ajax({
                      data:  {data:params},
                      url:   '<?= base_url(); ?>frigorificos/update_shamble_person',
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
        var client_id = $('input[name="person_id'+n+'"]').val();

        $('input[name="person_delete"]').val(client_id);
        $('input[name="person_delete_n"]').val(n);

      }
    </script>
    <script>
      function delete_person() {
        

        var params = {
          "id" : $('input[name="person_delete"]').val()
        }

        var n = $('input[name="person_delete_n"]').val()

        $.ajax({
              data:  {data:params},
              url:   '<?= base_url(); ?>frigorificos/delete_shamble_person',
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
      
      function new_person(shamble_id) {

          var params = {

                "name" : $('input[name="person_name"]').val(),
                "lastname" : $('input[name="person_lastname"]').val(),
                "phone" : $('input[name="person_phone"]').val(),
                "email" : $('input[name="person_email"]').val(),
                "position" : $('input[name="person_position"]').val()
            
          };
          
         $.ajax({
                data:  {data:params},
                url:   '<?= base_url(); ?>frigorificos/new_person_shamble/'+shamble_id,
                type:  'post',
                beforeSend: function () {
                        $("#buttonNewPerson").html("<i class='fa fa-spinner fa-spin'></i>");
                },
                success:  function (response) {
                        $("#message").remove();
                        $(response).appendTo('#resultado');
                        $("#message").hide().fadeIn('slow');
                        $("#buttonNewPerson").html("Registrar");
                        $("#close-modal-new-person").click();

                },
                error:function(error){
                  $("#message").remove();

                  $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');

                  $("#buttonNewPerson").html("Registrar");
                  $("#close-modal-new-person").click();
                }
        });

      }


    </script>

