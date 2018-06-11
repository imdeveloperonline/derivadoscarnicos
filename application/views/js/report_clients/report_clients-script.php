			var errorClass = 'invalid';
			var errorElement = 'em';

			$("#report-form").validate({
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
			$('#startdate').datepicker({
				dateFormat : 'yy-mm-dd',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#finishdate').datepicker('option', 'minDate', selectedDate);
				}
			});
			
			$('#finishdate').datepicker({
				dateFormat : 'yy-mm-dd',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#startdate').datepicker('option', 'maxDate', selectedDate);
				}
			});

			