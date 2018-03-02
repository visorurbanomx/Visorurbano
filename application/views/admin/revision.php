<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom" id="titulo">Revisión</h2>
        </div>
        <style media="screen">
            .margen{
                margin-top: 5px;
            }
            .row_border{
                border-bottom:solid #ccc 0.5px;
                padding:15px;
            }
            table tbody tr td {
              padding: 20px 10px; }
        </style>
    </header>
    <!-- Projects Section-->
    <section class="projects">
        <div class="container-fluid">
            <div id="contenido_tablas">
                <ul class="mui-tabs__bar mui-tabs__bar--justified">
                    <li class="mui--is-active"><a data-mui-toggle="tab" data-mui-controls="pane-justified-1" onclick="traer_informacion('T')">TODAS</a></li>
                    <li><a data-mui-toggle="tab" data-mui-controls="pane-justified-2" onclick="traer_informacion('R')">REVISADAS</a></li>
                    <li><a data-mui-toggle="tab" data-mui-controls="pane-justified-3" onclick="traer_informacion('P')">PRIORITARIOS</a></li>
                </ul>
                <div class="mui-tabs__pane mui--is-active" id="pane-justified-1" style="margin-top:30px;">
                    <table id="tblTodas" class="display table-striped style_table" cellspacing="0" width="100%" style="margin-top:30px !important;">
                        <thead>
                            <tr>
                                <th style="width:30%;">NOMBRE DEL SOLICITANTE</th>
                                <th style="width:40%;">GIRO</th>
                                <th style="width:10%;">FECHA</th>
                                <th style="width:10%;">ESTATUS</th>
                                <th style="text-align:center;">VER</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTodas">

                        </tbody>
                    </table>
                </div>
                <div class="mui-tabs__pane" id="pane-justified-2" style="margin-top:30px;">
                    <table id="tblRevisadas" class="display table-striped style_table" cellspacing="0" width="100%" style="margin-top:30px !important;">
                        <thead>
                            <tr>
                                <th style="width:30%;">NOMBRE DEL SOLICITANTE</th>
                                <th style="width:40%;">GIRO</th>
                                <th style="width:10%;">FECHA</th>
                                <th style="width:10%;">ESTATUS</th>
                                <th style="text-align:center;">VER</th>
                            </tr>
                        </thead>
                        <tbody id="bodyRevisadas">

                        </tbody>
                    </table>
                </div>
                <div class="mui-tabs__pane" id="pane-justified-3" style="margin-top:30px;">
                    <table id="tblPrioritarios" class="display table-striped style_table" cellspacing="0" width="100%" style="margin-top:30px !important;">
                        <thead>
                            <tr>
                                <th style="width:30%;">NOMBRE DEL SOLICITANTE</th>
                                <th style="width:40%;">GIRO</th>
                                <th style="width:10%;">FECHA</th>
                                <th style="width:10%;">ESTATUS</th>
                                <th style="text-align:center;">VER</th>
                            </tr>
                        </thead>
                        <tbody id="bodyPrioritarios">

                        </tbody>
                    </table>
                </div>
            </div>
            <div id="contenido_detalle">
                <div class="resumen_solicitante">
                    <div class="row row_border">
                        <div class="col-md-12 margen">
                            <h3>Identificación del solicitante</h3>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Tipo: </b>
                            <span id="tipo"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Tipo Representante: </b>
                            <span id="tipo_representante"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Tipo de carta poder: </b>
                            <span id="tipo_carta"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Carta Poder: </b>
                            <span id="carta_poder"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Identificación del Otorgante: </b>
                            <span id="ft_id_otorgante"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Identificación Testigo 1: </b>
                            <span id="ft_id_testigo1"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Identificación Testigo 2: </b>
                            <span id="ft_id_testigo2"></span>
                        </div>
                    </div>
                    <div class="row row_border">
                        <div class="col-md-12 margen">
                            <h3>Datos del solicitante</h3>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Nombre: </b>
                            <span id="nombre_sol"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Primer apellido: </b>
                            <span id="primer_apellido_sol"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Segundo apellido: </b>
                            <span id="segunda_apellido_sol"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>CURP: </b>
                            <span id="curp_sol"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>RFC: </b>
                            <span id="rfc_sol"></span>
                        </div>
                        <div class="col-md-12 margen">
                            <b>Email: </b>
                            <span id="email_sol"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Domicilio: </b>
                            <span id="domicilio_sol"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Num. Ext: </b>
                            <span id="num_ext_sol"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Num. Int: </b>
                            <span id="num_int_sol"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Colonia: </b>
                            <span id="colonia_sol"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Ciudad: </b>
                            <span id="ciudad_sol"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>C.P: </b>
                            <span id="cp_sol"></span>
                        </div>
                        <div class="col-md-12 margen">
                            <b>Teléfono: </b>
                            <span id="tel_sol"></span>
                        </div>
                    </div>
                    <div class="row row_border"  id="datos_representante" style="display:none;">
                        <div class="col-md-12 margen">
                            <h3>Datos del Representante</h3>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Nombre: </b>
                            <span id="nombre_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Primer apellido: </b>
                            <span id="primer_apellido_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Segundo apellido: </b>
                            <span id="segunda_apellido_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>CURP: </b>
                            <span id="curp_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>RFC: </b>
                            <span id="rfc_re"></span>
                        </div>
                        <div class="col-md-12 margen">
                            <b>Email: </b>
                            <span id="email_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Domicilio: </b>
                            <span id="domicilio_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Num. Ext: </b>
                            <span id="num_ext_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Num. Int: </b>
                            <span id="num_int_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Colonia: </b>
                            <span id="colonia_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Ciudad: </b>
                            <span id="ciudad_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>C.P: </b>
                            <span id="cp_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Teléfono: </b>
                            <span id="tel_re"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Identificación del representante: </b>
                            <span id="ft_id_representante"></span>
                        </div>
                    </div>
                    <div class="row row_border">
                        <div class="col-md-12 margen">
                            <h3>Datos del establecimiento</h3>
                        </div>
                        <div class="col-md-12 margen">
                            <b>Actividad: </b>
                            <span id="actividad"></span>
                        </div>
                        <div class="col-md-12 margen">
                            <b>Clave Catastral: </b>
                            <span id="cvecatastral"></span>
                        </div>
                        <div class="col-md-12 margen">
                            <b>Nombre: </b>
                            <span id="nombre_es"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Domicilio: </b>
                            <span id="domicilio_es"></span>
                        </div>
                        <div class="col-md-2 margen">
                            <b>Num. ext: </b>
                            <span id="num_ext_es"></span>
                        </div>
                        <div class="col-md-2 margen">
                            <b>Letra. ext: </b>
                            <span id="letra_ext_es"></span>
                        </div>
                        <div class="col-md-2 margen">
                            <b>Num. int: </b>
                            <span id="num_int_es"></span>
                        </div>
                        <div class="col-md-2 margen">
                            <b>Letra. int: </b>
                            <span id="letra_int_es"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Colonia: </b>
                            <span id="colonia_es"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Ciudad: </b>
                            <span id="ciudad_es"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Estado: </b>
                            <span id="estado_es"></span>
                        </div>
                        <div class="col-md-2 margen">
                            <b>C.P: </b>
                            <span id="cp_es"></span>
                        </div>
                        <div class="col-md-2 margen">
                            <b>Num. Local: </b>
                            <span id="num_es"></span>
                        </div>
                        <div class="col-md-2 margen">
                            <b>Superficie: </b>
                            <span id="superficie_es"></span>
                        </div>
                        <div class="col-md-2 margen">
                            <b>Área para utilizar: </b>
                            <span id="area_es"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Inversión: </b>
                            <span id="inversion_es"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Num. Empleados: </b>
                            <span id="num_empleado_es"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Cajones de estacionamientos: </b>
                            <span id="cajones_es"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Fotografia Fachada: </b>
                            <span id="ft_fachada"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Fotografia Puerta Abierta: </b>
                            <span id="ft_puerta_abierta"></span>
                        </div>
                        <div class="col-md-4 margen">
                            <b>Fotografia Interior: </b>
                            <span id="ft_interior"></span>
                        </div>
                    </div>
                    <div class="row" style="padding:15px;">
                        <div class="col-md-12" id="radios_revision">
                            <div class="form-group" style="margin-top:30px;">
                                <label><b>* Revisión:</b></label>
                                <br>
                                <input id="rdAprobada" type="radio" name="rdStatus" value="A" required>
                                <label for="rdAprobada">Aprovada</label>
                                <br>
                                <input id="rdSolventacion" type="radio" name="rdStatus" value="S" required>
                                <label for="rdSolventacion">Solventación</label>
                            </div>
                        </div>
                        <div class="col-md-12 margen">
                            <center>
                                <textarea class="form-control" name="name" rows="8" cols="80" style="width:80%;" placeholder="Escribe un mensaje" id="mensaje"></textarea>
                            </center>
                        </div>
                        <div class="col-md-12">
                            <center>
                                <button id="enviar" type="button" name="button" class="mui-btn mui-btn--primary" onclick="enviar_revision()">Enviar</button>
                                <button id="cancelar" type="button" name="button" class="mui-btn mui-btn--raised" onclick="cancelar()">Cancelar</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>
</div>
<div class="modal fade errorModal" id="errorModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            </div>
            <div class="modal-body">
                <h4>La revisión no puede continuar por las siguientes razones:</h4>
                <ul class="tramiteErrores"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
