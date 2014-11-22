var app = app || {};

app.VistaSeccion = Backbone.View.extend({
	tagName	: 'tr',
	// className : 'tr_seccion',
	plantillas : {
		plantillaTrSeccion :  _.template( $('#td_seccion').html() )
	},
	events 	: {
		// 'click .span_eliminar_seccion' : 'eliminarTr',

		'change .number'					: 'calcularSeccion',
		// 'keyup .number'						: 'calcularSeccion',
		'mousewheel .number'				: 'calcularSeccion',
		// 'click .number'				: 'calcularSeccion',
		'blur .number'				: 'calcularSeccion',
	},
	initialize 	: function () { },
	render: function (id) {
		/*El parametro id, es la clave del servicio que se está cotizando*/
		this.$el.html( this.plantillas.plantillaTrSeccion({ id:id }) );
		/*Establecer el precio en el input escondido para calcular el precio
		  de la sección*/
		this.$('.precio_hora').val($('#precio_hora').val());
		this.calcularSeccion();
		return this;
	},
	calcularSeccion : function () {
		var horas 		= this.$('.horas').val(),
			precio_hora = this.$('.precio_hora').val();

		/*El capo Horas es un input number, por lo que cuando se escribe
		  un número con letras, el campo lo rechaza y adopta el valor ''*/
		if (horas == '') {
			alerta('El campo <b>Horas</b> solo acepta números', function () {});
			this.$('.horas').val('1');
			return;
		};

		/*Mostramos el costo total de la seccion*/
		this.$('.costoSeccion').val( horas * precio_hora ).trigger('change');
		
		/*Los campos visibles al usuario no serán sirven dido que se encuentrar
		  en tds de tabla, para que se puede generar un json por casa sección 
		  del servicio que se encuantra cotizando, debemos pasar esos valores
		  a unos input hidden que si se encuentran en formularios.*/
		this.$('input[name="seccion"]')		.val(this.$('#seccion')		.val());
		this.$('input[name="descripcion"]')	.val(this.$('#descripcion')	.val());
		this.$('input[name="horas"]')	.val(horas);
		this.$('input[name="precio_hora"]')		.val(precio_hora);
	},
});

