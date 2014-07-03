var app = app || {};

app.VistaArchivo = Backbone.View.extend({
	initialize	: function () {
		this.listenTo(this.model, 'destroy', this.remove);
	},

	render	: function () {
		this.$el.append(this.plantillaDefault( this.model.toJSON() ));
		return this;
	}
});

app.V_A_ConsultaProyecto = app.VistaArchivo.extend({
	tagName					: 'tr',

	className				: 'trProyecto',

	plantillaDefault		: _.template($('#tr_archivo').html()),

	events					: {
		'click .eliminar'	: 'eliminar'
	},

	eliminar				: function () {
		this.model.destroy();
	}
});