var app = app || {};
var f = new Date();
app.ModeloContrato	= Backbone.Model.extend({
	urlRoot	: 'http://qualium.mx/sites/crmqualium/api_contratos',
	defaults	: {
		fechacreacion : f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate()
	}
});
var ColeccionContratos = Backbone.Collection.extend({
	model	: app.ModeloContrato,
<<<<<<< HEAD
	url		: 'http://qualium.mx/sites/crmqualium/api_contratos'
=======
	url		: 'http://crmqualium.com/api_contratos'
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

>>>>>>> 0c7427cbc3821cb301bd08cd83dbeb9fac354be3
});