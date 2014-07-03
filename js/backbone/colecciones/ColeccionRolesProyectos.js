var app = app || {};

var ColeccionRolesProyectos = Backbone.Collection.extend({
	
	model	: app.ModeloRolProyecto,

	url: 'http://qualium.mx/sites/crmqualium/api_rolesDeProyecto',
	// localStorage	: new Backbone.LocalStorage('proyectos-backbone'),

	// obtenerTodos : function () {
	// 	return this.filter( function (proyecto){
	// 		return proyecto.get('id');
	// 	});
	// },

	obtenerUltimoId	: function () {
		return this.last().get('id');
	},

	// obtenerUltimo	: function () {
	// 	return this.last();
	// }
});

