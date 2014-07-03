var app = app || {};

app.VistaCatalogoPuesto = Backbone.View.extend({
	tagName : 'tr',
	plantilla : _.template($('#listaPuestos').html()),

	events : {	
		'click     .icon-edit'  : 'habilitarEdicion', //..Habilita el input para la edición del rol...
		'keypress   #epuesto'   : 'guardarEdicion',	 //..Guarda la edición del campo...
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
			var puesto = $(elemento.currentTarget).val();
			if(puesto) // La variable puesto tiene valor
			{
				this.model.save
				(
					{ nombre : puesto }, 
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
			}//If de validación de la variable puesto
			
			this.$el.children().children().toggleClass('visibleR'); //..Mostramos la etiqueta que contiene el puesto modificado..
			elemento.preventDefault();
		};//..if elemento.keyCode
	},

	eliminar : function()
	{
		console.log(this.model);
		// this.model.destroy(); //...Destruye un modelo de la lista de roles...
	}

});

app.VistaNuevoPuesto = Backbone.View.extend({
	el : '#catalogoPuestos',

	events : {
		'click     #guardar'       : 'guardar',   //...Guardamos el Nuevo rol....
		'keypress  #buscar_puesto' : 'buscarPuesto', //...Para hacer una busqueda en la lista roles...
		'keyup     #buscar_puesto' : 'buscarPuesto', //...Al soltar una tecla llamamos a la función buscarRol...		
		'keypress  #puesto'		   : 'validarCampo',
		'keypress  #buscar_puesto' : 'validarCampo'
	},

	initialize : function ()
	{
		/* Inicializamos la tabla donde se listaran los roles*/
        this.$scroll_puestos = this.$('#scroll_puestos');
        /*...Una vez lista la tabla le cargamos la lista de roles...*/
        this.cargarPuestos();
        this.listenTo( app.coleccionPuestos, 'add',   this.cargarPuesto );
        this.listenTo( app.coleccionPuestos, 'reset', this.cargarPuesto );  

        $('#puesto').keydown(function(event) /*...eventos del teclado...*/
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

	buscarPuesto : function (elemento)
	{
		var buscando = $(elemento.currentTarget).val();
		if(elemento.keyCode===8)
		{			
			app.coleccionPuestos.fetch({
				reset:true, data:{nombre: buscando}
			});
		}
		app.coleccionPuestos.fetch({
			reset:true, data:{nombre: buscando}
		});

		this.sinCoincidencias();

		this.$scroll_puestos.html('');
		this.cargarPuestos();	
	},

	sinCoincidencias	: function () {
		if (app.coleccionPuestos.length == 0) {
			app.coleccionPuestos.fetch({
				reset:true, data:{nombre: ''}
			});
		};
	},
	
	guardar : function(evento)
	{		
		var modeloPuesto = pasarAJson($('#registroPuesto').serializeArray());
			 
		 $('#registroPuesto')[0].reset();
		if(modeloPuesto.nombre)
		{
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;		
			app.coleccionPuestos.create
			(
				modeloPuesto,
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

	cargarPuesto : function (puesto)
	{
		var vistaPuesto = new app.VistaCatalogoPuesto({model : puesto});		
		this.$scroll_puestos.append(vistaPuesto.render().el);
	},
	cargarPuestos : function ()
	{	
		app.coleccionPuestos.each(this.cargarPuesto, this);
	}
});

app.vistaNuevoPuesto = new app.VistaNuevoPuesto();