var app = app || {};

app.VistaServicioCliente = Backbone.View.extend({
	tagName		: 'small',
	plantilla	: _.template($('#servicioCliente').html()),
	events	: {
		'click .eliminarSC'	: 'cambiarStatus'
	},
	initialize	: function () {
	},

	render	: function () {
		this.$el.html(this.plantilla( this.model.toJSON() ));
		return this;
	},

	cambiarStatus	: function (elemento) {
		// this.model.destroy();
		this.model.cambiarStatus(elemento);
		// this.$el.remove();
	}

});