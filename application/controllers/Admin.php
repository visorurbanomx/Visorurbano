<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('LicenciasGiroModel');
        $this->output->set_template('admin');
        $this->load->section('top', 'admin/sections/top');
        $this->load->section('sidebar', 'admin/sections/sidebar');

        if (!$this->session->userdata('loged')){
            $red = $this->utils->encode((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            $this->session->sess_destroy();
            redirect(base_url().'ingresar?redirect='.$red, 'refresh');
        }
    }
    public function index()
    {
        switch ($this->session->userdata('level')){
            case 1:
                $data['licencias'] = $this->LicenciasGiroModel->getLicencias($this->session->userdata('idU'), false);
                $this->load->view('admin/index', $data);
            break;
            case 2:
                $data['licenciasVentanilla'] = $this->LicenciasGiroModel->getLicenciasVentanilla($this->session->userdata('idU'), false);
                $data['licenciasTVentanilla'] = $this->LicenciasGiroModel->getLicenciasByStatus('V');
                $this->load->css('https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css');
                $this->load->js('https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js');
                $this->load->view('admin/funcionarios_padron/bandeja_ventanilla', $data);
            break;
            case 3:
                $this->load->css('https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css');
                $this->load->js('https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js');
                redirect(base_url().'revision','refresh');
            break;
        }

    }
    public function misLicencias()
    {
        $data['licencias'] = $this->LicenciasGiroModel->getLicencias($this->session->userdata('idU'), true);
        $this->load->view('admin/misLicencias', $data);
    }
    public function impresion()
    {
        $data['levelUsuario'] = $this->session->userdata('level');
        if ($this->session->userdata('level') < 2){
            redirect(base_url().'admin', 'refresh');
        }
        $data['licencias'] = $this->LicenciasGiroModel->getLicenciasByStatus('FL');
        $this->load->css('https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css');
        $this->load->js('https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js');
        $this->load->view('admin/impresion', $data);
    }
    public function perfilUsuario(){
        $this->load->js(base_url().'assets/js/jquery.validate.min.js');
        $this->load->js(base_url().'assets/js/md5-min.js');
        $this->load->view('admin/perfil_usuario');
    }

    public function mensajes(){
        $data['mensajes'] = $this->Mensajes->getMensajes($this->session->userdata('idU'), 0, false);
        $this->load->css('https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css');
        $this->load->js('https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js');
        $this->load->view('admin/mensajes', $data);
    }

    public function mensaje(){
        $idMensaje = $cuenta = $this->uri->segment(3, 0);
        $mensaje = $this->Mensajes->getMensaje($this->session->userdata('idU'), $this->utils->decode($idMensaje));
        if (empty($mensaje)){
            $data['error'] = true;
        }else{
            $data['error'] = false;
            $data['mensaje'] = $mensaje;
            $this->Mensajes->setLeido($this->utils->decode($idMensaje));
        }
        $this->load->view('admin/mensaje', $data);
    }

    public function confirmacion_licencia(){
        $this->load->js(base_url().'assets/js/confirmacion_licencia.min.js');
        extract($_POST);
        if(empty($licencia)){
            $licencia="";
        }
        $datos['licencia'] = $licencia;
        $this->load->view('admin/confirmacion_licencia',$datos);
    }


}
