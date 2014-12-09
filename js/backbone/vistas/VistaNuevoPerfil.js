var app = app || {};

app.VistaNuevoPerfil = Backbone.View.extend({
	el : '#nuevop',
	plantilla : _.template($('#tsubmodulos').html()),

	events : {
		'click #guardar' : 'guardar',
		'change #idpermisos'   : 'marcarTodos',
		'keypress #nombre' 	 : 'validarNombre',
		'click #perfil_nuevo' : 'cargarSubmodulo',
		'click .tohead'    : 'resize',
	},

	initialize : function ()
	{
	    this.cargarModulo();
        this.cargarSubmodulo();
	},
	render : function (){ return this; },

	resize : function(elemento)
	{
		rezise(elemento);		
	},

	cargarModulo : function()
	{
		var list = '<% _.each(modulos, function(modulo){ %> <li><a href="#<%- modulo.modulo %>" role="tab" data-toggle="tab"> <%- modulo.modulo%> </a></li> <% }) %>';
		this.$('#modulos').append(_.template(list, {modulos : app.coleccionPermisos.toJSON() }));
		$("#modulos").children(':first-child').addClass('active');
	},
	cargarSubmodulo : function()
	{
		submodulos = app.coleccionPermisos.toJSON();			
		var json={};		
		for(var x=0; x < submodulos.length;x++)
		{			
			json.active = (x==0) ? "active" : "";
			json.modulo = submodulos[x].modulo;
			
			json.submodulos = submodulos[x].permisos.split(",");			
			this.$("#submodulos").append(this.plantilla(json));				
		}				
	},

	validarNombre : function(e)
	{
		key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = "8-37-39-46";
        tecla_especial = false;
        for(var i in especiales)
        {
            if(key == especiales[i])
            {
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial)
        {
            return false;
        }                 
	},

	guardar : function()
	{
		var permisos = pasarAJson($('#arraypermisos').serializeArray());
		var self = this;
		
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;

		app.coleccionPerfiles.create
		(
			{
				nombre : $("#nombre1").val(),
				idpermisos : self.jsonpermisos(permisos)
			},
			{
				wait : true,
				success : function(){},
				error 	: function(){}	
			}
			
		);
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;

	},

	jsonpermisos : function(permisos)
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
						{ nombre:"nuevo",	   permisos: permisos.ProyectosNuevo      },
						{ nombre:"Proyectos",  permisos: permisos.ProyectosProyectos  },
						{ nombre:"Cronograma", permisos: permisos.ProyectosCronograma },
					]
				},

				{
					nombre:"Contratos", 	
					submodulos:
					[
						{ nombre : "nuevo",     permisos: permisos.ContratosNuevo  		 },
						{ nombre : "Contratos", permisos: permisos.ContratosCotizaciones },
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

				// {
				// 	nombre:"Actividades", 	
				// 	submodulos:
				// 	[
				// 		{nombre:"nuevo",permisos:[1]},
				// 		{nombre:"Proyectos",permisos:[2,3,4]}
				// 	]
				// },

				{
					nombre:"Catálogos",
					submodulos:
					[
						{ nombre:"Empleados", permisos: permisos.Empleados 	},
						{ nombre:"Perfiles",  permisos: permisos.Perfiles 	},
						{ nombre:"Puestos",   permisos: permisos.Puestos 	},
						{ nombre:"Roles",     permisos: permisos.Roles 		},
						{ nombre:"Servicios", permisos: permisos.Servicios	}
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
	},
	guardar1 : function (evento)
	{
		var modeloPerfil = pasarAJson($('#registroPerfil').serializeArray());
		modeloPerfil.idpermisos = JSON.stringify( modeloPerfil.idpermisos );
		if(modeloPerfil.nombre)
		{
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionPerfiles.create
			(
				modeloPerfil,
				{
					wait: true,
					success: function (exito)
					{
						alerta('<p style="color:#1A641A"><b>Perfil Guardado con Éxito</b></p>', function(){});
					},
					error: function (error) {
						alerta('<p style="color:FireBrick"><b>Error al registrar el Perfil</b></p>', function(){});
					}
				}
			); /*...Create del perfil...*/

			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		} /*...If de modelo Perfil...*/
		
		evento.preventDefault();
	},

	mispermisos : function(idperfil)
	{
		idperfil = $(idperfil.currentTarget).val();
		var permisos = app.coleccionPerfiles.findWhere({id : idperfil }).get('idpermisos');
		var mispermisos = jQuery.parseJSON(permisos);
		var inputchek;
		$('.check').attr('checked', false);
		for(i in mispermisos)
		{
			if(
				  mispermisos[i].nombre=='Clientes' ||mispermisos[i].nombre=='Proyectos'
				||mispermisos[i].nombre=='Contratos'||mispermisos[i].nombre=='Cotizaciones'
				||mispermisos[i].nombre=='Proyectos'||mispermisos[i].nombre=='Actividades'
				||mispermisos[i].nombre=='Catálogos'||mispermisos[i].nombre=='Usuarios'
			  )
			{
				for(x in mispermisos[i].submodulos)
				{
					for(y in mispermisos[i].submodulos[x].permisos)
					{
						inputchek = $('#'+mispermisos[i].nombre+mispermisos[i].submodulos[x].nombre+' #'+mispermisos[i].submodulos[x].permisos[y]);
						$(inputchek).attr('checked',true);												
					}					
				}
			}			
		}		
	},
	// marcarTodos : function(elemento)
	// {
	// 	var checkboxTabla = this.$el.find('.chek').children();
 //       marcarCheck(elemento, checkboxTabla) ;
	// },

});

app.vistaNuevoPerfil = new app.VistaNuevoPerfil();