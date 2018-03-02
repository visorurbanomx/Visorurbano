var stepsForm = null;
var currentStep = $('#step').val();
var informado=false;
var arregloDatosP=[];
var NumExtPredio;
$(document).ready(function () {
    'use strict';
    // ------------------------------------------------------- //
    // Agregar efecto fade a los selects
    // ------------------------------------------------------ //
    $('.dropdown').on('show.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeIn();
    });
    $('.dropdown').on('hide.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeOut();
    });

    // ------------------------------------------------------- //
    // Change pass Form
    // ------------------------------------------------------ //
    if ($('#frmContrasena').length){
        $('#frmContrasena').validate({
            rules: {
                nuevoPass: {
                    required: true,
                    minlength: 8,
                },
                confirmaNuevoPass:{
                    required: true,
                    equalTo: '#txtNuevoPass'
                }
            },
            messages:{
                passActual: 'La contraseña actual es requerida para continuar',
                nuevoPass:{
                    required: 'La nueva contraseña es requerida para continuar',
                    minlength: 'La contraseña debe contener al menos 8 caracteres'
                },
                confirmaNuevoPass:{
                    required: 'Confirma la nueva contraseña para continuar',
                    equalTo: 'No coinciden las contraseñas'
                }
            }
        })
    }

    $('#btnCambiarPass').on('click', function(e){
        e.preventDefault();
        if ($('#frmContrasena').valid()){
            setPass($('#txtNuevoPass').val(), $('#txtPassActual').val(), $('#txtEmailPass').val()).done(function(data){
                if (data.status == 200){
                    setMessage('exito', $('.message'), '<b>Bien echo:</b> la contraseña se actualizó correctamente.');
                }else{
                    setMessage1('<b>Error:</b> la contraseña actual no es correcta.', true);
                }
            });
        }
    })

    // ------------------------------------------------------- //
    // Update Profile
    // ------------------------------------------------------ //

    if ($('#frmPerfilUsuario').length){
        $('#frmPerfilUsuario').validate({
            rules:{
              email:{
                  required: true,
                  email: true
              }
            },
            messages:{
                nombre: 'El nombre es requerido para continuar',
                ape_pat: 'El primer apellido es requerido para continuar',
                ape_mat: 'El segundo apellido es requerido para continuar',
                email:{
                    required: 'El correo eletrónico es requerido para continuar',
                    email: 'La cuenta no es valida'
                }
            }
        })
    }

    $('#btnActualizarPerfil').on('click', function (e) {
        e.preventDefault();
        if ($('#frmPerfilUsuario').valid()){
            updateProfile($('#txtEmail').val(), $('#txtNombre').val(), $('#txtApepat').val(), $('#txtApemat').val(), $('#txtCelular').val()).done(function(data){
                if (data.status == 200){
                    $('#contUserName').text($('#txtNombre').val());
                    setProfile($('#txtNombre').val(), $('#txtApepat').val(), $('#txtApemat').val(), $('#txtCelular').val()).done(function(data){
                        setMessage('exito', $('.messagePerfil'), '<b>Bien echo:</b> Tus datos han sido actualizado correctamente');
                    });
                }else{
                    setMessage1('<b>Error:</b> Ocurrio un erro inesperado al momento de actualizar tus datos por favor intenta de nuevo mas tarde.', true);
                }
            });
        }
    });


    // ------------------------------------------------------- //
    // Iniciar Licencia de Giro
    // ------------------------------------------------------ //
    if ($('#frmIniciarTramiteLicencia').length){
        $('#frmIniciarTramiteLicencia').validate({
            messages:{
                claveCatastral: 'La Clave Catastral es requerida para continuar'
            }
        });
    }

    $('#btnInciarTramiteLicencia').on('click', function(e){
        e.preventDefault();
        if ($('#frmIniciarTramiteLicencia').valid()){
            window.location.replace("http://visorurbano.guadalajara.gob.mx/mapa/?criterio=" + $('#txtClaveCatastral').val());
        }
        /*if ($('#frmIniciarTramiteLicencia').valid()){
            validaCC($('#txtClaveCatastral').val()).done(function(data){
                if (data.status == 200){
                    window.location.href = baseURL+'nueva_licencia/'+$('#txtClaveCatastral').val();
                }else{
                    $('#txtClaveCatastral').val('');
                    setMessage('error', $('.msg'), 'La Clave Catastral ingresada no existe por favor revise la información e intente de nuevo.' )
                }
            });
        }*/
    });

    // ------------------------------------------------------- //
    // Confirmación Licencia de Giro
    // ------------------------------------------------------ //
    if ($('#frmLicenciaGiroConfirmar').length){
        $('#frmLicenciaGiroConfirmar').validate({
            messages:{
                numeroPredial: 'El número de cuenta predial es requerido para continuar',
                folioFactibilidad: 'El folio del trámite de factibilidad es requerido para continuar',
                agreeAvisoPrivacidad: 'Debes aceptar el aviso de privaciad para continuar'
            }
        });
    }
    $('#btnConfirmarLicencias').on('click', function(){
       if ($('#frmLicenciaGiroConfirmar').valid()){
           validaNCP($('#txtCuentaPredial').val(), $('#txtCPE').val(), $('#txtCC').val(), $('#txtFFactibilidad').val()).done(function(data){
                if (data.status == 200){
                    window.location.href = baseURL + 'nueva-licencia/'+data.data.sec+'/'+data.data.sec2;
                   setFolder(data.data.id).done(function(dataFolder){
                        if (dataFolder.status == 200){
                            unsetLoading();
                            //window.location.href = baseURL + 'nueva-licencia/'+data.data.sec+'/'+data.data.sec2;
                        }else{
                            unsetLoading();
                            //window.location.href = baseURL + 'nueva-licencia/'+data.data.sec+'/'+data.data.sec2;
                        }
                    });
                }else{
                    unsetLoading();
                    setMessage1(data.message, true);
                }
            });
       }
    });


    // ------------------------------------------------------- //
    // Steps Licencia de Giro
    // ------------------------------------------------------ //

    $.validator.addMethod( "extension", function( value, element, param ) {
        param = typeof param === "string" ? param.replace( /,/g, "|" ) : "png|jpe?g|gif";
        return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
    }, $.validator.format( 'Este documento debe ser en formato ".pdf"' ) );


    if ($('#frmFirmar').length){
        $('#frmFirmar').validate({
            rules:{
                firmaCER:{
                    required: true,
                    extension: "cer"
                },
                firmaKEY:{
                  required: true,
                  extension: 'key'
                },
                firmaPass:{
                    required: true
                }
            },
            messages:{
                firmaCER:{
                    required: 'Ingresa el archivo .cer para continuar',
                    extension: 'Formato incorrecto, se espera un archivo con formato .cer'
                },
                firmaKEY:{
                    required: 'Ingresa el archivo .key para continuar',
                    extension: 'Formato incorrecto, se espera un archivo con formato .key'
                },
                firmaPass:{
                    required: 'Ingresa la contraseña de la firma electrónica para continuar'
                }
            }
        });
    }

    if ($('#FormCartaModel').length){
        $('#FormCartaModel').validate({
            rules:{
                nombreCompletoSuscrita:{
                    required: true,
                },
                documentoIdentificacion:{
                    required: true,
                },
                numeroIdentificacion:{
                    required: true,
                },
                domicilioPredio:{
                    required: true,
                },
                claveCatastral:{
                    required: true
                }
            },
            messages:{
                nombreCompletoSuscrita:{
                    required: 'Ingresa el nombre de la suscrita para continuar',
                },
                documentoIdentificacion:{
                    required: 'Ingresa el documento de identificación para continuar',
                },
                numeroIdentificacion:{
                    required: 'Ingresa el número del documento para continuar',
                },
                domicilioPredio:{
                    required: 'Ingresa el domicilio del predio para continuar',
                },
                claveCatastral:{
                    required: 'Ingresa la clave catastral para continuar',
                }
            }
        });
    }

    if ($('#frmSolicitudLicenciaGiro').length){
        var form = $("#frmSolicitudLicenciaGiro");
        form.validate({
            rules:{
                st1_carta_poder:{
                    required: true,
                    extension: "pdf,jpg,jpeg,png,tif"
                },
                fleIdentificacionOtorgante:{
                    required: true,
                    extension: "pdf,jpg,jpeg,png,tif"
                },
                fleTestigo1:{
                    required: true,
                    extension: "pdf,jpg,jpeg,png,tif"
                },
                fleTestigo2:{
                    required: true,
                    extension: "pdf,jpg,jpeg,png,tif"
                },
                fleContratoArrendamiento:{
                    required: true,
                    extension: "pdf,jpg,jpeg,png,tif"
                },
                fleAnuencia:{forms
                    required: true,
                    extension: "pdf,jpg,jpeg,png,tif"
                },
                st2_email_representante: {
                    required: true,
                    email: true
                },
                st2_num_ext_representante:{
                    required: true,
                    number: true
                },
                st2_num_int_representante:{
                    //required: true,
                    number: true
                },
                st2_cp_representante:{
                    required: true,
                    number: true
                },
                st2_telefono_representante:{
                    required: true,
                    number: true
                },
                st2_email_solicitante: {
                    required: false,
                    email: true
                },
                st2_num_ext_solicitante:{
                    required: true,
                    number: true
                },
                st2_num_int_solicitante:{
                    //required: true,
                    number: true
                },
                st2_cp_solicitante:{
                    required: true,
                    number: true
                },
                st2_telefono_solicitante:{
                    required: true,
                    number: true
                },
                st2_identificacion_representante:{
                    required: true,
                    extension: "pdf,jpg,jpeg,png,tif"
                },
                st2_identidficacion_solicitante:{
                    required: true,
                    extension: "pdf,jpg,jpeg,png,tif"
                },
                st3_num_ext_establecimiento:{
                    required: true,
                    number: true
                },
                st3_num_int_establecimiento:{
                    //required: true,
                    number: true
                },
                st3_cp_establecimiento:{
                    required: true,
                    number: true
                },
                st3_num_local_establecimiento:{
                    required: true,
                    number: true
                },
                st3_empleados_establecimiento:{
                    required: true,
                    number: true
                },
                st3_cajones_estacionamiento_establecimiento:{
                    required: true,
                    number: true
                },
                st3_sup_construida_establecimiento:{
                    required: true,
                    number: true
                },
                st3_area_utilizar_establecimiento:{
                    required: true,
                    number: true
                },
                st3_inversion_establecimiento:{
                    required: true,
                    number: true
                },
                st3_img1_establecimiento:{
                    required: true
                },
                st3_img2_establecimiento:{
                    required: true
                },
                st3_img3_establecimiento:{
                    required: true
                },
                st3_es_numero_interior:{
                    required: true
                },
                $st3_asignacion_numero:{
                    required: true
                }
            },
            messages:{
                st1_tipo_solicitante: {
                    required: 'Elige un tipo de solicitante para continuar'
                },
                st1_tipo_representante:{
                    required: 'Elige un tipo de representante para continuar'
                },
                st1_carta_responsiva:{
                    required: 'Adjunta la carta poder para continuar'
                },
                st1_carta_poder:{
                    required: 'Adjunta la carta poder para continuar'
                },
                fleIdentificacionOtorgante:{
                    required: 'Adjunta la identificación del otorgante para continuar'
                },
                fleTestigo1:{
                    required: 'Adjunta la identificación del Testtigo #1 para continuar'
                },
                fleTestigo2:{
                    required: 'Adjunta la identificación del Testtigo #2 para continuar'
                },
                fleContratoArrendamiento:{
                    required: 'Adjunta el contrato de arrendamiento para continuar'
                },
                st1_faculta:{
                    required: 'Confirma si el contrato de arrendamiento te faculta para abrir un negocio'
                },
                st1_anuencia:{
                    required: 'Confirma si cuentas con la anuencia del propietario para abrir un negocio'
                },
                fleAnuencia: {
                    required: 'Adjunta la anuencia firmada por el propietario o representante  para continuar'
                },
                st2_email_representante: {
                    email: 'La cuenta de correo proporcionada no es valdia'
                },
                st2_num_ext_representante:{
                    number: 'Debe ser una valor numérico'
                },
                st2_num_int_representante:{
                    number: 'Debe ser una valor numérico'
                },
                st2_cp_representante:{
                    number: 'Debe ser una valor numérico'
                },
                st2_telefono_representante:{
                    number: 'Debe ser una valor numérico'
                },
                st2_email_solicitante: {
                    email: 'La cuenta de correo proporcionada no es valdia'
                },
                st2_num_ext_solicitante:{
                    number: 'Debe ser una valor numérico'
                },
                st2_num_int_solicitante:{
                    number: 'Debe ser una valor numérico'
                },
                st2_cp_solicitante:{
                    number: 'Debe ser una valor numérico'
                },
                st2_telefono_solicitante:{
                    number: 'Debe ser una valor numérico'
                },
                st2_identificacion_representante:{
                    required: 'Adjunta la Identificación del representante continuar'
                },
                st2_identidficacion_solicitante:{
                    required: 'Adjunta la Identificación del solicitante continuar'
                },
                st3_num_ext_establecimiento:{
                    number: 'Debe ser una valor numérico'
                },
                st3_num_int_establecimiento:{
                    number: 'Debe ser una valor numérico'
                },
                st3_cp_establecimiento:{
                    number: 'Debe ser una valor numérico'
                },
                st3_num_local_establecimiento:{
                    number: 'Debe ser una valor numérico'
                },
                st3_empleados_establecimiento:{
                    number: 'Debe ser una valor numérico'
                },
                st3_cajones_estacionamiento_establecimiento:{
                    number: 'Debe ser una valor numérico'
                },
                st3_sup_construida_establecimiento:{
                    number: 'Debe ser una valor numérico'
                },
                st3_area_utilizar_establecimiento:{
                    number: 'Debe ser una valor numérico'
                },
                st3_inversion_establecimiento:{
                    number: 'Debe ser una valor numérico'
                },
                st3_img1_establecimiento:{
                    required: 'Adjunta la fotografía panorámica de la fachada para continuar'
                },
                st3_img3_establecimiento:{
                    required: 'Adjunta la fotografía del Interior del establecimiento para continuar'
                },
                st3_img2_establecimiento:{
                    required: 'Adjunta la fotografía panorámica de la fachada con la puerta o cortina abierta para continuar'
                },
                st3_es_numero_interior:{
                    required: 'Confirma si la licencia será para número interior'
                },
                st3_asignacion_numero:{
                    required: 'Adjunta la asignación de número ofical para continuar'
                },
                st4_declaratoria:{
                    required: 'La confirmación de que la información es correcta es requerida para continuar'
                }

            }
        });
        stepsForm = form.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            startIndex: parseInt(currentStep),
            onStepChanging: function (event, currentIndex, newIndex)
            {
                if(newIndex == 4){
                    fill_pago();
                }
                if((newIndex+1) == 5){
                    if ($('#firma_electronica').length){
                        if($('#firma_electronica').text() == ''){
                            $('#firma_electronica').text('');
                            $('.contErrorInsideFirma').remove();
                            $('#firmaContainer').append('<span style="color: #F35B53;" class="contErrorInsideFirma">Debes firmar la solicitud utilizando tu firma electronica (FIEL) para poder continuar.</span>');
                            $(window).scrollTop($('#firmaContainer').offset().top);
                            return false;
                        }else{
                            $('.contErrorInsideFirma').remove();
                            updateForma(frm, newIndex, $('#tramite').val()).done(function (data) {});
                        }
                    }
                }
                if(newIndex == 2){
                    getNegocio();
                }
                if((newIndex+1) == 3) {

                    form.validate().settings.ignore = ":disabled,:hidden,.valid";
                    if (form.valid()) {
                        var frm = form.find(":input:not(:hidden)").serializeArray();
                        updateForma(frm, newIndex, $('#tramite').val()).done(function (data) {
                            if(data.validacionMultiLic.status){
                                console.log(data.validacionMultiLic.licencias);
                                var errores = [];
                                errores[0] = "Se encontrarón estas licencias asociadas en este predio, acude a padrón y licencias a darlas de baja";
                                for (var i = 0; i < data.validacionMultiLic.licencias.length; i++) {
                                    errores[i+1] = data.validacionMultiLic.licencias[i].id + ' -- '+ data.validacionMultiLic.licencias[i].actividad;
                                }
                                errorLicenciaGiro(1, errores);
                                $('.actions ul li a[href=\'#next\']').hide();
                            }
                        });
                    }
                    if (newIndex == 3) {
                        resumenLicenciaGiro();
                    }
                }
                if(currentIndex != 3){
                    form.validate().settings.ignore = ":disabled,:hidden,.valid";
                    if (form.valid()){
                        var frm  = form.find(":input:not(:hidden)").serializeArray();
                        updateForma(frm, newIndex, $('#tramite').val());
                    }
                    if (newIndex == 3){
                        resumenLicenciaGiro();
                    }
                    return form.valid();
                    informado = true;
                }

                return form.valid();

            },
            onInit: function(event, currentIndex){
                if(currentIndex == 2){
                    getNegocio();
                    consulLicP($('#tramite').val()).done(function(data){
                        if(data.validacionMultiLic.status){
                            console.log(data.validacionMultiLic.licencias);
                            var errores = [];
                            errores[0] = "Se encontrarón estas licencias asociadas en este predio, acude a padrón y licencias a darlas de baja";
                            for (var i = 0; i < data.validacionMultiLic.licencias.length; i++) {
                                errores[i+1] = data.validacionMultiLic.licencias[i].id + ' -- '+ data.validacionMultiLic.licencias[i].actividad;
                            }
                            errorLicenciaGiro(1, errores);
                            $('.actions ul li a[href=\'#next\']').hide();
                        }
                    });
                }
                step_bd().done(function(data){
                    switch(data.data.step){
                        case '1':
                            if($('#id_solicitante').attr('href') != "" && (data.data.st2_colonia_solicitante == "" || data.data.st2_cp_solicitante == "0"  || data.data.st2_ciudad_solicitante == "" || data.data.st2_telefono_solicitante == "")){
                                delete_file('st2_identidficacion_solicitante');
                                $('#id_solicitante').hide();
                            }
                        break;
                        case '2':
                            if($('#file_img1').attr('href') != "" && (data.data.st3_inversion_establecimiento == "0" || data.data.st3_empleados_establecimiento == "0" || data.data.st3_cajones_estacionamiento_establecimiento == "0")){
                                delete_file('st3_img1_establecimiento');
                                $('#file_img1').hide();
                            }
                            if($('#file_img2').attr('href') != "" && (data.data.st3_inversion_establecimiento == "0" || data.data.st3_empleados_establecimiento == "0" || data.data.st3_cajones_estacionamiento_establecimiento == "0")){
                                delete_file('st3_img2_establecimiento');
                                $('#file_img2').hide();
                            }
                            if($('#file_img3').attr('href') != "" && (data.data.st3_inversion_establecimiento == "0" || data.data.st3_empleados_establecimiento == "0" || data.data.st3_cajones_estacionamiento_establecimiento == "0")){
                                delete_file('st3_img3_establecimiento');
                                $('#file_img3').hide();
                            }
                            if($('#file_dictamen_tecnico').attr('href') != "" && (data.data.st3_cajones_estacionamiento_establecimiento == "0" || data.data.st3_cajones_estacionamiento_establecimiento == "" > 3)){
                                delete_file('st3_dictamen_lineamiento');
                                $('#file_dictamen_tecnico').hide();
                                $('#dictamen_tecnico').hide();
                            }
                            if($('#file_asignacion_numero').attr('href') != "" && $("#txtNExterior_establecimiento").val() == NumExtPredio){
                                delete_file('st3_asignacion_numero');
                                $('#file_asignacion_numero').hide();
                                $('#asignacion_numero').hide();
                            }
                        break;
                    }
                });
                ResumeLicenciaGiro();
                informado = true;
                if(currentIndex == 4){
                    fill_pago();
                }
                if (currentIndex == 3){
                    resumenLicenciaGiro();
                }
                if(currentIndex == 1){
                    informado = false;
                }
                getDataPropietario($('#claveCatastral').val()).done(function(data){
                    if (data.status == 200){
                        arregloPropietario=data.data;
                        arregloPropietario.n_exterior = (arregloPropietario.n_exterior != "" ? parseInt(arregloPropietario.n_exterior): "");
                        arregloPropietario.n_interior = (arregloPropietario.n_interior != "" ? parseInt(arregloPropietario.n_interior): "");
                    }
                });
                $('#frmSolicitudLicenciaGiro .actions li a').addClass('mui-btn mui-btn--primary');
            },
            onFinished: function (event, currentIndex) {
                var dataSend = {name:"status", value:"FP"};
                updateForma(new Array(dataSend), currentIndex, $('#tramite').val()).done(function(data){
                    window.location.href = baseURL + "admin";
                });

            },
            labels: {
                cancel: "Cancelar",
                current: "paso actual:",
                pagination: "Paginación",
                finish: "Finalizar",
                next: "Siguiente  <i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i>",
                previous: "<i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i>  Anterior",
                loading: "Cargando ..."
            },


        });
    }


    //tipo Solicitante
    $('input:radio[name=st1_tipo_solicitante]').each(function(index, el) {
        $(this).on('click', function (){
            clear_table();
           var val =  $(this).val();
            $('#seccionPromotor, #seccionArrendatario').hide();
           switch (val){
               case 'propietario':
                   $('#secRepresentante').hide();
                    unsetError();
                    fillPropietario();
                   $('.cont-identificacion-solicitante').show();
               break;
               case 'promotor':
                   unsetError();
                   fillPropietario();
                   $('#seccionPromotor').show();
                   $('#secRepresentante').show();
                   $('.cont-identificacion-solicitante').hide();
                   $('input:radio[name=st1_faculta]').prop('checked', false);
                   $('input:radio[name=st1_anuencia]').prop('checked', false);
               break;
               case 'arrendatario':
                   cleanPropietario();
                   $('#seccionArrendatario').show();
                   $('#secRepresentante').hide();
                   $('.cont-identificacion-solicitante').show();
                   $('input:radio[name=st1_tipo_representante]').prop('checked', false);
                   $('input:radio[name=st1_tipo_carta_poder]').prop('checked', false);
                   $('#rbtCartaPoderSimple').prop('checked', true);
               break;
               default:
                   cleanPropietario();
                   $('#seccionPromotor, #seccionArrendatario').hide();
               break;

           }
        });
    });

    //tipo Promotor
    $('input:radio[name=st1_tipo_representante]').each(function(index, el) {
        $(this).on('click', function (){
            var val =  $(this).val();
            if (val == 'arrendatario'){
                $('#seccionArrendatario').show();
            }else{
                unsetError();
                $('#seccionArrendatario').hide();
            }
        });
    });

    // Tipod e Carta Poder
    $('input:radio[name=st1_tipo_carta_poder]').each(function(index, el) {
        $(this).on('click', function (){
            var val =  $(this).val();
            if (val == 'simple'){
                $('.anexoCartaPoder').show();
            }else{
                $('.anexoCartaPoder').hide();
            }
        });
    });

    //El contrato de arrendamento faculta
    $('input:radio[name=st1_faculta]').each(function(index, el) {
        $(this).on('click', function (){
            var val =  $(this).val();
            if (val == 'n'){
                $('#seccionAnuencia').show();
            }else{
                $('#seccionAnuencia').hide();
                $('#seccionCartaAnuencia').hide();
            }
        });
    });

    //Anuencia
    $('input:radio[name=st1_anuencia]').each(function(index, el) {
        $(this).on('click', function (){
            var val =  $(this).val();
            if (val == 's'){
                unsetError();
                $('#seccionCartaAnuencia').show();
            }else{
                var errores = [];
                errores[0] = 'El contrato de arrendamiento no te faculta para abrir un negocio.';
                errores[1] = 'No cuentas con la anuencia del propietario para abrir un negocio.';
                errorLicenciaGiro(1, errores);
                $('#seccionCartaAnuencia').hide();

            }
        });
    });

    // ------------------------------------------------------- //
    // Firmar
    // ------------------------------------------------------ //
    $('#btnFirmar').on('click', function(e){
        e.preventDefault();
        validateFirma();
    });

    // ------------------------------------------------------- //
    // Estilos botones steps
    // ------------------------------------------------------ //

    /*$("#txtNExterior_establecimiento").blur(function(){
            if($(this).val() != NumExtPredio || $("#txtLExterior").val() != ""){
                $('#asignacion_numero').show();
            }else{
                delete_file('st3_asignacion_numero');
                $('#file_asignacion_numero').hide();
                $('#asignacion_numero').hide();
            }
        });

    $("#txtLExterior").blur(function(){
        if($(this).val() != "" || $("#txtNExterior_establecimiento").val() != NumExtPredio){
            $('#asignacion_numero').show();
        }else{
            delete_file('st3_asignacion_numero');
            $('#file_asignacion_numero').hide();
            $('#asignacion_numero').hide();
        }
    });*/

    // ------------------------------------------------------- //
    // Validar area a utilizar
    // ------------------------------------------------------ //
    $('#txtAreaUtilizar').on('blur', function(e){
        e.preventDefault();
        if ($(this).val() != ''){
            if($('#zncion').val() == 'H1' || $('#zncion').val() == 'H2' || $('#zncion').val() == 'H3' || $('#zncion').val() == 'H4' || $('#zncion').val() == 'H5'){
                if ($(this).val() > 30){
                    $(this).val('')
                }
            }else{
                if ($(this).val() > 300){
                    $(this).val('')
                }
            }
        }
    });

    // ------------------------------------------------------- //
    // Validar cajones de estacionamiento
    // ------------------------------------------------------ //
    $('#txtCajonesEstacionamiento').on('blur', function(e){
        e.preventDefault();
        var cajones  = $(this).val();
        if (cajones != '' || $('#txtAreaUtilizar').val() > 79){
            var area =  $('#txtAreaUtilizar').val();
            //var area = 300;
            var res = (area/80);
            if (cajones < Math.trunc(res)){
                $('.cont-dictamen-tecnico-movilidad').show();
            }else{
                $('.cont-dictamen-tecnico-movilidad').hide();
                delete_file('st3_dictamen_tecnico_movilidad');
                $('#file_dictamen_tecnico').hide();
            }
        }
    });

});

