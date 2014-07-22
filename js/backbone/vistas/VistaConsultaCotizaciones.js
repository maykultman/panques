var app = app || {};
app.VistaEdicionCotizacion = app.VistaNuevaCotizacion.extend({
	el : '#section_actualizar',

	events : {
		'click #guardarEdicion' : 'guardarVersion',
		'click #vistaPreviaversion' : 'vistaPrevia'
	},

	initialize : function(){ this.contadorAlerta=1;},
	establecerCotizacion : function()
	{
		var self = this;
		this.$('#hid').val(this.model.get('id'));
		this.$('#titulo').val(this.model.get('titulo'));
		this.$('#cliente').val(this.model.get('cliente'));
		this.$('#fecha').val(this.model.get('fecha'));
		this.$('#detalles').val(this.model.get('detalles'));
		this.$('#caracteristicas').val(this.model.get('caracteristicas'));
		var rep = app.coleccionRepresentantes.findWhere({id : this.model.get('idrepresentante')}).get('nombre');

		this.$('#htitulo').val(this.model.get('titulo'));
		this.$('#idcliente').val(this.model.get('idcliente'));
		this.$('#idrepresentante').val(this.model.get('idrepresentante'));

		this.$('#representante').val(rep);
		
		this.$('#trServicio').html('');
		_.filter(app.coleccionServiciosCotizados.models, function(model){
			if(model.get('idcotizacion')==self.model.get('id'))
			{
				self.apilarServicioCotizacion(model);
			}
		});
	},

	apilarServicioCotizacion : function(modelo)
	{
		var servicio = app.coleccionServicios.get({ id : modelo.get('idservicio')});

		modelo.set({
			nombre : servicio.get('nombre'),
		});
		
		var vista = new app.VistaTablaCotizaciones ({ model : modelo});
		this.$('#trServicio').append(vista.render().el);
	},

	vistaPrevia : function()
	{
		alert('e')
	},

	guardarVersion : function(elemento)
	{
		var f = new Date();
        var modelocotizacion = pasarAJson($('#registroCotizacion').serializeArray());
        modelocotizacion.idcotizacion = modelocotizacion.id;
        delete modelocotizacion.id;
        modelocotizacion.version = Number(this.model.get('version'))+1;
		console.log(modelocotizacion);
        modelocotizacion.fecha = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
        modelocotizacion.idempleado = '65';
         
        var serviciosCotizados = pasarAJson($('.filas').serializeArray());
        var longitud = serviciosCotizados.id; 
        var self = this;
        Backbone.emulateHTTP = true; //Variables Globales
		Backbone.emulateJSON = true; //Variables Globales 
        app.coleccionCotizaciones.create
        (
           		modelocotizacion, //Hacemos un CREATE con los datos primarios de la cotización
           		{
           			wait:true,
           			success:function(exito)
           			{
           				/*..Si el programa pasa a este puntos significa que la cotización ha sido creada..*/           				           				
           				Backbone.emulateHTTP = true; //Variables Globales
		   				Backbone.emulateJSON = true; //Variables Globales 
		   				    /*Ahora recorremos las filas de la tabla para enviar cada modelo de servicio cotizado....*/
		           		for(i in longitud)
		           		{	
		           			app.coleccionServiciosCotizados.create
		           			(		           			
		           				{     //El exito.get('id') obtiene el id de la cotización que se acaba de crear 
		           				     // y ahora todos los servicios que estan dentro de este ciclo le pertenece a esa cotizacion acabada de crear
		           					idcotizacion : exito.get('id'),  
		           					idservicio   : serviciosCotizados.id[i],
			           				duracion     : serviciosCotizados.duracion[i],
			           				cantidad     : serviciosCotizados.cantidad[i],
			           				precio       : serviciosCotizados.precio[i],
			           				descuento    : serviciosCotizados.descuento[i]		           			
			           			},
		           				{ 
		           					wait:true,
				           			success:function(exito)
				           			{ /*..Ok nuestros modelo de servicio cotizado se ha creado :D ..*/
                          if(self.aumentarContador() === longitud.length)
                          { 
                            confirmar('La Versión de la Cotizacón '+modelocotizacion.titulo+' se guardo con exito <br> ¿Desea crear otra?', 
                            function(){ 
                                        $('#trServicio').html(''); 
                                        self.cargarServiciosCo();
                                      }, 
                            function(){ location.href='cotizaciones_consulta';} );  
                          }
				           				
                        },
				           			error:function(error)
				           			{/*..¡Oh no! :( algo no anda bien verifica el código de este archivo o preguntale a la API que ¡onda! :/ ..*/
				           				  
                            if(self.aumentarContador() == longitud.length)
                            {
                              confirmar('Ocurrio un error al intentar registrar la Cotización de '+modelocotizacion.titulo+'<br><b>¿Desea volver a intentelo?</b>',
                              function () {/*El sistema dejará modificar los datos ni redirigirá o otro lado*/},
                              function () {
                                location.href = 'cotizaciones_consulta';
                              });
                            }
				           			}
		           				}
		           			);
		           			 
		           		};
		           		Backbone.emulateHTTP = false; //Variables Globales
		   				    Backbone.emulateJSON = false; //Variables Globales

           			},
           			error:function(error)
           			{	/*..Tu modelo Cotizacion no se creo por lo tanto el modelo servicio cotizado Tampoco :( ..*/
						      console.log('Fue error ',error);
           			}
           		}
           ); //Fin de app.coleccionCotizaciones
          	Backbone.emulateHTTP = false; //Variables Globales
		    Backbone.emulateJSON = false; //Variables Globales
		    localStorage.clear();         
		   elemento.preventDefault();       
	},

	aumentarContador : function()
    {
      return this.contadorAlerta++;
    }
});
app.VistaCotizacion = Backbone.View.extend({
	tagName : 'tr',

	plantilla : _.template($('#tabla_Cotizacion').html()),

	events : {
		'click .icon-trash' 	: 'eliminarCotizacion',
		'click .icon-uniF5E2' 	: 'pasarAContrato',
		'click .tr_btn_editar' 	: 'edicionCotizacion',
		'click .icon-preview'	: 'vistaPrevia'
	},

	initialize : function (){
		this.listenTo( this.model, 'destroy', this.remove);
	},

	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	},

	eliminarCotizacion : function ()
	{
		this.model.destroy();
	},

	edicionCotizacion : function()
	{
		vista = new app.VistaEdicionCotizacion({ model : this.model});
		vista.establecerCotizacion();
	},

	pasarAContrato : function()
	{
		alert('contrato');
	},

	vistaPrevia : function()
	{
		localStorage.clear();
 		var servicios = app.coleccionServiciosCotizados.where({ idcotizacion : this.model.id });
		for(i in servicios)
		{
			app.coleccionLocalServicios.create(servicios[i].toJSON());
		}
		app.coleccionLocalCotizaciones.create(this.model.toJSON());
		window.open("vistaPreviaCotizacion");
	}

});

