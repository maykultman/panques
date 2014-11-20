var app = app || {};
app.VistaContrato = app.VistaCotizacion.extend({
	obtenerVersiones	: function () {
		var original  = [],
			versiones = [];
		original = app.coleccionContratos.where({
			id:this.model.get('idcontrato')
		});
		if (original.length) {
			versiones = app.coleccionContratos.where({
				idcontrato:original[0].get('id'),visibilidad:'1'
			});
			this.cargarVersiones(original, versiones);
		} else {
			versiones = app.coleccionContratos.where({
				idcontrato:this.model.get('id')
			});
			if (versiones.length) {
				original = app.coleccionContratos.where({
					id:versiones[0].get('idcontrato'),visibilidad:'1'
				});
				this.cargarVersiones(original, versiones);
			};
		};
	},
	cambiarStatus		: function (e) {
		this.model.cambiarStatus();
		app.coleccionContratos
			.get($(e.currentTarget).val())
			.cambiarStatus();
	},
	cambiarVisibilidadVersion	: function (e) {
		e.preventDefault();
		var vista = new app.VistaCotizacion({
			model:app.coleccionContratos.get($(e.currentTarget).attr('id'))
		});
		vista.setElement($(e.currentTarget).parents('li'));
		vista.cambiarVisibilidad();
	},
	vistaPreviaVersion	: function (e) {
		e.preventDefault();
		var vista = new app.VistaCotizacion({
			model:app.coleccionContratos.get($(e.currentTarget).attr('id'))
		});
		vista.vistaPrevia();
	},
	cambiarVisibilidad : function () {
		var self = this;
		if (this.model.get('visibilidad') == '1') {
			confirmar('¿Está seguro de que desea eliminar el contrato <b>'
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
});

var VistaContratoEliminado = VistaCotizacionEliminada.extend();

var EdicionContrato = EdicionCotizacion.extend();

app.VistaConsultaContratos = app.VistaConsultaCotizaciones.extend({
	el 		: '#seccion_contratos',

	cargar 	: function (model, eliminado) {
		var vista;
		model.set({    
	 		cliente  : app.coleccionClientes. get ({ id : model.get( 'idcliente'  )} ).get('nombreComercial'),
	 		empleado : app.coleccionEmpleados.get ({ id : model.get( 'idempleado' )} ).get('nombre'),
			total    : function () {
				var modelos = app.coleccionServiciosContrato.where({idcontrato:model.get('id')}),
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
			vista = new VistaContratoEliminado({model : model});
		} else {
			vista = new app.VistaContrato({model : model});
		};
		vista.plantilla = _.template($('#tds_contrato').html());
		this.$tbodyContratos.append( vista.render().el);
	},
	obtenerActivos	: function () {
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
    eliminarVarios 				: function () {
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
												+error.toJSON().titulo+
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

// var app = app || {};
// app.VistaEdicionContrato = app.VistaNuevoContrato.extend({
// 	el 	: '#section_actualizar',
// 	// plantilla 	: _.template($('#form_contrato').html()),
// 	// render	: function () {
// 	// 	this.$el.html(this.plantilla( this.model.toJSON() ));
// 	// },
// 	establecerContrato	: function () {
// 		// console.log(this.model.toJSON()); //Imprime el json del contrato con datos añadidos
// 		/*Respandamos this para utilizar las funciones de la clase en
// 		  caso de que las funciones contengas funciones*/
// 			var here = this;
// 		/*Obtenemos y establecemos el nombre del cliente en el campo busqueda*/
// 			this.$('#busqueda')
// 				.val(	this.
// 						model.
// 						get('nombreComercial') );
// 			this.$('#hidden_idCliente')
// 				.val(	this.
// 						model.
// 						get('idcliente'));
// 		/*Obtenemos y establecemos el nombre del representante en el campo input_Representante*/
// 			this.$('#input_Representante')
// 				.val(	this.
// 						model.
// 						get('nombreRepresentante') );
// 			this.$('#hidden_idRepresentante')
// 				.val(	this.
// 						model.
// 						get('idrepresentante'));
// 		/*Obtenemos y establecemos la fecha final en el campo fechaFinal*/
// 			this.$('#fechaFirma')
// 				.val( formatearFechaUsuario(new Date(	
// 						this.
// 						model.
// 						get('fechafirma') ) ) );
// 		/*Obtenemos y establecemos el titulo del contrato en el campo text_titulocontrato*/
// 			this.$('#text_titulocontrato')
// 				.val(	this.
// 						model.
// 						get('titulocontrato') );
// 		/*Obtenemos y establecemos la fecha de firma del contrato en el campo hidden_fechafirma*/
// 			this.$('#hidden_fechafirma')
// 				.val(	this.
// 						model.
// 						get('fechafirma') );
// 		/*Establecemos el id del empleado que creo el contrato. LUEGO TOMARA LA SESION DEL QUE EDITA EL CONTRATO*/
// 			this.$('#hidden_idEmpleado')
// 				.val(	this.
// 						model.
// 						get('idempleado'));
// 		this.$('#'+this.model.get('plan')).click();
// 		/*----------------------------------------------------------*/
// 		/*Cargamos los servicios cada vez que se cliquee en el boton
// 		  editar del contrato, para distinguir los servicios que ha 
// 		  seleccionado*/
// 		  	//La funcion tambien limpia la lista de servicios
// 			this.cargarServicios();
// 		/*Limpiamos la tabla de servicios que seleccione el cliente y
// 		  con los que cuenta el contrato*/
// 			this.$('#tbody_servicios_seleccionados').html('');
// 		/*Filtramos la coleccion de servicios contratados para mostrar
// 		  en pantalla todos aquellos que estes relacionados con el
// 		  contrato de esta vista*/
// 			_.filter(app.coleccionServiciosContrato.models, function (model) {
// 				if (model.get('idcontrato') == here.model.get('id')){
// 					here.apilarServicioContratado(model);
// 				}
// 			});
// 		/*----------------------------------------------------------*/
// 		if (this.model.get('plan') == 'evento') {
// 			this.$('.input_fechaInicioPago')
// 				.first().val( formatearFechaUsuario(new Date(this.model.get('fechainicio'))) ).trigger('change');
// 			this.$('.n_pagos')
// 				.first().val(this.model.get('nplazos')).trigger('change');
// 		};
// 		if (this.model.get('plan') == 'iguala') {
// 			this.$('.input_fechaInicioPago')
// 				.last().val( formatearFechaUsuario(new Date(this.model.get('fechainicio'))) ).trigger('change');
// 			this.$('.n_pagos')
// 				.last().val(this.model.get('nplazos')).trigger('change');
// 			this.$('#text_mensualidad').val( this.model.get('mensualidadletras') );
// 		};
// 		/*----------------------------------------------------------*/
// 		/*Asigna la nueva versión*/
// 			this.$('#version').val( parseInt(this.model.get('version')) + 1 );
// 	},
// 	/*[polimorfismo] Reescribimos la funcion.
// 	  Mismo procedimientos pero adaptado al historial de contratos*/
// 	apilarServicioContratado		: function (model) {
// 		var servicio = app.coleccionServicios.get({id:model.get('idservicio')});

// 		model.set({
// 			idserv 	: servicio.get('id'),
// 			nombre	: servicio.get('nombre'),
// 			total	: 	( 	/* ( precio - ( (precio x descuento)/100 ) ) * cantidad */ 
// 							(
// 								( model.get('precio') ) - (
// 									( model.get('precio') * model.get('descuento') ) / 100
// 								)
// 							) * model.get('cantidad')
// 						).toFixed(2)
// 		});

// 		var vista = new app.VistaServicioSeleccionado({ model:model });
// 		this.$('#tbody_servicios_seleccionados').append(vista.render().el);
// 																			/*ELIMINAR LA FUNCION parents() Y css()*/
// 		this.$( '#servicio_'+model.get('idservicio') ).attr('disabled',true);
// 		vista.calcularImporteIVATotalNeto();
// 	},
// 	/*[polimorfismo] Reescribimos la funcion.*/
// 	confirmarContratoGuardado	: function () {
// 		alerta('El contrato se ha actualizado con exito',function (){
// 			$('.visiblito').toggleClass('ocultito');
// 			/*escroleamos hacia arriba autimaticamente*/
// 			window.scrollTo(0,0);
// 		});
// 	},
// 	/*[polimorfismo] Reescribimos la funcion para no redireccionar al
// 	  mismo modulo historial.*/
// 	cancelar	: function () {/**/},
// });
// app.VistaContrato = Backbone.View.extend({
// 	tagName	: 'tr',
// 	plantilla : _.template($('#plantilla_tr_contrato').html()),
// 	plantillaModal	: _.template($('#plantilla_modal').html()),
// 	events	: {
// 		'click #eliminar'		: 'eliminar',
// 		'click #tr_btn_verInfo'	: 'verInfo',
// 		'click .tr_btn_editar'	: 'editar',
		
// 	},
// 	initialize	: function () {
// 		this.listenTo(this.model, 'destroy', this.remove);
// 	},
// 	render		: function () {
// 		this.$el.html(this.plantilla( this.model.toJSON() ));
// 		return this;
// 	},
// 	verInfo		: function (elem) {
// 		var thiS = this;
// 		this.$el.append( this.plantillaModal(this.model.toJSON()) );
// 	},
// 	editar 		: function () {
// 		vista = new app.VistaEdicionContrato({model:this.model});
// 		vista.establecerContrato();
// 		// $('#section_actualizar').css({'position':'absolute'}).show( 'slide', 2000 ,function () {
// 		// 	$('#section_actualizar').css({'position':'initial'});
// 		// });
		
// 		// $('#posicion_infotd').css({'position':'absolute'}).hide( 'slide',{direction:'right'}, 2000, function () {
// 		// 	$('#posicion_infotd').css({'position':'initial'});
// 		// });
// 	},
// 	eliminar	: function () {
// 		this.model.destroy({
// 			wait	: true,
// 			success	: function (model, response) {
// 				console.log(response.responseText);
// 			},
// 			error	: function (model, response) {
// 				console.log(response.responseText);
// 			}
// 		});
// 	},
// });

// app.VistaConsultaContrato = Backbone.View.extend({
// 	el	: '#posicion_infotd',
// 	events	: {
// 		'click #buscarCliente'  : 'busqueda',
// 		'keyup #buscarCliente'  : 'borrayRenderiza',
// 		'click #buscarEmpleado' : 'busqueda',
// 		'keyup #buscarEmpleado' : 'borrayRenderiza',
// 		'click #todos'	        : 'marcarTodosCheck',
// 		'click .abajo'    		: 'ordenarporfecha',
// 		'click .arriba'   		: 'ordenarporfecha'
// 	},
// 	initialize	: function () {
// 		this.$tbody_contratos = $('#tbody_contratos');
// 		this.cargarContratos();
// 		this.listenTo( app.coleccionContratos, 'add', this.cargarContrato );
// 		this.listenTo( app.coleccionContratos, 'reset', this.cargarContratos );

// 		// this.listenTo( app.coleccionServiciosContrato, 'add', this.resetearSerContr );
// 		// this.listenTo( app.coleccionPagos, 'add', this.resetearPagos );


// 	},
// 	render		: function () {},
// 	// resetearSerContr	: function () {
// 	// 	app.coleccionServiciosContrato.fetch();
// 	// 	console.log('Se reseteo la coleccion de servicios de contratos');
// 	// },
// 	// resetearPagos	: function () {
// 	// 	app.coleccionPagos.fetch();
// 	// 	console.log('Se reseteo la coleccion de pagos');
// 	// },
// 	cargarContrato	: function (contrato) {
// 		contrato.set({
// 			nombreComercial:app.coleccionClientes.get({
// 				id:contrato.get('idcliente')
// 			}).get('nombreComercial'),
// 			nombreRepresentante:app.coleccionRepresentantes.get({
// 				id:contrato.get('idrepresentante')
// 			}).get('nombre'),
// 			nombreEmpleado:app.coleccionEmpleados.get({
// 				id : contrato.get('idempleado')
// 			}).get('nombre')
// 		});
// 		var vista = new app.VistaContrato({model:contrato});
// 		this.$tbody_contratos.append(vista.render().el);
// 	},
// 	cargarContratos	: function () {
// 		this.$tbody_contratos.html('');
// 		app.coleccionContratos.each(this.cargarContrato, this);
// 	},

// 	ordenarporfecha : function(fecha)
// 	{ 
// 		ordenar(fecha, app.coleccionContratos, app.coleccionDeContratos);
// 	},
	
// 	busqueda : function(elemento)
// 	{
// 		// input de busqueda, this, coleccion, tabla donde se renderizara el modelo
// 		autocompleteGenerico(elemento, this, app.coleccionContratos, this.$tbody_contratos);
// 	},	
	
// 	borrayRenderiza	: function (e) 
//     {
// 		if(e.keyCode===8)
//           {
//           	this.$tbody_contratos.html('');
//             this.cargarContratos();
//           }
// 	},
// 	marcarTodosCheck : function(elemento)
//     {        
//         marcarCheck(elemento);
//     },
// });

// app.VistaGeneral = Backbone.View.extend({
// 	el 		: '.contenedor_principal_modulos',
// 	events	: {
// 		'click .tr_btn_editar'	: 'editar',
// 		'click #btn_calcelar'	: 'cancelar'
// 	},
// 	editar 		: function () {
// 		$('.visiblito').toggleClass('ocultito');
// 	},
// 	cancelar	: function () {
// 		$('.visiblito').toggleClass('ocultito');
// 		window.scrollTo(0,0);
// 	},
// });

// app.vistaGeneral = new app.VistaGeneral();

// app.vistaConsultaContrato = new app.VistaConsultaContrato();