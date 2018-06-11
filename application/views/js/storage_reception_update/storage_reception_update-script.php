            var errorClass = 'invalid';
            var errorElement = 'em';        

            $("#reception-form").validate({
                errorClass    : errorClass,
                errorElement  : errorElement,
                ignore: [],
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


              // START AND FINISH DATE
                $('#date').datepicker({
                    dateFormat : 'yy-mm-dd',
                    prevText : '<i class="fa fa-chevron-left"></i>',
                    nextText : '<i class="fa fa-chevron-right"></i>'
                });     

                $('#date_credit').datepicker({
                    dateFormat : 'yy-mm-dd',
                    prevText : '<i class="fa fa-chevron-left"></i>',
                    nextText : '<i class="fa fa-chevron-right"></i>'
                }); 