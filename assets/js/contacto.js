
if ($('#form_correo').length){
    $('#form_correo').validate({
        rules: {
            nombre: {
                required: true,
            },
            email:{
                required: true,
                email: true
            }
        },
        messages:{
            nombre: {
                required: "Coloca nombre para poder continuar",
            },
            email:{
                required: 'Coloca correo electrónico para poder continuar',
                email: 'Correo electrónico invalido'
            }
        }
    })
}

function enviar_correo(){
    if ($('#form_correo').valid()){
        mandar_correo();
    }else{
        $('.error').attr('style','color:red !important;');
    }
}

$('#nombre').keypress(function(e){
    if($(this).attr('style')){
        $(this).removeAttr('style');
    }
});

$('#email').keypress(function(e){
    if($(this).attr('style')){
        $(this).removeAttr('style');
    }else if(e.which == 0){
        setTimeout(function(){
            $('.error').attr('style','color:red !important;');
            $(this).removeAttr('style');
        },100);
    }
});

function mandar_correo(){
    $('#alertas').empty();
    $('#alertas').append('<div class="alert alert-warning">'+
    '<strong>Enviando... Porfavor no cierre la ventana!</strong>'+
    '</div>');
    $('#enviar').attr('disabled',true);
    $.ajax({
        url: "https://visorurbano.com/EmailController/Email",
        type: "POST",
        dataType: 'json',
        data: {
            'nombre':$('#nombre').val(),
            'de':$('#email').val(),
            'mensaje':$('#comentario').val(),
            'asunto':'Contacto',
            'telefono':$('#telefono').val(),
        },
        success: function(data){
            $('#alertas').empty();
            $('#enviar').attr('disabled',false);
            if(data.status){
                $('#alertas').append('<div class="alert alert-success">'+
                '<strong>Correcto!</strong> Se han mandado tus datos con exito, espera tu respuesta pronto.'+
                '</div>');
                $('#nombre').val('');
                $('#email').val('');
                $('#comentario').val('');
                $('#telefono').val('');
                setTimeout(function(){
                    $('#alertas').empty();
                },5000);
            }else{
                $('#alertas').append('<div class="alert alert-danger">'+
                '<strong>Lo sentimos!</strong> Ha ocurrido una falla, Intente más tarde ):'+
                '</div>');
                $('#nombre').val('');
                $('#email').val('');
                $('#comentario').val('');
                $('#telefono').val('');
                setTimeout(function(){
                    $('#alertas').empty();
                },5000);
            }
        }
    });
}
