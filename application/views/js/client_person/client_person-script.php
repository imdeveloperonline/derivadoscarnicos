		var errorClass = 'invalid';
        var errorElement = 'em';		

		$("#new-person-client-form").validate({
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


			