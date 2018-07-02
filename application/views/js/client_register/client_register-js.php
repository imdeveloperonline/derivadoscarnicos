 <!-- PAGE RELATED PLUGIN(S) -->
		<script src="<?= base_url() ?>assets/js/plugin/jquery-form/jquery-form.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.tmpl.js"></script>


		<script>
      
			
			function send_form() {

          var params = {

            client : {
                "tradename" : $('input[name="tradename"]').val(),
                "rut" : $('input[name="rut"]').val(),
                "phone" : $('input[name="phone"]').val(),
                "email" : $('input[name="email"]').val(),
                "address" : $('input[name="address"]').val(),
                "zip" : $('input[name="zip"]').val(),
                "city_id" : $('select[name="city"]').val()
            }
          };

          /*** Construimos array de las personas de contacto ***/
          var childs = $("#person_client").children("fieldset").size();

          params['person_client'] = {};

          for (var i = 0; i < childs; i++) {
            array = {
              [i] : {
                "name" : $("input[name='person_name"+i+"']").val(),
                "lastname" : $("input[name='person_lastname"+i+"']").val(),
                "phone" : $("input[name='person_phone"+i+"']").val(),
                "email" : $("input[name='person_email"+i+"']").val(),
                "position" : $("input[name='person_position"+i+"']").val(),
              }  
            };

            params['person_client'] = $.extend(array,params['person_client']);

             if(i == 0 && $("input[name='person_name"+i+"']").val() == "" && $("input[name='person_lastname"+i+"']").val() == "" && $("input[name='person_phone"+i+"']").val() == "" && $("input[name='person_email"+i+"']").val() == "" && $("input[name='person_position"+i+"']").val() == "") {

              params['person_client'] = "";

            }
            
          }

          params['send_address'] = {};

          for (var i = 0; i < childs; i++) {
            array = {
              [i] : {
                "address" : $("input[name='send_address"+i+"']").val(),
                "zip" : $("input[name='send_zip"+i+"']").val(),
                "city_id" : $("select[name='send_city"+i+"']").val()
              }  
            };

            params['send_address'] = $.extend(array,params['send_address']);

             if(i == 0 && $("input[name='send_address"+i+"']").val() == "" && $("input[name='send_zip"+i+"']").val() == "" && $("input[name='send_city"+i+"']").val() == "") {

              params['send_address'] = "";

            }
            
          }
          
				 $.ajax({
                      data:  {data:params},
                      url:   '<?= base_url(); ?>clientes/set_new_client',
                      type:  'post',
                      beforeSend: function () {
                              $("#button").html("<i class='fa fa-spinner fa-spin'></i>");
                      },
                      success:  function (response) {
                              $("#message").remove();
                              $(response).appendTo('#resultado').hide().fadeIn('slow');
                              $("#button").html("Registrar");

                      },
                      error:function(error){
                        $("#message").remove();

                        $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p><p>Será redirigido a la lista de clientes registrados. Verifique si el registro se guardó y haga los cambios de ser necesario.</p><p>'+JSON.stringify(error)+'</p></div>').appendTo('#resultado').hide().fadeIn('slow');

                        $("#button").html("Registrar");
                        /*location.href="<?= base_url() ?>clientes";*/
                      }
              });

			}

		</script>
    
    <script>
                
      $(document).ready(function(){

        $("#addPerson").click(function(){
          var childs = $("#person_client").children("fieldset").size();
          var i = { num : childs };

          $.get("<?= base_url() ?>assets/templates/person_client.html", function(template){
            
            $.tmpl(template,i).appendTo("#person_client");

          });      

        });

      });

      $(document).ready(function(){
        <?php 
          $ciudades = "";
          foreach ($datos as $key => $value) {
            $ciudades .= '<option value="' . $value['id'] . '">' . $value['name'] .'</option>';
          } ?>

        $("#addAddress").click(function(){
          var childs = $("#send_address").children("fieldset").size();
          
          var cities = '<?php echo $ciudades; ?>';
          
          var i = { num : childs };


          $.get("<?= base_url() ?>assets/templates/send_address_client.html", function(template){
            
            $.tmpl(template,i).appendTo("#send_address");

          });  

          $('<?= $ciudades ?>').appendTo("select[name=send_city"+childs+"]");    

        });

      });
      /********* Estilo MouserOver Boton Add *********/
      $(".fa-plus-circle").css("cursor","pointer");

    </script>

    <script>

      $(document).ready(function() {
        jQuery.extend(jQuery.validator.messages, {
          required: "Este campo es obligatorio.",
          remote: "Por favor, rellena este campo.",
          email: "Por favor, escribe una dirección de correo válida",
          url: "Por favor, escribe una URL válida.",
          date: "Por favor, escribe una fecha válida.",
          dateISO: "Por favor, escribe una fecha (ISO) válida.",
          number: "Por favor, escribe un número entero válido.",
          digits: "Por favor, escribe sólo dígitos.",
          creditcard: "Por favor, escribe un número de tarjeta válido.",
          equalTo: "Por favor, escribe el mismo valor de nuevo.",
          accept: "Por favor, escribe un valor con una extensión aceptada.",
          maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
          minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
          rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
          range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
          max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
          min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
        });
      });
      

        $("#checkout-form").validate({
          errorPlacement : function(error, element) {
            error.insertAfter(element.parent());
          }
        });

        
      
    </script>
