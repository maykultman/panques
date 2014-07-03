var app = app || {};
app.ModeloServicioContrato	= Backbone.Model.extend({
	urlRoot	: 'http://qualium.mx/sites/crmqualium/api_serviciosContrato'
});
var ColeccionServiciosContrato = Backbone.Collection.extend({
	model	: app.ModeloServicioContrato,
<<<<<<< HEAD
	url		: 'http://qualium.mx/sites/crmqualium/api_serviciosContrato'
=======
	url		: 'http://crmqualium.com/api_serviciosContrato'
});

var ColeccionServiciosContrato_LocalStorage = Backbone.Collection.extend({
	model			: app.ModeloServicioContrato,
	localStorage 	: new Backbone.LocalStorage('ColeccionServiciosContrato_LocalStorage-backbone'),
	ordenSiguente	: function () {
		if (!this.length) {
			return 1;
		};
		return this.last().get('id') + 1;
	}
>>>>>>> 0c7427cbc3821cb301bd08cd83dbeb9fac354be3
});