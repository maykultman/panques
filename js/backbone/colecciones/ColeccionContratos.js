var app = app || {};
var f = new Date();
app.ModeloContrato	= Backbone.Model.extend({
	urlRoot	: 'http://crmqualium.com/api_contratos',
	defaults	: {
		fechacreacion : f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate()
	}
});
app.ModeloContrato_L	= Backbone.Model.extend({
	defaults	: {
		fechacreacion : f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate()
	}
});

var ColeccionContratos = Backbone.Collection.extend({
	model			: app.ModeloContrato_L,
	url 	: 'http://crmqualium.com/api_contratos',
});

var ColeccionContratos_LocalStorage = ColeccionContratos.extend({
	model			: app.ModeloContrato,
	localStorage 	: new Backbone.LocalStorage('contratos-backbone'),
	ordenSiguente	: function () {
		if (!this.length) {
			return 1;
		};
		return this.last().get('id') + 1;
	}
});