function step_bd(){
    return $.ajax({
        url: baseURL + "LicenciasGiro/step",
        type: "GET",
        dataType: 'json',
        data: {
            'licencia':$('#tramite').val(),
        }
    });
}

function clear_table(){
    $.ajax({
        url: baseURL + "LicenciasGiro/limpiar_tabla",
        type: "POST",
        dataType: 'json',
        data: {
            'licencia':$('#tramite').val(),
        },
        success: function(data){
            var id=$('#tramite').val();
            var calle_establecimiento=$('#txtDomicilio_establecimiento').val();
            var no_ext_establecimiento=$('#txtNExterior_establecimiento').val();
            var colonia_establecimiento=$('#txtColoniaEstablecimiento').val();
            var ciudad_establecimiento=$('#txtCiudadEstablecimiento').val();
            var estado_establecimiento=$('#txtEstadoEstablecimiento').val();
            var sup_construida_establecimiento=$('#txtSupConstruida').val();
            var area_utilizar_establecimiento=$('#txtAreaUtilizar').val();
            $('input:text').val('');
            $('.erase').val('');
            $('.update_file').hide();
            $('#tramite').val(id);
            $('#txtDomicilio_establecimiento').val(calle_establecimiento);
            $('#txtNExterior_establecimiento').val(no_ext_establecimiento);
            $('#txtColoniaEstablecimiento').val(colonia_establecimiento);
            $('#txtCiudadEstablecimiento').val(ciudad_establecimiento);
            $('#txtEstadoEstablecimiento').val(estado_establecimiento);
            $('#txtSupConstruida').val(sup_construida_establecimiento);
            $('#txtAreaUtilizar').val(area_utilizar_establecimiento);
        }
    });
}

