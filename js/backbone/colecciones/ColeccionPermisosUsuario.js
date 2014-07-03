var app = app || {};

var ColeccionPermisosUsuario = Backbone.Collection.extend({
	url 	:'http://crmqualium.com/api_permisoUsuario',
	model	: app.ModeloPermisoUsuario,

});

app.coleccionPermisosUsuario = new ColeccionPermisosUsuario(app.ColeccionDePermisosUsuario);