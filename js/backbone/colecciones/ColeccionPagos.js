var app = app || {};
app.ModeloPago	= Backbone.Model.extend({
	urlRoot	: 'http://crmqualium.com/api_pagos'
});


var ColeccionPagos= Backbone.Collection.extend({
	model	: app.ModeloPago,
	url		: 'http://crmqualium.com/api_pagos'
});
/*---------------------------------------------------------------*/
app.ModeloPago_L	= Backbone.Model.extend({
});

var ColeccionPagos_LocalStorage = Backbone.Collection.extend({
	model	: app.ModeloPago_L,
	localStorage 	: new Backbone.LocalStorage('pagos-backbone'),
	ordenSiguente	: function () {
		if (!this.length) {
			return 1;
		};
		return this.last().get('id') + 1;
	}
});