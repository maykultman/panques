var app = app || {};

var ColeccionPerfiles = Backbone.Collection.extend({
	url: 'http://qualium.mx/sites/crmqualium/api_perfil',
	model	: app.ModeloPerfil,
});

app.coleccionPerfiles = new ColeccionPerfiles(app.coleccionDePerfiles);
	
