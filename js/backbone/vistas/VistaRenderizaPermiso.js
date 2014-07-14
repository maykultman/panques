/*... Dibuja los checked para seleccionar permisos...*/
app.VistaRenderizaPermiso = Backbone.View.extend({
	tagName : 'label',
	className : 'chek',

	plantilla : _.template($('#Permisos').html()),

	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	}
});

app.VistaSelectPerfil = Backbone.View.extend({
	tagName : 'option',	
	plantilla  : Handlebars.compile($('#selectperfil').html()),

	initialize : function () 
	{
		this.$el.attr('value', this.model.get('id'));
		this.$el.attr('id', 'per'+this.model.get('id'));			
	},

	render : function()
	{
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;	
	}
});