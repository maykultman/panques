var app = app || {};
// Pendiente
app.VistaNuevoPermiso = Backbone.View.extend({
	el : '#catalogoPermisos',

	events : {
		'click     #guardar' : 'guardar',
		'keypress  #permiso'	: 'validarNombre',
		'keypress  #buscar_permiso' : 'buscarPermiso', //...Para hacer una busqueda en la lista Permisoes...
		'keyup     #buscar_permiso' : 'buscarPermiso', //...Al soltar una tecla llamamos a la función buscarRol...		
	},

	initialize : function ()
	{
		/* Inicializamos la tabla servicios que es donde esta la lista de servicios a seleccionar*/
        this.$scroll_permisos = this.$('#scroll_permisos');
        /*Invocamos el metodo para cargar y pintar los servicios*/
        this.cargarPermisos();
        this.listenTo( app.coleccionPermisos, 'add', this.cargarPermisos );
		this.listenTo( app.coleccionPermisos, 'reset', this.cargarPermisos );     
	},
	render : function ()
	{
		return this;
	},

	buscarPermiso : function (elemento)
	{
		var buscando = $(elemento.currentTarget).val();
		if(elemento.keyCode===8)
		{
			app.coleccionPermisos.fetch({
				reset:true, data:{nombre: buscando}
			});
		}
		app.coleccionPermisos.fetch({
			reset:true, data:{nombre: buscando}
		});

		this.sinCoincidencias();

		this.$scroll_permisos.html('');
		this.cargarPermisos();	
	},

	sinCoincidencias	: function () {
		if (app.coleccionPermisos.length == 0) {
			app.coleccionPermisos.fetch({
				reset:true, data:{nombre: ''}
			});
		};
	},

	validarNombre : function(e)
	{
		return validarNombre(e);           
	},

	guardar : function (evento)
	{
		var modeloPermiso = pasarAJson($('#registroPermiso').serializeArray());
		$('#permiso').val('');
		if(modeloPermiso.nombre)
		{
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionPermisos.create
			(
				modeloPermiso,
				{
					wait: true,
					success: function (data){
						alerta('<p style="color:#1A641A"><b>Permiso Guardado con Éxito</b></p>', function(){});
					},
					error: function (error) {
						alerta('<p style="color:FireBrick"><b>Error al registrar el Permiso</b></p>', function(){});
					}
				}
			);

			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		}
		
		evento.preventDefault();
	},

	cargarPermiso : function (permiso)
	{
		var vistaPermiso = new app.VistaPermiso({model : permiso});		
		this.$scroll_permisos.append(vistaPermiso.render().el);
	},
	cargarPermisos : function ()
	{	
		app.coleccionPermisos.each(this.cargarPermiso, this);
	}
});

app.vistaNuevoPermiso = new app.VistaNuevoPermiso();