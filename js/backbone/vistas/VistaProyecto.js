var app = app || {};
/* ---------------------------------------------------------------- */
app.VistaServicioProyecto = app.VistaServicio.extend({
	tagName	: 'li',
	className	: 'list-group-item',
	plantillaDefault	: _.template($('#plantillaServicioProyecto').html()),
	events	: {
		'click .btn_eliminar'	: 'conmutarStatus'
	},
	initialize		: function () {
		this.listenTo(this.model, 'change:status', this.remove);
		this.bloquearSeleccionado();
	},
	conmutarStatus	: function () {
		var esto = this;
		this.model.conmutarStatus(
			function (){
				$('#select_servicios').children('#'+esto.model.get('idservicio')).attr('disabled',false);
				$('#select_servicios')//Selector
					//Nos hubicamos en el padre del selector
					.parents('.filaInformacion')
					//Buscamos al hijo con la clase especificada
					.children('.respuesta')
					//Removemos su atributo class
					.html('<label class="icon-uniF479 exito"></label>');
			},
			function (){
				$('#select_servicios')//Selector
					//Nos hubicamos en el padre del selector
					.parents('.filaInformacion')
					//Buscamos al hijo con la clase especificada
					.children('.respuesta')
					//Removemos su atributo class
					.html('<label class="icon-uniF478 error"></label>');
			}
		);
	},
	bloquearSeleccionado	: function () {
		$('#select_servicios').children('#'+this.model.get('idservicio')).attr('disabled',true);
	},
});
/* ---------------------------------------------------------------- */
app.VRolProyEmpleado = app.VistaRolPrincipal.extend({
	tagName				: 'li',
	className			: 'list-group-item',
	plantillaDefault	: _.template($('#plantillaRolProyecto').html()),
	events				: {
		'click .btn_eliminar'	: 'eliminarRol'
	},
	render				: function () {
		this.model.set( {nombreRol:app.coleccionRoles.get(this.model.get('idrol')).get('nombre')} );
		this.model.set( {nombrePersonal:app.coleccionEmpleados.get(this.model.get('idpersonal')).get('nombre')} );
		this.$el.html( this.plantillaDefault( this.model.toJSON() ) );
		return this;
	},
	eliminarRol			: function () {
		this.model.destroy();
	},
});
/* ---------------------------------------------------------------- */

