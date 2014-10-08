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

	},

	initialize : function ()
	{	
		this.cargarSelectPerfiles();
		this.cargarModulo();	
		this.selectEmpleados();
		this.cargarSubmodulo();
	},

	resize : function(elemento)
	{
		var efect = $(elemento.currentTarget).parent().children('.conf').attr('id');	
		$('#'+efect).slideToggle( 500 );
	},

	selectEmpleados : function()
    {
    	var list = '<% _.each(empleados, function(empleado) { %> <option disabled id="<%- empleado.id %>" value="<%- empleado.id %>"><%- empleado.nombre %></option> <% }); %>';
		this.$('#semp').
		append(_.template(list, 
			{ empleados : app.coleccionEmpleados.toJSON() }
		));
		this.$('#semp').selectize({
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
		var array=[];	
		var array2=[];
		var seccion ={};
		var divp=[]; 
		var divc;
		var active="";
		var cont=0;
		var cont2=0;
		for(var x=0; x < submodulos.length;x++)
		{			
			if(cont==0)
			{
				active="active";
				cont++;
			};
			
			json.active = active;
			active="";

			json.modulo = submodulos[x].modulo;
			
			json.submodulos = submodulos[x].permisos.split(",");			
			this.$("#submodulos").append(this.plantilla(json));	
			
		}			
	},
	
	cargarSelectPerfiles : function ()
	{	
		var list = '<% _.each(perfiles, function(perfil) { %> <option value="<%- perfil.id %>"><%- perfil.nombre %></option> <% }); %>';
		this.$('#idperfil').
		append(_.template(list, 
			{ perfiles : app.coleccionPerfiles.toJSON() }
		));
		// this.$('#idperfil').selectize({
		// 	create: true,
		// 	maxItems: 1
		// });
	},

	// mostrarPermisos : function(idperfil)
	// {
	// 	var nombre = app.coleccionPerfiles.findWhere({id : $(idperfil.currentTarget).val() }).get('idpermisos');
	// 	this.cargarPermisos();
	// 	if(nombre)
	// 	{
	// 		marcarPermiso(JSON.parse(nombre).idpermisos, this.$el.find('.chek').children(), this.$el);	
	// 	}		
	// },

	marcarTodos : function(elemento)
	{
		marcarCheck(elemento);      
	},

	guardar	 : function ()
	{		
		// var formData = new FormData($("#registroUsuario")[0]);
		console.log(this.$('#foto').val());
		// var foto = this.urlFoto(formData); 

		// var modeloUsuario = pasarAJson($('#registroUsuario').serializeArray());
		// modeloUsuario.foto = foto;
		// modeloUsuario = limpiarJSON(modeloUsuario);
		

		// modeloUsuario.idpermisos = JSON.stringify({idpermisos:modeloUsuario.idpermisos});
		// $('#registroUsuario')[0].reset();
		// Backbone.emulateHTTP = true;
		// Backbone.emulateJSON = true;
		// app.coleccionUsuarios.create
		// (
		// 	{
		// 		idempleado  : modeloUsuario.idempleado,
		// 		idperfil    : modeloUsuario.idperfil,
		// 		usuario     : modeloUsuario.usuario,
		// 		contrasenia : modeloUsuario.contrasenia,
		// 		foto        : foto,
		// 		idpermisos  : modeloUsuario.idpermisos
		// 	},
		// 	{
		// 		wait	: true,
		// 		success : function (exito) { location.href='usuarios_consulta'; },
		// 		error 	: function (error) {}
		// 	}
		// );
		// Backbone.emulateHTTP = false;
		// Backbone.emulateJSON = false;
		
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