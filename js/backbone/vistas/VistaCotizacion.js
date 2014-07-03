var app = app || {};

app.VistaCotizacion = Backbone.View.extend({
	tagName : 'tr',

	plantilla : _.template($('#tabla_Cotizacion').html()),

	events : {},

	initialize : function (){

	},

	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	},

});

// app.vistaCotizacion = new app.VistaCotizacion();