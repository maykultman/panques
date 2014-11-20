var app = app || {};

app.VistaCotizacion = Backbone.View.extend({
	tagName : 'tr',
	events : {
		'click .span_papelera' 			: 'cambiarVisibilidad',
		'click .span_restaurar' 		: 'cambiarVisibilidad',
		'click .span_borrar' 			: 'eliminarPermanente',
		'click .span_acontrato' 			: 'pasarAContrato',
		'click .span_vistaPrevia'		: 'vistaPrevia',
		'click .span_papeleraVersion'	: 'cambiarVisibilidadVersion',
		'click .span_vistaPreviaVersion': 'vistaPreviaVersion',
		'click .label_statusVersion'	: 'cambiarStatus'
	},
	initialize : function (){
		this.listenTo( this.model, 'destroy', this.remove);
		this.listenTo( this.model, 'change:visibilidad', this.remove);
	},
	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		this.obtenerVersiones();
		return this;
	},
	obtenerVersiones	: function () {
		var original  = [],
			versiones = [];
		original = app.coleccionCotizaciones.where({
			id:this.model.get('idcotizacion')
		});
		if (original.length) {
			versiones = app.coleccionCotizaciones.where({
				idcotizacion:original[0].get('id'),visibilidad:'1'
			});
			this.cargarVersiones(original, versiones);
		} else {
			versiones = app.coleccionCotizaciones.where({
				idcotizacion:this.model.get('id')
			});
			if (versiones.length) {
				original = app.coleccionCotizaciones.where({
					id:versiones[0].get('idcotizacion'),visibilidad:'1'
				});
				this.cargarVersiones(original, versiones);
			};
		};
	},
	cargarVersiones 	: function (original, versiones) {
		var arrayJson = [],
			list 	  = $('#li_version').html()
		// Añadimos el original al principio del array
		versiones.unshift(original[0]);

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
			versiones : arrayJson,
			actual : this.model.get('version')
		}));
	},
	cambiarStatus		: function (e) {
		this.model.cambiarStatus();
		app.coleccionCotizaciones
			.get($(e.currentTarget).val())
			.cambiarStatus();
	},
	cambiarVisibilidad : function () {
		var self = this;
		if (this.model.get('visibilidad') == '1') {
			confirmar('¿Está seguro de que desea eliminar la cotización <b>'
						+this.model.get('titulo')+
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
		var vista = new app.VistaCotizacion({
			model:app.coleccionCotizaciones.get($(e.currentTarget).attr('id'))
		});
		vista.setElement($(e.currentTarget).parents('li'));
		vista.cambiarVisibilidad();
	},
	eliminarPermanente : function () {
		var self = this;
		confirmar('La cotización <b>'
			+this.model.get('titulo')+
			'</b> será eliminada permanentemente',
			function () {
				self.model.eliminarPermanente();
			},
			function () {});
	},
	pasarAContrato : function() {
		alert('contrato');
	},
	vistaPrevia : function() {
		localStorage.clear();

		localStorage.imprimir = true;
		
 		var servicios = app.coleccionServiciosCotizados.where({
 			idcotizacion : this.model.id
 		});
		for(i in servicios)
		{
			app.coleccionLocalServicios.create(servicios[i].toJSON());
		}
		app.coleccionLocalCotizaciones.create(this.model.toJSON());
		window.open("formatoCotizacion");
	},
	vistaPreviaVersion	: function (e) {
		e.preventDefault();
		var vista = new app.VistaCotizacion({
			model:app.coleccionCotizaciones.get($(e.currentTarget).attr('id'))
		});
		vista.vistaPrevia();
	}
});
var VistaCotizacionEliminada = app.VistaCotizacion.extend({
	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		/*Modificamos la funcion render comentando la siguiente
		  linea, para que las cotizaciones eliminadas no carguen
		  datos innecesarias*/
		// this.obtenerVersiones(); -->Comparar con clase padre
		return this;
	}
});
var VistaSeccion = app.VistaSeccion.extend({
	plantillas : {
		plantillaTrSeccion : _.template($('#td_seccionReal').html())
	},
	render: function (json) {
		/*El parametro id, es la clave del servicio que se está cotizando*/
		this.$el.html( this.plantillas.plantillaTrSeccion(json) );
		/*Establecer el precio en el input escondido para calcular el precio
		  de la sección*/
		this.$('.precio_hora').val($('#precio_hora').val());
		this.calcularSeccion();
		return this;
	},
});

