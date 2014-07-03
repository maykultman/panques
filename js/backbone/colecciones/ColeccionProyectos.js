var app = app || {};

var ColeccionProyectos = Backbone.Collection.extend({
	
	model	: app.ModeloProyecto,

	url: 'http://qualium.mx/sites/crmqualium/api_proyectos',
	// localStorage	: new Backbone.LocalStorage('proyectos-backbone'),

	obtenerTodos : function () {
		return this.filter( function (proyecto){
			return proyecto.get('id');
		});
	},

	obtenerUltimoId	: function () {
		return this.last().get('id');
	},

	obtenerUltimo	: function () {
		return this.last();
	},

	// parse	: function (response) {
	// 	return response;
	// },
});

