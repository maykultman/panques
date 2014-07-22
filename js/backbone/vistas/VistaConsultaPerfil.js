var app = app || {};
app.VistaConsultaPerfil = Backbone.View.extend
({
	el : '#accordion',
	
	initialize : function()
	{
		this.$ConsultaPerfil = this.$('#unperfil');
		this.cargarPerfiles();
		this.listenTo( app.coleccionPerfiles, 'add',   this.cargarPerfil );
        this.listenTo( app.coleccionPerfiles, 'reset', this.cargarPerfil ); 
        
	}, 

	render : function()
	{
		return this;
	},

	cargarPerfil : function(perfil)
	{
		var vistaPerfil = new app.VistaPerfil({ model : perfil });
		this.$ConsultaPerfil.append(vistaPerfil.render().el);
	},

	cargarPerfiles : function()
	{
		app.coleccionPerfiles.each(this.cargarPerfil, this);	
	},

	eliminar : function()
	{
		this.model.destroy();
	}

});

app.vistaConsultaPerfil = new app.VistaConsultaPerfil();