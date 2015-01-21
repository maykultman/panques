var app = app || {};

app.VistaCatalogoPuesto = Backbone.View.extend({
	tagName : 'tr',
	plantilla : _.template($('#listaPuestos').html()),

	events : {	
		'click     .icon-edit'  : 'habilitarEdicion', //..Habilita el input para la edición del rol...
		'keypress   #epuesto'   : 'guardarEdicion',	 //..Guarda la edición del campo...
		'click     .icon-trash' : 'eliminar',		 //..Elimina un miembro de la lista de roles..
		'glyphicon-floppy-disk' : 'habilitarEdicion'
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

	habilitarEdicion : function(e)
	{	//..Cambia el class ha visible al campo para editar el rol
		this.$el.children().children('label').toggleClass('ocultoR');
		this.$el.children().children('input').toggleClass('visibleR');		
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

	eliminar : function(e)
	{
		var set = $(e.currentTarget).data('set');		
		var self = this;
		if(set==1)
		{
			confirmar('<b>No puede eliminar este puesto esta siendo utilizado</b>', 
						function () {}, function () {});
		}else{
			confirmar('¿Desea eliminar a este puesto?', function(){
				self.model.destroy();
			},function(){});
		}
	}

});

app.VistaNuevoPuesto = Backbone.View.extend({
	el : '#catalogoPuestos',

	events : {
		'click     #guardar'       : 'guardar',   //...Guardamos el Nuevo rol....
		// 'keypress  #buscar_puesto' : 'buscarPuesto', //...Para hacer una busqueda en la lista roles...
		// 'keyup     #buscar_puesto' : 'buscarPuesto', //...Al soltar una tecla llamamos a la función buscarRol...		
		'keypress  #puesto'		   : 'validarCampo',
		'keypress  #buscar_puesto' : 'validarCampo'
	},

	initialize : function ()
	{
		/* Inicializamos la tabla donde se listaran los roles*/
        this.$scroll_puestos = this.$('#contenidotbody');
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
        return validarNombre(e);
    },

	// buscarPuesto : function (elemento)
	// {
	// 	var buscando = $(elemento.currentTarget).val();
	// 	if(elemento.keyCode===8)
	// 	{			
	// 		app.coleccionPuestos.fetch({
	// 			reset:true, data:{nombre: buscando}
	// 		});
	// 	}
	// 	app.coleccionPuestos.fetch({
	// 		reset:true, data:{nombre: buscando}
	// 	});

	// 	this.sinCoincidencias();

	// 	this.$scroll_puestos.html('');
	// 	this.cargarPuestos();	
	// },

	// sinCoincidencias	: function () {
	// 	if (app.coleccionPuestos.length == 0) {
	// 		app.coleccionPuestos.fetch({
	// 			reset:true, data:{nombre: ''}
	// 		});
	// 	};
	// },
	
	guardar : function(evento)
	{		
		var modeloPuesto = pasarAJson($('#registroPuesto').serializeArray());
			 
		 $('#registroPuesto')[0].reset();
		if(modeloPuesto.nombre)
		{
			globaltrue();//vease en el archivo funcionescrm.js		
			app.coleccionPuestos.create
			(
				modeloPuesto,
				{
					wait: true,
					success: function (data){
						alerta('<p style="color:#1A641A"><b>Puesto Guardado con Éxito</b></p>', function(){});
					},
					error: function (error) {
						alerta('<p style="color:FireBrick"><b>Error al registrar el Puesto</b></p>', function(){});
					}
				}
			);
			globalfalse();//vease en el archivo funcionescrm.js	
		}
		evento.preventDefault();
	},

	cargarPuestos : function ()
	{	
		var self=this;
		app.coleccionPuestos.each(function(puesto){
			self.$scroll_puestos.append(new app.VistaCatalogoPuesto({model:puesto}).render().el);
		},this);
	}
});

app.vistaNuevoPuesto = new app.VistaNuevoPuesto();