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
            $("input[name='name"+n+"']").prop('disabled',false);
            $("input[name='rut"+n+"']").prop('disabled',false);
            $("input[name='bank"+n+"']").prop('disabled',false);
            $("input[name='center"+n+"']").prop('disabled',false);
            $("input[name='account"+n+"']").prop('disabled',false);
            $("input[name='type_account"+n+"']").prop('disabled',false);
            $("input[name='location"+n+"']").prop('disabled',false);
          }else if (edit == 2) {
            $("input[name='name"+n+"']").prop('disabled',true);
            $("input[name='rut"+n+"']").prop('disabled',true);
            $("input[name='bank"+n+"']").prop('disabled',true);
            $("input[name='center"+n+"']").prop('disabled',true);
            $("input[name='account"+n+"']").prop('disabled',true);
            $("input[name='type_account"+n+"']").prop('disabled',true);
            $("input[name='location"+n+"']").prop('disabled',true);

            $("input[name='name"+n+"']").removeClass('valid invalid');
            $("input[name='rut"+n+"']").removeClass('valid invalid');
            $("input[name='bank"+n+"']").removeClass('valid invalid');
            $("input[name='center"+n+"']").removeClass('valid invalid');
            $("input[name='account"+n+"']").removeClass('valid invalid');
            $("input[name='type_account"+n+"']").removeClass('valid invalid');
            $("input[name='location"+n+"']").removeClass('valid invalid');

            $(".input").removeClass('state-success state-error');
          } else {
            
            $("input[name='name"+n+"']").prop('disabled',true);
            $("input[name='rut"+n+"']").prop('disabled',true);
            $("input[name='bank"+n+"']").prop('disabled',true);
            $("input[name='center"+n+"']").prop('disabled',true);
            $("input[name='account"+n+"']").prop('disabled',true);
            $("input[name='type_account"+n+"']").prop('disabled',true);
            $("input[name='location"+n+"']").prop('disabled',true);

            $( "#update-form"+n ).validate().resetForm();

            $("input[name='name"+n+"']").removeClass('valid invalid');
            $("input[name='rut"+n+"']").removeClass('valid invalid');
            $("input[name='bank"+n+"']").removeClass('valid invalid');
            $("input[name='center"+n+"']").removeClass('valid invalid');
            $("input[name='account"+n+"']").removeClass('valid invalid');
            $("input[name='type_account"+n+"']").removeClass('valid invalid');
            $("input[name='location"+n+"']").removeClass('valid invalid');
            $(".input").removeClass('state-success state-error');
          
          }
        }
        
        function validForm(n) {

          form = $("#update-form"+n);

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

			
			function update (n,target) {

        if(target == 1) {
          var t = "update_supplier_bank";
        } 
        if(target == 2) {
          var t = "update_supplier_center";
        }

          var params = {
                "id" : $('input[name="id'+n+'"]').val(),
                "name" : $('input[name="name'+n+'"]').val(),
                "rut" : $('input[name="rut'+n+'"]').val(),
                "bank" : $('input[name="bank'+n+'"]').val(),
                "account" : $('input[name="account'+n+'"]').val(),
                "type_account" : $('input[name="type_account'+n+'"]').val(),
                "center" : $('input[name="center'+n+'"]').val(),
                "location" : $('input[name="location'+n+'"]').val()
            
          };
          
				 $.ajax({
                      data:  {data:params},
                      url:   '<?= base_url(); ?>proveedores/'+t,
                      type:  'post',
                      beforeSend: function () {
                              $("#buttonChanges"+n+"").html("<i class='fa fa-spinner fa-spin'></i>");
                      },
                      success:  function (response) {
                              $("#message").remove();
                              $(response).appendTo('#resultado-'+target);
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
        var id = $('input[name="id'+n+'"]').val();

        $('input[name="registry_delete"]').val(id);
        $('input[name="registry_delete_n"]').val(n);

      }
    </script>
    <script>
      function delete_registry() {

        var params = {
          "id" : $('input[name="registry_delete"]').val()
        }

        var n = $('input[name="registry_delete_n"]').val();

        var type_registry = $('input[name="type_registry'+n+'"]').val();

        if(type_registry == 1) {
          var t = "delete_supplier_bank";
        }

        if(type_registry == 2) {
          var t = "delete_supplier_center";
        }
       
        
        $.ajax({
              data:  {data:params},
              url:   '<?= base_url(); ?>proveedores/'+t,
              type:  'post',
              success:  function (response) {
                      $("#message").remove();
                      $(response).appendTo('#resultado-'+type_registry);
                      $("#message").hide().fadeIn('slow');
                      $("#close").click();
                      $("#article-"+n).fadeOut('slow');
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
      
      function new_bank(supplier_id) {

          var params = {

                "name" : $('input[name="name"]').val(),
                "rut" : $('input[name="rut"]').val(),
                "bank" : $('input[name="bank"]').val(),
                "account" : $('input[name="account"]').val(),
                "type_account" : $('input[name="type_account"]').val()
            
          };
          
         $.ajax({
                data:  {data:params},
                url:   '<?= base_url(); ?>proveedores/new_bank_supplier/'+supplier_id,
                type:  'post',
                beforeSend: function () {
                        $("#buttonNewBank").html("<i class='fa fa-spinner fa-spin'></i>");
                },
                success:  function (response) {
                        $("#message").remove();
                        $(response).appendTo('#resultado-1');
                        $("#message").hide().fadeIn('slow');
                        $("#buttonNewBank").html("Registrar");
                        $("#close-modal-bank").click();

                },
                error:function(error){
                  $("#message").remove();

                  $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');

                  $("#buttonNewBank").html("Registrar");
                  $("#close-modal-bank").click();
                }
        });

      }


    </script>

    <script>
      
      function new_center(supplier_id) {

          var params = {

                "name" : $('input[name="center_name"]').val(),
                "rut" : $('input[name="center_rut"]').val(),
                "center" : $('input[name="center"]').val(),
                "location" : $('input[name="location"]').val()
            
          };
          
         $.ajax({
                data:  {data:params},
                url:   '<?= base_url(); ?>proveedores/new_center_supplier/'+supplier_id,
                type:  'post',
                beforeSend: function () {
                        $("#buttonNewBank").html("<i class='fa fa-spinner fa-spin'></i>");
                },
                success:  function (response) {
                        $("#message").remove();
                        $(response).appendTo('#resultado-2');
                        $("#message").hide().fadeIn('slow');
                        $("#buttonNewCenter").html("Registrar");
                        $("#close-modal-center").click();

                },
                error:function(error){
                  $("#message").remove();

                  $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');

                  $("#buttonNewCenter").html("Registrar");
                  $("#close-modal-center").click();
                }
        });

      }


    </script>