function delete_file(val){
    $.ajax({
        url: baseURL + "LicenciasGiro/deleteFile",
        type: "POST",
        dataType: 'json',
        data: {
            'licencia':$('#tramite').val(),
            'campo':val,
        },
        success: function(data){
        }
    });
}

function pago_linea(){
    $('#enviar_form').trigger('click');
}

function fill_pago(){
    $.ajax({
        url: baseURL + "confirmacion_licencia/pago_linea",
        type: "post",
        dataType: 'json',
        data: {
            'licencia':$('#tramite').val(),
        },
        beforeSend:function(){
            setLoading();
        },
        success: function(data){
            $('#scian_form').val(data.data.scian);
            $('#zona_form').val(data.data.zona);
            $('#sub_zona_form').val(data.data.subzona);
            $('#actividad_form').val(data.data.actividad);
            $('#cvecuenta_form').val(data.data.cvecuenta);
            $('#propietario_form').val(data.data.propietario);
            $('#primer_ap_form').val(data.data.primer_ap);
            $('#segundo_ap_form').val(data.data.segundo_ap);
            $('#rfc_form').val(data.data.rfc);
            $('#curp_form').val(data.data.curp);
            $('#telefono_prop_form').val(data.data.telefono_prop);
            $('#email_form').val(data.data.email);
            $('#calle_form').val(data.data.calle);
            $('#num_ext_form').val(data.data.num_ext);
            $('#let_ext_form').val(data.data.let_ext);
            $('#num_int_form').val(data.data.num_int);
            $('#let_int_form').val(data.data.let_int);
            $('#colonia_form').val(data.data.colonia);
            $('#cp_form').val(data.data.cp);
            $('#sup_autorizada_form').val(data.data.sup_autorizada);
            $('#num_cajones_form').val(data.data.num_cajones);
            $('#num_empleados_form').val(data.data.num_empleados);
            $('#inversion_form').val(data.data.inversion);
            $('#licencia_form').val(data.data.licencia);
            $('#importe_form').val(data.data.importe);
            $('#id_usuario_form').val(data.data.id_usuario);
            $('#usuario_form').val(data.data.usuario);
            $('#contra_form').val(data.data.pass);
            unsetLoading();
        }
    });
}

