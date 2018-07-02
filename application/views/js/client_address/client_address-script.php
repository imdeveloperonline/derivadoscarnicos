		var errorClass = 'invalid';
        var errorElement = 'em';		

		$("#new-address-client-form").validate({
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


			