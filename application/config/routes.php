<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//$route['default_controller'] = "escritorio";
//$route['404_override'] = '';

$route['default_controller'] = "escritorio";
// $route['(:any)'] = 'escritorio/index/$1';
// $route['escritorio/'] = 'escritorio/';
$route['pruebausuario'] = 'escritorio/prueba';
# Dashboard
$route['dashboard'] = 'escritorio/dashboard';

$route['formatoCotizacion'] = 'escritorio/formato';
$route['formatoContrato']   = 'escritorio/formato';

# Rutas para el cliente
$route['modulo_Clientes'] 			 = 'escritorio/clientes';
$route['modulo_cliente_nuevo'] 		 = 'escritorio/clientes/$1';
$route['modulo_consulta_clientes'] 	 = 'escritorio/clientes/$1';
$route['modulo_consulta_prospectos'] = 'escritorio/clientes/$1';


// $route['catalogo_Servicios'] 		 = 'escritorio/catalogoServicios';

//Rutas para la proyectos
$route['modulo_proyectos'] = 'escritorio/proyectos/$1';
$route['modulo_proyectos_consulta']   = 'escritorio/proyectos/$1';
$route['modulo_proyectos_nuevo']      = 'escritorio/proyectos/$1';

//Rutas para la contratos...
$route['modulo_contratos']           = 'escritorio/contratos/$1';
$route['modulo_contratos_nuevo']     = 'escritorio/contratos/$1';
$route['modulo_contratos_historial'] = 'escritorio/contratos/$1';

//Rutas para la cotizacion
$route['modulo_cotizaciones']          = 'escritorio/cotizacion/$1';
$route['modulo_cotizaciones_nuevo']    = 'escritorio/cotizacion/$1';
$route['modulo_cotizaciones_consulta'] = 'escritorio/cotizacion/$1';

//Rutas para la facturas...
  $route['prueba_ver_proyecto'] = 'escritorio/facturas/$1';
  $route['modal_consulta_proyecto'] = 'escritorio/facturas/$1';
//$route['modulo_facturas'] = 'escritorio/facturas/$1';
// $route['modulo_facturass'] = 'escritorio/facturas/$1';
// $route['modulo_facturas'] = 'escritorio/facturas/$1';

//Rutas para la actividades...
$route['modulo_actividades'] = 'escritorio/actividades/$1';
$route['pruebapdf'] = 'escritorio/pdf/$1';
// $route['modulo_actividades'] = 'escritorio/actividades/$1';

//Rutas para la catalogos...
$route['modulo_catalogos']    = 'escritorio/catalogos/$1';
$route['catalogo_servicios']  = 'escritorio/catalogos/$1';
$route['catalogo_perfiles']  = 'escritorio/catalogos/$1';
$route['catalogo_permisos']  = 'escritorio/catalogos/$1';
$route['catalogo_empleados']  = 'escritorio/catalogos/$1';
$route['catalogo_roles']  = 'escritorio/catalogos/$1';
$route['catalogo_puestos']  = 'escritorio/catalogos/$1';

// $route['catalogo_telefonos']  = 'escritorio/catalogos';
// $route['catalogo_planes']  = 'escritorio/catalogos';


// $route['modulo_catologos'] = 'escritorio/catologos/$1';
// $route['modulo_catologos'] = 'escritorio/catologos/$1';

//Rutas para el modilo de usuarios...
$route['modulo_usuarios'] = 'escritorio/usuarios/$1';
$route['modulo_usuarios_nuevo'] = 'escritorio/usuarios/$1';
$route['modulo_usuarios_consulta'] = 'escritorio/usuarios/$1';
// $route['modulo_usuarios'] = 'escritorio/usuarios/$1';

//Rutas para el modulo de configuracion...
$route['modulo_configuracion'] = 'escritorio/configuracion/$1';
// $route['modulo_configuracion'] = 'escritorio/configuracion/$1';
// $route['modulo_configuracion'] = 'escritorio/configuracion/$1';

#################-----RUTAS PARA LAS APIS------######################

# Rutas para la api de clientes...
$route['api_cliente'] = 'cliente/api';
$route['api_cliente/(:num)'] = 'cliente/api';

$route['api_contactos'] = 'contacto/api';
$route['api_contactos/(:num)'] = 'contacto/api/$1';


$route['api_contratos'] = 'contratos/api';
$route['api_contratos/(:num)'] = 'contratos/api/$1';

