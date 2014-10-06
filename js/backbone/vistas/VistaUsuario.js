var app = app || {};

// app.VistaPermiso = app.VistaRenderizaPermiso.extend({
	
// 	plantilla : Handlebars.compile($('#Permisos').html()),
// 	events : {
// 		'change .chek' : 'resalta'
// 	},

// 	resalta : function()
// 	{
// 		if(this.$el.children().is(':checked'))
// 		{
// 			this.$el.css('background','#ddffdd');
// 			this.$el.css('border-radius','5px');
// 		}else
// 		{
// 			this.$el.css('background','#fff');
// 		}		
// 	}
// });

app.VistaUsuario = Backbone.View.extend({
	tagName : 'article',
	className : 'user-wrapper',//'panel panel-default',
	plantilla : Handlebars.compile($('#usuario').html()),
	modal  : Handlebars.compile($('#edicion').html()),
	
	events : {
		'click button.edit'	    : 'modaledit', // Abre el modal para la edición del usuario
		'click button.guardar'  : 'editar',		
		// 'click button.cancelar' : 'editar',
		'change #idperfil'	    : 'getpermisos',
		// 'click .close' 			: 'editar'
	},

	render : function (){

		this.$el.html(this.plantilla(this.model.toJSON()));	

		// this.cargarPermisos(this.model.toJSON().idpermisos);
		return this;
	},

	cargarSelectPerfil : function (perfil)
	{
		var vistaPerfil = new app.VistaSelectPerfil({ model : perfil });
		this.$('#idperfil').append(vistaPerfil.render().el);	
	},

	cargarSelectPerfiles : function (callback) 
	{ 
		this.$("#idperfil").html('');
		app.coleccionPerfiles.each(this.cargarSelectPerfil, this); callback(); 
	},

	// cargarPermiso : function(permiso)
	// {
	// 	var vistaPermiso = new app.VistaPermiso({ model : permiso});
	// 	this.$('#ListaPermisos').append(vistaPermiso.render().el);
	// },

	// cargarPermisos : function(mispermisos)
	// {
	// 	app.coleccionPermisos.each(this.cargarPermiso, this);
	// },

	// getpermisos : function(e)
	// {
	// 	e.preventDefault();
	// 	// Lo primero es obtener el id del perfil que nos devuelve el select
	// 	var perfil_id = $(e.currentTarget).val();
	// 	// Ahora buscamos los permisos del id obtenido en la coleccion
	// 	var permisos = app.coleccionPerfiles.findWhere({ 'id' : perfil_id}).get('idpermisos');
	// 	// como tercer paso traemos los permisos que contiene el modelo actual
	// 	var mis_permisos = this.model.get('idpermisos');
	// 	// Como los permisos regresan como un json pero en formato de cadena hay que regresarlo a formato json.
	// 	mis_permisos = jQuery.parseJSON(mis_permisos);
	// 	permisos = jQuery.parseJSON(permisos);

	// 	// Ahora con la funcion union de underscore fusionamos los permisos anteriores con los nuevos
	// 	// Pasandole los arrays json que acabamos de convertir
	// 	var union_permisos = _.union(permisos['idpermisos'], mis_permisos['idpermisos']);
	// 	// Hacemos un reset al html de ListaPermisos
	// 	this.$('#ListaPermisos').html('');
	// 	// llamamos a la funcion que pintra los permisos de verde y los deja en checked.
	// 	this.chekea_permisos(union_permisos);		
	// },

	// chekea_permisos : function(permisos)
	// {
	// 	this.$("#ListaPermisos").html('');
	// 	this.cargarPermisos();
	// 	if(this.model.get('idpermisos'))
	// 	{
	// 		marcarPermiso(	permisos, 
	// 						this.$el.find('.chek').children(), 
	// 						this.$el
	// 					 );	
	// 	}
	// },

	modaledit :function()
	{
		// Pasamos el modelo a formato json para poder representarlo en la plantilla
		this.$el.append(this.modal(this.model.toJSON()));

		// Buscamos un nodo en el DOM que tenga el id ideperfil
		var select_Perfil = this.$el.find('#idperfil');
		var usuario = this.model;
		this.cargarSelectPerfiles(function() 
		{	/*... Se le hace selected al puesto que le pertenece al modelo y desactiva el click...*/
			$(select_Perfil).children('#per'+usuario.get('idperfil')).attr('disabled', true).attr('selected', 'selected');
		});

		this.chekea_permisos(JSON.parse(this.model.get('idpermisos')).idpermisos);

		var mimodal = this.$el.find('#myModal'+this.model.get('id'));
		
		var here = this;
		mimodal.on('hidden.bs.modal', function()
		{
		 	this.remove();
		 	here.render();
		});

		mimodal = this.$el.find('#myModal'+this.model.get('id'));
		mimodal.modal({
			keybooard :false,
			backdrop  :false
		});

		function runEffect() 
	    {
	    	var options = { to: { width: 200, height: 60 }};
		      	// run the effect
		 	this.$( "#effect" ).toggle( 'blind', options, 500 );
	    };
	 
	    // set effect from select menu value
	    this.$('#togle').click(function() {  runEffect(); });
		
	},

	// editar : function(events)
	// {	
	// 	var mimodal = this.$el.find('#myModal'+this.model.get('id'));
	// 	// mimodal.modal('hide');

	// 	var here = this;
	// 	mimodal.on('hidden.bs.modal', function()
	// 	{
	// 	 	this.remove();
	// 	 	here.render();
	// 	});

	


	// 	// var modeloUsuario = pasarAJson( $('#edicionUsuario'+this.model.get('id')).serializeArray());
	// 	// console.log(modeloUsuario);
	// 	// modeloUsuario.idpermisos = JSON.stringify( pasarAJson($('#permisoz'+this.model.get('id')).serializeArray()) );
	// 	// var self = this;
	// 	// this.model.save
	// 	// (
	// 	// 	modeloUsuario, 
	// 	// 	{
	// 	// 		wait:true,
	// 	// 		patch:true,
	// 	// 		success: function (exito)
	// 	// 		{
	// 	// 			$('#t_usuario'+exito.get('id')).text(modeloUsuario.usuario);
	// 	// 		}, 
	// 	// 		error: function (error){}
	// 	// 	}
	// 	// );
				
	// }
});


