var app = app || {};

var ColeccionRepresentantes = Backbone.Collection.extend({
	model	: app.ModeloRepresentante,

	//localStorage	: new Backbone.LocalStorage('contactos-backbone'),
	url 	:'http://crmqualium.com/api_representante',

	obtenerTodos : function () {
		return this.filter( function (representante){
			return representante.get('id');
		});
	},

	/*establecerIdSiguiente	: function () {
		if(!this.length){
			return 1;
		}
		return this.last().get('idContacto') + 1;
	}*/
});

app.coleccionRepresentantes = new ColeccionRepresentantes(app.coleccionDeRepresentantes);
