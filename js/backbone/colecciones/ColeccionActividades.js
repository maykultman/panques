app.ModeloEvento = Backbone.Model.extend({
	urlRoot : 	'http://crmqualium.com/api_actividades',
	update 	: function (json) {
		return this.save(json, {
			wait 	: true,
			patch 	: true
		});
	},
	delete : function () {
		return this.destroy({ wait	: true });
	}
});
var ColeccionActividades = Backbone.Collection.extend({
	model 	: app.ModeloEvento,
	url 	: 	'http://crmqualium.com/api_actividades'
});