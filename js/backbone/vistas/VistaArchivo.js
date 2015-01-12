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