// app.VistaUsuario = Backbone.View.extend({
// 	tagName : 'div',
// 	className : 'panel panel-default',
// 	plantilla : Handlebars.compile($('#usuario').html()),
// 	events : {
// 		'click #guardar'    : 'editar',
// 	},

// 	render : function (){

// 		this.$el.html(this.plantilla(this.model.toJSON()));		
// 		var select_Perfil = this.$el.find('#perfil');
// 		var usuario = this.model;
// 		this.cargarSelectPerfiles(function() 
// 		{	/*... Se le hace selected al puesto que le pertenece al modelo y desactiva el click...*/
// 			$(select_Perfil).children('#per'+usuario.get('idperfil')).attr('disabled', true).attr('selected', 'selected');				
// 		});
// 		this.cargarPermisos();
			
// 		if(this.model.get('idpermisos'))
// 		{
// 			marcarPermiso(	JSON.parse(this.model.get('idpermisos')).idpermisos, 
// 							this.$el.find('.chek').children(), 
// 							this.$el
// 						 );	
// 		}
// 		return this;
// 	},

// 	cargarSelectPerfil : function (perfil)
// 	{
// 		var vistaPerfil = new app.VistaSelectPerfil({ model : perfil });
// 		this.$('#idperfil').append(vistaPerfil.render().el);	
// 	},

// 	cargarSelectPerfiles : function (callback) 
// 	{ 
// 		app.coleccionPerfiles.each(this.cargarSelectPerfil, this); callback(); 
// 	},

// 	cargarPermiso : function(permiso)
// 	{   
// 		var vistaPermiso = new app.VistaPermiso({ model : permiso });
// 		this.$('#ListaPermisos').append(vistaPermiso.render().el);	
// 	},

// 	cargarPermisos : function()
// 	{
// 		app.coleccionPermisos.each(this.cargarPermiso, this);
// 	},

// 	editar : function(events)
// 	{	
// 		var modeloUsuario = pasarAJson( $('#edicionUsuario'+this.model.get('id')).serializeArray());
// 		modeloUsuario.idpermisos = JSON.stringify( pasarAJson($('#permisoz'+this.model.get('id')).serializeArray()) );
// 		var self = this;
// 		this.model.save
// 		(
// 			modeloUsuario, 
// 			{
// 				wait:true,
// 				patch:true,
// 				success: function (exito)
// 				{
// 					$('#t_usuario'+exito.get('id')).text(modeloUsuario.usuario);
// 				}, 
// 				error: function (error){}
// 			}
// 		);
// 		events.preventDefault();		
// 	}
// });
