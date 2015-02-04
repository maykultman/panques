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
			'change     #busqueda'     	: 'buscarRepresentante',
			'click 	   #guardar'	   	: 'guardar',
			'click     #cancelar'		: 'cancelar',
			'click     .todos'	     	: 'marcarTodosCheck',
			'click     #vista-previa' 	: 'vistaPrevia',

			/*Botones del thead los servicios que se están cotizando*/
			'click .span_deleteAll'	 		: 'eliminarServicios',
			'click .span_eliminar_servicio' : 'eliminarServicio',
			'click .span_toggleAllSee'	 	: 'conmutarServicios',
			
			'change     .importe'     : 'calcularSubtotal',
			'change     .input-plan'  : 'calcularSubtotal',
			'mousewheel .input-plan'  : 'calcularSubtotal',
			'blur       .input-plan'  : 'calcularSubtotal',

			'change 	#precio_hora' : 'dispararCambio',
			'mousewheel #precio_hora' : 'dispararCambio',
			'blur 		#precio_hora' : 'dispararCambio',

			'change 	.input-tfoot' : 'calcularTotal',
			'mousewheel .input-tfoot' : 'calcularTotal',
			'blur 		.input-tfoot' : 'calcularTotal',
				
			'change .btn_plan'		  : 'conmutarTablaPlan',

		// Eventos de contrato

			'change input[name="npagos"]'		: 'obtenerValor',/*EVENTO IGUALA*/
			'mousewheel input[name="npagos"]'	: 'obtenerValor',/*EVENTO IGUALA*/
			/*'click input[name="npagos"]'		: 'obtenerValor',*//*EVENTO IGUALA*/
			'keyup input[name="npagos"]'		: 'obtenerValor',/*EVENTO IGUALA*/

			'click #btn_recargarPagos'	: 'recargarPagos',
			'click 	   #guardar'	   	: 'guardar', //Guarda la cotización
			'click .btn_quitarEnunciado': 'enunciado',
			'click .btn_anadirEnunciado': 'enunciado',

			'change #plazo'					: 'cambiar_n_pagos', /*EVENTO*/
			'mousewheel #plazo'				: 'cambiar_n_pagos', /*EVENTO*/
			'click #plazo'					: 'cambiar_n_pagos', /*EVENTO*/
			'keyup #plazo'					: 'cambiar_n_pagos', /*EVENTO*/
			'change #fechaInicioEvento' 	: 'cambiar_n_pagos',
			'change #fechaInicioIguala' 	: 'cambiar_n_pagos'
			// 'click .td_servicio tfoot button' : 'calcularTotal'


			// 'change .input_renta'	: 'equilibrarPagos',
			// 'wheel .input_renta'	: 'equilibrarPagos',
			// 'blur .input_renta'	: 'equilibrarPagos',
	},
	initialize 				: function () {
		var self = this;
		this.listenTo(app.coleccionContratos, 'reset', function () {
			var folio = app.coleccionContratos.establecerFolio();
			this.$('input[name="folio"]').val(folio);
			this.$('#h4_folio').text('Folio: '+ folio).fadeIn('fast');

			// los enunciados es lo que el cliente está comprando. solo
			// se pueden recuperar en este lugar, debido a que en la 
			// creación un contrato no se envia la colección
			// sino hasta que se solicita.
			self.cargarEnunciados();
		});

		this.render();
		// // Inicializamos la tabla servicios que es donde esta la lista de servicios a seleccionar
		// // this.$tablaServicios = this.$('#listaServicios');
		this.contadorAlerta = 1;
		this.totalelementos = 0;

		localStorage.clear();

		this.$npagosEvento = this.$el.find('input[name="npagos"]:eq(0)');
		this.$npagosIguala = this.$el.find('input[name="npagos"]:eq(1)');
	},
	render 					: function () {
		this.$('#formPrincipal').html( $('#plantilla-formulario').html() );
		
		// Invocamos el metodo para cargar y pintar los servicios
		this.cargarServicios();

		this.cargarPlugins();

		// this.$('#fecha').val( formatearFechaUsuario(new Date()) );
		/*BORRAR PARA PRODUCCIÓN (HAY MÁS)*/this.$('#serviciosolicitado').val('Contrato No. '+(Math.random()).toFixed(3) *1000);

		/*FOLIO. En la cración de una cotización ocurrira el fetch,
		  pero cuando se edite una cotización no se realizará*/
		if (app.coleccionContratos.length == 0) {
			app.coleccionContratos.fetch({reset:true});
		};
		return this;
	},
	cambiar_n_pagos 		: function (e) {
		var id = $(e.currentTarget).attr('id');
		if (id == 'plazo' || id == 'fechaInicioEvento')
			if (id=='plazo') {
				if (this.$('#plazo').val() == 1) {
					this.$npagosEvento.val(1).trigger('change');
				} else{
					this.$npagosEvento.trigger('change');
				};
			} else{
				this.$npagosEvento.trigger('change');
			};
		if (id == 'fechaInicioIguala') 
			this.$npagosIguala.trigger('change');
	},
	calcularTotal 			: function () {
		this.bloquearInputs();

		/*Reescribimos esta función para agregar
		  código. ver [1] en esta función*/
		var valores = this.$('.input-tfoot'),
			self = this;
		/*El capo Descuento es un input number, por lo que cuando se escribe
		  un número con letras, el campo lo rechaza y adopta el valor ''*/
		if ($(valores[1]).val() == '') {
			alerta('El campo Descuento solo acepta números', function () {});
			$(valores[1]).val('0');
		};
		var	total = function () {
						if (self.tipoPlan == 'evento') {
							return Number(self.$('#subtotal_evento').val());
						} else if (self.tipoPlan == 'iguala') {
							return Number(self.$('#precio_mes').val());
						};
					}(),
			desc  = Number($(valores[1]).val()) / 100,
			iva   = Number($(valores[2]).val()) / 100,
			decimales;

		total = total - total * desc;
		total = total + total * iva;
		this.total = total.toFixed(2);
		
		// [1]
		// Verificamos que tipo de plan está activo y
		// disparamos un evento al campo pertinente.
		if (this.$('#porEvento').is(':checked')) {
			this.$('#label_total').text( '$'+conComas(total.toFixed(2)) );
			this.obtenerValor( parseInt( this.$npagosEvento.val() ) );
		} 
		else if(this.$('#iguala').is(':checked')){
			var npagos = Number( this.$npagosIguala.val() );
			this.$('#label_total').text( '$'+conComas( (total * npagos).toFixed(2) ) );
			this.obtenerValor( npagos );
		};

		this.calcularTotalHoras();
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
	vistaPrevia 			: function(e) {
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
				window.open("formatoContrato");
			},
			error: function (error) {}
		});
		e.preventDefault();
	},
	cancelar 				: function () {
		location.href = 'contratos_historial';
	},
	guardar 				: function () {
		if (!this.obtenerDatos()) {
			return;
		};
		
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
	guardarSeccion			: function (idContrato, secciones) {
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
	guardado				: function () {
		if (this.aumentarContador() == this.totalelementos) {
			var self = this;
			$('#block').toggleClass('activo');
			alerta('¡Contrato guardado!', function () {
				confirmar('<b>¿Deseas crear otro contrato?</b>', function () {
					$('#formPrincipal')[0].reset();
					$('.span_eliminar_servicio').click();
					app.coleccionContratos.off().reset();
					self.initialize();
				}, function () {
					location.href = 'contratos_historial';
				});
			});
		};
	},
	noGuardada				: function () {
		if (this.aumentarContador() == this.totalelementos) {
			$('#block').toggleClass('activo');
			alerta('El contrato ha sido guardado, pero ocurrieron algunos errores<br>Revice el contrato en el historial de contratos', function () {
				location.href = 'contratos_historial';
				this.resetearContador();
			});
		};
	},
	obtenerDatos			: function () {
		this.bloquearInputs();
		var forms = this.$('.form_servicio'),
			json  = pasarAJson(this.$('   #serviciosolicitado,'
										+'#busqueda,'
										+'#idrepresentante,'
										+'#hidden_fechafirma,'
										+'input[name="plan"]:checked,'
										+'#select_firmaempleado,'
										+'#enunciado')
					.serializeArray()),
			fechainicio,
			fechafinal;
		// Cortafuego para forzar establecer los siguientes datos
			if (   json.prestaciones == '' 
				|| json.idcliente == '' 
				|| json.idrepresentante == ''
				|| json.firmaempleado == ''
				|| json.fechafirma == ''
			) {
				alerta('Complete los <b>datos básicos</b>', function () {});
				return false; // Terminamos el flujo del código
			} else if( !json.plan ){
				alerta('Seleccione un tipo de <b>plan</b>', function () {});
				return false; // Terminamos el flujo del código
			} else if ( !json.enunciado ) {
				alerta('Seleccione o escriba los <b>enunciados</b> del contrato', function () {});
				return false; // Terminamos el flujo del código
			};
		json = { secciones : [], datos : '' };
		// Datos básicos
			json.datos = pasarAJson(this.$('#formPrincipal')
						.serializeArray());
			if ( Array.isArray(json.datos.enunciado) )
				json.datos.enunciado = json.datos.enunciado.join(',.,');
		// Validar datos
			if ( json.datos.plan == 'evento' ){
				
				json.datos.fechainicio = formatearFechaDB(this.$('#fechaInicioEvento').datepicker('getDate'));
				json.datos.fechafinal = formatearFechaDB(this.$('#vencimientoPlanEvento').attr('disabled',false).datepicker('getDate'));
				this.$('#vencimientoPlanEvento').attr('disabled',true);
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
				
				json.datos.fechainicio = formatearFechaDB(this.$('#fechaInicioIguala').datepicker('getDate'));
				json.datos.fechafinal = formatearFechaDB(this.$('#vencimientoPlanIguala').attr('disabled',false).datepicker('getDate'));
				this.$('#vencimientoPlanIguala').attr('disabled',true);
				if ( json.datos.nplazos == '' ) {
					alerta('Establezca las <b>Mensualidades</b>');
					return false;
				}
			};
		// Datos pagos
			json.datos.totalletra 
			= 
			(NumeroALetras(this.total)).trim();
		// Cortafuego. Debe haber al menos 1 servicio para contratar
			if (!forms.length) {
				alerta('Seleccione al menos un <b>servicio</b> para contratar'
						, function () {});
				return false; // Terminamos el flujo del código
			};		
		// Servicios cotizados
			for (var i = 0; i < forms.length; i++) {
				json.secciones.push( pasarAJson($(forms[i])
									 .serializeArray()) );
			};
		// Datos basura
			delete json.datos.todos;
		
		json.datos.version = 1;

		return json;
	},
	bloquearInputs : function () {
		var self = this;
		setTimeout(function() {
			jQuery.fn.doOnce = function(func){
			this.length && func.apply(this);
				return this;
			}

			switch(self.tipoPlan){
				case 'iguala':
					self.$('.horas, .costoSeccion, .importe').doOnce(function(){
						$(this).css('text-decoration','line-through');
					});
					self.$('.horas, .input-group-constoSeccion, .input-group-importe').doOnce(function(){
						$(this).css('opacity','.5');
					});

					self.$('#precio_hora').attr('disabled',true);
					self.$('#precio_mes').attr('disabled',false);

					this.$('#plazo').attr('disabled',true);

					self.$npagosEvento.attr('disabled',true);
					self.$npagosIguala.attr('disabled',false);

					self.$(
						'#tbody_pagos_evento input[name="fechapago"],'+
						'#tbody_pagos_evento input[name="pago"]'
						).attr('disabled',true);
					self.$(
						'#tbody_pagos_iguala input[name="fechapago"],'+
						'#tbody_pagos_iguala input[name="pago"]'
						).attr('disabled',false);
				break;
				case 'evento':
					self.$('.horas, .costoSeccion, .importe').doOnce(function(){
						$(this).css('text-decoration','initial');
					});

					self.$('.horas, .input-group-constoSeccion, .input-group-importe').doOnce(function(){
						$(this).css('opacity','1');
					});
					self.$('#precio_mes').attr('disabled',true);
					self.$('#precio_hora').attr('disabled',false);

					this.$('#plazo').attr('disabled',false);

					self.$npagosEvento.attr('disabled',false);
					self.$npagosIguala.attr('disabled',true);

					self.$(
						'#tbody_pagos_evento input[name="fechapago"],'+
						'#tbody_pagos_evento input[name="pago"]'
						).attr('disabled',false);
					self.$(
						'#tbody_pagos_iguala input[name="fechapago"],'+
						'#tbody_pagos_iguala input[name="pago"]'
						).attr('disabled',true);
				break;
			}
		}, 10);
	},
	/*Funciones de contrato*/
	establecerPagos			: function (nPagos) {
		/*Limpiamos el tbody de pagos cada vez que se entre a esta
		  función, al igual que el array de pagos*/
		var plazo = 1,
			fecha = '',
			candado = 'icon-unlock',
			disabled = '',
			active = '',
			objDate,
			Modelo;


		this.vistaPago = []

		if (this.$('#porEvento').is(':checked')) {
			plazo = parseInt($('#plazo').val());
			
			fecha = this.$('#fechaInicioEvento').datepicker( 'getDate' );
			try {
				objDate = new Date( fecha.getTime() + ((plazo*nPagos)*24*60*60*1000));
			} catch (error) {
				return;
			};
			
			$('#vencimientoPlanEvento').datepicker( "setDate", objDate, 'd MM, yy' );
			
			$('#fechafinalEvento').val( formatearFechaDB(objDate) );

			candado = 'icon-unlock icon-lock';
			// ----------------------------------
			for (var i = 0; i < nPagos; i++) {
				Modelo = Backbone.Model.extend({
					defaults	: { 
						id 		: i,
						n 		: i+1,
						fechatabla	: formatearFechaUsuario( new Date( fecha.getTime() -1*24*60*60*1000 ) ),
						// fechapago	: formatearFechaDB( new Date( fecha.getTime() -1*24*60*60*1000 ) ),
						// fechatabla	: formatearFechaUsuario( fecha ),
						fechapago	: formatearFechaDB( fecha ),
						pago 	: (this.total/nPagos).toFixed(2),

						candado	: candado,
						active 		: active,
						disabled	: disabled,

						atrClase	: 'input_renta'
					}
				});
				this.vistaPago[i] = new app.VistaPago({model : new Modelo});

				$('#tbody_pagos_'+this.tipoPlan).append(this.vistaPago[i].render().el);

				fecha = new Date(fecha.getTime() + (plazo*24*60*60*1000));
			};
		} else if (this.$('#iguala').is(':checked')){
			plazo = 30;
			
			fecha = this.$('#fechaInicioIguala').datepicker( 'getDate' );
			try {
				objDate = new Date( fecha.getTime() + ((plazo*nPagos)*24*60*60*1000));
			}
			catch (error) { return; };
			
			$('#vencimientoPlanIguala').datepicker( "setDate", objDate, 'd MM, yy' );
			
			$('#fechafinalIguala').val( formatearFechaDB(objDate) );

			candado = 'icon-lock';
			disabled = 'disabled';
			active = 'active';
			// ----------------------------------
			for (var i = 0; i < nPagos; i++) {
				Modelo = Backbone.Model.extend({
					defaults	: { 
						id 		: i,
						n 		: i+1,
						fechatabla	: formatearFechaUsuario( new Date( fecha.getTime() -1*24*60*60*1000 ) ),
						// fechapago	: formatearFechaDB( new Date( fecha.getTime() -1*24*60*60*1000 ) ),
						// fechatabla	: formatearFechaUsuario( fecha ),
						fechapago	: formatearFechaDB( fecha ),
						pago 	: this.total,

						candado	: candado,
						active 		: active,
						disabled	: disabled,

						atrClase	: 'input_renta'
					}
				});
				this.vistaPago[i] = new app.VistaPago({model : new Modelo});

				$('#tbody_pagos_'+this.tipoPlan).append(this.vistaPago[i].render().el);

				fecha = new Date(fecha.getTime() + (plazo*24*60*60*1000));
			};
		} else {alerta('Seleccione un tipo de plan para el contrato', function () {});return;};

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

		if (_.isNumber(e)) {
			resetearPagos(e);
			return;
		}

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
			};
		};
	},
	equilibrarPagos			: function (residuo, idVista) {

		var rentas = this.$('#tbody_pagos_evento .input_renta');
		
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
	recargarPagos 			: function () {
		this.$('#tbody_pagos_'+this.tipoPlan).html('');
		$('input[name="npagos"]').first().trigger('change');
	},
	enunciado 		:function (e) {
		var longitud = this.$('.campo-enunciado').length;
		if ( $(e.currentTarget).attr('class')=='btn btn-default btn_anadirEnunciado' ) {
			if ( longitud >= 1 ) {
			this.$('#panel_enunciados')
				.append( _.template($('#plantilla-input-group-enunciado')
				.html()) );
			};
		} else if ( $(e.currentTarget).attr('class')=='btn btn-default btn_quitarEnunciado' ) {
			if ( longitud > 1 ) {
				$(e.currentTarget).parents('.campo-enunciado').remove();
			};
		};
	},
	cargarPlugins 		: function () {
		var self = this,
			date;
		this.$('#fechaFirma').on('change', function () {
			date = $(this).datepicker( 'getDate' );
			self.$('#hidden_fechafirma').val( date.getFullYear() + "-" + (date.getMonth() +1) + "-" + date.getDate() );
		});
		loadDatepicker('.datepicker');
		loadSelectize_Client('#busqueda',{
			valueField  : 'id',
			labelField  : 'title',
			searchField : 'title',
			maxItems    : 1,
			create      : false
		},app.coleccionClientes.toJSON());

		this.$('#table_servicios').tablesorter({
			theme: 'blue',
			widgets: ["zebra", "filter"],
			widgetOptions : {
				filter_external : '.search-services',
				filter_columnFilters: false,
				filter_saveFilters : true,
				filter_reset: '.reset'
			}
		}).bind('filterEnd', function () {
			// comentarios en la función cargarPlugins de
			// VistaNuevaCotizacion.js
			if (!self.$('#table_servicios tbody tr:visible').length) {
				self.$('.search-services').on('keypress', function (e) {
					self.guardarNuevoServ(e);
					self.$('.search-services').off('keypress');
				});
				self.$('#alert_anadirNuevioServicio').show();
			} else {
				self.$('.search-services').off('keypress');
				self.$('#alert_anadirNuevioServicio').hide();
			};
		});

		this.$('#select_firmaempleado').selectize();
	},
	cargarEnunciados : function () {
	    var $select = this.$('#enunciado').selectize({
				valueField  : 'title',
				labelField  : 'title',
				searchField : 'title',
				create      : true
			});
	    var control = $select[0].selectize;
	    control.clearOptions();
	    control.addOption(function () {
	        var array = [],
	        	enunciados = _.pluck(app.coleccionContratos.toJSON(),'enunciado');
			enunciados = enunciados.join(',.,');
			enunciados  = enunciados.split(',.,');
	        for (var i = 0; i < enunciados.length; i++) {
	           array.push({
	                id      : enunciados[i],
	                title   : enunciados[i]
	            });
	        };
	        return array;
	    }());
	}
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