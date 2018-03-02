<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utils {
    var $skey = "50f14b34Sru81o";
    var $ikey = "m4gd4l3n4Rub10r0drigu35";

    public function getJson($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        return ($result);
    }
    public function conec_soap($metodo,$params){
        ini_set("soap.wsdl_cache_enabled", 0);
        $wsdl = ''; // wsdl soap
        $options = array(
                'login'=>'',//user
                'password'=>'' //pass
        	);
        try {
        	$soap = new SoapClient($wsdl, $options);
        	$data = $soap->$metodo($params);
        }
        catch(Exception $e) {
        	die($e->getMessage());
        }
        return $data;
    }
    public  function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public  function encode($value){
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $this->skey );
        $iv = substr( hash( 'sha256', $this->ikey ), 0, 16 );
        $output = base64_encode( openssl_encrypt( $value, $encrypt_method, $key, 0, $iv ) );
        return $output;
    }

    public function decode($value){
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $this->skey );
        $iv = substr( hash( 'sha256', $this->ikey ), 0, 16 );
        $output = openssl_decrypt( base64_decode( $value ), $encrypt_method, $key, 0, $iv );
        return $output;
    }
    public function compareDecript($original, $compare){
        if ($original == $this->decode($compare)){
            return true;
        }else{
            return false;
        }
    }
}
