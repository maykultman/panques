var app = app || {};

app.ModeloServicioCliente = Backbone.Model.extend({

	// urlRoot	:'http://qualium.mx/sites/crmqualium/',
	defaults	: {
		status	: 1
	},

	cambiarStatus	: function (elemento) {
		this.save({ status: !this.get('status') }, {
			wait:true,
			success:function () {
	  			$(elemento.currentTarget)
	  			.parent()
	  			.html('<label class="exito">Eliminado </label>');
			},
			error:function (error) {
				$(elemento.currentTarget)
				.parent()
				.html('<label class="error">No se elimino </label>');
	  		}
		});
	}
});