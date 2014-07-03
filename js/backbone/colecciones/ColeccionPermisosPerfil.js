var app = app || {};

var ColeccionPermisosPerfil = Backbone.Collection.extend({
	url   : 'http://crmqualium.com/api_permisoPerfil',
	model :  app.ModeloPermisoPerfil
	
});

app.coleccionPermisosPerfil = new ColeccionPermisosPerfil(app.coleccionDePermisosPerfil);