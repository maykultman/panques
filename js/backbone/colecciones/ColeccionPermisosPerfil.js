var app = app || {};

var ColeccionPermisosPerfil = Backbone.Collection.extend({
	url   : 'http://qualium.mx/sites/crmqualium/api_permisoPerfil',
	model :  app.ModeloPermisoPerfil
	
});

app.coleccionPermisosPerfil = new ColeccionPermisosPerfil(app.coleccionDePermisosPerfil);