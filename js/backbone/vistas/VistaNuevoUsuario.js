var app = app || {};

app.VistaNuevoUsuario = Backbone.View.extend({
	el : '#datosUsuario',
	plantilla : _.template($('#tsubmodulos').html()),

	events : {
		'click #guardar'    : 'guardar',
		// 'click #empleado'   : 'buscarEmpleado',
		// 'blur  #empleado'   : 'Aidempleado',
		// 'keypress #empleado': 'soloLetras',
		// 'change #idperfil'  : 'mostrarPermisos',
		// 'change #idpermisos' : 'marcarTodos'
		// 'click .ui-corner-all' : 'resize',
		'click .tohead' : 'resize',
		'change #idperfil' : 'mispermisos'

	},

	initialize : function ()
	{	
		this.cargarModulo();	
		this.selectEmpleados();
		this.cargarSubmodulo();
		select_Perfil();
	},

	resize : function(elemento)
	{
		var efect = $(elemento.currentTarget).parent().children('.conf').attr('id');	
		$('#'+efect).slideToggle( 500 );
	},

	selectEmpleados : function()
    {
    	var list = '<% _.each(empleados, function(empleado) { %> <option disabled id="<%- empleado.id %>" value="<%- empleado.id %>"><%- empleado.nombre %></option> <% }); %>';
		this.$('#idempleado').
		append(_.template(list, 
			{ empleados : app.coleccionEmpleados.toJSON() }
		));
		this.$('#idempleado').selectize({
			create: true,
			maxItems: 1
		});
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
			// json.id = submodulos[x].id;			
			json.modulo = submodulos[x].modulo;
			
			json.submodulos = submodulos[x].permisos.split(",");			
			this.$("#submodulos").append(this.plantilla(json));				
		}				
	},
	
	mispermisos : function(idperfil)
	{
		idperfil = $(idperfil.currentTarget).val();
		var nombre = app.coleccionPerfiles.findWhere({id : idperfil }).get('idpermisos');
		console.log(nombre);
		// this.cargarPermisos();
		// if(nombre)
		// {
		// 	marcarPermiso(JSON.parse(nombre).idpermisos, this.$el.find('.chek').children(), this.$el);	
		// }		
	},

	marcarTodos : function(elemento)
	{
		marcarCheck(elemento);      
	},

	jsonpermisos : function()
	{
		var permisos = pasarAJson( this.$("#arraypermisos").serializeArray() ) ;		
		var mispermisos ={};
		mispermisos = {
			clientes : 
			{
				Nuevo : permisos.clientesNuevo,
				Clientes : permisos.clientesClientes,
				Prospecto : permisos.clientesProspectos,
				Papelera : permisos.clientesPapelera
			},
			proyectos : 
			{
				Nuevo : permisos.proyectosNuevo,
				Cronograma : permisos.proyectosCronograma,
				Proyectos : permisos.proyectosProyectos
			},
			contratos :
			{
				Nuevo 	  : permisos.contratosNuevo,
				Contratos : permisos.contratosContratos,
				Papelera  : permisos.contratosPapelera
			},
			cotizaciones :
			{
				Nuevo 		 : permisos.cotizacionesNuevo,
				Cotizaciones : permisos.cotizacionesCotizaciones,
				Papelera 	 : permisos.cotizacionesPapelera
			},
			catalogos :
			{
				Empleados : permisos.empleados,
				perfiles  : permisos.perfiles,
				roles     : permisos.roles,
				puestos   : permisos.puestos 				
			},
			usuarios :
			{
				Nuevo 	 : permisos.usuariosNuevo,
				Usuarios : permisos.usuariosUsuarios
			}
		};
		
		for(x in mispermisos)
		{
			mispermisos[x] = limpiarJSON(mispermisos[x]);	
		}
		
		return JSON.stringify(mispermisos);
	},

	guardar	 : function ()
	{	
		/*--- si el campo foto del formulario tiene una url de carpeta que contenga un archivo img entonces 
			  invocamos a la función urlFoto, y le enviamos de parametro formData---*/
		var foto = ( this.$('#foto').val() ) ? this.urlFoto( new FormData( $("#registroUsuario")[0]) ) : 'img/sinfoto.png';
		
		/*-- Si el usuario es un empleado se le asigna su idempleado en caso de que sea un usuario que no es empleado su id=0--*/
		var ide = ($("#idempleado").val()) ? $("#idempleado").val() : 0;
		
		var modeloUsuario 		= pasarAJson($('#registroUsuario').serializeArray());
		modeloUsuario 			= limpiarJSON(modeloUsuario); 

		/*--- asignamos atributos ---*/
		modeloUsuario.idempleado = ide;
		modeloUsuario.foto 		 = foto;
		/*--- la funcion jsonpermisos(); devuelve una cadena de todos los permisos asignados ---*/
		modeloUsuario.permisos 	= this.jsonpermisos();
		
		$('#registroUsuario')[0].reset();

		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		app.coleccionUsuarios.create
		(
			modeloUsuario,
			{
				wait	: true,
				success : function (exito) { location.href='usuarios_consulta'; },
				error 	: function (error) {}
			}
		);
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
		
	}, /*... Fin de la función guardar ...*/

	// -----obtenerFoto------------------------------- 
	urlFoto	: function (formData) 
	{		
        //hacemos la petición ajax  
        var resp = $.ajax({
            url: 'http://crmqualium.com/api_foto',
            type: 'POST',
            async:false,
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false
        });

        return jQuery.parseJSON(resp.responseText);
    },

    soloLetras : function(e)
    {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = "8-37-39-46";

        tecla_especial = false
        for(var i in especiales)
        {
            if(key == especiales[i])
            {
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
             return false;
        }
    }

});

app.vistaNuevoUsuario = new app.VistaNuevoUsuario();