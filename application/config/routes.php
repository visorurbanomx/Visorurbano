<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'frontend';
$route['normatividad'] = 'frontend/normatividad';
$route['manuales'] = 'frontend/manuales';
$route['preguntasfrecuentes'] = 'frontend/faq';
$route['tramites1'] = 'frontend/tramites1';
$route['contacto'] = 'frontend/contacto';
$route['bid'] = 'frontend/bid';
//Auth
$route['ingresar'] = 'auth';
$route['registro'] = 'auth/crearCuenta';
$route['login']['post'] = 'auth/login';
$route['sUpdate']['post'] = 'auth/updateSession';
$route['recuperar-contrasena'] = 'auth/recuperarContrasena';
//$route['logout']['post'] = 'auth/login';
//Admin
$route['admin'] = 'admin';
$route['admin/mis-licencias'] = 'admin/misLicencias';
$route['admin/impresion'] = 'admin/impresion';
$route['admin/usuario'] = 'admin/perfilUsuario';
$route['admin/mis-mensajes'] = 'admin/mensajes';
$route['admin/mis-mensajes/(:any)'] = 'admin/mensaje';
$route['admin/confirmacion_licencia/(:any)'] = 'admin/confirmacion_licencia';

//Licencias de Giro
$route['nueva-licencia'] = 'LicenciasGiro';
$route['nueva-licencia/confirmacion/(:any)'] = 'LicenciasGiro/licenciaGiroConfirmacion';
$route['nueva-licencia/(:any)/(:any)'] = 'LicenciasGiro/licenciaGiroForma';
$route['nueva-licencia/(:any)'] = 'LicenciasGiro/requisitos';

$route['licencia/a/update'] = 'LicenciasGiro/updateForma';

$route['revision'] = 'RevisionController';
$route['revision/(:any)'] = 'RevisionController';
//utils
$route['validacuentapredial'] = 'UtilsController/validateCuentaPredial';
$route['validaclavecatastral'] = 'UtilsController/validateClaveCatastral';
$route['datosPropietario'] = 'UtilsController/datosPropietario';
$route['admin/setMensaje'] = 'UtilsController/setMensaje';
$route['getTramite'] = 'UtilsController/getTramite';

//Formas
$route['orden-pago/licencia-giro/(:any)/(:any)'] = 'Formatos/formaPagoLicencias';

//Errors
$route['404_override'] = 'frontend/notFound';
$route['translate_uri_dashes'] = FALSE;
