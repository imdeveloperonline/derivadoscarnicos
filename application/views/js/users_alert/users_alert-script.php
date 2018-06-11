		var errorClass = 'invalid';
        var errorElement = 'em';		

		$("#update-form").validate({
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

          $("#user_alert").select2({
                multiple: true,
                placeholder: "Seleccione un usuario"
            });

            if($("#user_alert").val() == ""){
                $("input.select2-search__field").css("width","100%");
            }   
	


			