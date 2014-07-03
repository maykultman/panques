var app = app || {};

app.VistaPermiso = Backbone.View.extend({
	tagName : 'tr',

	plantilla : _.template($('#listarPermisos').html()),

	events : {
		'click     .icon-edit'  : 'habilitarEdicion', //..Habilita el input para la edición del rol...
		'keypress  #epermiso'   : 'guardarEdicion',	 //..Guarda la edición del campo...
		'click     .icon-trash' : 'eliminar'		 //..Elimina un miembro de la lista de roles..
	},

	initialize : function ()
	{
		this.listenTo(this.model, 'change', this.render);  //...Change evento que escucha un cambio en el modelo
		this.listenTo(this.model, 'destroy', this.remove); //...Destroy evento que escucha que se destruyo un modelo y remove lo emlimina de la lista
	},

	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	},

	habilitarEdicion : function()
	{
		this.$el.children().children().toggleClass('visibleR');
	},

	guardarEdicion : function(elemento)
	{
		if (elemento.keyCode === 13) 
		{			
			var permiso = $(elemento.currentTarget).val();
			if(permiso) // La variable permiso tiene valor
			{
				this.model.save
				(
					{ nombre : permiso }, 
					{
						wait:true,
						patch:true,
						success: function (exito){
							console.log(exito);
						}, 
						error: function (error){
							console.log(error);
						}
					}
				);
			}//If de validación de la variable permiso
			
			this.$el.children().children().toggleClass('visibleR'); //..Mostramos la etiqueta que contiene el permiso modificado..
			elemento.preventDefault();
		};//..if
	},

	eliminar : function()
	{
		this.model.destroy();
	}

});