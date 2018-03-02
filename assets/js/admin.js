$(document).ready(function () {
    'use strict';
    // ------------------------------------------------------- //
    // Mensajes
    // ------------------------------------------------------ //
    if ($('#tblMensajes').length){
        $('#tblMensajes').DataTable({
            "ordering": false,
            "info":     false,
            "paging":   false,
            "oLanguage": {
                "sSearch": "<span>Buscar mensaje:</span> _INPUT_",
                "sEmptyTable": "No se encontraron mensajes :(",
                "sZeroRecords": "No hay información para mostrar con los criterios de busqueda indicados."
            },
            "language": {
                "zeroRecords": "No records to display"
            }
        });
    }

    if ($('#tblImpresionLicencia').length){
        $('#tblImpresionLicencia').DataTable({
            "ordering": false,
            "info":     false,
            "paging":   true,
            "oLanguage": {
                "oPaginate": {
                    "sNext": "Siguiente Pagina",
                    "sPrevious": "Pagina Anterior",
                },
                "sSearch": "<span>Buscar Licencia:</span> _INPUT_",
                "sEmptyTable": "No data available in tablesss",
                "sZeroRecords": "No hay información para mostrar con los criterios de busqueda indicados.",
                "sLengthMenu": 'Mostrar <select>'+
                '<option value="10">10</option>'+
                '<option value="20">20</option>'+
                '<option value="30">30</option>'+
                '<option value="40">40</option>'+
                '<option value="50">50</option>'+
                '<option value="-1">Todas</option>'+
                '</select> Licencias'
            }
        });
    }

    if ($('#tblVentanilla').length){
        $('#tblVentanilla').DataTable({
            "ordering": false,
            "info":     false,
            "paging":   true,
            "oLanguage": {
                "oPaginate": {
                    "sNext": "Siguiente Pagina",
                    "sPrevious": "Pagina Anterior",
                },
                "sSearch": "<span>Buscar Trámite:</span> _INPUT_",
                "sEmptyTable": "No existen trámites para mostrar",
                "sZeroRecords": "No hay información para mostrar con los criterios de busqueda indicados.",
                "sLengthMenu": 'Mostrar <select>'+
                '<option value="10">10</option>'+
                '<option value="20">20</option>'+
                '<option value="30">30</option>'+
                '<option value="40">40</option>'+
                '<option value="50">50</option>'+
                '<option value="-1">Todas</option>'+
                '</select> trámites'
            }
        });
    }

    if ($('#tbltVentanilla').length){
        $('#tbltVentanilla').DataTable({
            "ordering": false,
            "info":     false,
            "paging":   true,
            "oLanguage": {
                "oPaginate": {
                    "sNext": "Siguiente Pagina",
                    "sPrevious": "Pagina Anterior",
                },
                "sSearch": "<span>Buscar Trámite:</span> _INPUT_",
                "sEmptyTable": "No existen trámites para mostrar",
                "sZeroRecords": "No hay información para mostrar con los criterios de busqueda indicados.",
                "sLengthMenu": 'Mostrar <select>'+
                '<option value="10">10</option>'+
                '<option value="20">20</option>'+
                '<option value="30">30</option>'+
                '<option value="40">40</option>'+
                '<option value="50">50</option>'+
                '<option value="-1">Todas</option>'+
                '</select> trámites'
            }
        });
    }

});

function validar_ventanilla(red){
    $.ajax({
        url: baseURL + "LicenciasGiro/validar_ventanilla",
        type: "post",
        dataType: 'json',
        data:{
            'datos':red,
        },
        success: function(data){
            window.location=red;
        }
    });
}

function logout(){
   acLogout().done(function(data){
        if (data.status == 200){
            window.location.href = baseURL+"ingresar";
        }
   });
}

function acLogout(){
    return $.ajax({
        url: baseURL + "auth/logout",
        type: "post",
        dataType: 'json',
    });
}
