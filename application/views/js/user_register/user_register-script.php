		var $registerForm = $('#register-form').validate({
			// Rules for form validation
				rules : {
					fname : {
						required : true
					},
					lname : {
						required : true
					},
					email : {
						required : true,
						email : true
					},
					phone : {
						required : true
					},
					regional : {
						required : true
					},
					position : {
						required : false
					},
					profile : {
						required : true
					},
					password : {
						required : true,
						minlength : 3,
						maxlength : 20
					},
					passwordConfirm : {
						required : true,
						minlength : 3,
						maxlength : 20,
						equalTo : '#password'
					},
				},
		
				// Messages for form validation
				messages : {
					fname : {
						required : 'Por favor introduzca un nombre'
					},
					lname : {
						required : 'Por favor introduzca un apellido'
					},
					email : {
						required : 'Por favor introduzca una dirección email',
						email : 'Por favor introduzca un email VALIDO'
					},
					phone : {
						required : 'Por favor introduzca un número telefónico'
					},
					regional : {
						required : 'Por favor seleccione un regional'
					},
					postion : {
						required : 'Por favor introduzca un cargo'
					},
					profile : {
						required : 'Por favor seleccione un perfil'
					},
					password : {
						required : 'Por favor introduzca una contraseña',
						minlength : 'La contraseña debe contener al menos 3 caracteres',
						maxlength : 'La contraseña debe contener máximo 20 caracteres'
					},
					passwordConfirm : {
						required : 'Por favor confirme la contraseña',
						minlength : 'La contraseña debe contener al menos 3 caracteres',
						maxlength : 'La contraseña debe contener máximo 20 caracteres',	
						equalTo : 'Las contraseñas no coinciden'
					}
				},
		
				// Do not change code below
				errorPlacement : function(error, element) {
					error.insertAfter(element.parent());
				}
			});
					
	
			// START AND FINISH DATE
			$('#startdate').datepicker({
				dateFormat : 'dd.mm.yy',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#finishdate').datepicker('option', 'minDate', selectedDate);
				}
			});
			
			$('#finishdate').datepicker({
				dateFormat : 'dd.mm.yy',
				prevText : '<i class="fa fa-chevron-left"></i>',
				nextText : '<i class="fa fa-chevron-right"></i>',
				onSelect : function(selectedDate) {
					$('#startdate').datepicker('option', 'maxDate', selectedDate);
				}
			});

			