var EdicionCotizacion = app.VistaNuevaCotizacion.extend({
	el : '#section_actualizar',
	
	establecerCotizacion : function() {
		var idcotizacion 	= this.model.get('id'),
			secciones 		= app.coleccionServiciosCotizados
								 .where({
								 	idcotizacion:idcotizacion
								 }),
			idservicio 		= '',
			json 			= {},
			preciohora 		= this.model.get('preciohora'),
			vSeccion,
			folio,
			$select = this.$('#busqueda')[0].selectize;

		
		/*La función render de la clase padre no establece
		el nuevo folio para la nueva versión de la cotización.
		esto es porque la longitud de la colección es mayor
		aquí. Tenemos que realizarlo manualmente.
		También tenemos que estanblecer el folio que viene
		desde le servidor, del array de objetos a la coleccion
		de cotizaciones de Backbone. 
		/*--DESCOMENTAR SI LOS FOLIO DEBEN NUNCA SE REPETIRAN--*/
			/*app.coleccionCotizaciones.folio 
				= app.coleccionDeCotizaciones.folio.folio;
			folio = app.coleccionCotizaciones.establecerFolio();*/
		this.$('#h4_folio')
				.text( 'Folio: '+ this.model.get('folio') )
				.fadeIn('fast');
		this.$('input[name="folio"]').val( this.model.get('folio') );

		this.$('#titulo').val(this.model.get('titulo'));
		$select.setValue(this.model.get('idcliente'));
		this.$('input[name="idcliente"]').val(this.model.get('idcliente'));

		this.$('#detalles')
			.val(this.model.get('detalles'));
		this.$('#caracteristicas')
			.val(this.model.get('caracteristicas'));

		this.$('input[name="descuento"]')
			.val(this.model.get('descuento'));

		for(i in secciones) {
			if (secciones[i].get('idcotizacion') == idcotizacion) {
				if (idservicio != secciones[i].get('idservicio')) {
					idservicio = secciones[i].get('idservicio');
					this.$('#servicio_'+idservicio).click();
					this.$el
						.find('#table_servicio_'+idservicio+' tbody')
						.html('');
				};
				json = secciones[i].toJSON();
				json.preciohora = preciohora;
				vSeccion = new VistaSeccion();
				this.$('#table_servicio_'+idservicio+' tbody')
					.append( vSeccion.render(json).el );

			};
		}
		this.$('#precio_hora')
			.val(preciohora)
			.trigger('change');
	},
	obtenerDatos	: function () {
		// Ocultamos la versión actual
		// debe hacerce antes para no mostrar las
		// dos cotizaciones, actual y nueva versión.
		this.model.cambiarStatus();

		var forms = this.$('.form_servicio'),
			json  = pasarAJson(this.$('#titulo').serializeArray()),
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

		/*preparamos la nueva version antes de devorverla*/
		json.datos.version = parseInt( this.model.get('version') ) +1;
		if (this.model.get('idcotizacion') == '0') {
			json.datos.idcotizacion = this.model.get('id');
		} else {
			json.datos.idcotizacion = this.model.get('idcotizacion');
		};
		
		return json;
	},
	guardado		: function () {
		$('#block').toggleClass('activo');
		alerta('Nueva versión guardada', function () {
			// $('#registroCotizacion')[0].reset();
			// this.$('.span_eliminar_servicio').click();
			// this.render();
			// this.resetearContador();
			location.href = 'cotizaciones_consulta';
		});
	},
	noGuardado	: function () {
		$('#block').toggleClass('activo');
		alerta('La nueva versión ha sido guardada, pero ocurrieron algunos errores<br>Recomendamos que revice la cotización', function () {
			location.href = 'cotizaciones_consulta';
			// this.resetearContador();
		});
	},
	regresarLista : function  () {
		var self = this;
		$('.btn_toggle').on('click', function () {
			// Conmutamos la visibilidad de las
			// secciones
			$('#seccion_cotizaciones').fadeToggle();
			$('#section_actualizar').fadeToggle();
			// Borramos el contenido del formulario
			$('#registroCotizacion').html('');
			// Apagamos el evento clic del botón regresar
			$('.btn_toggle').off('click');
			// Apagamos todos los eventos de la vista
			// edición
			self.$el.off();
		});
	},
});

