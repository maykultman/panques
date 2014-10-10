var app = app || {};
app.VistaConsultaPerfil = Backbone.View.extend
({
	el : '#accordion',
	plantilla : _.template($('#divperfil').html()),

	events : 
	{
		'click .delete' : 'eliminar',
		'click .edit' : 'editar',
	},

	initialize : function()
	{
		this.listenTo( app.coleccionPerfiles, 'add',   this.cargarPerfil );
  		this.listenTo( app.coleccionPerfiles, 'reset', this.cargarPerfil ); 
  		this.cargarPerfil();        
	}, 

	render : function()
	{
		return this;
	},

	editar : function(elemento)
	{
		var id = $(elemento.currentTarget).attr('id');		
		var nombre = app.coleccionPerfiles.findWhere({'id': id }).toJSON();
		$('#verpermisos'+id).toggle();
		
	},

	cargarPerfil : function()
	{
		app.coleccionPerfiles.each
		(
			function(perfil){
				this.$('#unperfil').append(this.plantilla(perfil.toJSON()));
			}
			,this
		);
	}


	// eliminar : function()
	// {
	// 	this.model.destroy();
	// }

});

app.vistaConsultaPerfil = new app.VistaConsultaPerfil();
