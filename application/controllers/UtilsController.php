<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UtilsController extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('utils');
        $this->load->model('LicenciasGiroModel');
    }

    public function getTramite(){
        try{
            if ($_SERVER['REQUEST_METHOD'] != 'GET') {
                throw new Exception('Bad request', 400);
            }
            $params = $_REQUEST;
            $result = $this->LicenciasGiroModel->getLicencia('', $params['idTramite']);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('status' => 200, 'message' =>'Sucesfully', 'data'=>$result)));
        }
        catch (Exception $e) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('status' => $e->getCode(), 'message' => $e->getMessage())));
        }
    }

    public function validateCuentaPredial(){
        try{
            if ($_SERVER['REQUEST_METHOD'] != 'GET') {
                throw new Exception('Bad request', 400);
            }
            $params = $_REQUEST;
            if (empty($params['original'])){
                throw new Exception('la cadena original es requerida.', 404);
            }
            if (empty($params['compare'])){
                throw new Exception('la cadena a comparar es requerida.', 404);
            }
            if (empty($params['cuenta_catastro'])){
                throw new Exception('la cuenta catastral es requerida.', 404);
            }
            if (empty($params['factibilidad'])){
                throw new Exception('El folio del trámite de factibilidad es requerido.', 404);
            }
            $factibilidad = '';//api para datos de dictamen
            if ($factibilidad->status != 200){
                throw new Exception('Folio de factibilidad no valido.', 401);
            }
            if ($factibilidad->data[0]->clave != $params['cuenta_catastro']){
                throw new Exception('El folio de factibilidad no es valido para este predio.', 401);
            }

            if ($factibilidad->data[0]->resultado == 'PROHIBIDO'){
                throw new Exception('El giro solicitado se encuentra prohibido conforme a la zonificación del predio.', 401);
            }

            if ($this->utils->compareDecript($params['original'], $params['compare'])){
                $result =  $this->LicenciasGiroModel->setLicencia($this->session->userdata('idU'),$this->session->userdata('nombre').' '.$this->session->userdata('primer_apellido').' '.$this->session->userdata('segundo_apellido'), $params['original'], $params['cuenta_catastro'], strtoupper($params['factibilidad']), $factibilidad->data[0]->descripciongiro, $factibilidad->data[0]->codigogiro, $factibilidad->data[0]->numerodistrito, $factibilidad->data[0]->numerosubdistrito, $factibilidad->data[0]->zonificacion, $this->session->userdata('level'), $factibilidad->data[0]->superficie);
                if ($result['status']){
                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode(array('status' => 200, 'message' =>'Sucesfully', 'data'=>array('sec' => $this->utils->encode($result['id']), 'sec2'=>$this->utils->encode($this->session->userdata('idU')), 'id'=>$result['id']))));
                }else{
                    throw new Exception('Ya existe un tramite con los mismos parametros', 401);
                }
            }else{
              throw new Exception('El número de cuenta predial es incorrecto.', 401);
            }
        }catch (Exception $e) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('status' => $e->getCode(), 'message' => $e->getMessage())));
        }
    }

    public function validateClaveCatastral(){
        try{
            if ($_SERVER['REQUEST_METHOD'] != 'GET') {
                throw new Exception('Bad request', 400);
            }
            $params = $_REQUEST;
            if (empty($params['clave'])){
                throw new Exception('La clave catastral es requerida', 404);
            }
            $result = ""; //api de datos de catastro
            if ($result->status == 200){
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('status' => 200, 'message' =>'Sucesfully')));
            }else{
                throw new Exception('Not found', 404);
            }
        }catch (Exception $e) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('status' => $e->getCode(), 'message' => $e->getMessage())));
        }
    }

    public function datosPropietario(){
        try{
            if ($_SERVER['REQUEST_METHOD'] != 'GET') {
                throw new Exception('Bad request', 400);
            }
            $params = $_REQUEST;
            if (empty($params['clave'])){
                throw new Exception('La clave catastral es requerida', 404);
            }
            $result = ""; //api de datos de catastro
            if ($result->status == 200){
                $data['nombre'] = $result->data->propietario->nombre;
                $data['ape_paterno'] = $result->data->propietario->ape_paterno;
                $data['ape_materno'] = $result->data->propietario->ape_materno;
                $data['razonsocial'] = $result->data->propietario->razonsocial;
                $data['rfc'] = $result->data->propietario->rfc;
                $data['calle'] = $result->data->propietario->calle;
                $data['colonia'] = $result->data->propietario->colonia;
                $data['curp'] = $result->data->propietario->curp;
                $data['n_exterior'] = $result->data->propietario->n_exterior;
                $data['n_interior'] = $result->data->propietario->n_interior;
                $data['ciudad'] = $result->data->propietario->ciudad;
                $data['estado'] = $result->data->propietario->estado;
                $data['cp'] = $result->data->propietario->cp;
                $data['telefono'] = $result->data->propietario->telefono;
                if(!is_int($data['n_exterior'])){
                    $data['n_exterior'] = 0;
                }
                if(!is_int($data['n_interior'])){
                    $data['n_interior'] = 0;
                }
                $this->LicenciasGiroModel->updatePropietario($result,$params['clave']);
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('status' => 200, 'message' =>'Sucesfully', 'data'=>$data)));
            }else{
                throw new Exception('Not found', 404);
            }
        }catch (Exception $e) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('status' => $e->getCode(), 'message' => $e->getMessage())));
        }
    }

    public function setMensaje(){
        try{
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Bad request', 400);
            }
            $params = $_REQUEST;
            if (empty($params['de'])){
                throw new Exception('El remitente del mensaje es requerido para continuar.', 404);
            }
            if (empty($params['para'])){
                throw new Exception('El destinatario del mensaje es requerido para continuar.', 404);
            }
            if (empty($params['mensaje'])){
                throw new Exception('El mensaje es requerido para continuar.', 404);
            }
            $result = $this->Mensajes->setMensaje($params['de'], $params['para'], $params['mensaje']);
            if ($result){
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('status' => 200, 'message' =>'Sucesfully')));
            }else{
                throw new Exception('Internal server error.', 505);
            }
        }catch (Exception $e) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('status' => $e->getCode(), 'message' => $e->getMessage())));
        }
    }

    function isMercado(){
        try{

        }catch (Exception $e) {
           return false;
        }
    }


}
