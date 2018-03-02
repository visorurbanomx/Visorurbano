(function($) {
    "use strict";
    $("#frmSolicitudGiro").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        labels: {
            cancel: "Cancelar",
            current: "Paso actual:",
            pagination: "Pganinación",
            finish: "Finalizar",
            next: "Siguiente",
            previous: "Anterior",
            loading: "Cargando ..."
        }
    });


})(jQuery);