function getNegocio(){
    $.ajax({
        url: baseURL + "LicenciasGiro/getNegocio",
        type: "GET",
        dataType: 'json',
        data: {
            'licencia':$('#tramite').val(),
        },
        success: function(data){
            NumExtPredio=data.data.predio_numero_ext;
        }
    });
}

function setPass(npass, pass, email) {
    var params = {};
    params["email"] = email;
    params["password"] = md5(pass);
    params["npassword"] = md5(npass);
    return $.ajax({
        url: userURL + "password",
        type: "post",
        dataType: 'json',
        data: params
    });
}


function updateProfile(email, nombres, apepat, apemat, celular){
    var params = {};
    params["email"] = email;
    params["nombres"] = nombres;
    params["ape_pat"] = apepat;
    params["ape_mat"] = apemat;
    params["celular"] = celular;
    return $.ajax({
        url: userURL + "perfil",
        type: "post",
        dataType: 'json',
        data: params
    });
}

function setProfile(nombres, apepat, apemat, celular){
    var params = {};
    params["nombres"] = nombres;
    params["ape_pat"] = apepat;
    params["ape_mat"] = apemat;
    params["celular"] = celular;
    return $.ajax({
        url: baseURL + "sUpdate",
        type: "post",
        dataType: 'json',
        data: params
    });
}


