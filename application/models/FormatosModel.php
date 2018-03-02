<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class FormatosModel extends CI_Model {
    private $UNIDADES = array(
          '',
          'UN ',
          'DOS ',
          'TRES ',
          'CUATRO ',
          'CINCO ',
          'SEIS ',
          'SIETE ',
          'OCHO ',
          'NUEVE ',
          'DIEZ ',
          'ONCE ',
          'DOCE ',
          'TRECE ',
          'CATORCE ',
          'QUINCE ',
          'DIECISEIS ',
          'DIECISIETE ',
          'DIECIOCHO ',
          'DIECINUEVE ',
          'VEINTE '
    );
    private $DECENAS = array(
          'VEINTI',
          'TREINTA ',
          'CUARENTA ',
          'CINCUENTA ',
          'SESENTA ',
          'SETENTA ',
          'OCHENTA ',
          'NOVENTA ',
          'CIEN '
    );
    private $CENTENAS = array(
          'CIENTO ',
          'DOSCIENTOS ',
          'TRESCIENTOS ',
          'CUATROCIENTOS ',
          'QUINIENTOS ',
          'SEISCIENTOS ',
          'SETECIENTOS ',
          'OCHOCIENTOS ',
          'NOVECIENTOS '
    );
    private $MONEDAS = array(
      array('country' => 'México', 'currency' => 'MXN', 'singular' => 'PESO MEXICANO', 'plural' => 'PESOS MEXICANOS', 'symbol', '$'),
    );
      private $separator = ',';
      private $decimal_mark = '.';
      private $glue = ' CON ';
      /**
       * Evalua si el número contiene separadores o decimales
       * formatea y ejecuta la función conversora
       * @param $number número a convertir
       * @param $miMoneda clave de la moneda
       * @return string completo
       */
      public function to_word($number, $miMoneda = null) {
          if (strpos($number, $this->decimal_mark) == "") {
            $convertedNumber = array(
              $this->convertNumber($number, $miMoneda, 'entero')
            );
          } else {
            $number = explode($this->decimal_mark, str_replace($this->separator, '', trim($number)));
            $convertedNumber = array(
              $this->convertNumber($number[0], $miMoneda, 'entero'),
              //$this->convertNumber($number[1], $miMoneda, 'decimal'),
            );
          }
          return implode($this->glue, array_filter($convertedNumber));
      }
      /**
       * Convierte número a letras
       * @param $number
       * @param $miMoneda
       * @param $type tipo de dígito (entero/decimal)
       * @return $converted string convertido
       */
      private function convertNumber($number, $miMoneda = null, $type) {

          $converted = '';
          if ($miMoneda !== null) {
              try {

                  $moneda = array_filter($this->MONEDAS, function($m) use ($miMoneda) {
                      return ($m['currency'] == $miMoneda);
                  });
                  $moneda = array_values($moneda);
                  if (count($moneda) <= 0) {
                      throw new Exception("Tipo de moneda inválido");
                      return;
                  }
                  ($number < 2 ? $moneda = $moneda[0]['singular'] : $moneda = $moneda[0]['plural']);
              } catch (Exception $e) {
                  echo $e->getMessage();
                  return;
              }
          }else{
              $moneda = '';
          }
          if (($number < 0) || ($number > 999999999)) {
              return false;
          }
          $numberStr = (string) $number;
          $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
          $millones = substr($numberStrFill, 0, 3);
          $miles = substr($numberStrFill, 3, 3);
          $cientos = substr($numberStrFill, 6);
          if (intval($millones) > 0) {
              if ($millones == '001') {
                  $converted .= 'UN MILLON ';
              } else if (intval($millones) > 0) {
                  $converted .= sprintf('%sMILLONES ', $this->convertGroup($millones));
              }
          }

          if (intval($miles) > 0) {
              if ($miles == '001') {
                  $converted .= 'MIL ';
              } else if (intval($miles) > 0) {
                  $converted .= sprintf('%sMIL ', $this->convertGroup($miles));
              }
          }
          if (intval($cientos) > 0) {
              if ($cientos == '001') {
                  $converted .= 'UN ';
              } else if (intval($cientos) > 0) {
                  $converted .= sprintf('%s ', $this->convertGroup($cientos));
              }
          }
          $converted .= $moneda;
          return $converted;
      }
      /**
       * Define el tipo de representación decimal (centenas/millares/millones)
       * @param $n
       * @return $output
       */
      private function convertGroup($n) {
          $output = '';
          if ($n == '100') {
              $output = "CIEN ";
          } else if ($n[0] !== '0') {
              $output = $this->CENTENAS[$n[0] - 1];
          }
          $k = intval(substr($n,1));
          if ($k <= 20) {
              $output .= $this->UNIDADES[$k];
          } else {
              if(($k > 30) && ($n[2] !== '0')) {
                  $output .= sprintf('%sY %s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
              } else {
                  $output .= sprintf('%s%s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
              }
          }
          return $output;
      }

      public function denominacion_moneda($val){
          $centavos = strpos($val,'CON');
          if($centavos != ""){
              $tipo_moneda=explode('CON',$val);
              return $tipo_moneda[0]." PESOS CON ".$tipo_moneda[1]." CENTAVOS";
          }
          return $val. " PESOS ";
      }

      public function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
          // Convirtiendo en timestamp las fechas
          $fechainicioO=$fechainicio;
          $fechafinO=$fechafin;
          $fechainicio = strtotime($fechainicio);
          $fechafin = strtotime($fechafin);
          if($fechainicio <= $fechafin){
              $fechafinO= explode('/',$fechafinO);
              $fechafinO[1] = $fechafinO[1]+1;
              if($fechafinO[1] < 10){
                  $fechafinO[1] = "0".$fechafinO[1];
              }
              $fechafin=strtotime($fechafinO[0].'/'.$fechafinO[1].'/20');
          }
          // Incremento en 1 dia
          $diainc = 24*60*60;

          // Arreglo de dias habiles, inicianlizacion
          $diashabiles = array();

          // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
          for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                  // Si el dia indicado, no es sabado o domingo es habil
                  if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                          // Si no es un dia feriado entonces es habil
                          if (!in_array(date('Y/m/d', $midia), $diasferiados)) {
                                  array_push($diashabiles, date('Y/m/d', $midia));
                          }
                  }
          }
          return $diashabiles;
      }

    function _data_last_month_day() {
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month+1, 0, $year));

        return date('Y/m/d', mktime(0,0,0, $month, $day, $year));
    }

    public function convertir_folio($folio){
       $count = strlen($folio);
       if($count < 5){
         $faltantes = 5-$count;
         for($i=0;$i < $faltantes; $i++){
           $folio="0".$folio;
         }
       }
       return $folio;
    }

    public function fechasFormat($fecha){
        $meses = array("ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC");
        $convert=explode('/',$fecha);
        $fecha = $convert[2].'/'.$meses[($convert[1]-1)].'/'.$convert[0];
        return $fecha;
    }

    public function fechasFormat_carta($fecha){
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $convert=explode('/',$fecha);
        $fecha = $convert[2].' de '.$meses[($convert[1]-1)].' del año '.$convert[0];
        return $fecha;
    }

    public function cadena($licencia,$movimiento,$folio_licencia,$tipo){
        $fechaTitle = date("d/m/Y");
        $direct = '';//direccion para realizar y guardar la cadena
        $cadena = $tipo.'+|+'.$movimiento.'+|+'.$folio_licencia.'+|+'.$licencia->descripcion_factibilidad.'+|+'.$licencia->st2_nombre_solicitante.' '.$licencia->st2_primer_apellido_solicitante.' '.$licencia->st2_segundo_apellido_solicitante.'+|+'.$licencia->st2_curp_solicitante.'+|+'.$licencia->st2_rfc_solicitante.'+|+'.$fechaTitle;
        if(!is_dir($direct.'/'.$folio_licencia)){
            mkdir($direct.'/'.$folio_licencia, 0777);
        }
        chmod($direct.'/'.$folio_licencia, 0777);
        $fp = fopen ($direct.'/'.$folio_licencia.'/utf.txt', 'w+');
        $fw = fwrite($fp, $cadena);
        fclose($fp);
        return $cadena;
    }

    public function validarFirma($folio_licencia,$anio){
        $licencia = $this->db->query('SELECT * FROM tbl_rel_licencia_usuario WHERE folio_licencia ='.$folio_licencia.' and anio='.$anio);
        $resultado = $licencia->result();
        if($licencia->num_rows() > 0){
            return false;
        }else{
            return true;
        }
    }

    public function traerFirma($folio_licencia,$anio){
        $licencia = $this->db->query('SELECT * FROM tbl_rel_licencia_usuario WHERE folio_licencia ='.$folio_licencia.' and anio='.$anio);
        if($licencia->num_rows() > 0){
            $resultado = $licencia->result()[0];
            return array('firma'=>$resultado->cadena_firmada,'id'=>$resultado->id_firma);
        }else{
            return true;
        }
    }

    public function insertarFirma($id_licencia,$id_usuario,$folio_licencia,$cadena,$id_firma,$tipo,$anio){
        $this->db->query('INSERT INTO tbl_rel_licencia_usuario VALUES (?,?,?,?,?,?,?,?,?,?)',array(0,$id_licencia,$id_usuario,$folio_licencia,'',$cadena,$id_firma['id'],$id_firma['firma'],$tipo,$anio));
        return true;
    }

    public function firmado($folio_licencia){
        $response = new stdClass();
        $response->code = 200;
        $direct = ''; //direccion para realizar y guardar la firma
        $pass = fopen(realpath($direct.'/pass.txt'), 'r');
        $pass = stream_get_contents($pass);
        $cadena = fopen(realpath($direct.'/'.$folio_licencia.'/utf.txt'), 'r');
        $cadena = stream_get_contents($cadena);
        $sello = fopen($direct.'/'.$folio_licencia.'/sello.txt', 'w+');
        $response->status =  openssl_pkcs7_sign(realpath($direct.'/'.$folio_licencia.'/utf.txt'),realpath($direct.'/'.$folio_licencia.'/sello.txt'),'file://'.realpath($direct.'/llave.cer.pem'), array('file://'.realpath($direct.'/llave.key.pem'), $pass), array(), PKCS7_NOATTR);
		if ($response->status) {
		  		$signature = fopen(realpath($direct.'/'.$folio_licencia.'/sello.txt'), 'r');
		  		$response->signature = stream_get_contents($signature);
		  		$response->signature = implode(PHP_EOL, array_slice(preg_split('/\n/', $response->signature), 5));
		  		fclose($signature);
	  	} else {
    		$response->message = 'Problem with certificates';
  		}

        $cert = $response->signature;
        $this->eliminar_archivos($folio_licencia);
        if (!$cert) {
            $response->message = 'Missing Parameters';
            $response->code = 400;
        } else {
            $this->load->library('Soap_Client');
            $this->soap_client->execute('firmaObjeto', ['objFirmado'=> $cert]);
            $response_soap = $this->soap_client->response;
            if (isset($response_soap->error)) {
                $response->message = $response_soap->error;
                $response->code = 500;
                echo "<center><h3>Lo sentimos estamos teniendo problemas técnicos temporalmente; estamos trabajando para resolver esta situación los más pronto posible, por favor intenta de nuevo mas tarde  :(</center></h3>";
                die();
            } else {
                $response->data = isset($response_soap->return) ? $response_soap->return : $response_soap;
                $id_firma=explode('|',$response->data);
                $id_firma=$id_firma[0];
                $data['id']=$id_firma;
                $data['firma']=$cert;
                return $data;
            }
        }
    }

    function eliminar_archivos($folio_licencia){
        $direct = '/var/www/html/assets/llaves_licencias';
        $dir = $direct.'/'.$folio_licencia;
        $handle = opendir($dir);
        $ficherosEliminados = 0;
        while ($file = readdir($handle)) {
            if (is_file($dir.'/'.$file)) {
                if (unlink($dir.'/'.$file) ){
                    $ficherosEliminados++;
                }
            }
        }
        rmdir($direct.'/'.$folio_licencia);
    }
}
