<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('AuthModel');
        $this->load->helper('url');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    public function index()
    {
        if ($this->session->userdata('loged')){
            redirect(base_url().'admin', 'refresh');
        }
        $params = $_REQUEST;
        if (isset($params['redirect'])){
            $data['redirect'] = $this->utils->decode($params['redirect']);
        }else{
            $data['redirect'] = "";
        }
        $this->output->set_template('login');
        $this->load->js(base_url().'assets/js/md5-min.js');
        $this->load->view('auth/login', $data);
    }

    public function crearCuenta(){
        $this->output->set_template('login');
        $this->load->js('https://www.google.com/recaptcha/api.js');
        $this->load->js(base_url().'assets/js/md5-min.js');
        $this->load->view('auth/register');
    }

    public function login(){
        try{
            if ($_SERVER['REQUEST_METHOD'] != 'POST'){
                throw new Exception('Bad request', 400);
            }
            $params = $_REQUEST;
            $dataSesion = array(
                'loged' => 1,
                'nombre'=>$params['nombre'],
                'primer_apellido'=>$params['primer_apellido'],
                'segundo_apellido'=>$params['segundo_apellido'],
                'email'=>$params['email'],
                'celular'=>$params['celular'],
                'level'=>$params['level'],
                'idU'=>$params['idU']
            );
            $this->session->set_userdata($dataSesion);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('status'=>200, 'message'=>'succesfully')));

        }catch (Exception $e){
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('status' => $e->getCode(),'message' => $e->getMessage())));
        }
    }

    public function logout(){
        try{
            if ($_SERVER['REQUEST_METHOD'] != 'POST'){
                throw new Exception('Bad request', 400);
            }else{
                $this->session->sess_destroy();
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('status'=>200, 'message'=>'succesfully')));
            }
        }catch (Exception $e){
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('status' => $e->getCode(),'message' => $e->getMessage())));
        }
    }
    public function updateSession(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST'){
            throw new Exception('Bad request', 400);
        }

        $params = $_REQUEST;
        if (isset($params['nombres'])){
            $this->session->set_userdata('nombre', $params['nombres']);
        }
        if (isset($params['ape_pat'])){
            $this->session->set_userdata('primer_apellido', $params['ape_pat']);
        }
        if (isset($params['ape_mat'])){
            $this->session->set_userdata('segundo_apellido', $params['ape_mat']);
        }
        if (isset($params['celular'])){
            $this->session->set_userdata('celular', $params['celular']);
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array('status'=>200, 'message'=>'succesfully')));
    }

    public function recuperarContrasena(){
        if ($this->session->userdata('loged')){
            redirect('http://localhost/backend/admin', 'refresh');
        }
        $this->output->set_template('login');
        $this->load->view('auth/recuperarContrasena');
    }

}
