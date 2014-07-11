var app = app || {};

app.VistaCotizacion = Backbone.View.extend({
	tagName : 'tr',

	plantilla : _.template($('#tabla_Cotizacion').html()),

	events : {
		'click .icon-trash' : 'eliminarCotizacion',
		'click .icon-uniF5E2' : 'pasarAContrato'
	},

	initialize : function (){

	},

	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	},

	eliminarCotizacion : function ()
	{
		this.model.destroy();
	},

	pasarAContrato : function()
	{
		alert('contrato');
	}

});

// app.vistaCotizacion = new app.VistaCotizacion();