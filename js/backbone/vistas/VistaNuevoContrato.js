app	= app || {};
app.VistaPago = Backbone.View.extend({
	tagName 	: 'tr',
	className 	: 'warning',
	plantilla_tr_pagos		: _.template($('#tr_pagos').html()),
	events		: {
		'click .icon-unlock'	: 'bloquear',
		'click .icon-lock'		: 'desbloquear'
	},
	initialize		: function () {
		this.listenTo(this.model, 'change', this.render);
		this.residuo = 0.0;
	},
	render			: function () {
		this.$el.html(this.plantilla_tr_pagos(this.model.toJSON()));
		var thiS = this,
			input_renta = this.$el.find('.input_renta');

		input_renta.one('change',function(){
			thiS.modificarPago(this);
		});
		return this;
	},
	bloquear		: function () {
		this.model.set({active:'active', atrClase:'bloqueado', candado: 'icon-lock', disabled:'disabled'});
	},
	desbloquear		: function () {
		this.model.set({active:'', atrClase:'input_renta', candado: 'icon-unlock', disabled:''});
	},
	modificarPago	: function (elem) {
		var pagoActual = parseFloat(this.model.get('pago')),
			id = '#'+$(elem).attr('id');
		// console.log();
		var residuo = (
			pagoActual 	- 	parseFloat( 
								(this.model.set({pago:$(elem).val()})).get('pago') )
							)
			.toFixed(2);

		this.bloquear();
		app.vistaNuevoContrato.equilibrarPagos(residuo);
		this.desbloquear();
		this.$(id).focus();
	}
});
app.VistaNuevoContrato = app.VistaNuevaCotizacion.extend({
	/*Herencias*/
	events : {
		// Eventos orignales de la clase VistaNuevaCotizacion
			'change     #busqueda'     	: 'buscarRepresentante',
			'click 	   #guardar'	   	: 'guardarCotizacion',
			'click     #todos'	     	: 'marcarTodosCheck',
			'click     #vista-previa' 	: 'vistaPrevia',

			// Botones del thead los servicios que se están cotizando
			'click .span_deleteAll'	 		: 'eliminarServicios',
			'click .span_eliminar_servicio' : 'eliminarServicio',
			'click .span_toggleAllSee'	 	: 'conmutarServicios',
			
			//Escucha los cambios en los inputs numericos y actualiza el total
			'change     .importe'     : 'calcularSubtotal',

			'change 	#precio_hora' : 'dispararCambio',
			'keyup 		#precio_hora' : 'dispararCambio',
			'mousewheel #precio_hora' : 'dispararCambio',
			'click 		#precio_hora' : 'dispararCambio',
			'focus 		#precio_hora' : 'dispararCambio',

			'change 	.input-tfoot' : 'calcularTotal',
			'keyup 		.input-tfoot' : 'calcularTotal',
			'mousewheel .input-tfoot' : 'calcularTotal',
			'click 		.input-tfoot' : 'calcularTotal',
			'focus 		.input-tfoot' : 'calcularTotal',

			'click #cancelar'	: 'cancelar',

		// Eventos de contrato
			'change .btn_plan'		: 'conmutarTablaPlan',
			'change .n_pagos'		: 'obtenerValor',
			'click #btn_recargarPagos'	: 'recargarPagos'
	},
	initialize : function () {
		// this.listenTo(app.coleccionCotizaciones, 'reset', this.obtenerFolio);
		this.render();
		// // Inicializamos la tabla servicios que es donde esta la lista de servicios a seleccionar
		// // this.$tablaServicios = this.$('#listaServicios');
		this.contadorAlerta = 1;

		localStorage.clear();
	},
	render : function () {
		this.$('#registroContrato').html( $('#plantilla-formulario').html() );
		// Invocamos el metodo para cargar y pintar los servicios
		this.cargarServiciosCo();
		loadSelectize_Client('#busqueda',app.coleccionClientes.toJSON());
		loadDatepicker('.datepicker');

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

		// this.$('#fecha').val( formatearFechaUsuario(new Date()) );
		/*BORRAR PARA PRODUCCIÓN (HAY MÁS)*/this.$('#titulo').val('Contrato No. '+(Math.random()).toFixed(3) *1000);

		/*FOLIO. El la cración de una cotización ocurrira el getch,
		  pero cuando se edite una cotización no se realizará*/
		// if (app.coleccionCotizaciones.length == 0) {
		// 	app.coleccionCotizaciones.fetch({reset:true});
		// };

		return this;
	},
	/*Funciones de contrato*/
	conmutarTablaPlan		: function (elem) {
		$('.tabla_visible').removeClass().addClass('tabla_oculto');
		$( '#tbody_'+$(elem.currentTarget).val() )
		.removeClass()
		.addClass('tabla_visible');

		this.establecerPagos( 
			$('#tbody_'+$(elem.currentTarget).val()+' .n_pagos').val());
	},
	establecerPagos			: function (nPagos) {
		// $('#margen').text(totalNeto);
		// totalNeto = totalNeto.split('');
		// totalNeto.shift();

		/*Limpiamos el tbody de pagos cada vez que se entre a esta
		  función*/
		$('#tbody_pagos').html('');

		var plazo = 1,
			aumento = 0,
			fecha = '',
			fechaNormal = '',
			fecha2 = '',
			candado = 'icon-unlock',
			disabled = '',
			active = '',
			objDate;

		if (this.$('#porEvento').is(':checked')) {
			plazo = parseInt($('#plazo').val());
			aumento = plazo;
			fecha = $('#fechainicioEvento').val();
			objDate = new Date(new Date(fecha).getTime() + ((plazo*nPagos)*24*60*60*1000));
			fecha2 = formatearFechaUsuario(objDate);
			if (fecha2 != 'NaN/NaN/NaN') {
				// $('#vencimientoPlanEvento').val( fecha2 );
				$('#vencimientoPlanEvento').datepicker( "setDate", objDate, 'd MM, yy' );
			} else{
				$('#vencimientoPlanEvento').val( '' );
			};
			fecha2 = fecha2.split('/');
			fecha2 = fecha2[2] + "-" + fecha2[1] + "-" + fecha2[0];
			$('#fechafinalEvento').val(fecha2);

			disabled = '';
		} else if (this.$('#iguala').is(':checked')){
			plazo = 30;
			aumento = plazo;
			fecha = $('#fechainicioIguala').val();
			objDate = new Date(new Date(fecha).getTime() + ((plazo*nPagos)*24*60*60*1000));
			fecha2 = formatearFechaUsuario(objDate);
			if (fecha2 != 'NaN/NaN/NaN') {
				// $('#vencimientoPlanIguala').val( fecha2 );
				$('#vencimientoPlanIguala').datepicker( "setDate", objDate, 'd MM, yy' );
			} else{
				$('#vencimientoPlanIguala').val( '' );
			};
			fecha2 = fecha2.split('/');
			fecha2 = fecha2[2] + "-" + fecha2[1] + "-" + fecha2[0];
			$('#fechafinalIguala').val(fecha2);

			candado = 'icon-lock';
			disabled = 'disabled';
			active = 'active';
		} else {console.log('Sin plan seleccionado');return;};

		objDate = new Date(new Date(fecha).getTime() + (1*24*60*60*1000));
		fechaNormal = formatearFechaUsuario(objDate);
		fecha2 = fechaNormal.split('/');

		var Modelo;
		this.vistaPago = [];
		for (var i = 0; i < nPagos; i++) {
			Modelo = Backbone.Model.extend({
				defaults	: { 
					id 		: i,
					n 		: i+1,
					fecha	: fechaNormal,
					fecha2	: fecha2[2] + "-" + fecha2[1] + "-" + fecha2[0],
					pago 	: (this.total/nPagos).toFixed(2),

					candado	: candado,
					active 		: active,
					disabled	: disabled,

					atrClase	: 'input_renta'
				}
			});
			this.vistaPago[i] = new app.VistaPago({model : new Modelo});

			$('#tbody_pagos').append(this.vistaPago[i].render().el);

			objDate = new Date(new Date(fecha).getTime() + (plazo*24*60*60*1000))
			fechaNormal = formatearFechaUsuario(objDate);
			fecha2 = fechaNormal.split('/');
			plazo = plazo + aumento;
		};
		this.modificarPagos();
	},
	modificarPagos			: function () {
		var margen = $('#totalNeto').text().split(''),
			rentas = $('.hidden_renta'),
			suma = 0.0, /*Debe inicializarse como flotante*/
			masmenos;

		margen.shift();
		margen = margen.join('');
		margen = parseInt(margen).toFixed();

		for (var i = 0; i < rentas.length; i++) {
			suma += parseFloat($(rentas[i]).val());
		};

		masmenos = suma;
		suma = suma.toFixed();
		if (suma > margen || suma < margen) {
			$('#margen').text('$'+masmenos.toFixed(2)).css('color','red');
		} else{
			$('#margen').text($('#totalNeto').text()).css('color','black');
		};
	},
	obtenerValor	: function (elem) {
		if ($(elem.currentTarget).val() < 101) {
			this.establecerPagos( 
				parseInt($(elem.currentTarget).val()), 
				this.total );
		} else{
			$(elem.currentTarget).val(1);
			this.obtenerValor(elem);
		};
	},
	equilibrarPagos			: function (residuo) {
		var rentas = $('.input_renta');
		var pagoNuevo = 0.0;
		residuo = residuo/parseFloat(rentas.length);
		for (var i = 0; i < rentas.length; i++) {
			pagoNuevo = (parseFloat($(rentas[i]).val()) + residuo).toFixed(2);
			// $(rentas[i]).val(pagoNuevo);
			this.vistaPago[parseInt($(rentas[i]).attr('id'))].model.set({pago:pagoNuevo});
		};
		this.modificarPagos();
	},	
	recargarPagos 			: function () {
		$('.n_pagos').first().trigger('change');
	},
});


