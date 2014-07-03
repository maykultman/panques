var app = app || {};
app.VistaConsultaPerfil = Backbone.View.extend
({
	el : '#accordion',
	
	events : {},

	initialize : function()
	{
		this.$ConsultaPerfil = this.$('#unperfil');
		this.cargarPerfiles();
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
	}

});

app.vistaConsultaPerfil = new app.VistaConsultaPerfil();