function validaCC(clave){
    var params = {};
    params["clave"] = clave;
    return $.ajax({
        url: baseURL + "validaclavecatastral",
        type: "get",
        dataType: 'json',
        data: params
    });
}

function validaNCP(original, comparar, catastral, factibilidad){
    var params = {};
    params["original"] = original;
    params["compare"] = comparar;
    params["cuenta_catastro"] = catastral;
    params["factibilidad"] = factibilidad;
    return $.ajax({
        url: baseURL + "validacuentapredial",
        type: "get",
        dataType: 'json',
        data: params,
        beforeSend:function(){
            setLoading();
        }
    });
}

function getDataPropietario(clave){
    var params = {};
    params["clave"] = clave;
    return $.ajax({
        url: baseURL + "datosPropietario",
        type: "get",
        dataType: 'json',
        data: params
    });
}

function setFolder(id){
    var params = {};
    params["auth-key"] = '50f14b34Sru81o#10830981';
    params["id_tramite"] = id;
    params["tipo_tramite"] = 'g';
    return $.ajax({
        url: 'https://visorurbano.com/api/vu_mkdir.php',
        type: "post",
        dataType: 'json',
        data: params
    });
}

function setMessage(type, cont, msg) {
    if (type == 'error'){
        classT = 'alert-danger';
    }
    else{
        classT = 'alert-success';
    }
    cont.empty();
    var el = $('<div/>');
    el.addClass('alert ' + classT).html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + msg).appendTo(cont);

}

function setMessage1(msg, error){
    $('.msessage-cont').remove();
    var messageContainer = $('<div/>', {class: 'msessage-cont mui--z2'}).prependTo('section.projects');
    if (error){

    }
    messageContainer.html('<p>' + msg + '</p><div class="close"></div>');
    $('.msessage-cont .close').on('click', function(e){
        e.preventDefault();
        $('.msessage-cont').remove();
    });

    $(window).scrollTop($('.msessage-cont').offset().top);
}

function adjustIframeHeight() {
    var $body   = $('body'),
        $iframe = $body.data('iframe.fv');
    if ($iframe) {
        $iframe.height($body.height());
    }
}

function cleanPropietario(){
    $('#txtNombre').val('');
    $('#txtNombre').parent().find("label").removeClass('active');
    $('#txtCURP').val('');
    $('#txtCURP').parent().find("label").removeClass('active');
    $('#txtRFC').val('');
    $('#txtRFC').parent().find("label").removeClass('active');
    $('#txtDomicilio').val('');
    $('#txtDomicilio').parent().find("label").removeClass('active');
    $('#txtNExterior').val('');
    $('#txtNExterior').parent().find("label").removeClass('active');
    $('#txtNInterior').val('');
    $('#txtNInterior').parent().find("label").removeClass('active');
    $('#txtColonia').val('');
    $('#txtColonia').parent().find("label").removeClass('active');
    $('#txtCiudad').val('');
    $('#txtCiudad').parent().find("label").removeClass('active');
    $('#txtCP').val('');
    $('#txtCP').parent().find("label").removeClass('active');
}

function setError(msg){
    $('.actions ul li a[href=\'#next\']').hide();
    $('li.current').addClass('error');
    $('#errorModal .modal-body ul').empty();
    $.each(msg, function( index, value ) {
        $('#errorModal .modal-body ul').append('<li>'+value+'</li>');
    });
    $('#errorModal').modal();
}

function unsetError(){
    $('.actions ul li a[href=\'#next\']').show();
    $('li.current').removeClass('error');

}

function updateForma(campos, step, id){
    var data = {};
    $.each(campos, function(index, val){
        data[val.name] = val.value;
    });
    data['step'] = step;
    return $.ajax({
        url: baseURL + "licencia/a/update",
        type: "post",
        dataType: 'json',
        data: {'licencia': id, 'campos': data, 'firma':$('#firma_electronica').text()}
    });
}

function consulLicP(id){
    return $.ajax({
        url: baseURL + "LicenciasGiro/redir_validacion",
        type: "post",
        dataType: 'json',
        data: {'licencia': id}
    });
}

function updateFiles(field, fleName, id){
    var data = {};
    data[field] = fleName;
    return $.ajax({
        url: baseURL + "licencia/a/update",
        type: "post",
        dataType: 'json',
        data: {'licencia': id, 'campos': data, 'firma':$('#firma_electronica').text()}
    });
}

