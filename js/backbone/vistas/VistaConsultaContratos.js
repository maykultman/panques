var app = app || {};
/*Comentarios de en la funcion modificarPafo de la
  clase app.VistaNuevoContrato en el archivo del
  mismo nombre .js*/
app.VistaPago.prototype.modificarPago = function (e) {
	clearTimeout(this.timer);
	var self = this;
	this.timer = setTimeout(function() {
		var actual = parseFloat(self.model.get('pago')),
			idVista = parseInt($(e.currentTarget).attr('id'));
		var diferencia = (
			actual - parseFloat( 
						self.model.set({
							pago:$(e.currentTarget).val()
						},{
							wait:true
						}).get('pago') )
					).toFixed(2);
		self.bloquear(e);
		app.vistaEdicionContrato.equilibrarPagos(diferencia, idVista);
		self.desbloquear();
		self.$('#'+idVista).select();
	}, 200);
};

var Pago = Backbone.View.extend({
	tagName : 'div',
	template : _.template( $('#pago').html() ),
	events:{
		'change .pagado' : 'conmutar',
	},
	initialize : function () {
		this.listenTo(this.model, 'change', this.render);
	},
	render 	: function () {
		this.$el.html( this.template( this.model.toJSON() ) );
		return this;
	},
	conmutar : function () {
		this.model.cambiarStatus();
	}
});