# Rutas para la api de clientes...
$route['api_cliente'] = 'cliente/api';
$route['api_cliente/(:num)'] = 'cliente/api';

# Rutas para la api de clientes...
$route['api_empleados'] = 'empleados/api';
$route['api_empleados/(:num)'] = 'empleados/api';

# Rutas para la api de clientes...
$route['api_prospecto'] = 'cliente/api';
$route['api_prospecto/(:num)'] = 'cliente/api/$1';

# Ruta para la api de representantes...
$route['api_representante'] = 'representante/api';
$route['api_representante/(:num)'] = 'representante/api/$1';

# Ruta para la api de Servicios...
$route['api_servicios'] = 'servicios/api';
$route['api_servicios/(:num)'] = 'servicios/api/$1';

# Ruta para la api de Servicios...
$route['api_actividades'] = 'actividades/api';
$route['api_actividades/(:num)'] = 'actividades/api/$1';

# Ruta para la api de Usuarios...
$route['api_usuarios'] = 'usuarios/api';
$route['api_usuarios/(:num)'] = 'usuarios/api/$1';

# Ruta para la api de Perfil...
$route['api_perfil'] = 'perfil/api';
$route['api_perfil/(:num)'] = 'perfil/api/$1';

# Ruta para la api de Permisos...
$route['api_permisos'] = 'permisos/api';
$route['api_permisos/(:num)'] = 'permisos/api/$1';

# Ruta para la api de Servicios de Interes...
$route['api_serviciosInteres'] = 'serviciosInteres/api';
$route['api_serviciosInteres/(:num)'] = 'serviciosInteres/api/$1';

# Ruta para la api de Servicios de Interes...
$route['api_serviciosCliente'] = 'serviciosCliente/api';
$route['api_serviciosCliente/(:num)'] = 'serviciosCliente/api/$1';
##################################################################
# Ruta de apis para la Cotizacioin...
$route['api_cotizaciones'] = 'cotizaciones/api';
$route['api_cotizaciones/(:num)'] = 'cotizaciones/api/$1';

# Ruta para la api de Servicios cotizados
$route['api_servicioCotizado']        = 'servicioCotizado/api';
$route['api_servicioCotizado/(:num)'] = 'servicioCotizado/api/$1';
##################################################################
# Ruta para la api de Servicios de Interes...
$route['api_archivos'] = 'archivo/api';
$route['api_archivos/(:num)'] = 'archivo/api/$1';


$route['api_foto'] = 'foto/api';

# Ruta para la api de Servicios de Interes...
$route['api_personal'] = 'personal/api';
$route['api_personal/(:num)'] = 'personal/api/$1';

# Ruta para la api de Servicios de Interes...
$route['api_proyectos'] = 'proyectos/api';
$route['api_proyectos/(:num)'] = 'proyectos/api/$1';

$route['api_serviciosProyecto'] = 'serviciosProyecto/api';
$route['api_serviciosProyecto/(:num)'] = 'serviciosProyecto/api/$1';

# Ruta para la api de Servicios de Interes...
$route['api_rolesDeProyecto'] = 'rolesDeProyecto/api';
$route['api_rolesDeProyecto/(:num)'] = 'rolesDeProyecto/api/$1';

$route['api_telefonos'] = 'telefono/api';
$route['api_telefonos/(:num)'] = 'telefono/api/$1';

$route['api_catalogoTelefonos'] = 'catalogoTelefonos/api';
$route['api_catalogoTelefonos/(:num)'] = 'catalogoTelefonos/api/$1';

$route['api_roles'] = 'roles/api';
$route['api_roles/(:num)'] = 'roles/api/$1';

$route['api_facturas'] = 'facturas/api';
$route['api_facturas/(:num)'] = 'facturas/api/$1';

$route['api_puestos'] = 'puesto/api';
$route['api_puestos/(:num)'] = 'puesto/api/$1';


$route['api_permisoPerfil'] = 'permisoPerfil/api';
$route['api_permisoPerfil/(:num)'] = 'permisoPerfil/api/$1';

$route['api_permisoUsuario'] = 'permisoUsuario/api';
$route['api_permisoUsuario/(:num)'] = 'permisoUsuario/api/$1';

$route['api_serviciosContrato'] = 'serviciosDeContrato/api';
$route['api_serviciosContrato/(:num)'] = 'serviciosDeContrato/api/$1';

$route['api_pagos'] = 'payment/api';
$route['api_pagos/(:num)'] = 'payment/api/$1';

