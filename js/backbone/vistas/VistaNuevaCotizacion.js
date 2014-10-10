var app = app || {};

app.VistaSeccion = Backbone.View.extend({
	tagName	: 'tr',
	// className : 'tr_seccion',
	plantillas : {
		plantillaTrSeccion :  _.template( $('#td_seccion').html() )
	},
	events 	: {
		'click .span_eliminar_seccion' : 'eliminarTr',

		'change .number'					: 'calcularSeccion',
		'keyup .number'						: 'calcularSeccion',
		'mousewheel .number'				: 'calcularSeccion',
		'click .number'				: 'calcularSeccion',
		'focus .number'				: 'calcularSeccion',
	},
	initialize 	: function () { },
	render: function (id) {
		/*El parametro id, es la clave del servicio que se está cotizando*/
		this.$el.html( this.plantillas.plantillaTrSeccion({ id:id }) );
		this.calcularSeccion();
		return this;
	},
	eliminarTr 		: function () {
		this.$el.remove();
	},
	calcularSeccion : function () {
		var horas 		= this.$('#horas').val(),
			precio_hora = this.$('#precio_hora').val();

		/*Mostramos el costo total de la seccion*/
		this.$('.costoSeccion').val( horas * precio_hora ).trigger('change');
		
		/*Los campos visibles al usuario no serán sirven dido que se encuentrar
		  en tds de tabla, para que se puede generar un json por casa sección 
		  del servicio que se encuantra cotizando, debemos pasar esos valores
		  a unos input hidden que si se encuentran en formularios.*/
		this.$('input[name="seccion"]')		.val(this.$('#seccion')		.val());
		this.$('input[name="descripcion"]')	.val(this.$('#descripcion')	.val());
		this.$('input[name="precio_hora"]')	.val(horas);
		this.$('input[name="horas"]')		.val(precio_hora);
	},
});

app.VistaCotizarServicio = Backbone.View.extend({
	tagName 	: 'tr',
	plantillas 	: {
		plantillaDelModelo :  _.template( $('#tds_servicio_seleccionado').html() )
	},
	events 		: {
		'click #span_otraSeccion'	: 'apilarSeccion',
		'click .span_toggleSee' : 'conmutarVista',
		'click .span_eliminar_servicio' : 'eliminarVista',

		'change .costoSeccion' : 'carlcularImporte',
	},
 	initialize 	: function () {
 		this.indice = 0;
 	},
	render 		: function () {
		this.$el.html(this.plantillas.plantillaDelModelo(this.model.toJSON()));
		this.apilarSeccion();
		return this;
	},
	apilarSeccion 	: function () {
		var vistaSeccion = new app.VistaSeccion();
		this.$('tbody').append( vistaSeccion.render(this.model.get('id')).el );
		this.indice++;
	},
	conmutarVista 	: function (e) {
		/*Cambiamos el icono del boton, arriba o abajo segun sea el caso*/
		this.$(e.currentTarget).toggleClass('icon-circleup');
		/*Guardamos todos los td que seran afectados.*/
		var selector = '#table_servicio_'+this.model.get('id')+' thead #tr_titulos_secciones td,';
			selector += '#table_servicio_'+this.model.get('id')+' tbody tr td,';
			selector += '#table_servicio_'+this.model.get('id')+' tfoot tr td';
		/*La función slideToggle solo funciona con td, no con table, tr, thead, tbody no tfoot*/
		this.$(selector).slideToggle('fast');
	},
	eliminarVista 	: function (e) {

		/*Antes de eliminar la vista buscamos el servicio correspondiente en la lista de servicios*/
		$(
			'#table_servicios #'
			+this.$(e.currentTarget)
			.attr('id')
		)							/*Obtenemos el imput checkbox*/
		.attr('disabled',false) 	/*Desmarcamos el checkbox*/
		.attr('checked',false) 		/*Activamos el checkbox*/
		.parents('tr')				/*Buscamos tr que contiene el checkbox*/
		.css('color','#333'); 		/*Reestablecemos el color original del texto*/

		this.$el.remove();
	},
	carlcularImporte 	: function () {
		/*Cada seccion tiene un imput con class ".costoSeccion."
		  tomando en cuenta que cualquier servicio puede tener
		  varias secciones, tenemos que obtener todos los valires
		  de los precios de cada sección, sumarlos y colocar el
		  resultado en el campo importe.*/
		var costoSecciones = this.$('.costoSeccion'),
			importe = 0;
		for (var i = 0; i < costoSecciones.length; i++) {
			importe += parseInt(this.$(costoSecciones[i]).val());
		};
		this.$('.importe').val(importe);
	},
	validarTypeNumber	: function (e) {
		// console.log(e.currentTarget.type, $(e.currentTarget).val(), e);
		// validarInput(e.currentTarget.type, $(e.currentTarget).val(), e);
	}
});

