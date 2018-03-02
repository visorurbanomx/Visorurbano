<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LicenciasGiroModel extends CI_Model {
    public function setLicencia($idU, $nombre_usu, $predial, $catastral, $factibiliad, $descFactibilidad, $claveFactibilidad, $distrito, $subDistrito, $zonificacion, $levelUsuario, $superficie){
        $licencia =  $this->db->select('*')->from('tbl_licencias_giro')->where('id_usuario', $idU)->where('cuenta_predial', $predial)->where('clave_catastral', $catastral)->where('folio_factibilidad', $factibiliad)->get()->row();
        if (!empty($licencia)){
            return array('status'=>false);
        }else{
            $catastro = '';//api catastro
            if (!empty($catastro)){
                $data = array(
                    'id_usuario'=>$idU,
                    'cuenta_predial'=>$predial,
                    'clave_catastral'=>$catastral,
                    'folio_factibilidad'=>$factibiliad,
                    'clave_factibilidad'=>$claveFactibilidad,
                    'descripcion_factibilidad'=>$descFactibilidad,
                    'usuario'=>$nombre_usu,
                    /* Predio */
                    'predio_recaudadora'=> $catastro->data->recaudadora,
                    'predio_tipo_predio'=> $catastro->data->tipoPredio,
                    'predio_subpredio'=> $catastro->data->subpredio,
                    'predio_vigente'=> $catastro->data->vigente,
                    'predio_calle'=> $catastro->data->calle,
                    'predio_colonia'=> $catastro->data->colonia,
                    'predio_numero_ext'=> $catastro->data->numeroExterior,
                    'predio_numero_int'=> $catastro->data->numeroInterior,
                    'predio_municipio'=> $catastro->data->poblacion,
                    'predio_estado'=> $catastro->data->estado,
                    'predio_area_titulo'=> $catastro->data->areaTitulo,
                    'predio_distrito'=> $distrito,
                    'predio_sub_distrito'=> $subDistrito,
                    'predio_zonificacion'=> $zonificacion,
                    'level_usuario'=> $levelUsuario,
                    'st3_area_utilizar_establecimiento'=> floatval($superficie)
                );

                $this->db->trans_start();
                $this->db->insert('tbl_licencias_giro',$data);
                $idLicencia = $this->db->insert_id();
                $anio = date('Y');
                $this->db->query('insert into tbl_rel_licencia_usuario values(0,'.$idLicencia.','.$idU.',"","","",0,"","N",'.$anio.')');
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    return array('status'=>false);
                } else {
                    $this->db->trans_commit();
                    return array('status'=>true, 'id'=>$idLicencia);
                }
            }else{
                return array('status'=>false);
            }

        }
    }

    public function getLicencias($idU, $type){
        if (!$type){
            $licencias =  $this->db->select('*')->from('tbl_licencias_giro')->where('id_usuario', $idU)->where('status !=', 'FL')->get()->result();
        }else{
            $licencias =  $this->db->select('*')->from('tbl_licencias_giro')->where('id_usuario', $idU)->where('status', 'FL')->get()->result();
        }

        return $licencias;
    }

    public function getLicenciasByStatus($status){
        $licencias =  $this->db->select('id_licencia, id_usuario, usuario, usuario_ventanilla, descripcion_factibilidad, st2_nombre_solicitante, st2_primer_apellido_solicitante, st2_segundo_apellido_solicitante, clave_catastral, folio_licencia')->from('tbl_licencias_giro')->where('status', $status)->get()->result();
        return $licencias;
    }

    public function getLicenciasVentanilla(){
        $licencias =  $this->db->select('id_licencia, id_usuario, usuario, usuario_ventanilla, descripcion_factibilidad, st2_nombre_solicitante, st2_primer_apellido_solicitante, st2_segundo_apellido_solicitante, clave_catastral, folio_licencia, status')->from('tbl_licencias_giro')->where('level_usuario', 2)->where('status', 'N')->or_where('status', 'FP')->get()->result();
        return $licencias;
    }

    public function getFirma($idU,$id_lic){
       $firma = $this->db->query('Select * from tbl_rel_licencia_usuario where id_licencia="'.$id_lic.'" and id_usuario='.$idU);
       if($firma->num_rows() > 0){
         $firma = $firma->result()[0];
       }else{
         $firma = "";
       }
       return $firma;
   }

    public function getLicencia($idU, $idLicencia){
        if($idU != ""){
            $licencia =  $this->db->select('*')->from('tbl_licencias_giro')->where('id_usuario', $idU)->where('id_licencia', $idLicencia)->get()->row();
        }else{
            $licencia = $this->db->select('*')->from('tbl_licencias_giro')->where('id_licencia', $idLicencia)->get()->row();
        }
        return $licencia;
    }
    public function getLicencia_fl($idU, $idLicencia){
        $licencia =  $this->db->select('*')->from('tbl_licencias_giro')->where('id_usuario', $idU)->where('id_licencia', $idLicencia)->where('status', 'FL')->get()->row();
        return $licencia;
    }

    public function getLicenciaFolio($folio){
        $licencia =  $this->db->select('*')->from('tbl_licencias_giro')->where('folio_licencia', $folio)->where('status', 'FL')->get()->row();
        return $licencia;
    }

    public function updateLicencia($idTramite, $params, $firma){
        $this->db->query('update tbl_rel_licencia_usuario set firma_e= "'.$firma.'" where id_licencia='.$idTramite);
        $this->db->trans_start();
        foreach ($params as $clave=>$valor){
            if(strpos($clave,'rfc') == '' && strpos($clave,'curp') == '' && $clave != 'status' && strpos($clave,'email') == ''){
                $params[$clave] = ucfirst(strtolower($valor));
            }else if(strpos($clave,'email') != ""){
                $params[$clave] = $valor;
            }else{
                $params[$clave] = strtoupper($valor);
            }
   		}
        if(isset($params['status']) && isset($params['step'])){
            if($params['status'] == 'FP' && $params['step'] == '4'){
                $consulta = $this->db->query('SELECT * from tbl_licencias_giro where id_licencia='.$idTramite);
                if($consulta->num_rows() > 0){
                    $res = $consulta->result()[0];
                    $result = ""; //api catastro
                    if ($result->status == 200){
                        $nombre_prop = $result->data->propietario->nombre;
                        $apellido_paterno_prop= $result->data->propietario->ape_paterno;
                        $apellido_materno_prop = $result->data->propietario->ape_materno;
                        $rfc_prop = $result->data->propietario->rfc;
                        $calle_prop = $result->data->propietario->calle;
                        $colonia_prop = $result->data->propietario->colonia;
                        $curp_prop = $result->data->propietario->curp;
                        $n_exterior_prop = $result->data->propietario->n_exterior;
                        $n_interior_prop = $result->data->propietario->n_interior;
                        $ciudad_prop = $result->data->propietario->ciudad;
                        $estado_prop = $result->data->propietario->estado;
                        $cp_prop = $result->data->propietario->cp;
                        $telefono_prop = $result->data->propietario->telefono;
                    }else{
                        $nombre_prop = "";
                        $apellido_paterno_prop = "";
                        $apellido_materno_prop = "";
                        $rfc_prop = "";
                        $calle_prop = "";
                        $colonia_prop = "";
                        $curp_prop = "";
                        $n_exterior_prop = "";
                        $n_interior_prop = "";
                        $ciudad_prop = "";
                        $estado_prop = "";
                        $cp_prop = "";
                        $telefono_prop = "";
                    }
                    $params['prioritario'] = 0;
                    $observaciones = array();
                    if($res->st3_area_utilizar_establecimiento > $res->st3_sup_construida_establecimiento){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Área a urilizar mayor a superficie construida');
                    }
                    if($res->st3_dictamen_tecnico_movilidad != ""){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se adjuntó dictamen técnico de movilidad');
                    }
                    if(!empty($nombre_prop) && $nombre_prop != mb_strtoupper($res->st2_nombre_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió nombre del solicitante');
                    }
                    if(!empty($apellido_paterno_prop) && $apellido_paterno_prop != mb_strtoupper($res->st2_primer_apellido_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió apellido paterno del solicitante');
                    }
                    if(!empty($apellido_materno_prop) && $apellido_materno_prop != mb_strtoupper($res->st2_segundo_apellido_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió apellido materno del solicitante');
                    }
                    if(!empty($rfc_prop) && $rfc_prop != mb_strtoupper($res->st2_rfc_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió rfc del solicitante');
                    }
                    if(!empty($calle_prop) && $calle_prop != mb_strtoupper($res->st2_domicilio_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió domicilio del solicitante');
                    }
                    if(!empty($colonia_prop) && $colonia_prop != mb_strtoupper($res->st2_colonia_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió colonia del solicitante');
                    }
                    if(!empty($curp_prop) && $curp_prop != mb_strtoupper($res->st2_curp_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió curp del solicitante');
                    }
                    if(!empty($n_exterior_prop) && $n_exterior_prop != mb_strtoupper($res->st2_num_ext_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió número exterior del solicitante');
                    }
                    if(!empty($n_interior_prop) && $n_interior_prop != mb_strtoupper($res->st2_num_int_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió número interior del solicitante');
                    }
                    if(!empty($ciudad_prop) && $ciudad_prop != mb_strtoupper($res->st2_ciudad_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió ciudad del solicitante');
                    }
                    if(!empty($cp_prop) && $cp_prop != mb_strtoupper($res->st2_cp_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió cp del solicitante');
                    }
                    if(!empty($telefono_prop) && $telefono_prop != mb_strtoupper($res->st2_telefono_solicitante)){
                        $params['prioritario'] = 1;
                        array_push($observaciones,'Se cambió teléfono del solicitante');
                    }
                    $params['observaciones_prioritarios']=json_encode($observaciones);
                }
            }
        }
        $this->db->where('id_licencia',$idTramite)->update('tbl_licencias_giro', $params);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return array('status'=>false);
        } else {
            $this->db->trans_commit();
            return array('status'=>true);
        }
    }

    public function isMercado($clave){
        $mercado =  $this->db->select('*')->from('tbl_predios_mercado')->where('clave_catastral', $clave)->get()->row();
        return $mercado;
    }

    public function postPdf($idU, $idLicencia, $idFolioSoap){
        $query=$this->db->query('Update tbl_licencias_giro set folio_licencia='.$idFolioSoap.' where id_licencia='.$idLicencia.' and id_usuario='.$idU);
        $resultado=array("status"=>true);
        return $resultado;
    }

    public function licencia_nueva($folio){
        $queryC=$this->db->query('select * from tbl_licencias_giro where folio_licencia='.$folio);

        if($queryC->num_rows() > 0){
            if($queryC->result()[0]->status == 'N' || $queryC->result()[0]->status == 'FP'){
                $query=$this->db->query('Update tbl_licencias_giro set status="FL", metodo_pago="Tarjeta bancaria" where folio_licencia='.$folio);
                $res['folio']=$this->utils->encode($folio);
                $res['usu']=$this->utils->encode($queryC->result()[0]->id_usuario);
                $res['lic']=$this->utils->encode($queryC->result()[0]->id_licencia);
                $resultado=array("status"=>true, "data"=> $res);
            }else if($queryC->result()[0]->status == 'FL'){
                $resultado=array("status"=>false, 'tipo'=>'FL');
            }else{
                $resultado=array("status"=>false, 'tipo'=>'P');
            }
        }else{
            $resultado=array("status"=>false, 'tipo'=>'P');
        }
        return $resultado;
    }

    public function updatePropietario($result,$clave_catastral){
        $nombre = $result->data->propietario->nombre;
        $ape_paterno=$result->data->propietario->ape_paterno;
        $ape_materno=$result->data->propietario->ape_materno;
        $rfc=$result->data->propietario->rfc;
        $calle=$result->data->propietario->calle;
        $colonia=$result->data->propietario->colonia;
        $curp=$result->data->propietario->curp;
        $n_exterior=$result->data->propietario->n_exterior;
        $n_interior=$result->data->propietario->n_interior;
        $ciudad=$result->data->propietario->ciudad;
        $cp=$result->data->propietario->cp;
        $tel=$result->data->propietario->telefono;
        if(empty($n_exterior)){
            $n_exterior = 0;
        }
        if(!is_int($n_exterior)){
            $n_exterior = 0;
        }
        if(empty($n_interior)){
            $n_interior = 0;
        }
        if(!is_int($n_interior)){
            $n_interior = 0;
        }
        if(empty($cp)){
            $cp = 0;
        }
        $consulta = $this->db->query('SELECT * from  tbl_licencias_giro where clave_catastral="'.$clave_catastral.'"');
        if($consulta->num_rows() > 0){
            $resultado = $consulta->result()[0];
            $c_n = $resultado->st2_nombre_solicitante;
            $c_ap = $resultado->st2_primer_apellido_solicitante;
            $c_am = $resultado->st2_segundo_apellido_solicitante;
            $c_c = $resultado->st2_curp_solicitante;
            $c_r = $resultado->st2_rfc_solicitante;
            $c_do = $resultado->st2_domicilio_solicitante;
            $c_nex = $resultado->st2_num_ext_solicitante;
            $c_nin = $resultado->st2_num_int_solicitante;
            $c_col = $resultado->st2_colonia_solicitante;
            $c_cd = $resultado->st2_ciudad_solicitante;
            $c_cp = $resultado->st2_cp_solicitante;
            $c_tel = $resultado->st2_telefono_solicitante;
            if($c_n == "" && $c_ap == "" && $c_am == "" && $c_c == "" && $c_r == "" && $c_do == "" && $c_nex == "0" && $c_nin == "0" && $c_col == "" && $c_cd == "" && $c_cp == "0" && $c_tel == ""){
                $query = 'Update tbl_licencias_giro set st2_nombre_solicitante = "'.$nombre.'",st2_primer_apellido_solicitante = "'.$ape_paterno;
                $query .= '",st2_segundo_apellido_solicitante = "'.$ape_materno.'",st2_curp_solicitante = "'.$curp.'",st2_rfc_solicitante = "'.$rfc.'",st2_domicilio_solicitante = "'.$calle.'",st2_num_ext_solicitante = "'.$n_exterior.'",st2_num_int_solicitante = "'.$n_interior.'",st2_colonia_solicitante = "'.$colonia.'",st2_ciudad_solicitante="'.$ciudad.'",st2_cp_solicitante='.$cp.',st2_telefono_solicitante = "'.$tel.'" where clave_catastral="'.$clave_catastral.'"';
                $query2 = $this->db->query($query);
            }
        }
    }

    public function consultClave($idLic){
         $queryC=$this->db->query('select cuenta_predial from tbl_licencias_giro where id_licencia='.$idLic);
         if($queryC->num_rows() > 0){
             $resultado=$queryC->result()[0]->cuenta_predial;
         }else{
             $resultado="";
         }
         return $resultado;
     }

     public function PropietarioLic($data,$idLic){
            $queryC=$this->db->query('select * from tbl_licencias_giro where id_licencia='.$idLic);
            if($queryC->num_rows() > 0){
                $myArray= array();
                $resultado=$queryC->result()[0];
                    $conteo=0;
                    $diferencia=0;
                    for ($i=0; $i < count($data); $i++) {
                        $nombre_a = $data[$i]->propietario;
                        $calle_a = $data[$i]->calle;
                        $num_ext_a = $data[$i]->num_ext;
                        $letra_ext_a = $data[$i]->let_ext;
                        $num_int_a = $data[$i]->num_int;
                        $letra_int_a = $data[$i]->let_int;
                        $nombre_b = $resultado->st2_primer_apellido_solicitante.' '.$resultado->st2_segundo_apellido_solicitante.' '.$resultado->st2_nombre_solicitante;
                        $calle_b = (empty($resultado->st3_domicilio_establecimiento)? strtoupper($resultado->predio_calle) : strtoupper($resultado->st3_domicilio_establecimiento));
                        $num_ext_b = (empty($resultado->st3_num_ext_establecimiento)? strtoupper($resultado->predio_numero_ext):strtoupper($resultado->st3_num_ext_establecimiento));
                        $letra_ext_b = (empty($resultado->st3_letra_ext_establecimiento)? "":strtoupper($resultado->st3_letra_ext_establecimiento));
                        $num_int_b = (empty($resultado->st3_num_int_establecimiento)? strtoupper($resultado->predio_numero_int):strtoupper($resultado->st3_num_int_establecimiento));
                        $letra_int_b = (empty($resultado->st3_letra_int_establecimiento)? "":strtoupper($resultado->st3_letra_int_establecimiento));
                        if($nombre_a != strtoupper($nombre_b) && $calle_a == $calle_b && $num_ext_a == $num_ext_b && $letra_ext_a == $letra_ext_b && $num_int_a == $num_int_b && $letra_int_a == $letra_int_b){
                            array_push($myArray,(object) array('id' => $data[$i]->licencia, 'actividad' => $data[$i]->actividad, "data"=>$data[$i]));
                            $conteo++;
                        }
                    }
                    if($conteo > 0){
                        return array('status'=>true, 'licencias'=> $myArray);
                    }else{
                        return array('status'=>false, 'licencias'=> $myArray);
                    }
            }else{
                $resultado="";
            }
        }

    public function getNegocio($idLicencia){
        $licencia = $this->db->select('predio_numero_ext')->from('tbl_licencias_giro')->where('id_licencia', $idLicencia)->get()->row();
        return $licencia;
    }

    public function getStep($idLicencia){
        $licencia = $this->db->select('*')->from('tbl_licencias_giro')->where('id_licencia', $idLicencia)->get()->row();
        return $licencia;
    }

    public function emptyField($licencia, $campo){
        $licencia = $this->db->query('Update tbl_licencias_giro set '.$campo.'=""  where id_licencia='.$licencia);
        return true;
    }

    public function emptyTabla($licencia){
        $licencia = $this->db->query('Update tbl_licencias_giro set
        st1_tipo_solicitante = "",
        st1_tipo_representante = "",
        st1_tipo_carta_poder = "",
        st1_carta_poder = "",
        st1_identificacion_otorgante = "",
        st1_identificacion_testigo1 = "",
        st1_identificacion_testigo2 = "",
        st1_contrato_arrendamiento = "",
        st1_faculta = "",
        st1_anuencia = "",
        st1_carta_anuencia = "",
        st2_nombre_solicitante = "",
        st2_priper_apellido_representante = "",
        st2_nombre_representante = "",
        st2_priper_apellido_representante = "",
        st2_segundo_apellido_representante = "",
        st2_curp_representante = "",
        st2_rfc_representante = "",
        st2_email_representante = "",
        st2_domicilio_representante = "",
        st2_num_ext_representante = "0",
        st2_num_int_representante = "0",
        st2_colonia_representante = "",
        st2_ciudad_representante = "",
        st2_cp_representante = "0",
        st2_telefono_representante = "",
        st2_identificacion_representante = "",
        st2_nombre_solicitante = "",
        st2_primer_apellido_solicitante = "",
        st2_segundo_apellido_solicitante = "",
        st2_curp_solicitante = "",
        st2_rfc_solicitante = "",
        st2_email_solicitante = "",
        st2_domicilio_solicitante = "",
        st2_num_ext_solicitante = "",
        st2_num_int_solicitante = "",
        st2_colonia_solicitante = "",
        st2_ciudad_solicitante = "",
        st2_cp_solicitante = "0",
        st2_telefono_solicitante = "",
        st2_identidficacion_solicitante = "",
        st3_nombre_establecimiento = "",
        st3_domicilio_establecimiento = "",
        st3_num_ext_establecimiento = "0",
        st3_num_int_establecimiento = "0",
        st3_letra_ext_establecimiento = "",
        st3_letra_int_establecimiento = "",
        st3_colonia_establecimiento = "",
        st3_ciudad_establecimiento = "",
        st3_estado_establecimiento = "",
        st3_cp_establecimiento = "0",
        st3_especificaciones_establecimiento = "",
        st3_edificio_plaza_establecimiento = "",
        st3_num_local_establecimiento = "0",
        st3_sup_construida_establecimiento = "0",
        st3_area_utilizar_establecimiento = "0",
        st3_inversion_establecimiento = "0",
        st3_empleados_establecimiento = "0",
        st3_cajones_estacionamiento_establecimiento = "0",
        st3_dictamen_tecnico_movilidad = "",
        st3_img1_establecimiento = "",
        st3_img2_establecimiento = "",
        st3_img3_establecimiento = "",
        st3_dictamen_lineamiento = "",
        st3_asignacion_numero = "",
        st3_es_numero_interior = "N",
        st4_declaratoria = "0",
        revisada = "0",
        metodo_pago = "", step="0" where id_licencia='.$licencia);
        return true;
    }

    public function validar($usuario, $tramite, $usuario_ventanilla){
        $query=$this->db->query('update tbl_licencias_giro set usuario_ventanilla="'.$usuario_ventanilla.'" where id_licencia='.$tramite.' and id_usuario='.$usuario);
        return true;
    }
}
