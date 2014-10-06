var app = app || {};

app.VistaNuevoCliente = Backbone.View.extend({
	el      : '.contenedor_modulo',

	events  : 
		{
					//Eventos de consulta
					'keyup #inputBusquedaI' : 'buscarServicioI',
					'keyup #inputBusquedaC' : 'buscarServicioC',
					 'change .tipo_cliente' : 'obtenerTipoCliente',

					//Eventos de eliminación
					'click  #btn_eliminar'  : 'eliminarTodos_Prueba',
				 'click  .eliminarCopia'    : 'eliminarCopia', //Para eliminar los telefonos que se van listando
				'click  .eliminarContacto'  : 'eliminarContacto', // Evento para el icono (boton) eliminar contacto.
					'click .icon-uniF470'   : 'quitarDeLista',

					//eventos para mostrar informacion
				'keypress #inputBusquedaI'  : 'agregarNuevoServ',
					 'click #btn_agregarI'  : 'agregarNuevoServBoton',
				'keypress #inputBusquedaC'  : 'agregarNuevoServ',
					 'click #btn_agregarC'  : 'agregarNuevoServBoton',
					
					// Eventos para registro de clientes y contactos
				'click  #btn_crear'         	: 'nuevoCliente',
				'click  #btnCancelar_cliente'	: 'cancelarRegistro',
				'click  #btnCancelar_contacto'	: 'cancelarRegistro',
				'click  #btn_guardarContactos' 	: 'nuevoContacto',
				'click  .otroTelefono'      	: 'otroTelefono',
				// 'click   #btn_otroContacto'  : 'otroContacto',
				'change #formularioFoto'       	: 'obtenerFoto',

					/*Las funciones para validar se ejecutan cuando 
					se hace blur a los elementos html con el id o class 
					especificados*/
					  'blur #email'         : 'validarCorreo',
					'blur .telefonoCliente' : 'validarTelefono',
					 'blur #paginaCliente'  : 'validarPaginaWeb',
				'blur #contactoEmail'       : 'validarCorreo',
				'blur .telefonoContacto'    : 'validarTelefono',
				'blur #emailRepresentante'  : 'validarCorreo',
			'blur .telefonoRepresentante'   : 'validarTelefono',
			// 'blur #otroContactoEmail'        : 'validarCorreo',

			'keyup #rfc'    : 'validarRFC',

			'click #toggle' : 'toggle'
		},
// -----initialize-------------------------------- 
	initialize      : function () {
	// Datos básicos
		this.tipoCliente          = '';
		this.$nombreFiscal        = $('#nombreComercial');
		this.$nombreComercial     = $('#nombreFiscal');
		this.$email               = $('#email');
		this.$rfc                 = $('#rfc');
		this.$paginaWeb           = $('#paginaCliente');
		this.$giro                = $('#giro');
		this.$direccion           = $('#txtareaDireccion');
		this.$logoCliente         = $('#logoCliente');
		this.$comentarioCliente   = $('#comentarioCliente');
		this.$foto                = $("#direccion");

	// Datos especificos
		this.$nombreRepresentante = $('#nombreRepresentante');
		this.$correoRepresentante = $('#emailRepresentante');
		this.$cargoRepresentante  = $('#cargoRepresentante');
		this.$telefonoRepresentante = $('.telefonoRepresentante');
		this.$tipoTelefonoRepresentante = $('.tipoTelefonoRepresentante');

	// selectores de servicios de interes y actuales
		this.$menuServicios   = $('.menuServicios');
		this.cargarServicios();

	// Intancias
		this.vistaTelefono = new app.VistaTelefono();

	// variables
		this.contadorContactos = 1;
	},
// -----render------------------------------------ 
	render          :               function () {
		return this;
	},
	cancelarRegistro		: 		function (e) {
		var here = this;
		e.preventDefault();
		var cancelarQue = $(e.currentTarget).attr('id').split('_');
		confirmar('¿Deseas cancelar el registro del '+cancelarQue[1]+'?', function () {
			cancelarQue = here.$('.tipo_cliente:checked').attr('id');
			if (cancelarQue) {
				location.href = 'consulta_'+cancelarQue+'s';
			} else {
				location.href = 'consulta_clientes';
			};
		}, function () {});
	},
// -----agregarNuevoServ-------------------------- 
	agregarNuevoServ    :           function (json) {
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		app.coleccionServicios.create( json ,{
			wait:true,
			success : function (exito) {
				console.log('exito: ',exito);
			},
			error   : function (error, respuesta) {
				console.log('error: ',respuesta);
			}
		});
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	},
// -----cargarServicios--------------------------- 
	cargarServicios     :           function () {
		var list = '<% _.each(servicios, function(servicio) { %> <option id="<%- servicio.id %>" value="<%- servicio.id %>"><%- servicio.nombre %></option> <% }); %>';
		this.$menuServicios.
		append(_.template(list, 
			{ servicios : app.coleccionServicios.toJSON() }
		));
		this.$menuServicios.selectize({
			// persist: false,
			createOnBlur: true,
			create: true
		});
	},
// -----eliminarCopia----------------------------- 
	eliminarCopia   :               function (elemento) {
		/*Función para eliminar telefonos. Recibe como parametro un objeto del DOM
		pasado como parametro por el evento que descencadena la ejecución de
		esta función. este objeto se utiliza como referencia para encontrar al elemento
		más cercano con el atributo class "copia" para luego removerlo del DOM.*/
		if ($(elemento.currentTarget).parents('.telefonos').children('.div_telefono').length != 1) {
			$(elemento.currentTarget).parents('.div_telefono').remove();
		};
	},
// -----nuevoContacto----------------------------- 
	nuevoContacto   :               function () {
		$('#btn_otroContacto').click();
		$($('.tab-content').children()[$('.tab-content').children().length -2]).toggleClass('active');
		$($('.pagination-ms').children()[$('.pagination-ms').children().length -2]).toggleClass('active');
		$($('.tab-content').children()[$('.tab-content').children().length -1]).remove();
		$($('.pagination-ms').children()[$('.pagination-ms').children().length -1]).remove();

		var here = this;

		/*Se activan las dos variables globales de Backbone para
		  mandar de manera correcta el POST de contactos. Antes de finalizar
		  esta función se desactivarán estas dos variables globales
		  para que no afecte otras funciónes.*/
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		/*Para registrar a un representante debe cumplirse quelo
		  elementosdel html que apuntan los selectores no esten vacios*/
		var nombreR = this.$nombreRepresentante.val().trim(),
			correoR = this.$correoRepresentante.val().trim(),
			cargoR = this.$cargoRepresentante.val().trim(),
			telefonoR = this.$telefonoRepresentante.serializeArray(),
			tipoTelfR = this.$tipoTelefonoRepresentante.serializeArray();
		if (nombreR
			&& correoR
			&& cargoR
		){
			$('.btn, input, textarea, select').attr('disabled',true);
			app.coleccionRepresentantes.create(
				this.nuevosAtributosContacto(
					nombreR,
					correoR,
					cargoR
				),{
					wait:true,
					success : function (exito) {
						/*console.log('exito: ',exito.toJSON());*/ /* NO ELIMINAR ESTAS LINEAS */
						here.vistaTelefono.crear({
							idpropietario   : exito.get('id'),
							tabla           : 'representantes',
							numero          : pasarAJson(telefonoR).numero,
							tipo            : pasarAJson(tipoTelfR).tipo
						});
						/*-----*/
						if (app.contactosLocal.length == 0) {
							alerta('¡El representante ha sido guardado!', function () {
								localStorage.clear();
							});
							$(document.getElementsByTagName('body')).find('#alertify-ok').on('click',function(){
								location.href = 'consulta_'+here.objetoCliente.tipoCliente+'s';
							});
							$('.btn, input, textarea, select').attr('disabled',false);
						};
					},
					error   : function (error, respuesta) {
						confirmar('Ocurrio un error al intentar guardar los contactos<br><b>¿Deseas volver a intentarlo?</b>', 
							function () {
								$('.btn, input, textarea, select').attr('disabled',false);
							}, 
							function () {
								location.href = 'consulta_'+here.objetoCliente.tipoCliente+'s';
							});
						if (app.contactosLocal.length) {
							return; //Terminamos la secuencia de la function nuevoContacto
						};
						/*console.log('error: ',respuesta);*/ /* NO ELIMINAR ESTAS LINEAS */
					}
				}
			);
		};
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
		/*--------------------*/
		if (app.contactosLocal.length) {
			$('.btn, input, textarea, select').attr('disabled',true);
			/*console.log('hay contactos');*/ /* NO ELIMINAR ESTAS LINEAS */
			app.contactosLocal.each(function (model) {
				/*console.log(model.toJSON());*/ /* NO ELIMINAR ESTAS LINEAS */
				here.guardarC(
					{
						cargo       : model.get('cargo'),
						correo      : model.get('correo'),
						idcliente   : model.get('idcliente'),
						nombre      : model.get('nombre')
					},
					model.get('id')
				);
			},this);
		};
	},
	guardarC    :                   function (jsonC,iT) {
		var here = this;
		/*console.log(jsonC,iT);*/ /* NO ELIMINAR ESTAS LINEAS */
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		app.coleccionContactos.create(jsonC,{
			wait    : true,
			success : function (modelC) {
				/*console.log('Se a guardando el contacto: ', modelC.get('nombre'), iT);*/ /* NO ELIMINAR ESTAS LINEAS */
				app.telefonosLocal.each(function (modelT) {
					if (modelT.get('id') == iT) {
						/*console.log(modelC.get('nombre') + ' Tiene telefonos');*/ /* NO ELIMINAR ESTAS LINEAS */
						here.guardarT({
							idpropietario   : modelC.get('id'),
							tabla           : modelT.get('tabla'),
							numero          : modelT.get('numero'),
							tipo            : modelT.get('tipo')
						});
					};
				},this);
				
				/*-----*/
				if (here.aumentarContadorContactos() == app.contactosLocal.length) {
					/*console.log('entro al if');*/ /* NO ELIMINAR ESTAS LINEAS */
					alerta('¡Contactos guardados!', function () {
						localStorage.clear();
					});
					$(document.getElementsByTagName('body')).find('#alertify-ok').on('click',function(){
						location.href = 'consulta_'+here.objetoCliente.tipoCliente+'s';
					});
					$('.btn, input, textarea, select').attr('disabled',false);
				};
			},
			error   : function (model) {
				/*console.log('Error guardando contacto: ', model.toJSON());*/ /* NO ELIMINAR ESTAS LINEAS */
				if (here.aumentarContadorContactos() == app.contactosLocal.length) {
					confirmar('Ocurrio un error al intentar guardar los contactos<br><b>¿Deseas volver a intentarlo?</b>', 
						function () {
							$('.btn, input, textarea, select').attr('disabled',false);
						}, 
						function () {
							location.href = 'consulta_'+here.objetoCliente.tipoCliente+'s';
						});
				};
			}
		});
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	},
	guardarT    :                   function (jsonTelefono) {
		this.vistaTelefono.crear(jsonTelefono);
	},
	aumentarContadorContactos   :   function () {
		return this.contadorContactos++;
	},
// -----nuevoCliente------------------------------ 
	nuevoCliente    :               function (evento) {
		/*Se ejecuta la funcion nuevosAtributosCliente que
		  tras terminar devuelve un json el cual es
		  almacenado en la variable objetoCliente*/
		this.objetoCliente = limpiarJSON(this.nuevosAtributosCliente());
		console.log('Antes del elvio',this.objetoCliente);

		/*Nos aseguramos de que las propiedades nombreComercial y tipoCliente
		  del objeto esten definidas. De lo contrario se alerta al usuario y
		  la creación del cliente no procede*/
		if (!this.objetoCliente.nombreComercial || !this.objetoCliente.tipoCliente){
			alerta('Establezca el tipo de cliente y un nombre de cliente',function (){});
			return;
		}

		if (this.$('#logoCliente').val() != '') {
			this.objetoCliente.foto = urlFoto();
		} else{
			this.objetoCliente.foto = 'img/sinfoto.png';
		};
		/*console.log(this.objetoCliente);*/ /* NO ELIMINAR ESTAS LINEAS */
		/*Guardamos la referencia a this para poder usarla en las
		  funciones dentro de esta función*/
		var here = this;

		var numero = pasarAJson($('.telefonoCliente').serializeArray()).numero,
			tipo = pasarAJson($('.tipoTelefonoCliente').serializeArray()).tipo,
			serviciosInteres = $(document.getElementsByName('serviciosInteres[]')).val(),
			serviciosCuenta = $(document.getElementsByName('serviciosCuenta[]')).val();

		$('.btn, input, textarea, select').attr('disabled',true);

		/*Se activan las dos variables globales de Backbone para
		  mandar de manera correcta el POST de contactos. Antes de finalizar
		  esta función se desactivarán estas dos variables globales
		  para que no afecte otras funciónes.*/
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		/*Se pasa la variable objetoCliente como primer parametro en la función
		  create de la colección de clientes. La propiedad success del segundo
		  parametro espera la respuesta del servidos tras almacenar los datos
		  del cliente de manera exitos, de lo contrario la funcion de de la
		  propiedad success no procedera para mostrar el formulario para el
		  registro de contactos y representante.*/
		app.coleccionClientes.create(this.objetoCliente,
			{
				wait:true,
				success : function(exito){
					// Muestra el nombre comercial del cliente el el siguente formulario
					$('#span_nombreCliente').html(exito.get('nombreComercial'));
					/*Guardar teléfonos*/
						here.vistaTelefono.crear({
							idpropietario   : exito.get('id'),
							tabla           : 'clientes',
							numero          : numero,
							tipo            : tipo
						});
					console.log('Despues del elvio',exito);	
					/*Guardar servicios de interes y cuenta*/
						// Obtenemos los servicios (existentes en la o no BD)
						var servicios       = serviciosInteres,
						// Obtenemos array de servicios existentes
							servPluck   = app.coleccionServicios.pluck('id'),
						// Aislamos los servicios nuevos (es un array)
							servNuevo   = _.difference( _.union( servicios,servPluck ),servPluck ),
						// Aislamos los servicios existentes en la DB
							servExiste  = _.difference( servicios,servNuevo ),
							status = [];
						if (servNuevo[0] != null) {
							/*if (servNuevo.length > 1) {*/
								for (var i = servNuevo.length - 1; i >= 0; i--) {
									status.push(true);
								};
								here.agregarNuevoServ({
									idcliente:exito.get('id'),
									serviciosinteres:'serviciosinteres',
									nombre:servNuevo,
									status:status
								});/*
							} else{
								here.agregarNuevoServ({
									idcliente:exito.get('id'),
									serviciosinteres:'serviciosinteres',
									nombre:servNuevo[0],
									status:1
								});
							};*/
						};
						status = [];
						if(servExiste.length > 0){
							if (servExiste.length == 1) {
								here.guardarServiciosI(exito.get('id'),servExiste[0]);
							} else{
								here.guardarServiciosI(exito.get('id'),servExiste);
							};
						};

						servicios   = serviciosCuenta,
						servNuevo   = _.difference( _.union( servicios,servPluck ),servPluck ),
						servExiste   = _.difference( servicios,servNuevo );

						if (servNuevo[0] != null) {
							/*if (servNuevo.length > 1) {*/
								for (var i = servNuevo.length - 1; i >= 0; i--) {
									status.push(true);
								};
								here.agregarNuevoServ({
									idcliente:exito.get('id'),
									servicioscuenta:'servicioscuenta',
									nombre:servNuevo,
									status:status
								});/*
							} else{
								here.agregarNuevoServ({
									idcliente:exito.get('id'),
									servicioscuenta:'servicioscuenta',
									nombre:servNuevo[0],
									status:1
								});
							};*/
						};
						if(servExiste.length > 0){
							if (servExiste.length == 1) {
								here.guardarServiciosC(exito.get('id'),servExiste[0]);
							} else{
								here.guardarServiciosC(exito.get('id'),servExiste);
							};
						};
						
					confirmar(
						'<p>¡El cliente ha sido guardado con exito!</p><p><b>¿Deseas registrar al <b>representante</b> o <b>contactos</b> del cliente?</b></p>',
						function (){
							here.$('.visibleR').toggleClass('ocultoR');
							window.scrollTo(0,0);
						},
						function () {
							location.href = 'consulta_'+here.objetoCliente.tipoCliente+'s';
						});
						$('.btn, input, textarea, select').attr('disabled',false);
				},
				error   : function () {
					confirmar('Ocurrio un error al intentar registrar al cliente<br><b>¿Desea volver a intentelo?</b>',
						function () {
							$('.btn, input, textarea, select').attr('disabled',false);
						},
						function () {
							location.href = 'consulta_'+here.objetoCliente.tipoCliente+'s';
						});
				}
			}
		);
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;

		evento.preventDefault();
	},
// -----guardarServiciosI------------------------- 
	guardarServiciosI   :           function (idcliente,idservicios) {
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		// if (idservicio) {
			// if (idservicio.length > 0) {
				// for (var i = 0; i < idservicio.length; i++) {
					app.coleccionServiciosClientesI.create({
						idcliente:idcliente,
						idservicio:idservicios
					},{
						wait:true,
						success : function (exito) {
							/*console.log('exito: ', exito);*/ /* NO ELIMINAR ESTAS LINEAS */
						},
						error   : function (error, respuesta) {
							/*console.log('error: ', respuesta);*/ /* NO ELIMINAR ESTAS LINEAS */
						}
					});
				// };
			// }
		// }
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	},
// -----guardarServiciosC------------------------- 
	guardarServiciosC   :           function (idcliente,idservicios) {
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		// if (idservicio) {
			// if (idservicio.length > 0) {
				// for (var i = 0; i < idservicio.length; i++) {
					app.coleccionServiciosClientesC.create({
						idcliente:idcliente,
						idservicio:idservicios
					},{
						wait:true,
						success : function (exito) {
							/*console.log('exito: ', exito);*/ /* NO ELIMINAR ESTAS LINEAS */
						},
						error   : function (error, respuesta) {
							/*console.log('error: ', respuesta);*/ /* NO ELIMINAR ESTAS LINEAS */
						}
					});
				// };
			// }
		// }
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	},
// -----nuevosAtributosContacto------------------- 
	nuevosAtributosContacto :       function (nombre,correo,cargo) {
		/*Los valores de los parametros se especifican en el lugar en 
		donde es ejecutada esta función*/
		return {
			idcliente : app.coleccionClientes.obtenerUltimo().get('id'),
				 // tipo : tipo,
			   nombre : nombre,
			   correo : correo,
				cargo : cargo
		}
	},
// -----nuevosAtributosCliente-------------------- 
	nuevosAtributosCliente  :       function () {
		/*Los valores de cada propiedad se obtienen directamente
		de los campos del html donde los selectores apuntan.*/
		return {
			 nombreComercial : this.$nombreFiscal.val().trim(),
				nombreFiscal : this.$nombreComercial.val().trim(),
					  email  : this.$email.val().trim(),
						 rfc : this.$rfc.val().trim(),
				   paginaWeb : this.$paginaWeb.val().trim(),
						giro : this.$giro.val(),
		   comentarioCliente : this.$comentarioCliente.val().trim(),
				   direccion : this.$direccion.val().trim(),
				 tipoCliente : this.tipoCliente,
				   // telefonos : this.recursividadTelefonos(document.getElementsByName('telefonoCliente'),document.getElementsByName('tipoTelefonoCliente')),
			// serviciosInteres : this.obtenerServicios(document.getElementsByName('serviciosInteres')),
			 // serviciosCuenta : this.obtenerServicios(document.getElementsByName('serviciosCuenta')),
						// foto : this.urlFoto()
		}
	},
// -----obtenerTipoCliente------------------------ 
	obtenerTipoCliente  :           function (elemento) {
		/*currentTarget obtiene el elemento html,
		  este se utiliza como selector para obtener
		  el valor del elemento seleccionado; en este
		  caso el TIPO de cliente a registrar*/
		this.tipoCliente = $(elemento.currentTarget).val();
	},
// -----obtenerFoto------------------------------- 
	obtenerFoto :                   function (e) {
		obtenerFoto(e);
	},
// -----otroTelefono------------------------------ 
	otroTelefono    :               function (elemento) {
		/*Esta función se ejecuta su evento asociado
		pasandole como parametro un objeto del DOM.
		Este elemento DOM sirve como referencia para
		obtener html y encajarla en nuevo html. Al final
		el nuevo html se imprime el una lista de teléfonos.*/
		this.$(elemento.currentTarget).parents('.telefonos').prepend('<div class="div_telefono">'+this.$(elemento.currentTarget).parent().parent().parent().parent().html()+'</div>');
		/*Se añade en el atributo class un nuevo nombre donde 
		apunta el selector*/
		$('.copia .icon-uniF476').removeClass().addClass('icon-uniF477 eliminarCopia'); 
		/*Primero se elimina y luego se añade un nuevo nombere 
		en el atributo class del elemento donde apunta el selector*/
		$('.copia .otroTelefono').removeClass().addClass('btn btn-default eliminarCopia'); 
		this.$telefonoRepresentante = $('.telefonoRepresentante');
		this.$tipoTelefonoRepresentante = $('.tipoTelefonoRepresentante');
	},
// -----obtenerServicios-------------------------- 
	obtenerServicios    :           function (servicio) {
			var arreglo = new Array();
			var cont = 0;

			for (var i = 0; i < servicio.length; i++) {
				if ($(servicio[i]).is(':checked')) {
					arreglo[cont] = $(servicio[i]).val();
					cont++;
				}
			};

			/*if (arreglo.length == 1) {
				return arreglo[0];
			} else */if (arreglo.length == 0) {
				return '';
			} else {
				return arreglo;
			};
	},
// -----recursividadArchivos---------------------- 
	recursividadArchivos    :       function (archivo,tipo,comentario) {
		if (comentario.length > 1) {
			var arreglo = new Array();
				for (var i = 0; i < comentario.length; i++) {
				arreglo[i] = this.recursividadArchivos(archivo[i],tipo[i],comentario[i]);
			};

			return arreglo;

		} else{
			var objetoArchivo = {};
			objetoArchivo.nombre = $(archivo).val().trim();
			objetoArchivo.tipo = $(tipo).val();
			objetoArchivo.comentario = $(comentario).val().trim();
			return jQuery.parseJSON(JSON.stringify(objetoArchivo));
		};
	},
// -----validarCorreo----------------------------- 
	validarCorreo   :               function (elemento) {
		if( !(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(elemento.currentTarget).val().trim())) && $(elemento.currentTarget).val().trim() != '' ) {
			alerta('No es un correo valido',function () {});
			$(document.getElementsByTagName('body')).find('#alertify-ok').on('click',function(){
				$(elemento.currentTarget).focus();
			});
			$(elemento.currentTarget).css('border-color','#a94442');
			return false;
		} else{
			$(elemento.currentTarget).css('border-color','#CCC');
			return true;
		};
	},
//------validarTelefono--------------------------- 
	validarTelefono :               function (elemento) {
		// if(isNaN($(elemento.currentTarget).val().trim()) && $(elemento.currentTarget).val().trim() != '' ) {
		if(!(/^\d{10,20}$/.test($(elemento.currentTarget).val().trim())) && $(elemento.currentTarget).val().trim() != '' ) {
			alerta('No ingrese letras u otros símbolos<br>Establezca un tipo de teléfono<br>Escriba 10 números como mínimo o 20 como máximo',function () {});
			$(document.getElementsByTagName('body')).find('#alertify-ok').on('click',function(){
				$(elemento.currentTarget).focus();
			});
			$(elemento.currentTarget).css('border-color','#a94442');
			return false;
		} else{
			$(elemento.currentTarget).css('border-color','#CCC');
			$(elemento.currentTarget).next().children('select').focus();
			return true;
		};
	},
//------validarPaginaWeb-------------------------- 
	validarPaginaWeb    :           function (elemento) {
		if (!($(elemento.currentTarget).val().trim().match(/^[a-z0-9\.-]+\.[a-z]{2,4}/gi)) && $(elemento.currentTarget).val().trim() != '' ) {
			alerta('La dirección de la página web no es correcta',function () {});
			$(document.getElementsByTagName('body')).find('#alertify-ok').on('click',function(){
				$(elemento.currentTarget).focus();
			});
			$(elemento.currentTarget).css('border-color','#a94442');
			return false;
		} else{
			$(elemento.currentTarget).css('border-color','#CCC');
			return true;
		};
	},
	// cerrarAlerta : function () {
	//  $('#error').toggleClass('oculto');
	// },
// -----validarRFC-------------------------------- 
	validarRFC  :                   function (elem) {
		validarRFC(elem);
	},


// -----Funciones para realizar pruebas-----------
	toggle : function () {
		this.$('.visibleR').toggleClass('ocultoR');
	},
});