app.VistaProyecto = Backbone.View.extend({
	tagName	: 'tr',
	plantilla_tr		: _.template($('#plantilla_tr_proyecto').html()),
	plantillaModal	: _.template($('#plantillaModalProyecto').html()),
	plantillaArchivo	: _.template($('#tr_archivoNuevo').html()),
	plantillaRol : _.template($('#input_rol').html()),
	events				: {
		'keypress #nombreProyecto'		: 'validarAtributo',

		'click .eliminar'				: 'eliminar',
		'click #tr_btn_editar'			: 'verInfo',
		'click #tr_btn_verInfo'			: 'verInfo',
		'click #btn_editar'				: 'editando',

		'click #btn_agregarServicio' 	: 'guadarServicio',

		'change   #select_rol'			: 'agregarRol',
		'click .btn_eliminarRol'		: 'eliminarRol',
		'change #select_empleados'		: 'validarRelacionRolEmpleado',
		'click #btn_enviarRolesProy'	: 'guadarRoles',

		'keydown #descripcion'			: 'actualizarComentario',

		'click .cerrar'					: 'cerrarAlerta',

		'change #inputArchivos'			: 'cargarArchivos',
		'click #btn_subirArchivo'		: 'subirArchivo',
		'click #inputArchivos'			: 'eliminarFileList',
		'click .eliminarArchivoNuevo'	: 'eliminarArchivo',
		'click #btn_cancelarArchivo'	: 'cancelarArchivos',
		'click #cancelar'				: 'cancelarArchivos',
		'click #continuar'				: 'cancelarArchivos',
	},
	initialize				: function () {
		this.listenTo(this.model, 'destroy', this.remove);
		this.listenTo(app.coleccionRoles, 'reset', this.cargarSelectRol);

		// this.htmlAdvertencia;
		this.esperar;
	},
	render					: function () {
		/*Creamos nueva propiedad duracion para calculos con fechas*/
		this.model.set( {duracion:this.calcularDuracion()} );
		this.$el.html( this.plantilla_tr(this.model.toJSON()) );
		return this;
	},
	verInfo					: function (elem) {
		var esto = this;
		
		/* ---Añade el nombre de los representantes del cliente--- */
			var representantes = 
				app.coleccionRepresentantes
				.where({
					idcliente:this.model.get('idcliente')
				});
			var nombres = [];
			for (var i = 0; i < representantes.length; i++) {
				nombres.push(' '+representantes[i].toJSON().nombre);
			};
			this.model.set( {representante:nombres} );		
		/* ------------------------------------------------------- */

		this.$el.append( this.plantillaModal(this.model.toJSON()) );
		/*La variable modal guarda el elem DOM del modal junto
		después de creado en el DOM general*/
		var modal = this.$el.find('#modal'+this.model.get('id'));
		this.$ul_serviciosProyecto 	= this.$el.find('#serviciosProyecto');
		this.$ul_rolesProyecto		= this.$el.find('#rolesProyecto');
		this.$archivos_proy			= this.$el.find('#archivos_proy');
		this.$select_servicios		= this.$el.find('#select_servicios');
		this.$select_rol			= this.$el.find('#select_rol');
		this.$tbody_archivos		= this.$el.find('#tbody_archivos');
		this.$inputArchivos			= this.$el.find('#inputArchivos');

		/*Cacheamos el id del boton editar del modal para luego 
		  cambiar su icono en cuanto se haga click en etidar tando en
		  el tr o el modal*/
		this.$btn_editar			= this.$el.find('#btn_editar');

		/* -Crea los tags de nuevo rol----------------------------- */
			var text_nuevoRol 		= this.$el.find('.text_nuevoRol');
			var btn_nuevoRol 		= this.$el.find('.btn_nuevoRol');

			btn_nuevoRol.on('click', function () {
				var nuevoRol = text_nuevoRol.val().trim();
				if (nuevoRol !== '') {
					$('#rolesNuevosProy').append(esto.plantillaRol({id:nuevoRol, nombre:nuevoRol, name:'nombre'}));
					text_nuevoRol.val('');
				};
				text_nuevoRol.val('');
			});

			text_nuevoRol.on('keypress', function (e) {
				if (e.keyCode === 13 && $(this).val() !== '') {
					$('#rolesNuevosProy').append(esto.plantillaRol({id:$(this).val(), nombre:$(this).val(), name:'nombre'}));
					$(this).val('');
				};
			});
		/* -------------------------------------------------------- */

		/*Cargar datos en el modal*/
		modal.on('shown.bs.modal',function (){
			/* Cargamos los select */
				esto.cargarSelectServicios();
				esto.cargarSelectRol();
				esto.cargarSelectEmpleados();
			/* Cargar información del proyecto */
				esto.cargarServicios(function () {
					esto.
						$ul_serviciosProyecto.
						children().
						children('.editando2').
						toggleClass('editando2');
				});
				esto.cargarRoles();
				esto.cargarArchivosProy();
			/* plugin Datepicker jQueryUI */
				$('.datepicker').datepicker({ 
					dateFormat	: 'yy-mm-dd', 
					monthNames	: [
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
					], 
					dayNames	: [
						'Lunes',
						'Martes',
						'Miercoles',
						'Jueves',
						'Viernes',
						'Sábado',
						'Domingo'
					]
				});
			/* Evento para el obtener la fecha del calendario */
				$( ".datepicker" ).on('change', function (elem){
					/*Serializamos la fecha (fecha de inicio o final 
					segun el caso). Lo pasamos como parametro a la 
					función que  actualiza los atributos del modelo 
					proyecto*/
					esto.actualizarAtributo( elem );
					/*Creamos un array sobre la fecha seleccionada
					para volverla a mostrar en el input*/
					var fecha = $(this).val().split('-');
					/*Formateamos la fecha seleccionada a la forma 
					día/mes/año y la establecemos en el input*/
					$(this).val(fecha[2]+'/'+fecha[1]+'/'+fecha[0]);
				});
			
			/*Puede ocurrir que desde el tr del proyecto se quiera
			  abrir el modal en modo edición. Esta condición ejecuta
			  la funcion editando para activar todos los campo en los 
			  que se puede editar*/
				if ($(elem.currentTarget).attr('id') == 'tr_btn_editar') {
					esto.editando();
				};
		});
		/*Escuchamos el evento que hace que se esconda el modal
		  para luego eliminarlo*/
		modal.on('hidden.bs.modal', function(){
			/*this es la variable modal. removemos el elem DOM
			de todo el documento (DOM general)*/
			$(this).remove();
			esto.render(); //Actualiza la vista al cerrar el modal
		});
	},

/*Funciones para la dinamina de roles de empleados sobre el proyecto*/
	validarRelacionRolEmpleado		: function (elem) {
		$('#rolesNuevosProy').html('');
		this.$select_rol.children().attr('disabled',false);
		this.$select_rol.children().first().attr('disabled',true);
		var roles = app.coleccionRolesProyectos.where({idproyecto:this.model.get('id'),idpersonal:$(elem.currentTarget.selectedOptions).val()})
		for (var i = 0; i < roles.length; i++) {
			this.$select_rol.children('#'+roles[i].get('idrol')).attr('disabled',true);
		};
	},
	guadarRoles				: function (event) {
		var modelo = pasarAJson(this.$('#form_roles').serializeArray());

		if ( typeof modelo.idpersonal === 'undefined' ) {
			console.log('seleccione personal');
			event.preventDefault();
			return;
		};

		/*Comprobamos si hay roles nuevos*/
		if ( typeof modelo.nombre !== 'undefined' ) {
			/*Aislamos los nuevos roles*/
			var nuevosRoles = {};
			nuevosRoles.nombre = modelo.nombre;
			delete modelo.nombre;

			if ( typeof modelo.idrol !== 'undefined' ) {
				this.guadarRolRecursivo(modelo);
			} else { /*ALERTA*/ };
			this.guardarRolesNuevos({
				idproyecto 	: modelo.idproyecto, 
				idpersonal 	: modelo.idpersonal,
				nombre 		: nuevosRoles.nombre
			});
		} else {
			if ( typeof modelo.idrol !== 'undefined' ) {
				this.guadarRolRecursivo(modelo);
			} else { /*ALERTA*/ };
		};
		event.preventDefault();
	},
	guadarRolRecursivo		: function (modelo) {
		var esto = this;
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
					success	: function (exito) {
						/*--------------------------------------*/
							esto.$ul_rolesProyecto
								.children()
								.children('.editando2')
								.toggleClass('editando2');
						/*--------------------------------------*/
							exito.set({exito:''});
							esto.cargarRol(exito);
						/*--------------------------------------*/
							esto.$ul_rolesProyecto
								.children()
								.children('.editar2')
								.toggleClass('editando2');
						/*--------------------------------------*/
					},
					error	: function (error) {
						error.set({error:''});
						esto.cargarRol(error);
					}
				}
			);
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		};	
	},
	guardarRolesNuevos		: function (nuevosRoles) {
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
						esto.guadarRolRecursivo({
							idproyecto:nuevosRoles.idproyecto, 
							idpersonal:nuevosRoles.idpersonal, 
							idrol:exito.get('id')
						});
						console.log('Rol creado');
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
//
	validarAtributo			: function (elem) {
		if (elem.keyCode === 13)
			this.actualizarAtributo( elem );
	},
	actualizarAtributo		: function (elem) {
		var datoSerializdo = $(elem.currentTarget).serializeArray();
		if (datoSerializdo[0].value != '') {
			/*Pasamos el dato al formato key:value con la función 
			pasarAJson()*/
			this.model.save(pasarAJson(datoSerializdo), { 
				wait	: true,
				patch	: true,
				success	: function (exito) {
					// console.log('actualizado');
					$(elem.currentTarget)//Selector
						//Nos hubicamos en el padre del selector
						.parents('.filaInformacion')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Removemos su atributo class
						.html('<label class="icon-uniF479 exito"></label>');
				},
				error	: function (error) {
					// console.log('error actualización');
					$(elem.currentTarget)//Selector
						//Nos hubicamos en el padre del selector
						.parents('filaInformacion')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Sustituimos html por uno nuevo
						.html('<label class="icon-uniF478 error"></label>');
				}
			});
		} else{
			console.log('dato no valido');
		};
	},
	actualizarComentario	: function (elem) {
		$(elem.currentTarget).parents('tr').children('.respuesta').html('<img src="img/ajax-loader.gif" width="14" height="14">');
		clearTimeout(this.esperar);
		var modelo = this.model;

		this.esperar = setTimeout(
			function () {
				modelo.save(
					pasarAJson($(elem.currentTarget)
								.serializeArray()),
					{
						wait	: true,
						patch	: true,
						success	: function (exito) {
							console.log('Exito actualizando comentario');
							$(elem.currentTarget)//Selector
								//Nos hubicamos en el padre del selector
								.parents('tr')
								//Buscamos al hijo con la clase especificada
								.children('.respuesta')
								//Removemos su atributo class
								.html('<label class="icon-uniF479 exito"></label>');
						},
						error	: function (error) {
							console.log('Error actualizando comentario');
							$(elem.currentTarget)//Selector
								//Nos hubicamos en el padre del selector
								.parents('tr')
								//Buscamos al hijo con la clase especificada
								.children('.respuesta')
								//Sustituimos html por uno nuevo
								.html('<label class="icon-uniF478 error"></label>');
						}
					}
				);
			},
			3000
		);
	},
	guadarServicio			: function () {
		var esto = this,
			dato = pasarAJson(this.$select_servicios.serializeArray()),

		/*Realizar una busqueda para no duplicar servicios. En tal
		  caso cambiamos el status del del servicio eliminado*/
			existente = app.coleccionServiciosProyecto.where({
								idproyecto:this.model.get('id'), 
								idservicio:dato.idservicio, 
								status: '0'
							});

			if (typeof existente[0] !== 'undefined') {
				existente[0].save({
					status:'1'
				},{
					patch	:true,
					success	: function () {
						esto.cargarServicios(function(){});
						esto.$select_servicios//Selector
							//Nos hubicamos en el padre del selector
							.parents('.filaInformacion')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Removemos su atributo class
							.html('<label class="icon-uniF479 exito"></label>');
					},
					error 	: function () {
						esto.$select_servicios//Selector
							//Nos hubicamos en el padre del selector
							.parents('.filaInformacion')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Sustituimos html por uno nuevo
							.html('<label class="icon-uniF478 error"></label>');
					}
				});
				/*Rompemos la secuencia de esta función*/
				return;
			};
		/*Si no existe creamos el nuevo servicio para el proyecto*/
			var	nombreServicio = 	this.
									$select_servicios.
									children('option:selected').
									text();
			if (dato.nombre !== '') {
				dato.idproyecto = this.model.get('id');
				Backbone.emulateHTTP = true;
				Backbone.emulateJSON = true;
				app.coleccionServiciosProyecto.create( dato, {
					wait 	:true,
					success : function (exito) {
						dato.nombre = nombreServicio;
						dato.status = '1';
						app.coleccionServiciosProyecto.last().set(dato);
						esto.cargarServicios(function () {
							/*Pasamos un callback sin instrucciones*/
						});
						console.log('Se guardo el nuevo servicio del proyecto');
						esto.$select_servicios//Selector
							//Nos hubicamos en el padre del selector
							.parents('.filaInformacion')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Removemos su atributo class
							.html('<label class="icon-uniF479 exito"></label>');
					},
					error 	: function (error) {
						console.log('No se guardo el servicio');
						esto.$select_servicios//Selector
							//Nos hubicamos en el padre del selector
							.parents('.filaInformacion')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Sustituimos html por uno nuevo
							.html('<label class="icon-uniF478 error"></label>');
					}
				});
				Backbone.emulateHTTP = false;
				Backbone.emulateJSON = false;
			} else{
				console.log('No has seleccionado servicio');
			};
	},
	eliminar				: function () {
		this.model.destroy();
	},
	editando				: function () {
		if (this.$btn_editar
			.children()
			.attr('class') == 
			'icon-edit2 MO icon-back'
		) {
			this.$btn_editar
				.children()
				.toggleClass('MO icon-back');
			this.$('.editar2').toggleClass('editando2');
			//Cierra el modal
				this.$('#cerrar_consulta').click();
			//Actualiza los datos
				this.render();
			//Abre nuevamente el modal
				this.$('.icon-eye').click();
		} else{
			this.$btn_editar
				.children()
				.toggleClass('MO icon-back');
			this.$('.editar2').toggleClass('editando2');
		};	
	},
	cargarServicio			: function (servicio) {
		var vista = new app.VistaServicioProyecto({ model:servicio });
		this.$ul_serviciosProyecto.append(vista.render().el);
	},
	cargarServicios			: function (callback) {
		this.$ul_serviciosProyecto.html('');
		var servicios = app.coleccionServiciosProyecto.where({idproyecto:this.model.get('id'), status:'1'});
		for (var i = 0; i < servicios.length; i++) {
			this.cargarServicio(servicios[i]);
		};
    	callback();
	},
	cargarRol				: function (rol) {
		var vista = new app.VRolProyEmpleado({ model:rol });
		this.$ul_rolesProyecto.append(vista.render().el);
	},
	cargarRoles				: function () {
		var roles = app.coleccionRolesProyectos.where({idproyecto:this.model.get('id')});
		for (var i = 0; i < roles.length; i++) {
			this.cargarRol(roles[i]);
		};
	},

	cargarSelectServicios	: function () {
		var list = '<% _.each(servicios, function(servicio) { %> <option id="<%- servicio.id %>" value="<%- servicio.id %>"><%- servicio.nombre %></option> <% }); %>';
		$('#select_servicios').
		append(_.template(list, 
			{ servicios : app.coleccionDeServicios }
		));
	},
	cargarSelectRol			: function () {
		var list = '<% _.each(roles, function(rol) { %> <option id="<%- rol.id %>" value="<%- rol.id %>"><%- rol.nombre %></option> <% }); %>';
		$('#select_rol').
		html('<option selected disabled>Seleccione un rol...</option>').
		append(_.template(list, 
			{ roles : app.coleccionDeRoles }
		));
	},
	cargarSelectEmpleados	: function () {
		var list = '<% _.each(empleados, function(empleado) { %> <option id="<%- empleado.id %>" value="<%- empleado.id %>"><%- empleado.nombre %></option> <% }); %>';
		$('#select_empleados').
		append(_.template(list, 
			{ empleados : app.coleccionDeEmpleados }
		));
	},
	agregarRol				: function (elem) {
		$('#rolesNuevosProy').append(this.plantillaRol( { id:$(elem.currentTarget).val(), nombre:$(elem.currentTarget.selectedOptions).text(), name:'idrol' } ));
		$(elem.currentTarget.selectedOptions).attr('disabled',true);	
	},
	eliminarRol 			: function (elem) {
		$('#select_rol').children('#'+$(elem.currentTarget).attr('value')).attr('disabled',false);
		$(elem.currentTarget).parents('.tag_rol').remove();
		elem.preventDefault();
	},
	cargarArchivoProy		: function (archivo) {
		var vista = new app.V_A_ConsultaProyecto({ model:archivo });
		this.$archivos_proy.append(vista.render().el);
	},
	cargarArchivosProy		: function () {
		var archivo = app.coleccionArchivos.where({idpropietario:this.model.get('id'), tabla:'proyectos'});
		for (var i = 0; i < archivo.length; i++) {
			this.cargarArchivoProy(archivo[i]);
		};
	},
	calcularDuracion		: function () {
		var valorFechaInicio = new Date(this.model.get('fechainicio')).valueOf();
		var valorFechaEntrega = new Date(this.model.get('fechafinal')).valueOf();
		var valorFechaActual = new Date().valueOf();
		var plazo = ((((valorFechaEntrega-valorFechaInicio))/24/60/60/1000) + 1).toFixed() - this.excluirDias(this.model.get('fechainicio'), this.model.get('fechafinal'));
		var queda = ((((valorFechaEntrega-valorFechaInicio)-((valorFechaEntrega-valorFechaInicio)-(valorFechaEntrega-valorFechaActual)))/24/60/60/1000) +1).toFixed() - this.excluirDias(new Date(), this.model.get('fechafinal'));
		if (queda == -0) queda = 0;
		var porcentaje = ((100 * queda)/plazo).toFixed();

		console.log('plazo: '+plazo, 'queda: '+queda, 'porcentaje: '+porcentaje+'%');
		return {
			plazo		:plazo,
			queda		:queda,
			porcentaje	:porcentaje
		};
	},
	excluirDias	: function (fechaInicio, fechaFinal) {
		var contador = 0;
		var valorFechaInicio = new Date(fechaInicio).valueOf();
		var valorFechaEntrega = new Date(fechaFinal).valueOf();
		var duracion = (((valorFechaEntrega-valorFechaInicio)/24/60/60/1000) +1).toFixed();
		var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
		for(var i = 0; i<duracion; i++){
			var dia = (new Date(new Date(fechaInicio).getTime() + i*24*60*60*1000)).getDay();
		   	if(days[dia] == 'Saturday' || days[dia] == 'Sunday'){ 
		   		contador++;
		   	};
		};
		return contador;
	},
/* Archivos nuevos */
	cargarArchivos	: function (elem) {
		this.$tbody_archivos.html('');
		this.arrArchivos = new Array();
		// if ( this.arrArchivos == $(elem.currentTarget).prop('files') ) {console.log('Si')} else{console.log('No')};
		var archivos = $(elem.currentTarget).prop('files');
		for (var i = 0; i < archivos.length; i++) {
			this.$tbody_archivos.append( this.plantillaArchivo( {i:i, tipo:(archivos[i].type).split('/')[1], nombre:archivos[i].name, tamaño:(archivos[i].size/1024).toFixed() +' KB'} ) );
		};
	},
	eliminarFileList	: function () {
		delete this.$inputArchivos.val('');
	},
	subirArchivo		: function () {/*elem*/
		console.log('subirArchivo');
		// elem.preventDefault();
		var archivos = this.$inputArchivos.prop('files');
		
		var esto = this;
		esto.classTr =  archivos.length - 1;
		if (this.arrArchivos) {
			// for (var i = 0; i < archivos.length; i++) {
			for (var i = archivos.length - 1; i >= 0; i--) {
				if ( this.arrArchivos.indexOf(String(i)) == -1 ) {
					this.$tbody_archivos.children('.'+i).children('.icon-eliminar').html('<img src="img/ajax-loader25x25.gif">');
					var formData = new FormData(document.getElementById('form_subirArchivos'));
					// formData.append('tabla','proyectos');
					formData.append('archivo[]',archivos[i]);
					// formData.append('idpropietario',this.idProyecto);
					var resp = $.ajax({
			            url: 'http://qualium.mx/sites/crmqualium/api_archivos',
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
		$(elem.currentTarget).parents('.'+$(elem.currentTarget).attr('id')).remove();
	},
	cancelarArchivos	: function (elem) {
		if ($(elem.currentTarget).attr('id') == 'btn_cancelarArchivo') {
			this.$('#advertencia #comentario').html('Los archivos a subir seran cancelados');
			this.$('#advertencia').removeClass('oculto');
		}; 
		if ($(elem.currentTarget).attr('id') == 'cancelar') {
			for (var i = 0; i < $('.eliminarArchivo').length; i++) {
				this.arrArchivos.push(i);
			};
			this.$('#advertencia').addClass('oculto');
			this.$tbody_archivos.html('');
		};
		if ($(elem.currentTarget).attr('id') == 'continuar') {
			/*Este condicion evalua si existe la variable global
			que almacena el html para la alerta de advertencia. de lo
			contrario no pa a la otra línea. esta variable se crea y 
			se guarda el html cuando el usuario preciona el botón de 
			cancelar proyecto en la función cancelarProyecto.
			DAR MANTENIMIENTO*/
			// if (this.htmlAdvertencia) {
			// 	this.$advertencia.html(this.htmlAdvertencia);
			// 	this.$advertencia.toggleClass('oculto');
			// };
			$(elem.currentTarget).parents('div').children('.cerrar').click();
		};
	},
// 

	cerrarAlerta		: function (elem) {
		/*Este condicion evalua si existe la variable global
		que almacena el html para la alerta de advertencia. de lo
		contrario no pa a la otra línea. esta variable se crea y 
		se guarda el html cuando el usuario preciona el botón de 
		cancelar proyecto en la función cancelarProyecto.
		DAR MANTENIMIENTO*/
		// if (this.htmlAdvertencia) {
		// 	this.$advertencia.html(this.htmlAdvertencia);
		// 	this.$advertencia.toggleClass('oculto');
		// 	return;	
		// };
		$(elem.currentTarget).parent().toggleClass('oculto');
	},
});