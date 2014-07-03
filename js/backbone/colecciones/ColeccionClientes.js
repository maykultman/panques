var app = app || {};

var ColeccionClientes = Backbone.Collection.extend({
	model	: app.ModeloCliente,

	// localStorage	: new Backbone.LocalStorage('clientes-backbone'),
	url: 'http://qualium.mx/sites/crmqualium/api_cliente',

	obtenerTodos : function () {
		return this.filter( function (cliente){
			return cliente.get('id');
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
	// 	return response;
	// },

	obtenerUltimo	: function () {
		return this.last();
	},

	/*Descomentar antes de subir a git, debe arregarse que se pueda utilizar en cualquier módulo*/
	sync	: function (method, model, options) {
		if (method === 'read') {
			app.busquedaCliente.cliente.buscarPorNombre(options.data.nombreComercial).done(function (data) {
				// console.log(data); //Debuelbe el objeto [Object]
				options.success(data);
			});
		};
	}
});

app.coleccionClientes = new ColeccionClientes(app.coleccionDeClientes);

