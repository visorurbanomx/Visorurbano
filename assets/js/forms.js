$(document).ready(function () {
    'use strict';
    // ------------------------------------------------------- //
    // Adding fade effect to dropdowns
    // ------------------------------------------------------ //
    $('.dropdown').on('show.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeIn();
    });
    $('.dropdown').on('hide.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeOut();
    });



    // ------------------------------------------------------- //
    // Login Form
    // ------------------------------------------------------ //
    if ($('#frmLogin').length){
        $('#frmLogin').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: 'El correo electrónico es requerido para continuar.',
                    email: 'No es una cuenta de correo valida,'
                },
                password: 'La contraseña es requerida para continuar.'
            }
        });

        $(document).keypress(function(e) {
            if(e.which == 13) {
                if ($('#frmLogin').valid()){
                    getLogin($('#txtEmail').val(), md5($('#txtPassword').val())).done(function (data) {
                        if (data.status == 200){
                            setLogin(data.data).done(function(data){
                                if (data.status == 200){
                                    if ($('#txtRedirect').val() != ''){
                                        window.location.href = $('#txtRedirect').val();//baseURL + "nueva-licencia/" + $('#txtRedirect').val();
                                    }else{
                                        window.location.href = baseURL + "admin";
                                    }
                                }
                            });
                        }else{
                            if (data.status == 401){
                                setMessage('Credenciales no validas, por favor revisa la información y vuelve a intentar', true);
                            }else{
                                setMessage(data.message, true);
                            }
                        }
                    });
                }
            }
        });
    }
    $('#btnLogin').on('click', function(){
        if ($('#frmLogin').valid()){
            getLogin($('#txtEmail').val(), md5($('#txtPassword').val())).done(function (data) {
                if (data.status == 200){
                    setLogin(data.data).done(function(data){
                        if (data.status == 200){
                            if ($('#txtRedirect').val() != ''){
                                window.location.href = $('#txtRedirect').val();//baseURL + "nueva-licencia/" + $('#txtRedirect').val();
                            }else{
                                window.location.href = baseURL + "admin";
                            }
                        }
                    });
                }else{
                    if (data.status == 401){
                        setMessage('Credenciales no validas, por favor revisa la información y vuelve a intentar', true);
                    }else{
                        setMessage(data.message, true);
                    }
                }
            });
        }
    })
    function getLogin(email, pass) {
        var params = {};
        params["email"] = email;
        params["password"] = pass;
        return $.ajax({
            url: userURL + 'login',
            type: "POST",
            dataType: 'json',
            data: params
        });
    }

    function setLogin(data){
        return $.ajax({
            url: baseURL + "auth/login",
            type: "post",
            dataType: 'json',
            data: data
        });
    }

    function setMessage(msg, error){
        $('.msessage-cont').remove();
        var messageContainer = $('<div/>', {class: 'msessage-cont mui--z2'}).prependTo('body');
        if (error){

        }
        messageContainer.html('<p>' + msg + '</p><div class="close"></div>');
        $('.msessage-cont .close').on('click', function(e){
            e.preventDefault();
            $('.msessage-cont').remove();
        });

        $(window).scrollTop($('.msessage-cont').offset().top);
    }

    // ------------------------------------------------------- //
    // Create Account
    // ------------------------------------------------------ //
    if ($('#frmRegister').length){
        $('#frmRegister').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                celular: {
                    required: true,
                    minlength: 10,
                    number: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                repassword: {
                    equalTo: "#password"
                }
            },
            messages: {
                email: {
                    required: 'El correo electrónico es requerido para continuar',
                    email: 'No es una cuenta de correo valida,'
                },
                nombre: 'El nombre es requerido para continuar',
                ape_paterno: 'El primer apellido es requerido para continuar',
                celular:{
                    required: 'El número celular es requerido para continuar',
                    minlength: 'El numero celular debe contener al menos 10 digitos',
                    number: 'El número celular debe contener solo numeros'
                },
                password:{
                    required: 'La contraseña es requerida para continuar',
                    minlength: 'La contraseña debe contener al menos 8 caracteres'
                },
                repassword:{
                    required: 'Confirma la contraseña para continuar',
                    equalTo: 'No coinciden las contraseñas'

                },
                agree: 'Debes aceptar los terminos y condiciones para continuar'
            }
        });
    }

    $('#btnRegistro').on('click', function(){
        if ($('#frmRegister').valid()){
            signIn($("[name='email']").val(), $("[name='nombre']").val(), $("[name='ape_paterno']").val(), $("[name='ape_materno']").val(), $("[name='celular']").val(), $("[name='password']").val()).done(function(data){
                if (data.status == 200){
                    getLogin($("[name='email']").val(), md5($("[name='password']").val())).done(function (data){
                        setLogin(data.data).done(function(dta){
                            if (dta.status == 200){
                                writeMessage(1, data.data['idU'],'Hola ' + $("[name='nombre']").val() +', Bienvenido a Visor urbano').done(function(dt){
                                    if (dt.status == 200){
                                        window.location.href = baseURL + "admin";
                                    }else{
                                        setMessage(data.message, true);
                                    }
                                });
                            }
                            else{
                                setMessage(data.message, true);
                            }
                        });
                    });
                }else{
                    setMessage(data.message, true);
                }
            });
        }
    });

    function signIn(email, nombre, ape_paterno, ape_materno, celular, pass) {
        var params = {};
        params["email"] = email;
        params["nombre"] = nombre;
        params["ape_paterno"] = ape_paterno;
        params["ape_materno"] = ape_materno;
        params["celular"] = celular;
        params["password"] = md5(pass);
        params["origen"] = 4;
        return $.ajax({
            url: userURL +"registro",
            type: "post",
            dataType: 'json',
            data: params
        });
    }

    function writeMessage(remitente, destinatario, msg) {
        var params = {};
        params["de"] = remitente;
        params["para"] = destinatario;
        params["mensaje"] = msg;
        return $.ajax({
            url: baseURL + 'admin/setMensaje',
            type: "post",
            dataType: 'json',
            data: params
        });
    }
});
