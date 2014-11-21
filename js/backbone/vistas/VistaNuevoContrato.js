app	= app || {};
app.VistaPago = Backbone.View.extend({
	tagName 	: 'tr',
	className 	: 'warning',
	plantilla_tr_pagos		: _.template($('#tr_pagos').html()),
	events		: {
		// Icono candado abierto
		'click .icon-unlock'	: 'bloquear',
		// Clase bootstrap, efecto botón precionado
		'click .active'		: 'desbloquear',
		'mousewheel .input_renta'	: 'validarCampo',
		'keyup .input_renta' 	: 'validarCampo',
		'change .input_renta' 	: 'validarCampo'
	},
	initialize		: function () {
		this.listenTo(this.model, 'change', this.render);
		this.residuo = 0.0;
		this.timer;
	},
	render			: function () {
		this.$el.html(this.plantilla_tr_pagos(this.model.toJSON()));

		return this;
	},
	bloquear		: function (e) {
		// e, es el imput number
		this.$(e.currentTarget)
			// conmutar boton
			.toggleClass('active')
			// conmutar candado
			.toggleClass('icon-unlock');
		this.$('#'+this.model.get('id'))
			// quitamos la clase para no
			// afectar el valor del campo
			// que estamos edidando (esto
			// paras las operaciones en la
			// clase VistaNuevoContrato)
			.toggleClass('input_renta')
			// Desactivamos el campo
			.attr('disabled',true);
	},
	desbloquear		: function () {
		this.render();
	},
	validarCampo 	: function (e) {	
		var self = this;
		var condiciones = function () {
			if ( $('.input_renta').length == 1 
				|| !$.isNumeric( $(e.currentTarget).val() *1) 
				|| $(e.currentTarget).val() == '' 
			) {
				self.render();
			} else {
				self.modificarPago(e);
			};
		};
		if (e.keyCode === 13 || e.type === 'change') {
			condiciones();
		}
		if ( e.type === 'mousewheel') {
			condiciones();
		};
	},
	modificarPago	: function (e) {
		// Cada vez que ocurre un evento change se renderiza la
		// la vista, por lo que el evento mousewheel nunca
		// funcionará. por ello metemos las operaciones de esta 
		// funcion en una función timeout para darle un tiempo
		// al evento mousewheel. cada vez que ocurra el evento
		// mousewheel devemos eliminar el anterior proceso, por
		// ello usamos la funcion clearTimeout y volver a comenzar el
		// proceso de esta funcion (modificarPago)
		clearTimeout(this.timer);
		var self = this;
		this.timer = setTimeout(function() {
			// Obtenemos el valor actual del campo
			var actual = parseFloat(self.model.get('pago')),
				// Obtenemos el id del campo, como refencia del
				// array de vistas en la clase VistaNuevoContrato
				idVista = parseInt($(e.currentTarget).attr('id'));

			// Calculamos la direncia entre el pago modificado
			// y el pago anterior
			var diferencia = (
				actual - parseFloat(
							// Primero actualizamos el modelo 
							self.model.set({
								pago:$(e.currentTarget).val()
							// Luego otenemos el pago actualizado
							// directamente del modelo
							},{
								wait:true
							}).get('pago') )
						).toFixed(2);

			// Bloqueamos el campo actual para no afectar su valor
			self.bloquear(e);
			// Estando bloqueado el campo que hemos modificado,
			// realizamos los calculos necesarios para los nuevos
			// valores de los demás campos. todo se realiza en la
			// clase VistaNuevaCotizacion.
			app.vistaNuevoContrato.equilibrarPagos(diferencia, idVista);
			// Renderizamos la vista que hemos modificado
			self.desbloquear();
			// Hacemos focus en el campo que estamos editando.
			self.$('#'+idVista).select();
		}, 200);
	}
});
app.VistaNuevoContrato = app.VistaNuevaCotizacion.extend({
	/*Herencias*/
	events : {
		// Eventos orignales de la clase VistaNuevaCotizacion
			'change     #busqueda'     	: 'buscarRepresentante',     //Cuando escribes una letra, despliega un menu de sugerencias
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

			'change 	.input-tfoot' : 'calcularTotal',
			'mousewheel .input-tfoot' : 'calcularTotal',
			'blur 		.input-tfoot' : 'calcularTotal',

			'click #cancelar'	: 'cancelar',

		// Eventos de contrato
			'change .btn_plan'			: 'conmutarTablaPlan',

			'change .n_pagos'			: 'obtenerValor',
			'mousewheel .n_pagos'		: 'obtenerValor',
			'click .n_pagos'		: 'obtenerValor',
			'keyup .n_pagos'				: 'obtenerValor',

			'click #btn_recargarPagos'	: 'recargarPagos',
			'click 	   #guardar'	   	: 'guardar', //Guarda la cotización


			// 'change .input_renta'	: 'equilibrarPagos',
			// 'wheel .input_renta'	: 'equilibrarPagos',
			// 'blur .input_renta'	: 'equilibrarPagos',
	},
	initialize : function () {
		this.listenTo(app.coleccionContratos, 'reset', function () {
			var folio = app.coleccionContratos.establecerFolio();
			this.$('input[name="folio"]').val(folio);
			this.$('#h4_folio').text('Folio: '+ folio).fadeIn('fast');
		});

		this.render();
		this.eventosPlugins();
		// // Inicializamos la tabla servicios que es donde esta la lista de servicios a seleccionar
		// // this.$tablaServicios = this.$('#listaServicios');
		this.contadorAlerta = 1;
		this.totalelementos = 0;

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
		/*BORRAR PARA PRODUCCIÓN (HAY MÁS)*/this.$('#prestacion').val('Contrato No. '+(Math.random()).toFixed(3) *1000);

		/*FOLIO. En la cración de una cotización ocurrira el fetch,
		  pero cuando se edite una cotización no se realizará*/
		if (app.coleccionContratos.length == 0) {
			app.coleccionContratos.fetch({reset:true});
		};
		return this;
	},
	eliminarServicios 		: function () {
		var spans = this.$('input[name="todos"]:checked'); /*Obtenemos todos los checkbox activados*/
		if (spans.length) { /*Solo si hay servicios marcados*/
			var here = this;
			confirmar('¿Estás seguro de eliminar los servicios marcados?',
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

		app.coleccionContratos_L.create(json, {
			wait: true,
			success: function (exito) {
				// for(i in json.secciones) {   
				// 	app.coleccionServiciosContrato_L.create(json.secciones[i], { 
				// 		wait:true,
				// 		success:function(exito) {
				// 			if (self.aumentarContador() == json.secciones.length) {
				// 				self.contadorAlerta = 1;
								window.open("formatoContrato");
				// 			};
				// 		},
				// 		error:function(error) {
				// 		}
				// 	});
				// };
			},
			error: function (error) {}
		});
		e.preventDefault();
	},
	guardar 		: function () {
		if (!this.obtenerDatos()) {
			return;
		};
		// Primero removemos los campos de la tabla
		// del plan desactivado para no traer sus
		// datos.
		this.$('.thead_oculto').remove();
		this.$('.tbody_oculto').remove();
		
		var jsonDatos,
			jsonPagos,
			secciones,
			self = this;

		// traemos todos los datos del contrato
		jsonDatos = this.obtenerDatos();
		// separamos los pagos y las fechas de pagos
		jsonPagos = _.pick(jsonDatos.datos, 'fechapago', 'pago');
		// separamos las secciones de del lo que se contrato
		secciones = jsonDatos.secciones;

		// eliminamos los datos del json general
		delete jsonDatos.datos.fechapago;
		delete jsonDatos.datos.pago;
		delete jsonDatos.secciones;
		jsonDatos = jsonDatos.datos;


		jsonDatos.status = true;
		jsonDatos.visibilidad = true;

		this.totalelementos = secciones.length + 1;

		$('#block').toggleClass('activo');
		 Backbone.emulateHTTP = true;
		 Backbone.emulateJSON = true; 
		 //Hacemos un CREATE con los datos primarios de la cotización
		 app.coleccionContratos.create(jsonDatos, {
			wait:true,
			success:function(exito){
				jsonPagos.idcontrato = exito.get('id');
				self.guardarPagos(jsonPagos);
				self.guardarSeccion(exito.get('id'), secciones);
			},
			error:function(error){ }
		});
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
		localStorage.clear();
	},
	guardarSeccion	: function (idContrato, secciones) {
		var self = this;
		for (var i = 0; i < secciones.length; i++) {
			secciones[i].idcontrato = idContrato;
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionServiciosContrato.create(secciones[i], {
				wait	: true,
				success	: function (exito) {
					// if (self.aumentarContador() == this.totalelementos) {
						self.guardado();
					// };
					// ok('La seccion: <b>'+exito.toJSON().seccion+'</b> ha sido guardada');
				},
				error	: function (error) {
					// if (self.aumentarContador() == this.totalelementos) {
						self.noGuardada();
					// };
					// error('Error al guardar seccion: <b>'+error.toJSON().seccion+'</b>');
				}
			});
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		};
	},
	guardado		: function () {
		if (this.aumentarContador() == this.totalelementos) {
			var self = this;
			$('#block').toggleClass('activo');
			alerta('¡Contrato guardado!', function () {
				confirmar('<b>¿Deseas crear otro contrato?</b>', function () {
					$('#registroContrato')[0].reset();
					$('.span_eliminar_servicio').click();
					app.coleccionContratos.off().reset();
					self.initialize();
				}, function () {
					location.href = 'contratos_historial';
				});
			});
		};
	},
	noGuardada	: function () {
		if (this.aumentarContador() == this.totalelementos) {
			$('#block').toggleClass('activo');
			alerta('El contrato ha sido guardado, pero ocurrieron algunos errores<br>Revice el contrato en el historial de contratos', function () {
				location.href = 'contratos_historial';
				this.resetearContador();
			});
		};
	},
	obtenerDatos	: function () {
		var forms = this.$('.form_servicio'),
			json  = pasarAJson(this.$('#prestacion, #busqueda, #idrepresentante, #hidden_fechafirma, input[name="plan"]:checked')
					.serializeArray()),
			f = new Date(),
			fechainicio,
			fechafinal;
		/*Cortafuego para forzar establecer los siguientes datos*/
		if (   json.prestaciones == '' 
			|| json.idcliente == '' 
			|| json.idrepresentante == '' 
			|| json.fechafirma == ''
		) {
			alerta('Complete los <b>datos básicos</b>', function () {});
			return false; // Terminamos el flujo del código
		} else if( !json.plan ){
			alerta('Seleccione un tipo de <b>plan</b>', function () {});
			return false; // Terminamos el flujo del código
		};

		json = { secciones : [], datos : '' };
		// Datos básicos
			json.datos = pasarAJson(this.$('#registroContrato')
						.serializeArray());
			
		// Validar datos
			// if ( json.datos.fechainicio == '' ){
			// 	alerta('Establezca la fecha de inicio de pagos');
			// 	return false;
			// };
			if ( json.datos.plan == 'evento' ){
				fechainicio = this.$('#fechaInicioEvento').datepicker('getDate');
				json.datos.fechainicio = formatearFechaDB(fechainicio);
				json.datos.fechafinal = $('#fechafinalEvento').val();
				if ( json.datos.plazo == '' ) {
					alerta('Establezca el <b>plazo en días');
					return false;
				};
				if ( json.datos.nplazos == '' ) {
					alerta('Establezca el <b>número de plazos</b>');
					return false;
				}
			}
			if ( json.datos.plan == 'iguala' ) {
				fechainicio = this.$('#fechaInicioIguala').datepicker('getDate');
				json.datos.fechainicio = formatearFechaDB(fechainicio);
				json.datos.fechafinal = $('#fechafinalIguala').val();
				if ( json.datos.nplazos == '' ) {
					alerta('Establezca las <b>Mensualidades</b>');
					return false;
				}
			};

			// if ( json.datos.plan == 'iguala' ){}


			json.datos.fechacreacion = f.getFullYear() 
									   + "-" + (f.getMonth() +1) 
									   + "-" + (f.getDate() +1);
			/*BORRAR PARA PRODUCCIÓN (HAY MÁS)*/json.datos.idempleado = '65';


		// Datos pagos
			json.datos.mensualidadletras 
			= 
			(NumeroALetras(this.total/Number(json.datos.nplazos))).trim();
		
		/*Cortafuego. Debe haber al menos 1 servicio para cotizarlo*/
		if (!forms.length) {
			alerta('Seleccione al menos un <b>servicio</b> para contratar'
					, function () {});
			return false; // Terminamos el flujo del código
		};
		
		/*Servicios cotizados*/
			for (var i = 0; i < forms.length; i++) {
				json.secciones.push( pasarAJson($(forms[i])
									 .serializeArray()) );
			};
		
		// Dato basura
		delete json.datos.todos;
		
		json.datos.version = 1;

		return json;
	},
	/*Funciones de contrato*/
	conmutarTablaPlan		: function (elem) {
		// Primero quitamos de los dos elementos la clase .thead_visible
		this.$('.thead_visible').removeClass().addClass('thead_oculto');
		this.$('.tbody_visible').removeClass().addClass('tbody_oculto');
		// Acemos visible al los campor del tipo de plan seleccionado
		this.tipoPlan = $(elem.currentTarget).val();
		this.$( '#thead_'+this.tipoPlan ).removeClass()
		.addClass('thead_visible');
		this.$( '#tbody_pagos_'+this.tipoPlan ).removeClass().addClass('tbody_visible');

		// Para no traer datos repetidos, desactivamos los campos del
		// plan desactivado
		switch(this.tipoPlan){
			case 'iguala':
				this.$('#fechaInicioEvento,#plazo,.n_pagos:eq(0)').attr('disabled',true);
				this.$('#fechaInicioIguala,.n_pagos:eq(1)').attr('disabled',false);
			break;
			case 'evento':
				this.$('#fechaInicioEvento,#plazo,.n_pagos:eq(0)').attr('disabled',false);
				this.$('#fechaInicioIguala,.n_pagos:eq(1)').attr('disabled',true);
			break;
		}

		// if( this.$('#tbody_pagos_'+this.tipoPlan).html() == "" ) {
		// 	this.establecerPagos( 
		// 		this.$('#thead_'+this.tipoPlan+' .n_pagos').val()
		// 	);
		// }
	},
	establecerPagos			: function (nPagos) {
		// alert(tipo);
		// $('#margen').text(totalNeto);
		// totalNeto = totalNeto.split('');
		// totalNeto.shift();

		/*Limpiamos el tbody de pagos cada vez que se entre a esta
		  función, al igual que el array de pagos*/
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
			fecha = this.$('#fechaInicioEvento').datepicker( 'getDate' );
			objDate = new Date( fecha.getTime() + ((plazo*nPagos)*24*60*60*1000));
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

			candado = 'icon-unlock icon-lock';
		} else if (this.$('#iguala').is(':checked')){
			plazo = 30;
			aumento = plazo;
			fecha = this.$('#fechaInicioIguala').datepicker( 'getDate' );
			objDate = new Date( fecha.getTime() + ((plazo*nPagos)*24*60*60*1000));
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
		} else {alerta('Seleccione un tipo de plan para el contrato', function () {});return;};

		objDate = new Date( fecha.getTime() + (1*24*60*60*1000));
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

			$('#tbody_pagos_'+this.tipoPlan).append(this.vistaPago[i].render().el);

			objDate = new Date(new Date(fecha).getTime() + (plazo*24*60*60*1000))
			fechaNormal = formatearFechaUsuario(objDate);
			fecha2 = fechaNormal.split('/');
			plazo = plazo + aumento;
		};

		// Descomentar para mantenimiento
			/************************/
			/*this.modificarPagos();*/
			/************************/
	},
	obtenerValor			: function (e) {
		var self = this, valorY;
		// las dos lineas siguientes seran utilizadas frencuentemente
		// por ello las respaldamos en una variable
		var resetearPagos = function (n) {
			self.$('#tbody_pagos_'+self.tipoPlan).html('');
			self.establecerPagos( n );
		};
		// solo si el evento es un enter o un cambio
		if (e.keyCode === 13 || e.type === 'change' || e.type === 'click') {
			// Ejecutamos la función que establece los pagos
			resetearPagos( parseInt($(e.currentTarget).val()) );
			// Solo si es evento es originado por el
			// rodillo del mouse
		} else if ( e.type === 'mousewheel' ) {
			// Solo si el valor evento no retorna valor,
			// establecemos el numero 1 manualmente
			if ( $(e.currentTarget).val() == '' ) {
				$(e.currentTarget).val('1').trigger('change');
				e.preventDefault();
			} else {
				// si aumentamos los plazos aumentamos 1 día
				if (e.originalEvent.wheelDeltaY < 0) {
					// Ejecutamos la función que establece los pagos
					resetearPagos( 
						parseInt($(e.currentTarget).val()) -1
					);
				// Sino, el usuario esta decrementando los días;
				// si el día actual es diferente de 1 porcedemos
				} else {
					// Ejecutamos la función que establece los pagos
					resetearPagos( 
						parseInt($(e.currentTarget).val()) +1
					);
				};

				
				// if (e.originalEvent.deltaY < 0) {
				// 	resetearPagos( 
				// 		parseInt($(e.currentTarget).val()) +1
				// 	);
				// } else if ($(e.currentTarget).val() != '1') {
				// 	resetearPagos( 
				// 		parseInt($(e.currentTarget).val()) -1
				// 	);
				// };



					
			};
		};
	},
	equilibrarPagos			: function (residuo, idVista) {

		var rentas = this.$('.input_renta');
		
		var pagoNuevo = 0.0;
		residuo = residuo/parseFloat(rentas.length);
		for (var i = 0; i < rentas.length; i++) {
			pagoNuevo = (parseFloat($(rentas[i]).val()) + residuo).toFixed(2);
			this.vistaPago[parseInt($(rentas[i]).attr('id'))].model.set({pago:pagoNuevo});
		};

		// Descomentar para mantenimiento
			/************************/
			/*this.modificarPagos();*/
			/************************/
	},
	guardarPagos			: function (json) {
		var self = this;
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		app.coleccionPagos.create(json,{
			wait 	: true,
			success	: function (coleccion) {
		// 		app.coleccionPagos.reset(coleccion);
				// console.log('Retorna esto: ',coleccion);
				self.guardado();
			},
			error	: function (error) {
				// console.log('Error al intentar guardar Pagos', error);
				self.noGuardada();
			}
		});		
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	},
	confirmarContratoGuardado	: function () {
		confirmar('El contrato se guardo con exito.<br>Si desea crear otro contrato haga clic en Aceptar'
		,function(){
			$('form')[0].reset();
		},function(){
			location.href = 'contratos_historial';
		});
	},
	eventosPlugins 			: function () {
		var self = this,
			date;
		this.$('#fechaFirma').on('change', function () {
			date = $(this).datepicker( 'getDate' );
			self.$('#hidden_fechafirma').val( date.getFullYear() + "-" + (date.getMonth() +1) + "-" + date.getDate() );
		});
	},
	recargarPagos 			: function () {
		this.$('#tbody_pagos_'+this.tipoPlan).html('');
		$('.n_pagos').first().trigger('change');
	},
	/********************************/
	/*Descomentar para mantenimiento*/
	/********************************/
		/*modificarPagos			: function () {
			var margen = $('#totalNeto').text().split(''),
				rentas = pasarAJson(this.$('.hidden_renta').serializeArray()),
				suma = 0.0;
			
			suma = function () {
						for (var i = 0; i < rentas.pago.length; i++) {
							suma += Number(rentas.pago[i]);
						};
						return suma;
					}();
			this.$('#suma').text((suma).toFixed(2))
			this.$('#margen').text(this.total);
			this.$('#diferencia').text((Number(this.total) - suma).toFixed(2));
		},*/	
});