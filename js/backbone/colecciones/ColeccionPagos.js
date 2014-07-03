var app = app || {};
app.ModeloPago	= Backbone.Model.extend({
	urlRoot	: 'http://qualium.mx/sites/crmqualium/api_pagos'
});
var ColeccionPagos= Backbone.Collection.extend({
	model	: app.ModeloPago,
<<<<<<< HEAD
	url		: 'http://qualium.mx/sites/crmqualium/api_pagos'
=======
	url		: 'http://crmqualium.com/api_pagos'
});

var ColeccionPagos= Backbone.Collection.extend({
	model	: app.ModeloPago,
	localStorage 	: new Backbone.LocalStorage('ColeccionPagos_LocalStorage-backbone'),
	ordenSiguente	: function () {
		if (!this.length) {
			return 1;
		};
		return this.last().get('id') + 1;
	}
>>>>>>> 0c7427cbc3821cb301bd08cd83dbeb9fac354be3
});