var app = app || {};

var ColeccionUsuarios = Backbone.Collection.extend({
	url 	:'http://crmqualium.com/api_usuarios',
	model	: app.ModeloUsuario,

});

app.coleccionUsuarios = new ColeccionUsuarios(app.coleccionDeUsuarios);