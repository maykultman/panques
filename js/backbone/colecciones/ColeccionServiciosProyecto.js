var app = app || {};

var ColeccionServiciosProyecto = Backbone.Collection.extend({
	model	: app.ModeloServicioProyecto,

	// localStorage	: new Backbone.LocalStorage('clientes-backbone'),
	url: 'http://qualium.mx/sites/crmqualium/api_serviciosProyecto',

	obtenerTodos : function () {
		return this.filter( function (serProy){
			return serProy.get('id');
		});
	},

	/*establecerIdSiguiente	: function () {
		if(!this.length){
			return 1;
		}
		return this.last().get('id') + 1;
	},*/

	obtenerUltimoId	: function () {
		return this.last().get('id');
	},

	// parse	: function (response) {
	// 	return response.data;
	// },

	obtenerUltimo	: function () {
		return this.last();
	},

	// sync	: function (method, model, options) {
	// 	if (method === 'read') {
	// 		app.busquedaCliente.cliente.buscarPorNombre(options.data.nombreComercial).done(function (data) {
	// 			// console.log(data); //Debuelbe el objeto [Object]
	// 			options.success(data);
	// 		});
	// 	};
	// }
});