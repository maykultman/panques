var app = app || {};
app.VistaConsultaPerfil = Backbone.View.extend
({
	el : '#misperfiles',
	plantilla : _.template($('#divperfil').html()),

	events : 
	{
		'click .delete' : 'eliminar',
	},

	initialize : function()
	{
		this.listenTo( app.coleccionPerfiles, 'add',   this.cargarPerfil );
  		this.listenTo( app.coleccionPerfiles, 'reset', this.cargarPerfil ); 
  		this.cargarPerfil();        
	}, 

	// editar : function(elemento)
	// {
	// 	var id = $(elemento.currentTarget).attr('id');		
	// 	var nombre = app.coleccionPerfiles.findWhere({'id': id }).toJSON();
	// 	$('#verpermisos'+id).toggle();
		
	// },
	
	cargarPerfil : function()
	{
		app.coleccionPerfiles.each
		( 	function(perfil)
			{
				$('#perfiles').append( new app.VistaPerfil({ model : perfil}).render().el );
			}
			,this
		);
	},
	// eliminar : function()
	// {
	// 	this.model.destroy();
	// }

});

app.vistaConsultaPerfil = new app.VistaConsultaPerfil();
