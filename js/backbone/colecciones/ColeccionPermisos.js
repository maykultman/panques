var app = app || {};

var ColeccionPermisos = Backbone.Collection.extend({
	url: 'http://qualium.mx/sites/crmqualium/api_permisos',
	model	: app.ModeloPermiso,

	sync	: function (method, model, options) {
		if (method === 'read') {
			app.busquedaPermiso.permiso.buscarPorNombre(options.data.nombre).done(function (data) {
				// console.log(data); //Debuelbe el objeto [Object]
				options.success(data);
			});
		};
	}

});

app.coleccionPermisos = new ColeccionPermisos(app.coleccionDePermisos);
	
