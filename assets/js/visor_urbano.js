(function($) {
  "use strict";

  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 48)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  //Cierra el menu resposivo
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });

  //Boton  de busqueda
    $('#btnBuscar').on('click', function(){
      if ($('#txtCritero').val() != ''){
          window.location.replace("http://visorurbano.guadalajara.gob.mx/mapa/?criterio=" + $('#txtCritero').val());
      }
    });

})(jQuery);
