var app = app || {};

app.VistaPerfil = Backbone.View.extend({
	tagName : 'article',
	
	plantilla : _.template($('#divperfil').html()), // plantilla para dibujar la tarjeta de perfil
	mimodal : _.template( $('#miperfil').html() ),  // plantilla para la edición del perfil
	psubmodulos : _.template( $('#tsubmodulos').html() ), // plantilla donde se generán la lista de submodulos

	events : {
		// 'click #guardarEdicion' : 'editar',
		'click button.edit': 'cargarModulos',
		'click .tohead'    : 'resize',
		// 'click .icon-trash'		: 'destroy'		
	},
	initialize : function()
	{
		// this.listenTo(this.model, 'destroy', this.remove); 
	},
	render : function (){
		this.$el.attr('style','float:left');
		this.$el.html( this.plantilla( this.model.toJSON() ) );       
		return this;
	},

	resize : function(elemento)
	{
		rezise(elemento);		
	},

	cargarModulos : function()
	{
		this.$("#edicion").append( this.mimodal( this.model.toJSON() ) );
		this.cargarModulo();

		mimodal = this.$("#modaledicion"+this.model.get('id'));

		var here = this;
		mimodal.on('hidden.bs.modal', function()
		{
			this.remove();
			here.render();
		});


	},

	cargarModulo : function()
	{
		var list = '<% _.each(modulos, function(modulo){ %> <li><a href="#<%- modulo.modulo %>" role="tab" data-toggle="tab"> <%- modulo.modulo%> </a></li> <% }) %>';
		$('#moduloss').append(_.template(list, {modulos : app.coleccionPermisos.toJSON() }));
		$("#moduloss").children(':first-child').addClass('active');
		this.cargarSubmodulo();
	},
	cargarSubmodulo : function()
	{
		submodulos = app.coleccionPermisos.toJSON();			
		var json={};		
		for(var x=0; x < submodulos.length;x++)
		{			
			json.active = (x==0) ? "active" : "";
			json.modulo = submodulos[x].modulo;
			
			json.submodulos = submodulos[x].permisos.split(",");			
			$("#submoduloss").append(this.psubmodulos(json));				
		}				
	},

		// this.$ListaPermisos = this.$('#ListaPermisos');
  //       this.cargarPermisos();
  //       if(this.model.get('idpermisos'))
		// {
		// 	this.json = JSON.parse( this.model.get('idpermisos') ).idpermisos;
		// 	marcarPermiso(this.json, this.$el.find('.chek').children(), this.$el);	
		// } 
	// cargarPermiso : function(permiso)
	// {
	// 		var vistaPermiso = new app.VistaRenderizaPermiso({ model : permiso });
	// 		this.$ListaPermisos.append(vistaPermiso.render().el);
	// },

	// cargarPermisos : function(events)
	// {
	// 	app.coleccionPermisos.each(this.cargarPermiso, this);	
	// },

	// editar : function(events)
	// {
	// 	var modeloPerfil = JSON.stringify( pasarAJson( $('#idpermisos'+this.model.get('id')).serializeArray()));
	// 	this.model.save
	// 	(
	// 		{ idpermisos : modeloPerfil}, 
	// 		{
	// 			wait:true,
	// 			patch:true,
	// 			success: function (exito){}, 
	// 			error: function (error){}
	// 		}
	// 	);
	// 	events.preventDefault();
	// },

	// destroy : function()
	// {
	// 	this.model.destroy();
	// }

});