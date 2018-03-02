<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class EmailController extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('EmailModel');
        $this->load->model('ProcesosModel');
    }

    public function Email(){
        extract($_POST);
        $respuesta=$this->EmailModel->sendEmail($nombre,$de,$mensaje,$asunto,$telefono);
        echo json_encode($respuesta);
    }

    public function licencias_sincronizacion(){
        $respuesta = $this->ProcesosModel->proceso_sincronizar();
    }
}
