var app = app || {};

app.VistaNuevoPerfil = Backbone.View.extend({
	el : '.modal-body',

	events : {
		'click .btn-primary' : 'guardar',
		'change #idpermisos'   : 'marcarTodos'
	},

	initialize : function ()
	{
	    this.$ListaPermisos = this.$('#ListaPermisos');
        this.cargarPermisos();      
	},
	render : function (){ return this; },

	guardar : function (evento)
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
					{},
					error: function (error) {}
				}
			); /*...Create del perfil...*/

			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		} /*...If de modelo Perfil...*/
		
		evento.preventDefault();
	},

	marcarTodos : function(elemento)
	{
		var checkboxTabla = this.$el.find('.chek').children();
       marcarCheck(elemento, checkboxTabla) ;
	},

	cargarPermiso : function (permiso)
	{
		var vistaPermiso = new app.VistaRenderizaPermiso({model : permiso});		
		this.$ListaPermisos.append(vistaPermiso.render().el);
	},
	cargarPermisos : function ()
	{	
		app.coleccionPermisos.each(this.cargarPermiso, this);	
	},

});

app.vistaNuevoPerfil = new app.VistaNuevoPerfil();