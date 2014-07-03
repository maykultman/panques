var app = app || {};

var ColeccionUsuarios = Backbone.Collection.extend({
	url 	:'http://qualium.mx/sites/crmqualium/api_usuarios',
	model	: app.ModeloUsuario,

});

app.coleccionUsuarios = new ColeccionUsuarios(app.coleccionDeUsuarios);