app.VistaCatalogoRol = Backbone.View.extend({
	tagName : 'tr',
	plantilla : _.template($('#listaRoles').html()),

	events : {	
		'click     .icon-edit' : 'habilitarEdicion', //..Habilita el input para la edición del rol...
		'keypress  #erol'      : 'guardarEdicion',	 //..Guarda la edición del campo...
		'click     .icon-trash' : 'eliminar'		 //..Elimina un miembro de la lista de roles..
   },

	initialize : function ()
	{
		this.listenTo(this.model, 'change', this.render);  //...Change evento que escucha un cambio en el modelo
		this.listenTo(this.model, 'destroy', this.remove); //...Destroy evento que escucha que se destruyo un modelo y remove lo emlimina de la lista
	},
	render : function ()
	{	//Renderiza en la plantilla el modelo....
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	},

	habilitarEdicion : function()
	{	//..Cambia el class ha visible al campo para editar el rol
		this.$el.children().children('label').toggleClass('ocultoR');
		this.$el.children().children('input').toggleClass('visibleR');
	},

	guardarEdicion : function(elemento)
	{		
		if (elemento.keyCode === 13) 
		{			
			var rol = $(elemento.currentTarget).val();
			if(rol) // La variable rol tiene valor
			{
				this.model.save
				(
					{ nombre : rol }, 
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
			}//If de validación de la variable rol
			
			this.$el.children().children().toggleClass('visibleR'); //..Mostramos la etiqueta que contiene el rol modificado..
			elemento.preventDefault();
		};//..if elemento.keyCode
	},

	eliminar : function(e)
	{
		var isuser = $(e.currentTarget).data('set');		
		var self = this;
		if(isuser==1)
		{
			confirmar('<b>El rol '+this.model.get('nombre')+' no se puede eliminar esta siendo utilizado</b>', 
						function () {}, function () {});
		}else{
			confirmar('¿Desea eliminar a este rol?', function(){
				self.model.destroy();
			},function(){});
		}
	}

});


app.VistaNuevoRol = Backbone.View.extend({
	el : '#catalogo_roles',

	events : {
		'click     #guardar'    : 'guardar',   //...Guardamos el Nuevo rol....
		'keypress  #buscar_rol' : 'buscarRol', //...Para hacer una busqueda en la lista roles...
		'keyup     #buscar_rol' : 'buscarRol', //...Al soltar una tecla llamamos a la función buscarRol...
		'keypress  #rol '		: 'validarCampo',
		'keypress  #buscar_rol' : 'validarCampo'
	},

	initialize : function ()
	{
		/* Inicializamos la tabla donde se listaran los roles*/
        this.$scroll_roles = this.$('#contenidotbody');
        /*...Una vez lista la tabla le cargamos la lista de roles...*/
        this.cargarRoles();
        this.listenTo( app.coleccionRoles, 'add',   this.cargarRol );
        this.listenTo( app.coleccionRoles, 'reset', this.cargarRol );

        $('#rol').keydown(function(event) /*...eventos del teclado...*/
        {
    		if(event.keyCode===13) /*...Si la tecla fue enter...*/
    		{
     	    	$('#guardar').trigger('click');
     	    	event.preventDefault();
    		};
    	});
	},

	render : function ()
	{
		return this;
	},

	validarCampo : function(e)
    {
        return validarNombre(e);
    },

	buscarRol : function (elemento)
	{
		var buscando = $(elemento.currentTarget).val();
		app.coleccionRoles.fetch({
			reset:true, data:{nombre: buscando}
		});

		this.sinCoincidencias();

		this.$scroll_roles.html('');
		this.cargarRoles();
	},

	sinCoincidencias	: function () {
		if (app.coleccionRoles.length == 0) {
			app.coleccionRoles.fetch({
				reset:true, data:{nombre: ''}
			});
		};
	},

	guardar : function(evento)
	{
		var modeloRol = pasarAJson($('#registro_rol').serializeArray());
		 $('#registro_rol')[0].reset();
		if(modeloRol.nombre)
		{
			globaltrue();//vease en el archivo funcionescrm.js
			app.coleccionRoles.create
			(
				modeloRol,
				{
					wait: true,
					success: function (data){
						alerta('<p style="color:#1A641A"><b>Rol Guardado con Éxito</b></p>', function(){});
					},
					error: function (error) {
						alerta('<p style="color:FireBrick"><b>Error al registrar el Rol</b></p>', function(){});
					}
				}
			);
			globalfalse();//vease en el archivo funcionescrm.js			
		}
		evento.preventDefault();
	},

	cargarRoles : function ()
	{	
		var self=this;
		app.coleccionRoles.each(function(rol){
			self.$scroll_roles.append(new app.VistaCatalogoRol({model:rol}).render().el);
		},this);
	}
});

app.vistaNuevoRol = new app.VistaNuevoRol();


