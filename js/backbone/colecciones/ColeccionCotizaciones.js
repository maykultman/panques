var app = app || {};

app.ModeloCotizacion = Backbone.Model.extend({
	urlRoot : 'http://crmqualium.com/api_cotizaciones',

	// defaults: {
	// 	version : 1,
	// 	status:true,
	// 	visibilidad:true
	// },

	cambiarVisibilidad: function () {
		// this.respuesta = 'no lo pasa';
		this.save({
			visibilidad: !parseInt(this.get('visibilidad'))
		},{
			wait:true, 
			patch:true,
			success	:function (exito) {
				// ok('OK');
			},
			error 	:function (error) {
				if (error.toJSON().visibilidad == '1') {
					error('Error al Eliminar a <b>'+error.toJSON().nombreComercial+'</b>. Intentelo más tarde');
				} else{
					error('Error al Restaurar a <b>'+error.toJSON().nombreComercial+'</b>. Intentelo más tarde');
				};
			}
		});
	},
	cambiarStatus	: function () {
		this.save({
			status: !parseInt(this.get('status'))
		},{
			wait:true, 
			patch:true,
			success	:function (exito) {
				// ok('OK');
			},
			error 	:function (error) {
				if (error.toJSON().status == '1') {
					error('Error al Guardar la nueva versión de <b>'+error.toJSON().titulo+'</b>. Intentelo más tarde');
				} else{
					error('Error al Restaurar la nueva versión de <b>'+error.toJSON().titulo+'</b>. Intentelo más tarde');
				};
			}
		});
	},
	eliminarPermanente: function () {
		var arrayModels, original;
		
		// De  qué cotizacion se trata
		switch(this.get('version')) {
		case '1': // Es una original
			// Buscamos sus versiones
			// Los respaldamos en una variable
	        arrayModels = app.coleccionCotizaciones
	        				.where({idcotizacion:this.get('id')});
	        // Añadimos el original al array
	        arrayModels.push(this);
	        // Recorremos el array para
	        // eliminar cada modelos
        	for (var i = 0; i < arrayModels.length; i++) {
        		console.log(arrayModels.length);
				this.destroy_model(arrayModels[i]);
			};
	        break;
		default: // No es la original
			// Bucamos la original
	        original = app.coleccionCotizaciones
	        			.get(this.get('idcotizacion'));
	        // Buscamos las versiones
			arrayModels = app.coleccionCotizaciones
						.where({idcotizacion:original.get('id')});
			// Incluimos el original al array
			arrayModels.push(original);
			// Eliminamos cada uno de los modelos
	        for (var i = 0; i < arrayModels.length; i++) {
				this.destroy_model(arrayModels[i]);
			};
		}
	},
	destroy_model 	: function (model) {
		model.destroy({
			wait : true,
			success	: function (model) { },
			error	: function () {
				alerta('Ha ocurrido un error, inténtelo más tarde', function () {});
			}
		})
	}
});

var ColeccionCotizaciones = Backbone.Collection.extend({
	url   : 'http://crmqualium.com/api_cotizaciones',
	model : app.ModeloCotizacion,
});

app.coleccionCotizaciones = new ColeccionCotizaciones(app.coleccionDeCotizaciones);