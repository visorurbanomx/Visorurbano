<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProcesosModel extends CI_Model {

    public function proceso_sincronizar(){
        $this->load->library('Utils');
        try{
            $licencias = $this->db->query('select * from tbl_licencias_giro where status != "FL" and status != "C" and status != "S"');
            if (!$licencias) {
                throw new Exception('select falló (ProcesosModel -- proceso_sincronizar)', 400);
            }
            $respuestas = $licencias->result();
            $rows = $licencias->num_rows();
            if($rows > 0){
                for ($i=0; $i < $rows; $i++) {
                    if($respuestas[$i]->folio_licencia > 0){
                        $params = array(
                            'licencia'=>$respuestas[$i]->folio_licencia,
                        );
                        $data_soap=$this->utils->conec_soap('licAdeudo',$params);
                        if(empty($data_soap)){
                            try{
                                $pago = $this->db->query('Update tbl_licencias_giro set status = "FL" where folio_licencia ="'.$respuestas[$i]->folio_licencia.'"');
                                if (!$pago) {
                                    throw new Exception('Update falló (ProcesosModel -- proceso_sincronizar) licencia #'.$respuestas[$i]->folio_licencia, 400);
                                }
                            }catch(Exception $e){
                                $this->log($e->getMessage());
                            }
                        }
                    }
                }
            }
        }catch(Exception $e){
            $this->log($e->getMessage());
        }
    }

    public function log($message){
        $fecha = date("d/m/Y H:i");
        $fp = fopen ('/var/www/html/Logs/logs.txt', 'r+');
        $cadena = stream_get_contents($fp);
        $cadena = $fecha." --- ".$message. "\n";
        $fw = fwrite($fp, $cadena);
        fclose($fp);
    }

}
