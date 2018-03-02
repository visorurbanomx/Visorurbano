
if(!$('#datos').val()){
    $('#boton').append('<center><h3><i class="fa fa-frown-o" aria-hidden="true"></i> Parámetros incorrectos; imposible imprimir licencia</h3></center>');
}else{
    $.ajax({
        url: baseURL + 'Confirmacion_licencia/confirmacion_lic',
        type: "GET",
        dataType: 'json',
        data: {
            'id_l': $('#datos').val()
        },
        success:function(data){
            if(data.status){
                $('#boton').append('<section>'+
                    '<div class="row">'+
                        '<div class="col-md-12">'+
                                '<h3>Imprimir licencia:</h3><a href="'+baseURL+'formatos/licencia_pdf?lic='+data.data.lic+'&usu='+data.data.usu+'" target="_blank" class="mui-btn mui-btn--primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Licencia</a>'+
                        '</div>'+
                    '</div>'+
                '</section>');
            }else{
                if(data.tipo == 'FL'){
                    window.location = baseURL + "admin/mis-licencias";
                }else{
                    $('#boton').append('<center><h3><i class="fa fa-frown-o" aria-hidden="true"></i> Parámetros incorrectos; imposible imprimir licencia</h3></center>');
                }
            }
        }
    });
}
