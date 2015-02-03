app.ModeloActicidad = Backbone.Model.extend({
	urlRoot 	: 	'http://crmqualium.com/api_actividades',
	// defaults 	: {}
});
var ColeccionActividades = Backbone.Collection.extend({
	model 	: app.ModeloActicidad,
	url 	: 	'http://crmqualium.com/api_actividades'
});