// app.VistaServicioSeleccionado = Backbone.View.extend({
// 	tagName	: 'tr',
// 	plantillaDefault	: _.template($('#tds_servicio_seleccionado').html()),
// 	events					: {
// 		'click .eliminar'		: 'eliminarSeleccion',
// 		// 'keyup  #descuento'		: 'establecerPrecio',
// 		// 'keyup  #cantidad'		: 'calcularTotal',
// 		// 'keyup  #precio'		: 'calcularDescuento',
// 		// 'change #descuento'		: 'establecerPrecio',
// 		// 'change #cantidad'		: 'calcularTotal',
// 		// 'change #precio'		: 'calcularDescuento'
// 	},
// 	initialize			: function () {
// 		this.listenTo(this.model, 'change', this.render);
// 		this.listenTo(this.model, 'change', this.calcularImporteIVATotalNeto);
// 		/*Es para el modulo de consulta de contratos*/
// 			this.listenTo(this.model, 'destroy', this.remove);
// 	},
// 	render				: function () {
// 		// console.log(this.model.toJSON());
// 		this.$el.html(this.plantillaDefault( this.model.toJSON() ));

// 		var thiS = this;
// 		var descuento = this.$el.find('#descuento');
// 		descuento.one('change',function (){
// 			thiS.calcularTotal(this);
// 		});
// 		var cantidad = this.$el.find('#cantidad');
// 		cantidad.one('change',function (){
// 			thiS.calcularTotal(this);
// 		});
// 		var precio = this.$el.find('#precio');
// 		precio.one('change',function (){
// 			thiS.calcularTotal(this);
// 		});

