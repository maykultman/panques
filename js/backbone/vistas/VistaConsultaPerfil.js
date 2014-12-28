var app = app || {};
app.VistaConsultaPerfil = Backbone.View.extend
({
	el : '#perfiles',
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
	
	cargarPerfil : function()
	{
		$('#perfiles').html('');
		app.coleccionPerfiles.each
		( 	function(perfil)
			{
				$('#perfiles').append( new app.VistaPerfil({ model : perfil}).render().el );
			}
			,this
		);
	},

});

app.vistaConsultaPerfil = new app.VistaConsultaPerfil();
