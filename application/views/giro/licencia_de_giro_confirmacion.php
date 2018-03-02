<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Confirmación de cuenta predial</h2>
        </div>
    </header>
    <!-- Projects Section-->
    <section class="projects">
        <div class="container-fluid">
            <?php if($status == 200): ?>
                <?php if ($adeudo > 0): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Error.</strong> El trámite no puede continuar por que el predio presenta un adeudo. <br>
                        Puedes realizar tu pago <a href="url_pago_predial">aquí</a>
                    </div>
                <?php else: ?>
                    <form id="frmLicenciaGiroConfirmar" class="frmAdmin mui-form">
                        <input type="hidden" id="txtCPE" value="<?= $cpredial ?>">
                        <input type="hidden" id="txtCC" value="<?= $cuenta ?>">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="mui-textfield mui-textfield--float-label">
                                    <input id="txtCuentaPredial" type="text" maxlength="13" name="numeroPredial"  class="input-material" required>
                                    <label for="txtCuentaPredial">Número de cuenta predial</label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mui-textfield mui-textfield--float-label">
                                    <input id="txtFFactibilidad" type="text" maxlength="13" name="folioFactibilidad"  class="input-material upercase" required>
                                    <label for="txtFFactibilidad">Folio de factibilidad de visor urbano</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group aviso-privacidad">
                                    <label>
                                        <input  type="checkbox" name="agreeAvisoPrivacidad" value="agree" required="" aria-required="true">
                                         He leído y acepto el <a href="#" data-toggle="modal" data-target="#mdlTerminosCondiciones">aviso de privacidad.</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button id="btnConfirmarLicencias" class="mui-btn mui-btn--primary" type="button">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="msg"></div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Error.</strong> La clave catastral: <?=$cuenta; ?> no es valida.
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
</div>
</div>

<!-- Modal Terminos y Condiciones-->
<div id="mdlTerminosCondiciones" class="modal" role="dialog" style="margin-top: 80px;">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">AVISO DE PRIVACIDAD</h4>
            </div>
            <div class="modal-body crearCunentaTerminosCondiciones">
                <h4>Identidad del Responsable.</h4>
                <p>
                    Ayuntamiento Constitucional de Guadalajara, Jalisco, con domicilio en Av. Miguel Hidalgo y Costilla sin número, Zona Centro, Código Postal: 44100 Guadalajara, Jalisco, está comprometido con la protección de sus datos personales, al ser responsable de su uso, manejo y confidencialidad mediante la continua revisión de nuestros procesos de protección de datos de manera física como electrónica.
                </p>
                <br>
                <h4>Finalidad del tratamiento de los datos personales.</h4>
                <p>
                    Los datos personales que usted remita a la plataforma en línea “Visor Urbano” o que el ayuntamiento de Guadalajara obtenga por cualquier otra forma que se encuentre apegada a la Ley, por ejemplo, bases de datos públicas, juicios, información de transparencia, internet, entre otras, tendrán el siguiente tratamiento:
                    <ul style="padding-left: 20px;">
                        <li>
                            La denominada e-firma, que es el archivo digital que te identifica al realizar trámites por internet emitido por el SAT, únicamente tendrá como usos el de identificación de usted, y no se otorgará a ningún ente público y/o privado que lo solicite, salvo disposición jurisdiccional.
                        </li>
                        <li>
                            La emisión de los actos administrativos que usted solicite su emisión, describiendo de manera enunciativa más no limitativa los siguientes: Dictamen de Trazos Usos y Destinos, Dictamen de Trazos Usos y Destinos Específicos, Certificado de Alineamiento y Número Oficial, Licencias de Giro, Licencia de Anuncios, Licencias de Construcción, Certificados de Habitabilidad.
                        </li>
                        <li>
                            Resolución de recursos administrativos que se desahogarán en cualquier dependencia del Ayuntamiento de Guadalajara, Jalisco.
                        </li>
                        <li>
                            Obtención de datos estadísticos.
                        </li>
                        <li>
                            Administra y operar la plataforma en Línea “Visor Urbano”.
                        </li>
                        <li>
                            Informarle a usted de proceso en el que se encuentra el trámite que solicitó.
                        </li>
                    </ul>
                </p>
                <br>
                <h4>Derechos ARCO</h4>
                <p>
                    Todos los Titulares de los datos personales tienen el derecho de Acceder, Rectificar y Cancelar su información personal que esté en posesión de terceros, así como Oponerse a su uso. A ello se le conoce como derechos ARCO.
                    <br><br>
                    Por lo anterior, se hace de su conocimiento nuestra política de Privacidad y de cómo salvaguardamos la integridad, Privacidad y protección de sus datos personales.
                    <br><br>
                    <h5>Acceso.</h5> Implica el derecho que tiene a acceder y conocer su información que está siendo objeto de tratamiento, así como el alcance y particularidades de dicho tratamiento.
                    <br><br>
                    <h5>Rectificación.</h5> Es el derecho que usted tiene a corregir sus datos personales.
                    <br><br>
                    Aplica cuando sus datos son incorrectos, imprecisos, incompletos o están desactualizados.
                    <br><br>
                    <h5>Cancelación.</h5> Es el derecho que le permite solicitar, en todo momento, la eliminación o borrado de sus datos personales cuando considere que los mismos no están siendo utilizados o manejados conforme a los principios, deberes y obligaciones previstas en la Ley.
                    <br><br>
                    <h5>Oposición.</h5> Consiste en solicitar el cese del tratamiento de sus datos personales cuando una situación específica y personal así lo requiera para evitarle un daño o para fines específicos y concretos, por ejemplo, para fines publicitarios.
                    <br><br>
                    Por lo anterior, se hace de su conocimiento nuestra política de Privacidad y de cómo salvaguardamos la integridad, Privacidad y protección de sus datos personales.
                </p>
                <br>
                <h4>Datos Personales.</h4>
                <p>
                    Los datos personales son cualquier información que refiere a su persona física que pueda ser identificada a través de los mismos, los cuales se pueden expresar en forma numérica, alfabética, gráfica, fotográfica, acústica o de cualquier otro tipo, como por ejemplo: nombre, apellidos, CURP, estado civil, lugar y fecha de nacimiento, domicilio, número telefónico, correo electrónico, grado de estudios, sueldo, entre otros.
                    <br><br>
                    Dentro de los datos personales hay una categoría que se denomina “datos personales sensibles”, que requiere especial protección, ya que refieren a una información que pueda revelar aspectos íntimos de una persona o dar lugar a discriminación, como el estado de salud, información genética, creencias religiosas, filosóficas y morales, afiliación sindical, opiniones políticas origen racial o étnico y preferencia sexual, por mencionar algunos.
                </p>
                <br>
                <h4>Modificaciones al Aviso de Privacidad.</h4>
                <p>
                    Nos reservamos el derecho de efectuar en cualquier momento modificaciones o actualizaciones al presente Aviso de Privacidad, para la atención de novedades legislativas, políticas internas o nuevos requerimientos para la prestación u ofrecimiento de nuestros servicios o productos.
                </p>
                <br><br>
                <center>
                    <h4>
                        Atentamente
                        <br>
                        Ayuntamiento de Guadalajara, Jalisco.
                    </h4>
                </center>
            </div>

        </div>

    </div>
</div>
