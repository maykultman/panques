app.ModeloEvento = Backbone.Model.extend({
	urlRoot : 	'http://crmqualium.com/api_actividades',
	update 	: function (json) {
		this.save(json,{
			wait 	: true,
			success : function (model) {
				ok('Evento actualizado');
			},
			error 	: function (model) {
				error('Error al intentar actualizar el evento');
			}
		});
	}
});
var ColeccionActividades = Backbone.Collection.extend({
	model 	: app.ModeloEvento,
	url 	: 	'http://crmqualium.com/api_actividades'
});