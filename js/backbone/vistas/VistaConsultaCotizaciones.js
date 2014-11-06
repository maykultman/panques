var app = app || {};

app.VistaCotizacion = Backbone.View.extend({
	tagName : 'tr',
	plantilla : _.template($('#tds_Cotizacion').html()),
	events : {
		'click .span_papelera' 			: 'cambiarVisibilidad',
		'click .span_restaurar' 		: 'cambiarVisibilidad',
		'click .span_borrar' 			: 'eliminarPermanente',
		'click .icon-uniF5E2' 			: 'pasarAContrato',
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
	pasarAContrato : function()
	{
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
		  linea, para que las cotizaciones eliminadas co carguen,
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
			$select = this.$('#busqueda')[0].selectize;

		this.obtenerFolio();

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
		/*Ocultamos la versión actual*/
		this.model.cambiarStatus();

		var forms = this.$('.form_servicio'),
			json  = pasarAJson(this.$('#titulo, #busqueda, #idrepresentante')
								    .serializeArray()),
			f = new Date();
		/*Cortafuego para forzar establecer los siguientes datos*/
		if (
				json.titulo == '' 
			|| 	json.idcliente == '' 
			|| 	json.idrepresentante == ''
		) {
			alerta('Escriba un <b>título</b> para la cotización y seleccione un <b>cliente</b>', function () {});
			return false; // Terminamos el flujo del código
		};

		json = {
			secciones : [], datos : ''
		};
		// Datos básicos
			json.datos = pasarAJson(this.$('#registroCotizacion').serializeArray());
			json.datos
				.fecha = f.getFullYear() + "-" + 
						(f.getMonth() +1) + "-" + 
						(f.getDate() +1);
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

		/*preparamos la nueva antes de devorverla*/
		json.datos.version = parseInt( this.model.get('version') ) +1;
		if (this.model.get('idcotizacion') == '0') {
			json.datos.idcotizacion = this.model.get('id');
		} else {
			json.datos.idcotizacion = this.model.get('idcotizacion');
		};
		
		return json;
	},
	cotizacionGuardada		: function () {
		$('input,select,button,textarea').attr('disabled',false);
		alerta('Nueva versión guardada', function () {
			// $('#registroCotizacion')[0].reset();
			// this.$('.span_eliminar_servicio').click();
			// this.render();
			// this.resetearContador();
			location.href = 'cotizaciones_consulta';
		});
	},
	cotizacionNoGuardada	: function () {
		$('input,select,button,textarea').attr('disabled',false);
		alerta('La nueva versión ha sido guardada, pero ocurrieron algunos errores<br>Recomendamos que revice la cotización', function () {
			location.href = 'cotizaciones_consulta';
			// this.resetearContador();
		});
	}
});

app.VistaConsultaCotizaciones = Backbone.View.extend({
	el : '.contenedor_principal_modulos',

	events : {
	 	'click  #btn_eliminarVarios'  	 : 'eliminarVarios',
		'click #btn_restaurarVarios' : 'restaurarVarios',

        'click  #todos' 		 : 'marcarTodosCheck',

		'click .span_editar'	: 'conmutarSeccion',
		'click .btn_toggle'	: 'regresar',
	},
	regresar : function  () {
		var self = this;
		_.extend(this.$('.btn_toggle'), Backbone.Events);
		this.$('.btn_toggle').on('regresar', function () {
			self.$('#seccion_cotizaciones').fadeToggle();
			self.$('#section_actualizar').fadeToggle();
			self.$('#registroCotizacion').html('');
		});
		this.$('.btn_toggle').trigger('regresar');
		this.$('.btn_toggle').off('regresar');
	},
	cargarCotizacion 	: function (model, eliminado) {
		model.set({    
	 		cliente  : app.coleccionClientes. get ({ id : model.get( 'idcliente'  )} ).get('nombreComercial'),
	 		empleado : app.coleccionEmpleados.get ({ id : model.get( 'idempleado' )} ).get('nombre'),
			total    : function () {
				var modelos = app.coleccionServiciosCotizados.where({idcotizacion:model.get('id')}),
					horas = 0,
					total = 0,
					vista;
				for (var i = 0; i < modelos.length; i++) {
					horas += Number(modelos[i].get('horas'));
				};
				total = horas * Number(model.get('preciohora'));
				total = total - total * Number(model.get('descuento'))/100;
				total = total + total * 0.16;
				total = '' + total.toFixed(2);
				total = total.split('.');
				decimales = total[1];
				total = conComas(total[0].split(''));
				return total+'.'+decimales;
			}()
	 	});
		if (eliminado) {
			vista = new VistaCotizacionEliminada({model : model});
		} else {
			vista = new app.VistaCotizacion({model : model});
		};
		
		this.$tbodyCotizaciones.append( vista.render().el);
	},
	obtenerActivos	: function () {
		this.$tbodyCotizaciones.html('');
		var cotizaciones = app.coleccionCotizaciones.where({
			status	: '1',
			visibilidad: '1'
		});
		this.recursividadCotizaciones(cotizaciones, false);
	},
	obtenerEliminados	: function () {
		this.$tbodyCotizaciones.html('');
		var cotizaciones = app.coleccionCotizaciones.where({
			visibilidad: '0'
		});
		this.recursividadCotizaciones(cotizaciones, true);
	},
	recursividadCotizaciones	: function (cotizaciones, eliminado) {
		/*el parametro cotizaciones es un arreglo de objetos que contiene a
		clientes activos, aliminados así como prospectos.*/
		if (cotizaciones!="null" 
			&& cotizaciones!=null 
			&& cotizaciones!="" 
			&& typeof cotizaciones != "undefined") 
		{
			if (cotizaciones.length) {
				for (var i = 0; i < cotizaciones.length; i++) {
					this.recursividadCotizaciones(cotizaciones[i], eliminado);
				};
			} else {
				this.cargarCotizacion(cotizaciones, eliminado);
			};
		};
	},
	/*?*/ordenarporfecha : function(fecha) {	
		app.coleccionCotizaciones.reset( app.coleccionCotizaciones.toJSON().reverse() );
		ordenar(fecha);
	},
	/*?*/busqueda : function(elemento) {
		autocompleteGenerico(elemento, this, app.coleccionCotizaciones, this.$tbodyCotizaciones);
	},	
    /*?*/borrayRenderiza	: function (e) {
		if(e.keyCode===8)
        {
        	this.cargarCotizaciones();
        }
	},
	marcarTodosCheck : function(elemento) {
		marcarCheck(elemento);
    },
    eliminarVarios 				: function () {
		var here = this, mensaje, visibilidad, ids;
		/*De los checkboxs con class .todos tomamos el primero (sin importar si hay uno o vareios checheados)
		  Si hay checheados, procedemos*/
		if (this.$('.todos:checked').val()) {
			/*Solo con el primer cliente seleccionado nos vasta para saber
			  lo que queremos eliminar (clientes o prospectos).*/
			visibilidad = app.coleccionCotizaciones
							 .get(this.$('.todos:checked').val())
							 .toJSON()
							 .visibilidad;
			if ( visibilidad == '1' ) {
				mensaje = '¿Deseas eliminar las cotizaciones seleccionadas?<br><b>Se enviarán a la papelera</b>';
			} else {
				mensaje = '¿Deseas borrar las cotizaciones seleccionadas?<br><b>Toda la información relacionada con las cotizaciones serán borrada</b>';
			};
			confirmar(mensaje,
				function () {
					ids = pasarAJson(here.$('.todos:checked').serializeArray()).todos;
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
		if (this.$('.todos:checked').val()) { /*Por lo menos un cliente seleccionado*/
			var ids = pasarAJson(this.$('.todos:checked').serializeArray()).todos;
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
		app.vista = new EdicionCotizacion({
			model:app.coleccionCotizaciones
					 .get( $(e.currentTarget)
						 .children()
					 .val() )
		});
		app.vista.establecerCotizacion();
	},
	conmutarSeccion	: function (e) {
		var self = this;
		this.editarCotizacion(e);
		this.$('#seccion_cotizaciones').fadeToggle();
		setTimeout(function() {
			self.$('#section_actualizar').fadeToggle();
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
		this.$("#tabla_cotizaciones").tablesorter(options);
	}
});

app.CotizacionesVisibles = app.VistaConsultaCotizaciones.extend({
	initialize : function () {
		this.$tbodyCotizaciones = this.$('#tbody_cotizaciones');
		this.obtenerActivos();
		var self = this;
		this.listenTo( app.coleccionCotizaciones,
			'change:status',
		function (ef) {
			app.coleccionCotizaciones.fetch({
				reset:true,
				wait:true,
				success: function () {
					self.obtenerActivos();
				}
			});
		});
		this.$('#seccion_cotizaciones').show();
		this.$('#section_actualizar').hide();

		this.cargarPlugin();
	}
});
app.CotizacionesEliminadas = app.VistaConsultaCotizaciones.extend({
	initialize : function () {
		this.$tbodyCotizaciones = this.$('#tbody_cotizaciones');
		this.obtenerEliminados();

		this.cargarPlugin();			
	}
});