var arregloPropietario=[];
function fillPropietario(){
    getDataPropietario($('#claveCatastral').val()).done(function(data){
        if (data.status == 200){
            cleanPropietario();
            arregloPropietario=data.data;
            arregloPropietario.n_exterior = (arregloPropietario.n_exterior != "" ? parseInt(arregloPropietario.n_exterior): "");
            arregloPropietario.n_interior = (arregloPropietario.n_interior != "" ? parseInt(arregloPropietario.n_interior): "");

            $('#txtNombre').parent().find("label").addClass('active');
            $('#txtPApellidoSolicitante').parent().find("label").addClass('active');
            $('#txtSApellidoSolicitante').parent().find("label").addClass('active');
            $('#txtCURP').parent().find("label").addClass('active');
            $('#txtRFC').parent().find("label").addClass('active');
            $('#txtDomicilio').parent().find("label").addClass('active');
            $('#txtNExterior').parent().find("label").addClass('active');
            $('#txtNInterior').parent().find("label").addClass('active');
            $('#txtColonia').parent().find("label").addClass('active');
            $('#txtCiudad').parent().find("label").addClass('active');
            $('#txtCP').parent().find("label").addClass('active');

            $('#txtNombre').val(capitalize(data.data.nombre.toLowerCase()));
            $('#txtPApellidoSolicitante').val(capitalize(data.data.ape_paterno.toLowerCase()));
            $('#txtSApellidoSolicitante').val(capitalize(data.data.ape_materno.toLowerCase()));
            $('#txtCURP').val(data.data.curp);
            $('#txtRFC').val(data.data.rfc);
            $('#txtDomicilio').val(capitalize(data.data.calle.toLowerCase()));
            $('#txtNExterior').val(data.data.n_exterior);
            $('#txtNInterior').val(data.data.n_interior);
            $('#txtColonia').val(capitalize(data.data.colonia.toLowerCase()));
            $('#txtCiudad').val(capitalize(data.data.ciudad.toLowerCase()));
            $('#txtCP').val(data.data.cp);
        }

        $('input:radio[name=st1_tipo_representante]').prop('checked', false);
        $('input:radio[name=st1_tipo_carta_poder]').prop('checked', false);
        $('#rbtCartaPoderSimple').prop('checked', true);
        $('input:radio[name=st1_faculta]').prop('checked', false);
        $('input:radio[name=st1_anuencia]').prop('checked', false);
    });
}


function ResumeLicenciaGiro(){
    switch($('input:radio[name=st1_tipo_solicitante]:checked').val()){
        case 'promotor':
            $('#seccionPromotor').show();
            $('#secRepresentante').show();
            $('.cont-identificacion-solicitante').hide();
        break;
        case 'arrendatario':
            $('#seccionArrendatario').show();
            $('#secRepresentante').hide();
            $('.cont-identificacion-solicitante').show();
        break;
        default:
            $('#secRepresentante').hide();
            $('#seccionArrendatario').hide();
            $('#seccionPromotor').hide();
            $('.cont-identificacion-solicitante').show();
        break;
    }

    if($('input:radio[name=st1_tipo_representante]:checked').val() == 'arrendatario'){
        $('#seccionArrendatario').show();
    }else{
        $('#seccionArrendatario').hide();
    }

    if($('input:radio[name=st1_tipo_carta_poder]:checked').val() == 'simple'){
        $('.anexoCartaPoder').show();
    }else{
        $('.anexoCartaPoder').hide();
    }

    if($('input:radio[name=st1_faculta]:checked').val() == 'n'){
        $('#seccionAnuencia').show();
    }else{
        $('#seccionAnuencia').hide();
        $('#seccionCartaAnuencia').hide();
    }

    if($('input:radio[name=st1_anuencia]:checked').val() == 'n'){
        alert ('hoña');
        errorLicenciaGiro();
        $('#seccionCartaAnuencia').hide();
    }else{
        unsetError();
        if($('input:radio[name=st1_anuencia]:checked').val() == 's'){
            $('#seccionCartaAnuencia').show();
        }

    }
}

