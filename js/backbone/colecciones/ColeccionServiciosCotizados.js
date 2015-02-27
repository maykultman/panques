var app = app || {};

var ColeccionServiciosCotizados = Backbone.Collection.extend({
	url 	:location.origin+'/api_servicioCotizado',
	model	: app.ModeloServicioCotizado,
	

	// parse	: function (response) {
	// 	return response.data;
	// },
});

app.coleccionServiciosCotizados = new ColeccionServiciosCotizados(app.coleccionDeServiciosCotizados);