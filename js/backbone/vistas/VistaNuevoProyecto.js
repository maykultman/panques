var app = app || {};
/* {{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}} */
app.VistaServicioProyecto = app.TrServicio.extend({
	tagName	: 'tr',
	plantillaDefault	: _.template($('#tds_servicio').html()),
	events  : {
    'click .checkbox_servicio'  : 'apilarServicio',
  },
});
/* {{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}} */

app.VistaNuevoProyecto = Backbone.View.extend({
	el					: '.contenedor_principal_modulos',

	plantillaServicio 	: _.template($('#tds_servicio').html()),
	plantillaArchivo	: _.template($('#tr_archivo').html()),

	events	: {
		'click .eliminarDeTabla_servicios'	: 'eliminarDeTabla',
		'click .eliminarDeTabla_empleados'	: 'eliminarDeTabla',
		'click .btn_eliminarMarcados'		: 'eliminarMarcados',

		'change #fechaEntrega'				: 'calcularDuracion',
		'change #fechaInicio'				: 'calcularEntrega',
		'change #duracion'					: 'calcularEntrega',
		'keyup #duracion'					: 'calcularEntrega',
		'mousewheel #duracion'				: 'calcularEntrega',

		'click #btn_guardarProyecto'		: 'guardarProyecto',
		'click #btn_cancelarProyecto'		: 'cancelarProyecto',

		'change .btn_marcarTodos'			: 'marcarTodos',

		'click #btn_subirArchivo'			: 'subirArchivo',
		'change #inputArchivos'				: 'cargarArchivos',
		'click #inputArchivos'				: 'eliminarFileList',
		'click .eliminarArchivo'			: 'eliminarArchivo',
		'click #btn_cancelarArchivo'		: 'cancelarArchivos',
	},

	initialize			: function () {
		this.$busqueda			= $('#busqueda');
		this.$hidden_idCliente	= $('#hidden_idCliente');

		this.$tbody_empleados 	= $('#tbody_empleados');
		this.$tbody_servicios 	= $('#tbody_servicios');
		this.$fechaInicio       = $('#fechaInicio');
		this.cargarServicios();

		// this.$advertencia		= $('#advertencia');
		// this.$error 			= $('#error');
		// this.$exito 			= $('#exito');

		this.$formNuevoProyecto = $('#formNuevoProyecto');

		this.btn_marcarTodos	= $('.btn_marcarTodos')[0];

		this.$fechaEntrega      = $('#fechaEntrega');
		this.$duracion          = $('#duracion');

		this.$inputArchivos		= $('#inputArchivos');
		this.$fecha_creacion	= $('#fecha_creacion');
		// this.$section_resp_Paso3 = $('#paso3 .panel-info .panel-body');
		this.$tbody_archivos	= $('#tbody_archivos');
		this.$propietarioArchivo = $('#form_subirArchivos #idpropietario');
		this.$tablaProyecto 	= $('#form_subirArchivos #tabla');
		
		this.cargarClientes();

		this.cargarEmpleados();

		// this.idProyecto;

		this.array = new Array();

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
	render				: function () {
		return this;
	},
	cargarClientes		: function () {
		var list = '<% _.each(clientes, function(cliente) { %> <option id="<%- cliente.id %>" value="<%- cliente.id %>"><%- cliente.nombreComercial %></option> <% }); %>';
		this.$busqueda.
		append(_.template(list, 
			{ clientes : app.coleccionClientes.toJSON() }
		));
		this.$busqueda.append('<option selected disabled>Buscar cliente</option>');
		this.$busqueda.selectize({
			maxItems: 1
		});
	},
	cargarServicio		: function (servicio) {
		var vistaServicio = new app.VistaServicioProyecto({ 
			model:servicio 
		});
		this.$tbody_servicios.append( vistaServicio.render().el );
	},
	cargarServicios		: function () {
		app.coleccionServicios.each( this.cargarServicio, this );
	},
	cargarEmpleado		: function (empleado) {
		/*añadimos una nueva propiedad al modelo de empledo para
		tener en cada formulario rol el id del proyecto, de esta 
		manera es más facil enviar los roles a la api de roles de 
		proyecto*/
		// empleado.set({idproyecto:this.idProyecto});
		var vistaEmpleado = new app.VistaEmpleado({ model:empleado });
		this.$tbody_empleados.append( vistaEmpleado.render().el );
	},
	cargarEmpleados		: function () {
		app.coleccionEmpleados.each( this.cargarEmpleado, this );
	},
	calcularDuracion	: function (elem) {
		var fecha = this.$fechaInicio.val().split('/');
		var valorFechaInicio = fecha[2]+'-'+fecha[1]+'-'+fecha[0];
			fecha = this.$fechaEntrega.val().split('/');
		var valorFechaEntrega = fecha[2]+'-'+fecha[1]+'-'+fecha[0];
		// this.$duracion.val(
		// 	((valorFechaEntrega-valorFechaInicio)/24/60/60/1000) +1
		// );
		this.$duracion.val(calcularDuracion(valorFechaInicio,valorFechaEntrega).plazo);
	},
	calcularEntrega 	: function () {
		var fecha = this.$fechaInicio.val().split('/'),
			valorFechaInicio = new Date(fecha[2]+'-'+fecha[1]+'-'+fecha[0]).valueOf(),
			valorFechaEntrega = valorFechaInicio + ( parseInt(this.$duracion.val())*24*60*60*1000 ),
			fechaEntrega;

		fechaEntrega = formatearFechaUsuario(new Date(valorFechaEntrega));

		// if ((fF.getDate()) < 10 )
		// 	fechaEntrega = '0'+(fF.getDate());
		// else
		// 	fechaEntrega = (fF.getDate());
		// if ((fF.getMonth() +1) < 10 )
		// 	fechaEntrega += '/0'+(fF.getMonth() +1);
		// else
		// 	fechaEntrega +=  '/'+(fF.getMonth() +1);

		// fechaEntrega +=  '/'+fF.getFullYear();

		if (fechaEntrega != 'NaN/NaN/NaN') {
			this.$fechaEntrega.val( fechaEntrega );
		} else{
			this.$fechaEntrega.val('');
		};
	},
	eliminarDeTabla		: function (elem) {
		/*Separamos la clase del elem para acceder a la tabla
		del cual queremos eliminar uno de sus tr*/
		var arrayClass = $(elem.currentTarget)
						 .attr('class')
						 .split('_');

		/*Ejemplo de cómo se ve el selector:
		  $(#tbody_servicios #servicio_n).attr('disabled',false);
		  ó
		  $(#tbody_empleados #servicio_n).attr('disabled',false);
		*/
		$( "#tbody_"+arrayClass[1]+" #"
					+$(elem.currentTarget).attr('id') )
					.attr('disabled',false); //activamos el checkbox

		$( "#tbody_"+arrayClass[1]+" #"
					+$(elem.currentTarget).attr('id') )
					.attr('checked',false); //desmarcamos el checkbox

		$( "#tbody_"+arrayClass[1]+" #"
					+$(elem.currentTarget).attr('id') )
					.parents('tr')
					// .removeClass()	//removemos el color del tr
					.css('color','#333'); //Cambiamos color del texto

		$(elem.currentTarget).parents('tr').remove();
	},
	eliminarMarcados	: function (elem) {
		var atributoClass = $(elem.currentTarget)
							.attr('class')
							.split(' ');
		var checkboxTabla = document
							.getElementsByName(atributoClass[3]);
		var array = new Array();
		for (var i = 0; i < checkboxTabla.length; i++) {
			if ($(checkboxTabla[i]).is(':checked')) {
				array.push(checkboxTabla[i]);
			};
		};
		for (var i = 0; i < array.length; i++) {
			$(array[i])
			.parents('tr')
			.children('.icon-eliminar')
			.children()
			.click();
		};
		// /*Restablecemos el boton de Marcar todos*/
		// $(elem.currentTarget)//Utilizamo elem como referencia
		// .parent()//Nos ubicamos en el padre del elem
		// .children('.btn-group')//Nos hubicamos en el hijo especificado
		// .children('.btn')//Nos hubicamos en el hijo del hijo anterios
		// .click('toggle');//Conmutamos el botón
	},
	guardarProyecto		: function (elem) {
		var esto = this;
		var modeloProyecto = pasarAJson(this.$formNuevoProyecto.serializeArray());

		if (modeloProyecto.idcliente == '' || modeloProyecto.nombre == '') {
			alerta('Estableca un cliente y un nombre para el proyecto<br>Si no desea asociar un cliente a un proyecto escriba <b>qualium</b> como cliente',
				function () {});
			return;
		};

		if (modeloProyecto.fechainicio != '' && modeloProyecto.fechafinal != '') {
			modeloProyecto.fechainicio = modeloProyecto.fechainicio.split('/');
			modeloProyecto.fechainicio = 	modeloProyecto.fechainicio[2]+'-'+
											modeloProyecto.fechainicio[1]+'-'+
											modeloProyecto.fechainicio[0];

			modeloProyecto.fechafinal = modeloProyecto.fechafinal.split('/');
			modeloProyecto.fechafinal = 	modeloProyecto.fechafinal[2]+'-'+
											modeloProyecto.fechafinal[1]+'-'+
											modeloProyecto.fechafinal[0];
		};

		/******************************/
		var servicios = modeloProyecto.servicios;
		delete modeloProyecto.servicios;
		/******************************/

		if (servicios == undefined) {
			alerta('Debe seleccionar uno o más servicios para el proyecto',function () {});
			return;
		};

		$('#btn_guardarProyecto, #btn_cancelarProyecto').attr('disabled',true);

		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		app.coleccionProyectos.create(
			modeloProyecto,
			{
				wait	: true,
				success	: function (exito) {
					esto.guadarServiciosProyecto(exito.get('id'),servicios);
					/*----------------------------------------------*/
					/*Establece el id del proyecto a todos los roles
					a guardar*/
					$(document.getElementsByName('idproyecto')).val(exito.get('id'),servicios);
					esto.validarRolesEmpleados();

					/*Establece el id del proyecto como propietario
					del archivo a guardar y sus fechas de creación*/
					esto.$propietarioArchivo.val(exito.get('id'));
					var f = new Date();
					esto.$fecha_creacion.val(f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate());
					esto.subirArchivo();

					setTimeout(function() {
						alerta('<b>El proyecto '+exito.get('nombre')+' ha sido guadado con exito</b>',function(){});
						$(document.getElementsByTagName('body')).find('#alertify-ok').on('click',function(){
							location.href = 'proyectos_consulta';
						});
						$('#btn_guardarProyecto, #btn_cancelarProyecto').attr('disabled',false);
					}, 1000);
				},
				error	: function (error) {
					confirmar('Ocurrio un error al intentar guardar el proyecto<br><b>¿Deseas intentarlo nuevamente?</b>',
						function () {
						},
						function () {
							location.href = 'proyectos_consulta';
						});
				}
			}
		);
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;

		elem.preventDefault();
	},
	cancelarProyecto 	: function () {
		confirmar('¿Esta seguro de cancelar este poyecto?', 
			function () {
				location.href = 'proyectos_consulta';
			},
			function () {});
	},
	guadarServiciosProyecto	: function (idproyecto,servicios) {
		if ($.isArray(servicios)) {
			for (var i = 0; i < servicios.length; i++) {
				this.guadarServiciosProyecto(idproyecto,servicios[i]);
			};
		} else{
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionServiciosProyecto.create({ 
				idproyecto:idproyecto, idservicio:servicios, status:true
			},{
				wait 	:true,
				success : function (exito) { },
				error 	: function (error) { }
			});
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		};
	},
/*Funciones para la dinamina de roles de empleados sobre el nuevo proyecto*/
	validarRolesEmpleados			: function () {
		var forms = $('#paso2 form');
		for (var i = 0; i < forms.length; i++) {
			var modelo = pasarAJson(this.$(forms[i]).serializeArray());
			/*Comprobamos si hay roles nuevos*/
			if ( typeof modelo.nombre !== 'undefined' ) {
				/*Aislamos los nuevos roles*/
				var nuevosRoles = {};
				nuevosRoles.nombre = modelo.nombre;
				
				delete modelo.nombre;
				if ( typeof modelo.idrol !== 'undefined' ) {
					this.guadarRolRecursivo(modelo);
				};

				this.guardarRolesNuevos({
					idproyecto 	: modelo.idproyecto, 
					idpersonal 	: modelo.idpersonal,
					nombre 		: nuevosRoles.nombre
				});
			} else {
				if ( typeof modelo.idrol !== 'undefined' ) {
					this.guadarRolRecursivo(modelo);
				};
			};
		};
	},
	guadarRolRecursivo	: function (modelo) {
		if ($.isArray(modelo.idrol)) {
			for (var i = 0; i < modelo.idrol.length; i++) {
				this.guadarRolRecursivo({
					idproyecto:modelo.idproyecto, 
					idpersonal:modelo.idpersonal, 
					idrol:modelo.idrol[i]
				});
			};
		} else{
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionRolesProyectos.create(
				modelo,
				{
					wait	: true,
					success	: function (exito) {},
					error	: function (error) {}
				}
			);
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		};	
	},
	guardarRolesNuevos	: function (nuevosRoles) {
		var esto = this;

		if ($.isArray(nuevosRoles.nombre)) {
				for (var i = 0; i < nuevosRoles.nombre.length; i++) {
					this.guardarRolesNuevos({
						idproyecto:nuevosRoles.idproyecto, 
						idpersonal:nuevosRoles.idpersonal, 
						nombre:nuevosRoles.nombre[i]
					});
				};
		} else{
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionRoles.create(
				{nombre:nuevosRoles.nombre},
				{
					wait	: true,
					success : function (exito) {
						console.log(exito);
						esto.guadarRolRecursivo({
							idproyecto:nuevosRoles.idproyecto, 
							idpersonal:nuevosRoles.idpersonal, 
							idrol:exito.get('id')
						});
					},
					error 	: function (error) {
						console.log('error');
					}
				}
			);
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		};	
	},
/*Controladores para carga de archivos*/
	cargarArchivos		: function (elem) {
		this.$tbody_archivos.html('');
		this.arrArchivos = new Array();
		var archivos = $(elem.currentTarget).prop('files');
		for (var i = 0; i < archivos.length; i++) {
			this.$tbody_archivos.append( this.plantillaArchivo( {i:i, tipo:(archivos[i].type).split('/')[1], nombre:archivos[i].name, tamaño:(archivos[i].size/1024).toFixed() +' KB'} ) );
		};
	},
	eliminarFileList	: function () {
		delete this.$inputArchivos.val('');
	},
	subirArchivo		: function () {
		var archivos = this.$inputArchivos.prop('files');
		
		var esto = this;
		esto.classTr =  archivos.length - 1;
		if (this.arrArchivos) {
			// for (var i = 0; i < archivos.length; i++) {
			var formData;
			for (var i = archivos.length - 1; i >= 0; i--) {
				if ( this.arrArchivos.indexOf(String(i)) == -1 ) {
				this.$tbody_archivos.children('.'+i).children('.icon-eliminar').html('<div class="spin"><div>');
					// formData.append('tabla','proyectos');
					formData = new FormData(document.getElementById('form_subirArchivos'));
					formData.append('archivo[]',archivos[i]);
					// formData.append('idpropietario',this.idProyecto);
					var resp = $.ajax({
			            url: 'http://crmqualium.com/api_archivos',
			            type: 'POST',
			            async:true,
			            data: formData,
			            //necesario para subir archivos via ajax
			            cache: false,
			            contentType: false,
			            processData: false,
			            success: function (exito) {
			            	esto.$tbody_archivos.children('.'+esto.classTr).addClass('success');
			            	esto.$tbody_archivos.children('.'+esto.classTr).children('.icon-eliminar').html('<div class="has-success"><span class="glyphicon glyphicon-ok form-control-feedback"></span></div>');
			   				esto.classTr--;
			            },
			            error  : function (error) {
			            	esto.$tbody_archivos.children('.'+esto.classTr).addClass('danger');
			            	esto.$tbody_archivos.children('.'+esto.classTr).children('.icon-eliminar').html('<div class="has-error"><span class="glyphicon glyphicon-remove form-control-feedback"></span></div>');
			   				esto.classTr--;
			            }
			        });
				};
			};
		}			
	},
	eliminarArchivo		: function (elem) {
		this.arrArchivos.push( $(elem.currentTarget).attr('id') );
		$(elem.currentTarget).parents('tr').remove();
	},
	cancelarArchivos	: function () {
		var here = this;
		confirmar('Los archivos a subir seran cancelados',
			function () {
				here.cancelarTodosLosArchivos();
			},
			function () {});
	},
	cancelarTodosLosArchivos 	: function () {
		for (var i = 0; i < $('.eliminarArchivo').length; i++) {
			this.arrArchivos.push(i);
		};
		this.$tbody_archivos.html('');
	},
	marcarTodos 		: function (elem) {
		var checkboxTabla = document
							.getElementsByName(
								$(elem.currentTarget).attr('id')
							 );
		if ($(elem.currentTarget).is(':checked')) {
			for (var i = 0; i < checkboxTabla.length; i++) {
				checkboxTabla[i].checked = true;
			};
		} else{
			for (var i = 0; i < checkboxTabla.length; i++) {
				checkboxTabla[i].checked = false;
			};
		};
	},
});

app.vistaNuevoProyecto = new app.VistaNuevoProyecto();