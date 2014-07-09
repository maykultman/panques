var app = app || {};

app.VistaConsultaCotizaciones = Backbone.View.extend({
	 el : '.contenedor_principal_modulos',

	 events : 
	 {
	 	'click  #marcar'    	 : 'marcarTodos',
	 	'click  #desmarcar' 	 : 'desmarcarTodos',
	 	'click  #eliminar'  	 : 'eliminar',
        'click  #buscarCliente'  : 'busqueda',
        'keyup  #buscarCliente'  : 'borrayRenderiza',
        'click  #buscarEmpleado' : 'busqueda',
        'keyup  #buscarEmpleado' : 'borrayRenderiza',
        'click 	.abajo'          : 'ordenarporfecha',
		'click  .arriba'         : 'ordenarporfecha',
		'click #todos' : 'marcarTodosCheck'
	 },

	 initialize : function ()
	 {
	 	this.$tablaCotizaciones = this.$('#lista_cotizaciones');
	 	this.cargarCotizaciones(); 
	 	this.listenTo( app.coleccionCotizaciones, 'add', this.cargarCotizacion );
		this.listenTo( app.coleccionCotizaciones, 'reset', this.cargarCotizaciones);	 	
	 },

    render : function (){},

	cargarCotizacion : function (modelo)
	{
	 	var cantidad  = 0;	 	var precio = 0;	 	
	 	var descuento = 0;	 	var total  = 0;
	 	
	 	/* Busqueda de id´s en cada colección*/
	 	var servicio = app.coleccionServiciosCotizados.where ({ idcotizacion : modelo.get( 'id' ) });

	 	 /*Este ciclo es para calcular el total de todos los servicios que le pertenece a una cotización*/
	 	for(var i = 0; i < servicio.length; i++ )
	 	{
	 		/*...Le pedimos el dato para hacer la operación total a la colección de servicios...*/
	 		cantidad  = Number( servicio[i].get( 'cantidad'  ) );
	 	 	precio 	  = Number( servicio[i].get( 'precio'    ) );
	 	 	descuento = Number( servicio[i].get( 'descuento' ) );
	 	 	/*Despues de obtener los datos hacemos la operación para calcular el total*/
	 	 	total 	  += cantidad * precio - descuento;
	 	}
	 	/*...Añadimos campos a la colección de modelocotización...*/ 	 	
	 	modelo.set
	 	({  
	 		fecha      : formatearFechaUsuario(new Date(modelo.get('fecha'))), 				  
	 		'empleado' : app.coleccionEmpleados.get ({ id : modelo.get( 'idempleado' )} ).get('nombre'),
	 		'cliente'  : app.coleccionClientes. get ({ id : modelo.get( 'idcliente'  )} ).get('nombreComercial'), 
			'total'    : total
	 	});
	 	
	 	/*...Ahora Instanciamos nuestra vistaCotización y le enviamos el modelo acabado de crear...*/
	 	var vistaCotizacion = new app.VistaCotizacion({model : modelo});
	 	/*...Lo añadimos a la tabla para que se apile en la interfaz, mediante el metodo render de la vistaCotización...*/
	 	this.$tablaCotizaciones.append( vistaCotizacion.render().el);
	},

	cargarCotizaciones : function ()
	{
		this.$tablaCotizaciones.html('');
	 	app.coleccionCotizaciones.each(this.cargarCotizacion, this);
	},

	ordenarporfecha : function(fecha)
	{	
		ordenar(fecha, app.coleccionCotizaciones, app.coleccionDeCotizaciones);
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

	//  desmarcarTodos : function()
	//  {
	//  	alert('e.e');
	//  },

	//  eliminar : function()
	//  {
	//  	alert('e.e');
	//  },


});

app.vistaConsultaCotizaciones = new app.VistaConsultaCotizaciones();