function resumenLicenciaGiro(){
    var data = {};
    data['idTramite'] = $('#tramite').val();
    $.ajax({
        type: 'GET',
        url: baseURL + "getTramite",
        data:data,
        dataType: 'json',
        success:function(data){
            $("#resumenIdentificacionSolicitante").remove();
            var resumen_isd = $('<div/>', {id: 'resumenIdentificacionSolicitante'}).appendTo('#resumen-container');
            /* Datos Principales */
            var principalesCont = $('<div/>').appendTo(resumen_isd);
            resumen_isd.append('<table class="mui-table mui-table--bordered"><thead><th>Clave Catastral</th></tr></thead><tbody><tr><td>'+data.data.clave_catastral+'</td></tr></tbody></table>')
            resumen_isd.append('<table class="mui-table mui-table--bordered"><thead><th>Giro solicitado:</th></tr></thead><tbody><tr><td>'+data.data.descripcion_factibilidad+'</td></tr></tbody></table><br><br>')
            /* Identificacion del solicitante */
            resumen_isd.append('<table class="mui-table mui-table--bordered" id="tbl_identificacion_solicitante"><thead><th colspan="3">Identificación del solicitante:</th></tr></thead><tbody><tr><td colspan="3"> <b>Tipo solicitante:</b> '+ data.data.st1_tipo_solicitante + '</td></tr></tbody></table><br><br>');
            if (data.data.st1_tipo_solicitante == 'Promotor'){
                if ( data.data.st1_tipo_representante == 'Propietario'){
                    st1_tipo_representante = 'Representante de persona física/moral que es dueña del predio.';
                }else{
                    st1_tipo_representante = 'Representante de persona física/moral que está rentando el predio.';
                }
                $('#tbl_identificacion_solicitante').append('<tr><td colspan="3"><b>Tipo de Representante:</b> Carta Poder ' + st1_tipo_representante + '</td></tr>');
                $('#tbl_identificacion_solicitante').append('<tr><td colspan="3"><b>Tipo de Poder:</b> Carta poder ' + data.data.st1_tipo_carta_poder + '</td></tr>');
                $('#tbl_identificacion_solicitante').append('<tr><td colspan="3"><a href="'+data.data.st1_carta_poder+'" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> Carta Poder</a></td></tr>');

                if(data.data.st1_tipo_carta_poder == 'Simple'){
                    $('#tbl_identificacion_solicitante').append('<tr><td colspan="3"><a href="'+data.data.st1_identificacion_otorgante+'" target="_blank"><i class="fa fa-id-card-o" aria-hidden="true"></i> Identificación del otorgante</a></td></tr>');
                    $('#tbl_identificacion_solicitante').append('<tr><td colspan="3"><a href="'+data.data.st1_identificacion_testigo1+'" target="_blank"><i class="fa fa-id-card-o" aria-hidden="true"></i> Identificación del Testigo 1</a></td></tr>');
                    $('#tbl_identificacion_solicitante').append('<tr><td colspan="3"><a href="'+data.data.st1_identificacion_testigo2+'" target="_blank"><i class="fa fa-id-card-o" aria-hidden="true"></i> Identificación del Testigo 2</a></td></tr>');
                }
            }

            if (data.data.st1_tipo_solicitante == 'Arrendatario' || data.data.st1_tipo_representante == 'Arrendatario'){
                $('#tbl_identificacion_solicitante').append('<tr><td colspan="3"><a href="'+data.data.st1_contrato_arrendamiento+'" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> Contrato de arrendamiento</a></td></tr>');
                var facutlta = ( data.data.st1_faculta == 'N' ) ? 'No' : 'Si';
                $('#tbl_identificacion_solicitante').append('<tr><td colspan="3"><b>El contrato de arrendamiento te faculta para abrir un negocio:</b> ' + facutlta + '</td></tr>');
                var anuencia = ( data.data.st1_anuencia == 'N' ) ? 'No' : 'Si';
                $('#tbl_identificacion_solicitante').append('<tr><td colspan="3"><b>Cuentas con la anuencia del arrendador para abrir un negocio:</b> ' + anuencia + '</td></tr>');
                if (data.data.st1_anuencia == 'S'){
                    $('#tbl_identificacion_solicitante').append('<tr><td colspan="3"><a href="'+data.data.st1_carta_anuencia+'" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> Carta de anuencia</a></td></tr>');
                }

            }

            /* Datos Representante */
            if (data.data.st1_tipo_solicitante == 'Promotor'){
                resumen_isd.append('<table class="mui-table mui-table--bordered" id="tbl_representante"><thead><th colspan="3">Datos del representante:</th></tr></thead><tbody><tr><td colspan="3"> <b>Nombre del representante:</b> '+ data.data.st2_nombre_representante + ' ' + data.data.st2_priper_apellido_representante + ' ' + data.data.st2_segundo_apellido_representante +'</td></tr>' +
                    '<tr><td><b>C.U.R.P.:</b> '+data.data.st2_curp_representante+'</td><td><b>R.F.C.:</b> '+data.data.st2_rfc_representante+'</td></tr>' +
                    '<tr><td colspan="3"><b>Correo Electrónico:</b> ' +data.data.st2_email_representante+'</td></tr>'+
                    '<tr><td><b>Domicilio:</b> '+data.data.st2_domicilio_representante+'</td><td ><b>Num Ext:</b> '+data.data.st2_num_ext_representante+'</td><td><b>Num Int:</b> '+data.data.st2_num_int_representante+'</td></tr>' +
                    '<tr><td colspan="2"><b>Colonia:</b> '+data.data.st2_colonia_representante+'</td><td colspan="1"><b>C.P.:</b> '+data.data.st2_cp_representante+'</td></tr>' +
                    '<tr><td colspan="2"><b>Ciudad:</b> '+data.data.st2_ciudad_representante+'</td><td colspan="1"><b>Teléfono:</b> '+data.data.st2_telefono_representante+'</td></tr>' +
                    '</tbody></table><br><br>')
                if (data.data.st2_identificacion_representante != ''){
                    $('#tbl_representante').append('<tr><td colspan="3"><a target="_blank" href="'+data.data.st2_identificacion_representante+'"><i class="fa fa-id-card-o" aria-hidden="true"></i> Identificación del representante</a></td></tr>');
                }
            }

            /* Datos Solicitante */
            resumen_isd.append('<table class="mui-table mui-table--bordered" id="tbl_solicitante"><thead><th colspan="3">Datos del solicitante:</th></tr></thead><tbody><tr><td colspan="3"> <b>Nombre del Solicitante/arrendatario:</b> '+ data.data.st2_nombre_solicitante + ' ' + data.data.st2_primer_apellido_solicitante + ' ' + data.data.st2_segundo_apellido_solicitante +'</td></tr>' +
                '<tr><td><b>C.U.R.P.:</b> '+data.data.st2_curp_solicitante+'</td><td><b>R.F.C.:</b> '+data.data.st2_rfc_solicitante+'</td></tr>' +
                '<tr><td colspan="3"><b>Correo Electrónico:</b> ' +data.data.st2_email_solicitante+'</td></tr>'+
                '<tr><td><b>Domicilio:</b> '+data.data.st2_domicilio_solicitante+'</td><td ><b>Num Ext:</b> '+data.data.st2_num_ext_solicitante+'</td><td><b>Num Int:</b> '+data.data.st2_num_int_solicitante+'</td></tr>' +
                '<tr><td colspan="2"><b>Colonia:</b> '+data.data.st2_colonia_solicitante+'</td><td colspan="1"><b>C.P.:</b> '+data.data.st2_cp_solicitante+'</td></tr>' +
                '<tr><td colspan="2"><b>Ciudad:</b> '+data.data.st2_ciudad_solicitante+'</td><td colspan="1"><b>Teléfono:</b> '+data.data.st2_telefono_solicitante+'</td></tr>' +
                '</tbody></table><br><br>');
            if (data.data.st2_identidficacion_solicitante != ''){
                $('#tbl_solicitante').append('<tr><td colspan="3"><a target="_blank" href="'+data.data.st2_identidficacion_solicitante+'"><i class="fa fa-id-card-o" aria-hidden="true"></i> Identificación del propietario/arrendatario</a></td></tr>');
            }

            /* Datos del Establecimiento */
            if (data.data.st3_nombre_establecimiento != ''){
                nombreEstablecimiento = data.data.st3_nombre_establecimiento;
            }
            else{
                nombreEstablecimiento = 'No definido';
            }

            if (data.data.st3_especificaciones_establecimiento != ''){
                referenciasEstablecimiento = data.data.st3_especificaciones_establecimiento;
            }
            else{
                referenciasEstablecimiento = 'Sin referencias';
            }
            resumen_isd.append('<table class="mui-table mui-table--bordered" id="tbl_establecimiento"><thead><th colspan="3">Datos del establecimiento:</th></tr></thead><tbody><tr><td colspan="3"> <b>Nombre comercial del negocio: </b></bZ></b> '+ nombreEstablecimiento +'</td></tr>' +
                '<tr><td><b>Domicilio:</b> '+data.data.st3_domicilio_establecimiento+'</td><td ><b>Num Ext:</b> '+data.data.st3_num_ext_establecimiento+'</td><td><b>Letra Ext:</b> '+data.data.st3_letra_ext_establecimiento+'</td></tr>' +
                '<tr><td><b>Colonia:</b> '+data.data.st3_colonia_establecimiento+'</td><td ><b>Num Int:</b> '+data.data.st3_num_int_establecimiento+'</td><td><b>Letra Int:</b> '+data.data.st3_letra_int_establecimiento+'</td></tr>' +
                '<tr><td><b>Ciudad:</b> '+data.data.st3_ciudad_establecimiento+'</td><td ><b>Estado:</b> '+data.data.st3_estado_establecimiento+'</td><td><b>C.P.:</b> '+data.data.st3_cp_establecimiento+'</td></tr>' +
                '<tr><td colspan="3"><b>Referencias del inmueble:</b> ' +referenciasEstablecimiento+'</td></tr>'+
                '<tr><td><b>Edificio o Plaza:</b> '+data.data.st3_edificio_plaza_establecimiento+'</td><td ><b>Número de local:</b> '+data.data.st3_num_local_establecimiento+'</td><td><b>Superficie construida:</b> '+data.data.st3_sup_construida_establecimiento+' mts. </td></tr>' +
                '<tr><td><b>Area a utilizar:</b> '+data.data.st3_area_utilizar_establecimiento+' mts.</td><td ><b>Inversión estimada:</b> $'+data.data.st3_inversion_establecimiento+'</td><td><b>Número de empleados:</b> '+data.data.st3_empleados_establecimiento+'</td></tr>' +
                '<tr><td colspan="3"><b>Número de cajones de estacionamiento:</b> ' + data.data.st3_cajones_estacionamiento_establecimiento +'</td></tr>'+
                '<tr><td colspan="3"><a href="'+data.data.st3_img1_establecimiento+'" target="_blank"><i class="fa fa-file-image-o" aria-hidden="true"></i> Fotografía Panorámica de la fachada completa</a></td></tr>'+
                '<tr><td colspan="3"><a href="'+data.data.st3_img2_establecimiento+'" target="_blank"><i class="fa fa-file-image-o" aria-hidden="true"></i> Fotografía Panorámica de la fachada con la puerta o cortina abierta</a></td></tr>'+
                '<tr><td colspan="3"><a href="'+data.data.st3_img3_establecimiento+'" target="_blank"><i class="fa fa-file-image-o" aria-hidden="true"></i> Fotografía del Interior del Establecimiento</a></td></tr>'+
                '</tbody></table><br><br>');


        },
        error:function(){

        }
    });


    $('.cadenaFirmar').empty();
    var nombreFirmar = ($('input:radio[name=st1_tipo_solicitante]:checked').val() == 'promotor')?$('input:text[name=st2_nombre_representante]').val():$('input:text[name=st2_nombre_solicitante]').val();
    var primerApellidFirmar = ($('input:radio[name=st1_tipo_solicitante]:checked').val() == 'promotor')?$('input:text[name=st2_priper_apellido_representante]').val():$('input:text[name=st2_primer_apellido_solicitante]').val();
    var segundoApellidFirmar = ($('input:radio[name=st1_tipo_solicitante]:checked').val() == 'promotor')?$('input:text[name=st2_segundo_apellido_representante]').val():$('input:text[name=st2_segundo_apellido_solicitante]').val();
    var d = new Date();
    $('.cadenaFirmar').html('Nombre|=|'+nombreFirmar+'|+|Primer Apellido|=|'+primerApellidFirmar+'|+|Segundo Apellido|=|'+primerApellidFirmar+'|+|Tramite|=|'+$('#tramite').val()+'|+|Actividad|=|'+$('#descActividad').text()+'|+|Fecha|=|'+ d.getDate()  + "/" + (d.getMonth()+1) + "/" + d.getFullYear());
    //$('#firamarCadenaOriginal').html('Nombre|=|'+nombreFirmar+'|+|Primer Apellido|=|'+primerApellidFirmar+'|+|Segundo Apellido|=|'+primerApellidFirmar+'|+|Tramite|=|'+$('#tramite').val()+'|+|Actividad|=|'+$('#descActividad').text()+'|+|Fecha|=|'+ d.getDate()  + "/" + (d.getMonth()+1) + "/" + d.getFullYear());

}

