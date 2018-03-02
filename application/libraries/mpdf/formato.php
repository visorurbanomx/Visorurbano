<?php


 foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
die;

$html = '
<style>
table { border-collapse: collapse; margin-top: 0; text-align: left; font-family: Arial; font-size: 9pt;}
h1 { margin-bottom: 0; }
@page{
	margin-left: 70px;
	margin-right: 70px;
	margin-top: 50px;
	margin-bottom: 50px;
}
</style>

<table width="100%" style="font-size: 11pt;">
	<tr>
		<td style="text-align: left" width="75%"><img style="vertical-align: middle" src="logo.png" width="160" /></td>
	
		<td style="text-align: right" width="25%"><img style="vertical-align: middle" src="innovacion.jpeg" width="auto" /></td>
	</tr>
</table>

<br>

<table width="100%" style="font-size: 11pt;">
	<tr>
		<td style="text-align: left; vertical-align: bottom" width="60%">
			<h2>SOLICITUD DE SERVICIO</h2>
		</td>
	
		<td style="text-align: right" width="40%">

		<div style="text-align: right; font-size: 8pt;"><strong>Datos exclusivos de Dirección de Innovación</strong></div>
		<table border="1" width="100%" align="right">
			<tbody>
				<tr>
					<td style="padding: 0.3em;" width="45%"><strong>Fecha y Hora: </strong> </td>
					<td style="padding: 0.3em;" width="55%"></td>
				</tr>
				<tr>
					<td style="padding: 0.3em;" width="45%"><strong>Folio:</strong></td>
					<td style="padding: 0.3em;" width="55%"></td>
				</tr>
				<tr>
					<td style="padding: 0.3em;" width="45%"><strong>Usuario asignado: </strong> </td>
					<td style="padding: 0.3em;" width="55%"></td>
				</tr>
			</tbody>
		</table>

		</td>
	</tr>
</table>

<br>



<table style="border: 1px solid #000000;" class="widecells" width="100%">
	<tbody>
		<tr style="background-color: #000;">
			<td style="padding: 0.3em; color: #FFF; text-align: center;" width="50%" colspan="4"><strong>Datos Actuales del Solicitante</strong></td>
		</tr>
		<tr>
			<td style="padding: 0.3em;" width="50%" colspan="2">Nombre:</td>
		</tr>
		<tr>
			<td style="padding: 0.3em;" width="50%" colspan="2">Puesto:</td>
		</tr>
		<tr>
			<td style="padding: 0.3em;" width="50%" colspan="2">Dirección:</td>
		</tr>
		<tr>
			<td style="padding: 0.3em;" width="50%" colspan="2">Coordinación: </td>
		</tr>
		<tr>
			<td style="padding: 0.3em;" width="50%">Teléfono:</td>
			<td style="padding: 0.3em;" width="50%">Extensión:</td>
		</tr>
	</tbody>
</table>

<br>

<table style="border: 1px solid #000000; text-align: center;" class="widecells" width="100%">
	<tbody>
		<tr style="background-color: #000;">
			<td style="padding: 0.3em; color: #FFF;" width="50%" colspan="4"><strong>Tipo de Solicitud</strong></td>
		</tr>
		<tr>
			<td style="padding: 0.3em;" width="50%">Nuevo Empleado
				<input type="radio" name="pre_publication">
			</td>
			<td style="padding: 0.3em;" width="50%">Modificar Empleado
				<input type="radio" name="pre_publication">
			</td>
		</tr>
	</tbody>
</table>

<br>

<table style="border: 1px solid #000000;  text-align: center;" class="widecells" width="100%">
	<tbody>
		<tr style="background-color: #000;">
			<td style="padding: 0.3em; color: #FFF;" width="50%" colspan="4"><strong>Nuevos Servicios Requeridos</strong></td>
		</tr>
		<tr>
			<td style="padding: 0.3em;" width="33%">Usuario de Dominio de Red 
				<input type="radio" name="pre_publication">
			</td>
			<td style="padding: 0.3em;" width="33%">Correo Electrónico Oficial 
				<input type="radio" name="pre_publication">
			</td>
			<td style="padding: 0.3em;" width="34%">Acceso a Conexión VPN 
				<input type="radio" name="pre_publication">
			</td>
		</tr>
		<tr>
			<td style="padding: 0.3em;" width="33%">Acceso a Internet Esencial 
				<input type="radio" name="pre_publication">
			</td>
			<td style="padding: 0.3em;" width="33%">Acceso a Internet Básico 
				<input type="radio" name="pre_publication">
			</td>
			<td style="padding: 0.3em;" width="34%">Acceso a Internet Redes Sociales 
				<input type="radio" name="pre_publication">
			</td>
		</tr>
	</tbody>
</table>

<br>

<table border="1" width="100%">
	<tbody>
		<tr style="background-color: #000;">
			<td style="padding: 0.3em; text-align: center; color: #FFF;"><strong>Notificarme cuando esté listo a:</strong></td>
		</tr>
		<tr>
			<td>Correo Electrónico Personal:</td>
		</tr>
		<tr>
			<td>Teléfono y Extensión de Contacto:</td>
		</tr>
		<tr>
			<td>Notas:</td>
		</tr>
	</tbody>
</table>


<br>

<table border="1" width="100%">
	<tbody>
		<tr style="background-color: #000;">
			<td style="padding: 0.3em; text-align: center; color: #FFF;" width="33%">Solicitante</td>
			<td style="padding: 0.3em; text-align: center; color: #FFF;" width="33%">Titular de la Dependencia que autoriza</td>
			<td style="padding: 0.3em; text-align: center; color: #FFF;" width="34%">Recepción de la DIG</td>
		</tr>
		<tr>
			<td height="110" style="vertical-align: bottom; text-align: center;">Nombre y Firma</td>
			<td height="110" style="vertical-align: bottom; text-align: center;">Nombre, firma y sello </td>
			<td height="110" style="vertical-align: bottom; text-align: center;">Nombre y Firma</td>
		</tr>
	</tbody>
</table>
<p style="font-size: 7pt; font-family: Arial;">
Procedimiento:
<br>
1) Llenar adecuadamente la información requerida en este formato. 
<br>
2) Imprimirlo para completar nombre y firma del Solicitante, así como nombre, firma y sello del Titular que autoriza.
<br>
3) Enviar la solicitud en original físico o archivo digital:
<br>
Enviar en Físico: 
Dirección de Innovación Gubernamental
Calle Pedro Moreno 1521 3er Piso Interior 305
Col. Americana
<br>
Enviar en Escaneado ó Fotografía:
http://ayuntamiento.guadalajara.gob.mx/solicitudservicio
<br>
>> Indicar el numero de folio de la solicitud y adjuntar el archivo digital.
<br>
Si tienes dudas marca al teléfono 3818 3600 con extensión 3100 con horario de 9:00 a 14:00 Hrs
<br>
<div style="text-align: right"><img src="barra_colores.png" width="auto" height="7"/></div>
</p>
';
//==============================================================
//==============================================================
//==============================================================
include("mpdf.php");

$mpdf=new mPDF('c','Letter');  

$mpdf->WriteHTML($html);

$mpdf->Output();
exit;
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================


?>