app.VistaConsultaCotizaciones = Backbone.View.extend({
	 el : '.contenedor_principal_modulos',

	 events : 
	 {
	 	'click  #marcar'    	 : 'marcarTodos',
	 	'click  #desmarcar' 	 : 'desmarcarTodos',
	 	'click  #eliminar'  	 : 'eliminarMarcados',
        'click  #buscarCliente'  : 'busqueda',
        'click  #todos' 		 : 'marcarTodosCheck',
        'click  #buscarEmpleado' : 'busqueda',
        'keyup  #buscarCliente'  : 'borrayRenderiza',        
        'keyup  #buscarEmpleado' : 'borrayRenderiza',
        'click 	.abajo'          : 'ordenarporfecha',
		'click  .arriba'         : 'ordenarporfecha',
	 },

	 initialize : function ()
	 {
	 	this.$tablaCotizaciones = this.$('#lista_cotizaciones');
	 	this.cargarCotizaciones(); 
	 	
		this.listenTo( app.coleccionCotizaciones, 'add', this.cargarCotizacion );
		this.listenTo( app.coleccionCotizaciones, 'reset', this.cargarCotizaciones);	 			
	 },

	cargarCotizacion : function (modelo)
	{
		var cantidad  = 0;	 	var precio = 0;	 var descuento = 0;	 	var total  = 0;
	 	
	 	/* Busqueda de id´s en cada colección*/
	 	var servicio = app.coleccionServiciosCotizados.where({ idcotizacion : modelo.get( 'id' ) });

	 	 /*Calculamos el total de todos los servicios que le pertenece a una cotización*/
	 	for(var i = 0; i < servicio.length; i++ )
	 	{
	 		/*...obtenemos el valor de los campos y hacemos la operación...*/
	 		cantidad  = Number( servicio[i].get( 'cantidad'  ) );
	 	 	precio 	  = Number( servicio[i].get( 'precio'    ) );
	 	 	descuento = Number( servicio[i].get( 'descuento' ) );
	 	 	total 	 += cantidad * precio - descuento;
	 	}
	  	/*...Añadimos campos a la colección de modelocotización...*/ 
	 	if(app.coleccionClientes.get({ id : modelo.get( 'idcliente')}))	 	
	 	{
	 		modelo.set
		 	({    
		 		'empleado' : app.coleccionEmpleados.get ({ id : modelo.get( 'idempleado' )} ).get('nombre'),
		 		'cliente'  : app.coleccionClientes. get ({ id : modelo.get( 'idcliente'  )} ).get('nombreComercial'), 
				'total'    : total
		 	});
			 /*...Ahora Instanciamos nuestra vistaCotización y le enviamos el modelo acabado de crear...*/
		 	var vistaCotizacion = new app.VistaCotizacion({model : modelo});
		 	/*...Lo añadimos a la tabla para que se apile en la interfaz, mediante el metodo render de la vistaCotización...*/
		 	this.$tablaCotizaciones.append( vistaCotizacion.render().el);
		 }	 	
	},

	cargarCotizaciones : function ()
	{
		this.$tablaCotizaciones.html('');
	 	app.coleccionCotizaciones.each(this.cargarCotizacion, this);
	},

	ordenarporfecha : function(fecha)
	{	app.coleccionCotizaciones.reset( app.coleccionCotizaciones.toJSON().reverse() );
		ordenar(fecha);
	},

	busqueda : function(elemento)
	{
		autocompleteGenerico(elemento, this, app.coleccionCotizaciones, this.$tablaCotizaciones);
	},	

    borrayRenderiza	: function (e) 
    {
		if(e.keyCode===8)
        {
        	this.cargarCotizaciones();
        }
	},

	marcarTodosCheck : function(elemento)
	{
		marcarCheck(elemento);
    },

    eliminarMarcados : function()
    {
    	var ides = document.getElementsByName('todos');
        var array = new Array();
        for (var i = 0; i < ides.length; i++) 
        {
            if ($(ides[i]).is(':checked')) {
               array.push(ides[i]);
            };
        };

        for (var i = 0; i < array.length; i++) 
        {
        	$(array[i])
            .parents('tr')
            .children('.icon-operaciones')
            .children('.icon-trash')
            .click();
        };
        $('#todos').attr('checked', false);
        event.preventDefault(); 
    }
});

app.VistaGeneral = Backbone.View.extend({
	el 		: '.contenedor_principal_modulos',
	events	: {
		'click .icon-edit2'	: 'editar',
		'click #btn_calcelar'	: 'cancelar'
	},
	editar 		: function () {
		$('.visiblito').toggleClass('ocultito');
	},
	cancelar	: function () {
		$('.visiblito').toggleClass('ocultito');
		window.scrollTo(0,0);
	},
});

app.vistaGeneral = new app.VistaGeneral();
app.vistaConsultaCotizaciones = new app.VistaConsultaCotizaciones();