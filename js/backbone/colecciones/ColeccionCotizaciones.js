var app = app || {};

var ColeccionCotizaciones = Backbone.Collection.extend({
	url   : 'http://crmqualium.com/api_cotizaciones',
	model : app.ModeloCotizacion,
	

	// parse : function (response) {
	// 	//Se ejecuta cuando se hace un fetch a la colección
	// 	return response;
	// }

	sync	: function (method, model, options) {
		
	
		if (method === 'read') {

			// if(options.data.idcliente)
			// {
				app.busquedaCotizacion.cotizacion.buscarPorNombre(options.data.idcliente).done(function (data) {
				
				options.success(data);
				});	
			// }
			// if(options.data.idempleado)
			// {
			// 	app.busquedaCotizacion.cotizacion.buscarPorNombre(options.data.idempleado).done(function (data) {
				
			// 	options.success(data);
			// 	});	
			// }
			
		};
	
		
	},
});

app.coleccionCotizaciones = new ColeccionCotizaciones(app.coleccionDeCotizaciones);