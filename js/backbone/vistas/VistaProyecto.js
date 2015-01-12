var app = app || {};
/* ---------------------------------------------------------------- */
app.VistaSeccionProyecto = app.VistaServicio.extend({
	tagName	: 'div',
	className	: 'row margin5px padding5px',
	plantillas:{
		seccion : _.template($('#row-seccion').html())
	},
	events	: {
		'click .btn-conmutar-status-seccion'	: 'conmutarStatus',
		'click .btn_eliminar_seccion' 	: 'eliminar',
		'click .btn_editar_seccion' 	: 'editar',
		'click .btn_actualizar'			: 'actualizar',
	},
	initialize : function () {
		this.listenTo(this.model, 'change:status', this.remove);
		this.listenTo(this.model, 'change', this.render);
		this.listenTo(this.model, 'destroy', this.remove);
		// corrige el error del modelo que contiene un modelo dentro
		// el cual tiene el id que retorna la api
		this.listenTo(this.model, 'remove', this.remove);

		// this.$seccion = this.$('input[name="seccion"]');
		// this.$horas = this.$('input[name="horas"]');
		// this.$descripcion = this.$('input[name="descripcion"]');
	},
	render : function () {
		this.$el.html(this.plantillas.seccion(this.model.toJSON()));

		return this;
	},
	conmutarStatus	: function () {
		var self = this;
		this.model.conmutarStatus(
			function (){
				$('#select_servicios').children('#'+self.model.get('idservicio')).attr('disabled',false);
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
	eliminar 		: function () {
		this.model.destroy({wait:true});
	},
	editar 	: function (e) {
		this.$el.find('.editar').toggleClass('editando');
		this.$(e.currentTarget).toggleClass('active');
		var $save = this.$('.btn_actualizar');
		if ($save.is(':disabled') == true) {
			$save.attr('disabled', false);
		} else{
			$save.attr('disabled', true);
		};
	},
	actualizar 	: function (e) {
		var self = this;
		this.model.save( pasarAJson( this.$('form').serializeArray() ) , {
			wait 	:true,
			success :function () {
				setTimeout(function() {
					self.$('.btn_editar_seccion').click();
					self.$el.addClass('row-success');
				}, 10);
			},
			error 	:function () {
				this.$el.addClass('row-error');
			}
		} );
		e.preventDefault();
	},
	// bloquearSeleccionado	: function () {
	// 	$('#select_servicios').children('#'+this.model.get('idservicio')).attr('disabled',true);
	// },
});
app.VistaSeccionEliminada = app.VistaSeccionProyecto.extend({
	tagName	: 'div',
	className	: 'btn-group btn-group-xs margin2px',
	plantillas : {
		seccion : _.template($('#seccion-eliminada').html())
	}
})
app.VistaServicioProyecto = Backbone.View.extend({
	tagName:'div',
	className:'panel panel-default',
	plantillas	: {
		servicio : _.template($('#plantillaServicioProyecto').html())
	},
	events 	: { },
	initialize : function () {
		this.listenTo(app.coleccionServiciosProyecto, 'change:status', this.cargarSeccion);
		this.listenTo(app.coleccionServiciosProyecto, 'add', this.cargarSeccion);
	},
	render 	: function () {
		this.$el.append(this.plantillas.servicio({
			nombre : app.coleccionServicios.get(this.model.get('idservicio')).toJSON().nombre,
			id:this.model.get('idservicio')
		}));
		this.cargarSecciones();
		this.cargarEliminados();
		return this;
	},
	cargarSeccion	: function (model) {
		if ( model.get('idservicio') == this.model.get('idservicio') ) {
			var vista;
			switch(model.get('status')){
				case '1':
					vista = new app.VistaSeccionProyecto({ model: model });
					this.$('.secciones').prepend(vista.render().el);
					break;
				case '0':
					vista = new app.VistaSeccionEliminada({ model: model });
					this.$('.secciones-eliminadas').append(vista.render().el);
					break;
				default:
					// statements_def
					break;
			}
		};
	},
	cargarSecciones : function () {
		var self = this;
		app.coleccionServiciosProyecto.each(function (model){
			if (model.get('idproyecto') == self.model.get('idproyecto') &&
				model.get('idservicio') == self.model.get('idservicio') &&
				model.get('status') == '1'
			) {
				self.cargarSeccion(model);
			};
		});
	},
	cargarEliminados : function () {
		var self = this;
		app.coleccionServiciosProyecto.each(function (model){
			if (model.get('idproyecto') == self.model.get('idproyecto') &&
				model.get('idservicio') == self.model.get('idservicio') &&
				model.get('status') == '0'
			) {
				self.cargarSeccion(model);
			};
		});
	}
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
app.VAProyecto = app.VistaArchivo.extend({
	tagName					: 'tr',

	className				: 'trProyecto',

	plantillaDefault		: _.template($('#tr_archivo').html()),

	events					: {
		'click .eliminar'	: 'eliminar'
	},
	eliminar				: function () {
		this.model.destroy();
	}
});
/* ---------------------------------------------------------------- */
app.VistaProyecto = Backbone.View.extend({
	tagName	: 'tr',
	plantillas : {
		tr	: _.template($('#plantilla_tr_proyecto').html()),
		modal			: _.template($('#plantillaModalProyecto').html()),
		archivo			: _.template($('#tr_archivoNuevo').html()),
	},
	events				: {
		'keypress #nombreProyecto'		: 'validarAtributo',

		'click .eliminar'				: 'eliminar',
		'click #modal_btn_eliminar'		: 'eliminar',
		
		'click #tr_btn_editar'			: 'verInfo',
		'click #tr_btn_verInfo'			: 'verInfo',
		'click #modal_btn_editar'		: 'editando',

		'click #btn_agregarServicio' 	: 'guardarServicio',

		'change #select_empleados'		: 'validacionRolEmpleado',
		'click #btn_enviarRolesProy'	: 'guadarRol',

		'keydown #descripcion'			: 'actualizarComentario',

		'click .cerrar'					: 'cerrarAlerta',

		'click #btn_subirArchivo'		: 'subirArchivo',
		
		'click .span-conmutar-entrega'		: 'conmutarEntrega'
	},
	initialize				: function () {
		this.listenTo(this.model, 'destroy', this.remove);
		this.listenTo(this.model, 'change:status', this.render);
		this.listenTo(this.model, 'change:entregado', this.render);
		this.esperar;
	},
	render					: function () {
		/*Creamos nueva propiedad duracion para calculos con fechas*/
		this.model.set( {
			duracion : calcularDuracion( 
				new Date( fechaEstandar( this.model.get('fechainicio') ) ),
				new Date( fechaEstandar( this.model.get('fechafinal') ) )
			)
		} );
		
		this.$el.html( this.plantillas.tr( this.model.toJSON() ) );
		
		var entregado = this.model.get('entregado');

		if ( entregado == '1' || entregado == true ) {
			this.$el.addClass('success');
		};

		return this;
	},
	verInfo					: function (e) {
		var self = this;
		
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

		this.$el.children('.td_modal').append( this.plantillas.modal(this.model.toJSON()) );
		/*La variable modal guarda el e DOM del modal junto
		después de creado en el DOM general*/
		var modal = this.$el.find('#modal'+this.model.get('id'));
		this.$div_serviciosProyecto 	= this.$('#serviciosProyecto');
		this.$ul_rolesProyecto		= this.$('#ul-rolesProyecto');
		this.$tbody_archivos_subidos			= this.$('#tbody-archivos-subidos');
		this.$select_servicios		= this.$('#select_servicios');
		this.$form_seccion			= this.$('#form_seccion');
		this.$select_empleados		= this.$('#select_empleados');
		this.$select_rol			= this.$('#select_rol');
		this.$tbody_archivos		= this.$('#tbody_archivos');
		this.$inputArchivos			= this.$('#inputArchivos');
		this.$select_empleados 		= this.$('#select_empleados');

		/*Cacheamos el id del boton editar del modal para luego 
		  cambiar su icono en cuanto se haga click en etidar tando en
		  el tr o el modal*/
		this.$btn_eliminar = this.$('#modal_btn_eliminar');
		this.$btn_editar = this.$('#modal_btn_editar');

		/*Cargar datos en el modal*/
		modal.modal({
			keyboard : false,
			backdrop : false
		}).on('shown.bs.modal',function (){
			/* Cargamos los select */
self.cargarSelectServicios();
self.cargarSelectRoles(false);
self.cargarSelectEmpleados();
			/* Cargar información del proyecto */
				self.cargarServicios();
self.cargarRoles();
self.cargarArchivosProy();
			
			/*Puede ocurrir que desde el tr del proyecto se quiera
			  abrir el modal en modo edición. Esta condición ejecuta
			  la funcion editando para activar todos los campo en los 
			  que se puede editar*/
				if ($(e.currentTarget).attr('id') == 'tr_btn_editar') {
					self.editando();
				};
		});
		/*Escuchamos el evento que hace que se esconda el modal
		  para luego eliminarlo*/
		modal.on('hidden.bs.modal', function(){
			/*this es la variable modal. removemos el e DOM
			de todo el documento (DOM general)*/
			$(this).remove();
			self.render(); //Actualiza la vista al cerrar el modal
		});
		this.cargarPlugins();
		var VArchivos = app.VistaArchivos.extend({
			el:'#profile',
			plantillaArchivo		: _.template($('#tr_archivoNuevo').html())
		})
		this.vistaArchivos = new VArchivos();
	},
	conmutarEntrega 		: function () {
		var self = this,
			entregado = this.model.get('entregado');
		if (entregado == '0' || entregado == false) {
			confirmar('¿Deseas dar por terminado este proyecto?<br>No podrás revertir esta acción.',function () {
				self.model.conmutarEntrega();
			}, function () {});
		} else {
			this.model.conmutarEntrega();
		};
			
	},
/*Funciones para la dinamina de roles de empleados sobre el proyecto*/
	guadarRol				: function (e) {
		var json = pasarAJson(this.$('#form_roles').serializeArray()),
			self = this;

		if (json.idpersonal == '' ||
			json.idrol == '' ) {
			alerta('Seleccione un empleado y un rol, luego haga clic en el botón agregar',function () {});
			e.preventDefault();
			return;
		};
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		app.coleccionRolesProyectos.create(json,{
			wait 	: true,
			success : function (model) {
				self.cargarRol(model);
				self.cargarSelectRoles(false);
				self.cargarSelectEmpleados();
			},
			error 	: function () {
				alerta('Ocurrio un <span class="label label-danger">error</span> al crear el rol del empleado', function () {});
			}
		});
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
		e.preventDefault();
	},
	validarAtributo			: function (e) {
		if (e.keyCode === 13)
			this.actualizarAtributo( e );
	},
	actualizarAtributo		: function (e) {
		var datoSerializdo = $(e.currentTarget).serializeArray();
		if (datoSerializdo[0].value != '') {
			/*Pasamos el dato al formato key:value con la función 
			pasarAJson()*/
			this.model.save(pasarAJson(datoSerializdo), { 
				wait	: true,
				patch	: true,
				success	: function (exito) {
					// console.log('actualizado');
					$(e.currentTarget)//Selector
						//Nos hubicamos en el padre del selector
						.parents('.filaInformacion')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Removemos su atributo class
						.html('<label class="icon-uniF479 exito"></label>');
				},
				error	: function (error) {
					// console.log('error actualización');
					$(e.currentTarget)//Selector
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
	actualizarComentario	: function (e) {
		this.$('#spin').removeClass().addClass('spin');
		clearTimeout(this.esperar);
		var modelo = this.model,
			self = this;

		this.esperar = setTimeout(
			function () {
				modelo.save(
					pasarAJson($(e.currentTarget)
								.serializeArray()),
					{
						wait	: true,
						patch	: true,
						success	: function (exito) {
								self.$('#spin').removeClass().addClass('icon-uniF479 exito');
						},
						error	: function (error) {
							console.log('Error actualizando comentario');
							$(e.currentTarget)//Selector
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
	guardarServicio			: function (e) {
		var self = this,
			json = pasarAJson(this.$form_seccion.serializeArray());

			if (json.idservicio.split('_')[0] == 'nuevo') {
				Backbone.emulateHTTP = true;
				Backbone.emulateJSON = true;
				app.coleccionServicios.create({
					nombre:json.idservicio.split('_')[1]
				},{
					wait:true,
					success:function (model) {
						self.$select_servicios[0]
						.selectize
						.updateOption('nuevo_'+model.get('nombre'),{
							id 	  :model.get('id'),
							title :model.get('nombre')
						});
						// El plugin no actualiza el value del servicio nuevo 
						// seleccionado porque es una imagen del original,
						// (verificar api selectize.js). Lo realizamos manualmente
						self.$('select option[value="nuevo_'+model.get('nombre')+'"]').val( model.get('id') );

						self.guardarServicio(e);
						setTimeout(function() {
							self.cargarServicios();
						}, 500);
					},
					error:function () {
						alerta('Ocurrio un <span class="label label-danger">error</span> al intentar crear la sección/actividad',function () {});
					}
				});
				Backbone.emulateHTTP = false;
				Backbone.emulateJSON = false;

			} else if ( json.idservicio	!= '' &&
						json.seccion	!= '' &&
						json.descripcion!= ''
			) {
				json.idproyecto = this.model.get('id');
				Backbone.emulateHTTP = true;
				Backbone.emulateJSON = true;
				app.coleccionServiciosProyecto.create( json, {
					wait 	:true,
					success : function (model) {
						self.$form_seccion[0].reset();
						// Verificamos si existe el contenedor de secciones
						// de lo contrario, lo creamos.
						if (!self.$('#servicio'+model.get('idservicio')).attr('id')) {
							self.cargarServicio(model.get('idservicio'));
						};
					},
					error 	: function (error) {
						alerta('Ocurrio un <span class="label label-danger">error</span> al intentar crear la sección/actividad',function () {});
					}
				});
				Backbone.emulateHTTP = false;
				Backbone.emulateJSON = false;
			} else{
				console.log('No has seleccionado servicio');
			};
		e.preventDefault();
	},
	eliminar				: function () {
		var self = this;
		confirmar('El proyecto <b>'+this.model.get('nombre')+'</b> y sus archivos serán eliminados de manera permanente.',function (){
			self.model.destroy();
		}, function (){});
		
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
			this.$('#home .editar').toggleClass('editando');
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
			this.$('#home .editar').toggleClass('editando');
		};
	},
	cargarServicio			: function (idservicio) {
		var vista = new app.VistaServicioProyecto({model:new Backbone.Model({
			idservicio:idservicio,
			idproyecto:this.model.get('id')
		})});
    	this.$div_serviciosProyecto.prepend(vista.render().el);
	},
	cargarServicios			: function () {
		this.$div_serviciosProyecto.html('');
    	var grupos = this.obtenerGrupos({idproyecto:this.model.get('id')});
    	for (var i = 0; i < grupos.length; i++) {
    		this.cargarServicio(grupos[i]);
    	};
	},
	obtenerGrupos			: function (parametros) {
		var jsonSecciones = _.where(app.coleccionServiciosProyecto.toJSON(),parametros);
		var groposServicios = _.groupBy(jsonSecciones,'idservicio');
		return _.keys(groposServicios);
	},
	cargarRol				: function (rol) {
		var vista = new app.VRolProyEmpleado({ model:rol });
		this.$ul_rolesProyecto.prepend(vista.render().el);
	},
	cargarRoles				: function () {
		var roles = app.coleccionRolesProyectos.where({idproyecto:this.model.get('id')});
		for (var i = 0; i < roles.length; i++) {
			this.cargarRol(roles[i]);
		};
	},
	validacionRolEmpleado	: function () {
		this.cargarSelectRoles(false);
		var control = this.$select_rol[0].selectize,
			idemp   = this.$select_empleados.val();
			idroles = _.pluck( _.where(app.coleccionRolesProyectos.toJSON(), {
				idpersonal : idemp,
				idproyecto : this.model.get('id')
			}), 'idrol' );

		// aunque _.pluck() simpre devuelve array,
		// preparamos la funcion para el caso contrario
		if ( _.isArray( idroles ) ) {
			for (var i = 0; i < idroles.length; i++) {
				control.removeOption( idroles[i] );
			};
		} else{
			control.removeOption( idroles )
		};
	},
	cargarSelectServicios	: function () {
		var list = '<% _.each(servicios, function(servicio) { %> <option id="<%- servicio.id %>" value="<%- servicio.id %>"><%- servicio.nombre %></option> <% }); %>';
		this.$select_servicios.
		append( _.template(list)({ servicios : app.coleccionDeServicios }) );
		this.$select_servicios.selectize({
			valueField  : 'id',
			labelField  : 'title',
			searchField : 'title',
			maxItems    : 1,
			create      : function (value) {
				return {
					id 		:'nuevo_'+value,
					title 	:value
				}
			}
		});
	},
	cargarSelectEmpleados	: function () {
		var control = this.$select_empleados[0].selectize;
		control.clearOptions();
		control.addOption(function () {
	        var array = [],
	            empleado = app.coleccionEmpleados.toJSON();
	        
	        for (var i = 0; i < empleado.length; i++) {
	            array.push({
	                id      : empleado[i].id,
	                title   : empleado[i].nombre
	            });
	        };

	        return array;
	    }());
	},
	cargarSelectRoles			: function (filtro) {
		// clearOptions(), addOption(), setValue(); son 
		// funciones del plugin selectize
		var control = this.$select_rol[0].selectize,
			values  = this.$select_rol.val();
		control.clearOptions();
		control.addOption(function () {
	        var array = [],
	            roles = app.coleccionRoles.toJSON();
	        
	        for (var i = 0; i < roles.length; i++) {
	            array.push({
	                id      : roles[i].id,
	                title   : roles[i].nombre
	            });
	        };

	        return array;
	    }());
	    // [IMPORTANTE] si no ocurre la autoselección
	    // despues de actualizar los items utilize una
	    // función setTimeout con 10 ms como minimo.
	    if (filtro) {
	    	control.setValue( values );
	    };
	},
	actualizarItem 	: function () {
		// model contrandrá el rol más recientemente creado
		// tenga o no tenga valor, respaldamos los valores del select y
		// obtenemos el objeto control de selectize.
		var model 	= app.coleccionRoles.last(),
			control = this.$select_rol[0].selectize;
		
		control.setValue(model.get('id'));
	},
	cargarArchivoProy		: function (model) {
		var vista = new app.VAProyecto({ model:model });
		this.$tbody_archivos_subidos.append(vista.render().el);
	},
	cargarArchivosProy		: function () {
		var archivo = app.coleccionArchivos.where({idpropietario:this.model.get('id'), tabla:'proyectos'});
		for (var i = 0; i < archivo.length; i++) {
			this.cargarArchivoProy(archivo[i]);
		};
	},
/* Archivos nuevos */
	subirArchivo		: function (e) {
		app.contadorAlerta = this.$inputArchivos.prop('files').length;
		this.vistaArchivos.guardar(this.model);
		e.preventDefault();	
	},

	cargarPlugins 		: function () {
		var self = this;
		this.$select_empleados.selectize({
			valueField  : 'id',
			labelField  : 'title',
			searchField : 'title',
		});
		this.$select_rol.selectize({
			valueField  : 'id',
			labelField  : 'title',
			searchField : 'title',
			create      :  function (value) {
				// enviamos al servidor el nuevo rol
				Backbone.emulateHTTP = true;
				Backbone.emulateJSON = true;
				app.coleccionRoles.create({nombre:value},{
					wait:true,
					success:function (model) {
						// en el momento que el rol es creado
						// actualizamos en select del empleado,
						// realizamos esta operacion despues de
						// 10ms.
						setTimeout(function() {
							// No usamos listenTo a la coleccion
							// de roles porque escucha 2 veces el
							// evento add (por alguna razón!)
							self.cargarSelectRoles(true);
						}, 10);
						setTimeout(function() {
							self.actualizarItem();
						}, 20);
					},
					error 	: function (model) {
						error('Error al listar nuevo rol');
					}
				});
				Backbone.emulateHTTP = false;
				Backbone.emulateJSON = false;

				// necesariamente tenemos que retornar un id y un
				// title. en la funcion success de la creacion del 
				// rol se ejecuta la funcion actualizarItem para
				// usar datos correctos y no el que se retorna aquí.
				return {
					id:'nuevo',
					title:value
				}
			}
		});
		/* plugin Datepicker jQueryUI */
			this.$('.datepicker').datepicker({ 
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
				this.$( ".datepicker" ).on('change', function (e){
					/*Serializamos la fecha (fecha de inicio o final 
					segun el caso). Lo pasamos como parametro a la 
					función que  actualiza los atributos del modelo 
					proyecto*/
					self.actualizarAtributo( e );
					/*Creamos un array sobre la fecha seleccionada
					para volverla a mostrar en el input*/
					var fecha = $(this).val().split('-');
					/*Formateamos la fecha seleccionada a la forma 
					día/mes/año y la establecemos en el input*/
					$(this).val(fecha[2]+'/'+fecha[1]+'/'+fecha[0]);
				});
	},

	cerrarAlerta		: function (e) {
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
		$(e.currentTarget).parent().toggleClass('oculto');
	},
});