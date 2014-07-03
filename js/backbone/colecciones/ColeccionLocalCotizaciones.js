var app = app || {};

var ColeccionLocalCotizaciones = Backbone.Collection.extend({
	localStorage 	: new Backbone.LocalStorage('cotizacion'),
	model : app.ModeloLocalCotizacion,
});

app.coleccionLocalCotizaciones = new ColeccionLocalCotizaciones();