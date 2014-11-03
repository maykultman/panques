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
		this.destroy({
			wait : true,
			success	: function () { },
			error	: function () {
				alerta('Ha ocurrido un error, inténtelo más tarde', function () {});
			}
		});
	}
});