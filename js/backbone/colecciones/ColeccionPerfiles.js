var app = app || {};

var ColeccionPerfiles = Backbone.Collection.extend({
	url: 'http://crmqualium.com/api_perfil',
	model	: app.ModeloPerfil,
});

app.coleccionPerfiles = new ColeccionPerfiles(app.coleccionDePerfiles);
	