app.VistaContrato = Backbone.View.extend({
	tagName : 'tr',
	events : {
		'click .span_papelera' 			: 'cambiarVisibilidad',
		'click .span_restaurar' 		: 'cambiarVisibilidad',
		'click .span_borrar' 			: 'eliminarPermanente',
		'click .span_acontrato' 		: 'pasarAContrato',
		'click .span_vistaPrevia'		: 'vistaPrevia',
		'click .span_papeleraVersion'	: 'cambiarVisibilidadVersion',
		'click .span_vistaPreviaVersion': 'vistaPreviaVersion',
		'click .label_statusVersion'	: 'cambiarStatus',
		'click .span_pagos' 			: 'cargarPagos',
	},
	initialize : function (){
		this.listenTo( this.model, 'destroy', this.remove);
		this.listenTo( this.model, 'change:visibilidad', this.remove);
	},
	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));

		this.$modalPagos = this.$('.modal-pago .contenedor-pagos');

		this.obtenerVersiones();

		return this;
	},
	obtenerVersiones	: function () {
		var original = [],
			versiones = [];
		// Tenemos que saber si se trata de la primera
		// versión u otra.
		if (this.model.get('version') == '1') {
			// si se trata de la primera versión obtenemos
			// las versiones derivadas de esta que no estén
			// eliminados
			versiones = app.coleccionContratos.where({
				idcontrato : this.model.get('id'),
				visibilidad  :'1'
			});
			// cargamos todo
			this.cargarVersiones(this.model, versiones);
		} else {
			// Sino, se trata de una version derivada.
			// Obtenemos la original sin importar si está
			// eliminada
			original = app.coleccionContratos.findWhere({
				id 			 :this.model.get('idcontrato')
			});
			// cargamos todo 	// original	// versiones
			this.cargarVersiones( original, app.coleccionContratos.where({
				idcontrato : this.model.get('idcontrato'),
				visibilidad  :'1'
			}) );
		};
	},
	cargarVersiones 	: function (original, versiones) {
		// console.log(original, versiones); return;
		var arrayJson = [],
			list 	  = $('#li_version').html();
		// Añadimos el original al principio del array,
		// si es que original tiene algún valor
		if (original != undefined)
			versiones.unshift(original);

		/*La versión original actualmente está en la papelera,
		  no la mostramos en la lista de versiones*/
		if (versiones[0].get('visibilidad') == '0') {
			/*La cotización original está en primera,
			posición del array. La quitamos del array*/
			versiones.shift();
		};

		/*Necesitamos un array de objetos json. Como el
		array actual son objetos de Backbone.Model,
		convertimos a json acada uno de ellos y los
		pasamos a un nuevo array.*/
		for (var i = 0; i < versiones.length; i++) {
			arrayJson.push(versiones[i].toJSON());
		};
		/*Ordenamos las versiones por version, (la api
		  desascomoda las versiones porque lo devuelve
		  por fecha) y luego quitamos los keys que se
		  crearon a ordenarlos. Reemplazamos arrayJson*/
		arrayJson = _.values(_.indexBy(arrayJson,'version'));
		this.$('#ul-versiones').html('').append(_.template(list)({
			versiones  	: arrayJson,
			actual  	: this.model.get('version')
		}));
	},
	cambiarStatus		: function (e) {
		// comentario en la funcion cambiarStatus
		// de la clase VistaCotizacion
		this.model.cambiarStatus();
		app.coleccionContratos
			.get($(e.currentTarget).val())
			.off()
			.cambiarStatus();
	},
	cambiarVisibilidad 	: function () {
		var self = this;
		if (this.model.get('visibilidad') == '1') {
			confirmar('¿Está seguro de que desea eliminar el contrato <b>'
						+this.model.get('serviciosolicitado')+
						'<b>?<br>Se enviará a la papelera',
				function () {
					self.model.cambiarVisibilidad();
				},
				function () {});			
		} else{
			this.model.cambiarVisibilidad();
		};
	},
	cambiarVisibilidadVersion	: function (e) {
		e.preventDefault();
		var vista = new app.VistaContrato({
			model:app.coleccionContratos.get($(e.currentTarget).attr('id'))
		});
		vista.setElement($(e.currentTarget).parents('li'));
		vista.cambiarVisibilidad();
	},
	eliminarPermanente : function () {
		var self = this;
		confirmar('El contrato <b>'
			+this.model.get('serviciosolicitado')+
			'</b> será eliminada permanentemente',
			function () {
				self.model.eliminarPermanente();
			},
			function () {});
	},
	vistaPrevia 		: function(e) {
		localStorage.clear();
		var self = this;
		var json = {
			datos 		: (function () {
				var jsonC = self.model.toJSON();
				var jsonP = {
					pago: _.pluck(_.where(app.coleccionPagos.toJSON(),{
						idcontrato:self.model.get('id')
					}), 'pago'),
					fechapago: _.pluck(_.where(app.coleccionPagos.toJSON(),{
						idcontrato:self.model.get('id')
					}), 'fechapago')
				};
				
				jsonC.pago 		= jsonP.pago;
				jsonC.fechapago = jsonP.fechapago;
				return jsonC;
			})(),
			secciones 	: (function () {
				// la funcion _.where simpre regresa un arreglo
				var jsonSC = _.where(app.coleccionServiciosContrato.toJSON(),{
						idcontrato:self.model.get('id')
					});

				return jsonSC;
			})()
		};
		// $('body').html(JSON.stringify(json));return false;
		app.coleccionContratos_L.create(json, {
			wait: true,
			success: function (exito) {
				window.open("formatoContrato");
			},
			error: function (error) {}
		});
		e.preventDefault();
	},
	vistaPreviaVersion	: function (e) {
		e.preventDefault();
		var vista = new app.VistaContrato({
			model:app.coleccionContratos.get($(e.currentTarget).attr('id'))
		});
		vista.vistaPrevia();
	},
	cargarPagos 		: function (e) {
		var pagos = app.coleccionPagos.where({ idcontrato:this.model.get('id') }),
			vista;
		this.$modalPagos.html('');
		for (var i = 0; i < pagos.length; i++) {
			vista = new Pago({ model:pagos[i] });
			this.$modalPagos.append( vista.render().el );
		};
	}
});

var VistaContratoEliminado = app.VistaContrato.extend({
	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	}
});

