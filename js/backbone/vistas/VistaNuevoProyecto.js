var app = app || {};

var VistaSeccion = app.VistaSeccion.extend({
	plantillas : {
		plantillaTrSeccion : _.template($('#td_seccionReal').html())
	},
	render: function (json) {
		this.$el.html( this.plantillas.plantillaTrSeccion(json) );
		return this;
	},
});

/*Modificando las clases originales*/
	app.VistaCotizarServicio.prototype.apilarSeccion = function(){
		var vistaSeccion = new app.VistaSeccion();

		if ( this.model.get('nuevo') ) {
			this.$('tbody').append( vistaSeccion.render(this.model.get('nombre')).el );
		} else{
			this.$('tbody').append( vistaSeccion.render(this.model.get('id')).el );	
		};
		setTimeout(function() {
			app.vistaNuevoProyecto.calcularTotalHoras();
		}, 10);
	};
	app.VistaCotizarServicio.prototype.eliminarSeccion = function (e) {
		this.$(e.currentTarget).parent().parent().remove();
		setTimeout(function() {
			app.vistaNuevoProyecto.calcularTotalHoras();
		}, 10);
	};

app.VistaNuevoProyecto = app.VistaNuevaCotizacion.extend({
	el						: '.contenedor_principal_modulos',

	plantillaServicio 		: _.template($('#tds_servicio').html()),

	events	: {
		/*Eventos de cotizacion*/
		'click 	   #guardar'	   	: 'guardar',
		'click     .todos'	     	: 'marcarTodosCheck',
		'click     #vista-previa' 	: 'vistaPrevia',

		'click .span_deleteAll'	 		: 'eliminarServicios',
		'click .span_eliminar_servicio' : 'eliminarServicio',
		'click .span_toggleAllSee'	 	: 'conmutarServicios',

		'change .btn_plan'			: 'conmutarTablaPlan',

		'click #cancelar'	: 'cancelar',

		/*Eventos de proyecto*/
		'change #busqueda'					: 'obtenerContratos',
		'change #nombreproyecto' 			: 'establecerDatos',

		'change #fechaEntrega'				: 'calcularDuracion',
		'change #fechaInicio'				: 'calcularEntrega',
		'change #duracion'					: 'calcularEntrega',
		'keyup #duracion'					: 'calcularEntrega',
		'mousewheel #duracion'				: 'calcularEntrega',

		'click #btn_guardarProyecto'		: 'guardar',
		'click #btn_cancelarProyecto'		: 'cancelar',
	},

	initialize				: function () {
		this.html = this.$el.html();

		this.listenTo(app.coleccionRoles, 'add', this.residuos);
		this.listenTo(app.coleccionServicios, 'add', this.residuos);

		this.$busqueda			= this.$('#busqueda');
		this.$nombreproyecto 	= this.$('#nombreproyecto');
		this.$hidden_idcontrato = this.$('#hidden-idcontrato')

		this.$tbody_empleados 	= this.$('#tbody_empleados');
		this.$tbody_servicios 	= this.$('#tbody_servicios');
		this.$tbody_servicios_seleccionados = this.$('#tbody_servicios_seleccionados');
		this.$fechaInicio       = this.$('#fechaInicio');
		this.cargarServicios();

		this.$formNuevoProyecto = this.$('#formNuevoProyecto');

		this.btn_marcarTodos	= this.$('.btn_marcarTodos')[0];

		this.$fechaEntrega      = this.$('#fechaEntrega');
		this.$duracion          = this.$('#duracion');

		// this.$fecha_creacion	= this.$('#fecha_creacion');
		
		this.$inputArchivos		= this.$('#inputArchivos');

		this.cargarEmpleados();		
		this.cargarPlugins();

		this.array = new Array();
		this.arrayResiduos = [];
		app.contadorAlerta = 1;
		app.totalelementos = 0;

		
	},
	render					: function () {
		return this;
	},
	/*OK*/cargarServicio		: function (servicio) {
		var vistaTrServ = new app.VistaTrServ({ model:servicio });
		this.$tbody_servicios.append( vistaTrServ.render().el );
	},
	/*OK*/cargarServicios		: function () {
		this.$tbody_servicios.html('');
		app.coleccionServicios.each( this.cargarServicio, this );
	},
	/*OK*/eliminarServicio 		: function (e) {
		// Comentario en la clase VistaNuevaCotizacion
		this.$(
			'#table_servicios #'
			+this.$(e.currentTarget)
			.attr('id')
		)
		.attr('disabled',false)
		.attr('checked',false)
		.parents('tr')
		.css('color','#333');
		this.$(e.currentTarget).parents('.td_servicio').remove();
	},
	/*OK*/cargarEmpleado		: function (empleado) {
		/*añadimos una nueva propiedad al modelo de empledo para
		tener en cada formulario rol el id del proyecto, de esta 
		manera es más facil enviar los roles a la api de roles de 
		proyecto*/
		// empleado.set({idproyecto:this.idProyecto});
		var vistaEmpleado = new app.VistaEmpleado({ model:empleado });
		this.$tbody_empleados.append( vistaEmpleado.render().el );
	},
	/*OK*/cargarEmpleados		: function () {
		app.coleccionEmpleados.each( this.cargarEmpleado, this );
	},
	/*OK*/obtenerContratos 		: function (e) {
		var control = this.$nombreproyecto[0].selectize;
		control.clearOptions();
		var contratos =  _.where(app.coleccionContratos.toJSON() ,{
			idcliente : $(e.currentTarget).val()
		});
		control.addOption(function () {
			var array = [];
			for (var i = 0; i < contratos.length; i++) {
				array.push({
					id      : contratos[i].id,
					title   : contratos[i].serviciosolicitado
				});
			};
			return array;
		}() );
	},
	/*OK*/establecerDatos		: function (e) {
		// Antes veficicamos que las operaciones
		// prosigan si tenemos valor, si no
		// terminamos la secuencia
		if ($(e.currentTarget).val() == '') {
			this.$hidden_idcontrato.val('');
			e.preventDefault();
			return;
		};
		
		var idcontrato 	= $(e.currentTarget).val(),
			arrayServicios	= function () {
				// Comentario en la clase VistaNuevaCotizacion
				var jsonSecciones = _.where(app.coleccionServiciosContrato.toJSON(),{
					idcontrato:idcontrato
				});
				var groposServicios = _.groupBy(jsonSecciones,'idservicio');
				return _.values(groposServicios);
			}(),
			contrato 	= app.coleccionContratos.get(idcontrato);
			secciones 	= app.coleccionServiciosContrato.where({
				idcontrato:idcontrato
			}),
			idservicio 		= '';

		this.$fechaInicio
			.datepicker( 	"setDate", 
							new Date( fechaEstandar( contrato.get('fechainicio') ) ),
							'd MM, yy' );
		this.$fechaEntrega
			.datepicker( 	"setDate", 
							new Date( fechaEstandar( contrato.get('fechafinal') ) ),
							'd MM, yy' ).trigger('change');

		this.$duracion.trigger('change');

		this.$('input[value="'+contrato.get('plan')+'"]').click();

		this.$tbody_servicios_seleccionados.find('.span_eliminar_servicio').click();

		// Comentarios en la función 'establecerDatos' la clase,
		// VistaConsultaCotizaciones del archivo con el mismo nombre
		for(i in arrayServicios) {
			// En primer lugar tenemos que apilar el servicio en
			// la tabla de servicios y borrar las secciones que
			// apila automaticamente.
			idservicio = arrayServicios[i][0].idservicio;
			this.$('#servicio_'+idservicio).click();
			this.$el.find('#table_servicio_'+idservicio+' tbody').html('');
			// Apilamos las secciones del servicio en turno y que son propios
			// de la cotizacion a editar.
			for(j in arrayServicios[i]){
				vSeccion = new VistaSeccion();
				this.$('#table_servicio_'+idservicio+' tbody')
					.append( vSeccion.render(arrayServicios[i][j]).el );
			}
		}


		this.calcularTotalHoras(); // Función heredada

		this.$hidden_idcontrato.val(idcontrato);
	},
	/*OK*/calcularDuracion		: function (elem) {
		var date1 = this.$fechaInicio.datepicker('getDate'),
			date2 = this.$fechaEntrega.datepicker('getDate');
		this.$('input[name="fechainicio"]').val( formatearFechaDB(date1) );
		this.$('input[name="fechafinal"]').val( formatearFechaDB(date2) );
		this.$duracion.val(calcularDuracion( date1,date2 ).plazo);
	},
	/*OK*/calcularEntrega 		: function (e) {
		var self = this;

		var calcular = function (num) {
			// obtenemos los días establecido por el usuario,
			// obtenemos la fecha de inicio del proyecto y: valor,
			// calculamos la fecha de entrega: valor (la cual no es real).
			// por utimo preparamos una variable que contendrá
			// tendra la verdadera fecha
			var dias = parseInt( num ),
				valorFechaInicio = function (fechaInicio){
					if ( fechaInicio.val() != '' ) {
						return fechaInicio.datepicker('getDate').valueOf();
					} else{
						var date = new Date();
						fechaInicio.datepicker( 'setDate', date );
						self.$('input[name="fechainicio"]').val(formatearFechaDB(date));
						return date.valueOf();
					};
				}(self.$fechaInicio),
				valorFechaEntrega = valorFechaInicio + ( dias*24*60*60*1000 ),
				fechaEntrega;

			// necesitamos el valor de la fecha de entrga, para eso,
			// creamos un objeto Date y obtenemos el valor mediante valueOf()
			fechaEntrega = new Date(new Date(valorFechaEntrega).valueOf());
			// la función excluirDias obtiene el numero de días sábados y
			// domingos del rango de fechas que se pasan como parametro
			var nsabadosYdomingos = excluirDias(valorFechaInicio, fechaEntrega);
			// Necesariamente necesitamos saber si los días que el usuario
			// establece es un número mayor que 10, esto se hace para
			// establecer correctamente la fecha en que terminará el proyecto
			if ( dias > 10) {
				fechaEntrega = new Date(fechaEntrega.valueOf() + ( (nsabadosYdomingos +1)*24*60*60*1000 ));
			} else {
				fechaEntrega = new Date(fechaEntrega.valueOf() + ( (nsabadosYdomingos -1)*24*60*60*1000 ));
			};
			// usamos la funcion datepicker de jQueryUI para establecer la fecha
			// correcta para el termino del proyecto.
			self.$fechaEntrega.datepicker( "setDate", fechaEntrega, 'd MM, yy' );
			self.$('input[name="fechafinal"]').val( formatearFechaDB(fechaEntrega) );
		};

		if ( e.type === 'mousewheel' ) {
			if ( $(e.currentTarget).val() == '' ) {
				$(e.currentTarget).val('1').trigger('change');
				e.preventDefault();
			} else {
				if (e.originalEvent.wheelDeltaY < 0) {
					calcular( parseInt($(e.currentTarget).val()) -1 );
				} else {
					calcular( parseInt($(e.currentTarget).val()) +1 );
				};	
			};
		} else {
			calcular( parseInt($(e.currentTarget).val()) );
		};
	},
	/*OK*/eliminarServicios 	: function () {
		var spans = this.$('input[name="todos"]:checked');
		if (spans.length) {
			var here = this;
			confirmar('¿Estás seguro de eliminar los servicios?',
				function () {
					for (var i = 0; i < spans.length; i++) {
						here.$('.iconos-operaciones #'+$(spans[i]).attr('id').split('/')[0]).click();
					};
				},
				function () {});
		};
	},
	/*OK*/guardar				: function (elem) {
		var json = this.obtenerDatos(),
			self = this;
			// console.log(json);return;
		// si ha fallado la recolección de datos
		// rompemos la secuencia de esta funcion
		if (!json) { return; };

		$('#block').toggleClass('activo');

		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		app.coleccionProyectos.create(json.proyecto,{
			wait:true,
			success : function (model) {
				self.guardarSeccion(model.get('id'), json.secciones);
				self.guardarParticipante(model.get('id'), json.participantes);
				// Los ARCHIVOS se guardan automaticamente despues que el
				// proyecto es guardado. Hay un listener en la clase VistaArchivos
				self.guardado();
			},
			error 	: function () {
				alerta('Ocurrio un error al intentar guardar el proyecto',function () {});
				// solo en el caso de que el proyecto no sea guardado 
				// igualamos las variables que hacen que se quite el 
				// bloqueo en la pantalla
				app.contadorAlerta = app.totalelementos;
				self.noGuardada();
			}
		});
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	},
	guardado			: function () {	/*-tambien en VArchivo-*/
		if (this.aumentarContador() == app.totalelementos) {
			var self = this;
			$('#block').toggleClass('activo');
			alerta('¡Proyecto guardado!', function () {
				confirmar('¿Deseas crear otro proyecto?', function (){
					// self.$el.html('');
					self.$el.html(self.html);
					// setTimeout(function() {
						self.initialize();
					// }, 1000);
				},function (){
					location.href = 'proyectos_consulta';
				});
			});
		};
	},
	noGuardada			: function () {	/*-tambien en VArchivo-*/
		if (this.aumentarContador() == app.totalelementos) {
			$('#block').toggleClass('activo');
			alerta('El proyecto ha sido guardado, pero ocurrieron algunos errores<br>Revice el proyecto en la sección de consulta', function () {
				location.href = 'proyectos_consulta';
			});
		};
	},
	aumentarContador 	: function() {	/*-tambien en VArchivo-*/
		return app.contadorAlerta++;
	},
	/*OK*/guardarSeccion		: function (idproyecto, secciones) {
		var self = this;
		for (var i = 0; i < secciones.length; i++) {
			secciones[i].idproyecto = idproyecto;
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionServiciosProyecto.create(secciones[i], {
				wait	: true,
				success	: function (model) {
					self.guardado();
				},
				error	: function (model) {
					self.noGuardada();
				}
			});
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		};
	},
	/*OK*/guardarParticipante	: function (idproyecto, participantes) {
		var self = this;
		for (var i = 0; i < participantes.length; i++) {
			participantes[i].idproyecto = idproyecto;
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionRolesProyectos.create(participantes[i], {
				wait	: true,
				success	: function (model) {
					self.guardado();
				},
				error	: function (model) {
					self.noGuardada();
				}
			});
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		};
	},
	/*OK*/obtenerDatos 			: function () {
		// validar paso 1
			var json_basicos = pasarAJson( this.$('#formDatosBasicos').serializeArray() );
			// validar que los datos existen
			if (json_basicos.idcliente	== '' ||
				json_basicos.nombre		== '' ||
				json_basicos.fechainicio== '' ||
				json_basicos.fechafinal	== '' /*||
				json_basicos.descripcion== '' //Descomentar si requiere descripción*/
			) {
				alerta('Todos los <b>datos básicos</b> son obligatorios', function () {});
				return false;
			}
		// validar paso 2
			var forms_secciones = this.$('.form_servicio');
			// validar si temenos servicios seleccionados
			if (!forms_secciones.length) {
				alerta('Seleccione <b>servicios</b> para integrar el proyecto', function () {});
				return false;
			};
		// validar paso 3
			var forms_participantes = this.$('.form_participante');
			// validar si tenemos empleados seleccionados
			if (!forms_participantes.length) {
				alerta('Seleccione <b>empleados y sus roles</b> respectivamente', function () {});
				return false;
			};

		var json = {
			proyecto 		: '',
			secciones 		: '',
			participantes 	: ''
		}

		// <SECCION> PASO 1
			// si es un proyecto de un contrato, buscamo el el contrato
			// por medio de su id que está en json_basicos.nombre luego 
			// reescribimos la propiedad anterior con el nombre del contrato
			// si no es un proyecto de un contrato no reescribimos la
			// propiedad mencionada antes
			var contrato = app.coleccionContratos.get(json_basicos.nombre);
			if ( !_.isUndefined(contrato) ) {
				json_basicos.nombre = contrato.get('serviciosolicitado');
			};
			json.proyecto = json_basicos;
		// <SECCION> PASO 2
			var json_secciones = [];
			for (var i = 0; i < forms_secciones.length; i++) {
				json_secciones.push( pasarAJson( $(forms_secciones[i]).serializeArray() ) );
			};
			json.secciones = json_secciones;
		// <SECCION> PASO 3
			var json_participantes = [];
			for (var i = 0; i < forms_participantes.length; i++) {
				json_participantes.push( pasarAJson( $(forms_participantes[i]).serializeArray() ) );
			};

			var validarRolPorEmpleado = function () {

				var sinrol = false;
				for (var i = 0; i < json_participantes.length; i++) {
					if ( _.isUndefined(json_participantes[i].idrol) ) {
						sinrol = true;
						break;
					}/* else {
						if (_.isArray(json_participantes[i].idrol)) {
							json_participantes[i].idrol = json_participantes[i].idrol.join(',');
						};
					}*/;
				};
				return sinrol;
			};

			if (validarRolPorEmpleado()) {
				alerta('Establesca <b>roles</b> a los empleados',function () {});
				return false;
			};

			json.participantes = json_participantes;
		// <SECCION> PASO 4
			
		app.totalelementos 	=	1 +
								json_secciones.length +
								json_participantes.length +
								this.$inputArchivos.prop('files').length;
		return json;
	},
	cancelar	: function () {
		var self = this;
		confirmar('¿Esta seguro de cancelar este poyecto?', 
			function () {
				if (self.arrayResiduos.length) {
					var contador = 1;
					var terminamos = function () {
						if ( self.arrayResiduos.length == contador ) {
							$('#block').toggleClass('activo');
							location.href = 'proyectos_consulta';
						} else {
							contador++;
						};
					};
					confirmar('¿Deseas conservar los servicios y roles agregados?',function () {
						location.href = 'proyectos_consulta';
					}, function () {
						$('#block').toggleClass('activo');
						for (var i = 0; i < self.arrayResiduos.length; i++) {
							self.arrayResiduos[i].destroy({
								wait 	: true,
								success : function () {
									terminamos();
								},
								error 	: function () {
									terminamos();
								}
							});
						};
					});
				} else {
					location.href = 'proyectos_consulta';
				};
			},
			function () { });
	},
	/*-------------*/
	residuos	: function (model) {
		this.arrayResiduos.push(model);
	},
	/*OK*/cargarPlugins			: function () {
		self = this;
		loadSelectize_Client('#busqueda',{
			valueField  : 'id',
			labelField  : 'title',
			searchField : 'title',
			maxItems    : 1,
			create      : false
		},app.coleccionClientes.toJSON());

		this.$nombreproyecto.selectize({
			valueField  : 'id',
			labelField  : 'title',
			searchField : 'title',
			maxItems    : 1,
			create      : true
		});

		loadDatepickerRange('#fechaInicio','#fechaEntrega');

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
		
		this.$('#table_empleados').tablesorter({
			theme: 'blue',
			widgets: ["zebra", "filter"],
			widgetOptions : {
			  filter_external : '.search-employees',
			  filter_columnFilters: false,
			  filter_saveFilters : true,
			  filter_reset: '.reset'
			}
		});
	},
});

