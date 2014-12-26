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

		'click #cancelar'	: 'cancelar',

		/*Eventos de proyecto*/
		'change #busqueda'					: 'obtenerContratos',
		'change #nombreproyecto' 			: 'establecerProyectoBaseContrato',

		'change #fechaEntrega'				: 'calcularDuracion',
		'change #fechaInicio'				: 'calcularEntrega',
		'change #duracion'					: 'calcularEntrega',
		'keyup #duracion'					: 'calcularEntrega',
		'mousewheel #duracion'				: 'calcularEntrega',

		'click #btn_guardarProyecto'		: 'guardar',
		'click #btn_cancelarProyecto'		: 'cancelar',
	},

	initialize				: function () {
		this.listenTo(app.coleccionRoles, 'add', this.residuos);
		this.listenTo(app.coleccionServicios, 'add', this.residuos);

		this.$busqueda			= this.$('#busqueda');
		this.$nombreproyecto 	= this.$('#nombreproyecto');
		this.$hidden_idCliente	= this.$('#hidden_idCliente');

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
	/*OK*/establecerProyectoBaseContrato		: function (e) {
		var idcontrato 	= $(e.currentTarget).val(),
			contrato 	= app.coleccionContratos.get(idcontrato);
			secciones 	= app.coleccionServiciosContrato.where({
				idcontrato:idcontrato
			}),
			idservicio 		= '';

		this.$fechaInicio
			.datepicker( 	"setDate", 
							new Date( contrato.get('fechainicio') ), 
							'd MM, yy' );
		this.$fechaEntrega
			.datepicker( 	"setDate", 
							new Date( contrato.get('fechafinal') ), 
							'd MM, yy' ).trigger('change');

		this.$tbody_servicios_seleccionados.html('');

		// Comentarios en la función 'establecerDatos' la clase,
		// VistaConsultaCotizaciones del archivo con el mismo nombre
		for(i in secciones) {
			if (idservicio != secciones[i].get('idservicio')) {
				idservicio = secciones[i].get('idservicio');
				this.$('#servicio_'+idservicio).click();
				this.$el
					.find('#table_servicio_'+idservicio+' tbody')
					.html('');
			};
			json = secciones[i].toJSON();
			json.preciohora = 'preciohora';
			vSeccion = new VistaSeccion();
			this.$('#table_servicio_'+idservicio+' tbody')
				.append( vSeccion.render(json).el );
		}
		this.calcularTotalHoras(); // Función heredada
	},
	/*OK*/calcularDuracion		: function (elem) {
		var date1 = this.$fechaInicio.datepicker('getDate'),
			date2 = this.$fechaEntrega.datepicker('getDate');
		this.$('input[name="fechainicio"]').val( formatearFechaDB(date1) );
		this.$('input[name="fechafinal"]').val( formatearFechaDB(date2) );
		this.$duracion.val(calcularDuracion( date1,date2 ).plazo);
	},
	/*OK*/calcularEntrega 		: function (e) {
		// obtenemos los días establecido por el usuario,
		// obtenemos la fecha de inicio del proyecto y: valor,
		// calculamos la fecha de entrega: valor (la cual no es real).
		// por utimo preparamos una variable que contendrá
		// tendra la verdadera fecha
		var dias = parseInt( this.$(e.currentTarget).val() ),
			valorFechaInicio = this.$fechaInicio.datepicker('getDate').valueOf(),
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
		this.$fechaEntrega.datepicker( "setDate", fechaEntrega, 'd MM, yy' );
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
				location.href = 'proyectos_consulta';
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
					} else {
						if (_.isArray(json_participantes[i].idrol)) {
							json_participantes[i].idrol = json_participantes[i].idrol.join(',');
						};
					};
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
		console.log(app.totalelementos);
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

app.VistaArchivos = Backbone.View.extend({
	el:'#paso4',
	plantillaArchivo		: _.template($('#tr_archivo').html()),
	events 					: {
		'change #inputArchivos'				: 'cargar',
		'click #btn_subirArchivo'			: 'subirArchivo',
		'click #inputArchivos'				: 'eliminarFileList',
		'click #btn_cancelarArchivo'		: 'cancelarArchivos',
	},
	initialize 				: function () {
		this.listenTo(app.coleccionProyectos, 'add', this.guardar);
		// this.listenTo(app.coleccionProyectos, 'destroy', this.eliminarArchivos);

		this.$inputArchivos			= this.$('#inputArchivos');
		this.$tbody					= this.$('tbody');
		this.$propietarioArchivo 	= this.$('#idpropietario');
		this.$tablaProyecto 		= this.$('#tabla');
	},
	render 					: function () { },
	cargar					: function (e) {
		this.$tbody.html('');
		var archivos = $(e.currentTarget).prop('files');
		for (var i = 0; i < archivos.length; i++) {
			this.$tbody.append( this.plantillaArchivo( {i:i, tipo:(archivos[i].type).split('/')[1], nombre:archivos[i].name, tamaño:(archivos[i].size/1024).toFixed() +' KB'} ) );
		};
	},
	/*OK*/guardar 			: function (model) {
		// obtenemos todos los archivos,
		// obtenemos el id del proyecto creado recientemente,
		// preparamos una variable para los objetos formData,
		// y respaldamos this para acceder a las func. y var.
		var archivos = this.$inputArchivos.prop('files'),
			idpropietario = model.get('id'),
			formData,
			tabla,
			self = this;

		tabla = this.establecerTabla(model);

		// verificamos si hay archivos listados para el proy.
		if (archivos.length) {
			// (!) tememos que preparar una variable para indicar,
			// el estado de los achivos (en espera, guardado y no,
			// guardado). classTr es la fila del archivo en la tabla
			self.classTr =  archivos.length - 1;
			for (var i = 0; i < archivos.length; i++) {
				// colocamos un spin en la fila del archivo para indicar 
				// que el archivo esta siendo procesado
				this.$tbody.children('.'+i).children('.icon-eliminar').html('<div class="spin"><div>');
				// creamos un objeto FormData por cada uno de los archivos
				// que serán enviados y añadimos las propiedades que
				// acompañara el archivo en turno
				formData = new FormData();
				formData.append('idpropietario',idpropietario);
				formData.append('tabla',tabla);
				formData.append('archivo[]',archivos[i]);
				// enviamos la info a la api de archivos
				$.ajax({
		            url: 'http://crmqualium.com/api_archivos',
		            type: 'POST',
		            async:true,
		            data: formData,
		            //necesario para subir archivos via ajax
		            cache: false,
		            contentType: false,
		            processData: false,
		            success: function (exito) {
		            	app.coleccionArchivos.add(exito);
		            	self.$tbody.children('.'+self.classTr).addClass('success');
		            	self.$tbody.children('.'+self.classTr).children('.icon-eliminar').html('<div class="has-success"><span class="glyphicon glyphicon-ok form-control-feedback"></span></div>');
		   				self.classTr--;
		   				self.guardado();
		            },
		            error  : function (error) {
		            	self.$tbody.children('.'+self.classTr).addClass('danger');
		            	self.$tbody.children('.'+self.classTr).children('.icon-eliminar').html('<div class="has-error"><span class="glyphicon glyphicon-remove form-control-feedback"></span></div>');
		   				self.classTr--;
		   				self.noGuardada();
		            }
		        });
			};
		} else { 
			console.log('No hay archivos para enviar');
		};
	},
	guardado				: function () {	/*-tambien en VProyecto-*/
		if (this.aumentarContador() == app.totalelementos) {
			var self = this;
			$('#block').toggleClass('activo');
			alerta('¡Proyecto guardado!', function () { });
		};
	},
	noGuardada				: function () {	/*-tambien en VProyecto-*/
		if (this.aumentarContador() == app.totalelementos) {
			$('#block').toggleClass('activo');
			alerta('El proyecto ha sido guardado, pero ocurrieron algunos errores<br>Revice el proyecto en la sección de consulta', function () {
				location.href = 'proyectos_consulta';
			});
		};
	},
	aumentarContador 	: function() {		/*-tambien en VProyecto-*/
		return app.contadorAlerta++;
	},
	/*OK*/establecerTabla 	: function (model) {
		var tabla,
			url = model.url();
		console.log(url);
		url = url.split('/');
		url.pop();
		url = url.join('/');
		switch( url ){
			case 'http://crmqualium.com/api_proyectos':
				tabla = 'proyectos';
				break;
			default:
				tabla = '';
				break;
		}

		return tabla;
	},
	eliminarFileItemList	: function () {/*[!]*/},
	/*OK*/cancelarArchivos	: function () {
		var here = this;
		confirmar('Los archivos a subir seran cancelados',
			function () {
				here.$inputArchivos.val('');
				here.$tbody.html('');
			},
			function () {});
	},
	/*OK*/eliminarArchivos 	: function (model) {
		var idpropietario = model.get('id'),
			tabla 		  = this.establecerTabla(model);

		app.coleccionArchivos.each(function (model) {
			if (model.get('idpropietario') == idpropietario &&
				model.get('tabla') == tabla
			) {
				model.destroy({
					wait 	: true,
					success : function () {},
					error   : function () {}
				});
			};
		});
	}
});