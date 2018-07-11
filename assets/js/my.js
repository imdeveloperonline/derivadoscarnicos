
/********** Validator Messages ***********/
$(function() {
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


$(function(){
    $.validator.addMethod("amounts", function(value, element) {
        return /^[0-9\.]+$|^[0-9\.]+([\,][0-9]{2})$/i.test(value);
    }, "Debe ingresar un entero o un decimal de dos (2) dígitos separados por una coma (,)");

    $.validator.addMethod("rest", function(value, element) {
        return /^[0-9\.]+$|^[0-9\.]+([\,][0-9]{2})$/i.test(value);
    }, "Este valor no puede ser menos que cero (0)");

    $.validator.addMethod("date", function(value, element) {
        return /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/i.test(value);
    }, "El formato valido es AAAA-MM-DD");

    $.validator.addMethod("img", function(value, element) {
        return /^(C:\\fakepath\\)+[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+(\.jpg)|(\.jpeg)$|^$/i.test(value);
    }, "El formato de la imagen debe ser jpg");
}); 



$.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '< Ant',
 nextText: 'Sig >',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 
 $.datepicker.setDefaults($.datepicker.regional['es']);


function numberFront(name) {
                
    var element = document.querySelector("input[name='"+name+"']");

    var number = String(element.value);

    if(number.indexOf(",") != -1){
        // Tiene coma
        var number_split = number.split(",");

        var entero = number_split[0];
        var decimal = number_split[1];

        entero = entero.replace(/\D/g, "");
        entero = Number(entero).toLocaleString('de-DE');

        decimal = decimal.substr(0,2);

        return entero+","+decimal;

    } else {
        var entero = number.replace(/\D/g, "");
        entero = Number(entero).toLocaleString('de-DE');

        return entero;
    }
    
}

function numberToString(number) {
    var number = String(number);

    if(number.indexOf("-") != -1){
        var negativo = "-";
    } else {
        var negativo = "";
    }

    if(number.indexOf(".") != -1){
        // Tiene coma
        var number_split = number.split(".");

        var entero = number_split[0];
        var decimal = number_split[1];

        entero = entero.replace(/\D/g, "");
        entero = Number(entero).toLocaleString('de-DE');

        decimal = decimal.substr(0,2);

        return negativo+entero+","+decimal;

    } else {
        var entero = number.replace(/\D/g, "");
        entero = Number(entero).toLocaleString('de-DE');

        return negativo+entero;
    }
    
}

function stringToNumber(string) {

    if(string.indexOf(",") != -1){
        var number = string.split(",");
        var entero = number[0];
        var decimal = number[1];

        entero = entero.replace(/\D/g,"");

        number = entero+"."+decimal;

        return Number(number);

    } else {
        var number = string;
        var entero = number.replace(/\D/g,"");

        return Number(entero);
    }

 }
