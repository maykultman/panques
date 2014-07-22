var app = app || {};

app.VistaPerfil = Backbone.View.extend({
	tagName : 'div',
	className : 'panel panel-default',

	plantilla : _.template($('#Perfil').html()),

	events : {
		'click #guardarEdicion' : 'editar',
		'click .icon-trash'		: 'destroy'
	},
	initialize : function()
	{
		this.listenTo(this.model, 'destroy', this.remove); 
	},
	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		this.$ListaPermisos = this.$('#ListaPermisos');
        this.cargarPermisos();
        if(this.model.get('idpermisos'))
		{
			this.json = JSON.parse( this.model.get('idpermisos') ).idpermisos;
			marcarPermiso(this.json, this.$el.find('.chek').children(), this.$el);	
		}        
		return this;
	},

	cargarPermiso : function(permiso)
	{
			var vistaPermiso = new app.VistaRenderizaPermiso({ model : permiso });
			this.$ListaPermisos.append(vistaPermiso.render().el);
	},

	cargarPermisos : function(events)
	{
		app.coleccionPermisos.each(this.cargarPermiso, this);	
	},

	editar : function(events)
	{
		var modeloPerfil = JSON.stringify( pasarAJson( $('#idpermisos'+this.model.get('id')).serializeArray()));
		this.model.save
		(
			{ idpermisos : modeloPerfil}, 
			{
				wait:true,
				patch:true,
				success: function (exito){}, 
				error: function (error){}
			}
		);
		events.preventDefault();
	},

	destroy : function()
	{
		this.model.destroy();
	}

});