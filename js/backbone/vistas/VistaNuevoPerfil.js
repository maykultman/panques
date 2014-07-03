var app = app || {};
app.VistaPermisoPerfil = Backbone.View.extend({
	tagName : 'label',
	className : 'chek',

	plantilla : _.template($('#Permisos').html()),
	events : {},

	initialize : function(){},

	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	},
});

app.VistaNuevoPerfil = Backbone.View.extend({
	el : '#contenido_nuevoperfil',

	events : {
		'click .btn-primary' : 'guardar',
		'change #idpermiso'   : 'marcarTodos'
	},

	initialize : function ()
	{
	    this.$ListaPermisos = this.$('#ListaPermisos');
        this.cargarPermisos();
      
	},
	render : function ()
	{
		return this;
	},

	guardar : function (evento)
	{
		var modeloPerfil = pasarAJson($('#registroPerfil').serializeArray());
		console.log(modeloPerfil.idpermiso.length);
		if(modeloPerfil.nombre)
		{
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionPerfiles.create
			(
				{ nombre : modeloPerfil.nombre},
				{
					wait: true,
					success: function (exito)
					{ 
						Backbone.emulateHTTP = true;
						Backbone.emulateJSON = true;
						if(modeloPerfil.idpermiso.length>1)
						{
							
							for(i in modeloPerfil.idpermiso)
							{
								app.coleccionPermisosPerfil.create
								(
									{ 	idperfil  : exito.get('id'),
										idpermiso : modeloPerfil.idpermiso[i]
									},
									{
										wait: true,
										success: function (data){ console.log('exito')},
										error : function (){}
									}
								);	
							}

							
						} /*Modeloperfilpermisos*/
						else
						{
							app.coleccionPermisosPerfil.create
							(
								{ 	idperfil  : exito.get('id'),
									idpermiso : modeloPerfil.idpermiso
								},
								{
									wait: true,
									success: function (data){ console.log('exito')},
									error : function (){}
								}
							);
						}
						Backbone.emulateHTTP = false;
						Backbone.emulateJSON = false;


					},
					error: function (error) {}
				}
			); /*...Create del perfil...*/

			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		} /*...If de modelo Perfil...*/
		
		evento.preventDefault();
	},

	marcarTodos : function(elemento)
	{
		console.log($(elemento.currentTarget).attr('id'));
		var checkboxTabla = document.getElementsByName($(elemento.currentTarget).attr('id'));
		
		if ($(elemento.currentTarget).is(':checked')) 
		{
 	 		for (var i = 0; i < checkboxTabla.length; i++) 
 	 		{
				checkboxTabla[i].checked = true;
			}
 	 	}
        else
        {
        	for (var i = 0; i < checkboxTabla.length; i++) 
        	{
				checkboxTabla[i].checked = false;
			}
        }        
	},

	cargarPermiso : function (permiso)
	{
		var vistaPermiso = new app.VistaPermisoPerfil({model : permiso});		
		this.$ListaPermisos.append(vistaPermiso.render().el);
	},
	cargarPermisos : function ()
	{	
		app.coleccionPermisos.each(this.cargarPermiso, this);	
	},

});

app.vistaNuevoPerfil = new app.VistaNuevoPerfil();