<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class EmailModel extends CI_Model {

    public function sendEmail($nombre,$de,$mensaje,$asunto, $telefono){

        $to = '';//$correo;
        $subject = 'Visorurbano';
        $message = "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='utf-8'>
                <style type='text/css'>
                    body {
                        font-family: Helvetica, sans-serif;
                    }
                </style>
            </head>
                <body style=\"font-family: Lato, Helvetica, sans-serif;\">
                    <table width='800px'>
                        <tr>
                            <td width='40%'>
                                <img src='https://visorurbano.com/assets/img/logo.png' width='40%' alt=''>
                            </td>
                            <td width='20%'>
                                &nbsp;
                            </td>
                            <td width='40%' style='text-align:right;'>
                                <img src='https://visorurbano.com/assets/img/escudo.jpg'  width='40%' alt='' style='float:right;'>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3'>
                                <b>Asunto:</b> $asunto
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3'>
                                <b>Nombre:</b> $nombre
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3'>
                                <b>Email:</b> $de
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3'>
                                <b>Teléfono:</b> $telefono
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3'>
                                <b>Mensaje:</b> $mensaje
                            </td>
                        </tr>
                    </table>
                </body>
            </html>";

         $config = Array(
             'protocol' => 'smtp',
             'smtp_host' => 'smtp.gmail.com',
             'smtp_port' => 587, //465,
             'smtp_user' => '',//correo servido gmail
             'smtp_pass' => '', //password de correo gmail
             'smtp_crypto' => 'tls',
             'smtp_timeout' => '20',
             'mailtype'  => 'html',
             'charset'   => 'utf-8'
         );

         $config['newline'] = "\r\n";
         $config['crlf'] = "\r\n";
         $this->load->library('email', $config);
         $this->email->from('visorurbanomx@gmail.com', 'Visorurbano | Plataforma digital de gestión del territorio');
         $this->email->to($to);
         $this->email->subject($subject);
         $this->email->message($message);
         if ( $this->email->send()) {
              return array('status' => TRUE);
         }
         else{
              return array('status' => FALSE, 'error' => 'La cuenta de email no es valida');
         }
    }

}