app.vistaNuevoCliente = new app.VistaNuevoCliente();

// function showMessage (message) {
//     $("#mensajeFoto").html("").show();
//     $("#mensajeFoto").html(message);
// }
//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
// function isImage (extension) {
//     switch(extension.toLowerCase()) 
//     {
//         case 'jpg': case 'gif': case 'png': case 'jpeg':
//             return true;
//         break;
//         default:
//             return false;
//         break;
//     }
// }

// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------

app.ModeloContactoLocal = Backbone.Model.extend({});
app.ModeloTelefonoLocal = Backbone.Model.extend({});
var ContactosLocal = Backbone.Collection.extend({
	model           : app.ModeloContactoLocal,
	localStorage    : new Backbone.LocalStorage('contactos-backbone'),
	idSiguiente   : function () {
		if(!this.length){
			return 1;
		}
		return this.last().get('id') + 1;
	}
});
app.contactosLocal = new ContactosLocal();
var TelefonosLocal = Backbone.Collection.extend({
	model           : app.ModeloTelefonoLocal,
	localStorage    : new Backbone.LocalStorage('telefonos-backbone'),
	idSiguiente   : function () {
		if(!this.length){
			return 1;
		}
		return this.last().get('id') + 1;
	}
});
app.telefonosLocal = new TelefonosLocal();
app.VistaContacto = Backbone.View.extend({
	events      : {
		'keyup #contactoNombre'         : 'actualizarContacto',
		'keyup #contactoEmail'          : 'actualizarContacto',
		'keyup #contactoCargo'          : 'actualizarContacto',
		'keyup .telefonoContacto'       : 'actualizarTelefono',
		'change .tipoTelefonoContacto'  : 'actualizarTelefono',
		'click .eliminarCopiaC'         : 'eliminarCopia',
		'click #eliminar'               : 'eliminar'
	},
	initialize  : function () {
		this.listenTo(this.model, 'destroy', this.remove);
		app.telefonosLocal.fetch();
	},
	actualizarContacto  : function () {
		this.model.save({
			nombre  : this.$('#contactoNombre').val().trim(),
			correo  : this.$('#contactoEmail').val().trim(),
			cargo   : this.$('#contactoCargo').val().trim(),
		},{
			wait    : true,
			success : function (model) {
				// console.log('Actualizado: ',model.toJSON());
			},
			error   : function (model) {
				// console.log('Error actualizando contacto');
			}
		});
	},
	actualizarTelefono  : function () {
		app.telefonosLocal.findWhere({ idpropietario:this.model.get('id') }).save({
			numero  : pasarAJson(this.$('.telefonoContacto').serializeArray()).numero,
			tipo    : pasarAJson(this.$('.tipoTelefonoContacto').serializeArray()).tipo
		},{
			wait    : true,
			success : function (model) {
				// console.log('Telefonos actualizados: ',model.toJSON());
			},
			error   : function (model) {
				// console.log('Error al actualizar telefonos');
			}
		});
	},
	eliminarCopia       : function (elemento) {
		if ($(elemento.currentTarget).parents('.telefonos').children('.div_telefono').length != 1) {
			$(elemento.currentTarget).parents('.div_telefono').remove();
			this.actualizarTelefono();
		};
	},
	eliminar            : function () {
		var here = this;
		confirmar('¿Estas seguro de eliminar el contacto?', function () {
			if ((parseInt(here.model.get('id')) +1) == app.contactosLocal.idSiguiente() && $('.tab-content').children().length == 1) {
				$('.tab-content').children()[$('.tab-content').children().length -1].remove();
				$('.pagination-ms').children()[$('.pagination-ms').children().length -1].remove();
				$('.tab-content').append( _.template( $('#plantillaFormContacto').html() )({i:here.model.get('id')}) );
				$('.pagination-ms').append( _.template( '<li id="pagina<%- i %>" class="active"><a href="#<%- i %>" data-toggle="tab"><%- i %></a></li>' )({i:this.model.get('id')}) );
			};

			$('#pagina'+here.model.get('id')).next().addClass('active');
			$('.tab-content #'+here.model.get('id')).next().addClass('active');
			$('#pagina'+here.model.get('id')).remove();
			app.telefonosLocal.findWhere({ idpropietario:here.model.get('id') }).destroy();
			here.model.destroy();
		}, function () {});	
	}
});
app.VistaGeneralContactos = Backbone.View.extend({
	el          : '#div_contactos',
	events      : {
		'click #btn_otroContacto'    : 'guardarC'
	},
	initialize  : function () {
		this.listenTo(app.contactosLocal, 'remove', this.render);
		this.render();
		this.vistaContacto;
		this.anterior;
	},
	render      : function () {
		if (app.contactosLocal.length == 0) {
			this.i = app.contactosLocal.idSiguiente();
			this.$('.tab-content').html( _.template( $('#plantillaFormContacto').html() )({i:this.i}) );
			this.$('.pagination-ms').html( _.template( '<li id="pagina<%- i %>" class="active"><a href="#<%- i %>" data-toggle="tab"><%- i %></a></li>' )({i:this.i}) );
			this.nuevasReferencias();
			this.instanciarFormVacio();
		} else {
			this.i = app.contactosLocal.idSiguiente();
			this.formVacio.setElement(this.$('.tab-content #'+(this.i)));
			this.nuevasReferencias();
		};
	},
	instanciarFormVacio    : function () {
			var Vista = app.VistaContacto.extend({
				initialize : function () {},
				eliminarCopia       : function (elemento) {
					if ($(elemento.currentTarget).parents('.telefonos').children('.div_telefono').length != 1) {
						$(elemento.currentTarget).parents('.div_telefono').remove();
					};
				},
				actualizarContacto : function () {},
				actualizarTelefono : function () {},
				eliminar : function () {}
			});
			this.formVacio = new Vista();
			this.formVacio.setElement(this.$('.tab-content #'+(this.i)));
	},
	guardarC     : function () {
		var here = this;
		this.nuevasReferencias();
		if (this.$contactoNombre.val().trim()
			&& this.$contactoEmail.val().trim()
			&& this.$contactoCargo.val().trim()
		){
			app.contactosLocal.create({
				id          : this.i,
				idcliente   : app.coleccionClientes.obtenerUltimo().get('id'),
				nombre      : this.$contactoNombre.val().trim(),
				correo      : this.$contactoEmail.val().trim(),
				cargo       : this.$contactoCargo.val().trim()
			},{
				wait    : true,
				success : function (model) {
					// console.log('contacto GUARDADO ', model.toJSON());
					this.vistaContacto = new app.VistaContacto({model:model});
					this.vistaContacto.setElement(here.$('.tab-content #'+model.get('id')));
					here.guardarT(
						model.get('id'),
						pasarAJson(here.$telefonoContacto.serializeArray()).numero,
						pasarAJson(here.$tipoTelefonoContacto.serializeArray()).tipo
					);
					$('.active').toggleClass('active');
					here.$('.tab-content').append( _.template( $('#plantillaFormContacto').html() )({i:app.contactosLocal.idSiguiente()}) );
					here.$('.pagination-ms').append( _.template( '<li id="pagina<%- i %>" class="active"><a href="#<%- i %>" data-toggle="tab"><%- i %></a></li>' )({i:app.contactosLocal.idSiguiente()}) );
					here.render();
				},
				error   : function (model) {
					// console.log('ERROR contacto');
				}
			});
		};
	},
	guardarT    : function (idp, n, t) {
		app.telefonosLocal.create({
			id              : app.telefonosLocal.idSiguiente(),
			idpropietario   : idp,
			tabla           : 'contactos',
			numero          : n,
			tipo            : t
		},{
			wait    : true,
			success : function (model) {
				// console.log('telefono GUARDADO: ', model.toJSON());
			},
			error   : function (model) {
				// console.log('ERROR telefono');
			}
		});
	},
	nuevasReferencias : function () {
		this.$contactoNombre =       this.$('.tab-content #'+ this.i +' #contactoNombre');
		this.$contactoEmail =        this.$('.tab-content #'+ this.i +' #contactoEmail');
		this.$contactoCargo =        this.$('.tab-content #'+ this.i +' #contactoCargo');
		this.$telefonoContacto =     this.$('.tab-content #'+ this.i +' .telefonoContacto');
		this.$tipoTelefonoContacto = this.$('.tab-content #'+ this.i +' .tipoTelefonoContacto');
	},
});
var vistaGeneralContactos = new  app.VistaGeneralContactos();