// 		return this;
// 	},
// 	eliminarSeleccion	: function (elem) {
// 		$('#tbody_servicios .check_posicion #servicio_'+$(elem.currentTarget).attr('id')).attr('disabled',false)
		
// 		this.$el.remove();

// 		this.calcularImporteIVATotalNeto();
// 	},
// 	calcularDescuento	: function (elem) {
// 		var precio 		= this.$('#precio').val();
// 		this.$('#descuento').val(( 100 - ((precio * 100)/this.model.get('precioDefault')) ).toFixed());
// 		this.calcularTotal(elem);
// 	},
// 	calcularTotal		: function (elem) {
// 		var precio 		= this.$('#cantidad').val() * this.$('#precio').val();
// 		var descuento 	= precio*(this.$('#descuento').val()/100);
// 		var json 		= pasarAJson(this.$('.inputsServicios').serializeArray());
// 		json.total 		= (precio - descuento).toFixed(2);
// 		/*Respaldamos id del input que se está editando*/
// 		var idHtml 		= $(elem).attr('id');
		
// 		/*Al establecer nuevos valores en el modelo,
// 		  ejecutaremos la función render, que está 
// 		  especificado en la función initialize en el
// 		  listener para con evento change*/
// 		this.model.set(json);

// 		/*Hacemos focus sobre el input en que se esta.
// 		  Al hacerlo el texto se auto selecciona, para
// 		  evitar tal efecto se reescribe su valor para
// 		  que el cursor se posiciones al fonal del texto*/
// 		this.$('#'+idHtml).focus().val( this.$('#'+idHtml).val() );
		
// 	},
// 	calcularImporteIVATotalNeto	: function () {
// 		var totales = $('.total');
// 		var importe = 0;
// 		for (var i = 0; i < totales.length; i++) {
// 			importe += parseInt($(totales[i]).val());
// 		};
// 		$('#importe').text('$'+importe.toFixed(2));
// 		$('#IVA').text('$'+(importe*app.iva).toFixed(2));
// 		$('#totalNeto').text('$'+(importe + (importe*app.iva)).toFixed(2));

// 		/*Provocamos un click automatico para que la tabla de pagos
// 		  se actualice*/
// 		var a = $('.btn_plan');
// 		for (var i = 0; i < a.length; i++) {
// 			if ($(a[i]).is(':checked')) {
// 				$(a[i]).attr('checked',false);
// 				$(a[i]).click();
// 			};
// 		};
// 	}
// });

// app.VistaServicioContrato = app.VistaServicio.extend({
// 	tagName	: 'tr',
// 	plantillaDefault	: _.template($('#plantillaServicio').html()),
// 	events	: {
// 		'click .checkbox_servicio'		: 'apilarServicio',
// 		// 'click .icon_detalles'			: 'conmutarInfo' //Descomentar si desea habilitar la visibilidad de info de cada servicio
// 	},
// 	apilarServicio		: function (elem) {
// 		var ModelCopia = this.model;
// 		ModelCopia.set({
// 			idserv 			: this.model.get('id'),
// 			descuento 		: '0',
// 			cantidad		: '1',
// 			total 			: parseInt(this.model.get('precio')).toFixed(2)
// 		});
// 		ModelCopia = Backbone.Model.extend({
// 			defaults: ModelCopia.toJSON()
// 		});
// 		var vista = new app.VistaServicioSeleccionado({ model:new ModelCopia });
// 		$('#tbody_servicios_seleccionados').append(vista.render().el);
// 		$(elem.currentTarget).attr('disabled',true);
// 		vista.calcularImporteIVATotalNeto();
// 	},
// });

