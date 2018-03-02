<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Confirmacion_licencia extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('LicenciasGiroModel');

        if (!$this->session->userdata('loged')){
            $this->session->sess_destroy();
            redirect(base_url().'ingresar', 'refresh');
        }
    }

    public function confirmacion_lic(){
        $id_l = $this->utils->decode($this->input->get('id_l'));
        $consulta = $this->LicenciasGiroModel->licencia_nueva($id_l);
        echo json_encode($consulta);
    }

    public function pago_linea(){
        extract($_POST);
        $licencia = $this->LicenciasGiroModel->getLicencia("", $licencia);
        $pws = //api para recuperar contraseña y loguearte a los otros sistemas
        if($licencia->folio_licencia == 0){
            $params = array(
                "tipo_tramite" => '13',
                "scian" => intval($licencia->clave_factibilidad),
                'x'=>'0',
                'y'=>'0',
                'zona' => $licencia->predio_distrito,
                'subzona' => $licencia->predio_sub_distrito,
                'actividad'=> mb_strtoupper($licencia->descripcion_factibilidad),
                'cvecuenta'=>$licencia->cuenta_predial,
                'propietario'=> mb_strtoupper($licencia->st2_nombre_solicitante),
                'primer_ap'=> mb_strtoupper($licencia->st2_primer_apellido_solicitante),
                'segundo_ap'=> mb_strtoupper($licencia->st2_segundo_apellido_solicitante),
                'rfc'=> mb_strtoupper($licencia->st2_rfc_solicitante),
                'curp'=>mb_strtoupper($licencia->st2_curp_solicitante),
                'telefono_prop'=>$licencia->st2_telefono_solicitante,
                'email'=>$licencia->st2_email_solicitante,
                'cvecalle'=>'0',
                'calle'=>mb_strtoupper($licencia->st3_domicilio_establecimiento),
                'num_ext'=>$licencia->st3_num_ext_establecimiento,
                'let_ext'=>mb_strtoupper($licencia->st3_letra_ext_establecimiento),
                'num_int'=>$licencia->st3_num_int_establecimiento,
                'let_int'=>mb_strtoupper($licencia->st3_letra_int_establecimiento),
                'colonia'=>mb_strtoupper($licencia->st3_colonia_establecimiento),
                'cp'=>$licencia->st3_cp_establecimiento,
                'espubic'=>'',
                'sup_autorizada'=>$licencia->st3_area_utilizar_establecimiento,
                'num_cajones'=>$licencia->st3_cajones_estacionamiento_establecimiento,
                'num_empleados'=>$licencia->st3_empleados_establecimiento,
                'aforo'=>'0',
                'inversion'=> $licencia->st3_inversion_establecimiento,
                );
            $data_soap=$this->utils->conec_soap('licTramite',$params);
            $folio_licencia=$data_soap->licencia;
            $this->LicenciasGiroModel->postPdf($licencia->id_usuario, $licencia->id_licencia, $data_soap->licencia);
        }else{
            $folio_licencia=$licencia->folio_licencia;
        }
        $params = array(
            'licencia'=>$folio_licencia,
        );
        $data_soap=$this->utils->conec_soap('licAdeudo',$params);
        $total=$data_soap[(count($data_soap)-1)]->acumulado;
        $data=array(
            "tipo_tramite" => '13',
            "scian" => $licencia->descripcion_factibilidad,
            'x'=>'0',
            'y'=>'0',
            'zona' => $licencia->predio_distrito,
            'subzona' => $licencia->predio_sub_distrito,
            'actividad'=> $licencia->descripcion_factibilidad,
            'cvecuenta'=>$licencia->cuenta_predial,
            'propietario'=> $licencia->st2_nombre_solicitante,
            'primer_ap'=> $licencia->st2_primer_apellido_solicitante,
            'segundo_ap'=> $licencia->st2_segundo_apellido_solicitante,
            'rfc'=> $licencia->st2_rfc_solicitante,
            'curp'=>$licencia->st2_curp_solicitante,
            'telefono_prop'=>$licencia->st2_telefono_solicitante,
            'email'=>$licencia->st2_email_solicitante,
            'cvecalle'=>'0',
            'calle'=>$licencia->st3_domicilio_establecimiento,
            'num_ext'=>$licencia->st3_num_ext_establecimiento,
            'let_ext'=>$licencia->st3_letra_ext_establecimiento,
            'num_int'=>$licencia->st3_num_int_establecimiento,
            'let_int'=>$licencia->st3_letra_int_establecimiento,
            'colonia'=>$licencia->st3_colonia_establecimiento,
            'cp'=>$licencia->st3_cp_establecimiento,
            'espubic'=>'',
            'sup_autorizada'=>$licencia->st3_area_utilizar_establecimiento,
            'num_cajones'=>$licencia->st3_cajones_estacionamiento_establecimiento,
            'num_empleados'=>$licencia->st3_empleados_establecimiento,
            'aforo'=>'0',
            'inversion'=> $licencia->st3_inversion_establecimiento,
            'licencia' => $this->utils->encode($folio_licencia),
            'importe' => $total,
            'origen' => 102,
            'tipo' => 'A',
            'entre' => "",
            'id_usuario' => $this->utils->encode($licencia->id_usuario),
            'usuario' => $this->utils->encode($this->session->userdata('email')),
            'pass' => $this->utils->encode($pws),
        );

        echo json_encode(array('status' => TRUE, "data" => $data));
    }
}
