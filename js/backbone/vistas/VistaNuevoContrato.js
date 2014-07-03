app	= app || {};

app.VistaServicioSeleccionado = Backbone.View.extend({
	tagName	: 'tr',
	plantillaDefault	: _.template($('#servicioContratado').html()),
	events					: {
		'click .eliminar'		: 'eliminarSeleccion',
		// 'keyup  #descuento'		: 'establecerPrecio',
		// 'keyup  #cantidad'		: 'calcularTotal',
		// 'keyup  #precio'		: 'calcularDescuento',
		// 'change #descuento'		: 'establecerPrecio',
		// 'change #cantidad'		: 'calcularTotal',
		// 'change #precio'		: 'calcularDescuento'
	},
	initialize			: function () {
		this.listenTo(this.model, 'change', this.render);
		this.listenTo(this.model, 'change', this.calcularImporteIVATotalNeto);
	},
	render				: function () {
		this.$el.html(this.plantillaDefault( this.model.toJSON() ));

		var thiS = this;
		var descuento = this.$el.find('#descuento');
		descuento.one('change',function (){
			thiS.calcularTotal(this);
		});
		var cantidad = this.$el.find('#cantidad');
		cantidad.one('change',function (){
			thiS.calcularTotal(this);
		});
		var precio = this.$el.find('#precio');
		precio.one('change',function (){
			thiS.calcularTotal(this);
		});

		return this;
	},
	eliminarSeleccion	: function (elem) {
		$('#tbody_servicios .check_posicion #servicio_'+this.model.get('id')).attr('disabled',false)
		this.$el.remove();
		this.calcularImporteIVATotalNeto();
	},
	calcularDescuento	: function (elem) {
		var precio 		= this.$('#precio').val();
		this.$('#descuento').val(( 100 - ((precio * 100)/this.model.get('precioDefault')) ).toFixed());
		this.calcularTotal(elem);
	},
	calcularTotal		: function (elem) {
		var precio 		= this.$('#cantidad').val() * this.$('#precio').val();
		var descuento 	= precio*(this.$('#descuento').val()/100);
		var json 		= pasarAJson(this.$('.inputsServicios').serializeArray());
		json.total 		= (precio - descuento).toFixed(2);
		/*Respaldamos id del input que se está editando*/
		var idHtml 		= $(elem).attr('id');
		
		/*Al establecer nuevos valores en el modelo,
		  ejecutaremos la función render, que está 
		  especificado en la función initialize en el
		  listener para con evento change*/
		this.model.set(json);

		/*Hacemos focus sobre el input en que se esta.
		  Al hacerlo el texto se auto selecciona, para
		  evitar tal efecto se reescribe su valor para
		  que el cursor se posiciones al fonal del texto*/
		this.$('#'+idHtml).focus().val( this.$('#'+idHtml).val() );
		
	},
	calcularImporteIVATotalNeto	: function () {
		var totales = $('.total');
		var importe = 0;
		for (var i = 0; i < totales.length; i++) {
			importe += parseInt($(totales[i]).val());
		};
		$('#importe').text('$'+importe.toFixed(2));
		$('#IVA').text('$'+(importe*0.16).toFixed(2));
		$('#totalNeto').text('$'+(importe + (importe*0.16)).toFixed(2));

		/*Provocamos un click automatico para que la tabla de pagos
		  se actualice*/
		var a = $('.btn_plan');
		for (var i = 0; i < a.length; i++) {
			if ($(a[i]).is(':checked')) {
				$(a[i]).attr('checked',false);
				$(a[i]).click();
			};
		};
	}
});

app.VistaServicioContrato = app.VistaServicio.extend({
	tagName	: 'tr',
	plantillaDefault	: _.template($('#plantillaServicio').html()),
	events	: {
		'click .checkbox_servicio'		: 'apilarServicio',
	},
	apilarServicio		: function (elem) {
		var modelCopia = this.model;
		modelCopia.set({
			descuento 		: '0',
			cantidad		: '1',
			total 			: parseInt(this.model.get('precio')).toFixed(2)
		});
		var vista = new app.VistaServicioSeleccionado({ model:modelCopia });
		$('#tbody_servicios_seleccionados').append(vista.render().el);
		$(elem.currentTarget).attr('disabled',true);
		vista.calcularImporteIVATotalNeto();
	},
});

