var getUrl = window.location;
var params = getUrl.pathname.split('/')[3];
if(params){
    $('#titulo').text('Detalle');
    $('#contenido_tablas').hide();
    $('#contenido_detalle').show();
    detalle_revision(params);
}else{
    $('#contenido_tablas').show();
    $('#contenido_detalle').hide();
}

var table = $('.style_table').DataTable({
    "ordering": false,
    "info":     false,
    "paging":   false,
    "oLanguage": {
        "sSearch": "<span>Buscar licencias:</span> _INPUT_",
        "sEmptyTable": "No se encontrarón licencias :(",
        "sZeroRecords": "No se encontrarón coincidencias :(",
    },
    "language": {
        "sZeroRecords": "No records to display"
    }
});

function traer_informacion(val){
  $.ajax({
      type: "POST",
      dataType: "json",
      url: baseURL + "RevisionController/licencias",
      data:{
        "tipo":val,
      },
      success:function(data){
          var identificador;
          var idTablas;
          switch (val) {
            case "T":
            identificador=$('#tblTodas').DataTable();
            idTablas="Todas";
            break;
            case "R":
            identificador=$('#tblRevisadas').DataTable();
            idTablas="Revisadas";
            break;
            case "P":
            identificador=$('#tblPrioritarios').DataTable();
            idTablas="Prioritarios";
            break;
          }
          if(data.status){
            identificador.rows().remove().draw();
            for (var i = 0; i < data.data.length; i++) {
                identificador.row.add( [
                    data.data[i].st2_nombre_solicitante,
                    data.data[i].descripcion_factibilidad,
                    data.data[i].fecha,
                    (data.data[i].status == 'S' ? 'Solventación' :(data.data[i].status == 'FL' && data.data[i].revisada == 1 ? 'Aprovada' : 'Finalizada')),
                    '<a href="'+baseURL+'revision/'+data.data[i].id_encrip+'" onclick="detalle_revision('+"'"+data.data[i].id_encrip+"'"+')"><i class="fa fa-eye" aria-hidden="true"></i> Ver</a>'
                ] ).draw( false );
              
             }
          }else{

          }
        }
    });
}
var id_usuario_lic;
var usuario;
function detalle_revision(val){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: baseURL + "RevisionController/licencias_id",
        data:{
          "id":val,
        },
        success:function(data){
            if(data.status){
                $('#actividad').text(data.data[0].descripcion_factibilidad);
                $('#tipo').text(data.data[0].st1_tipo_solicitante);
                $('#nombre_sol').text(data.data[0].	st2_nombre_solicitante);
                $('#primer_apellido_sol').text(data.data[0].st2_primer_apellido_solicitante);
                $('#segunda_apellido_sol').text(data.data[0].st2_segundo_apellido_solicitante);
                $('#curp_sol').text(data.data[0].st2_curp_solicitante);
                $('#rfc_sol').text(data.data[0].st2_rfc_solicitante);
                $('#email_sol').text(data.data[0].st2_email_solicitante);
                $('#domicilio_sol').text(data.data[0].st2_domicilio_solicitante);
                $('#num_ext_sol').text(data.data[0].st2_num_ext_solicitante);
                $('#num_int_sol').text(data.data[0].st2_num_int_solicitante);
                $('#colonia_sol').text(data.data[0].st2_colonia_solicitante);
                $('#ciudad_sol').text(data.data[0].st2_ciudad_solicitante);
                $('#cp_sol').text(data.data[0].st2_cp_solicitante);
                $('#tel_sol').text(data.data[0].st2_telefono_solicitante);

                $('#tipo_representante').text(data.data[0].st1_representante);
                $('#tipo_carta').text(data.data[0].st1_tipo_carta_poder);
                $('#carta_poder').append('<a href="'+data.data[0].st1_carta_poder+'" data-lightbox="carta poder"> <i class="fa fa-file-text-o" aria-hidden="true"></i> Carta Poder</a>');
                $('#ft_id_otorgante').append('<a href="'+data.data[0].st1_identificacion_otorgante+'" data-lightbox="Identificación otorgante""> <i class="fa fa-file-text-o" aria-hidden="true"></i> Identificación del otorgante</a>');
                $('#ft_id_testigo1').append('<a href="'+data.data[0].st1_identificacion_testigo1+'" data-lightbox="Identificación testigo 1"> <i class="fa fa-file-text-o" aria-hidden="true"></i> Identificacón del testigo 1</a>');
                $('#ft_id_testigo2').append('<a href="'+data.data[0].st1_identificacion_testigo2+'" data-lightbox="Identificación testigo 2"> <i class="fa fa-file-text-o" aria-hidden="true"></i> Identificacón del testigo 2</a>');

                $('#nombre_re').text(data.data[0].st2_nombre_representante);
                $('#primer_apellido_re').text(data.data[0].st2_priper_apellido_representante);
                $('#segunda_apellido_re').text(data.data[0].st2_segundo_apellido_representante);
                $('#curp_re').text(data.data[0].st2_curp_representante);
                $('#rfc_re').text(data.data[0].st2_rfc_representante);
                $('#email_re').text(data.data[0].st2_email_representante);
                $('#domicilio_re').text(data.data[0].st2_domicilio_representante);
                $('#num_ext_re').text(data.data[0].st2_num_ext_representante);
                $('#num_int_re').text(data.data[0].st2_num_int_representante);
                $('#colonia_re').text(data.data[0].st2_colonia_representante);
                $('#ciudad_re').text(data.data[0].st2_ciudad_representante);
                $('#cp_re').text(data.data[0].st2_cp_representante);
                $('#tel_re').text(data.data[0].st2_telefono_representante);
                $('#ft_id_representante').append('<a href="'+data.data[0].st2_identificacion_representante+'" data-lightbox="Identificaión del representante"> <i class="fa fa-file-text-o" aria-hidden="true"></i> Identificacón del representante</a>');

                $('#nombre_es').text(data.data[0].st3_nombre_establecimiento);
                $('#cvecatastral').text(data.data[0].clave_catastral);
                $('#domicilio_es').text(data.data[0].st3_domicilio_establecimiento);
                $('#num_ext_es').text(data.data[0].st3_num_ext_establecimiento);
                $('#num_int_es').text(data.data[0].st3_num_int_establecimiento);
                $('#letra_ext_es').text(data.data[0].st3_letra_ext_establecimiento);
                $('#letra_int_es').text(data.data[0].st3_letra_int_establecimiento);
                $('#colonia_es').text(data.data[0].st3_colonia_establecimiento);
                $('#ciudad_es').text(data.data[0].st3_ciudad_establecimiento);
                $('#estado_es').text(data.data[0].st3_estado_establecimiento);
                $('#cp_es').text(data.data[0].st3_cp_establecimiento);
                $('#num_es').text(data.data[0].st3_num_local_establecimiento);
                $('#superficie_es').text(data.data[0].st3_sup_construida_establecimiento+' mts');
                $('#area_es').text(data.data[0].st3_area_utilizar_establecimiento+' mts');
                $('#inversion_es').text("$"+data.data[0].st3_inversion_establecimiento);
                $('#num_empleado_es').text(data.data[0].st3_empleados_establecimiento);
                $('#cajones_es').text(data.data[0].st3_cajones_estacionamiento_establecimiento);

                $('#ft_fachada').append('<a href="'+data.data[0].st3_img1_establecimiento+'" data-lightbox="Foto fachada"> <i class="fa fa-picture-o" aria-hidden="true"></i> fotografia.jpg</a>');
                $('#ft_puerta_abierta').append('<a href="'+data.data[0].st3_img2_establecimiento+'" data-lightbox="Foto puerta abierta"> <i class="fa fa-picture-o" aria-hidden="true"></i> fotografia.jpg</a>');
                $('#ft_interior').append('<a href="'+data.data[0].st3_img3_establecimiento+'" data-lightbox="Foto interior"> <i class="fa fa-picture-o" aria-hidden="true"></i> fotografia.jpg</a>');
                id_usuario_lic = data.data[0].id_usuario;
                usuario = data.usu;
                if(data.data[0].st1_tipo_solicitante == 'promotor'){
                    $('#datos_representante').show();
                }
                if(data.data[0].revisada == 1){
                    $('#radios_revision').hide();
                    $('#enviar').attr('onclick','writeMessage()');
                }else if(data.data[0].revisada == 1 && data.data[0].status == 'S'){
                    $('#rdSolventacion').prop('checked',true);
                }
            }
        }
     });
}

function writeMessage() {
    var params = {};
    params["de"] = usuario;
    params["para"] = id_usuario_lic;
    params["mensaje"] = $('#mensaje').val();
    $.ajax({
        url: baseURL + 'admin/setMensaje',
        type: "post",
        dataType: 'json',
        data: params,
        success:function(data){
            cancelar();
        }
    });
}

function enviar_revision(){
    if(!$('input[name=rdStatus]:checked').val()){
        var errores=[];
        errores[0] = 'Colocar revisión';
        setError(errores);
    }else{
        $.ajax({
            url: baseURL + 'RevisionController/revision_lic',
            type: "post",
            dataType: 'json',
            data:{
                'id':params,
                'revisada':$('input[name=rdStatus]:checked').val(),
            },
            success:function(data){
                writeMessage();
            }
        });
    }
}

function cancelar(){
    window.location=baseURL+"revision";
}

function setError(msg){
    $('li.current').addClass('error');
    $('#errorModal .modal-body ul').empty();
    $.each(msg, function( index, value ) {
        $('#errorModal .modal-body ul').append('<li>'+value+'</li>');
    });
    $('#errorModal').modal();
}

function unsetError(){
    $('li.current').removeClass('error');
}

traer_informacion('T');
