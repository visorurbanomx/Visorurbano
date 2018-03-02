<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RevisionModel extends CI_Model {
    public function getLicencias($Tipo){
        switch ($Tipo) {
          case 'T':
              $query=$this->db->query('select * from tbl_licencias_giro');
            break;
          case 'R':
              $query=$this->db->query('select * from tbl_licencias_giro where status="FL" and revisada = 1');
            break;
          case 'P':
              $query=$this->db->query('select * from tbl_licencias_giro where status="FL" and revisada = 1');
            break;
          default:
              $query->num_rows('');
        }
        if($query->num_rows()>0){
            $resultado=array("status"=>true,"data"=>$query->result());
        }else{
            $resultado=array("status"=>false,"data"=>"");
        }
        return $resultado;
    }

    public function getLicencias_id($idUser,$id){
        $query=$this->db->query('select * from tbl_licencias_giro where id_licencia="'.$id.'"');
        if($query->num_rows()>0){
            $resultado=array("status"=>true,"data"=>$query->result(),'usu'=>$idUser);
        }else{
            $resultado=array("status"=>false,"data"=>"");
        }
        return $resultado;
    }

    public function postRevision($id_decode,$status){
        switch($status){
            case 'A':
                $query=$this->db->query('Update tbl_licencias_giro set status="FL", revisada=1 where id_licencia="'.$id_decode.'"');
                $resultado=array("status"=>true);
            break;
            case 'S':
                $query=$this->db->query('Update tbl_licencias_giro set status="S" where id_licencia="'.$id_decode.'"');
                $resultado=array("status"=>true);
            break;
            default:
                $resultado=array("status"=>false);
        }
        return $resultado;
    }
}