// app.VistaPago = Backbone.View.extend({
// 	tagName 	: 'tr',
// 	plantilla_tr_pagos		: _.template($('#tr_pagos').html()),
// 	events		: {
// 		'click .icon-unlock'	: 'bloquear',
// 		'click .icon-lock'		: 'desbloquear'
// 	},
// 	initialize		: function () {
// 		this.listenTo(this.model, 'change', this.render);
// 		this.residuo = 0.0;
// 	},
// 	render			: function () {
// 		this.$el.html(this.plantilla_tr_pagos(this.model.toJSON()));
// 		var thiS = this,
// 			input_renta = this.$el.find('.input_renta');

// 		input_renta.one('change',function(){
// 			thiS.modificarPago(this);
// 		});
// 		return this;
// 	},
// 	bloquear		: function () {
// 		this.model.set({atrClase:'bloqueado', candado: 'icon-lock', checked:'disabled'});
// 	},
// 	desbloquear		: function () {
// 		this.model.set({atrClase:'input_renta', candado: 'icon-unlock', checked:''});
// 	},
// 	modificarPago	: function (elem) {
// 		var pagoActual = parseFloat(this.model.get('pago')),
// 			id = '#'+$(elem).attr('id');
// 		// console.log();
// 		var residuo = (
// 			pagoActual 	- 	parseFloat( 
// 								(this.model.set({pago:$(elem).val()})).get('pago') )
// 							)
// 			.toFixed(2);

// 		this.bloquear();
// 		app.vistaNuevoContrato.equilibrarPagos(residuo);
// 		this.desbloquear();
// 		this.$(id).focus();
// 	}
// });

// app.VistaNuevoContrato = Backbone.View.extend({
// 	el						: '.contenedor_principal_modulos',
// 	events					: {
// 		'change     #busqueda'     	: 'buscarRepresentante',


// 		'change .btn_plan'		: 'conmutarTablaPlan',

// 		'change .n_pagos'		: 'obtenerValor',
// 		// 'keyup .input_renta'	: 'modificarPagos',
// 		// 'change .input_renta'	: 'modificarPagos',

// 		'click #btn_guardar'		: 'guardar',
// 		'click #btn_vistaPrevia'	: 'vistaPrevia',
// 		'click #btn_calcelar'		: 'cancelar',

// 		'click #btn_recargarPagos'	: 'recargarPagos'
// 	},
// 	initialize				: function () {
// 		this.render();
// 		loadSelectize_Client('#busqueda',app.coleccionClientes.toJSON());
// 		this.cargarServicios();
// 		loadDatepicker('.datepicker');
// 		var fecha;
// 		$('.input_fechaInicioPago').on('change', function(){
// 			fecha = $(this).val().split('/');
// 			$('#fechainicio').val(fecha[2] + "-" + fecha[1] + "-" + fecha[0]);
// 			var a = $('.btn_plan');
// 			for (var i = 0; i < a.length; i++) {
// 				if ($(a[i]).is(':checked')) {
// 					$(a[i]).attr('checked',false);
// 					$(a[i]).click();
// 				};
// 			};
// 		});

// 		$('#fechaFirma').on('change', function () {
// 			/*Pone la fecha de forma como la fecha en que se iniciaran
// 			  los pagos*/
// 			// $('.input_fechaInicioPago').val($(this).val());
// 			fecha = $(this).val().split('/');
// 			$('#hidden_fechafirma').val(fecha[2] + "-" + fecha[1] + "-" + fecha[0]);
// 		});
// 	},
// 	render					: function () {
// 		this.$('#registroContrato').html( $('#plantilla-formulario').html() );
// 	},

// 	guardar					: function (elem) {
// 		var here = this;
// 		var json = pasarAJson(this.$('form').serializeArray()),
// 			jsonContrato = {},
// 			jsonServicios  = {},
// 			jsonPagos	   = {},
// 			thiS = this;

// 		if (json.idcliente == '') {
// 			alerta('Seleccione un cliente para el contrato',function(){});
// 			elem.preventDefault();
// 			return;
// 		};

