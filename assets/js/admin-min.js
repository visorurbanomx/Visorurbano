function validar_ventanilla(o){$.ajax({url:baseURL+"LicenciasGiro/validar_ventanilla",type:"post",dataType:"json",data:{datos:o},success:function(a){window.location=o}})}function logout(){acLogout().done(function(o){200==o.status&&(window.location.href=baseURL+"ingresar")})}function acLogout(){return $.ajax({url:baseURL+"auth/logout",type:"post",dataType:"json"})}$(document).ready(function(){"use strict";$("#tblMensajes").length&&$("#tblMensajes").DataTable({ordering:!1,info:!1,paging:!1,oLanguage:{sSearch:"<span>Buscar mensaje:</span> _INPUT_",sEmptyTable:"No se encontraron mensajes :(",sZeroRecords:"No hay información para mostrar con los criterios de busqueda indicados."},language:{zeroRecords:"No records to display"}}),$("#tblImpresionLicencia").length&&$("#tblImpresionLicencia").DataTable({ordering:!1,info:!1,paging:!0,oLanguage:{oPaginate:{sNext:"Siguiente Pagina",sPrevious:"Pagina Anterior"},sSearch:"<span>Buscar Licencia:</span> _INPUT_",sEmptyTable:"No data available in tablesss",sZeroRecords:"No hay información para mostrar con los criterios de busqueda indicados.",sLengthMenu:'Mostrar <select><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option><option value="-1">Todas</option></select> Licencias'}}),$("#tblVentanilla").length&&$("#tblVentanilla").DataTable({ordering:!1,info:!1,paging:!0,oLanguage:{oPaginate:{sNext:"Siguiente Pagina",sPrevious:"Pagina Anterior"},sSearch:"<span>Buscar Trámite:</span> _INPUT_",sEmptyTable:"No existen trámites para mostrar",sZeroRecords:"No hay información para mostrar con los criterios de busqueda indicados.",sLengthMenu:'Mostrar <select><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option><option value="-1">Todas</option></select> trámites'}}),$("#tbltVentanilla").length&&$("#tbltVentanilla").DataTable({ordering:!1,info:!1,paging:!0,oLanguage:{oPaginate:{sNext:"Siguiente Pagina",sPrevious:"Pagina Anterior"},sSearch:"<span>Buscar Trámite:</span> _INPUT_",sEmptyTable:"No existen trámites para mostrar",sZeroRecords:"No hay información para mostrar con los criterios de busqueda indicados.",sLengthMenu:'Mostrar <select><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option><option value="-1">Todas</option></select> trámites'}})});