app.VistaPago = Backbone.View.extend({
	tagName 	: 'tr',
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
		this.model.set({atrClase:'bloqueado', candado: 'icon-lock', checked:'disabled'});
	},
	desbloquear		: function () {
		this.model.set({atrClase:'input_renta', candado: 'icon-unlock', checked:''});
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

app.VistaNuevoContrato = Backbone.View.extend({
	el						: '.contenedor_principal_modulos',
	events					: {
		'change .btn_plan'		: 'conmutarTablaPlan',
		'change .n_pagos'		: 'obtenerAtributoValue',
		// 'keyup .input_renta'	: 'modificarPagos',
		// 'change .input_renta'	: 'modificarPagos',
		'click #btn_guardar'		: 'guardar',
		'click #btn_vistaPrevia'	: 'vistaPrevia',
		'click #btn_recargarPagos'	: 'recargarPagos'
	},
	initialize				: function () {
		this.cargarClientes();
		this.cargarServicios();
		this.fecha();
		var fecha;
		$('.input_fechaInicioPago').on('change', function(){
			fecha = $(this).val().split('/');
			$('#fechainicio').val(fecha[2] + "-" + fecha[1] + "-" + fecha[0]);
			var a = $('.btn_plan');
			for (var i = 0; i < a.length; i++) {
				if ($(a[i]).is(':checked')) {
					$(a[i]).attr('checked',false);
					$(a[i]).click();
				};
			};
		});

		$('#fechaFirma').on('change', function () {
			/*Pone la fecha de forma como la fecha en que se iniciaran
			  los pagos*/
			// $('.input_fechaInicioPago').val($(this).val());
			fecha = $(this).val().split('/');
			$('#hidden_fechafirma').val(fecha[2] + "-" + fecha[1] + "-" + fecha[0]);
		});
	},
	render					: function () {},
	vistaPrevia 			: function () {
		window.open('formatoContrato.php','ventana1','scrollbars=NO') 
	},
	guardar					: function (elem) {
		var json = pasarAJson($('form').serializeArray()),
			jsonContrato = {},
			jsonServicios  = {},
			jsonPagos	   = {},
			thiS = this;

		if (json.idcliente == '') {
			alert('Seleccione un cliente para el contrato');
			elem.preventDefault();
			return;
		};

		if ($('#porEvento').is(':checked')) {
			delete json.mensualidades;
			json.fechafinal = json.fechafinal[0];
			/*------------------------------------------------------*/
			jsonContrato.fechafirma 		= json.fechafirma;
			jsonContrato.fechainicio 		= json.fechainicio;
			jsonContrato.fechafinal 		= json.fechafinal;
			jsonContrato.idcliente 			= json.idcliente;
			jsonContrato.idrepresentante 	= json.idrepresentante;
			jsonContrato.nplazos 			= json.nPlazos;
			jsonContrato.plan 				= json.plan;
			jsonContrato.plazo 				= json.plazo;

			if (json.nPlazos == '' && json.plazo == '') {
				alert('Especifique el plazo y el numero de plazos');
				elem.preventDefault();
				return;
			};

		} else if ($('#iguala').is(':checked')){
			delete json.plazo;
			delete json.nPlazos;
			json.fechafinal = json.fechafinal[1];
			/*------------------------------------------------------*/
			jsonContrato.fechafirma 		= json.fechafirma;
			jsonContrato.fechainicio 		= json.fechainicio;
			jsonContrato.fechafinal 		= json.fechafinal;
			jsonContrato.idcliente 			= json.idcliente;
			jsonContrato.idrepresentante 	= json.idrepresentante;
			jsonContrato.nplazos 			= json.mensualidades;
			jsonContrato.plan 				= json.plan;

			if (json.mensualidades == '') {
				alert('Especifique las mensualidades');
				elem.preventDefault();
				return;
			};
		} else {
			alert('Elija tipo de plan');
			elem.preventDefault();
			return;
		};

		if (json.fechainicio == '') {
			alert('Especifique la fecha de inicio del contrato');
			elem.preventDefault();
			return;
		};

		/*Datos que poseen los dos tipos de planes*/
		jsonServicios.idservicio	= json.idservicio;
		jsonServicios.cantidad		= json.cantidad;
		jsonServicios.descuento		= json.descuento;
		jsonServicios.precio		= json.precio;
		/*Datos que poseen los dos tipos de planes*/
		jsonPagos.fechapago 	= json.fechapago;
		jsonPagos.pago 			= json.pago;

		/* -------------------------------------------------------- */
		/**/Backbone.emulateHTTP = true;
		/**/Backbone.emulateJSON = true;
		/**/app.coleccionContratos.create(jsonContrato,{
		/**/	wait	: true,
		/**/	success	: function (exito) {
		/**/		console.log('En contrato se guardo con exito');
		/**/		jsonServicios.idcontrato = exito.get('id');
		/**/		jsonPagos.idcontrato = exito.get('id');
		/**/		thiS.guardarServicios(jsonServicios);
		/**/		thiS.guardarPagos(jsonPagos);
		/**/	},
		/**/	error	: function (error) {
		/**/		console.log('El contrato no a sido guardado');
		/**/	}
		/**/});
		/**/Backbone.emulateHTTP = false;
		/**/Backbone.emulateJSON = false;
		/* -------------------------------------------------------- */

		// console.log(jsonContrato,'\n',jsonServicios,'\n',jsonPagos);
		elem.preventDefault();
	},
	guardarServicios		: function (json) {
		/* -------------------------------------------------------- */
		/**/Backbone.emulateHTTP = true;
		/**/Backbone.emulateJSON = true;
		/**/app.coleccionServiciosContrato.create(json,{
		/**/	wait 	: true,
		/**/	success	: function (exito) {
		/**/		console.log('Se guardaron los Servicios');
		/**/	},
		/**/	error	: function (error) {
		/**/		console.log('Error al intentar guardar Servicios');
		/**/	}
		/**/});
		/**/Backbone.emulateHTTP = false;
		/**/Backbone.emulateJSON = false;
		/* -------------------------------------------------------- */
	},
	guardarPagos			: function (json) {
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		/* -------------------------------------------------------- */
		/**/app.coleccionPagos.create(json,{
		/**/	wait 	: true,
		/**/	success	: function (exito) {
		/**/		console.log('Se guardaron los Pagos');
		/**/	},
		/**/	error	: function (error) {
		/**/		console.log('Error al intentar guardar Pagos');
		/**/	}
		/**/});
		/* -------------------------------------------------------- */		
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	},

	jsonArray	: function (claveId,valorId,arrayClaves,arrayValores,n) { /*PARA MI FRAMEWORK*/
		var array = new Array();
		var stringJson = '';
		for (var i = 0; i < n; i++) {
			stringJson = claveId +'":"'+valorId+'",';
			for (var ii = 0; ii < arrayClaves.length; ii++) {
				stringJson += '"'+arrayClaves[ii] + '":"' + arrayValores[ii][i];
                if(ii != arrayClaves.length && ii < arrayClaves.length-1) stringJson += '",';
			};
            
            array.push(jQuery.parseJSON('{"'+stringJson+'"}'));
            stringJson = '';
		};
		return array;
	},

	cargarClientes			: function () {
		$('#busqueda').autocomplete({
			source : app.coleccionClientes.pluck('nombreComercial'),

			select : function( event, ui ) {
				/*Obtenemos el modelo del cliente seleccionado*/
				var coincidencia = 	app.
									coleccionClientes.
									findWhere({nombreComercial:ui.item.value});
				/*Establecemos el id del cliente al formulario*/
				$('#hidden_idCliente').val(coincidencia.get('id'));

				/*Obtenemos el modelo del representante del cliente*/
					coincidencia = 	app.
									coleccionRepresentantes.
									findWhere({idcliente:coincidencia.get('id')});
				/*Establecemos el nombre del representante al formulario*/
				$('#input_Representante').val(coincidencia.get('nombre'));
				/*Establecemos el id del representante en el formulario*/
				$('#hidden_idRepresentante').val(coincidencia.get('id'));
			},

			change  : function (event) {
				/*Si se ha dejado vacio el campo para el nombre de
				  servicio, limpiamos los campos ocultos para el 
				  id del cliente y is del representante*/
				if ( $('#busqueda').val() == '' ) {
					$('#input_Representante').val('');
					$('#hidden_idCliente').val('');
					$('#hidden_idRepresentante').val('');
				};
			}
		});
	},
	cargarServicio			: function (servicio) {
		var vista = new app.VistaServicioContrato({model:servicio});
		$('#tbody_servicios').append(vista.render().el);
	},
	cargarServicios			: function () {
		app.coleccionServicios.each(this.cargarServicio, this);
	},
	fecha					: function () {
		$('.datepicker').datepicker({ 
			dateFormat:'dd/mm/yy',  
			dayNamesMin:[
				'Do',
				'Lu',
				'Ma',
				'Mi',
				'Ju',
				'Vi',
				'Sá'
			],
			monthNames:[
				'Enero',
				'Febrero',
				'Marzo',
				'Abril',
				'Mayo',
				'Junio',
				'Julio',
				'Agosto',
				'Septiembre',
				'Octubre',
				'Noviembre',
				'Diciembre'
			]
		});
	},
	conmutarTablaPlan		: function (elem) {
		$('.tabla_visible').removeClass().addClass('tabla_oculto');
		$('#tbody_'+$(elem.currentTarget).attr('id'))
		.removeClass()
		.addClass('tabla_visible');

		this.establecerPagos( 
			$('#tbody_'+$(elem.currentTarget).attr('id')+' .n_pagos').val(), 
			$('#totalNeto').text() );
	},
	obtenerAtributoValue	: function (elem) {
		if ($(elem.currentTarget).val() < 101) {
			this.establecerPagos( 
				parseInt($(elem.currentTarget).val()), 
				$('#totalNeto').text() );
		} else{
			$(elem.currentTarget).val(1);
			this.obtenerAtributoValue(elem);
		};
	},
	recargarPagos 			: function () {
		$('.n_pagos').first().trigger('change');
	},
	establecerPagos			: function (n, totalNeto) {
		$('#margen').text(totalNeto);
		totalNeto = totalNeto.split('');
		totalNeto.shift();

		/*Limpiamos el tbody de pagos cada vez que se entre a esta
		  función*/
		$('#tbody_pagos').html('');

		var plazo = 1,
			aumento = 0,
			fecha = '',
			fechaNormal = '',
			fecha2 = '',
			candado = 'icon-unlock',
			checked = '';

		if ($('#porEvento').is(':checked')) {
			plazo = parseInt($('#plazo').val());
			aumento = plazo;
			fecha = $('#fechainicio').val();
			fecha2 = this.formatearFechaUsuario(new Date(new Date(fecha).getTime() + ((plazo*n)*24*60*60*1000)));
			if (fecha2 != 'NaN/NaN/NaN') {
				$('#vencimientoPlanEvento').val( fecha2 );
			} else{
				$('#vencimientoPlanEvento').val( '' );
			};
			fecha2 = fecha2.split('/');
			fecha2 = fecha2[2] + "-" + fecha2[1] + "-" + fecha2[0];
			$('#fechafinalEvento').val(fecha2);
		} else if ($('#iguala').is(':checked')){
			plazo = 30;
			aumento = plazo;
			fecha = $('#fechainicio').val();
			fecha2 = this.formatearFechaUsuario(new Date(new Date(fecha).getTime() + ((plazo*n)*24*60*60*1000)));
			if (fecha2 != 'NaN/NaN/NaN') {
				$('#vencimientoPlanIguala').val( fecha2 );
			} else{
				$('#vencimientoPlanIguala').val( '' );
			};
			fecha2 = fecha2.split('/');
			fecha2 = fecha2[2] + "-" + fecha2[1] + "-" + fecha2[0];
			$('#fechafinalIguala').val(fecha2);

			candado = '';
			checked = 'disabled';
		} else {console.log('Sin plan seleccionado');return;};
		
		fechaNormal = this.formatearFechaUsuario(new Date(new Date(fecha).getTime() + (1*24*60*60*1000)));
		fecha2 = fechaNormal.split('/');

		var Modelo;
		this.vistaPago = [];
		for (var i = 0; i < n; i++) {
			Modelo = Backbone.Model.extend({
				defaults	: { 
					id 		: i,
					n 		: i+1,
					fecha	: fechaNormal,
					fecha2	: fecha2[2] + "-" + fecha2[1] + "-" + fecha2[0],
					pago 	: (parseInt(totalNeto.join(''))/n).toFixed(2),
					candado	: candado,
					atrClase	: 'input_renta',
					checked	: checked
				}
			});
			this.vistaPago[i] = new app.VistaPago({model : new Modelo});

			$('#tbody_pagos').append(this.vistaPago[i].render().el);

			fechaNormal = this.formatearFechaUsuario(new Date(new Date(fecha).getTime() + (plazo*24*60*60*1000)));
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
	formatearFechaUsuario	: function (fecha) {
		var fechaFormateada = '';
		if ((fecha.getDate()) < 10 )
		fechaFormateada = '0'+(fecha.getDate());
		else
			fechaFormateada = (fecha.getDate());
		if ((fecha.getMonth() +1) < 10 )
			fechaFormateada += '/0'+(fecha.getMonth() +1);
		else
			fechaFormateada +=  '/'+(fecha.getMonth() +1);

		fechaFormateada +=  '/'+fecha.getFullYear();

		return fechaFormateada;
	},
});

app.vistaNuevoContrato = new app.VistaNuevoContrato();