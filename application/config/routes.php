<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
# Este archivo contiene todas las rutas del sistema si desea agregar otra ruta 
# Simple, escritorio/'ruta_nueva' = escritorio(controlador)/metodo
$route[ 'default_controller'] = "escritorio";
$route[ '404_override'      ] = '';
$route[ 'logout'            ] = 'escritorio/logout';

# Rutas para los modulos del sistema.
$route[ 'escritorio/dashboard'			    ] = 'escritorio/modulo';
$route[ 'escritorio/cliente_nuevo'          ] = 'escritorio/modulo';
$route[ 'escritorio/consulta_clientes'      ] = 'escritorio/modulo';		 
$route[ 'escritorio/consulta_prospectos'    ] = 'escritorio/modulo';
$route[ 'escritorio/consulta_clientes_eliminados'    ] = 'escritorio/modulo';
$route[ 'escritorio/proyectos_consulta'     ] = 'escritorio/modulo';
$route[ 'escritorio/proyectos_nuevo'        ] = 'escritorio/modulo';
$route[ 'escritorio/proyectos_cronograma'   ] = 'escritorio/modulo';
$route[ 'escritorio/prueba_ver_proyecto'    ] = 'escritorio/modulo';
$route[ 'escritorio/modal_consulta_proyecto'] = 'escritorio/modulo';
$route[ 'escritorio/contratos_nuevo'      	] = 'escritorio/modulo';
$route[ 'escritorio/contratos_historial'  	] = 'escritorio/modulo';
$route[ 'escritorio/contratos_papelera'  	] = 'escritorio/modulo';
$route[ 'escritorio/formatoContrato'        ] = 'escritorio/modulo';
$route[ 'escritorio/cotizaciones_nuevo'     ] = 'escritorio/modulo';
$route[ 'escritorio/cotizaciones_consulta'  ] = 'escritorio/modulo';
$route[ 'escritorio/cotizaciones_papelera'  ] = 'escritorio/modulo';
$route[ 'escritorio/formatoCotizacion'      ] = 'escritorio/modulo';
$route[ 'escritorio/actividades' 		    ] = 'escritorio/modulo';
$route[ 'escritorio/pruebapdf'          	] = 'escritorio/pdf';
$route[ 'escritorio/catalogos'   		    ] = 'escritorio/modulo';
$route[ 'escritorio/catalogo_servicios' 	] = 'escritorio/modulo';
$route[ 'escritorio/catalogo_perfiles'  	] = 'escritorio/modulo';
$route[ 'escritorio/catalogo_permisos'  	] = 'escritorio/modulo';
$route[ 'escritorio/catalogo_empleados' 	] = 'escritorio/modulo';
$route[ 'escritorio/catalogo_roles'     	] = 'escritorio/modulo';
$route[ 'escritorio/catalogo_puestos'   	] = 'escritorio/modulo';
$route[ 'escritorio/usuarios_nuevo'    	 	] = 'escritorio/modulo';
$route[ 'escritorio/usuarios_consulta' 	 	] = 'escritorio/modulo';
$route[ 'escritorio/vistaPreviaCotizacion'  ] = 'escritorio/modulo';
$route['escritorio/configuracion'		 	] = 'escritorio/modulo';

#################-----RUTAS PARA LAS APIS------######################
$route[ 'api_actividades'        	  ] = 'actividades/api';
$route[ 'api_actividades/(:num)' 	  ] = 'actividades/api/$1';
$route[ 'api_archivos'                ] = 'archivo/api';
$route[ 'api_archivos/(:num)'		  ] = 'archivo/api/$1';
$route[ 'api_cliente'                 ] = 'cliente/api';
$route[ 'api_cliente/(:num)'          ] = 'cliente/api/$1';
$route[ 'api_contactos'               ] = 'contacto/api';
$route[ 'api_contactos/(:num)'        ] = 'contacto/api/$1';
$route[ 'api_contratos'               ] = 'contratos/api';
$route[ 'api_contratos/(:num)'        ] = 'contratos/api/$1';
$route[ 'api_cotizaciones'			  ] = 'cotizaciones/api';
$route[ 'api_cotizaciones/(:num)'	  ] = 'cotizaciones/api/$1';
$route[ 'api_empleados'               ] = 'empleados/api';
$route[ 'api_empleados/(:num)'        ] = 'empleados/api';
$route[ 'api_foto'                    ] = 'foto/api';
$route[ 'api_pagos'                   ] = 'payment/api';
$route[ 'api_pagos/(:num)'            ] = 'payment/api/$1';
$route[ 'api_perfil'             	  ] = 'perfil/api';
$route[ 'api_perfil/(:num)'      	  ] = 'perfil/api/$1';
$route[ 'api_permisos'				  ] = 'permisos/api';
$route[ 'api_permisos/(:num)'		  ] = 'permisos/api/$1';
$route[ 'api_prospecto'               ] = 'cliente/api';
$route[ 'api_prospecto/(:num)'        ] = 'cliente/api/$1';
$route[ 'api_proyectos'				  ] = 'proyectos/api';
$route[ 'api_proyectos/(:num)' 		  ] = 'proyectos/api/$1';
$route[ 'api_puestos'                 ] = 'puesto/api';
$route[ 'api_puestos/(:num)'          ] = 'puesto/api/$1';
$route[ 'api_representante'           ] = 'representante/api';
$route[ 'api_representante/(:num)'    ] = 'representante/api/$1';
$route[ 'api_roles'					  ] = 'roles/api';
$route[ 'api_roles/(:num)'			  ] = 'roles/api/$1';
$route[ 'api_rolesDeProyecto'		  ] = 'rolesDeProyecto/api';
$route[ 'api_rolesDeProyecto/(:num)'  ] = 'rolesDeProyecto/api/$1';
$route[ 'api_servicios'               ] = 'servicios/api';
$route[ 'api_servicios/(:num)'        ] = 'servicios/api/$1';
$route[ 'api_serviciosInteres'		  ] = 'serviciosInteres/api';
$route[ 'api_serviciosInteres/(:num)' ] = 'serviciosInteres/api/$1';
$route[ 'api_serviciosCliente'        ] = 'serviciosCliente/api';
$route[ 'api_serviciosCliente/(:num)' ] = 'serviciosCliente/api/$1';
$route[ 'api_servicioCotizado'		  ] = 'servicioCotizado/api';
$route[ 'api_servicioCotizado/(:num)' ] = 'servicioCotizado/api/$1';
$route[ 'api_serviciosProyecto'       ] = 'serviciosProyecto/api';
$route[ 'api_serviciosProyecto/(:num)'] = 'serviciosProyecto/api/$1';
$route[ 'api_serviciosContrato'       ] = 'serviciosDeContrato/api';
$route[ 'api_serviciosContrato/(:num)'] = 'serviciosDeContrato/api/$1';
$route[ 'api_telefonos'				  ] = 'telefono/api';
$route[ 'api_telefonos/(:num)'		  ] = 'telefono/api/$1';
$route[ 'api_usuarios'           	  ] = 'usuarios/api';
$route[ 'api_usuarios/(:num)'    	  ] = 'usuarios/api/$1';

$route['escritorio/pdf_cotizacion/(:any)'] = 'pdf_cotizacion/get_cotizacion/$1';
