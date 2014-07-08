var app = app || {};

var ColeccionLocalCotizaciones = Backbone.Collection.extend({
	localStorage 	: new Backbone.LocalStorage('cotizacion'),
	model : app.ModeloLocalCotizacion,
});

var ColeccionLocalServicios = Backbone.Collection.extend({
	localStorage 	: new Backbone.LocalStorage('servicios'),
	model : app.ModeloLocalServicio,
});

app.coleccionLocalCotizaciones = new ColeccionLocalCotizaciones();
app.coleccionLocalServicios = new ColeccionLocalServicios();