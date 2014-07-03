var app = app || {};

app.VistaNuevaCotizacion = Backbone.View.extend({
	el : '.contenedor_principal_modulos',

        events : {
            
            'click    #cliente'   : 'buscarCliente',     //Cuando escribes una letra, despliega un menu de sugerencias
            'keyup    #cliente'   : 'borrar',     //Cuando escribes una letra, despliega un menu de sugerencias
            'click 	  #guardar'	  : 'guardarCotizacion', //Guarda la cotización
            'click    #todos'	    : 'marcarTodosCheck',  //Marca todas las casillas de la tabla servicios cotizando
            'keypress #cliente'   : 'soloLetras',        //Valida que en el campo cliente haya solo letras
            'click 	  .btndelete' : 'eliminarServicio',  //Elimina un servicio de la tabla servicios cotizando
            'keyup    .valor'     : 'establecerTotal',   //Escucha los cambios en los inputs numericos y actualiza el total
            'keypress #bserv'     : 'buscarServicio',   //Escucha los cambios en los inputs numericos y actualiza el total
            'keyup #bserv'        : 'buscarServicio',
            'click #vistaPrevia'  : 'vistaPrevia'
        },

        initialize : function () {

            var fecha = new Date();   var dia=0;       var mes=0;
            /* Le damos formato a la fecha para que lo muestre en el campo fecha*/
            (fecha.getDate()<10) ? dia = '0'+fecha.getDate()      : dia = fecha.getDate();
            (fecha.getMonth()<10)? mes = '0'+(fecha.getMonth()+1) : mes = (fecha.getMonth()+1);

            this.$('#fecha').val(dia+'/'+mes+'/'+fecha.getFullYear());
            /* Inicializamos la tabla servicios que es donde esta la lista de servicios a seleccionar*/
            this.$tablaServicios = this.$('#listaServicios');
            /*Invocamos el metodo para cargar y pintar los servicios*/
            this.cargarServiciosCo();
        },

        render : function () { return this; },

        cargarServicioCo	: function (serviciosCotizacion) {
        	 /*....................Instanciamos un modelo servicios y le pasamos el modelo.............*/
              var vistaServicioCotizacion = new app.VistaServicioCotizacion( { model:serviciosCotizacion } );
              /*..Pintamos el modelo en la vista servicio mendiante una herencia al metodo render de la vista servicio...*/
              this.$tablaServicios.append( vistaServicioCotizacion.render().el );
        },

        cargarServiciosCo : function (){
        	/*....hacemos un ciclo each a la colección pasandole cada modelo de servicio para poder pintarlo en la tabla......*/
            app.coleccionServicios.each(this.cargarServicioCo, this);
        },

        eliminarServicio : function (elemento){
        	// var serviciosCotizados = pasarAJson($('.filas').serializeArray());
        	// console.log(serviciosCotizados);
        	/*....Eliminamos un modelo de la tabla de servicios cotizando....*/
           $(elemento.currentTarget).parents('tr').remove();
           /*.....Activamos el servicio de nuevo de la lista en la tablaServicios*/
           $('#listaServicios #'+$(elemento.currentTarget).attr('id')).attr('disabled',false);
           /*....Establecemos en checkbox oculto a falso y asi poder seleccionarlo de nuevo.....*/
           $('#listaServicios #'+$(elemento.currentTarget).attr('id')).attr('checked',false);
        },

        establecerTotal : function (elemento)
        {
           var total = 0;
           /*...Cada que se levante una tecla recuperaremos todos los importes y lo pasamos a un array...*/          
           var array = pasarAJson($('.importes').serializeArray());
           /*...¿Es un array de importes?...*/
           if($.isArray(array.importes))
           {    
           		/*...Si es cierto iteramos sobre los importes....*/
            	for(i in array.importes)
                {	
                /*....Cada posicion la convertimos a número y lo adicionamos al total....*/
                    total+=Number(array.importes[i]);
                }
                /*...Por fin tenemos el total y se lo asignamos a la etiqueta total para que se vea el cambio..*/
                $('#total').text(total);
            }
            else
            {	/*..¡A no fue un arreglo!..Bueno entonces paso directo el importe al total....*/
            	$('#total').text(array.importes);	
            }	            	
        },

        marcarTodosCheck : function(elemento){
        	/*..Totos los checkbox de la tabla de servicios cotizando tienen el mismo id....*/
        	var checkboxTabla = document.getElementsByName($(elemento.currentTarget).attr('id'));
          /*..Asi es como obtenemos todos...para luego iterar sobre ellos estableciendo true o false...*/
        	/*..Si marcar todos es TRUE entonces todos los de la lista son TRUE caso contrario FALSO*/
     	 		if ($(elemento.currentTarget).is(':checked')) {
     	 			for (var i = 0; i < checkboxTabla.length; i++) {
    					checkboxTabla[i].checked = true;
    				}
     	 		}
                else{
            		for (var i = 0; i < checkboxTabla.length; i++) {
    					checkboxTabla[i].checked = false;
    				}
            	}
        },

        buscarCliente : function (elemento)
        {
        	/*..Establecemos global el array de clientes por que nos servira en el metodo buscarRepresentante...*/
        	clientes = new Array();  var cont  = 0;
        	/*..Iteramos la coleccionDeClientes y Obtenemos a todos los clientes en un array...*/
            for(i in app.coleccionDeClientes)
            {
                clientes[cont] = app.coleccionDeClientes[i].nombreComercial; cont++;
            };
            /*...EL array obtenido lo usamos para un autocomplete..*/
            $('#cliente').autocomplete({ source: clientes});
            var esto = this;
            /*...Ahora obtenemos el nombre del cliente que seleccionamos de la lista y lo pasamos 
                 a otra función para que se encargue de buscar a su representante..*/
            $( "#cliente" ).on( "autocompleteselect", function( event, ui ) {
                esto.buscarRepresentante(ui.item.value);
            });
        },

        buscarServicio : function(elemento)
        {
          app.coleccionServicios.fetch({reset:true, data:{nombre: $(elemento.currentTarget).val() }});

          this.sinCoincidencias();

          this.$tablaServicios.html('');
          this.cargarServiciosCo();
        },

        sinCoincidencias  : function () 
        {
          if (app.coleccionServicios.length == 0) {
            app.coleccionServicios.fetch({reset:true, data:{nombre: ''}});
          };
        },

	    // Validamos que el campo #cliente solo contenga letras
        soloLetras : function(e)
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

        borrar : function(e)
        {
          if(e.keyCode===8)
          {          
            $('#idcliente')       . val( '' );
            $('#idrepresentante') . val( '' );
            $('#representante')   . val( '' );    
          }          
        },

        buscarRepresentante : function(pcliente)
        {
            var idcliente     = ( ( app.coleccionClientes.findWhere       ( { 'nombreComercial' : pcliente  } ) ).toJSON() ).id ;
            var representante = ( ( app.coleccionRepresentantes.findWhere ( { 'idcliente'       : idcliente } ) ).toJSON() )    ;
              
              $('#idcliente')       . val( idcliente            );
              $('#idrepresentante') . val( representante.id     );
              $('#representante')   . val( representante.nombre ); 		
	      },

        vistaPrevia : function(elemento)
        {


          // var html = document;
          // console.log(html);

          var f = new Date();
          var modelocotizacion = pasarAJson($('#registroCotizacion').serializeArray());
          modelocotizacion.fecha = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
          modelocotizacion.idempleado = '46';

          
          app.coleccionLocalCotizaciones.create
          (
            modelocotizacion,
            {
              wait: true,
              success: function (data){ console.log('exito')},
              error: function (error) {}
            }
          );
        // javascript:window.open('formato','','width=600,height=400,left=50,top=50,toolbar=yes');
          
          elemento.preventDefault();
        },

        /*..Una vez que tenemos lista la cotizacion nos toca el turno de guardala en la base de datos :D ...*/
        guardarCotizacion : function (elemento)
        {  
          // $('#vistaPrevia').attr('true');
        //   var f = new Date();
        //   var modelocotizacion = pasarAJson($('#registroCotizacion').serializeArray());

        //   modelocotizacion.fecha = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
        //   modelocotizacion.idempleado = '46';
         
        //   /*...Ahora obtenemos el form de cada fila de la tabla servicios cotizando y lo pasamos a un array..*/
        //   var serviciosCotizados = pasarAJson($('.filas').serializeArray());
        //   /*..Como en el array serviciosCotizados no podemos usar el length entonces obtenermos el array de id´s
        //   	  de los servicios de la tabla y ahora este array si nos dejara usar length y asi poder iterar sobre el array
        //   	  serviciosCotizados ...*/
        //   var longitud = serviciosCotizados.id;

        //    Backbone.emulateHTTP = true; //Variables Globales
		      //  Backbone.emulateJSON = true; //Variables Globales 
        //    app.coleccionCotizaciones.create
        //    (
        //    		modelocotizacion, //Hacemos un CREATE con los datos primarios de la cotización
        //    		{
        //    			wait:true,
        //    			success:function(exito)
        //    			{
        //    				/*..Si el programa pasa a este puntos significa que la cotización ha sido creada..*/           				           				
        //    				Backbone.emulateHTTP = true; //Variables Globales
		   			// 	    Backbone.emulateJSON = true; //Variables Globales 
		   			// 	    /*Ahora recorremos las filas de la tabla para enviar cada modelo de servicio cotizado....*/
		      //      		for(i in longitud)
		      //      		{	
		      //      			app.coleccionServiciosCotizados.create
		      //      			(		           			
		      //      				{     /*El exito.get('id') obtiene el id de la cotización que se acaba de crear 
		      //      				        y ahora todos los servicios que estan dentro de este ciclo le pertenece a esa cotizacion acabada de crear*/
		      //      					idcotizacion : exito.get('id'),  
		      //      					idservicio   : serviciosCotizados.id[i],
			     //       				duracion     : serviciosCotizados.duracion[i],
			     //       				cantidad     : serviciosCotizados.cantidad[i],
			     //       				precio       : serviciosCotizados.precio[i],
			     //       				descuento    : serviciosCotizados.descuento[i]		           			
			     //       			},
		      //      				{ 
		      //      					wait:true,
				    //        			success:function(exito)
				    //        			{ /*..Ok nuestros modelo de servicio cotizado se ha creado :D ..*/
				    //        				console.log('Fue exito');
				    //        			},
				    //        			error:function(error)
				    //        			{/*..¡Oh no! :( algo no anda bien verifica el código de este archivo o 
				    //        				 preguntale a la API que ¡onda! :/ ..*/
				    //        				console.log('Fue error ',error);
				    //        			}
		      //      				}
		      //      			);
		           			 
		      //      		};
		      //      		Backbone.emulateHTTP = false; //Variables Globales
		   			// 	    Backbone.emulateJSON = false; //Variables Globales

        //    			},
        //    			error:function(error)
        //    			{	/*..Tu modelo Cotizacion no se creo por lo tanto el modelo servicio cotizado Tampoco :( ..*/
						  //     console.log('Fue error ',error);
        //    			}
        //    		}
        //    ); //Fin de app.coleccionCotizaciones
        // Backbone.emulateHTTP = false; //Variables Globales
		    // Backbone.emulateJSON = false; //Variables Globales

		   /*..Con esta instrucción evitamos que la pagina del navegador se recargue y asi no perdemos los datos..*/
		   elemento.preventDefault();

		} //Fin del metodo guardarCotizacion


}); //Fin de la vista Nueva Cotización

app.vistaNuevaCotizacion = new app.VistaNuevaCotizacion();
