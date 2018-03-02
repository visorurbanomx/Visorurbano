<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AuthModel extends CI_Model {
    public function setLogin($params){
        $this->db->trans_start();
        $checkExist = $this->db->select('email')->from('tbl_usuario')->where('id',$params['email'])->get()->row();
        if (empty($checkExist)){
            $this->db->insert('tbl_usuario', array('nombre'=>$params['nombre'], 'primer_apellido'=>$params['primer_apellido'], 'segundo_apellido'=>$params['segundo_apellido'], 'email'=>$params['email'], 'celular'=>$params['celular'], 'alcance'=>$params['level']));
        }
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function logout($email){
        $this->db->trans_start();
        $this->db->where('email',$email)->delete('tbl_usuario');
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}