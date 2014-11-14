var app = app || {};
var f = new Date();
app.ModeloContrato	= Backbone.Model.extend({
	urlRoot	: 'http://crmqualium.com/api_contratos',
	defaults	: {
		fechacreacion : f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate()
	}
});

var ColeccionContratos = Backbone.Collection.extend({
	model			: app.ModeloContrato,
	url 	: 'http://crmqualium.com/api_contratos',
	parse : function (response) {
		this.folio = response.folio.folio;

		return response.contratos;
	},
	establecerFolio : function () {
		try {
			return this.folio;
		}
		catch(err) {
			return 'A001';
		}
	}
});
/*---------------------------------------------------------------------------------*/
app.ModeloContrato_L	= Backbone.Model.extend({
	defaults	: {
		fechacreacion : f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate()
	}
});

var ColeccionContratos_LocalStorage = ColeccionContratos.extend({
	model			: app.ModeloContrato_L,
	localStorage 	: new Backbone.LocalStorage('contratos-backbone'),
	ordenSiguente	: function () {
		if (!this.length) {
			return 1;
		};
		return this.last().get('id') + 1;
	}
});