var app = app || {};

app.ModeloPermiso = Backbone.Model.extend({
	urlRoot	:root+'/api_permisos'
});

var ColeccionPermisos = Backbone.Collection.extend({
	url: location.origin+'/api_permisos',
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
	