var EdicionContrato = app.VistaNuevoContrato.extend({
	el : '#section_actualizar',
	initialize 				: function () {
		var self = this;
		this.listenTo(app.coleccionContratos, 'reset', function () {
			var folio = app.coleccionContratos.establecerFolio();
			this.$('input[name="folio"]').val(folio);
			this.$('#h4_folio').text('Folio: '+ folio).fadeIn('fast');
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
	establecerDatos 	: function() {
		var idcontrato 	= this.model.get('id'),
			secciones 		= app.coleccionServiciosContrato
								 .where({
								 	idcontrato:idcontrato
								 }),
			idservicio 		= '',
			json 			= {},
			preciotiempo 	= this.model.get('preciotiempo'),
			vSeccion,
			folio,
			$select 		= this.$('#busqueda'),
			$selectPlugin 	= this.$('#busqueda')[0].selectize,
			pagos,
			pago,
			Modelo,
			vistaPago = [],
			enunciados,
			self = this;
		
		/*La función render de la clase padre no establece
		el nuevo folio para la nueva versión de la cotización.
		esto es porque la longitud de la colección es mayor
		aquí. Tenemos que realizarlo manualmente.
		También tenemos que estanblecer el folio que viene
		desde le servidor, del array de objetos a la coleccion
		de cotizaciones de Backbone. 
		/*--DESCOMENTAR SI LOS FOLIO NUNCA DEBEN REPETIRSE--*/
			app.coleccionContratos.folio 
				= app.coleccionDeContratos.folio.folio;
			folio = app.coleccionContratos.establecerFolio();
		this.$('#h4_folio')
				.text( 'Folio: '+ folio )
				.fadeIn('fast');
		this.$('input[name="folio"]').val( folio );

		this.$('#serviciosolicitado').val(this.model.get('serviciosolicitado'));
		$selectPlugin.setValue(this.model.get('idcliente'));
		$selectPlugin.disable();
		$select.after('<input type="hidden" name="idcliente" value="'+this.model.get('idcliente')+'">');
		$select.attr('name','');
		$select.attr('disabled',true);

		this.$('input[name="descuento"]')
			.val(this.model.get('descuento'));

		for(i in secciones) {
			if (secciones[i].get('idcontrato') == idcontrato) {
				if (idservicio != secciones[i].get('idservicio')) {
					idservicio = secciones[i].get('idservicio');
					this.$('#servicio_'+idservicio).click();
					this.$el
						.find('#table_servicio_'+idservicio+' tbody')
						.html('');
				};
				json = secciones[i].toJSON();
				json.preciotiempo = preciotiempo;
				vSeccion = new VistaSeccion();
				this.$('#table_servicio_'+idservicio+' tbody')
					.append( vSeccion.render(json).el );
			};
		}
		this.$('#precio_hora')
			.val(preciotiempo)
			.trigger('change');

		this.$('input[value="'+this.model.get('plan')+'"]').click();
		if (this.model.get('plan') == 'evento') {
			// this.$('#fechaInicioEvento').val( this.model.get('fechainicio') );
			this.$('#plazo')			.val( this.model.get('plazo') );
			this.$('.n_pagos:eq(0)')	.val( this.model.get('nplazos') );
			   /*---------------------*/
			  /*-Establece los pagos-*/
			 /*---------------------*/
			/*setTimeout(function() {
				self.$('#tbody_pagos_evento').html('');
					
				pagos = _.where(app.coleccionPagos.toJSON(), {
					idcontrato:self.model.get('id')
				});

				pago = (
					Number(self.model.get('total'))/
					Number(self.model.get('nplazos'))
				).toFixed(2);
				
				for (var i = 0; i < pagos.length; i++) {
					Modelo = Backbone.Model.extend({
						defaults		: { 
							id 			: i,
							n 			: i+1,
							fecha		: formatearFechaUsuario(new Date(pagos[i].fechapago)),
							fecha2		: pagos[i].fechapago,
							pago 		: pagos[i].pago,

							candado		: 'icon-unlock icon-lock',
							active 		: '',
							disabled	: '',

							atrClase	: 'input_renta'
						}
					});
					vistaPago[i] = new app.VistaPago({model : new Modelo});

					self.$('#tbody_pagos_'+self.model.get('plan')).append(vistaPago[i].render().el);
				};
			}, 10);*/

		} else if (this.model.get('plan')=='iguala') {
			this.$('.n_pagos:eq(1) option[value="'
				+this.model.get('nplazos')+
				'"]')
				.attr('selected',true);
		};

		enunciados = this.model.get('enunciado').split(',.,');
		for (var i = 0; i < enunciados.length; i++) {
			this.$('#panel_enunciados')
				.append( _.template($('#plantilla-input-group-enunciado')
				.html())({
					enunciado:enunciados[i]
				}) );
		};

		this.cargarEnunciados();
	},
	obtenerDatos		: function () {
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
			if (   json.serviciosolicitado == '' 
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

		if (this.model.get('version') == '1') {
			json.datos.version = parseInt(
				_.max( _.pluck( _.where(app.coleccionContratos.toJSON(),{
					idcontrato:this.model.get('id')
				}),'version' ), function (version) {
					return version;
				}) ) +1;
			if ( !json.datos.version ) {
				json.datos.version = parseInt( this.model.get('version') ) +1;
			};
			json.datos.idcontrato = this.model.get('id');
		} else{
			json.datos.version = parseInt(
				_.max( _.pluck( _.where(app.coleccionContratos.toJSON(),{
					idcontrato:this.model.get('idcontrato')
				}),'version' ), function (version) {
					return version;
				}) ) +1;
			json.datos.idcontrato = this.model.get('idcontrato');
		};

		return json;
	},
	guardado			: function () {
		if (this.aumentarContador() == this.totalelementos) {
			// Ocultamos la versión actual
			this.model.off().cambiarStatus();
			$('#block').toggleClass('activo');
			alerta('Se ha renovado el contrato', function () {
				location.href = 'contratos_historial';
			});
		};
	},
	noGuardada			: function () {
		if (this.aumentarContador() == this.totalelementos) {
			// Ocultamos la versión actual
			this.model.off().cambiarStatus();
			$('#block').toggleClass('activo');
			alerta('La renovación del contrato ha sido guardado, pero ocurrieron algunos errores<br>Recomendamos que revice el contrato', function () {
				location.href = 'contratos_historial';
			});
		};
	},
	establecerRegreso  	: function  () {
		var self = this;
		$('.btn_toggle').on('click', function () {
			// Conmutamos la visibilidad de las
			// secciones
			$('#seccion_tabla').fadeToggle();
			$('#section_actualizar').fadeToggle();
			// Borramos el contenido del formulario
			$('#formPrincipal').html('');
			// Apagamos el evento clic del botón regresar
			$('.btn_toggle').off('click');
			// Apagamos todos los eventos de la vista
			// edición
			self.undelegateEvents();
		});
	},
});

app.VistaConsultaContratos = app.VistaConsultaCotizaciones.extend({
	el 		: '#seccion_tabla',
	cargar 				: function (model, eliminado) {
		var vista;
		model.set({    
	 		cliente  : app.coleccionClientes. get ( model.get( 'idcliente'  ) ).get('nombreComercial'),
	 		empleado : app.coleccionUsuarios.get ( model.get( 'idusuario' ) ).get('usuario'),
			total    : function () {
				var modelos = app.coleccionServiciosContrato.where({idcontrato:model.get('id')}),
					horas = 0,
					total = 0;
				for (var i = 0; i < modelos.length; i++) {
					horas += Number(modelos[i].get('horas'));
				};
				total = horas * Number(model.get('preciotiempo'));
				total = total - total * Number(model.get('descuento'))/100;
				total = total + total * 0.16;
				total = conComas(total.toFixed(2));
				return total;
			}()
	 	});
		if (eliminado) {
			vista = new VistaContratoEliminado({model : model});
		} else {
			vista = new app.VistaContrato({model : model});
		};
		vista.plantilla = _.template($('#tds_contrato').html());
		this.$tbodyContratos.append( vista.render().el);
	},
	obtenerActivos		: function () {
		this.$tbodyContratos.html('');
		var contratos = app.coleccionContratos.where({
			status	: '1',
			visibilidad: '1'
		});
		this.recursividad(contratos, false);
	},
	obtenerEliminados	: function () {
		this.$tbodyContratos.html('');
		var contratos = app.coleccionContratos.where({
			visibilidad: '0'
		});
		this.recursividad(contratos, true);
	},
    eliminarVarios 		: function () {
		var here = this, mensaje, visibilidad, ids;
		/*De los checkboxs con class .todos tomamos el primero (sin importar si hay uno o vareios checheados)
		  Si hay checheados, procedemos*/
		if (this.$('input[name="todos"]:checked').val()) {
			/*Solo con el primer cliente seleccionado nos vasta para saber
			  lo que queremos eliminar (clientes o prospectos).*/
			visibilidad = app.coleccionContratos
							 .get(this.$('input[name="todos"]:checked').val())
							 .toJSON()
							 .visibilidad;
			if ( visibilidad == '1' ) {
				mensaje = '¿Deseas eliminar los contratos seleccionados?<br><b>Se enviarán a la papelera</b>';
			} else {
				mensaje = '¿Deseas borrar los contratos seleccionados?<br><b>Toda la información relacionada con el contrato serán borrado</b>';
			};
			confirmar(mensaje,
				function () {
					ids = pasarAJson(here.$('input[name="todos"]:checked').serializeArray()).todos;
					if ( visibilidad == '1' ) { /*Si visibilidad es 1, queremos enviar clientes a la papelera*/
						if ($.isArray(ids)) { /*Si es verdadero, eliminaremos varios clientes*/
							for (var i = 0; i < ids.length; i++) {
								app.coleccionContratos
								   .get(ids[i])
								   .cambiarVisibilidad();
							};
						} else{/*De lo contrario, solo un cliente será eliminado*/
							app.coleccionContratos
							   .get(ids)
							   .cambiarVisibilidad();
						};
					} else{ /*Si la visibilidad no es 1, entonces su valor es 0, el los clientes seran
						      eliminados permanentemente*/
						if ($.isArray(ids)) { /*Si es verdadero, borraremos varios clientes*/
							for (var i = 0; i < ids.length; i++) {
								app.coleccionContratos.get(ids[i]).destroy({
									wait : true,
									success	: function (exito) {
									},
									error	: function (error) {
										error('Error al Borrar a <b>'
												+error.toJSON().serviciosolicitado+
											'</b>. Intentelo más tarde');
									}
								});
							};
						} else{/*De lo contrario, solo un cliente será borrado*/
							app.coleccionContratos.get(ids).destroy({
								wait : true,
								success	: function (exito) {
								},
								error	: function (error) {
									error('Error al Borrar a <b>'
											+error.toJSON().serviciosolicitado+
										'</b>. Intentelo más tarde');
								}
							});
						};
							
					};
				},
				function () {});
		};	
	},
	restaurarVarios		: function () {
		if (this.$('input[name="todos"]:checked').val()) { /*Por lo menos un cliente seleccionado*/
			var ids = pasarAJson(this.$('input[name="todos"]:checked').serializeArray()).todos;
			if ($.isArray(ids)) { /*Sol varios clientes ha restaurar*/
				for (var i = 0; i < ids.length; i++) {
					app.coleccionContratos
					   .get(ids[i])
					   .cambiarVisibilidad();
				};
			} else{/*Solo se quiere restaurar un cliente*/
				app.coleccionContratos
				   .get(ids)
				   .cambiarVisibilidad();
			};
		};
	},
	editar  			: function(e) {
		app.vistaEdicionContrato = new EdicionContrato({
			model:app.coleccionContratos
					 .get( $(e.currentTarget)
						 .children()
					 .val() )
		});
		app.vistaEdicionContrato.establecerDatos();
		app.vistaEdicionContrato.establecerRegreso();
	},
});

app.ContratosVisibles = app.VistaConsultaContratos.extend({
	/*********************************/
	/**Comentarios en la clase padre**/
	/*********************************/
	initialize : function () {
		this.$tbodyContratos = this.$('#tbody_contratos');
		this.obtenerActivos();
		var self = this;
		this.listenTo( app.coleccionContratos,
			'change:status',
		function () {
			app.coleccionContratos.fetch({
				reset:true,
				wait:true,
				success: function () {
					self.obtenerActivos();
				}
			});
		});
		this.cargarPlugin();
	}
});

app.ContratosEliminadas = app.VistaConsultaContratos.extend({
	initialize : function () {
		this.$tbodyContratos = this.$('#tbody_contratos');
		this.obtenerEliminados();

		this.cargarPlugin();		
	}
});