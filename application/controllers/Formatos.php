<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Formatos extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library("Pdf");
        $this->load->helper('url');
        $this->load->model('LicenciasGiroModel');
        $this->load->model('FormatosModel');
    }

    public function licencia_pdf(){
       extract($_GET);
       $idTramite = $this->utils->decode($lic);
       $idUsuario = $this->utils->decode($usu);
       $licencia = $this->LicenciasGiroModel->getLicencia_fl($idUsuario, $idTramite);
       if(!$licencia){
           echo "<center><h3>Lo sentimos estamos teniendo problemas técnicos temporalmente; estamos trabajando para resolver esta situación los más pronto posible, por favor intenta de nuevo mas tarde  :(</center></h3>";
       }else{
           $actividad = $licencia->descripcion_factibilidad;
           $scian = $licencia->clave_factibilidad;
           $cajones_estacionamiento=$licencia->st3_cajones_estacionamiento_establecimiento;
           $aforo_personas="0";
           $superficie=$licencia->st3_area_utilizar_establecimiento;
           $horario="";
           $fecha_sesion="";
           $calle = $licencia->st3_domicilio_establecimiento;
           $no_ext = $licencia->st3_num_ext_establecimiento;
           $col = $licencia->st3_colonia_establecimiento;
           $clave_catastral = $licencia->clave_catastral;
           $no_int = $licencia->st3_num_int_establecimiento;
           $nombre = $licencia->st2_nombre_solicitante;
           $apellido_primer = $licencia->st2_primer_apellido_solicitante;
           $apellido_segundo = $licencia->st2_segundo_apellido_solicitante;
           $rfc = $licencia->st2_rfc_solicitante;
           $curp = $licencia->st2_curp_solicitante;
           $zona = $licencia->predio_distrito.(empty($licencia->predio_sub_distrito)?'':' - '.$licencia->predio_sub_distrito);
           $fechaTitle = date("d/m/Y H:i");
           $anio=date('Y');
           $pago=$licencia->metodo_pago;
           $id_licencia=$licencia->id_licencia;
           $id_usuario=$licencia->id_usuario;
           if($licencia->folio_licencia == 0){
                $params = array(
                   'tipo_tramite'=>'13',
                   'scian'=>intval($scian),
                   'x'=>'0',
                   'y'=>'0',
                   'zona'=> $licencia->predio_distrito,
                   'subzona'=> $licencia->predio_sub_distrito,
                   'actividad'=> mb_strtoupper($actividad),
                   'cvecuenta'=>$licencia->cuenta_predial,
                   'propietario'=> mb_strtoupper($nombre),
                   'primer_ap'=> mb_strtoupper($apellido_primer),
                   'segundo_ap'=> mb_strtoupper($apellido_segundo),
                   'rfc'=>mb_strtoupper($rfc),
                   'curp'=>mb_strtoupper($curp),
                   'telefono_prop'=>$licencia->st2_telefono_solicitante,
                   'email'=>$licencia->st2_email_solicitante,
                   'cvecalle'=>'0',
                   'calle'=>mb_strtoupper($calle),
                   'num_ext'=>$no_ext,
                   'let_ext'=>mb_strtoupper($licencia->st3_letra_ext_establecimiento),
                   'num_int'=>$no_int,
                   'let_int'=>mb_strtoupper($licencia->st3_letra_int_establecimiento),
                   'colonia'=>mb_strtoupper($col),
                   'cp'=>$licencia->st3_cp_establecimiento,
                   'espubic'=>'',
                   'sup_autorizada'=>$superficie,
                   'num_cajones'=>$cajones_estacionamiento,
                   'num_empleados'=>$licencia->st3_empleados_establecimiento,
                   'aforo'=>$aforo_personas,
                   'inversion'=> $licencia->st3_inversion_establecimiento,
                   );
                   $data_soap=$this->utils->conec_soap('licTramite',$params);
                   $folio_licencia=$data_soap->licencia;
                   $this->LicenciasGiroModel->postPdf($idUsuario, $idTramite, $data_soap->licencia);
            }else{
               $folio_licencia=$licencia->folio_licencia;
            }
           $params = array(
               'licencia'=>$folio_licencia,
           );
           $data_soap=$this->utils->conec_soap('licAdeudo',$params);
           if(empty($data_soap)){
               $total='0.00';
           }else{
               $total=$data_soap[(count($data_soap)-1)]->acumulado;
           }
           if($cadena = $this->FormatosModel->cadena($licencia,'Nueva licencia',$folio_licencia,'licencias de giro tipo A')){
               if($this->FormatosModel->validarFirma($folio_licencia,$anio)){
                   if($id_firma=$this->FormatosModel->firmado($folio_licencia)){
                       $this->FormatosModel->insertarFirma($id_licencia,$id_usuario,$folio_licencia,$cadena,$id_firma,'N',$anio);
                   }
               }else{
                   $id_firma=$this->FormatosModel->traerFirma($folio_licencia,$anio);
               }
           }
           $centavos = explode('.',$total);
           $centavos = $centavos[1];
           $html ='<html>
                   <head>
                       <style>
                            body{
                               font-family: exo;
                            }
                            .titulo{
                               text-align: center;
                               color:#919191;
                               font-size: 30px;
                            }
                            .subtitulos{
                               text-align: center;
                               background: #969696;
                               color: #fff;
                               font-weight: bold;
                               border-radius: 5px;
                            }
                            .subtitulos_sub{
                               text-align: center;
                               background: #969696;
                               color:#fff;
                               font-weight: bold;
                               border-radius: 4px;
                               font-size: 12px;
                            }
                            .margen_principal{
                               margin-top: 50px;
                            }
                            .margen_titulo{
                               margin-top: 100px;
                            }
                            .margen_30{
                               margin-top: 30px;
                            }
                            .margen_15{
                               margin-top: 15px;
                            }
                            .margen_20{
                               margin-top: 20px;
                            }
                            .separador_20{
                               margin-left:40px;
                            }
                            .tamano_14{
                               font-size: 14px;
                            }
                            .tamano_12{
                               font-size: 12px;
                            }
                            .tamana_10{
                               font-size: 8px;
                            }
                        </style>
                    </head>
                    <body>
                        <div style="position:absolute; left:60px; top:4%; width:20%;">
                            <img src="assets/img/logo-padron.png" alt="">
                        </div>
                        <div  style="position:absolute; left:160px; top:7%; text-align:center; width:60%;  color:#C40E91; font-size: 25px;">
                            <span class="subrayado">LICENCIA MUNICIPAL</span>
                        </div>
                        <div style="position:absolute; right:10%; top:3%; width: 8%">
                            <img src="assets/img/gdl-logo.png" alt="">
                        </div>
                        <div style="position:absolute; top:100px; width:85%; height:100%;  background-image: url(assets/img/logo-GDL-licencia.png); background-size:80%; background-repeat: no-repeat;  background-position: 50% 30%;">
                            <div>
                                <div class="subtitulos margen_principal" style="width:30%; font-size: 12px;">
                                    <span>MOVIMIENTO</span>
                                </div>
                                <div style="width:30%; margin-top:10px;">
                                    <span style="font-weight: 500; float: right; font-size: 12px">NUEVA LICENCIA <span class="separador_20" style="font-weight: bold; font-size: 18px; margin-top:10px;">'.$folio_licencia.'</span></span>
                                </div>
                            </div>
                            <div>
                                <div style="width: 35%; float: left;">
                                    &nbsp;
                                </div>
                                <div class="subtitulos" style="width:30%; float: left; font-size: 12px;">
                                    <span>DATOS DEL GIRO</span>
                                </div>
                                <div style="width: 30%; float: right; margin-left: 10%;">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="margen_15">
                                <div class="tamano_14" style="width:100%; font-weight:bold; text-align:center;">
                                    Giro: &nbsp;'.$actividad.'
                                </div>
                                <div class="tamano_12 margen_15">
                                    <div style="width: 35%; float: left;">
                                        <span>Cajones de estacimiento: '.$cajones_estacionamiento.'</span>
                                    </div>
                                    <div style="width: 30%; float: left;">
                                        <span class="separador_20">Superficie Autorizadas: '.$superficie.' mts</span>
                                    </div>
                                    <div style="width: 30%; float: right; margin-left: 10%;">
                                        <span class="separador_20">Horario: '.$horario.'</span>
                                    </div>
                                </div>
                                <div class="tamano_12 margen_20">
                                    OBLIGATORIO CONTAR CON CONTRATO DE RECOLECCIÓN DE RESIDUOS O DICTAMEN DE MICROGENERADOR
                                    EMITIDO POR LA DIR DE MEDIO AMBIENTE Y CONTENEDORES CLASIFICADOS PARA LOS RESIDUOS
                                </div>
                                <div>
                                    <div class="subtitulos_sub margen_15" style="width: 30%; float:left; margin-top: 20px;">
                                       UBICACIÓN
                                    </div>
                                    <div class="subtitulos_sub" style="width: 30%; float:right;" >
                                        CONTRIBUYENTE
                                    </div>
                                </div>
                                <div class="tamano_12 margen_15">
                                    <div style="width: 40%; float: left;">
                                        Calle: '.$calle.'<br>
                                        No Ext: '.$no_ext.'<br>
                                        Colonia: '.$col.'<br>
                                        Cve Catastral: '.$clave_catastral.'
                                    </div>
                                    <div style="width: 20%; float: left;">
                                        <br>
                                        No. Int: '.$no_int.'<br>
                                        Distrito: '.$zona.'
                                    </div>
                                    <div style="width: 30%; float: right; margin-left: 10%;">
                                        Nombre: '.$nombre.' '.$apellido_primer.' '.$apellido_segundo.'<br>
                                        RFC: '.$rfc.'<br>
                                        CURP: '.$curp.'
                                    </div>
                                </div>
                                <div class="margen_15">
                                    <div class="subtitulos_sub" style="width: 30%; float: left;">
                                        LICENCIA
                                    </div>
                                    <div  style="width: 5%; float: left;">
                                        &nbsp;
                                    </div>
                                    <div class="subtitulos_sub" style="width: 30%; float:left;">
                                        CONCEPTO
                                    </div>
                                    <div class="subtitulos_sub" style="width: 30%; float:right;">
                                        IMPORTE
                                    </div>
                                </div>
                                <div class="tamano_12 margen_15">
                                    <div style="width: 30%; float: left;">
                                        '.$folio_licencia.'
                                    </div>
                                    <div  style="width: 5%; float: left;">
                                        &nbsp;
                                    </div>
                                    <div style="width: 65%; float: left;">';
            $html .= '<table class="tamano_12" width="100%">';
                for ($i=0; $i < count($data_soap) ; $i++) {
                    $html .='<tr>
                                <td width="50%" style="text-align:left;">
                                    '.$data_soap[$i]->descripcion.'
                                </td>
                                <td width="50%" style="text-align:right; vertical-align:bottom;">
                                    $'.$data_soap[$i]->importe.'
                                </td>
                            </tr>';
                }
            $html .= '</table>';
            $html .='</div>
                     <div style="width: 30%; float: right; text-align: right;">';
            $html .='</div>
                    </div>
                    <div class="tamano_12 margen_15">
                        <div style="width: 80%; float: left;">
                            ('.$this->FormatosModel->denominacion_moneda($this->FormatosModel->to_word($total,null)).' '.$centavos.'/100 M.N.)
                        </div>
                        <div style="width: 20%; float: right; text-align: right;">
                            <b>$'.$total.'</b>
                        </div>
                    </div>
                    <div class="tamano_12" style="marin-top:5px;">
                        <div style="width: 30%; float: left;">
                            <b>Forma de pago: '.$pago.'</b>
                         </div>
                    </div>
                    <div>
                        <div style="width: 60%; float: left; text-align: left; font-size: 12px;">
                            <br><br><br>
                            <b>
                            LIC. xxxxxx xxxx xxxx<br>
                            Director de Padrón y Licencias <br>
                            CURP: xxxxxxxxxxxxx00<br>
                            E-MAIL: xxxx@guadalajara.gob.mx<br>
                            Vigencia hasta xx/xx/xx
                            </b>
                        </div>
                        <div  style="width: 5%; float: left;">
                            &nbsp;
                        </div>
                        <div style="width: 30%; float: right; text-align: right;">
                            <br>
                            <barcode code="'.$this->utils->encode($folio_licencia).'" type="QR" class="barcode" size="1.5"  style="border:none;"/><br>
                        </div>
                    </div>
                </div>
                <br>
                <div style="widht:100%; font-size:8px; text-align:left;">
                    ID:<b>'.$id_firma['id'].'</b>|'.preg_replace( "/\r|\n/", "", $id_firma['firma'] ).'
                </div>
            </div>
        </body>
    </html>';
    $this->pdf->WriteHTML($html);
    $this->pdf->AddPage();
    $html2 = '<html>
                <head>
                    <style>
                        body{
                           font-size: 11px;
                        }
                        .cuadro_principal{
                           border:solid 1px #b1b1b1;
                           text-align: justify;
                        }
                        .margen_2_p{
                           margin:2%;
                        }
                        .tamano_12{
                           font-size: 12px;
                        }
                        .margen_10_top{
                           margin-top: 5%;
                        }
                    </style>
                </head>
                <body>
                    <div class="cuadro_principal">
                        <div class="margen_2_p">
                            Hoy, más que nunca <b> Guadalajara necesita de tu participación y compromiso.</b> Te invitamos a respetar y
                            cumplir los reglamentos, el respeto a los mismos es el respeto a la ciudadania. Recuerda que el
                            desconocimiento de los mismos no nos exime de responsabilidad. A continuación hacemos mención de
                            algunos de los aspectos que debes tener muy presentes para el buen funcionamiento de tu giro.
                        </div>
                    </div>
                    <div>
                        <table class="margen_10_top">
                            <tr>
                                <td style="width: 35%">
                                    <br>
                                    <b>SON MOTIVOS DE CLAUSURA:</b>
                                </td>
                                <td style="width: 65%; padding-left: 15px">
                                    <br>
                                    <b>EL REFRENDO, BAJA, MODIFICACIONES Y TRASPASOS DE LICENCIAS.</b>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <br><br>
                                    <b>A. </b>CARECER DE LA LICENCIA MUNICIPAL. <br>
                                    <b>B. </b>OPERAR UNA ACTIVIDAD DISTINTA A LA MANIFESTADA EN LA LICENCIA. <br>
                                    <b>C. </b>FUNCIONAR FUERA DEL HORARIO PERMITIDO. <br>
                                    <b>D. </b>LA VENTA Y/O CONSUMO DE BEBIDAS ALCOHÓLICAS FUERA DE LO ESTABLECIDO EN LA LEY. <br>
                                    <b>E. </b>QUE SE COMETAN DELITO CONTRA LA SALUD, LA VIDA O LA INTEGRIDAD FÍSICA DE LAS PERSONAS DENTRO DEL ESTABLECIMIENTO.<br>
                                    <b>F. </b>COLOCAR ANUNCIOS SOBRE LA VÍA PÚBLICA. <br>
                                    <b>G. </b>OBSTRUIR EL PASO PEATONAL. HACIENDO USO DE LA VÍA PÚBLICA SIN AUTORIZACIÓN.<br>
                                    <b>H. </b>EXCEDER EL AFORO AUTORIZADO. <br>
                                    <b>I. </b>EXCEDER CON EMISIONES DE RUIDO. NORMA AMBIENTAL NOM-081-SEMARNAT-1994 DE DECIBELES (RELATIVA A LOS DECIBELES PERMITIDOS). <br>
                                    <b>J. </b>DESCARGA DE RESIDUOS NOCIVOS A LA RED MUNICIPAL. <br>
                                    <b>K. </b>OPERAR MÁQUINAS DE JUEGOS DE AZAR. <br>
                                    <b>L. </b>QUE LOS DOCUMENTOS Y DATOS PROPORCIONADOS EN LA PLATAFORMA SEAN FALSOS. <br>
                                    <br><br><br><br>
                                    <div>
                                       DENUNCIA LAS ACTUACIONES <br>
                                       IRREGULARES DE LOS FUNCIONARIOS <br>
                                       MUNICIPALES A LA DIRECCIÓN DE <br>
                                       RESPONSABILIDADES <br>
                                       5 DE FEBRERO 248, UNIDAD <br>
                                       ADMINISTRATIVA REFORMA <br>
                                       TELÉFONOS: 15931569 Y 33348676 <br>
                                       HORARIO: 09:00 A 17:00
                                   </div>
                               </td>
                               <td valign="top" style="padding-left: 15px">
                                   <br><br>
                                   La licecia municipal deberá estar en un sitio visible. <br><br>
                                   El <b>refrendo</b> de la licencia municipal es anual y deberá ser realizado durante los primeros dos meses del año fiscal correspondiente. <br><br>
                                   En caso de que el negocio deje de operar, el titular de la licencia deberá <b>presentar aviso de baja </b>
                                   ante de la Dirección de Padrón y licencias. <br><br>
                                   Para realizar <b>traspaso y/o modificaciones en la licencia, </b>se deberá acudir a las oficinas de Padrón y Licencias para su debida autorización. <br><br>
                                   <b>EL ESTABLECIMIENTO: MEDIO AMBIENTE, IMAGEN, ORDEN Y SEGURIDAD</b>. <br><br>
                                   <li>Mantener una imagen <b>ordenada</b> y limpia en el exterior del establecimiento.</li> <br><br>
                                   <li>Contar con las medidas en materia de <b>seguridad</b> y protección civil.</li> <br><br>
                                   <li>Permitir el ingreso al personal autorizado por el Ayuntamiento, asi como proporcionarles la documentación requerida para el desarrollo de sus funciones.</li> <br><br>
                                   <li>Acatar las disposiciones establecidas en el reglamento de <b>anuncios</b>.</li> <br><br>
                                   <li>Queda prohibida la instalación de los <b>anuncios eventuales tipo pendón</b> en todo el Municipio de Guadalajara, de acuerdo al Articulo 39, del Reglamento de Anuncios para el Municipio de Guadalajara.</li><br><br><br><br>
                               </td>
                           </tr>
                           <tr>
                               <td></td>
                               <td style="text-align: center;">
                                   <b>ADOPTA UN ESPACIO VERDE, RESPETA EL ESPACIO PÚBLICO</b>
                               </td>
                           </tr>
                       </table>
                   </div>
                   <div style="position:absolute; bottom:12%; text-align: left; font-size: 10px; width: 45%; border-right: solid #000000 1px">
                       <div>
                           <div style="margin-left: 10px; font-weight:bold;">EXPEDIDO EN: </div>
                           <div style="margin-left: 10px; font-weight:bold;">PRESTADOR DE SERVICIOS Y CERTIFICADORA: </div>
                           <div style="margin-left: 10px; font-weight:bold;">TECNOLOGÍA IMPLEMENTADA PARA LA CRECIÓN DE LAS FIRMAS: </div>
                           <div style="margin-left: 10px; font-weight:bold;">NÚMERO DE SERIE: </div>
                       </div>
                   </div>
                   <div style="position:absolute; bottom:12%; right:7%; text-align: left; font-size: 10px;">
                       <div style="border-left: #0d1318 solid 1px;">
                           <div style="margin-left: 10px;">Guadalajara, Jalisco, el día '.$fechaTitle.'</div>
                           <div style="margin-left: 10px;">SECRETARIA GENERAL DE GOBIERNO DEL ESTADO DE JALISCO</div>
                           <div style="margin-left: 10px;">SSO</div>
                           <div style="margin-left: 10px;">30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 37 33 36 33</div>
                       </div>
                   </div>
                   <div style="position:absolute; bottom:7%; text-align: left; font-size: 10px; width: 85%">
                       <b>EL PRESENTE ACTO ADMINISTRATIVO CUENTA CON PLENA VALIDEZ, EFICACIA JURÍDICA Y OBLIGATORIEDAD DESDE LA FECHA DE SU EMISIÓN Y/O NOTIFICACIÓN TANTO PARA LOS PARTICULARES
                           COMO PARA LAS AUTORIDADES.</b>
                       </div>
               </body>
            </html>';
           $this->pdf->WriteHTML($html2);
           $this->pdf->Output('Licencia_Municipal_'.$folio_licencia.'.pdf', 'I');

       }
   }


    public function refrendo(){
        $url=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url=explode('/',$url);
        $idlicencia=$this->utils->decode($url[count($url)-1]);
        $licencia =  $this->LicenciasGiroModel->getLicenciaFolio($idlicencia);
        if(!$licencia){
            $params = array(
               'licencia'=>$idlicencia,
            );
            $data_soap=$this->utils->conec_soap('licDatos',$params);
            if($data_soap->mensaje == "LA LICENCIA NO EXISTE" || $idlicencia == ""){
                echo "<h3>Lo sentimos estamos teniendo problemas técnicos temporalmente; estamos trabajando para resolver esta situación los más pronto posible, por favor intenta de nuevo mas tarde  :(</h3>";
                die();
            }else{
                $actividad = $data_soap->actividad;
                $cajones_estacionamiento=$data_soap->num_cajones;
                $aforo_personas=$data_soap->aforo;
                $superficie=$data_soap->sup_autorizada;
                $horario="";
                $fecha_sesion="";
                $calle = $data_soap->calle;
                $no_ext = $data_soap->num_ext;
                $col = $data_soap->colonia;
                $clave_catastral = $data_soap->cvecatastral;
                $no_int = $data_soap->num_int;
                $nombre = $data_soap->propietario;
                $apellido_primer = "";
                $apellido_segundo = "";
                $rfc = $data_soap->rfc;
                $curp = $data_soap->curp;
                $zona = $data_soap->zona;
                $fechaTitle = date("d/m/Y H:i");
                $aforo = $data_soap->aforo;
                $id_licencia="0";
                $id_usuario="0";
                $movimiento = $data_soap->movimiento;
                $movimiento2 = explode(' ',$data_soap->movimiento);
                $id_ultimo = $movimiento[count($movimiento2)-1];
                $movimiento =preg_replace('/\W\w+\s*(\W*)$/', '$1', $movimiento);
                $licencia = new stdClass();
                $licencia->descripcion_factibilidad = $data_soap->actividad;
                $licencia->st2_nombre_solicitante = $data_soap->propietario;
                $licencia->st2_curp_solicitante = $data_soap->curp;
                $licencia->st2_rfc_solicitante = $data_soap->rfc;
            }
        }else{
            $actividad = $licencia->descripcion_factibilidad;
            $cajones_estacionamiento=$licencia->st3_cajones_estacionamiento_establecimiento;
            $aforo_personas="0";
            $superficie=$licencia->st3_area_utilizar_establecimiento;
            $horario="";
            $fecha_sesion="";
            $calle = $licencia->st3_domicilio_establecimiento;
            $no_ext = $licencia->st3_num_ext_establecimiento;
            $col = $licencia->st3_colonia_establecimiento;
            $clave_catastral = $licencia->clave_catastral;
            $no_int = $licencia->st3_num_int_establecimiento;
            $nombre = $licencia->st2_nombre_solicitante;
            $apellido_primer = $licencia->st2_primer_apellido_solicitante;
            $apellido_segundo = $licencia->st2_segundo_apellido_solicitante;
            $rfc = $licencia->st2_rfc_solicitante;
            $curp = $licencia->st2_curp_solicitante;
            $zona = $licencia->predio_distrito.(empty($licencia->predio_sub_distrito)?'':' - '.$licencia->predio_sub_distrito);
            $fechaTitle = date("d/m/Y H:i");
            $aforo = '';
            $id_licencia=$licencia->id_licencia;
            $id_usuario=$licencia->id_usuario;
            $movimiento = 'REFRENDO LICENCIA';
        }
        $anio=date('Y');
        $pago = "Tarjeta bancaria";
        $folio_licencia=$idlicencia;
        $params = array(
           'licencia'=>$folio_licencia,
        );
        $data_soap=$this->utils->conec_soap('licAdeudo',$params);
        if(empty($data_soap)){
            $total='0.00';
        }else{
            $total=$data_soap[(count($data_soap)-1)]->acumulado;
        }
        if($cadena = $this->FormatosModel->cadena($licencia,$movimiento,$folio_licencia,'licencias de giro tipo A')){
            if($this->FormatosModel->validarFirma($folio_licencia,$anio)){
                if($id_firma=$this->FormatosModel->firmado($folio_licencia)){
                    $this->FormatosModel->insertarFirma($id_licencia,$id_usuario,$folio_licencia,$cadena,$id_firma,'R',$anio);
                }
            }else{
                $id_firma=$this->FormatosModel->traerFirma($folio_licencia,$anio);
            }
        }
        $centavos = explode('.',$total);
        $centavos = $centavos[1];
        $html ='<html>
                <head>
                    <style>
                        body{
                            font-family: exo;
                        }
                        .titulo{
                            text-align: center;
                            color:#919191;
                            font-size: 30px;
                        }
                        .subtitulos{
                            text-align: center;
                            background: #969696;
                            color: #fff;
                            font-weight: bold;
                            border-radius: 5px;
                        }
                        .subtitulos_sub{
                            text-align: center;
                            background: #969696;
                            color:#fff;
                            font-weight: bold;
                            border-radius: 4px;
                            font-size: 12px;
                        }
                        .margen_principal{
                            margin-top: 50px;
                        }
                        .margen_titulo{
                            margin-top: 100px;
                        }
                        .margen_30{
                            margin-top: 30px;
                        }
                        .margen_15{
                            margin-top: 15px;
                        }
                        .margen_20{
                            margin-top: 20px;
                        }
                        .separador_20{
                            margin-left:40px;
                        }
                        .tamano_14{
                            font-size: 14px;
                        }
                        .tamano_12{
                            font-size: 12px;
                        }
                        .tamana_10{
                            font-size: 8px;
                        }

                    </style>
                </head>
                <body>
                    <div style="position:absolute; left:60px; top:4%; width:20%;">
                        <img src="assets/img/logo-padron.png" alt="">
                    </div>
                    <div  style="position:absolute; left:160px; top:7%; text-align:center; width:60%;  color:#C40E91; font-size: 25px;">
                        <span class="subrayado">LICENCIA MUNICIPAL</span>
                    </div>
                    <div style="position:absolute; right:10%; top:3%; width: 8%">
                        <img src="assets/img/gdl-logo.png" alt="">
                    </div>
                    <div style="position:absolute; top:100px; width:85%; height:100%;  background-image: url(assets/img/logo-GDL-licencia.png); background-size:80%; background-repeat: no-repeat;  background-position: 50% 30%;">
                        <div>
                            <div class="subtitulos margen_principal" style="width:30%; font-size: 12px;">
                                <span>MOVIMIENTO</span>
                            </div>
                            <div style="width:30%; margin-top:10px;">
                                <span style="font-weight: 500; float: right; font-size: 12px">'.$movimiento.' <span class="separador_20" style="font-weight: bold; font-size: 18px; margin-top:10px;">'.$folio_licencia.'</span></span>
                            </div>
                        </div>
                        <div>
                            <div style="width: 35%; float: left;">
                                &nbsp;
                            </div>
                            <div class="subtitulos" style="width:30%; float: left; font-size: 12px;">
                                <span>DATOS DEL GIRO</span>
                            </div>
                            <div style="width: 30%; float: right; margin-left: 10%;">
                                &nbsp;
                            </div>
                        </div>
                        <div class="margen_15">
                            <div class="tamano_14" style="width:100%; font-weight:bold; text-align:center;">
                                Giro: &nbsp;'.$actividad.'
                            </div>
                            <div class="tamano_12 margen_15">
                                <div style="width: 28%; float: left;">
                                    <span>Cajones de estacimiento: '.$cajones_estacionamiento.'</span>
                                </div>
                                <div style="width: 27%; float: left;">
                                    <span class="separador_20">Superficie Autorizadas: '.$superficie.' mts</span>
                                </div>
                                <div style="width: 20%; float: left; margin-left: 10%;">
                                    <span class="separador_20">Horario: '.$horario.'</span>
                                </div>
                                <div style="width: 15%; float: right; margin-left: 10%;">
                                    <span class="separador_20">Aforo: '.$aforo.'</span>
                                </div>
                            </div>
                            <div class="tamano_12 margen_20">
                                OBLIGATORIO CONTAR CON CONTRATO DE RECOLECCIÓN DE RESIDUOS O DICTAMEN DE MICROGENERADOR
                                EMITIDO POR LA DIR DE MEDIO AMBIENTE Y CONTENEDORES CLASIFICADOS PARA LOS RESIDUOS
                            </div>
                            <div>
                                <div class="subtitulos_sub margen_15" style="width: 30%; float:left; margin-top: 20px;">
                                    UBICACIÓN
                                </div>
                                <div class="subtitulos_sub" style="width: 30%; float:right;" >
                                    CONTRIBUYENTE
                                </div>
                            </div>
                            <div class="tamano_12 margen_15">
                                <div style="width: 40%; float: left;">
                                    Calle: '.$calle.'<br>
                                    No Ext: '.$no_ext.'<br>
                                    Colonia: '.$col.'<br>
                                    Cve Catastral: '.$clave_catastral.'
                                </div>
                                <div style="width: 20%; float: left;">
                                    <br>
                                    No. Int: '.$no_int.'<br>
                                    Distrito: '.$zona.'
                                </div>
                                <div style="width: 30%; float: right; margin-left: 10%;">
                                    Nombre: '.$nombre.' '.$apellido_primer.' '.$apellido_segundo.'<br>
                                    RFC: '.$rfc.'<br>
                                    CURP: '.$curp.'
                                </div>
                            </div>
                            <div class="margen_15">
                                <div class="subtitulos_sub" style="width: 30%; float: left;">
                                    LICENCIA
                                </div>
                                <div  style="width: 5%; float: left;">
                                    &nbsp;
                                </div>
                                <div class="subtitulos_sub" style="width: 30%; float:left;">
                                    CONCEPTO
                                </div>
                                <div class="subtitulos_sub" style="width: 30%; float:right;">
                                    IMPORTE
                                </div>
                            </div>
                            <div class="tamano_12 margen_15">
                                <div style="width: 30%; float: left;">
                                    '.$folio_licencia.'
                                </div>
                                <div  style="width: 5%; float: left;">
                                    &nbsp;
                                </div>
                                <div style="width: 65%; float: left;">';
                                    $html .= '<table class="tamano_12" width="100%">';
                                        for ($i=0; $i < count($data_soap) ; $i++) {
                                            $html .= '<tr>
                                            <td width="50%" style="text-align:left;">
                                                '.$data_soap[$i]->descripcion.'
                                            </td>
                                            <td width="50%" style="text-align:right; vertical-align:bottom;">
                                                $'.$data_soap[$i]->importe.'
                                            </td>
                                            </tr>';
                                        }
                                    $html .= '</table>';
                                    $html .='</div>
                                        <div style="width: 30%; float: right; text-align: right;">';
                                    $html .='</div>
                                    </div>
                                    <div class="tamano_12 margen_15">
                                        <div style="width: 80%; float: left;">
                                            ('.$this->FormatosModel->denominacion_moneda($this->FormatosModel->to_word($total,null)).' '.$centavos.'/100 M.N.)
                                        </div>
                                        <div style="width: 20%; float: right; text-align: right;">
                                            <b>$'.$total.'</b>
                                        </div>
                                    </div>
                                    <div class="tamano_12" style="marin-top:5px;">
                                        <div style="width: 30%; float: left;">
                                            <b>Forma de pago: '.$pago.'</b>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="width: 60%; float: left; text-align: left; font-size: 12px;">
                                            <br><br><br>
                                            <b>
                                                LIC. xxxx xxxx xxx<br>
                                                Director de Padrón y Licencias <br>
                                                CURP: xxxxxxxxxxxxxx<br>
                                                E-MAIL: xxxxx@xxx.gob.mx<br>
                                                Vigencia hasta xx/xx/xx
                                            </b>
                                        </div>
                                        <div  style="width: 5%; float: left;">
                                            &nbsp;
                                        </div>
                                        <div style="width: 30%; float: right; text-align: right;">
                                            <br>
                                            <barcode code="'.$this->utils->encode($folio_licencia).'" type="QR" class="barcode" size="1.5"  style="border:none;"/><br>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div style="widht:100%; font-size:8px; text-align:left;">
                                    ID:<b>'.$id_firma['id'].'</b>|'.preg_replace( "/\r|\n/", "", $id_firma['firma'] ).'
                                </div>
                            </div>
                        </body>
                    </html>';
        $this->pdf->WriteHTML($html);
        $this->pdf->AddPage();
        $html2 = '<html>
                    <head>
                        <style>
                            body{
                                font-size: 11px;
                            }
                            .cuadro_principal{
                                border:solid 1px #b1b1b1;
                                text-align: justify;
                            }
                            .margen_2_p{
                                margin:2%;
                            }
                            .tamano_12{
                                font-size: 12px;
                            }
                            .margen_10_top{
                                margin-top: 5%;
                            }
                                </style>
                            </head>
                            <body>
                                <div class="cuadro_principal">
                                    <div class="margen_2_p">
                                        Hoy, más que nunca <b> Guadalajara necesita de tu participación y compromiso.</b> Te invitamos a respetar y
                                        cumplir los reglamentos, el respeto a los mismos es el respeto a la ciudadania. Recuerda que el
                                        desconocimiento de los mismos no nos exime de responsabilidad. A continuación hacemos mención de
                                        algunos de los aspectos que debes tener muy presentes para el buen funcionamiento de tu giro.
                                    </div>
                                </div>
                                <div>
                                    <table class="margen_10_top">
                                        <tr>
                                            <td style="width: 35%">
                                                <br>
                                                <b>SON MOTIVOS DE CLAUSURA:</b>
                                            </td>
                                            <td style="width: 65%; padding-left: 15px">
                                                <br>
                                                <b>EL REFRENDO, BAJA, MODIFICACIONES Y TRASPASOS DE LICENCIAS.</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <br><br>
                                                <b>A. </b>CARECER DE LA LICENCIA MUNICIPAL. <br>
                                                <b>B. </b>OPERAR UNA ACTIVIDAD DISTINTA A LA MANIFESTADA EN LA LICENCIA. <br>
                                                <b>C. </b>FUNCIONAR FUERA DEL HORARIO PERMITIDO. <br>
                                                <b>D. </b>LA VENTA Y/O CONSUMO DE BEBIDAS ALCOHÓLICAS FUERA DE LO ESTABLECIDO EN LA LEY. <br>
                                                <b>E. </b>QUE SE COMETAN DELITO CONTRA LA SALUD, LA VIDA O LA INTEGRIDAD FÍSICA DE LAS PERSONAS DENTRO DEL ESTABLECIMIENTO.<br>
                                                <b>F. </b>COLOCAR ANUNCIOS SOBRE LA VÍA PÚBLICA. <br>
                                                <b>G. </b>OBSTRUIR EL PASO PEATONAL. HACIENDO USO DE LA VÍA PÚBLICA SIN AUTORIZACIÓN.<br>
                                                <b>H. </b>EXCEDER EL AFORO AUTORIZADO. <br>
                                                <b>I. </b>EXCEDER CON EMISIONES DE RUIDO. NORMA AMBIENTAL NOM-081-SEMARNAT-1994 DE DECIBELES (RELATIVA A LOS DECIBELES PERMITIDOS). <br>
                                                <b>J. </b>DESCARGA DE RESIDUOS NOCIVOS A LA RED MUNICIPAL. <br>
                                                <b>K. </b>OPERAR MÁQUINAS DE JUEGOS DE AZAR. <br>
                                                <b>L. </b>QUE LOS DOCUMENTOS Y DATOS PROPORCIONADOS EN LA PLATAFORMA SEAN FALSOS. <br>
                                                <br><br><br><br>
                                                <div>
                                                    DENUNCIA LAS ACTUACIONES <br>
                                                    IRREGULARES DE LOS FUNCIONARIOS <br>
                                                    MUNICIPALES A LA DIRECCIÓN DE <br>
                                                    RESPONSABILIDADES <br>
                                                    5 DE FEBRERO 248, UNIDAD <br>
                                                    ADMINISTRATIVA REFORMA <br>
                                                    TELÉFONOS: 15931569 Y 33348676 <br>
                                                    HORARIO: 09:00 A 17:00
                                                </div>
                                            </td>
                                            <td valign="top" style="padding-left: 15px">
                                                <br><br>
                                                La licecia municipal deberá estar en un sitio visible. <br><br>
                                                El <b>refrendo</b> de la licencia municipal es anual y deberá ser realizado durante los primeros dos meses del año fiscal correspondiente. <br><br>
                                                En caso de que el negocio deje de operar, el titular de la licencia deberá <b>presentar aviso de baja </b>
                                                ante de la Dirección de Padrón y licencias. <br><br>
                                                Para realizar <b>traspaso y/o modificaciones en la licencia, </b>se deberá acudir a las oficinas de Padrón y Licencias para su debida autorización. <br><br>
                                                <b>EL ESTABLECIMIENTO: MEDIO AMBIENTE, IMAGEN, ORDEN Y SEGURIDAD</b>. <br><br>
                                                <li>Mantener una imagen <b>ordenada</b> y limpia en el exterior del establecimiento.</li> <br><br>
                                                <li>Contar con las medidas en materia de <b>seguridad</b> y protección civil.</li> <br><br>
                                                <li>Permitir el ingreso al personal autorizado por el Ayuntamiento, asi como proporcionarles la documentación requerida para el desarrollo de sus funciones.</li> <br><br>
                                                <li>Acatar las disposiciones establecidas en el reglamento de <b>anuncios</b>.</li> <br><br>
                                                <li>Queda prohibida la instalación de los <b>anuncios eventuales tipo pendón</b> en todo el Municipio de Guadalajara, de acuerdo al Articulo 39, del Reglamento de Anuncios para el Municipio de Guadalajara.</li><br><br><br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="text-align: center;">
                                                <b>ADOPTA UN ESPACIO VERDE, RESPETA EL ESPACIO PÚBLICO</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="position:absolute; bottom:12%; text-align: left; font-size: 10px; width: 45%; border-right: solid #000000 1px">
                                    <div>
                                        <div style="margin-left: 10px; font-weight:bold;">EXPEDIDO EN: </div>
                                        <div style="margin-left: 10px; font-weight:bold;">PRESTADOR DE SERVICIOS Y CERTIFICADORA: </div>
                                        <div style="margin-left: 10px; font-weight:bold;">TECNOLOGÍA IMPLEMENTADA PARA LA CRECIÓN DE LAS FIRMAS: </div>
                                        <div style="margin-left: 10px; font-weight:bold;">NÚMERO DE SERIE: </div>
                                    </div>
                                </div>
                                <div style="position:absolute; bottom:12%; right:7%; text-align: left; font-size: 10px;">
                                    <div style="border-left: #0d1318 solid 1px;">
                                        <div style="margin-left: 10px;">Guadalajara, Jalisco, el día '.$fechaTitle.'</div>
                                        <div style="margin-left: 10px;">SECRETARIA GENERAL DE GOBIERNO DEL ESTADO DE JALISCO</div>
                                        <div style="margin-left: 10px;">SSO</div>
                                        <div style="margin-left: 10px;">3030303030303030303030303030303037333633</div>
                                    </div>
                                </div>
                                <div style="position:absolute; bottom:7%; text-align: left; font-size: 10px; width: 85%">
                                    <b>
                                        EL PRESENTE ACTO ADMINISTRATIVO CUENTA CON PLENA VALIDEZ, EFICACIA JURÍDICA Y OBLIGATORIEDAD DESDE LA FECHA DE SU EMISIÓN Y/O NOTIFICACIÓN TANTO PARA LOS PARTICULARES
                                        COMO PARA LAS AUTORIDADES.
                                    </b>
                                </div>
                            </body>
                        </html>';

        $this->pdf->WriteHTML($html2);
        $this->pdf->Output('Licencia_Municipal_'.$folio_licencia.'.pdf', 'I');

}

   public function carta_responsiva_pdf(){
       extract($_GET);
       $html='<html>
       <head>
           <style>
               body{
                   font-family: exo;
               }
               .margen_top_20{
                   margin-top: 20px;
               }
               .cuadro{
                   margin: 15px;
                   margin-bottom: 10px;
               }
           </style>
       </head>
       <body>
           <div style="position:absolute; left:60px; top:4%; width:20%;">
               <img src="assets/img/logo-padron.png" alt="">
           </div>
           <div  style="position:absolute; left:160px; top:12%; text-align:center; width:60%;  color:#C40E91; font-size: 24px;">
              &nbsp;
           </div>
           <div style="position:absolute; right:8%; top:4%; width: 18%">
               <img src="assets/img/logo.png" alt="">
           </div>
           <br><br><br><br>
           <div style="margin-left:11%; width:80%;">
                <div>
                    <div style="float:left; text-align:justify; width:60%;">
                        &nbsp;
                    </div>
                    <div style="float:right; text-align:justify; width:40%;">
                        Asunto: Carta responsiva para la iniciación de tramites en la plataforma Visor Urbano.
                    </div>
                </div><br><br>
                <div>
                    <div style="float:left; text-align:justify; width:100%;">
                        H. Ayuntamiento de Guadalajara<br>
                        Presente.
                    </div>
                </div><br><br>
                <div>
                    <div style="float:left; text-align:justify; width:100%;">
                        En la ciudad de Guadalajara, Jalisco; el día '.$this->FormatosModel->fechasFormat_carta(date('Y/m/d')).',
                        la suscrita (to) C. <u>'.mb_strtoupper($nombre).'</u>, quien se identifica con <u>'.mb_strtoupper($doc).'</u> número <u>'.mb_strtoupper($numero_doc).'</u>,
                        a través de esta declaración, manifiesto sujetarme a las reglas y lineamientos establecidos por el Ayuntamiento de Guadalajara, Jalisco y sus dependencias,
                        para llevar acabo el trámite en línea mediante la plataforma “Visor Urbano” en el link www.visorurbano.com del acto administrativo consistente en la Licencia
                        de Construcción y/o giro en relación al predio ubicado en <u>'.mb_strtoupper($domicilio).'</u>, que cuenta con clave catastral <u>'.mb_strtoupper($clave).'</u>.<br><br>
                        Manifiesto bajo protesta de decir verdad, que es mi deseo subir documentos a la plataforma en línea Visor Urbano y que solicité él apoyó al servidor
                        público de ventanilla para que en mi nombre y representación inicie el trámite solicitado por la suscrita (to), otorgándole información y documentación
                        veraz, real y oficial, que acredita plenamente mi identidad, la situación jurídica y técnica del predio en cita, por lo cual la (el) que suscribe se
                        responsabiliza plenamente de cualquier falsificación de documentos o falsedad en los datos que le entrego al Servidor Público, dejándolos bajo mi
                        resguardo para que en todo momento el Ayuntamiento de Guadalajara realice mediante su personal el cotejo correspondiente de los mismo.<br><br>
                        Por último a través de este documento manifiesto mi conformidad de recibir cualquier tipo de notificación emanada del acto administrativo que
                        insto a través del correo electrónico proporcionado en mi solicitud de trámite, siendo tal medio electrónico una herramienta legalmente reconocida
                        de manera expresa por el Reglamento para la Gestión Integral de la Ciudad del Municipio de Guadalajara.
                    </div>
                </div><br><br><br><br><br><br><br>
                <div>
                    <div style="float:left; text-align:center; width:45%; border-top:solid 1px #000;">
                        '.mb_strtoupper($nombre).'
                    </div>
                    <div style="float:left; text-align:center; width:5%;">
                        &nbsp;
                    </div>
                    <div style="float:right; text-align:center; width:45%;">
                        &nbsp;
                    </div>
                </div><br><br>
           </div>
       </body>
       </html>';
       $this->pdf->WriteHTML($html);
       $this->pdf->Output('carta_responsiva.pdf', 'D');
   }

   public function acuse_ventanilla(){
       $url=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       $url=explode('/',$url);
       $idUsuario=$this->utils->decode($url[count($url)-1]);
       $idTramite=$this->utils->decode($url[count($url)-2]);
       $licencia = $this->LicenciasGiroModel->getLicencia($idUsuario, $idTramite);
       $vacio="&nbsp;";
       if(!$licencia){
           echo "<center><h3>Lo sentimos estamos teniendo problemas técnicos temporalmente; estamos trabajando para resolver esta situación los más pronto posible, por favor intenta de nuevo mas tarde  :(</center></h3>";
       }else{
            $html='<html>
                <head>
                <style>
                body{
                    font-family: exo;
                    font-size: 12px;
                }
                .margen_top_20{
                    margin-top: 20px;
                }
                .cuadro{
                   margin: 15px;
                   margin-bottom: 10px;
                }
                </style>
                    </head>
                        <body>
                            <div style="position:absolute; left:60px; top:4%; width:20%;">
                                <img src="assets/img/logo-padron.png" alt="">
                            </div>
                            <div  style="position:absolute; left:160px; top:12%; text-align:center; width:60%;  color:#C40E91; font-size: 24px;">
                                <span class="subrayado">ACUSE DE VENTANILLA</span>
                            </div>
                            <div style="position:absolute; right:10%; top:3%; width: 18%">
                                <img src="assets/img/logo.png" alt="">
                            </div>
                            <div style="position:absolute; top:17%; text-align:center; width:84%;">
                                <div style="padding:2px;">
                                    <div style="float:right; width:68%; border:solid 1px #000; border-radius:5px;">
                                        <b>GIRO SOLICITADO</b><br>
                                        '.(empty($licencia->descripcion_factibilidad)?$vacio:$licencia->descripcion_factibilidad).'
                                    </div>
                                    <div style="float:right; width:1%;">
                                        &nbsp;
                                    </div>
                                    <div style="float:right; width:30.3%; border:solid 1px #000; border-radius:5px;">
                                        <b>CLAVE CATASTRAL</b><br>
                                        '.(empty($licencia->clave_catastral)?$vacio:$licencia->clave_catastral).'
                                    </div>
                                </div>
                                <div style="padding:10px; text-align:left;">
                                    <b>INDENTIFICACIÓN DEL SOLICITANTE</b>
                                </div>';
                                if(strtolower($licencia->st1_tipo_solicitante) == "propietario"){
                                    $html.='<div style="padding:2px;">
                                        <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>TIPO DE SOLICITANTE</b><br>
                                                '.(empty($licencia->st1_tipo_solicitante)?$vacio:$licencia->st1_tipo_solicitante).'
                                            </div>
                                        </div>
                                    </div>';
                                }else if(strtolower($licencia->st1_tipo_solicitante) == "promotor"){
                                    $html.='<div style="padding:2px;">
                                        <div style="float:right; width:32%; border:solid 1px #000; border-radius:5px;">
                                            <b>TIPO DE PODER</b><br>
                                            '.(empty($licencia->st1_tipo_carta_poder)?$vacio:$licencia->st1_tipo_carta_poder).'
                                        </div>
                                        <div style="float:right; width:1%;">
                                            &nbsp;
                                        </div>
                                        <div style="float:right; width:32%; border:solid 1px #000; border-radius:5px;">
                                            <b>TIPO DE REPRESENTANTE</b><br>
                                            '.(empty($licencia->st1_tipo_representante)?$vacio:$licencia->st1_tipo_representante).'
                                        </div>
                                        <div style="float:right; width:1%;">
                                            &nbsp;
                                        </div>
                                        <div style="float:right; width:33%; border:solid 1px #000; border-radius:5px;">
                                            <b>TIPO DE SOLICITANTE</b><br>
                                            '.(empty($licencia->st1_tipo_solicitante)?$vacio:$licencia->st1_tipo_solicitante).'
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>SE ADJUNTO CARTA DE PODER</b><br>
                                                '.(empty($licencia->st1_carta_poder)?'NO':'SI').'
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>SE ADJUNTO IDENTIFICACIÓN DEL OTORGANTE</b><br>
                                                '.(empty($licencia->st1_identificacion_otorgante)?'NO':'SI').'
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>SE ADJUNTO IDENTIFICACIÓN DEL TESTIGO 1</b><br>
                                                '.(empty($licencia->st1_identificacion_testigo1)?'NO':'SI').'
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>SE ADJUNTO IDENTIFICACIÓN DEL TESTIGO 2</b><br>
                                                '.(empty($licencia->st1_identificacion_testigo2)?'NO':'SI').'
                                            </div>
                                        </div>
                                    </div>';
                                }else{
                                    $html.='<div style="padding:2px;">
                                        <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>TIPO DE SOLICITANTE</b><br>
                                                '.(empty($licencia->st1_tipo_solicitante)?$vacio:$licencia->st1_tipo_solicitante).'
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>SE ADJUNTO CONTRATO DE ARRENDAMIENTO</b><br>
                                                '.(empty($licencia->st1_contrato_arrendamiento)?'NO':'SI').'
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="float:right; width:49%; border:solid 1px #000; border-radius:5px;">
                                            <b>CONTRATO DE ARRENDAMIENTO TE FACULTA PARA ABRIR UN NEGOCIO</b><br>
                                            '.(empty($licencia->st1_faculta) || $licencia->st1_faculta == 'n' || $licencia->st1_faculta == 'N'?'NO':'SI').'
                                        </div>
                                        <div style="float:right; width:1%;">
                                            &nbsp;
                                        </div>
                                        <div style="float:right; width:49.3%; border:solid 1px #000; border-radius:5px;">
                                            <b>CUENTAS CON LA AUNENCIA DEL ARRENDADOR PARA ABRIR UN NEGOCIO</b><br>
                                            '.(empty($licencia->st1_faculta) || $licencia->st1_faculta == 'n' || $licencia->st1_faculta == 'N'?'NO':'SI').'
                                        </div>
                                    </div>';
                                }
                                if(strtolower($licencia->st1_tipo_solicitante) == "promotor"){
                                    $html .= ' <div style="padding:10px; text-align:left;">
                                        <b>DATOS DEL REPRESENTANTE</b>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>NOMBRE DEL REPRESENTANTE</b><br>
                                                '.(empty($licencia->st2_nombre_representante)?$vacio:$licencia->st2_nombre_representante.' '.$licencia->st2_priper_apellido_representante.' '.$licencia->st2_segundo_apellido_representante).'
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="float:right; width:49%; border:solid 1px #000; border-radius:5px;">
                                            <b>RFC</b><br>
                                            '.(empty($licencia->st2_rfc_representante)?$vacio:$licencia->st2_rfc_representante).'
                                        </div>
                                        <div style="float:right; width:1%;">
                                            &nbsp;
                                        </div>
                                        <div style="float:right; width:49.3%; border:solid 1px #000; border-radius:5px;">
                                            <b>CURP</b><br>
                                            '.(empty($licencia->st2_curp_representante)?$vacio:$licencia->st2_curp_representante).'
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>CORREO ELECTRÓNICO</b><br>
                                                '.(empty($licencia->st2_email_representante)?$vacio:$licencia->st2_email_representante).'
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="text-align:left; float:left; width:59%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>DOMICILIO</b><br>
                                                '.(empty($licencia->st2_domicilio_representante)?$vacio:$licencia->st2_domicilio_representante).'
                                            </div>
                                        </div>
                                        <div style="float:left; width:1%;">
                                            &nbsp;
                                        </div>
                                        <div style="text-align:center; float:left; width:19%; border:solid 1px #000; border-radius:5px;">
                                            <b>NO. EXT.</b><br>
                                            '.(empty($licencia->st2_num_ext_representante)?$vacio:$licencia->st2_num_ext_representante).'
                                        </div>
                                        <div style="float:left; width:1%;">
                                            &nbsp;
                                        </div>
                                        <div style="text-align:center; float:right; width:19%; border:solid 1px #000; border-radius:5px;">
                                            <b>NO. INT.</b><br>
                                            '.(empty($licencia->st2_num_int_representante)?$vacio:$licencia->st2_num_int_representante).'
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="float:right; width:49%; border:solid 1px #000; border-radius:5px;">
                                            <b>CP</b><br>
                                            '.(empty($licencia->st2_cp_representante)?$vacio:$licencia->st2_cp_representante).'
                                        </div>
                                        <div style="float:right; width:1%;">
                                            &nbsp;
                                        </div>
                                        <div style="float:right; width:49.3%; border:solid 1px #000; border-radius:5px;">
                                            <b>COLONIA</b><br>
                                            '.(empty($licencia->st2_colonia_representante)?$vacio:$licencia->st2_colonia_representante).'
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="float:right; width:49%; border:solid 1px #000; border-radius:5px;">
                                            <b>TELÉFONO</b><br>
                                            '.(empty($licencia->st2_telefono_representante)?$vacio:$licencia->st2_telefono_representante).'
                                        </div>
                                        <div style="float:right; width:1%;">
                                            &nbsp;
                                        </div>
                                        <div style="float:right; width:49.3%; border:solid 1px #000; border-radius:5px;">
                                            <b>CIUDAD</b><br>
                                            '.(empty($licencia->st2_ciudad_representante)?$vacio:$licencia->st2_ciudad_representante).'
                                        </div>
                                    </div>
                                    <div style="padding:2px;">
                                        <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                            <div style="margin-left:10px;">
                                                <b>SE ADJUNTO LA IDENTIFICACIÓN DE REPRESENTANTE</b><br>
                                                '.(empty($licencia->st2_identificacion_representante)?'NO':'SI').'
                                            </div>
                                        </div>
                                    </div>';
                                }
                                $html.='<div style="padding:10px; text-align:left;">
                                    <b>DATOS DEL SOLICITANTE</b>
                                </div>
                                <div style="padding:2px;">
                                    <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                        <div style="margin-left:10px;">
                                            <b>NOMBRE DEL SOLICITANTE/ARRENDATARIO</b><br>
                                            '.(empty($licencia->st2_nombre_solicitante)?$vacio:$licencia->st2_nombre_solicitante.' '.$licencia->st2_primer_apellido_solicitante.' '.$licencia->st2_segundo_apellido_solicitante).'
                                        </div>
                                    </div>
                                </div>
                                <div style="padding:2px;">
                                    <div style="float:right; width:49%; border:solid 1px #000; border-radius:5px;">
                                        <b>RFC</b><br>
                                        '.(empty($licencia->st2_rfc_solicitante)?$vacio:$licencia->st2_rfc_solicitante).'
                                    </div>
                                    <div style="float:right; width:1%;">
                                        &nbsp;
                                    </div>
                                    <div style="float:right; width:49.3%; border:solid 1px #000; border-radius:5px;">
                                        <b>CURP</b><br>
                                        '.(empty($licencia->st2_curp_solicitante)?$vacio:$licencia->st2_curp_solicitante).'
                                    </div>
                                </div>
                                <div style="padding:2px;">
                                    <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                        <div style="margin-left:10px;">
                                            <b>CORREO ELECTRÓNICO</b><br>
                                            '.(empty($licencia->st2_email_solicitante)?$vacio:$licencia->st2_email_solicitante).'
                                        </div>
                                    </div>
                                </div>
                                <div style="padding:2px;">
                                    <div style="text-align:left; float:left; width:59%; border:solid 1px #000; border-radius:5px;">
                                        <div style="margin-left:10px;">
                                            <b>DOMICILIO</b><br>
                                            '.(empty($licencia->st2_domicilio_solicitante)?$vacio:$licencia->st2_domicilio_solicitante).'
                                        </div>
                                    </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:left; width:19%; border:solid 1px #000; border-radius:5px;">
                                    <b>NO. EXT.</b><br>
                                    '.(empty($licencia->st2_num_ext_solicitante)?$vacio:$licencia->st2_num_ext_solicitante).'
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:right; width:19%; border:solid 1px #000; border-radius:5px;">
                                    <b>NO. INT.</b><br>
                                    '.(empty($licencia->st2_num_int_solicitante)?$vacio:$licencia->st2_num_int_solicitante).'
                                </div>
                            </div>
                            <div style="padding:2px;">
                                <div style="float:right; width:49%; border:solid 1px #000; border-radius:5px;">
                                    <b>CP</b><br>
                                    '.(empty($licencia->st2_cp_solicitante)?$vacio:$licencia->st2_cp_solicitante).'
                                </div>
                                <div style="float:right; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="float:right; width:49.3%; border:solid 1px #000; border-radius:5px;">
                                    <b>COLONIA</b><br>
                                    '.(empty($licencia->st2_colonia_solicitante)?$vacio:$licencia->st2_colonia_solicitante).'
                                </div>
                            </div>
                            <div style="padding:2px;">
                                <div style="float:right; width:49%; border:solid 1px #000; border-radius:5px;">
                                    <b>TELÉFONO</b><br>
                                    '.(empty($licencia->st2_telefono_solicitante)?$vacio:$licencia->st2_telefono_solicitante).'
                                </div>
                                <div style="float:right; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="float:right; width:49.3%; border:solid 1px #000; border-radius:5px;">
                                    <b>CIUDAD</b><br>
                                    '.(empty($licencia->st2_ciudad_solicitante)?$vacio:$licencia->st2_ciudad_solicitante).'
                                </div>
                            </div>
                            <div style="padding:2px;">
                                <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>SE ADJUNTO LA IDENTIFICACIÓN DE PROPIETARIO / ARRENDATARIO</b><br>
                                        '.(empty($licencia->st2_identidficacion_solicitante)?'NO':'SI').'
                                    </div>
                                </div>
                            </div>';

                            if(strtolower($licencia->st1_tipo_solicitante) == "promotor"){
                                $html.=" </div>
                                </body>
                                </html>";
                                $this->pdf->WriteHTML($html);
                                $this->pdf->AddPage();
                                $html = "<html><body>";
                            }
                            $html.='<div style="padding:10px; text-align:left;">
                                <b>DATOS DEL ESTABLECIMIENTO</b>
                            </div>
                            <div style="padding:2px;">
                                <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>NOMBRE DEL ESTABLECIMIENTO</b><br>
                                        '.(empty($licencia->st3_nombre_establecimiento)?$vacio:$licencia->st3_nombre_establecimiento).'
                                    </div>
                                </div>
                            </div>
                            <div style="padding:2px;">
                                <div style="text-align:left; float:left; width:59%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>DOMICILIO</b><br>
                                        '.(empty($licencia->st3_domicilio_establecimiento)?$vacio:$licencia->st3_domicilio_establecimiento).'
                                    </div>
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:left; width:19%; border:solid 1px #000; border-radius:5px;">
                                    <b>NO. EXT.</b><br>
                                    '.(empty($licencia->st3_num_ext_establecimiento)?$vacio:$licencia->st3_num_ext_establecimiento).'
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:right; width:19%; border:solid 1px #000; border-radius:5px;">
                                    <b>LETRA EXT.</b><br>
                                    '.(empty($licencia->st3_letra_ext_establecimiento)?$vacio:$licencia->st3_letra_ext_establecimiento).'
                                </div>
                            </div>
                            <div style="padding:2px;">
                                <div style="text-align:left; float:left; width:59%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>COLONIA</b><br>
                                        '.(empty($licencia->st3_colonia_establecimiento)?$vacio:$licencia->st3_colonia_establecimiento).'
                                    </div>
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:left; width:19%; border:solid 1px #000; border-radius:5px;">
                                    <b>NO. INT.</b><br>
                                    '.(empty($licencia->st3_num_int_establecimiento)?$vacio:$licencia->st3_num_int_establecimiento).'
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:right; width:19%; border:solid 1px #000; border-radius:5px;">
                                    <b>LETRA INT.</b><br>
                                    '.(empty($licencia->st3_letra_int_establecimiento)?$vacio:$licencia->st3_letra_int_establecimiento).'
                                </div>
                            </div>';
                            if(strtolower($licencia->st1_tipo_solicitante) != "promotor"){
                                $html.=" </div>
                                </body>
                                </html>";
                                $this->pdf->WriteHTML($html);
                                $this->pdf->AddPage();
                                $html = "<html><body>";
                            }
                            $html.='<div style="padding:2px;">
                                <div style="text-align:left; float:left; width:32%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>CIUDAD</b><br>
                                        '.(empty($licencia->st3_ciudad_establecimiento)?$vacio:$licencia->st3_ciudad_establecimiento).'
                                    </div>
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:left; width:33%; border:solid 1px #000; border-radius:5px;">
                                    <b>ESTADO</b><br>
                                    '.(empty($licencia->st3_estado_establecimiento)?$vacio:$licencia->st3_estado_establecimiento).'
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:right; width:32%; border:solid 1px #000; border-radius:5px;">
                                    <b>CP</b><br>
                                    '.(empty($licencia->st3_cp_establecimiento)?$vacio:$licencia->st3_cp_establecimiento).'
                                </div>
                            </div>
                            <div style="padding:2px;">
                                <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>REFERENCIA DEL INMUEBLE</b><br>
                                        '.(empty($licencia->st3_especificaciones_establecimiento)?$vacio:$licencia->st3_especificaciones_establecimiento).'
                                    </div>
                                </div>
                            </div>';
                            $html.='<div style="padding:2px;">
                                <div style="text-align:left; float:left; width:32%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>EDIFICIO O PLAZA</b><br>
                                        '.(empty($licencia->st3_edificio_plaza_establecimiento)?$vacio:$licencia->st3_edificio_plaza_establecimiento).'
                                    </div>
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:left; width:33%; border:solid 1px #000; border-radius:5px;">
                                    <b>NÚMERO DE LOCAL</b><br>
                                    '.(empty($licencia->st3_num_local_establecimiento)?$vacio:$licencia->st3_num_local_establecimiento).'
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:right; width:32%; border:solid 1px #000; border-radius:5px;">
                                    <b>SUPERFICIE CONSTRUIDA</b><br>
                                    '.(empty($licencia->st3_sup_construida_establecimiento)?$vacio:$licencia->st3_sup_construida_establecimiento).'
                                </div>
                            </div>
                            <div style="padding:2px;">
                                <div style="text-align:left; float:left; width:32%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>ÁREA A UTILIZAR</b><br>
                                        '.(empty($licencia->st3_area_utilizar_establecimiento)?$vacio:$licencia->st3_area_utilizar_establecimiento).'
                                    </div>
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:left; width:33%; border:solid 1px #000; border-radius:5px;">
                                    <b>INVERSIÓN ESTIMADA</b><br>
                                    '.(empty($licencia->st3_inversion_establecimiento)?$vacio:$licencia->st3_inversion_establecimiento).'
                                </div>
                                <div style="float:left; width:1%;">
                                    &nbsp;
                                </div>
                                <div style="text-align:center; float:right; width:32%; border:solid 1px #000; border-radius:5px;">
                                    <b>NÚMERO DE EMPLEADOS</b><br>
                                    '.(empty($licencia->st3_empleados_establecimiento)?$vacio:$licencia->st3_empleados_establecimiento).'
                                </div>
                            </div>
                            <div style="padding:2px;">
                                <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>SE ADJUNTO LA FOTOGRAFIA PANORÁMICA DE LA FACHADA COMPLETA</b><br>
                                        '.(empty($licencia->st3_img1_establecimiento)?'NO':'SI').'
                                    </div>
                                </div>
                            </div>
                            <div style="padding:2px;">
                                <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>SE ADJUNTO LA FOTOGRAFIA PANORÁMICA DE LA FACHADA CON LA PUERTA O CORTINA ABIERTA</b><br>
                                        '.(empty($licencia->st3_img2_establecimiento)?'NO':'SI').'
                                    </div>
                                </div>
                            </div>
                            <div style="padding:2px;">
                                <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                    <div style="margin-left:10px;">
                                        <b>SE ADJUNTO LA FOTOGRAFIA DEL INTERIOR DEL ESTABLECIMIENTO</b><br>
                                        '.(empty($licencia->st3_img3_establecimiento)?'NO':'SI').'
                                    </div>
                                </div>
                            </div>';
                            if(!empty($licencia->st3_asignacion_numero)){
                                $html .= '<div style="padding:2px;">
                                    <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                                        <div style="margin-left:10px;">
                                            <b>SE ADJUNTO ASIGNACION DE NÚMERO OFICIAL</b><br>
                                            SI
                                        </div>
                                    </div>
                                </div>';
                            }
                            $html .='<div style="margin-top:5px;">
                                <div style="text-align:justify; float:right; width:99.8%;">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                    </p>
                                </div>
                            </div>
                            </div>
                            <div style="position:absolute; bottom:10%; text-align:right; width:84%;">
                                <div style="width:50%; float:right; border-top:solid 1px #000; text-align:center;">
                                    FIRMA DEL '.mb_strtoupper($licencia->st1_tipo_solicitante).'
                                </div>
                            </div>
                        </body>
                    </html>';
                    $this->pdf->WriteHTML($html);
                    $this->pdf->Output('Acuse_ventanilla.pdf', 'I');
       }
   }

   public function orden_pago(){
       extract($_GET);
       $fecha_limite=$this->FormatosModel->getDiasHabiles(date("Y/m/d"), $this->FormatosModel->_data_last_month_day() , [ '' ]);
       $idTramite = $this->utils->decode($lic);
       $idUsuario = $this->utils->decode($usu);
       $licencia = $this->LicenciasGiroModel->getLicencia($idUsuario, $idTramite);
       if(!$licencia){
           echo "<center><h3>Lo sentimos estamos teniendo problemas técnicos temporalmente; estamos trabajando para resolver esta situación los más pronto posible, por favor intenta de nuevo mas tarde  :(</center></h3>";
       }else{
           $id_licencia = $licencia->id_licencia;
           $scian = $licencia->clave_factibilidad;
           $actividad = mb_strtoupper($licencia->descripcion_factibilidad);
           $cajones_estacionamiento=$licencia->st3_cajones_estacionamiento_establecimiento;
           $aforo_personas="0";
           $superficie=$licencia->st3_area_utilizar_establecimiento;
           $horario="";
           $fecha_sesion="";
           $calle = mb_strtoupper($licencia->st3_domicilio_establecimiento);
           $no_ext = $licencia->st3_num_ext_establecimiento;
           $col = mb_strtoupper($licencia->st3_colonia_establecimiento);
           $clave_catastral = $licencia->clave_catastral;
           $no_int = $licencia->st3_num_int_establecimiento;
           $nombre = mb_strtoupper($licencia->st2_nombre_solicitante);
           $apellido_primer = mb_strtoupper($licencia->st2_primer_apellido_solicitante);
           $apellido_segundo = mb_strtoupper($licencia->st2_segundo_apellido_solicitante);
           $rfc = mb_strtoupper($licencia->st2_rfc_solicitante);
           $curp = mb_strtoupper($licencia->st2_curp_solicitante);
           $fecha_recepcion = explode(' ',$licencia->fecha);
           $fechaTitle = date("Y/m/d");
           $vacio="&nbsp;";
           if($licencia->folio_licencia == 0){
               $params = array(
                   'tipo_tramite'=>'13',
                   'scian'=>intval($scian),
                   'x'=>'0',
                   'y'=>'0',
                   'zona' => $licencia->predio_distrito,
                   'subzona' => $licencia->predio_sub_distrito,
                   'actividad'=> mb_strtoupper($actividad),
                   'cvecuenta'=>$licencia->cuenta_predial,
                   'propietario'=> mb_strtoupper($nombre),
                   'primer_ap'=> mb_strtoupper($apellido_primer),
                   'segundo_ap'=> mb_strtoupper($apellido_segundo),
                   'rfc'=>mb_strtoupper($rfc),
                   'curp'=>mb_strtoupper($curp),
                   'telefono_prop'=>$licencia->st2_telefono_solicitante,
                   'email'=>$licencia->st2_email_solicitante,
                   'cvecalle'=>'0',
                   'calle'=>mb_strtoupper($calle),
                   'num_ext'=>$no_ext,
                   'let_ext'=>mb_strtoupper($licencia->st3_letra_ext_establecimiento),
                   'num_int'=>$no_int,
                   'let_int'=>mb_strtoupper($licencia->st3_letra_int_establecimiento),
                   'colonia'=>mb_strtoupper($col),
                   'cp'=>$licencia->st3_cp_establecimiento,
                   'espubic'=>'',
                   'sup_autorizada'=>$superficie,
                   'num_cajones'=>$cajones_estacionamiento,
                   'num_empleados'=>$licencia->st3_empleados_establecimiento,
                   'aforo'=>$aforo_personas,
                   'inversion'=> $licencia->st3_inversion_establecimiento,
                   );
                   $data_soap=$this->utils->conec_soap('licTramite',$params);
                   $folio_licencia=$data_soap->licencia;
                   $this->LicenciasGiroModel->postPdf($idUsuario, $idTramite, $data_soap->licencia);
               }else{
                   $folio_licencia=$licencia->folio_licencia;
               }
               $params = array(
               'licencia'=>$folio_licencia,
               );
               $data_soap=$this->utils->conec_soap('licAdeudo',$params);

               $html='<html>
               <head>
                   <style>
                       body{
                           font-family: exo;
                           font-size:12px;
                       }
                   </style>
               </head>
               <body>
                   <div style="position:absolute; left:60px; top:4%; width:20%;">
                       <img src="assets/img/logo-padron.png" alt="">
                   </div>
                   <div  style="position:absolute; left:2%; top:13%; text-align:center; font-weight:bold; width:100%;  color:gray; font-size: 15px;">
                       <span>PROPUESTA DE COBRO</span>
                   </div>
                   <div style="position:absolute; right:10%; top:3%; width: 8%">
                       <img src="assets/img/gdl-logo.png" alt="">
                   </div>
                   <div style="position:absolute; top:17%; text-align:center; width:84%;">
                       <div style="padding:2px;">
                           <div style="float:right; width:32%; border:solid 1px #000; border-radius:5px;">
                               <b>FOLIO</b><br>
                               '.(empty($id_licencia)?$vacio:$this->FormatosModel->convertir_folio($id_licencia)).'
                           </div>
                           <div style="float:right; width:1%;">
                               &nbsp;
                           </div>
                           <div style="float:right; width:32%; border:solid 1px #000; border-radius:5px;">
                               <b>FECHA DE RECEPCIÓN</b><br>
                               '.$this->FormatosModel->fechasFormat(str_replace('-','/',$fecha_recepcion[0])).'
                           </div>
                           <div style="float:right; width:1%;">
                               &nbsp;
                           </div>
                           <div style="float:right; width:33%; border:solid 1px #000; border-radius:5px;">
                               <b>FECHA LIMITE DE PAGO</b><br>
                               '.$this->FormatosModel->fechasFormat($fecha_limite[3]).'
                           </div>
                       </div>
                       <div style="padding:2px;">
                           <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                               <div style="margin-left:10px;">
                                   <b>NOMBRE DEL CONTRIBUYENTE</b><br>
                                   '.(empty($nombre)?$vacio:$nombre).' '.(empty($apellido_primer)?$vacio:$apellido_primer).' '.(empty($apellido_segundo)?$vacio:$apellido_segundo).'
                               </div>
                           </div>
                       </div>
                       <div style="padding:2px;">
                           <div style="text-align:left; float:left; width:59%; border:solid 1px #000; border-radius:5px;">
                               <div style="margin-left:10px;">
                                   <b>DOMICILIO</b><br>
                                   '.(empty($calle)?$vacio:$calle).', COL. '.(empty($col)?$vacio:$col).'
                               </div>
                           </div>
                           <div style="float:left; width:1%;">
                               &nbsp;
                           </div>
                           <div style="text-align:center; float:left; width:19%; border:solid 1px #000; border-radius:5px;">
                               <b>NO. EXT.</b><br>
                               '.(empty($no_ext)?$vacio:$no_ext).'
                           </div>
                           <div style="float:left; width:1%;">
                               &nbsp;
                           </div>
                           <div style="text-align:center; float:right; width:19%; border:solid 1px #000; border-radius:5px;">
                               <b>NO. INT.</b><br>
                               '.(empty($no_int)?$vacio:$no_int).'
                           </div>
                       </div>
                       <div style="padding:2px;">
                           <div style="text-align:left; float:right; width:99.8%; border:solid 1px #000; border-radius:5px;">
                               <div style="margin-left:10px;">
                                   <b>Giro</b><br>
                                   '.(empty($actividad)?$vacio:$actividad).'
                               </div>
                           </div>
                       </div>
                       <div style="padding:2px;">
                           <div style="text-align:center; float:left; width:32%; border:solid 1px #000; border-radius:5px;">
                               <b>NO. CAJONES</b><br>
                               '.(empty($cajones_estacionamiento)? $vacio : $cajones_estacionamiento).'
                           </div>
                           <div style="float:left; width:1%;">
                               &nbsp;
                           </div>
                           <div style="text-align:center; float:left; width:32%; border:solid 1px #000; border-radius:5px;">
                               <b>SUPERFICIE AUTORIZADA</b><br>
                               '.(empty($superficie)?$vacio:$superficie).' mts
                           </div>
                           <div style="float:left; width:1%;">
                               &nbsp;
                           </div>
                           <div style="text-align:center; float:right; width:33%; border:solid 1px #000; border-radius:5px;">
                               <b>LICENCIA QUE SE AUTORIZA</b><br>
                               '.(empty($folio_licencia)?$vacio:$folio_licencia).'
                           </div>
                       </div>
                       <div style="text-align:justify; font-size:10px;">
                           <p>
                               ** Estimado usuario, al recibir la propuesta de cobro es su obligación verificar que los datos asentados en ella sean los correctos y antes
                               de realizar el pago deberá solicitar la aclaración de las tarifas aplicadas si existieran dudas de su parte.
                           </p><br>
                       </div>
                       <div>
                           <div style="font-size:10px; float:left; width:100%; text-align:normal; border: 1px solid black; border-radius: 5px;">
                               <table style="width:100%;" cellpadding="4">';

                                   for ($i=0; $i < count($data_soap); $i++) {
                                       $html .='<tr><td style="border:none;">
                                           '.$data_soap[$i]->descripcion.':
                                       </td>
                                       <td style="text-align:right; border:none;">
                                           $'.$data_soap[$i]->importe.'
                                       </td>
                                   </tr>';
                               }


                               $html .= '<tr>
                                   <td style="border:none;">
                                       <br>
                                       <b>IMPORTE TOTAL A PAGAR:</b>
                                   </td>
                                   <td style="text-align:right; border:none;">
                                       <br>
                                       <b>$'.$data_soap[(count($data_soap)-1)]->acumulado.'</b>
                                   </td>
                               </tr>
                           </table>
                       </div>
                       <div style="text-align:left; color:#C40E91; font-weight:bold; font-size:15px; margin-top:10px; margin-left:5px;">
                           <span>Esta propuesta de cobro sólo será válida hasta la fecha límite señalada a continuación:</span>
                       </div>
                       <div>
                           <div style="text-align:left; width:50%; float:left; margin-top:10%;">
                               <span><b>Fecha de impresión: '.$this->FormatosModel->fechasFormat($fechaTitle).'</b></span><br><br>
                               <barcode code="'.$this->utils->encode($folio_licencia).'" type="C128A" class="barcode" size="0.5" style="margin-left:-5px";/>
                               </div>
                               <div style="text-align:right; float:right; width:50%;">
                                   <span><b>Fecha límite de pago: '.$this->FormatosModel->fechasFormat($fecha_limite[3]).'</b></span>
                               </div>
                           </div>
                       </div>
                   </div>
               </body>
               </html>';


               $this->pdf->WriteHTML($html);
               $this->pdf->Output('propuesta_cobro.pdf', 'I');
       }
    }
}