function capitalize(s)
{
    return s[0].toUpperCase() + s.slice(1);
}

function loadFile(element){
    el = $("#" + element.id);
    var file = document.getElementById(element.id).files[0];
    var data = new FormData();
    data.append('auth','50f14b34Sru81o#10830981');
    data.append('folio', $('#tramite').val());
    data.append('documento',file);
    data.append('name', el.data('type'));
    var contObj = el.parent();
    if (el.valid() == true) {
        $.ajax({
            type: 'POST',
            url: 'https://visorurbano.guadalajara.gob.mx/api/vu_up.php',
            contentType:false,
            data:data,
            processData:false,
            beforeSend:function(){
                $('#'+el.data('elastic')).css('margin','15px 0px');
                var circle = new ProgressBar.Line('#'+el.data('elastic'), {
                    color: '#8CBC5F',
                    easing: 'easeInOut'
                });

                circle.animate(1.0, {
                    duration: 900
                }, function() {
                   circle.destroy();
                    $('#'+el.data('elastic')).css('margin','0px');
                });


            },
            success:function(data){
                var serialized = eval("(" + data + ")");
                contObj.find('.link-to-file').remove();
                contObj.append('<a href="'+serialized.url+'" target="_blank" class="link-to-file update_file"><i class="fa fa-file-text-o" aria-hidden="true"></i> '+el.data('text')+'</a>');
                updateFiles(el.data('type'), serialized.url ,$('#tramite').val()).done(function(data){
                });
            },
            error:function(){

            }
        });
    }
}
    function generar_carta(){
        if ($('#FormCartaModel').valid()){
            var nombre = $('#nombreCompletoSuscrita').val();
            var doc = $('#documentoIdentificacion').val();
            var numero_doc = $('#numeroIdentificacion').val();
            var domicilio = $('#domicilioPredio').val();
            var clave = $('#claveCatastralModal').val();
            window.open(baseURL+'/formatos/carta_responsiva_pdf?nombre='+nombre+'&doc='+doc+'&numero_doc='+numero_doc+'&domicilio='+domicilio+'&clave='+clave);
            $('#responsivaModel').modal('hide');
            $('#nombreCompletoSuscrita').val('');
            $('#documentoIdentificacion').val('');
            $('#numeroIdentificacion').val('');
            $('#domicilioPredio').val('');
            $('#claveCatastralModal').val('');
        }
    }

    function validateFirma(){
        if ($('#frmFirmar').valid()){
            var cer = document.getElementById('fleCER').files[0];
            var key = document.getElementById('fleKEY').files[0];
            var data = new FormData();
            data.append('id_tramite', $('#txtFirmaTramite').val());
            data.append('cadena_original', $('.cadenaFirmar').text());
            data.append('pass', $('#txtPassFIEL').val());
            data.append('cer',cer);
            data.append('key',key);
            $.ajax({
                type: 'POST',
                url: 'https://visorurbano.guadalajara.gob.mx/api/vu_firma.php',
                contentType:false,
                data:data,
                processData:false,
                success:function(data){
                    $('#txtPassFIEL').val('');
                    $('#txtPassFIEL').removeClass('mui--is-dirty mui--is-not-empty valid mui--is-touched');
                    $('#fleKEY').val('');
                    $('#fleCER').val('');
                    $('#firmaModal').modal('hide');
                    var sdata = eval("(" + data + ")");
                    if (sdata.status != 200){
                        $('#firma_electronica').empty();
                        $('#contMSGFirmaError').empty().append('<div class="alert alert-danger"><strong>Error: </strong>'+sdata.message+'</div>')
                    }else{
                        var nombreTitular = (sdata.titular[0]);
                        var curpTitular = (sdata.titular[4]);
                        var rfcTitular = (sdata.titular[3]);
                        //var rfcTitular = ($('#txtCURPRep').val().toUpperCase());
                        if($('input:radio[name=st1_tipo_solicitante]:checked').val() == 'promotor'){
                            if (nombreTitular == ($('#txtNombreRep').val().toUpperCase() + ' ' + $('#txtPApellido').val().toUpperCase() + ' ' + $('#txtSApellido').val().toUpperCase()) && curpTitular == $('#txtCURPRep').val().toUpperCase() && rfcTitular == $('#txtCURPRep').val().toUpperCase()){
                                $('#contMSGFirmaError').empty();
                                $('#firma_electronica').empty().text(sdata.firma);
                                $('.contErrorInsideFirma').remove();
                            }else{
                                $('.contErrorInsideFirma').remove();
                                $('#firmaContainer').append('<span style="color: #F35B53;" class="contErrorInsideFirma">Los datos del Representante no coinciden con los de la firma electrónica.</span>');
                            }
                        }else{
                            var nombre = $('#txtNombre').val().toUpperCase() + ' ' + $('#txtPApellidoSolicitante').val().toUpperCase() + ' ' + $('#txtSApellidoSolicitante').val().toUpperCase();

                            if (nombreTitular == nombre.trim() && curpTitular == $('#txtCURP').val().toUpperCase() && rfcTitular == $('#txtRFC').val().toUpperCase()){
                                $('#contMSGFirmaError').empty();
                                $('#firma_electronica').empty().text(sdata.firma);
                                $('.contErrorInsideFirma').remove();
                            }else{
                                $('.contErrorInsideFirma').remove();
                                $('#firmaContainer').append('<span style="color: #F35B53;" class="contErrorInsideFirma">Los datos del Propietario/Arrendatario no coinciden con los de la firma electrónica.</span>');
                            }
                        }
                    }
                },
                error:function(){

                }
            });
        }
    }