// 		if ($('#evento').is(':checked')) {
// 			delete json.mensualidades;
// 			delete json.mensualidadletras;
// 			if ($.isArray(json.fechafinal)) {
// 				json.fechafinal = json.fechafinal[0];
// 			};
// 			/*------------------------------------------------------*/
// 			jsonContrato.titulocontrato		= json.titulocontrato;
// 			jsonContrato.fechafirma 		= json.fechafirma;
// 			jsonContrato.fechainicio 		= json.fechainicio;
// 			jsonContrato.fechafinal 		= json.fechafinal;
// 			// jsonContrato.mensualidadletras		= json.mensualidadletras;
// 			jsonContrato.idcliente 			= json.idcliente;
// 			jsonContrato.idrepresentante 	= json.idrepresentante;
// 			jsonContrato.idempleado 		= json.idempleado;
// 			jsonContrato.nplazos 			= json.nPlazos;
// 			jsonContrato.plan 				= json.plan;
// 			jsonContrato.plazo 				= json.plazo;
// 			if (json.nPlazos == '' && json.plazo == '') {
// 				alerta('Especifique el plazo y el numero de plazos',function(){});
// 				elem.preventDefault();
// 				return;
// 			};
// 		} else if ($('#iguala').is(':checked')){
// 			delete json.plazo;
// 			delete json.nPlazos;
// 			if ($.isArray(json.fechafinal)) {
// 				json.fechafinal = json.fechafinal[1];
// 			};
// 			/*------------------------------------------------------*/
// 			jsonContrato.titulocontrato		= json.titulocontrato;
// 			jsonContrato.fechafirma 		= json.fechafirma;
// 			jsonContrato.fechainicio 		= json.fechainicio;
// 			jsonContrato.fechafinal 		= json.fechafinal;
// 			jsonContrato.mensualidadletras	= json.mensualidadletras;
// 			jsonContrato.idcliente 			= json.idcliente;
// 			jsonContrato.idrepresentante 	= json.idrepresentante;
// 			jsonContrato.idempleado 		= json.idempleado;
// 			jsonContrato.nplazos 			= json.mensualidades;
// 			jsonContrato.plan 				= json.plan;
// 			if (json.mensualidades == '') {
// 				alerta('Especifique las mensualidades',function(){});
// 				elem.preventDefault();
// 				return;
// 			};
// 		} else {
// 			alerta('Elija tipo de plan',function(){});
// 			elem.preventDefault();
// 			return;
// 		};

// 		if (!json.idservicio) {
// 			alerta('Seleccione uno o más servicios',function(){});
// 			elem.preventDefault();
// 			return;
// 		};

// 		if (json.fechainicio == '') {
// 			alerta('Especifique la fecha de inicio del contrato',function(){});
// 			elem.preventDefault();
// 			return;
// 		};
// 		/*Datos que poseen los dos tipos de planes*/
// 		jsonContrato.version 		= json.version;

// 		jsonServicios.idservicio	= json.idservicio;
// 		jsonServicios.cantidad		= json.cantidad;
// 		jsonServicios.descuento		= json.descuento;
// 		jsonServicios.precio		= json.precio;

// 		jsonPagos.fechapago 	= json.fechapago;
// 		jsonPagos.pago 			= json.pago;

// 		/* -------------------------------------------------------- */
// 		/**/Backbone.emulateHTTP = true;
// 		/**/Backbone.emulateJSON = true;
// 		/**/app.coleccionContratos.create(jsonContrato,{
// 		/**/	wait	: true,
// 		/**/	success	: function (exito) {
// 		/**/		jsonServicios.idcontrato = exito.get('id');
// 		/**/		jsonPagos.idcontrato = exito.get('id');
// 		/**/		thiS.guardarServicios(jsonServicios);
// 		/**/		thiS.guardarPagos(jsonPagos);
// 		/**/		thiS.confirmarContratoGuardado();
// 		/**/	},
// 		/**/	error	: function (model,response) {
// 		/**/		error('El contrato no a sido guardado');
// 		/**/		console.log(response);
// 		/**/	}
// 		/**/});
// 		/**/Backbone.emulateHTTP = false;
// 		/**/Backbone.emulateJSON = false;
// 		/* -------------------------------------------------------- */

// 		// console.log(jsonContrato,'\n',jsonServicios,'\n',jsonPagos);
// 		elem.preventDefault();
// 	},
// 	guardarServicios		: function (json) {
// 		/* -------------------------------------------------------- */
// 		/**/Backbone.emulateHTTP = true;
// 		/**/Backbone.emulateJSON = true;
// 		/**/app.coleccionServiciosContrato.create(json,{
// 		/**/	wait 	: true,
// 		/**/	success	: function (coleccion) {
// 		// /**/		app.coleccionServiciosContrato.reset(coleccion);
// 		/**/		console.log('Retorna esto: ',coleccion);
// 		/**/	},
// 		/**/	error	: function (error) {
// 		/**/		console.log('Error al intentar guardar Servicios');
// 		/**/	}
// 		/**/});
// 		/**/Backbone.emulateHTTP = false;
// 		/**/Backbone.emulateJSON = false;
// 		/* -------------------------------------------------------- */
// 	},
// 	guardarPagos			: function (json) {
// 		Backbone.emulateHTTP = true;
// 		Backbone.emulateJSON = true;
// 		/* -------------------------------------------------------- */
// 		/**/app.coleccionPagos.create(json,{
// 		/**/	wait 	: true,
// 		/**/	success	: function (coleccion) {
// 		// /**/		app.coleccionPagos.reset(coleccion);
// 		/**/		console.log('Retorna esto: ',coleccion);
// 		/**/	},
// 		/**/	error	: function (error) {
// 		/**/		console.log('Error al intentar guardar Pagos');
// 		/**/	}
// 		/**/});
// 		/* -------------------------------------------------------- */		
// 		Backbone.emulateHTTP = false;
// 		Backbone.emulateJSON = false;
// 	},
// 	confirmarContratoGuardado	: function () {
// 		confirmar('El contrato se guardo con exito.<br>Si desea crear otro contrato haga clic en Aceptar'
// 		,function(){
// 			$('form')[0].reset();
// 		},function(){
// 			location.href = 'contratos_historial';
// 		});
// 	},

