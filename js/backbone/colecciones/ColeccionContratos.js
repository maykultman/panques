var app = app || {};
var f = new Date();
app.ModeloContrato	= Backbone.Model.extend({
	urlRoot	: 'http://crmqualium.com/api_contratos',
	defaults	: {
		fechacreacion : f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate()
	}
});

var ColeccionContratos_LocalStorage = Backbone.Collection.extend({
	model			: app.ModeloContrato,
	localStorage 	: new Backbone.LocalStorage('ColeccionContratos_LocalStorage-backbone'),
	ordenSiguente	: function () {
		if (!this.length) {
			return 1;
		};
		return this.last().get('id') + 1;
	}
});