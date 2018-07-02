		var errorClass = 'invalid';
        var errorElement = 'em';		

		$("#update-supplier-form").validate({
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


          $("#shamble").select2({
                multiple: true,
                placeholder: "Seleccione un frigorífico"
            });

            if($("#shamble").val() == ""){
                $("input.select2-search__field").css("width","100%");
            }		


			