app.VistaCotizarServicio = Backbone.View.extend({
	tagName 	: 'tr',
	plantillas 	: {
		plantillaSeleccionado :  _.template( $('#tds_servicio_seleccionado').html() )
	},
	events 		: {
		'click #span_otraSeccion'	: 'apilarSeccion',
		'click .span_toggleSee' : 'conmutarVista',

		'change .costoSeccion' : 'carlcularImporte',
		'click .span_eliminar_seccion' : 'eliminarSeccion',
	},
	initialize 	: function () {
	},
	render 		: function () {
		this.$el.html(this.plantillas.plantillaSeleccionado(this.model.toJSON()));
		var here = this;
		this.apilarSeccion();
		
		return this;
	},
	apilarSeccion 	: function () {
		var vistaSeccion = new app.VistaSeccion();
		this.$('tbody').append( vistaSeccion.render(this.model.get('id')).el );
		/*Despues de que el se ha apilado el servicio a cotizar,
		  calculamos instantaneamente el importe del servicio*/
		this.carlcularImporte();
	},
	conmutarVista 	: function (e) {
		/*Cambiamos el icono del boton, arriba o abajo segun sea el caso*/
		this.$(e.currentTarget).toggleClass('icon-circleup');
		/*Guardamos todos los td que seran afectados.*/
		var selector = '#table_servicio_'+this.model.get('id')+' thead #tr_titulos_secciones,';
			selector += '#table_servicio_'+this.model.get('id')+' tbody,';
			selector += '#table_servicio_'+this.model.get('id')+' tfoot';
		/*La función slideToggle solo funciona con td, no con table, tr, thead, tbody no tfoot*/
		this.$(selector).fadeToggle('fast');
	},
	eliminarSeccion 		: function (e) {
		/*El argumento e, es el span para elliminar
		  la sección. Recorremos las tags padres hasta
		  encontrar el tr se la sección, por eso
		  son las dos funciones parent.*/
		this.$(e.currentTarget).parent().parent().remove();
		this.carlcularImporte();
	},
	carlcularImporte 	: function () {
		/*Cada seccion tiene un imput con class ".costoSeccion."
		  tomando en cuenta que cualquier servicio puede tener
		  varias secciones, tenemos que obtener todos los valires
		  de los precios de cada sección, sumarlos y colocar el
		  resultado en el campo importe.*/
		var costoSecciones = this.$('.costoSeccion'),
			importe = 0,
			here = this;
		for (var i = 0; i < costoSecciones.length; i++) {
			importe += parseInt(this.$(costoSecciones[i]).val());
		};
		/*Establecemos el valor del importe, y justo despues
		  disparamos un evento change para que la vista general
		  realice el cálculo del subtotal. Utilizamos la funcion
		  setTimeout*/
		setTimeout(function() {
			here.$('.importe').val(importe).trigger(jQuery.Event('change'));
		}, 10);		
	},
	// validarTypeNumber	: function (e) {
	// 	// console.log(e.currentTarget.type, $(e.currentTarget).val(), e);
	// 	// validarInput(e.currentTarget.type, $(e.currentTarget).val(), e);
	// }
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
		'change     #busqueda'     	: 'buscarRepresentante',     //Cuando escribes una letra, despliega un menu de sugerencias
		'click 	   #guardar'	   	: 'guardar', //Guarda la cotización
		'click     .todos'	     	: 'marcarTodosCheck',  //Marca todas las casillas de la tabla servicios cotizando
		'click     #vista-previa' 	: 'vistaPrevia',

		/*Botones del thead los servicios que se están cotizando*/
		'click .span_deleteAll'	 		: 'eliminarServicios',
		'click .span_eliminar_servicio' : 'eliminarServicio',
		'click .span_toggleAllSee'	 	: 'conmutarServicios',
		
		'change     .importe'     : 'calcularSubtotal',   //Escucha los cambios en los inputs numericos y actualiza el total

		'change 	#precio_hora' : 'dispararCambio',
		'mousewheel #precio_hora' : 'dispararCambio',
		'blur 		#precio_hora' : 'dispararCambio',
		// 'keyup 		#precio_hora' : 'dispararCambio',
		// 'click 		#precio_hora' : 'dispararCambio',
		// 'focus 		#precio_hora' : 'dispararCambio',

		'change 	.input-tfoot' : 'calcularTotal',
		'mousewheel .input-tfoot' : 'calcularTotal',
		'blur 		.input-tfoot' : 'calcularTotal',
		// 'keyup 		.input-tfoot' : 'calcularTotal',
		// 'click 		.input-tfoot' : 'calcularTotal',
		// 'focus 		.input-tfoot' : 'calcularTotal',

		'click #cancelar'	: 'cancelar'
	},

	initialize : function () {
		this.listenTo(app.coleccionCotizaciones, 'reset', function () {
			var folio = app.coleccionCotizaciones.establecerFolio();
			this.$('input[name="folio"]').val(folio);
			this.$('#h4_folio').text('Folio: '+ folio).fadeIn('fast');
		});
		this.render();
		// // Inicializamos la tabla servicios que es donde esta la lista de servicios a seleccionar
		// // this.$tablaServicios = this.$('#listaServicios');
		this.contadorAlerta = 1;

		localStorage.clear();
	},
	render : function () {
		this.$('#registroCotizacion').html( $('#plantilla-formulario').html() );
		// Invocamos el metodo para cargar y pintar los servicios
		this.cargarServiciosCo();
		loadSelectize_Client('#busqueda',app.coleccionClientes.toJSON());

		this.$('#table_servicios').tablesorter({
			theme: 'blue',
		    widgets: ["zebra", "filter"],
		    widgetOptions : {
		      filter_external : '.search-services',
		      filter_columnFilters: false,
		      filter_saveFilters : true,
		      filter_reset: '.reset'
		    }
		});

		this.$('#fecha').val( formatearFechaUsuario(new Date()) );
		/*BORRAR PARA PRODUCCIÓN (HAY MÁS)*/this.$('#titulo').val('Cotizaicón No. '+(Math.random()).toFixed(3) *1000);

		/*FOLIO. En la cración de una cotización ocurrira el fetch,
		  pero cuando se edite una cotización no se realizará.
		  Esto es porque el la longitud de la colección en la
		  creción de la cotizacion es 0, pero en la cosulta, la
		  longitud es diferente mayor*/
		if (app.coleccionCotizaciones.length == 0) {
			app.coleccionCotizaciones.fetch({reset:true});
		};

		return this;
	},
	cargarServicioCo	: function (serviciosCotizacion) {
		/*....................Instanciamos un modelo servicios y le pasamos el modelo.............*/
		var vistaTrServ = new app.VistaTrServ( { model:serviciosCotizacion } );
		/*..Pintamos el modelo en la vista servicio mendiante una herencia al metodo render de la vista servicio...*/
		this.$('#tbody_servicios').append( vistaTrServ.render().el );
	},
	cargarServiciosCo 	: function () {
		/*....hacemos un ciclo each a la colección pasandole cada modelo de servicio para poder pintarlo en la tabla......*/
			this.$('#tbody_servicios').html('');
			app.coleccionServicios.each(this.cargarServicioCo, this);
	},
	calcularSubtotal 	: function () {
		var total = 0,
			decimales;
		/*Cada cambio en cualquiera de los importes activará los campos,
		  para que la función serializeArray pueda obtener sus valores,
		  de lo contrario no funcionará*/          
		var array = pasarAJson(this.$('.importe').attr('disabled',false).serializeArray());
		/*Despues de haber obtenido los importes desactivamos nuevamente
		  los campos*/
		this.$('.importe').attr('disabled',true);
		
		/*...¿Es un array de importes?...*/
		if($.isArray(array.importes)) {    
			// ...Si es cierto iteramos sobre los importes....
			for(i in array.importes)
				{	
				// ....Cada posicion la convertimos a número y lo adicionamos al total....
						total+=Number(array.importes[i]);
				}
				// ...Por fin tenemos el total y se lo asignamos a la etiqueta total para que se vea el cambio..
				this.$('#subtotal').val(total.toFixed(2));

				/*Formateamos subtotal para mostrarlo*/
				// total = '' + total.toFixed(2);
				// total = total.split('.');
				// decimales = total[1];
				// total = conComas(total[0].split(''));
				
				this.$('#label_subtotal').text( '$'+conComas(total.toFixed(2)) );
		} else {	/*..¡A no fue un arreglo!..Bueno entonces paso directo el importe al total....*/
			/*Evaluamos si hay algun valor en el objeto.
			  Si no lo hay colocamos un cero, puesto que
			  no hay importe que sumar*/
			if ( _.isUndefined(array.importes) ) {
				this.$('#label_subtotal').text('$0');
				this.$('#subtotal').val(0);
			} else{
				/*Si hay almenos un importe lo imprimimos
				  en pantalla en su campo correspondiente*/
				this.$('#subtotal').val(Number(array.importes).toFixed(2));

				/*Formateamos subtotal para mostrarlo*/
				// total = '' + Number(array.importes).toFixed(2);
				// total = total.split('.');
				// decimales = total[1];
				// total = conComas(total[0].split(''));
				
				/*Formateamos subtotal para mostrarlo*/
				this.$('#label_subtotal').text( '$'+conComas(Number(array.importes).toFixed(2)) );
			};
			
		}
		this.calcularTotal();
	},
	calcularTotal 		: function () {
		var valores = this.$('.input-tfoot');
		/*El capo Descuento es un input number, por lo que cuando se escribe
		  un número con letras, el campo lo rechaza y adopta el valor ''*/
		if ($(valores[1]).val() == '') {
			alerta('El campo Descuento solo acepta números', function () {});
			$(valores[1]).val('0');
		};
		var	total = Number($(valores[0]).val()),
			desc  = Number($(valores[1]).val()) / 100,
			iva   = Number($(valores[2]).val()) / 100,
			decimales;

		total = total - total * desc;
		total = total + total * iva;
		this.total = total.toFixed(2); // Sirve para la clase contrato
		
		this.$('#label_total').text( '$'+conComas(total.toFixed(2)) );

		this.calcularTotalHoras();
	},
	calcularTotalHoras	: function (argument) {
		var horas = this.$('.horas'),
			total = 0;
		this.$('#totalHoras').val(function () {
			for (var i = 0; i < horas.length; i++) {
				total += Number( $(horas[i]).val() );
			};
			return total;
		}());
	},
	marcarTodosCheck 	: function(e) {        
			marcarCheck(e, '#tbody_servicios_seleccionados');
	},
	buscarRepresentante 		: function (e) {
		var here = this,
			representante = app.coleccionRepresentantes.findWhere({ idcliente:$(e.currentTarget).val() });
		if (representante) {
			this.$('#nombreRepresentante').val(representante.get('nombre'));
			this.$('#idrepresentante').val(representante.get('id'));
		} else{
			alerta('El cliente seleccionado no tiene representante (<b>Requerido</b>)', function () {});
		};
	},
	vistaPrevia 		: function(e) {
		localStorage.clear();

		var json = this.obtenerDatos(),
			self = this;
		/*La función obtenerDatos devuelve un json
		  de los datos básicos de la cotización y
		  los datos de las secciones para la coti-
		  zación. obtenerDatos rompe su ejecución
		  si no se llegara a especificar un cliente,
		  por lo que devolverá undefined, en ese caso
		  en ésta funcion rompemos la ejecución para
		  evitar crear una cotización innecesaria*/
		if (!json) {
			return;
		};

		app.coleccionCotizaciones_L.create(json.datos, {
			wait: true,
			success: function (exito) {
				for(i in json.secciones) {   
					app.coleccionServicios_L.create(json.secciones[i], { 
						wait:true,
						success:function(exito) {
							if (self.aumentarContador() == json.secciones.length) {
								self.contadorAlerta = 1;
								window.open("formatoCotizacion");
							};
							// console.log('Fue exito');
						},
						error:function(error) {
							// console.log('Fue error ',error);
						}
					});
				};
			},
			error: function (error) {}
		});
		e.preventDefault();
	},
	cancelar			: function () {
		location.href = 'cotizaciones_consulta';
	},
	guardar 	: function (e) {
		var json = this.obtenerDatos(),
			self = this;

		/*La función obtenerDatos devuelve un json
		  de los datos básicos de la cotización y
		  los datos de las secciones para la coti-
		  zación. obtenerDatos rompe su ejecución
		  si no se llegara a especificar un cliente,
		  por lo que devolverá undefined, en ese caso
		  en ésta funcion rompemos la ejecución para
		  evitar crear una cotización innecesaria*/
		if (!json) {
			return;
		};
		json.datos.status = true;
		json.datos.visibilidad = true;
		
		$('#block').toggleClass('activo');
		 Backbone.emulateHTTP = true;
		 Backbone.emulateJSON = true; 
		 //Hacemos un CREATE con los datos primarios de la cotización
		 app.coleccionCotizaciones.create(json.datos, {
			wait:true,
			success:function(exito){
				console.log('se guardo', exito);
				self.guardarSeccion(exito.get('id'), json.secciones);
			},
			error:function(error){
				// console.log('Fue error ',error);
			}
		});
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
		localStorage.clear();         
		e.preventDefault();
	},
	obtenerDatos	: function () {
		var forms = this.$('.form_servicio'),
			json  = pasarAJson(this.$('#titulo, #busqueda, #idrepresentante').serializeArray()),
			f = new Date();
		/*Cortafuego para forzar establecer los siguientes datos*/
		if (json.titulo == '' || json.idcliente == '' || json.idrepresentante == '') {
			alerta('Escriba un <b>título</b> para la cotización y seleccione un <b>cliente</b>', function () {});
			return false; // Terminamos el flujo del código
		};

		json = { secciones : [], datos : '' };
		// Datos básicos
			json.datos = pasarAJson(this.$('#registroCotizacion').serializeArray());
			json.datos.fechacreacion = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + (f.getDate() +1);
			/*BORRAR PARA PRODUCCIÓN (HAY MÁS)*/json.datos.idempleado = '65';

		/*Cortafuego. Debe haber al menos 1 servicio para cotizarlo*/
		if (!forms.length) {
			alerta('Seleccione al menos un <b>servicio</b> para cotizarlo', function () {});
			return false; // Terminamos el flujo del código
		};
		/*Servicios cotizados*/
			for (var i = 0; i < forms.length; i++) {
				json.secciones.push( pasarAJson($(forms[i]).serializeArray()) );
			};

		// Dato basura
		delete json.datos.todos;

		json.datos.version = 1;

		return json;
	},
	/*Funciones creadas por geyser*/
	guardarSeccion	: function (idCotizacion, secciones) {
		var self = this;
		for (var i = 0; i < secciones.length; i++) {
			secciones[i].idcotizacion = idCotizacion;
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionServiciosCotizados.create(secciones[i], {
				wait	: true,
				success	: function (exito) {
					if (self.aumentarContador() == secciones.length) {
						self.guardado();
					};
					// ok('La seccion: <b>'+exito.toJSON().seccion+'</b> ha sido guardada');
				},
				error	: function (error) {
					if (self.aumentarContador() == secciones.length) {
						self.noGuardada();
					};
					// error('Error al guardar seccion: <b>'+error.toJSON().seccion+'</b>');
				}
			});
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		};
	},
	guardado		: function () {
		var self = this;
		// Desbloqueamos todos los botones
		$('#block').toggleClass('activo');
		alerta('¡Cotización guardada!', function () {
			confirmar('<b>¿Deseas crear otra cotización?</b>', function () {
				// Necesitamos resetear la coleccion para,
				// traer nuevamento todos los datos junto
				// con el folio más actual. Debemos terminar
				// el listener del evento reset que se encuentra
				// en la función initialize para poder usar la
				// funcion reset() que elimina todo los modelo
				// en la coleccion.
				app.coleccionCotizaciones.off().reset();
				// Inicializamos todo nuevamente para otra
				// cotizacion
				self.initialize();
			}, function () {
				location.href = 'cotizaciones_consulta';
			});
		});
	},
	noGuardada	: function () {
		$('#block').toggleClass('activo');
		alerta('La cotización ha sido guardada, pero ocurrieron algunos errores<br>Recomendamos que revice la cotización en la consulta de cotizaciones', function () {
			location.href = 'cotizaciones_consulta';
			this.resetearContador();
		});
	},
	aumentarContador 	: function() {
		return this.contadorAlerta++;
	},
	resetearContador	: function () {
		this.contadorAlerta = 1;
	},
	conmutarServicios 		: function () {
		var spans = this.$('input[name="todos"]:checked'); /*Obtenemos todos los checkbox activados*/
		if (spans) {
			for (var i = 0; i < spans.length; i++) {
				/*Hacemos clic en los span correspondientes a los trs checkeados.
				  la vista de cada tr recibirá el evento clic y ejecutará la 
				  funcion correspondiente*/
				this.$('.iconos-operaciones #'+$(spans[i]).attr('id').split('/')[1]).click();
			};
		};
		// this.$('.span_toggleSee').click();
	},	
	eliminarServicio 		: function (e) {

		/*Antes de eliminar la vista buscamos el servicio correspondiente en la lista de servicios*/
		this.$(
			'#table_servicios #'
			+this.$(e.currentTarget)
			.attr('id')
		)							/*Obtenemos el imput checkbox*/
		.attr('disabled',false) 	/*Desmarcamos el checkbox*/
		.attr('checked',false) 		/*Activamos el checkbox*/
		.parents('tr')				/*Buscamos tr que contiene el checkbox*/
		.css('color','#333'); 		/*Reestablecemos el color original del texto*/

		/*En vez de eliminar la vista del servicio que se está cotizando
		  lo hacemos en esta clase y no en su propia clase, debido a que
		  necesitamos ejecutar la función calcularSubtotal que se encuentra
		  en esta clase.*/
		this.$(e.currentTarget).parents('.td_servicio').remove();
		this.calcularSubtotal();
	},
	eliminarServicios 		: function () {
		var spans = this.$('input[name="todos"]:checked'); /*Obtenemos todos los checkbox activados*/
		if (spans.length) { /*Solo si hay servicios marcados*/
			var here = this;
			confirmar('¿Los servicios marcados están siendo cotizados, estás seguro de eliminarlos?',
				function () {
					for (var i = 0; i < spans.length; i++) {
						/*Hacemos clic en los span correspondientes a los trs checkeados.
						  la vista de cada tr recibirá el evento clic y ejecutará la 
						  funcion correspondiente*/
						here.$('.iconos-operaciones #'+$(spans[i]).attr('id').split('/')[0]).click();
					};
				},
				function () {});
		};
		// this.$('.span_eliminar_servicio').click();
	},	
	dispararCambio		: function (e) {
		var precioHora = $(e.currentTarget).val();
		/*El capo Precio/Horas es un input number, por lo que cuando se escribe
		  un número con letras, el campo lo rechaza y adopta el valor ''*/
		if (precioHora == '') {
			alerta('El campo <b>Precio/Horas</b> solo acepta números', function () {});
			$(e.currentTarget).val('300');
		};
		/*Los campo con class .precio_hora están ocultos pero son
		  fundamentales para los cálculos de los totales de cada
		  sección, por tanto los actualizamos.*/
		this.$('.precio_hora').val(precioHora).trigger('change');
	}
});