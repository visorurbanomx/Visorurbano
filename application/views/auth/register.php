<div class="auth">
    <div class="logo">
        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/logo.png" alt="Visor Urbano" width="200"></a>
    </div>
    <form id="frmRegister" class="mui-form">
        <div class="mui-textfield mui-textfield--float-label">
            <input type="text" id="txtNombre" name="nombre" class="input-material" required tabindex="1" maxlength="255">
            <label for="txtNombre">*Nombre(s)</label>
        </div>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="text" id="txtApePat" name="ape_paterno" class="input-material" required tabindex="2" maxlength="255">
            <label for="txtApePat">*Primer Apellido</label>
        </div>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="text" id="txtApeMat" name="ape_materno" class="input-material" tabindex="3" maxlength="255">
            <label for="txtApeMat">Segundo Apellido</label>
        </div>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="email" id="txtEmail" name="email" class="input-material" required tabindex="4" maxlength="255">
            <label for="txtEmail">*Correo Electrónico</label>
        </div>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="text" id="txtCelular" name="celular" id="txtCelular" maxlength="10" class="input-material" required tabindex="5">
            <label for="txtCelular">*Número celular</label>
        </div>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="password" name="password" id="password" class="input-material" required tabindex="6" maxlength="50">
            <label for="password">*Contraseña</label>
        </div>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="password" name="repassword" class="input-material" required tabindex="7" maxlength="50">
            <label for="repassword">*Confirmar contraseña</label>
        </div>
        <br>
        <div class="mui-checkbox">
            <label>
                <input type="checkbox" name="agree" value="agree" required class="checkbox-template" tabindex="8"/>
                He leído y aceptó los <a href="#" data-toggle="modal" data-target="#mdlTerminosCondiciones">terminos y condiciones</a>
            </label>
        </div>
        <br>
        <center>
            <button type="button" id="btnRegistro" class="mui-btn mui-btn--primary" tabindex="9">Registrarme</button>
        </center>&nbsp;
    </form>
