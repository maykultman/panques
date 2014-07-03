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
		this.$el.children().children().toggleClass('visibleR');
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

	eliminar : function()
	{
		this.model.destroy(); //...Destruye un modelo de la lista de roles...
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
        this.$scroll_roles = this.$('#scroll_roles');
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
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = "8-37-39-46";
        tecla_especial = false
        for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
                return false;
        }
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
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionRoles.create
			(
				modeloRol,
				{
					wait: true,
					success: function (data){},
					error: function (error) {}
				}
			);
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		}
		evento.preventDefault();
	},

	cargarRol : function (rol)
	{
		var vistaRol = new app.VistaCatalogoRol({model : rol});
		this.$scroll_roles.append(vistaRol.render().el);
	},
	cargarRoles : function ()
	{
		app.coleccionRoles.each(this.cargarRol, this);
	}
});

app.vistaNuevoRol = new app.VistaNuevoRol();


