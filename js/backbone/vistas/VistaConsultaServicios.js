var app = app || {};

app.VistaConsultaServicios = Backbone.View.extend({
	el : '#consulta_servicios',

	events	: {},

	initialize	: function () {
		this.$tablaServicios = this.$('#consulta_tablaservicio');
		this.cargarServicios();
		this.listenTo( app.coleccionServicios, 'add', this.cargarServicio );
	    this.listenTo( app.coleccionServicios, 'reset', this.cargarServicios );

		// app.coleccionServicios.fetch();
	},

	render	: function () {},

	cargarServicio	: function (modelodeladd) {
		var vistaCatalogoServicio = new app.VistaCatalogoServicio( { model:modelodeladd } );
		this.$tablaServicios.append( vistaCatalogoServicio.render().el );
	},

	cargarServicios	: function () {
		app.coleccionServicios.each(this.cargarServicio, this);
	}
});

app.vistaConsultaServicios = new app.VistaConsultaServicios();