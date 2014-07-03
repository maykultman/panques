var app = app || {};

app.VistaConsultaCotizaciones = Backbone.View.extend({
	 el : '.contenedor_principal_modulos',

	 events : 
	 {
	 	'click    #marcar'    	   : 'marcarTodos',
	 	'click    #desmarcar' 	   : 'desmarcarTodos',
	 	'click    #eliminar'  	   : 'eliminar',
        'click    #buscarCliente'  : 'autocompleteCliente',
        'keyup    #buscarCliente'  : 'borrayRenderiza',
        // 'click    #buscarUsuario'  : 'autocompleteUsuario'
        // 'keyup    #buscarUsuario'  : 'autocompleteUsuario'
	 },

	 initialize : function (){
	 	this.$tablaCotizaciones = this.$('#lista_cotizaciones');
	 	this.cargarCotizaciones(); 
	 	this.listenTo( app.coleccionCotizaciones, 'add', this.cargarCotizacion );
		this.listenTo( app.coleccionCotizaciones, 'reset', this.cargarCotizaciones);
	 	
	 },

    render : function (){},

	autocompleteCliente : function (elemento)
	{
        clientes = new Array();  var cont  = 0; 
        for(i in app.coleccionDeClientes)
        {
             clientes[cont] = app.coleccionDeClientes[i].nombreComercial; cont++;          
        };
        
        $('#buscarCliente').autocomplete({ source : clientes }); // Autocompletamos
 		
 		var esto = this; // Respaldamos el this para llamar a una funcion dentro del evento siguiente...

        $( "#buscarCliente" ).on( "autocompleteselect", function( event, ui ) {
            /*...Buscamos al cliente que nos proporciono el autocomplete en la coleccion.....
              ...Invocamos al metodo busquedaPorCliente y le enviamos el id como parametro...*/
            esto.porCliente( ( ( app.coleccionClientes.findWhere( { 'nombreComercial' : ui.item.value } ) ).toJSON() ).id);
        });
	},


    /************************/
    porCliente : function(buscando)
    {   
     	app.coleccionCotizaciones.fetch({ reset:true, data:{ idcliente : buscando } });
		
		this.sinCoincidencias();
		this.$tablaCotizaciones.html('');
		this.cargarCotizaciones();	
    },

 //    autocompleteUsuario : function (elemento)
	// {
 //        empleados = new Array();  var cont  = 0; 
 //        for(i in app.coleccionDeEmpleados)
 //        {
 //             empleados[cont] = app.coleccionDeEmpleados[i].nombre; cont++;          
 //        };
        
 //        $('#buscarUsuario').autocomplete({ source : empleados }); // Autocompletamos
 		
 // 		var esto = this; // Respaldamos el this para llamar a una funcion dentro del evento siguiente...

 //        $( "#buscarUsuario" ).on( "autocompleteselect", function( event, ui ) {
 //            // ...Buscamos al cliente que nos proporciono el autocomplete en la coleccion.....
 //            //   ...Invocamos al metodo busquedaPorCliente y le enviamos el id como parametro...
 //            esto.porUsuario( ( ( app.coleccionEmpleados.findWhere( { 'nombre' : ui.item.value } ) ).toJSON() ).id);
 //        });
	// },

	// porUsuario : function(empleado)
 //    {       
 //       	app.coleccionCotizaciones.fetch({ reset:true, data:{ idempleado : empleado }	});		
	// 	this.sinCoincidencias();
	// 	this.$tablaCotizaciones.html('');
	// 	this.cargarCotizaciones();	
 //    },
	
	borrayRenderiza : function(element)
	{
		if(element.keyCode===8)
		{		
			this.porCliente( $(element.currentTarget).val() );
		}
	},
  
    sinCoincidencias	: function () 
    {
		if (app.coleccionCotizaciones.length == 0) {
			app.coleccionCotizaciones.fetch({
				reset:true, data:{idcliente: ''}
			});
		};
	},


	cargarCotizacion : function (modelocotizacion)
	{
	 	/*Variables para el calculo del total de cada cotizacion*/
	 	var i;				//i para el ciclo for de calculo del total
	 	var cantidad  = 0;
	 	var precio 	  = 0;
	 	var descuento = 0;
	 	var total	  =0;
	 	/* Instanciamos las colecciones para la consulta de la cotizacón...*/
	 	/* Le asignamos los id´s que se va a buscar en cada colección*/
	 	var cliente  = app.coleccionClientes.where ({ id : modelocotizacion.get('idcliente')  }); 
	 	var empleado = app.coleccionEmpleados.where({ id : modelocotizacion.get('idempleado') });
	 	var servicio = app.coleccionServiciosCotizados.where({ idcotizacion : modelocotizacion.get('id')});

	 	 /*Este ciclo es para calcular el total de todos los servicios que le pertenece a una cotización*/
	 	for(i = 0; i < servicio.length; i++ )
	 	{
	 		/*...Le pedimos el dato para hacer la operación total a la colección de servicios...*/
	 		cantidad  = Number( servicio[i].get('cantidad')  );
	 	 	precio 	  = Number( servicio[i].get('precio')    );
	 	 	descuento = Number( servicio[i].get('descuento') );
	 	 	/*Despues de obtener los datos hacemos la operación para calcular el total*/
	 	 	total 	  += cantidad * precio - descuento;
	 	}
	 	/*...Añadimos campos a la colección de modelocotización...*/ 	 	
	 	modelocotizacion.set({'empleado': empleado[0].get('nombre')});
	 	modelocotizacion.set({'cliente' : cliente[0].get('nombreComercial')});
	 	modelocotizacion.set({'total' : total });

	 	/*...Ahora Instanciamos nuestra vistaCotización y le enviamos el modelo acabado de crear...*/
	 	var vistaCotizacion = new app.VistaCotizacion({model : modelocotizacion});
	 	/*...Lo añadimos a la tabla para que se apile en la interfaz, mediante el metodo render de la vistaCotización...*/
	 	this.$tablaCotizaciones.append( vistaCotizacion.render().el);
	},

	cargarCotizaciones : function ()
	{
	 	app.coleccionCotizaciones.each(this.cargarCotizacion, this);
	},

	//  marcarTodos : function()
	//  {
	//  	alert('e.e');
	//  },

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