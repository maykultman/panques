var app = app || {};

var ColeccionTelefonos = Backbone.Collection.extend({
	url 	:'http://crmqualium.com/api_telefonos',
	model	: app.ModeloTelefono,

	// localStorage	: new Backbone.LocalStorage('telefonos-backbone'),
	

	obtenerTodos : function () {
		return this.filter( function (telefono){
			return telefono.get('id');
		});
	},

	establecerIdSiguiente	: function () {
		if(!this.length){
			return 1;
		}
		return this.last().get('id') + 1;
	},

	// parse	: function (response) {
	// 	return response.data;
	// },
});

// app.coleccionTelefonos = new ColeccionTelefonos();
app.coleccionTelefonos = new ColeccionTelefonos(app.coleccionDeTelefonos);
