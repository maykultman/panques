/*... Dibuja los checked para seleccionar permisos...*/
app.VistaRenderizaPermiso = Backbone.View.extend({
	tagName : 'div',
	className : 'toggler',

	plantilla : _.template($('#permisos').html()),

	events : {
		'click #togle' : 'resize',
	},

	resize : function(elemento)
	{
		var efect = $(elemento.currentTarget).parent().children('#effect');
		// console.log(efect);
		var options = { to: { width: 200, height: 60 }};
		// run the effect
		this.$(efect).toggle( 'blind', options, 500 );
	},

	render : function (){
		this.$el.attr('id','mod'+this.model.get('id'));

		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	}
});

app.VistaRenderizaPermiso = Backbone.View.extend({
	tagName : 'li',
	className : 'opciones',

	plantilla : _.template($('#permisos').html()),

	events : {
		// 'click #togle' : 'resize',
	},

	resize : function(elemento)
	{
		var efect = $(elemento.currentTarget).parent().children('#effect');
		console.log(efect);
		// var options = { to: { width: 200, height: 60 }};
		// run the effect|
		// this.$(efect).toggle( 'blind', options, 500 );
	},

	render : function (){
		// this.$el.attr('id','mod'+this.model.get('id'));
		// this.$el.attr('id',this.model.modulo);

		// this.$el.html(this.plantilla(this.model.toJSON()));
		this.$el.html( this.plantilla(this.model) );
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