app.VistaConsultaCotizaciones = Backbone.View.extend({
	el : '#seccion_cotizaciones',

	events : {
	 	'click  #btn_eliminarVarios'  	 : 'eliminarVarios',
		'click #btn_restaurarVarios' : 'restaurarVarios',

        'click  .todos' 		 : 'marcarTodosCheck',

		'click .span_editar'	: 'conmutarSeccion',
	},
	cargar 	: function (model, eliminado) {
		var vista;
		model.set({    
	 		cliente  : app.coleccionClientes. get ({ id : model.get( 'idcliente'  )} ).get('nombreComercial'),
	 		empleado : app.coleccionEmpleados.get ({ id : model.get( 'idempleado' )} ).get('nombre'),
			total    : function () {
				var modelos = app.coleccionServiciosCotizados.where({idcotizacion:model.get('id')}),
					horas = 0,
					total = 0;
				for (var i = 0; i < modelos.length; i++) {
					horas += Number(modelos[i].get('horas'));
				};
				total = horas * Number(model.get('preciohora'));
				total = total - total * Number(model.get('descuento'))/100;
				total = total + total * 0.16;
				total = conComas(total.toFixed(2));
				return total;
			}()
	 	});
		if (eliminado) {
			vista = new VistaCotizacionEliminada({model : model});
		} else {
			vista = new app.VistaCotizacion({model : model});
		};
		vista.plantilla = _.template($('#tds_cotizacion').html());
		this.$tbodyCotizaciones.append( vista.render().el);
	},
	obtenerActivos	: function () {
		this.$tbodyCotizaciones.html('');
		var cotizaciones = app.coleccionCotizaciones.where({
			status	: '1',
			visibilidad: '1'
		});
		this.recursividad(cotizaciones, false);
	},
	obtenerEliminados	: function () {
		this.$tbodyCotizaciones.html('');
		var cotizaciones = app.coleccionCotizaciones.where({
			visibilidad: '0'
		});
		this.recursividad(cotizaciones, true);
	},
	recursividad	: function (objetos, eliminado) {
		/*el parametro objetos es un arreglo de objetos que contiene a
		clientes activos, aliminados así como prospectos.*/
		if (objetos!="null" 
			&& objetos!=null 
			&& objetos!="" 
			&& typeof objetos != "undefined") 
		{
			if (objetos.length) {
				for (var i = 0; i < objetos.length; i++) {
					this.recursividad(objetos[i], eliminado);
				};
			} else {
				this.cargar(objetos, eliminado);
			};
		};
	},
	marcarTodosCheck : function(e) {
		marcarCheck(e, '#'+this.$el.attr('id'));
    },
    eliminarVarios 				: function () {
		var here = this, mensaje, visibilidad, ids;
		/*De los checkboxs con class .todos tomamos el primero (sin importar si hay uno o vareios checheados)
		  Si hay checheados, procedemos*/
		if (this.$('input[name="todos"]:checked').val()) {
			/*Solo con el primer cliente seleccionado nos vasta para saber
			  lo que queremos eliminar (clientes o prospectos).*/
			visibilidad = app.coleccionCotizaciones
							 .get(this.$('input[name="todos"]:checked').val())
							 .toJSON()
							 .visibilidad;
			if ( visibilidad == '1' ) {
				mensaje = '¿Deseas eliminar las cotizaciones seleccionadas?<br><b>Se enviarán a la papelera</b>';
			} else {
				mensaje = '¿Deseas borrar las cotizaciones seleccionadas?<br><b>Toda la información relacionada con las cotizaciones serán borrada</b>';
			};
			confirmar(mensaje,
				function () {
					ids = pasarAJson(here.$('input[name="todos"]:checked').serializeArray()).todos;
					if ( visibilidad == '1' ) { /*Si visibilidad es 1, queremos enviar clientes a la papelera*/
						if ($.isArray(ids)) { /*Si es verdadero, eliminaremos varios clientes*/
							for (var i = 0; i < ids.length; i++) {
								app.coleccionCotizaciones
								   .get(ids[i])
								   .cambiarVisibilidad();
							};
						} else{/*De lo contrario, solo un cliente será eliminado*/
							app.coleccionCotizaciones
							   .get(ids)
							   .cambiarVisibilidad();
						};
					} else{ /*Si la visibilidad no es 1, entonces su valor es 0, el los clientes seran
						      eliminados permanentemente*/
						if ($.isArray(ids)) { /*Si es verdadero, borraremos varios clientes*/
							for (var i = 0; i < ids.length; i++) {
								app.coleccionCotizaciones.get(ids[i]).destroy({
									wait : true,
									success	: function (exito) {
									},
									error	: function (error) {
										error('Error al Borrar a <b>'
												+error.toJSON().titulo+
											'</b>. Intentelo más tarde');
									}
								});
							};
						} else{/*De lo contrario, solo un cliente será borrado*/
							app.coleccionCotizaciones.get(ids).destroy({
								wait : true,
								success	: function (exito) {
								},
								error	: function (error) {
									error('Error al Borrar a <b>'
											+error.toJSON().titulo+
										'</b>. Intentelo más tarde');
								}
							});
						};
							
					};
				},
				function () {});
		};	
	},
	restaurarVarios	: function () {
		if (this.$('input[name="todos"]:checked').val()) { /*Por lo menos un cliente seleccionado*/
			var ids = pasarAJson(this.$('input[name="todos"]:checked').serializeArray()).todos;
			if ($.isArray(ids)) { /*Sol varios clientes ha restaurar*/
				for (var i = 0; i < ids.length; i++) {
					app.coleccionCotizaciones
					   .get(ids[i])
					   .cambiarVisibilidad();
				};
			} else{/*Solo se quiere restaurar un cliente*/
				app.coleccionCotizaciones
				   .get(ids)
				   .cambiarVisibilidad();
			};
		};
	},
	editarCotizacion : function(e) {
		var vista = new EdicionCotizacion({
			model:app.coleccionCotizaciones
					 .get( $(e.currentTarget)
						 .children()
					 .val() )
		});
		vista.establecerCotizacion();
		vista.regresarLista();
	},
	conmutarSeccion	: function (e) {
		var self = this;
		this.editarCotizacion(e);
		$('#seccion_cotizaciones').fadeToggle();
		setTimeout(function() {
			$('#section_actualizar').fadeToggle();
		}, 10);
	},
	cargarPlugin 	: function () {
		var options = {
			widthFixed : true,
			showProcessing: true,
			headerTemplate: '{content} {icon}', // Add icon for jui theme; new in v2.7!

			widgets: [ 'zebra', 'cssStickyHeaders', 'filter' ],

			widgetOptions: {
				filter_columnFilters   : false,
				filter_external : '.search',
				cssStickyHeaders_offset        : 0,
				cssStickyHeaders_addCaption    : true,
				cssStickyHeaders_attachTo      : null,
				cssStickyHeaders_filteredToTop : true,
				cssStickyHeaders_zIndex        : 10
			}

		};
		/* make second table scroll within its wrapper */
		options.widgetOptions.cssStickyHeaders_attachTo = '.wrapper'; // or $('.wrapper')
		this.$("#tabla_principal").tablesorter(options);
	}
});

app.CotizacionesVisibles = app.VistaConsultaCotizaciones.extend({
	initialize : function () {
		// Guardamos el selector. será usado varias veces
		this.$tbodyCotizaciones = this.$('#tbody_cotizaciones');
		this.obtenerActivos();
		var self = this;
		// Cualquier cambio en el status de las cotizaciones
		// provocará que se haga una petición GET de todas
		// las cotizaciones al servidor
		this.listenTo( app.coleccionCotizaciones,
			'change:status',
			function () {
				app.coleccionCotizaciones.fetch({
					reset:true,
					wait:true,
					success: function () {
						// Despues de haber traido
						// todas las cotizaciones,
						// volvemos a cargar todo
						self.obtenerActivos();
					}
				});
			});
		// Utilizamos código de terceros
		this.cargarPlugin();
	}
});
app.CotizacionesEliminadas = app.VistaConsultaCotizaciones.extend({
	initialize : function () {
		// Guardamos el selector. será usado varias veces
		this.$tbodyCotizaciones = this.$('#tbody_cotizaciones');
		this.obtenerEliminados();
		this.cargarPlugin();			
	}
});

