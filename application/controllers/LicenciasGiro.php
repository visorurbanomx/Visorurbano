<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LicenciasGiro extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('LicenciasGiroModel');
        $this->load->library('utils');
        $this->load->section('top', 'admin/sections/top');
        $this->load->section('sidebar', 'admin/sections/sidebar');

        if (!$this->session->userdata('loged')){
            $cuenta = $this->uri->segment(2, 0);
            $red = $this->utils->encode((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            $this->session->sess_destroy();
            redirect(base_url().'ingresar?redirect='.$red, 'refresh');
        }
    }
    public function index()
    {
        $this->output->set_template('admin');
        $this->load->js(base_url().'assets/js/jquery.validate.min.js');
        $this->load->view('giro/iniciarTramite');
    }
    public function requisitos(){
        $this->output->set_template('admin');
        $data['cuenta'] = $this->uri->segment(2, 0);
        $this->load->view('giro/index', $data);
    }
    public function licenciaGiroForma(){
        $this->output->set_template('admin');
        $idTramite = $this->utils->decode($this->uri->segment(2, 0));
        $idUsuario = $this->session->userdata('idU');
        if ($this->session->userdata('level') == 2){
            $licencia = $this->LicenciasGiroModel->getLicencia('',$idTramite);
            $firma = "";

        }else{
            $licencia = $this->LicenciasGiroModel->getLicencia($idUsuario, $idTramite);
            $firma = $this->LicenciasGiroModel->getFirma($idUsuario, $idTramite);
        }

        if($firma != ""){
          $data['firma']= $firma->firma_e;
        }else{
            $data['firma'] = null;
        }
        //var_dump($licencia);
        if (!empty($licencia)){
            $data['licencia'] = $licencia;
            $data['error']= false;
            $cuenta = $licencia->clave_catastral;
            $data['cuenta'] = $cuenta;
            $mercado =  $this->LicenciasGiroModel->isMercado($cuenta);
            $predio = '';//api para obtener datos de catastro ;
            if (!$predio){
                $data['error']= true;
                $data['msg']= '<b>Upss</b> Lo sentimos estamos teniendo problemas temporalmente; estamos trabajando para resolver esta situación los mas pronto posible, por favor intenta de nuevo mas tarde  :(';
            }else{
                //Config
                if (empty($mercado)){
                    $data['mercado'] = false;
                }else{
                    $data['mercado'] = true;
                }
                $zonificacion = explode('/', $licencia->predio_zonificacion);
                $data['zonificacion'] = $zonificacion[2];
                //Step 1
                $data['st1_carta_responsiva'] = $licencia->st1_carta_responsiva;
                $data['st1_tipo_solicitante'] = $licencia->st1_tipo_solicitante;
                $data['st1_tipo_representante'] = $licencia->st1_tipo_representante;
                $data['st1_tipo_carta_poder'] = $licencia->st1_tipo_carta_poder;
                $data['st1_carta_poder'] = $licencia->st1_carta_poder;
                $data['st1_identificacion_otorgante'] = $licencia->st1_identificacion_otorgante;
                $data['st1_identificacion_testigo1'] = $licencia->st1_identificacion_testigo1;
                $data['st1_identificacion_testigo2'] = $licencia->st1_identificacion_testigo2;
                $data['st1_contrato_arrendamiento'] = $licencia->st1_contrato_arrendamiento;
                $data['st1_faculta'] = $licencia->st1_faculta;
                $data['st1_anuencia'] = $licencia->st1_anuencia;
                $data['st1_carta_anuencia'] = $licencia->st1_carta_anuencia;
                //Step 2
                $data['st2_nombre_representante'] = $licencia->st2_nombre_representante;
                $data['st2_primer_apellido_solicitante'] = $licencia->st2_primer_apellido_solicitante;
                $data['st2_segundo_apellido_solicitante'] = $licencia->st2_segundo_apellido_solicitante;
                $data['st2_curp_representante'] = $licencia->st2_curp_representante;
                $data['st2_rfc_representante'] = $licencia->st2_rfc_representante;
                $data['st2_priper_apellido_representante'] = $licencia->st2_priper_apellido_representante;
                $data['st2_segundo_apellido_representante'] = $licencia->st2_segundo_apellido_representante;
                if($this->session->userdata('level') == 1){
                    if (!empty($licencia->st2_email_representante)){
                        $data['st2_email_representante'] = $licencia->st2_email_representante;
                    }else{
                        $data['st2_email_representante'] = $this->session->userdata('email');
                    }
                }else{
                    $data['st2_email_representante'] = '';
                }

                $data['st2_domicilio_representante'] = $licencia->st2_domicilio_representante;
                if ($licencia->st2_num_ext_representante > 0){
                    $data['st2_num_ext_representante'] = $licencia->st2_num_ext_representante;
                }else{
                    $data['st2_num_ext_representante'] = '';
                }
                if ($licencia->st2_num_int_representante > 0){
                    $data['st2_num_int_representante'] = $licencia->st2_num_int_representante;
                }else{
                    $data['st2_num_int_representante'] = '';
                }
                $data['st2_colonia_representante'] = $licencia->st2_colonia_representante;
                $data['st2_ciudad_representante'] = $licencia->st2_ciudad_representante;
                if ($licencia->st2_cp_representante > 0){
                    $data['st2_cp_representante'] = $licencia->st2_cp_representante;
                }else{
                    $data['st2_cp_representante'] = '';
                }
                if($this->session->userdata('level') == 1){
                    if (!empty($licencia->st2_email_representante)){
                        $data['st2_telefono_representante'] = $licencia->st2_telefono_representante;
                    }else{
                        $data['st2_telefono_representante'] = $this->session->userdata('celular');
                    }
                }else{
                    $data['st2_telefono_representante'] = '';
                }

                $data['st2_identificacion_representante'] = $licencia->st2_identificacion_representante;
                //Step 2.1
                $data['st2_nombre_solicitante'] = $licencia->st2_nombre_solicitante;
                $data['st2_curp_solicitante'] = $licencia->st2_curp_solicitante;
                $data['st2_rfc_solicitante'] = $licencia->st2_rfc_solicitante;
                if($this->session->userdata('level') == 1){
                    if (!empty($licencia->st2_email_representante)){
                        $data['st2_email_solicitante'] = $licencia->st2_email_solicitante;
                    }else{
                        $data['st2_email_solicitante'] = $this->session->userdata('email');
                    }
                }else{
                    $data['st2_email_solicitante'] = $licencia->st2_email_solicitante;
                }
                $data['st2_domicilio_solicitante'] = $licencia->st2_domicilio_solicitante;
                if ($licencia->st2_num_ext_solicitante > 0){
                    $data['st2_num_ext_solicitante'] = $licencia->st2_num_ext_solicitante;
                }else{
                    $data['st2_num_ext_solicitante'] = '';
                }
                if ($licencia->st2_num_int_solicitante > 0){
                    $data['st2_num_int_solicitante'] = $licencia->st2_num_int_solicitante;
                }else{
                    $data['st2_num_int_solicitante'] = '';
                }
                $data['st2_colonia_solicitante'] = $licencia->st2_colonia_solicitante;
                $data['st2_ciudad_solicitante'] = $licencia->st2_ciudad_solicitante;
                if ($licencia->st2_cp_solicitante > 0){
                    $data['st2_cp_solicitante'] = $licencia->st2_cp_solicitante;
                }else{
                    $data['st2_cp_solicitante'] = '';
                }
                if($this->session->userdata('level') == 1){
                    if (!empty($licencia->st2_email_representante)){
                        $data['st2_telefono_solicitante'] = $licencia->st2_telefono_solicitante;
                    }else{
                        $data['st2_telefono_solicitante'] = $this->session->userdata('celular');
                    }
                }else{
                    $data['st2_telefono_solicitante'] = $licencia->st2_telefono_solicitante;
                }

                $data['st2_identidficacion_solicitante'] = $licencia->st2_identidficacion_solicitante;
                //Step3
                $data['descripcion_factibilidad'] = $licencia->descripcion_factibilidad;
                $data['st3_nombre_establecimiento'] = $licencia->st3_nombre_establecimiento;
                if (!empty($licencia->st3_domicilio_establecimiento)){
                    $data['st3_domicilio_establecimiento'] = $licencia->st3_domicilio_establecimiento;
                }else{
                    $data['st3_domicilio_establecimiento'] = $predio->data->calle;
                }
                if (!empty($licencia->st3_num_ext_establecimiento)){
                    $data['st3_num_ext_establecimiento'] = $licencia->st3_num_ext_establecimiento;
                }else{
                    $data['st3_num_ext_establecimiento'] = (int)$predio->data->numeroExterior;
                }
                if ($licencia->st3_num_int_establecimiento > 0){
                    $data['st3_num_int_establecimiento'] = $licencia->st3_num_int_establecimiento;
                }else{
                    $data['st3_num_int_establecimiento'] = '';
                }
                $data['st3_letra_ext_establecimiento'] = $licencia->st3_letra_ext_establecimiento;
                $data['st3_letra_int_establecimiento'] = $licencia->st3_letra_int_establecimiento;
                if (!empty($licencia->st3_colonia_establecimiento)){
                    $data['st3_colonia_establecimiento'] = $licencia->st3_colonia_establecimiento;
                }else{
                    $data['st3_colonia_establecimiento'] = $predio->data->colonia;
                }
                if (!empty($licencia->st3_ciudad_establecimiento)){
                    $data['st3_ciudad_establecimiento'] = $licencia->st3_ciudad_establecimiento;
                }else{
                    $data['st3_ciudad_establecimiento'] = $predio->data->poblacion;
                }
                if (!empty($licencia->st3_estado_establecimiento)){
                    $data['st3_estado_establecimiento'] = $licencia->st3_estado_establecimiento;
                }else{
                    $data['st3_estado_establecimiento'] = $predio->data->estado;
                }
                if ($licencia->st3_cp_establecimiento > 0){
                    $data['st3_cp_establecimiento'] = $licencia->st3_cp_establecimiento;
                }else{
                    $data['st3_cp_establecimiento'] = '';
                }
                $data['st3_especificaciones_establecimiento'] = $licencia->st3_especificaciones_establecimiento;
                $data['st3_edificio_plaza_establecimiento'] = $licencia->st3_edificio_plaza_establecimiento;
                if ($licencia->st3_num_local_establecimiento > 0){
                    $data['st3_num_local_establecimiento'] = $licencia->st3_num_local_establecimiento;
                }else{
                    $data['st3_num_local_establecimiento'] = '';
                }

                if (!empty($licencia->st3_sup_construida_establecimiento)){
                    $data['st3_sup_construida_establecimiento'] = $licencia->st3_sup_construida_establecimiento;
                }else{
                    $data['st3_sup_construida_establecimiento'] = (int)$predio->data->avaluo->areaConstruccionAvaluo;
                }
               $data['st3_area_utilizar_establecimiento'] = $licencia->st3_area_utilizar_establecimiento;
                if ($licencia->st3_inversion_establecimiento > 0){
                    $data['st3_inversion_establecimiento'] = $licencia->st3_inversion_establecimiento;
                }else{
                    $data['st3_inversion_establecimiento'] = '';
                }
                if ($licencia->st3_empleados_establecimiento > 0){
                    $data['st3_empleados_establecimiento'] = $licencia->st3_empleados_establecimiento;
                }else{
                    $data['st3_empleados_establecimiento'] = '';
                }
                if ($licencia->st3_cajones_estacionamiento_establecimiento > 0){
                    $data['st3_cajones_estacionamiento_establecimiento'] = $licencia->st3_cajones_estacionamiento_establecimiento;
                }else{
                    $data['st3_cajones_estacionamiento_establecimiento'] = '';
                }
                $data['st3_dictamen_tecnico_movilidad'] = $licencia->st3_dictamen_tecnico_movilidad;
                $data['st3_img1_establecimiento'] = $licencia->st3_img1_establecimiento;
                $data['st3_img2_establecimiento'] = $licencia->st3_img2_establecimiento;
                $data['st3_img3_establecimiento'] = $licencia->st3_img3_establecimiento;
                $data['st3_dictamen_lineamiento'] = $licencia->st3_dictamen_lineamiento;
                $data['st3_es_numero_interior'] = $licencia->st3_es_numero_interior;
                $data['st4_declaratoria'] = $licencia->st4_declaratoria;
                $data['status'] = $predio->status;

                $data['st3_asignacion_numero'] = $licencia->st3_asignacion_numero;
            }

        }else{
            $data['error']= true;
            $data['msg']= '<b>Error.</b> La solicitud a la que estas intentando acceder no existe ó no tienes los permisos suficientes para continuar con el trámite.';
        }

        $this->load->css(base_url().'assets/css/admin/steps.css');
        $this->load->css(base_url().'assets/css/lightbox.min.css');
        $this->load->css(base_url().'assets/css/select.css');
        $this->load->js(base_url().'assets/js/jquery.validate.min.js');
        $this->load->js(base_url().'assets/js/jquery.steps.min.js');
        $this->load->js(base_url().'assets/vendor/progressbar.js');
        $this->load->js(base_url().'assets/vendor/select/select.min.js');
        $this->load->js(base_url().'assets/vendor/lightbox.min.js');
        $this->load->view('giro/licencia_de_giro_forma', $data);
    }

    public function validar_ventanilla(){
        extract($_POST);
        $id = explode('/',$datos);
        $cont = count($id);
        $usuario = $this->utils->decode($id[$cont-1]);
        $tramite = $this->utils->decode($id[$cont-2]);
        $usuario_ventanilla=$this->session->userdata('nombre').' '.$this->session->userdata('primer_apellido').' '.$this->session->userdata('segundo_apellido');
        $res = $this->LicenciasGiroModel->validar($usuario,$tramite,$usuario_ventanilla);
        echo $res;
    }

    public function licenciaGiroConfirmacion(){
        $this->output->set_template('admin');
        $cuenta = $this->uri->segment(3, 0);
        $data['cuenta'] = $cuenta;
        $predio = ''; //api para data de catastro
        $data['status'] = $predio->status;
        if ($predio->status == 200){
            $data['cpredial'] = $this->utils->encode($predio->data->cuenta);
            $data['adeudo'] = 0;//$predio->data->adeudo->saldo;
        }
        $this->load->js(base_url().'assets/js/jquery.validate.min.js');
        $this->load->view('giro/licencia_de_giro_confirmacion', $data);
    }

    public function updateForma(){
        try{
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Bad request', 400);
            }
            $params = $_REQUEST;
            if (empty($params['licencia'])){
                throw new Exception('El folio del trámite es requerido', 404);
            }
            $data = $params['campos'];
            if($data['step'] == 2){
                $validacion=$this->validacionPropietarioLic($params['licencia']);
            }else{
                $validacion=false;
            }
            $result =  $this->LicenciasGiroModel->updateLicencia($params['licencia'], $data, $params['firma']);
            if ($result['status']){
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('status' => 200, 'message' =>'Sucesfully','validacionMultiLic' => $validacion)));
            }else{
                throw new Exception('Ocurrio un error inesperado por favor intenta mas tarde.', 401);
            }
        }catch (Exception $e) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('status' => $e->getCode(), 'message' => $e->getMessage())));
        }
    }

    function subir_archivos(){
        if(!empty($_FILES['uploaded_file']) || !empty($_FILES['uploaded_file1'])){
          if(!empty($_FILES['uploaded_file'])){
            $file_name = $_FILES['uploaded_file']['name'];
            $file_tmp = $_FILES['uploaded_file']['tmp_name'];
            $file_ext=explode('.',$file_name);
          }else if(!empty($_FILES['uploaded_file1'])){
            $file_name = $_FILES['uploaded_file1']['name'];
            $file_tmp = $_FILES['uploaded_file1']['tmp_name'];
            $file_ext=explode('.',$file_name);
          }
          $folio=$_POST['folio'];
          $tipo=$_POST['tipo'];
          $pass=$_POST['pass'];
          if(!is_dir(__DIR__.'/archivos_sat/'.$folio)){
              mkdir(__DIR__.'/archivos_sat/'.$folio, 0777);
          }
          chmod(__DIR__.'/archivos_sat/'.$folio, 0777);
          copy($file_tmp, __DIR__."/archivos_sat/".$folio."/".$file_name);

          switch($tipo){
              case "key":
              if($file_ext[1] == 'key'){
                if($firma = $this->generar_key_pem($folio,$pass,$file_name)){
                  $this->eliminar_archivos($folio,$file_name);
                  echo $firma;
                }
              }else{
                echo json_encode(array('status' => false, 'data' => 'Archivo incorrecto'));
              }
              break;
              case "cer":
                if($file_ext[1] == 'cer'){
                  if($cer = $this->get_certificado($folio,$file_name)){
                    $this->eliminar_archivos($folio,$file_name);
                    echo json_encode(array('status' => true, 'data' => $cer));
                  }else{
                    echo json_encode(array('status' => false, 'data' => 'No se genero el proceso de verificación .cer'));
                  }
                }else{
                  echo json_encode(array('status' => false, 'data' => 'Archivo incorrecto'));
                }
              break;
          }
        }
    }

    function eliminar_archivos($folio,$file_name){
       $dir = __DIR__.'/archivos_sat/'.$folio.'/';
       $handle = opendir($dir);
       $ficherosEliminados = 0;
       while ($file = readdir($handle)) {
           if (is_file($dir.$file)) {
               if (unlink($dir.$file) ){
                   $ficherosEliminados++;
               }
           }
       }
       rmdir(__DIR__.'/archivos_sat/'.$folio);
    }

    function sellar($cadenaOriginal,$folio,$file_name){
        $key = __DIR__.'/archivos_sat/'.$folio.'/'.$file_name.'.pem';
        $fp = fopen (__DIR__.'/archivos_sat/'.$folio.'/utf.txt', 'w+');
        $fw = fwrite($fp, $cadenaOriginal);
        fclose($fp);
        $fs = fopen (__DIR__.'/archivos_sat/'.$folio.'/sello.txt', 'w+');
        fclose($fs);
        $firma = shell_exec ('openssl dgst -sha256 '.$key.' utf.txt | openssl enc -base64 -A > '.__DIR__.'/archivos_sat/'.$folio.'/sello.txt');
        $leer = readfile(__DIR__.'/archivos_sat/'.$folio.'/sello.txt');
        return $leer;
      }

      public function generar_key_pem($folio,$pass,$file_name){
          $nombreKey =__DIR__.'/archivos_sat/'.$folio.'/'.$file_name;
          $password = $this->input->post('pass');
          $cadenaOriginal = $this->input->post('cadena_original');
          if (file_exists($nombreKey)) {
              $salida = shell_exec('openssl pkcs8 -inform DER -in '.$nombreKey.' -out '.$nombreKey.'.pem -passin pass:'.$password.' 2>&1');
              if($salida == '' || $salida == false || $salida == null){
                $keypem = $nombreKey.'.pem';
                if($sello = $this->sellar($cadenaOriginal,$folio,$file_name)){
                  return $sello;
                }else{
                  echo json_encode(array('status' => false, "data" => 'No se logro generar el key.pem'));
                }
              }else if (strpos($salida, 'Error decrypting') !== false) {
                echo json_encode(array('status' => false, "data" => 'contraseña incorrecta'));
                return false;
              }else {
                echo json_encode(array('status' => false, "data" => 'No se logro generar el key.pem'));
                return false;
              }
          }else {
              echo json_encode(array('status' => false, "data" => 'El archivo requerido no esta disponible'));
              return false;
          }
      }

      public function get_certificado($folio,$file_name){
          $data = shell_exec ('openssl x509 -inform der -in '.__DIR__.'/archivos_sat/'.$folio.'/'.$file_name.' -noout -text');
          if($data){
            $inicio = strrpos($data, 'Subject:');
            $rest = substr($data, $inicio);
            $porciones = explode('Subject Public Key Info:', $rest);
            $porciones = explode(':', $porciones[0]);
            $porciones = str_replace('/',',',$porciones[1]);
            $porciones = explode('=',$porciones);
            $arrayCertificado = array();
            for ($i=0; $i < count($porciones); $i++) {
              if($i > 2){
                $recorte = explode(',',$porciones[$i]);
                array_push($arrayCertificado, $recorte[0]);
              }
            }
            return $arrayCertificado;
          }else{
            return false;
          }
        }

        public function redir_validacion(){
            $params = $_REQUEST;
            $validacion = $this->validacionPropietarioLic($params['licencia']);
            $this->output->set_output(json_encode(array('status' => 200, 'message' =>'Sucesfully','validacionMultiLic' => $validacion)));
        }

    public function validacionPropietarioLic($idLic){
            $cuenta = $this->LicenciasGiroModel->consultClave($idLic);
            $params = array(
                'cvecuenta'=> $cuenta,
            );
            $data_soap=$this->utils->conec_soap('consLicXCvecuenta',$params);
            $consulta = $this->LicenciasGiroModel->PropietarioLic($data_soap,$idLic);
            return $consulta;
        }

        public function getNegocio(){
            extract($_GET);
            $licencia = $this->LicenciasGiroModel->getNegocio($licencia);
            echo json_encode(array("status"=>'true', "data" => $licencia));
        }

        public function deleteFile(){
            extract($_POST);
            $delete = $this->LicenciasGiroModel->emptyField($licencia, $campo);
            echo json_encode(array("status"=>'true'));
        }

        public function limpiar_tabla(){
            extract($_POST);
            $delete = $this->LicenciasGiroModel->emptyTabla($licencia);
            echo json_encode(array("status"=>'true'));
        }

        public function step(){
            extract($_GET);
            $licencia = $this->LicenciasGiroModel->getStep($licencia);
            echo json_encode(array("status"=>'true', "data" => $licencia));
        }

    }
