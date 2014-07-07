var app = app || {};

var ColeccionCotizaciones = Backbone.Collection.extend({
	url   : 'http://crmqualium.com/api_cotizaciones',
	model : app.ModeloCotizacion,
	
	// parse : function (response) {
	// 	//Se ejecuta cuando se hace un fetch a la colección
	// 	return response;
	// }
});

app.coleccionCotizaciones = new ColeccionCotizaciones(app.coleccionDeCotizaciones);