// 	vistaPrevia 			: function (elem) {
// 		var json = pasarAJson($('form').serializeArray()),
// 			jsonContrato = {},
// 			jsonServicios  = {},
// 			jsonPagos	   = {},
// 			thiS = this;

// 		if (json.idcliente == '') {
// 			alerta('Seleccione un cliente para el contrato',function(){});
// 			elem.preventDefault();
// 			return;
// 		};

// 		if ($('#porEvento').is(':checked')) {
// 			delete json.mensualidades;
// 			delete json.mensualidadletras;
// 			if ($.isArray(json.fechafinal)) {
// 				json.fechafinal = json.fechafinal[0];
// 			};
// 			/*------------------------------------------------------*/
// 			jsonContrato.titulocontrato		= json.titulocontrato;
// 			jsonContrato.fechafirma 		= json.fechafirma;
// 			jsonContrato.fechainicio 		= json.fechainicio;
// 			jsonContrato.fechafinal 		= json.fechafinal;
// 			// jsonContrato.mensualidadletras		= json.mensualidadletras;
// 			jsonContrato.idcliente 			= json.idcliente;
// 			jsonContrato.idrepresentante 	= json.idrepresentante;
// 			jsonContrato.nplazos 			= json.nPlazos;
// 			jsonContrato.plan 				= json.plan;
// 			jsonContrato.plazo 				= json.plazo;
// 			if (json.nPlazos == '' && json.plazo == '') {
// 				alerta('Especifique el plazo y el numero de plazos',function(){});
// 				elem.preventDefault();
// 				return;
// 			};
// 		} else if ($('#iguala').is(':checked')){
// 			delete json.plazo;
// 			delete json.nPlazos;
// 			if ($.isArray(json.fechafinal)) {
// 				json.fechafinal = json.fechafinal[1];
// 			};
// 			/*------------------------------------------------------*/
// 			jsonContrato.titulocontrato		= json.titulocontrato;
// 			jsonContrato.fechafirma 		= json.fechafirma;
// 			jsonContrato.fechainicio 		= json.fechainicio;
// 			jsonContrato.fechafinal 		= json.fechafinal;
// 			jsonContrato.mensualidadletras		= json.mensualidadletras;
// 			jsonContrato.idcliente 			= json.idcliente;
// 			jsonContrato.idrepresentante 	= json.idrepresentante;
// 			jsonContrato.nplazos 			= json.mensualidades;
// 			jsonContrato.plan 				= json.plan;
// 			jsonContrato.id = app.coleccionContratos_LocalStorage.ordenSiguente();
// 			if (json.mensualidades == '') {
// 				alerta('Especifique las mensualidades',function(){});
// 				elem.preventDefault();
// 				return;
// 			};
// 		} else {
// 			alerta('Elija tipo de plan',function(){});
// 			elem.preventDefault();
// 			return;
// 		};

// 		if (!json.idservicio) {
// 			alerta('Seleccione uno o más servicios',function(){});
// 			elem.preventDefault();
// 			return;
// 		};

// 		if (json.fechainicio == '') {
// 			alerta('Especifique la fecha de inicio del contrato',function(){});
// 			elem.preventDefault();
// 			return;
// 		};

// 		/*Datos que poseen los dos tipos de planes*/
// 		jsonServicios.idservicio	= json.idservicio;
// 		jsonServicios.cantidad		= json.cantidad;
// 		jsonServicios.descuento		= json.descuento;
// 		jsonServicios.precio		= json.precio;

// 		/*Datos que poseen los dos tipos de planes*/
// 		jsonPagos.fechapago 	= json.fechapago;
// 		jsonPagos.pago 			= json.pago;

// 		/*Eliminar todo la coleccion para no duplicar datos*/
// 		app.coleccionContratos_LocalStorage.each(function (model){ 
// 			model.destroy();
// 		},this);
// 		app.coleccionContratos_LocalStorage.create(jsonContrato,{
// 			wait	: true,
// 			success	: function (exito) {
// 				console.log('En contrato se guardo en localStorage');
// 				jsonServicios.idcontrato = exito.get('id');
// 				jsonPagos.idcontrato = exito.get('id');
// 				thiS.guardarServicios_L(jsonServicios);
// 				thiS.guardarPagos_L(jsonPagos);

// 				// /*Eliminar todo la coleccion para no duplicar datos*/
// 				// app.coleccionContratos_LocalStorage.each(function (model){ 
// 				// 	model.destroy();
// 				// },this);
// 				// /*Eliminar todo la coleccion para no duplicar datos*/
// 				// app.coleccionServiciosContrato_LocalStorage.each(function (model){ 
// 				// 	model.destroy();
// 				// },this);
// 				// /*Eliminar todo la coleccion para no duplicar datos*/
// 				// app.coleccionPagos_LocalStorage.each(function (model){ 
// 				// 	model.destroy();
// 				// },this);

