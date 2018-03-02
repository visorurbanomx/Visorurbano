function setLoading(){
    $('#overlayLoading').remove();
    var overlay = $('<div/>',{id:'overlayLoading'}).appendTo($('body'));
    var contLoading = $('<div/>',{id:'overlayLoadingContent', class:'mui--z2'}).appendTo(overlay);
    $('body').css('overflow', 'hidden');
    $('#overlayLoading').attr('style','position:fixed;');
}

function unsetLoading(){
    $('#overlayLoading').remove();
    $('body').css('overflow-y', 'auto');
}

function errorLicenciaGiro(n, msg){
    $('#overlayError').remove();
    $('li.current').addClass('error');
    var overlay = $('<div/>',{id:'overlayError'}).appendTo($('body'));
    var contLoading = $('<div/>',{id:'overlayErrorContent', class:'mui--z2'}).appendTo(overlay);
    contLoading.append('<h3><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> El trámite no puede continuar por las siguientes razones:</h3>');
    contLoading.append('<ul></ul>');
    contLoading.append('<div class="footer"><a href="javascript:removeErrorLicenciaGiro('+n+')" class="mui-btn">Entiendo</a></div>')
    $('body').css('overflow', 'hidden');
    $.each(msg, function( index, value ) {
        $('#overlayErrorContent ul').append('<li>'+value+'</li>');
    });
}

function removeErrorLicenciaGiro(n){
    $('#overlayError').remove();
    $('body').css('overflow-y', 'auto');
    switch (n){
        case 1:
            $('input:radio[name=st1_anuencia]').prop('checked', false);
        break;
    }
}

function setWarning(msg){
    $('#overlayError').remove();
    var overlay = $('<div/>',{id:'overlayError'}).appendTo($('body'));
    var contLoading = $('<div/>',{id:'overlayWarningContent', class:'mui--z2'}).appendTo(overlay);
    contLoading.append('<h3><i class="fa fa-info-circle" aria-hidden="true"></i> Importante:</h3>');
    contLoading.append('<span>Se encontrarón las siguientes diferencias entre los datos proporcionados del propietario y la base de datos de Guadalajara: </span>');
    contLoading.append('<ul></ul>');
    contLoading.append('<div class="footer"><a href="javascript:removeWarning()" class="mui-btn">Entiendo</a></div>')
    $('body').css('overflow', 'hidden');
    $.each(msg, function( index, value ) {
        $('#overlayWarningContent ul').append('<li>'+value+'</li>');
    });
}

function continuarVentanilla(){
    $('#overlayError').remove();
    var overlay = $('<div/>',{id:'overlayError'}).appendTo($('body'));
    var contLoading = $('<div/>',{id:'overlayWarningContent', class:'mui--z2'}).appendTo(overlay);
    contLoading.append('<h3><i class="fa fa-info-circle" aria-hidden="true"></i> Continuar el trámite de manera presencial en ventanilla.</h3>');
    contLoading.append('<br><span style="margin-bottom: 40px;">Si no cuentas con tu firma electrónica y deseas finalizar tu trámite, acude a las ventanillas de la Dirección de padrón y Licencias de Guadalajara para continuar con el proceso.<br><br><i class="fa fa-map-marker" aria-hidden="true"></i> Av 5 de Febrero 249, Las Conchas, 44460 Guadalajara, Jal.</span><br>');
    contLoading.append('<div class="footer"><button type="button" class="mui-btn" id="btnVentanilla">Aceptar</button><a href="javascript:removeWarning()" class="mui-btn mui-btn--danger">Cancelar</a></div>')
    $('body').css('overflow', 'hidden');

    $('#btnVentanilla').on('click', function(e){
        e.preventDefault();
        var dataSend = {name:"status", value:"V"};
        updateForma(new Array(dataSend), 0, $('#tramite').val()).done(function(data){
            window.location.href = baseURL + "admin";
        });
    });
}

function removeWarning(){
    $('#overlayError').remove();
    $('body').css('overflow-y', 'auto');
}
