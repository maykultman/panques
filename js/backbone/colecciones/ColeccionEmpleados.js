var app = app || {};

var ColeccionEmpleados = Backbone.Collection.extend({
	model	: app.ModeloEmpleado,

	// localStorage	: new Backbone.LocalStorage('clientes-backbone'),
	url: 'http://qualium.mx/sites/crmqualium/api_empleados',

	obtenerTodos : function () {
		return this.filter( function (empleado){
			return empleado.get('id');
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
	// 		app.busquedaEmpleados.empleado.buscarPorNombre(options.data.nombreComercial).done(function (data) {
	// 			// console.log(data); //Debuelbe el objeto [Object]
	// 			options.success(data);
	// 		});
	// 	};
	// }
});

app.coleccionEmpleados = new ColeccionEmpleados(app.coleccionDeEmpleados);