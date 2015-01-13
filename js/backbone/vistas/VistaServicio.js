var app = app || {};

app.VistaServicio = Backbone.View.extend({
	tagName		: 'li',
	events	: {
	},

	render	: function () {
		this.$el.html(this.plantillaDefault( this.model.toJSON() ));
		return this;		
	}
});


app.VistaTrServicio = app.VistaServicio.extend({

	initialize  : function () {
		this.listenTo(this.model, 'destroy', this.remove);
		this.$tbody_servicios_seleccionados 
		= $('#tbody_servicios_seleccionados');
	},

	apilarServicio  : function (elem) {
		/*Desabilitar la seleccion del servicio*/
		$(elem.currentTarget).attr('disabled',true);
			this.$tbody_servicios_seleccionados.append(
			this.plantillaSeleccionado(this.model.toJSON())
		);
		this.$el.css('color','#CCC');
	}
});