// 				/*Descomentar las tres lineas siguientes para ver los datos en caso de pruebas*/
// 					// $('.secciones1').slideToggle(500);
// 					// $('.secciones2').slideToggle(500);
// 					// var consulta_Hoja = new Consulta_Hoja();
// 			},
// 			error	: function (error) {
// 				console.log('El contrato no a sido guardado en localStorage');
// 			}
// 		});

// 		console.log(jsonContrato,'\n',jsonServicios,'\n',jsonPagos);
// 	},
// 	guardarServicios_L		: function (json) {
// 		/*Eliminar todo la coleccion para no duplicar datos*/
// 		app.coleccionServiciosContrato_LocalStorage.each(function (model){ 
// 			model.destroy();
// 		},this);
// 		app.coleccionServiciosContrato_LocalStorage.create(json,{
// 			wait 	: true,
// 			success	: function (exito) {
// 				console.log('Se guardaron los Servicios en localStorage');
// 			},
// 			error	: function (error) {
// 				console.log('Error al intentar guardar Servicios en localStorage');
// 			}
// 		});
// 	},
// 	guardarPagos_L			: function (json) {
// 		/*Eliminar todo la coleccion para no duplicar datos*/
// 		app.coleccionPagos_LocalStorage.each(function (model){ 
// 			model.destroy();
// 		},this);
// 		app.coleccionPagos_LocalStorage.create(json,{
// 			wait 	: true,
// 			success	: function (exito) {
// 				console.log('Se guardaron los Pagos en localStorage');
// 			},
// 			error	: function (error) {
// 				console.log('Error al intentar guardar Pagos en localStorage');
// 			}
// 		});	
// 	},

// 	cancelar				: function () {
// 		location.href = 'contratos_historial';
// 	},
// 	buscarRepresentante 		: function (e) {
// 		var here = this,
// 			representante = app.coleccionRepresentantes.findWhere({ idcliente:$(e.currentTarget).val() });
// 		if (representante) {
// 			this.$('#nombreRepresentante').val(representante.get('nombre'));
// 			this.$('#idrepresentante').val(representante.get('id'));
// 		} else{
// 			alerta('El cliente seleccionado no tiene representante (<b>Requerido</b>)', function () {});
// 		};
// 	},
// 	cargarServicio			: function (servicio) {
// 		var vista = new app.VistaServicioContrato({model:servicio});
// 		$('#tbody_servicios').append(vista.render().el);
// 	},
// 	cargarServicios			: function () {
// 		$('#tbody_servicios').html('');
// 		app.coleccionServicios.each(this.cargarServicio, this);
// 	},
// 	conmutarTablaPlan		: function (elem) {
// 		$('.tabla_visible').removeClass().addClass('tabla_oculto');
// 		$('#tbody_'+$(elem.currentTarget).attr('id'))
// 		.removeClass()
// 		.addClass('tabla_visible');

// 		this.establecerPagos( 
// 			$('#tbody_'+$(elem.currentTarget).attr('id')+' .n_pagos').val(), 
// 			$('#totalNeto').text() );
// 	},
// 	obtenerValor	: function (elem) {
// 		if ($(elem.currentTarget).val() < 101) {
// 			this.establecerPagos( 
// 				parseInt($(elem.currentTarget).val()), 
// 				$('#totalNeto').text() );
// 		} else{
// 			$(elem.currentTarget).val(1);
// 			this.obtenerValor(elem);
// 		};
// 	},
// 	recargarPagos 			: function () {
// 		$('.n_pagos').first().trigger('change');
// 	},
// 	establecerPagos			: function (n, totalNeto) {
// 		$('#margen').text(totalNeto);
// 		totalNeto = totalNeto.split('');
// 		totalNeto.shift();

// 		/*Limpiamos el tbody de pagos cada vez que se entre a esta
// 		  función*/
// 		$('#tbody_pagos').html('');

// 		var plazo = 1,
// 			aumento = 0,
// 			fecha = '',
// 			fechaNormal = '',
// 			fecha2 = '',
// 			candado = 'icon-unlock',
// 			checked = '';

// 		if (this.$('#porEvento').is(':checked')) {
// 			plazo = parseInt($('#plazo').val());
// 			aumento = plazo;
// 			fecha = $('#fechainicio').val();
// 			fecha2 = formatearFechaUsuario(new Date(new Date(fecha).getTime() + ((plazo*n)*24*60*60*1000)));
// 			if (fecha2 != 'NaN/NaN/NaN') {
// 				$('#vencimientoPlanEvento').val( fecha2 );
// 			} else{
// 				$('#vencimientoPlanEvento').val( '' );
// 			};
// 			fecha2 = fecha2.split('/');
// 			fecha2 = fecha2[2] + "-" + fecha2[1] + "-" + fecha2[0];
// 			$('#fechafinalEvento').val(fecha2);
// 		} else if (this.$('#iguala').is(':checked')){
// 			plazo = 30;
// 			aumento = plazo;
// 			fecha = $('#fechainicio').val();
// 			fecha2 = formatearFechaUsuario(new Date(new Date(fecha).getTime() + ((plazo*n)*24*60*60*1000)));
// 			if (fecha2 != 'NaN/NaN/NaN') {
// 				$('#vencimientoPlanIguala').val( fecha2 );
// 			} else{
// 				$('#vencimientoPlanIguala').val( '' );
// 			};
// 			fecha2 = fecha2.split('/');
// 			fecha2 = fecha2[2] + "-" + fecha2[1] + "-" + fecha2[0];
// 			$('#fechafinalIguala').val(fecha2);