app.VistaTablaRoles = Backbone.View.extend({
	el : '#tbla_roles',
	events : {
		'click .eliminarParticipacion' 		: 'eliminarParticipante',
		'click .eliminarVarios' : 'eliminarParticipantes',
		'click     .todos'	     	: 'marcarTodosCheck',
	},

	eliminarParticipante	: function (e) {

		/*Antes de eliminar la vista buscamos el servicio correspondiente en la lista de servicios*/
		$(
			'#table_empleados #'
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
		$(e.currentTarget).parents('.tr-participante').remove();
	},
	eliminarParticipantes 	: function () {
		var spans = this.$('input[name="todos"]:checked'); /*Obtenemos todos los checkbox activados*/
		if (spans.length) { /*Solo si hay servicios marcados*/
			var here = this;
			confirmar('¿Está seguro de eliminar a los empleados y sus roles?',
				function () {
					for (var i = 0; i < spans.length; i++) {
						/*Hacemos clic en los span correspondientes a los trs checkeados.
						  la vista de cada tr recibirá el evento clic y ejecutará la 
						  funcion correspondiente*/
						here.$('.icon-eliminar #'+$(spans[i]).attr('id').split('/')[0]).click();
					};
				},
				function () {});
		};
		// this.$('.span_eliminar_servicio').click();
	},
	marcarTodosCheck 		: function(e) {        
			marcarCheck(e, '#tbody_empleados_seleccionados');
	},
});

app.VArchivos = app.VistaArchivos.extend({
	el:'#paso4',
	plantillaArchivo		: _.template($('#tr_archivo').html())
})
