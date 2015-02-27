var app = app || {};

app.ModeloUsuario = Backbone.Model.extend({
	urlRoot	:location.origin+'/api_usuarios'
});

var ColeccionUsuarios = Backbone.Collection.extend({
	url 	:location.origin+'api_usuarios',
	model	: app.ModeloUsuario,

});

app.coleccionUsuarios = new ColeccionUsuarios(app.coleccionDeUsuarios);

// function globaltrue()
// {
//     Backbone.emulateHTTP = true;//Variables Globales
//     Backbone.emulateJSON = true;//Variables Globales
// }
// function globalfalse()
// {
//     Backbone.emulateHTTP = false;//Variables Globales
//     Backbone.emulateJSON = false;//Variables Globales
// }