var app = app || {};

app.VistaNuevoUsuario = Backbone.View.extend({
	el : '#datosUsuario',

	events : {
		'click #guardar'    : 'guardar',
		// 'click #empleado'   : 'buscarEmpleado',
		// 'blur  #empleado'   : 'Aidempleado',
		// 'keypress #empleado': 'soloLetras',
		// 'change #idperfil'  : 'mostrarPermisos',
		// 'change #idpermisos' : 'marcarTodos'
		'click #togle' : 'resize',

	},

	initialize : function ()
	{	
		this.$per = this.$("#moduloss");
		this.active = 1;
		this.cargarSelectPerfiles();
		this.cargarPermisos();	
		this.selectEmpleados();

		this.mod;
        
	},

	resize : function(elemento)
	{
		var efect = $(elemento.currentTarget).attr('class');
		// var efect = $("#effect"+this.mod).attr('id');
		// console.log(efect);
		// var options = { to: { width: 200, height: 60 }};
		// run the effect|
		// efect.toggle( 'blind', options, 500 );
	},

	render : function()	{	return this; },

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
    },

    selectEmpleados : function()
    {
    	var list = '<% _.each(empleados, function(empleado) { %> <option disabled id="<%- empleado.id %>" value="<%- empleado.id %>"><%- empleado.nombre %></option> <% }); %>';
		this.$('.semp').
		append(_.template(list, 
			{ empleados : app.coleccionEmpleados.toJSON() }
		));
		this.$('.semp').selectize({
			create: true,
			maxItems: 1
		});
    },

	cargarPermiso : function(permiso)
	{
		
		var vistaPermiso = new app.VistaRenderizaPermiso({model : permiso.toJSON()});	
		this.$per.append(vistaPermiso.render().el);
		// var perm = permiso.get('permisos');
		//  if(perm)
		//  {
		//  	var resp = jQuery.parseJSON(perm);	
		//  }
		
		// var modelo = {};

		// modelo.id 	  =	permiso.get('id');
		// modelo.modulo = permiso.get('modulo');
		
		// var div ={};
		// div = this.html(modelo.modulo, modelo.id);
		// if(this.active==1)
		// {
		// 	$("#submodulos").html('<div class="tab-pane active" id='+modelo.modulo+'>'+div[0]+div[1]+div[2]+div[3]+'</div>');
		// 	this.active++;
		// }
		// else
		// {
		// 	$("#submodulos").append('<div class="tab-pane" id='+modelo.modulo+'>'+div[0]+div[1]+'</div></div>');		
		// } 

	},


	html : function (modulo)
	{
		var div = {};
		// var chekbox = '<input name="idpermisos" class="chek" class="chek" value="<%-id%>" type="checkbox">Crear<input name="idpermisos" class="chek" value="<%-id%>" type="checkbox">Leer<input name="idpermisos" class="chek" value="<%-id%>" type="checkbox">Editar<input name="idpermisos" class="chek" value="<%-id%>" type="checkbox">Eliminar';
		var chekbox = '<input name="idpermisos" class="chek" value="<%-id%>" type="checkbox">Leer<input name="idpermisos" class="chek" value="<%-id%>" type="checkbox">Editar<input name="idpermisos" class="chek" value="<%-id%>" type="checkbox">Eliminar';
		if(modulo=='clientes')
		 {
		 	div[0] ='<div id='+modulo+'><div id="togle" class="tohead">Nuevo</div><div id="effectclientes"            class="contenido" style="display:none;"><input name="idpermisos" class="chek" value="<%-id%>" type="checkbox">Nuevo</div></div>';
		 	div[1] ='<div id="togle" class="tohead">Prospectos</div><div id="effectprospectos"       class="contenido" style="display:none;">'+chekbox+'</div>';
		 	div[2] ='<div id="togle" class="tohead">Clientes Activos</div><div id="effectactivos" class="contenido" style="display:none;">'+chekbox+'</div>';
		 	div[3] ='<div id="togle" class="tohead">Papelera</div><div id="effectpapelera"         class="contenido" style="display:none;">'+chekbox+'</div>';
		 }
		 else if(modulo=='proyectos')
		 {
		 	div[0] ='<div id="togle" class="tohead">Nuevo</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 	div[1] ='<div id="togle" class="tohead">Proyectos</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 	div[2] ='<div id="togle" class="tohead">Cronograma</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';

		 }
		 else if(modulo=='contratos')
		 {
		 	div[0] ='<div id="togle" class="tohead">Nuevo</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 	div[1] ='<div id="togle" class="tohead">Contratos</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 	// div[2] ='<div id="togle" class="tohead">Clientes Activos</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 }
		 else if(modulo=='cotizaciones')
		 {
		 	div[0] ='<div id="togle" class="tohead">Nuevo</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 	div[1] ='<div id="togle" class="tohead">Cotizaciones</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 	// div[2] ='<div id="togle" class="tohead">Clientes Activos</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 }
		 else if(modulo=='catalogos')
		 {
		 	div[0] ='<div id="togle" class="tohead">Empleados</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 	div[1] ='<div id="togle" class="tohead">Perfiles</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 	div[2] ='<div id="togle" class="tohead">Puestos Activos</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 }else if(modulo=='usuarios')
		 {
		 	div[0] ='<div id="togle" class="tohead">Nuevo</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 	div[1] ='<div id="togle" class="tohead">Consulta Usuarios</div><div id="effect" class="ui-widget-content" style="display:none;">'+chekbox+'</div>';
		 }

		 return div;
	},

	cargarPermisos : function ()
	{	
		app.coleccionPermisos.each(this.cargarPermiso,this);
		$("#moduloss").children(':first-child').addClass('active');	

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

	mostrarPermisos : function(idperfil)
	{
		var nombre = app.coleccionPerfiles.findWhere({id : $(idperfil.currentTarget).val() }).get('idpermisos');
		this.cargarPermisos();
		if(nombre)
		{
			marcarPermiso(JSON.parse(nombre).idpermisos, this.$el.find('.chek').children(), this.$el);	
		}		
	},

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
    }

});

app.vistaNuevoUsuario = new app.VistaNuevoUsuario();