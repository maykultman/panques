var app = app || {};

var ColeccionServiciosCotizados = Backbone.Collection.extend({
	url 	:'http://crmqualium.com/api_servicioCotizado',
	model	: app.ModeloServicioCotizado,
	

	// parse	: function (response) {
	// 	return response.data;
	// },
});

app.coleccionServiciosCotizados = new ColeccionServiciosCotizados(app.coleccionServiciosCotizados);