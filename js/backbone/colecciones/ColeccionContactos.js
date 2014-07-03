var app = app || {};

var ColeccionContactos = Backbone.Collection.extend({
	model	: app.ModeloContacto,

	//localStorage	: new Backbone.LocalStorage('contactos-backbone'),
	url 	:'http://qualium.mx/sites/crmqualium/api_contactos',

	obtenerTodos : function () {
		return this.filter( function (contacto){
			return contacto.get('id');
		});
	},

	/*establecerIdSiguiente	: function () {
		if(!this.length){
			return 1;
		}
		return this.last().get('idContacto') + 1;
	},*/

	// parse	: function (response) {
	// 	return response.data;
	// },
});

app.coleccionContactos = new ColeccionContactos(app.coleccionDeContactos);