app.VistaTrServ = app.VistaTrServicio.extend({
	tagName : 'tr',
	plantillaDefault  : _.template($('#tds_servicio').html()),
	events  : {
		'click .checkbox_servicio'  : 'apilarServicio',
	},
	apilarServicio  : function (elem) {
		/*Desabilitar la seleccion del servicio*/
		$(elem.currentTarget).attr('disabled',true);
		// this.$tbody_servicios_seleccionados.append(
		// 	'<tr>' + 
		// 		this.plantillaSeleccionado( this.model.toJSON() )
		// 	+ '</tr>' 
		// );

		/*Creación de la vista de servicio cotizado*/
		var vistaCotizarServicio = new app.VistaCotizarServicio({model:this.model});
		this.$tbody_servicios_seleccionados.append(vistaCotizarServicio.render().el);
		// VistaTrTablaServ.setElement( this.$el.find('#servicio_'+this.model.get('id')) );

		this.$el.css('color','#CCC');
	}
});


app.VistaNuevaCotizacion = Backbone.View.extend({
	el : '.contenedor_principal_modulos',

	events : {
			
			'click     #cliente'     : 'buscarCliente',     //Cuando escribes una letra, despliega un menu de sugerencias
			'click 	   #guardar'	   : 'guardarCotizacion', //Guarda la cotización
			'click     #todos'	     : 'marcarTodosCheck',  //Marca todas las casillas de la tabla servicios cotizando
			'click     #vistaPrevia' : 'vistaPrevia',
			'click     #bserv'       : 'completarServicio',
			'keyup     #cliente'     : 'borrar',     //Cuando escribes una letra, despliega un menu de sugerencias
			'keyup     #bserv'       : 'sinCoincidencias',
			'blur      #titulo'      : 'titulo',
			'keypress  #titulo'      : 'soloLetras',
			'click     #delete'      : 'eleminiarServicios',
			'keypress  #cliente'     : 'soloLetras',        //Valida que en el campo cliente haya solo letras

			/*Botones del thead los servicios que se están cotizando*/
			'click .span_toggleAllSee'	 : 'conmutarVistas',
			'click .span_deleteAll'	 	: 'eliminarVistas',
			
			/*'click     .span_eliminar'   : 'eliminarServicio',*/  //Elimina un servicio de la tabla servicios cotizando

			
			'keyup     .valor'       : 'establecerTotal',   //Escucha los cambios en los inputs numericos y actualiza el total
			
	},

	initialize : function () 
	{
		var fecha = new Date();   var dia=0;       var mes=0;
		/* Le damos formato a la fecha para que lo muestre en el campo fecha*/
		(fecha.getDate()<10) ? dia = '0'+fecha.getDate()      : dia = fecha.getDate();
		(fecha.getMonth()<10)? mes = '0'+(fecha.getMonth()+1) : mes = (fecha.getMonth()+1);

		this.$('#fecha').val(dia+'/'+mes+'/'+fecha.getFullYear());
		/* Inicializamos la tabla servicios que es donde esta la lista de servicios a seleccionar*/
		// this.$tablaServicios = this.$('#listaServicios');
		/*Invocamos el metodo para cargar y pintar los servicios*/
		this.cargarServiciosCo();

		this.contadorAlerta = 1;

		// this.$('#table_servicios').tablesorter({
		// theme: 'blue',
		// 	widgets: ["zebra", "filter"],
		// 	widgetOptions : {
		// 		filter_external : '.search-services',
		// 		filter_columnFilters: false,
		// 		filter_saveFilters : true,
		// 		filter_reset: '.reset'
		// 	}
		// });
	},

	render : function () { return this; },

	titulo : function()
	{
			$('#htitulo').val($('#titulo').val());
	},
	cargarServicioCo	: function (serviciosCotizacion) {
		 /*....................Instanciamos un modelo servicios y le pasamos el modelo.............*/
				var vistaTrServ = new app.VistaTrServ( { model:serviciosCotizacion } );
				/*..Pintamos el modelo en la vista servicio mendiante una herencia al metodo render de la vista servicio...*/
				this.$('#tbody_servicios').append( vistaTrServ.render().el );
	},

	cargarServiciosCo : function ()
	{
		/*....hacemos un ciclo each a la colección pasandole cada modelo de servicio para poder pintarlo en la tabla......*/
			this.$('#tbody_servicios').html('');
			app.coleccionServicios.each(this.cargarServicioCo, this);
	},

	// eliminarServicio : function (elemento)
	// {
	//  // var serviciosCotizados = pasarAJson($('.filas').serializeArray());
	// 			/*.....Activamos el servicio de nuevo de la lista en la tablaServicios*/
	// 	 $('#listaServicios #'+$(elemento.currentTarget).attr('id')).attr('disabled',false);
	// 	 /*....Establecemos en checkbox oculto a falso y asi poder seleccionarlo de nuevo.....*/
	// 	 $('#listaServicios #'+$(elemento.currentTarget).attr('id')).attr('checked',false);
	// 	 $(elemento.currentTarget).parents('tr').remove();
	// },

	// eleminiarServicios : function(event)
	// {
	// 	 var ides = document.getElementsByName('todos');
	// 	 var array = new Array();
	// 	 for (var i = 0; i < ides.length; i++) 
	// 	 {
	// 			if ($(ides[i]).is(':checked')) {
	// 				 array.push(ides[i]);
	// 			};
	// 	 };

	// 	 for (var i = 0; i < array.length; i++) 
	// 	 {
	// 			$(array[i])
	// 			.parents('tr')
	// 			.children('.iconos-operaciones')
	// 			.children('.btndelete')
	// 			.click();
	// 	 };

	// 	 $('#todos').attr('checked', false);
	// 	 event.preventDefault(); 
	// },

	// establecerTotal : function (elemento)
	// {
	// 	var total = 0;
	// 	// ...Cada que se levante una tecla recuperaremos todos los importes y lo pasamos a un array...          
	// 	var array = pasarAJson($('.importe').serializeArray());
	// 	/*...¿Es un array de importes?...*/
	// 	if($.isArray(array.importes))
	// 	{    
	// 		// ...Si es cierto iteramos sobre los importes....
	// 		for(i in array.importes)
	// 			{	
	// 			// ....Cada posicion la convertimos a número y lo adicionamos al total....
	// 					total+=Number(array.importes[i]);
	// 			}
	// 			// ...Por fin tenemos el total y se lo asignamos a la etiqueta total para que se vea el cambio..
	// 			$('#total').text(total);
	// 	}
	// 	else
	// 	// {	..¡A no fue un arreglo!..Bueno entonces paso directo el importe al total....
	// 		$('#total').text(array.importes);	
	// 	}	            	
	// },
	marcarTodosCheck : function(elemento)
	{        
			marcarCheck(elemento);
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
			console.log(clientes);
			$('#cliente').autocomplete({ source: clientes});
			var esto = this;
			/*...Ahora obtenemos el nombre del cliente que seleccionamos de la lista y lo pasamos 
					 a otra función para que se encargue de buscar a su representante..*/
			$( "#cliente" ).on( "autocompleteselect", function( event, ui ) {
					esto.buscarRepresentante(ui.item.value);
			});
	},

	completarServicio : function()
	{
		var completar=new Array();
		
		for(i in app.coleccionDeServicios)
		{
			 completar[i] = app.coleccionDeServicios[i].nombre;
		}
		$('#bserv').autocomplete({ source : completar});
		var esto = this;
		$( "#bserv" ).on( "autocompleteselect", function( event, ui ) { esto.buscarServicio(ui.item.value); });

	},
	buscarServicio : function(elemento)
	{
			var modeloServicio = app.coleccionServicios.where({ nombre : elemento});
			var vistaServicioCotizacion = new app.VistaServicioCotizacion( { model: modeloServicio[0] } );
			this.$tablaServicios.html('');
			this.$tablaServicios.append( vistaServicioCotizacion.render().el );
	},

	sinCoincidencias  : function (e) 
	{
		if(e.keyCode===8)
		{
			this.cargarServiciosCo();
		}
	},

	// Validamos que el campo #cliente solo contenga letras
		soloLetras : function(e)
		{
			key = e.keyCode || e.which;
			tecla = String.fromCharCode(key).toLowerCase();
			letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
			especiales = "8-37-39-46";
			tecla_especial = false
			for(var i in especiales)
			{
					 if(key == especiales[i])
					 {
							 tecla_especial = true;
							 break;
					 }
			 }
			 if(letras.indexOf(tecla)==-1 && !tecla_especial)
			 {
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
				if(representante)  
				{
					$('#idcliente')       . val( idcliente            );
					$('#idrepresentante') . val( representante.id     );
					$('#representante')   . val( representante.nombre ); 		
				}
		},

		vistaPrevia : function(elemento)
		{
				localStorage.clear(); 
				var modeloservicios = pasarAJson($('.filas').serializeArray());
				var longitud = modeloservicios.id;
		
				var f = new Date();
				var modelocotizacion = pasarAJson($('#registroCotizacion').serializeArray());
				modelocotizacion.fecha = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
				modelocotizacion.idempleado = '46';
				app.coleccionLocalCotizaciones.create
				(
						modelocotizacion,
						{
							wait: true,
							success: function (data)
							{ 
								console.log('exito');
								for(i in longitud)
								{   
										app.coleccionLocalServicios.create
										(                           
												{     
														idcotizacion : data.get('id'),  
														idservicio   : modeloservicios.id[i],
														duracion     : modeloservicios.duracion[i],
														cantidad     : modeloservicios.cantidad[i],
														precio       : modeloservicios.precio[i],
														descuento    : modeloservicios.descuento[i]                          
												},
												{ 
														wait:true,
														success:function(exito)
														{ /*..Ok nuestros modelo de servicio cotizado se ha creado :D ..*/
																window.open("formatoCotizacion");
																console.log('Fue exito');
														},
														error:function(error)
														{/*..¡Oh no! :( algo no anda bien verifica el código de este archivo o 
																preguntale a la API que ¡onda! :/ ..*/
																console.log('Fue error ',error);
														}
												}
										);
								};
							},
							error: function (error) {}
						}
				);
			elemento.preventDefault();
		},

		/*..Una vez que tenemos lista la cotizacion nos toca el turno de guardala en la base de datos :D ...*/
		guardarCotizacion : function (elemento)
		{
			
			var forms = this.$('.form_servicio');
			for (var i = 0; i < forms.length; i++) {
				console.log(pasarAJson($(forms[i]).serializeArray()));
			};
			return;
			var f = new Date();
			var modelocotizacion = pasarAJson($('#registroCotizacion').serializeArray());

			modelocotizacion.fecha = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
			modelocotizacion.idempleado = '65';
		 
			/*...Ahora obtenemos el form de cada fila de la tabla servicios cotizando y lo pasamos a un array..*/
			var serviciosCotizados = pasarAJson($('.filas').serializeArray());
			/*..Como en el array serviciosCotizados no podemos usar el length entonces obtenermos el array de id´s
					de los servicios de la tabla y ahora este array si nos dejara usar length y asi poder iterar sobre el array
					serviciosCotizados ...*/
			var longitud = serviciosCotizados.id;
			$('#registroCotizacion')[0].reset();
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
												confirmar('La Cotizacón '+modelocotizacion.titulo+' se guardo con exito <br> ¿Desea crear otra?', 
												function(){ 
																		$('#tbody_servicios_seleccionados').html(''); 
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

	}, //Fin del metodo guardarCotizacion

	aumentarContador : function()
	{
		return this.contadorAlerta++;
	},
	/*Funciones creadas por geyser*/
		conmutarVistas 	: function () {
			var spans = $('.todos:checked'); /*Obtenemos todos los checkbox activados*/
			if (spans) {
				for (var i = 0; i < spans.length; i++) {
					/*Hacemos clic en los span correspondientes a los trs checkeados.
					  la vista de cada tr recibirá el evento clic y ejecutará la 
					  funcion correspondiente*/
					this.$('.iconos-operaciones #'+$(spans[i]).val().split('/')[1]).click();
				};
			};
			// this.$('.span_toggleSee').click();
		},
		eliminarVistas 	: function () {
			var spans = $('.todos:checked'); /*Obtenemos todos los checkbox activados*/
			if (spans.length) { /*Solo si hay servicios marcados*/
				var here = this;
				confirmar('¿Los servicios marcados están siendo cotizados, estás seguro de eliminarlos?',
					function () {
						for (var i = 0; i < spans.length; i++) {
							/*Hacemos clic en los span correspondientes a los trs checkeados.
							  la vista de cada tr recibirá el evento clic y ejecutará la 
							  funcion correspondiente*/
							here.$('.iconos-operaciones #'+$(spans[i]).val().split('/')[0]).click();
						};
					},
					function () {});
			};
			// this.$('.span_eliminar_servicio').click();
		}


}); //Fin de la vista Nueva Cotización

app.vistaNuevaCotizacion = new app.VistaNuevaCotizacion();
