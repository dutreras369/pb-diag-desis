function getCityByRegion() {
    var id_region = $("#id_region").val();
    $.post("ajax.php",{getCityByRegion:'getCityByRegion',id_region:id_region},function (response) {
        var data = response.split('^');
        $("#id_city").html(data[1]);
    });
}

// Add custom rule for at least one letter
$.validator.addMethod("containsLetter", function(value, element) {
    return /[a-zA-Z]/.test(value);
}, "Por favor debe contener al menos una letra.");

// Add custom rule for at least one number
$.validator.addMethod("containsNumber", function(value, element) {
    return /\d/.test(value);
}, "Por favor debe contener al menos un numeros.");

$.validator.addMethod("validRut", function(value, element) {
    // Remove dots and validate the RUT format
    return /^[0-9]+-[0-9kK]{1}$/.test(value.replace(/\./g, ''));
  }, "Ingrese RUT sin puntos y con guion (ej: 12345678-9).");

$().ready(function () {
    $("#votacionForm").validate({
        rules: {
            name:  {
                required: true, 
            },
            alias: {
                required: true,
                minlength: 5, 
                containsLetter: true,
                containsNumber: true,
            },
            rut: {
                required: true,
                validRut: true
            },
            email: {
                required: true,
                email: true
            },
            id_region: {
                required: true,
            },
            id_city: {
                required: true,
            },
            id_candidato: {
                required: true,
            },
            id_consulta: {
                required: true,
            },
        },

        messages: {
            name:{ 
                required: "Ingrese nombre"
            },
            alias: {
                required: "Ingrese un alias con letras y numeros",
                minlength: "El largo minimo es de 5 caracteres",
            },
            rut: {
                required: "Ingrese rut",
                minlength: "El largo minimo es de 5 caracteres",
            },
            email: {
                required: "Ingrese mail",
                email: "Ingrese un email valido"
            },
            id_region: {
                required: "Seleccione una region",
            },
            id_city: {
                required: "Seleccione una comuna",
            },
            id_candidato: {
                required: "Seleccione un candidato",
            },
            id_consulta: {
                required: "Seleccione un medio",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});