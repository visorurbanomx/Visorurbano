<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mensajes extends CI_Model {
    public function getMensajes($idUser, $limit = 5, $noleidos){
        if (!$noleidos){
            $mensajes =  $this->db->select('*')->from('tbl_mensajes')->where('para', $idUser)->order_by('id_mensaje','desc')->limit($limit)->get()->result();
        }else{
            $mensajes =  $this->db->select('*')->from('tbl_mensajes')->where('para', $idUser)->where('leido', 0)->order_by('id_mensaje','desc')->limit($limit)->get()->result();
        }
        return $mensajes;
    }

    public function getMensaje($idUser, $idMesnaje){
        $mensaje =  $this->db->select('*')->from('tbl_mensajes')->where('id_mensaje', $idMesnaje)->where('para', $idUser)->get()->row();
        return $mensaje;
    }

    public function setLeido($idMensaje){
        $this->db->trans_start();
        $this->db->where('id_mensaje',$idMensaje)->update('tbl_mensajes',array('leido'=> 1));
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function setMensaje($de, $para, $msg){
        $data = array('de'=>$de, 'para'=>$para, 'mensaje'=>$msg);
        $this->db->trans_start();
        $this->db->insert('tbl_mensajes',$data);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}