<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "escritorio";
$route['404_override'] = '';

$route['logout'] = 'escritorio/logout';

$route['pruebausuario'] = 'escritorio/modulo';

# Dashboard
$route['escritorio/dashboard'] = 'escritorio/modulo';

$route['formatoCotizacion'] = 'escritorio/modulo';
$route['formatoContrato']   = 'escritorio/modulo';

# Rutas para el cliente
$route['escritorio/modulo_Clientes'] 			 = 'escritorio/modulo';
$route['escritorio/modulo_cliente_nuevo'] 		 = 'escritorio/modulo/$1';
$route['escritorio/modulo_consulta_clientes'] 	 = 'escritorio/modulo/$1';
$route['escritorio/modulo_consulta_prospectos'] = 'escritorio/modulo/$1';

//Rutas para la proyectos
$route['escritorio/modulo_proyectos'] = 'escritorio/modulo/$1';
$route['escritorio/modulo_proyectos_consulta']   = 'escritorio/modulo/$1';
$route['escritorio/modulo_proyectos_nuevo']      = 'escritorio/modulo/$1';
$route['escritorio/modulo_proyectos_cronograma'] = 'escritorio/modulo/$1';

//Rutas para la contratos...
$route['escritorio/modulo_contratos']           = 'escritorio/modulo/$1';
$route['escritorio/modulo_contratos_nuevo']     = 'escritorio/modulo/$1';
$route['escritorio/modulo_contratos_historial'] = 'escritorio/modulo/$1';

//Rutas para la cotizacion
$route['escritorio/modulo_cotizaciones']          = 'escritorio/modulo/$1';
$route['escritorio/modulo_cotizaciones_nuevo']    = 'escritorio/modulo/$1';
$route['escritorio/modulo_cotizaciones_consulta'] = 'escritorio/modulo/$1';

//Rutas para la facturas...
  $route['prueba_ver_proyecto'] = 'escritorio/modulo/$1';
  $route['escritorio/modal_consulta_proyecto'] = 'escritorio/modulo/$1';
 

//Rutas para la actividades...
$route['escritorio/modulo_actividades'] = 'escritorio/modulo/$1';
$route['escritorio/pruebapdf'] = 'escritorio/pdf/$1';

//Rutas para la catalogos...
$route['escritorio/modulo_catalogos']    = 'escritorio/modulo/$1';
$route['escritorio/catalogo_servicios']  = 'escritorio/modulo/$1';
$route['escritorio/catalogo_perfiles']  = 'escritorio/modulo/$1';
$route['escritorio/catalogo_permisos']  = 'escritorio/modulo/$1';
$route['escritorio/catalogo_empleados']  = 'escritorio/modulo/$1';
$route['escritorio/catalogo_roles']  = 'escritorio/modulo/$1';
$route['escritorio/catalogo_puestos']  = 'escritorio/modulo/$1';


//Rutas para el modilo de usuarios...
$route['escritorio/modulo_usuarios'] = 'escritorio/modulo/$1';
$route['escritorio/modulo_usuarios_nuevo'] = 'escritorio/modulo/$1';
$route['escritorio/modulo_usuarios_consulta'] = 'escritorio/modulo/$1';
// $route['escritorio/modulo_usuarios'] = 'escritorio/usuarios/$1';

//Rutas para el modulo de configuracion...
$route['escritorio/modulo_configuracion'] = 'escritorio/modulo/$1';

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

$route['api_serviciosContrato'] = 'serviciosDeContrato/api';
$route['api_serviciosContrato/(:num)'] = 'serviciosDeContrato/api/$1';

$route['api_pagos'] = 'payment/api';
$route['api_pagos/(:num)'] = 'payment/api/$1';

