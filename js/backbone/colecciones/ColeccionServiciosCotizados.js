var app = app || {};

var ColeccionServiciosCotizados = Backbone.Collection.extend({
	url 	:'http://qualium.mx/sites/crmqualium/api_servicioCotizado',
	model	: app.ModeloServicioCotizado,
	

	// parse	: function (response) {
	// 	return response.data;
	// },
});

app.coleccionServiciosCotizados = new ColeccionServiciosCotizados(app.coleccionServiciosCotizados);