</div>
<!-- Modal Terminos y Condiciones-->
<div id="mdlTerminosCondiciones" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">TÉRMINOS Y CONDICIONES</h4>
            </div>
            <div class="modal-body crearCunentaTerminosCondiciones">
                <p>
                    A los usuarios les informamos de los siguientes Términos y Condiciones de Uso y Confidencialidad, que son aplicables para el uso de "Trámites en Línea de Guadalajara" desde el sitio oficial de internet del Municipio de Guadalajara (el “Portal”), por lo que entendemos que los acepta, y acuerda en obligarse a su cumplimiento. En caso de que no esté de acuerdo con los Términos y Condiciones de Uso y Confidencialidad deberá abstenerse de acceder o utilizar el portal.
                    <br><br>
                    El Municipio de Guadalajara actualiza de manera permanente el contenido de sitio oficial de internet con la finalidad de mantener vigente la información a su disposición, esto en cumplimiento a los ordenamientos de la materia, lo cual se realiza sin previo aviso de los usuarios.
                    <br><br>
                    El usuario es entendido como aquella persona que realiza acceso al portal mediante equipo de cómputo y/o de comunicación, mismo que no deberá utilizar dispositivos, software, o cualquier otro medio tendiente a interferir tanto en las actividades y/u operaciones del Portal o en las bases de datos y/o información que se contenga en el mismo.
                </p>
                <br>
                <h4>1. USO Y RESTRICCIONES.</h4>
                <p>
                    El acceso o utilización del Portal expresan la adhesión plena y sin reservas del Usuario a los presentes Términos y Condiciones de Uso y Confidencialidad. A través del Portal (<a href="http://servicios.guadalajara.gob.mx/registro_ciudadano" target="_blank">http://servicios.guadalajara.gob.mx/registro_ciudadano</a>) , el Usuario se servirá y/o utilizará diversos servicios y contenidos, puestos a disposición de los Usuarios por el Municipio de Guadalajara y/o por terceros proveedores de los mismos. El Municipio de Guadalajara tendrá el derecho de restringir el acceso total o parcialmente al Usuario, a su entera discreción, cuando el Municipio de Guadalajara lo considere pertinente o para los fines que así le convengan.
                    <br><br>
                    El Usuario reconoce que no todos los trámites ofertados por el Municipio de Guadalajara se encuentran disponibles a través del portal, por lo que únicamente podrá realizar aquellos que se encuentren disponibles en ese momento en el portal. El Municipio de Guadalajara no garantiza la disponibilidad y continuidad de la operación de las Páginas o el Portal y de los Servicios y Contenidos, ni la utilidad del Portal o los Servicios y Contenidos en relación con cualquier actividad específica, independientemente del medio de acceso que utilice el Usuario incluido la telefonía móvil. El Municipio de Guadalajara no será responsable por daño o pérdida alguna de cualquier naturaleza que pueda ser causado debido a la falta de disponibilidad o continuidad de operación del portal y/o de los Servicios y Contenidos.
                </p>
                <br>
                <h4>2. DESCRIPCIÓN DEL SERVICIO</h4>
                <p>
                    El Municipio de Guadalajara, a través de la Dirección de Innovación Gubernamental proporciona al Usuario acceso a Servicios y Contenidos a través del Portal. El Usuario reconoce que los Servicios del Portal son de manera opcional, por lo que no substituye de ninguna manera la prestación de Servicios de manera presencial por parte del Municipio de Guadalajara.
                </p>
                <br>
                <h4>3. PROPIEDAD INTELECTUAL</h4>
                <p>
                    Los derechos de propiedad intelectual respecto de los Servicios y Contenidos y los signos distintivos y escudos y dominios del Portal, así como los derechos de uso, incluyendo su divulgación, publicación, reproducción, distribución y transformación, son propiedad exclusiva del Municipio de Guadalajara. El Usuario no adquiere ningún derecho de propiedad intelectual por el simple uso de los Servicios y Contenidos del Portal y en ningún momento dicho uso será considerado como una autorización o licencia para utilizar los Servicios y Contenidos con fines distintos a los que se contemplan en los presentes Términos y Condiciones de Uso y Confidencialidad.
                </p>
                <br>
                <h4>4. USOS PERMITIDOS</h4>
                <p>
                    El aprovechamiento de los Servicios y Contenidos del Portal es exclusiva responsabilidad del Usuario, quien en todo caso deberá servirse de ellos acorde a las funcionalidades permitidas en el propio Portal y a los usos autorizados en los presentes Términos y Condiciones de Uso y Confidencialidad, por lo que el Usuario se obliga a utilizarlos de modo tal que no atenten contra las normas de uso y convivencia en Internet, las leyes de los Estados Unidos Mexicanos y la legislación vigente en el país en que el Usuario se encuentre al usarlos, las buenas costumbres, la dignidad de la persona y los derechos de terceros. El Portal es para el uso individual del Usuario por lo que no podrá comercializar de manera alguna los Servicios y Contenidos.
                </p>
                <br>
                <h4>5. RESTRICCIONES</h4>
                <p>
                    El Usuario no tiene el derecho a utilizar el Portal con fines distintos a los establecidos en los presentes Términos y Condiciones de Uso, ni el derecho de colocar o utilizar los Servicios y Contenidos de la Página en sitios o páginas propias o de terceros sin autorización previa y por escrito del Municipio de Guadalajara, con excepción de aquella que sea considerada como información pública de acuerdo a lo establecido en el artículo 3 de la Ley de Transparencia y Acceso a la Información Pública del Estado de Jalisco y sus Municipios. Asimismo, el Usuario no tendrá el derecho de limitar o impedir a cualquier otro Usuario el uso del Portal.
                </p>
                <br>
                <h4>6. CALIDAD DE LOS SERVICIOS Y CONTENIDOS</h4>
                <p>
                    Ni el Municipio de Guadalajara, ni sus proveedores serán responsables de cualquier daño o perjuicio que sufra el Usuario a consecuencia de inexactitudes, consultas realizadas, errores tipográficos y cambios o mejoras que se realicen periódicamente a los Servicios y Contenidos.
                </p>
                <br>
                <h4>7. CONFIDENCIALIDAD</h4>
                <p>
                    El Municipio de Guadalajara protege los datos personales del Usuario y solo serán utilizados para el fin que fueron recibidos, en caso necesario se utilizarán para mantener al Usuario informado (a) con motivo de tu petición. Los datos personales del Usuario son intransferibles, excepto en los casos que establece el artículo 22 de la Ley de Transparencia y Acceso a la Información Pública del Estado de Jalisco y sus Municipios y demás disposiciones normativas.
                    <br><br>
                    Si le Usuario desea ejercer el derecho de acceso, rectificación, modificación, corrección, sustitución, oposición, supresión, ampliación, revocar el consentimiento, limitar el uso o divulgación de datos personales podrá iniciar el trámite mediante Solicitud de protección de información confidencial, la cual se recibirá en la Dirección de Transparencia y Acceso a la Información, ubicada en la Av. Hidalgo s/n, Plaza de las Américas, en la Unidad Administrativa Basílica, oficinas 29 y 29A segundo piso, Centro Histórico Guadalajara, Jalisco, para mayor información ponemos a su disposición del Usuario el número 38182200 ext. 1231.
                    <br><br>
                    Le invitamos a conocer al Usuario el Aviso de Confidencialidad, donde se establecieron los mecanismos que protegerán los datos personales del Usuario y se encuentra a su disposición en el siguiente enlace:
                    <a href="http://transparencia.guadalajara.gob.mx/sites/default/files/AvisoConfidencialidad.pdf" target="_blank">http://transparencia.guadalajara.gob.mx/sites/default/files/AvisoConfidencialidad.pdf</a>
                </p>
                <br>
                <h4>8. USO DE LA INFORMACIÓN NO CONFIDENCIAL O INDIVIDUAL</h4>
                <p>Mediante el uso del Portal, el Usuario autoriza al Municipio de Guadalajara a utilizar la información no confidencial o no individual para los fines que le interesen, en términos de lo establecido en el artículo 109 de la Ley Federal de los Derechos de Autor.</p>
                <br>
                <h4>9. AVISO DE PRIVACIDAD DE DATOS PERSONALES</h4>
                <p>
                    Toda la información que el Municipio de Guadalajara recabe del Usuario es tratada con absoluta confidencialidad conforme las disposiciones legales aplicables.
                    <br>
                    Para conocer mayor información de la protección de sus datos personales acuda a la siguiente liga: <a href="http://transparencia.guadalajara.gob.mx/" target="_blank">http://transparencia.guadalajara.gob.mx/</a>
                </p>
                <br>
                <h4>10. CLAVES DE ACCESO</h4>
                <p>
                    En todo momento, el Usuario es el responsable único y final de mantener en secreto su clave de acceso con la cual tiene los permisos para acceder a ciertos Servicios y Contenidos del Portal; el Municipio de Guadalajara no se hace responsable por los daños o perjuicios, de cualquier tipo, que sean ocasionados al Usuario, derivados del mal uso de su clave de acceso al Portal.
                </p>
                <br>
                <h4>11. MODIFICACIONES</h4>
                <p>
                    El Municipio de Guadalajara tendrá el derecho de modificar en cualquier momento los Términos y Condiciones de Uso y Confidencialidad. En consecuencia, el Usuario debe leer atentamente los Términos y Condiciones de Uso y Confidencialidad cada vez que pretenda utilizar el Portal. Determinados Servicios y Contenidos ofrecidos a los Usuarios en y/o a través del Portal están sujetos a condiciones particulares propias que sustituyen, completan y/o modifican los Términos y Condiciones de Uso y Confidencialidad. Consiguientemente, el Usuario también debe leer atentamente las correspondientes Condiciones Particulares antes de acceder a cualquiera de los Servicios y Contenidos.
                    <br>
                    De conformidad con la legislación aplicable ciertos servicios requerirán de la instalación de herramientas de protección para la información que se solicite, por lo que el servicio será negado en caso de no ser aceptada la instalación requerida.
                </p>
                <br>
                <h4>12. LEYES APLICABLES Y JURISDICCIÓN</h4>
                <p>
                    Para la interpretación, cumplimiento y ejecución de los presentes Términos y Condiciones de Uso y Confidencialidad, el Usuario está de acuerdo en sujetarse a los principios administrativos establecidos en la Ley del Procedimiento Administrativo del Estado de Jalisco y sus Municipios, así como a las Leyes Federales aplicables de los Estados Unidos Mexicanos y a la legislación aplicable del Estado Libre y Soberano de Jalisco; competente a los tribunales de la Ciudad de Guadalajara, Jalisco, renunciando expresamente a cualquier otro fuero o jurisdicción que pudiera corresponderles en razón de sus domicilios presentes o futuros o por cualquier otra causa.
                </p>
            </div>

        </div>

    </div>
</div>
