<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RevisionController extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('RevisionModel');
        if($this->session->userdata('level') != 3){
            redirect(base_url().'admin','refresh');
        }else if (!$this->session->userdata('loged')){
            $this->session->sess_destroy();
            redirect(base_url().'ingresar', 'refresh');
        }
    }

    public function index(){
        $this->output->set_template('revision');
        $this->load->section('top', 'admin/sections/top');
        $this->load->section('sidebar', 'admin/sections/sidebar');
        $this->load->css('https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css');
        $this->load->js('https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js');
        $this->load->css(base_url().'assets/css/lightbox.min.css');
        $this->load->js(base_url().'assets/vendor/lightbox.min.js');
        $this->load->js(base_url().'assets/js/revision.min.js');
        $this->load->js(base_url().'assets/js/admin-min.js');
        $this->load->view('admin/revision');
    }

    public function licencias(){
        $Tipo = $this->input->post('tipo');
        $lista=$this->RevisionModel->getLicencias($Tipo);
        for ($i=0; $i < count($lista['data']); $i++) {
          $lista['data'][$i]->id_encrip=$this->utils->encode($lista['data'][$i]->id_licencia);
        }
        echo json_encode($lista);
    }

    public function licencias_id(){
        $id = $this->input->post('id');
        $id_user = $this->session->userdata('idU');
        $id_decode = $this->utils->decode($id);
        $lista=$this->RevisionModel->getLicencias_id($id_user,$id_decode);
        echo json_encode($lista);
    }

    public function revision_lic(){
        $id = $this->input->post('id');
        $status = $this->input->post('revisada');
        $id_user = $this->session->userdata('idU');
        $id_decode = $this->utils->decode($id);
        $result=$this->RevisionModel->postRevision($id_decode,$status);
        echo json_encode($result);
    }
}
