var app = app || {};

app.VistaConsultaUsuario = Backbone.View.extend({
	el : '#consultaDeUsuarios',

	initialize : function()
	{
		this.$divVistaUsuario = this.$('#accordion');
		this.cargarUsuarios();
	},

	render : function() { return this; },

	cargarUsuario : function(modelo)
	{		             
		modelo.set({ empleado : app.coleccionEmpleados.get
			      ({ id       : modelo.get('idempleado')   }).get('nombre') });
		
		var vistaUsuario = new app.VistaUsuario({ model : modelo });
		this.$divVistaUsuario.append(vistaUsuario.render().el);
	},

	cargarUsuarios : function()
	{
		app.coleccionUsuarios.each(this.cargarUsuario, this);
		var leyenda = "Sin usuarios";
		if  (app.coleccionDeUsuarios.length==1) {	leyenda = ' Usuario' ; }
		else								    {	leyenda = ' Usuarios'; }

		$('#cantidadDeUsuarios').text(app.coleccionDeUsuarios.length+leyenda);
	}
});

app.vistaConsultaUsuario = new app.VistaConsultaUsuario();