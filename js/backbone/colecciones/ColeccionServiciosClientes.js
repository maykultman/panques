var app = app || {};

ColeccionServiciosClientes = Backbone.Collection.extend({
	model	: app.ModeloServicioCliente,

	obtenerTodos : function () {
		return this.filter( function (servicio){
			return servicio.get('id');
		});
	},

	// establecerIdSiguiente	: function () {
	// 	if(!this.length){
	// 		return 1;
	// 	}
	// 	return this.last().get('id') + 1;
	// }

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
	// 		app.busquedaServicio.servicio.buscarPorNombre(options.data.nombre).done(function (data) {
	// 			// console.log(data); //Debuelbe el objeto [Object]
	// 			options.success(data);
	// 		});
	// 	};
	// }
});
// app.c = 'new ColeccionServiciosClientes(app.coleccionDeServiciosI)';
var ColeccionServiciosClientesI = ColeccionServiciosClientes.extend({
	url 	:'http://qualium.mx/sites/crmqualium/api_serviciosInteres',
});
var ColeccionServiciosClientesC = ColeccionServiciosClientes.extend({
	url 	:'http://qualium.mx/sites/crmqualium/api_serviciosCliente',
});

app.coleccionServiciosClientesI = new ColeccionServiciosClientesI(app.coleccionDeServiciosI);
app.coleccionServiciosClientesC = new ColeccionServiciosClientesC(app.coleccionDeServiciosC);