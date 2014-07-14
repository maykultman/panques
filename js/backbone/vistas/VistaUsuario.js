var app = app || {};

app.VistaPermiso = app.VistaRenderizaPermiso.extend({

	plantilla : Handlebars.compile($('#Permisos').html()),
	events : {
		'change .chek' : 'resalta'
	},

	resalta : function()
	{
		if(this.$el.children().is(':checked'))
		{
			this.$el.css('background','#ddffdd');
			this.$el.css('border-radius','5px');
		}else
		{
			this.$el.css('background','#fff');
		}		
	}
});

app.VistaUsuario = Backbone.View.extend({
	tagName : 'div',
	className : 'panel panel-default',
	plantilla : Handlebars.compile($('#usuario').html()),
	events : {
		'click #guardar'    : 'editar',
	},

	render : function (){

		this.$el.html(this.plantilla(this.model.toJSON()));		
		var select_Perfil = this.$el.find('#perfil');
		var usuario = this.model;
		this.cargarSelectPerfiles(function() 
		{	/*... Se le hace selected al puesto que le pertenece al modelo y desactiva el click...*/
			$(select_Perfil).children('#per'+usuario.get('idperfil')).attr('disabled', true).attr('selected', 'selected');				
		});
		this.cargarPermisos();
			
		if(this.model.get('idpermisos'))
		{
			marcarPermiso(	JSON.parse(this.model.get('idpermisos')).idpermisos, 
							this.$el.find('.chek').children(), 
							this.$el
						 );	
		}
		return this;
	},

	cargarSelectPerfil : function (perfil)
	{
		var vistaPerfil = new app.VistaSelectPerfil({ model : perfil });
		this.$('#idperfil').append(vistaPerfil.render().el);	
	},

	cargarSelectPerfiles : function (callback) 
	{ 
		app.coleccionPerfiles.each(this.cargarSelectPerfil, this); callback(); 
	},

	cargarPermiso : function(permiso)
	{   
		var vistaPermiso = new app.VistaPermiso({ model : permiso });
		this.$('#ListaPermisos').append(vistaPermiso.render().el);	
	},

	cargarPermisos : function()
	{
		app.coleccionPermisos.each(this.cargarPermiso, this);
	},

	editar : function(events)
	{	
		var modeloUsuario = pasarAJson( $('#edicionUsuario'+this.model.get('id')).serializeArray());
		modeloUsuario.idpermisos = JSON.stringify( pasarAJson($('#permisoz'+this.model.get('id')).serializeArray()) );
		var self = this;
		this.model.save
		(
			modeloUsuario, 
			{
				wait:true,
				patch:true,
				success: function (exito)
				{
					$('#t_usuario'+exito.get('id')).text(modeloUsuario.usuario);
				}, 
				error: function (error){}
			}
		);
		events.preventDefault();		
	}
});