// 			candado = '';
// 			checked = 'disabled';
// 		} else {console.log('Sin plan seleccionado');return;};
		
// 		fechaNormal = formatearFechaUsuario(new Date(new Date(fecha).getTime() + (1*24*60*60*1000)));
// 		fecha2 = fechaNormal.split('/');

// 		var Modelo;
// 		this.vistaPago = [];
// 		for (var i = 0; i < n; i++) {
// 			Modelo = Backbone.Model.extend({
// 				defaults	: { 
// 					id 		: i,
// 					n 		: i+1,
// 					fecha	: fechaNormal,
// 					fecha2	: fecha2[2] + "-" + fecha2[1] + "-" + fecha2[0],
// 					pago 	: (parseInt(totalNeto.join(''))/n).toFixed(2),
// 					candado	: candado,
// 					atrClase	: 'input_renta',
// 					checked	: checked
// 				}
// 			});
// 			this.vistaPago[i] = new app.VistaPago({model : new Modelo});

// 			$('#tbody_pagos').append(this.vistaPago[i].render().el);

// 			fechaNormal = formatearFechaUsuario(new Date(new Date(fecha).getTime() + (plazo*24*60*60*1000)));
// 			fecha2 = fechaNormal.split('/');
// 			plazo = plazo + aumento;
// 		};
// 		this.modificarPagos();
// 	},
// 	modificarPagos			: function () {
// 		var margen = $('#totalNeto').text().split(''),
// 			rentas = $('.hidden_renta'),
// 			suma = 0.0, /*Debe inicializarse como flotante*/
// 			masmenos;

// 		margen.shift();
// 		margen = margen.join('');
// 		margen = parseInt(margen).toFixed();

// 		for (var i = 0; i < rentas.length; i++) {
// 			suma += parseFloat($(rentas[i]).val());
// 		};

// 		masmenos = suma;
// 		suma = suma.toFixed();
// 		if (suma > margen || suma < margen) {
// 			$('#margen').text('$'+masmenos.toFixed(2)).css('color','red');
// 		} else{
// 			$('#margen').text($('#totalNeto').text()).css('color','black');
// 		};
// 	},
// 	equilibrarPagos			: function (residuo) {
// 		var rentas = $('.input_renta');
// 		var pagoNuevo = 0.0;
// 		residuo = residuo/parseFloat(rentas.length);
// 		for (var i = 0; i < rentas.length; i++) {
// 			pagoNuevo = (parseFloat($(rentas[i]).val()) + residuo).toFixed(2);
// 			// $(rentas[i]).val(pagoNuevo);
// 			this.vistaPago[parseInt($(rentas[i]).attr('id'))].model.set({pago:pagoNuevo});
// 		};
// 		this.modificarPagos();
// 	},

// });

		// // Convert numbers to words
  //       // copyright 25th July 2006, by Stephen Chapman http://javascript.about.com
  //       // permission to use this Javascript on your web page is granted
  //       // provided that all of the code (including this copyright notice) is
  //       // used exactly as shown (you can change the numbering system if you wish)
 
  //       // American Numbering System
  //       var th = ['','mill','millon', 'billon','trillon'];
  //       // uncomment this line for English Number System
  //       // var th = ['','thousand','million', 'milliard','billion'];
 
  //       var dg = ['cero','uno','dos','tres','cuatro', 'cinco','seis','siete','ocho','nueve']; 
  //       var tn = ['diez','once','doce','trece', 'catorce','quince','dieciseis', 'diecisiete','diociocho','diecinueve']; 
  //       var tw = ['veinte','treinta','cuarenta','cincuenta', 'sesenta','setenta','ochenta','noventa']; 
  //       function toWords(s){s = s.toString(); s = s.replace(/[\, ]/g,''); if (s != parseFloat(s)) return 'not a number'; var x = s.indexOf('.'); if (x == -1) x = s.length; if (x > 15) return 'too big'; var n = s.split(''); var str = ''; var sk = 0; for (var i=0; i < x; i++) {if ((x-i)%3==2) {if (n[i] == '1') {str += tn[Number(n[i+1])] + ' '; i++; sk=1;} else if (n[i]!=0) {str += tw[n[i]-2] + ' ';sk=1;}} else if (n[i]!=0) {str += dg[n[i]] +' '; if ((x-i)%3==0) str += 'cien ';sk=1;} if ((x-i)%3==1) {if (sk) str += th[(x-i-1)/3] + ' ';sk=0;}} if (x != s.length) {var y = s.length; str += 'point '; for (var i=x+1; i<y; i++) str += dg[n[i]] +' ';} return str.replace(/\s+/g,' ');}