var app = app || {};
app.ModeloServicioContrato	= Backbone.Model.extend({
	urlRoot	: 'http://crmqualium.com/api_serviciosContrato'
});
var ColeccionServiciosContrato = Backbone.Collection.extend({
	model	: app.ModeloServicioContrato,
	url		: 'http://crmqualium.com/api_serviciosContrato'
});

var ColeccionServiciosContrato_LocalStorage = Backbone.Collection.extend({
	model			: app.ModeloServicioContrato,
	localStorage 	: new Backbone.LocalStorage('serviciosContratos-backbone'),
	ordenSiguente	: function () {
		if (!this.length) {
			return 1;
		};
		return this.last().get('id') + 1;
	}
});