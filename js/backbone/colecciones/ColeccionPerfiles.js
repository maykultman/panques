var app = app || {};

app.ModeloPerfil = Backbone.Model.extend({
	urlRoot	:'http://crmqualium.com/api_perfil'
});

var ColeccionPerfiles = Backbone.Collection.extend({
	url: 'http://crmqualium.com/api_perfil',
	model	: app.ModeloPerfil,
});

app.coleccionPerfiles = new ColeccionPerfiles(app.coleccionDePerfiles);

	function rezise(elemento, togle)
	{
		var efect = $(elemento.currentTarget).parent().children('.conf').attr('id');	
		$('#'+elemento).slideToggle( 400 );
		$('#'+togle).toggleClass('rotate');
	}

	function marcarPermiso(permiso, checkbox, el)
	{
		for( e in permiso)
		{
			for(var i = 0 ; i < checkbox.length ; i++)
			{ 
			 	if(permiso[e] == checkbox[i].value)
			 	{
			 		el.find('#permiso_'+permiso[e]).attr('checked', 'true');
			 		el.find('#permiso_'+permiso[e]).parent().css('background','#ddffdd');
					el.find('#permiso_'+permiso[e]).parent().css('border-radius','5px');						 	
			 	}
			}
		}	
	}
	function jsonpermisos(permisos)
	{
		var mispermisos = 
			[
				{
					nombre:"Clientes", 	
					submodulos:
					[
						{ nombre:"Nuevo",      permisos : permisos.ClientesNuevo	   },
						{ nombre:"Prospectos", permisos : permisos.ClientesProspectos  },
						{ nombre:"Clientes",   permisos : permisos.ClientesClientes  },
						{ nombre:"Papelera",   permisos : permisos.ClientesPapelera  },
					]
				},

				{
					nombre:"Proyectos", 	
					submodulos:
					[
						{ nombre:"Nuevo",	   permisos: permisos.ProyectosNuevo      },
						{ nombre:"Proyectos",  permisos: permisos.ProyectosProyectos  },
						{ nombre:"Cronograma", permisos: permisos.ProyectosCronograma },
					]
				},

				{
					nombre:"Contratos", 	
					submodulos:
					[
						{ nombre : "Nuevo",     permisos: permisos.ContratosNuevo  		 },
						{ nombre : "Contratos", permisos: permisos.ContratosContratos    },
						{ nombre : "Papelera",  permisos: permisos.ContratosPapelera     }
					]
				},

				{
					nombre:"Cotizaciones", 
					submodulos:
					[
						{ nombre : "Nuevo",        permisos: permisos.CotizacionesNuevo  		},
						{ nombre : "Cotizaciones", permisos: permisos.CotizacionesCotizaciones },
						{ nombre : "Papelera",     permisos: permisos.CotizacionesPapelera     }
					]
				},

				{
					nombre:"Actividades", 	
					submodulos:
					[
						{nombre:"nuevo",permisos:[1]},
						{nombre:"Proyectos",permisos:[2,3,4]}
					]
				},

				{
					nombre:"Catálogos",
					submodulos:
					[
						{ nombre:"Empleados", permisos: permisos.CatálogosEmpleados 	},
						{ nombre:"Perfiles",  permisos: permisos.CatálogosPerfiles 	},
						{ nombre:"Puestos",   permisos: permisos.CatálogosPuestos 	},
						{ nombre:"Roles",     permisos: permisos.CatálogosRoles 		},
						{ nombre:"Servicios", permisos: permisos.CatálogosServicios	}
					]
				},

				{
					nombre:"Usuarios",
					submodulos:
					[
						{nombre:"Nuevo",permisos: permisos.UsuariosNuevo},
						{nombre:"Usuarios",permisos: permisos.UsuariosUsuarios}
					]
				}
			];	
		
		
		for(x in mispermisos)
		{
			mispermisos[x] = limpiarJSON(mispermisos[x]);	
		}
		return JSON.stringify(mispermisos);
	}


	function markTodos(chek)
	{
		checkboxs = $('.chek');
		if ($(chek.currentTarget).is(':checked'))
	    {
	        for (var i = 0; i < checkboxs.length; i++) {
	            checkboxs[i].checked = true;
	        }
	    }
	    else{
	        for (var i = 0; i < checkboxs.length; i++) {
	            checkboxs[i].checked = false;
	        }
	    }
	}