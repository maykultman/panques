var app = app || {};

var ColeccionPermisosUsuario = Backbone.Collection.extend({
	url 	:'http://qualium.mx/sites/crmqualium/api_permisoUsuario',
	model	: app.ModeloPermisoUsuario,

});

app.coleccionPermisosUsuario = new ColeccionPermisosUsuario(app.ColeccionDePermisosUsuario);