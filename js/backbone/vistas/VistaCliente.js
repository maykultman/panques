var app = app || {};

app.Telefono = app.VistaTelefono.extend({
	plantilla : _.template($('#plantilla_telefono').html())
});

app.VistaCliente = Backbone.View.extend({
	tagName : 'tr',
	plantilla : _.template($('#plantilla_td_de_cliente').html()),
	plantillaModalCliente : _.template($('#modalCliente').html()),
	plantillaModalContacto : _.template($('#modalContacto').html()),
	events  : {
		//Es el boton de eliminar del tr del CLIENTE
			'click #tr_btn_eliminar'        : 'visibilidad',
		//Boton para accesar rapidamente a la edición del cliente
					'click #tr_btn_editar'  : 'verInfo',
						'click .verInfo'    : 'verInfo',

		//Es el boton de eliminar del modal de información del CLIENTE
			'click #modal_btn_eliminar'     : 'visibilidad',

		'click #alertasCliente #cancelar'   : 'cancelar',
		//Es el boton para editar CLIENTE en el MODAL
				'click #modal_btn_editar'   : 'editando',
		//Es el boton para ver CONTACTOS
			'click #btn_verContactos'       : 'verContactos',
		/*Evento para nuevo teléfono*/
		'click #divCliente #enviarTelefono' : 'crearTelefono',


		/*Vaidaciones*/
		'blur #divCliente #numeroNuevo' : 'validarTelefono',

		/*Eventos de atributos*/
		'keypress #nombreComercial'         : 'actualizarAtributo',
		// 'change #nombreComercial'            : 'actualizarAtributo', /*Descomentar si desea actualizar sin la ecesidad de hacer enter*/
		'keypress #divCliente .editando'    : 'actualizarAtributo',
		// 'change #divCliente .editando'       : 'actualizarAtributo', /*Descomentar si desea actualizar sin la ecesidad de hacer enter*/
		'keydown #divCliente #comentario'   : 'actualizarComentario',
		/*Eventos de servicios*/
		'change .menuServicios'             : 'guardarServicio',

		'click #divCliente .icon-uniF470'   : 'quitarDeLista',

		/*Eventos para nuevo contacto o representante*/
		'click #btn_nuevoContacto'   : 'nuevoContacto',


		/*Validar telefono y correo del nuevo contacto o representante*/
		'blur #nuevoMail'   : 'validarCorreo',
		'blur #nuevoNumero' : 'validarTelefono',

		'change #fotoCliente' : 'actualizarFoto'
	},
	initialize  : function () {
		this.listenTo(app.coleccionServiciosClientesI, 'reset', this.agregarServciciosClienteI);
		this.listenTo(app.coleccionServiciosClientesC, 'reset', this.agregarServciciosClienteC);
		// this.listenTo(app.coleccionServicios, 'reset', this.cargarServicios);
		/*Listener para capturar los CAMBIOS en cada uno de
		los ATRIBUTOS de los modelos*/
		this.listenTo(
			this.model, 
			'change:visibilidad', 
			this.eliminarDelDOM
		);
		
		//Otras variables
		this.pasarFiltro = 0;
		this.esperar;
	},
	render  : function () {
		/*Cargar los datos del cliente en la plantilla de underscore
		para luego cargar como html en las etiquetas que hace
		referencia el atributo el. luego esta función sera llamada
		cuendo se instancie esta clase para imprimirlo en pantalla.*/
		this.$el.html(this.plantilla( this.model.toJSON() ));
		

		return this;
	},
	//---------------------------------------------
	verInfo                   	: function (elem) {
		var here = this;
		/*Cuando los clientes se cargan en la tabla, no se carga el
		modal sino hasta que el usuario quiera verlo. Es en esta
		función donde se crea el modal*/
		this.$el.append(this.plantillaModalCliente( this.model.toJSON() ));

		/*guardamos los selectores del los botones eliminar y editar
		de la ficha de información del cliente.*/
		this.$btn_eliminar = this.$('#modal_btn_eliminar');
		this.$btn_editar = this.$('#modal_btn_editar');
		this.$btn_contactos = this.$('#btn_verContactos');
		/*Guardamos el selector donde seran impresos los contactos
		y el representante, el selector sera utilizado más adelante.*/
		this.$divContactos = this.$('#divContactos');

		this.$panelBody = this.$('.panel-body');

		this.$telefonos = this.$('#telefonos');

		this.agregarServciciosClienteI();

		this.agregarServciciosClienteC();

		/*Obtener lo telefonos (modelos) del cliente*/
		this.agregarTelefono(this.model.get('id'),'clientes');


		this.$editarAtributo = this.$('.editar');

		/*La variable modal guarda el elem DOM del modal junto
		después de creado en el DOM general*/
		var modal = this.$el.find('#modal'+this.model.get('id'));
		/*Escuchamos el evento que hace que se esconda el modal
		para luego eliminarlo*/
		modal.on('hidden.bs.modal', function(){
			/*this es la variable modal. removemos el elem DOM
			de todo el documento (DOM general)*/
			$(this).remove();
			here.render();
		});

		if ($(elem.currentTarget).attr('id') == 'tr_btn_editar') {
			this.editando();
		};
	},
	nuevoContacto             	: function (submit) {
		var serializado = this.$formNuevoContacto.serializeArray();

		for (var i = 0; i < serializado.length; i++) {
			if (serializado[i].value == '') {
				alerta('Llene todos los campos', function () {});
				submit.preventDefault();
				return;
			};
		};
		
		var modelo = pasarAJson(serializado);

		var persona = modelo.persona;
		delete modelo.persona;

		telefono = {};

		telefono.tipo = modelo.tipo;
		delete modelo.tipo;

		telefono.numero = modelo.numero;
		delete modelo.numero;

		modelo.idcliente = this.model.get('id');

		// console.log(persona,modelo,telefono);
		// this.$('#btn_cerrarNuevoContacto').click();
		// submit.preventDefault();
		// return;

		var here = this;

		/*Se activan las dos variables globales de Backbone para
		mandar de manera correcta el POST de contactos. Antes de finalizar
		esta función se desactivarán estas dos variables globales
		para que no afecte otras funciónes.*/
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		
		if (persona == 'representante') {
			app.coleccionRepresentantes.create(
				modelo,
				{
					wait:true,
					success:function(exito){
						here.$('#alertasCliente #exito #comentario')
							.html('Se creo el nuevo <strong>representante</strong>');
						here.$('#alertasCliente #exito').removeClass('oculto');

						Backbone.emulateHTTP = true;
						Backbone.emulateJSON = true;
						app.coleccionTelefonos.create(
							{
								idpropietario:exito.get('id'),
								tabla:'representantes',
								numero:telefono.numero,
								tipo:telefono.tipo
							},
							{wait:true}
						);
						Backbone.emulateHTTP = false;
						Backbone.emulateJSON = false;
						here.$('#btn_cerrarNuevoContacto').click();
						setTimeout(
							function () {
								here.agregarRepresentante(exito, here.model.get('id'), 'Nuevo representante');
							},
							500);
					},
					error:function(){
						here.$('#alertasCliente #error #comentario')
							.html('Ocurrio un erro al intentar crear al <strong>representante</strong>');
						here.$('#alertasCliente #error').removeClass('oculto');
					}
				}
			);
		};
		if (persona == 'contacto') {
			app.coleccionContactos.create(
				modelo,
				{
					wait:true,
					success:function(exito){
						here.$('#alertasCliente #exito #comentario')
							.html('Se creo el nuevo <strong>contacto</strong>');
						here.$('#alertasCliente #exito').removeClass('oculto');

						Backbone.emulateHTTP = true;
						Backbone.emulateJSON = true;
						app.coleccionTelefonos.create(
							{
								idpropietario:exito.get('id'),
								tabla:'contactos',
								numero:telefono.numero,
								tipo:telefono.tipo
							},
							{wait:true}
						);
						Backbone.emulateHTTP = false;
						Backbone.emulateJSON = false;
						here.$('#btn_cerrarNuevoContacto').click();
						setTimeout(
							function () {
								here.agregarContacto(exito, here.model.get('id'), 'Nuevo contacto');
							},
							500);
					},
					error:function(){
						here.$('#alertasCliente #error #comentario')
							.html('Ocurrio un erro al intentar crear al <strong>contacto</strong>');
						here.$('#alertasCliente #error').removeClass('oculto');
					}
				}
			);
		};

		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;

		// window.location.href = "modulo_consulta_clientes";

		submit.preventDefault();
	},
	actualizarAtributo        	: function (elem) {
		/*Cada vez que ocurre el evento keypress este metoso se 
		ejecuta; solo cuando el valos de la propiedad es igual 13 
		equivalente a precionar la tecla enter*/
		if ( 
			(elem.keyCode === 13 || elem.type === 'change') && 
			$(elem.currentTarget).attr('id') != 'comentario' 
		){
			/*El formulario de nuevo telefono esta dentro de un div 
			con class editar que luego cambia a editando. here provoca 
			un error en la actualozacion de atributos del cliente 
			porque los inputs para actualiar atributo tambien tienen 
			class editar que cambian a editando. Para ello esta 
			funcion esta preparada para evitar que se ejecute por 
			completo en caso de querer actualizar un telefono que no 
			existe*/
			if ($(elem.currentTarget)
				.parent()
				.attr('id') == 'telefonos'
			) {
				elem.preventDefault();
				return;
			};

			var valorJson = $(elem.currentTarget)
			.serializeArray();

			if (valorJson.length == 0) {
				elem.preventDefault();
				return;
			};

			if (valorJson.length > 0) {
				if ($(elem.currentTarget).attr('class') == 
					'serviciosInteres editando' 

					|| $(elem.currentTarget).attr('class') == 
					'serviciosCuenta editando'
				) {
					this.actualizarServicios(valorJson,elem);
					return;
				};
			};

			if ($(elem.currentTarget).attr('id') == 'mail') {
				if (!this.validarCorreo(elem)) {
					elem.preventDefault();
					return;
				};
			};

			if ($(elem.currentTarget).attr('id') == 'url') {
				if (!this.validarPaginaWeb(elem)) {
					elem.preventDefault();
					return;
				};
			};

			/*Enviamos la propiedad que deseamos actualizar mediante
			la funcion save de modelo (cliente) actual.*/
			this.model.save(
				/*La función pasarAJson obtiene el nuevo valor y la
				propiedad que queremos actualizar en formato json,
				pero antes los datos en el htmo se serializan para
				obtener un array con las propiedades name y value.*/
				pasarAJson(valorJson),
				{
					wait    : true,//Esperamos respuesta del server
					patch   : true,//Evitamos enviar todo el modelo
					success : function (exito) {//Encaso del exito
						$(elem.currentTarget)//Selector
						//Salimos del elem
						.blur()
						//Nos hubicamos en el padre del selector
						.parents('tr')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Removemos su atributo class
						.html('<label class="icon-uniF479 exito"></label>');
					},
					error   : function (error) {//En caso de error
						$(elem.currentTarget)//Selector
						//Salimos del elem
						.focus()
						//Nos hubicamos en el padre del selector
						.parents('tr')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Sustituimos html por uno nuevo
						.html('<label class="icon-uniF478 error"></label>');
						alerta('No se pudo actualizar el <b>'+ valorJson[0].name[0].toUpperCase() + valorJson[0].name.substring(1) +'<b>' ,function (){});
					}
				}
			);
			elem.preventDefault();
		};
	},
	crearTelefono             	: function (elem) {
		if (this.$('#numeroNuevo').val() 
			!= '' && this.$('#tipoNuevo').val() != ''
		) {

			var json1 = pasarAJson(
				this.$('#numeroNuevo').serializeArray()
			);

			var json2 = pasarAJson(
				this.$('#tipoNuevo').serializeArray()
			);
			json1.tipo = json2.tipo;
			json1.idpropietario = this.model.get('id');
			json1.tabla = 'clientes';
			
			var here = this;

			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionTelefonos.create(
				json1,
				{
					wait    : true,//Esperamos respuesta del server
					// patch    : true,//Evitamos enviar todo el modelo
					success : function (exito) {//Encaso del exito
						$(elem.currentTarget)//Selector
						//Salimos del elem
						.blur()
						//Nos hubicamos en el padre del selector
						.parents('tr')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Removemos su atributo class
						.html('<label class="icon-uniF479 exito"></label>');
						//Borrar el contenido del td para telefonos
						here.$telefonos.html('');
						//Imprimir el formulario para nuevo telefono
						here.$telefonos.html('<div class="editar"><div class="input-group"><input type="text" id="numeroNuevo" class="form-control" name="numero" minlength="10" maxlength="20" placeholder="Nuevo Teléfono"><div class="input-group-btn"><select id="tipoNuevo" class="btn btn-default" name="tipo"><option value="No definido" selected style="display:none;">Tipo</option><option value="Casa">Casa</option><option value="Fax">Fax</option><option value="Movil">Movil</option><option value="Oficina">Oficina</option><option value="Personal">Personal</option><option value="Trabajo">Trabajo</option><option value="Otro">Otro</option></select><button id="enviarTelefono" class="btn btn-default"><label class="icon-save"></label></button></div></div><br></div>');
						//Obtener nuevamente los telefonos del cliente
						here.agregarTelefono(here.model.get('id'), 'clientes');

						here.$editarAtributo.toggleClass('editando');
						here.$editarAtributo = here.$('.editar');
						here.$editarAtributo.toggleClass('editando');
					},
					error   : function (error) {//En caso de error
						$(elem.currentTarget)//Selector
						//Salimos del elem
						.focus()
						//Nos hubicamos en el padre del selector
						.parents('tr')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Sustituimos html por uno nuevo
						.html('<label class="icon-uniF478 error"></label>')
					}
				}
			);
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		};
		elem.preventDefault();
	},
	actualizarServicios       	: function (servicio, elem) {
		/*Esta función se ejecuta cuando se agregan servicios que
		ya existen los cuales pueden interesarles al cliente o son
		puede que cuente con ellos*/
		var json = pasarAJson(servicio);
		var modeloServicio = {};
		modeloServicio.idcliente = this.model.get('id');
		
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;

		if ($(elem.currentTarget).attr('class') == 
			'serviciosInteres editando'
		) {
			/*restarle 100 para guardar el id verdadero del servico.
			En la listade servicios actuales se le aumenta 100 para
			no generar conflictos en la otra lista de servicios*/
			modeloServicio.idservicio = json.nameServiciosInteres;
			app.coleccionServiciosClientesI.create(modeloServicio,{
				wait    :true,
				success : function (exito) {
					$(elem.currentTarget)//Selector
					//Nos hubicamos en el padre del selector
					.parents('tr')
					//Buscamos al hijo con la clase especificada
					.children('.respuesta')
					//Removemos su atributo class
					.html('<label class="icon-uniF479 exito"></label>');
				},
				error   : function (error) {
					$(elem.currentTarget)//Selector
					//Nos hubicamos en el padre del selector
					.parents('tr')
					//Buscamos al hijo con la clase especificada
					.children('.respuesta')
					//Sustituimos html por uno nuevo
					.html('<label class="icon-uniF478 error"></label>');
				}
			});
		};
		if ($(elem.currentTarget).attr('class') == 
			'serviciosCuenta editando'
		) {
			/*restarle 100 para guardar el id verdadero del servico.
			En la listade servicios actuales se le aumenta 100 para
			no generar conflictos en la otra lista de servicios*/
			modeloServicio.idservicio = 
			(parseInt(json.nameServiciosCuenta)-100);

			app.coleccionServiciosClientesC.create(modeloServicio,{
				wait    :true,
				success : function (exito) {
					$(elem.currentTarget)//Selector
					//Nos hubicamos en el padre del selector
					.parents('tr')
					//Buscamos al hijo con la clase especificada
					.children('.respuesta')
					//Removemos su atributo class
					.html('<label class="icon-uniF479 exito"></label>');
				},
				error   : function (error) {
					$(elem.currentTarget)//Selector
					//Nos hubicamos en el padre del selector
					.parents('tr')
					//Buscamos al hijo con la clase especificada
					.children('.respuesta')
					//Sustituimos html por uno nuevo
					.html('<label class="icon-uniF478 error"></label>');
				}
			});
		};
		
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	},
	actualizarComentario      	: function (elem) {
		// $(elem.currentTarget).parents('tr').children('.respuesta').html('<img src="img/ajaxloader.gif">');
		this.$('#spin').removeClass().addClass('spin');
		var here = this;
		clearTimeout(this.esperar);
		var modelo = this.model;

		this.esperar = setTimeout(
			function () {
				// var valorJson = $(elem.currentTarget)
				//              .serializeArray();
				modelo.save(
					/*La función pasarAJson obtiene el nuevo valor y la
					propiedad que queremos actualizar en formato json,
					pero antes los datos en el htmo se serializan para
					obtener un array con las propiedades name y value.*/
					pasarAJson($(elem.currentTarget)
								.serializeArray()),
					{
						wait    : true,//Esperamos respuesta del server
						patch   : true,//Evitamos enviar todo el modelo
						success : function (exito) {//Encaso del exito
							/*$(elem.currentTarget)//Selector
								//Nos hubicamos en el padre del selector
								.parents('tr')
								//Buscamos al hijo con la clase especificada
								.children('.respuesta')
								//Removemos su atributo class
								.html('<label class="icon-uniF479 exito"></label>');*/
								here.$('#spin').removeClass().addClass('icon-uniF479 exito');
						},
						error   : function (error) {//En caso de error
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
	agregarTelefono           	: function (idPropietario, tabla) {
		var telefonos = app.coleccionTelefonos.where({
				idpropietario:idPropietario, 
				tabla:tabla
			});
		/*Pasa el filtro del if solo si el arreglo de telefonos
		contiene por almenos un valor*/
		if (telefonos.length > 0) {
			/*Limpiamos el td de la tabla para los telefonos*/
			this.$telefonos.children('label').remove();
			for (var i = 0; i < telefonos.length; i++) {
				/*Instanciar un objeto telefono*/
				var vistaTelefono = new app.Telefono({
					model:telefonos[i]
				});
				/*Agregar td que contentran los telefonos
				de este cliente*/
				this.$telefonos.append(vistaTelefono.render().el);
			};
		};
	},
	agregarServciciosClienteI 	: function () {
		this.$('#serviciosInteres').html('');
		var here = this, vSC;
		app.coleccionServiciosClientesI.each(function (model) {
			if (here.model.get('id') == model.get('idcliente') && model.get('status') == 1) {
				vSC = new app.VistaServicioCliente({model:model})
				here.$('#serviciosInteres').append(vSC.render().el);
			};
		}, this);
	},
	agregarServciciosClienteC 	: function () {
		this.$('#serviciosCuenta').html('');
		var here = this, vSC;
		app.coleccionServiciosClientesC.each(function (model) {
			if (here.model.get('id') == model.get('idcliente') && model.get('status') == 1) {
				vSC = new app.VistaServicioCliente({model:model})
				here.$('#serviciosCuenta').append(vSC.render().el);
			};
		}, this);
	},
	cargarServicios           	: function () {
		var list = '<% _.each(servicios, function(servicio) { %> <option disabled id="<%- servicio.id %>" value="<%- servicio.id %>"><%- servicio.nombre %></option> <% }); %>';
		this.$('.menuServicios').
		append(_.template(list, 
			{ servicios : app.coleccionServicios.toJSON() }
		));
		this.$('.menuServicios').selectize({
			create: true,
			maxItems: 1
		});
	},
	quitarDeLista             	: function (elem) {
		/*Esta funcion recibe un parametro al y se ejecuta al momento 
		de ejecutarse el evento para quitar de la lista uno de los 
		servicios. El parametro es un objeto del DOM.

		En la variable arrayServicios se almacenan los objetos que 
		coincidan con el mismo atributo name.*/
		var arrayServicios = document
							.getElementsByName(
								$(elem.currentTarget)
								.attr('name')
							);

		/*En la variable servicio almacenamos el id del elem que 
		se quiere quitar de la lista.*/
		var servicio = $(elem.currentTarget).parent().attr('id');

		/*Mediante el ciclo for se itera sobre los elems del arreglo
		arrayServicios hasta encontrar una coincidencia de id espeficicada
		en la condición if. se establece como falso y se rompe el ciclo.
		here se hace para no desactivar todos los alementos de la lista
		que se han agregado para el cliente. Hay un checkbox oculto con 
		cada elem de la lista*/
		for (var i = 0; i < arrayServicios.length; i++) {
			if ($(arrayServicios[i]).attr('id') == servicio) {
				$(arrayServicios[i]).prop('checked', false);
				break;
			};
		};

		/*Finalmente se remueve del DOM el servicio que ya no se 
		quiera ver en ella*/
		$(elem.currentTarget).parent().remove();
	},
	guardarServicio           	: function (elem) {
		var here = this;
		
		if ( (elem.type === 'change' || elem.which == 13) && $(elem.currentTarget).attr('id') == 'select_ServI' ) {
			var servicioCliente = app.coleccionServiciosClientesI.findWhere({ idservicio : $(elem.currentTarget).val()[0], idcliente : this.model.get('id') });
			if (servicioCliente != undefined) {
				if ( ( servicioCliente.get('status') == '1' || servicioCliente.get('status') == true ) && servicioCliente != undefined ) {
					alerta('El servicio ya está en la lista',function () {});
					return;
				} else if( ( servicioCliente.get('status') == '0' || servicioCliente.get('status') == false ) && servicioCliente != undefined ) {
					servicioCliente.save({
						status:'1'
					},{
						wait: true,
						patch: true,
						success : function () {
							here.agregarServciciosClienteI();
							here.$('#serviciosInteres small .editar').toggleClass('editando');
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Removemos su atributo class
							.html('<label class="icon-uniF479 exito"></label>');
						},
						error	: function () {
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Sustituimos html por uno nuevo
							.html('<label class="icon-uniF478 error"></label>');
						}
					});
				};
			} else{
				if( app.coleccionServicios.findWhere({ id : $(elem.currentTarget).val()[0] }) ){
					Backbone.emulateHTTP = true;
					Backbone.emulateJSON = true;
					app.coleccionServiciosClientesI.create({
						idcliente:here.model.get('id'),
						idservicio:$(elem.currentTarget).val(),
						status:true,
					},{
						wait:true,
						success:function (exito) {
							app.coleccionServiciosClientesI.fetch({
								reset:true,
								success:function () {
									here.$('#serviciosInteres small .editar').toggleClass('editando');
								}
							});
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Removemos su atributo class
							.html('<label class="icon-uniF479 exito"></label>');
						},
						error:function () {
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Sustituimos html por uno nuevo
							.html('<label class="icon-uniF478 error"></label>');
						}
					});
					Backbone.emulateHTTP = false;
					Backbone.emulateJSON = false;          
				} else {
					Backbone.emulateHTTP = true;
					Backbone.emulateJSON = true;
					app.coleccionServicios.create({
						idcliente           :here.model.get('id'),
						nombre              :$(elem.currentTarget).val(),
						serviciosinteres    :'serviciosinteres',
						status              : ['1']
					},{
						wait    : true,
						success : function (exito) {
							app.coleccionServiciosClientesI.fetch({
								reset:true,
								success:function () {
									here.$('#serviciosInteres small .editar').toggleClass('editando');
								}
							});
							app.coleccionServicios.fetch({
								reset:true,
								success: function (coleccion) {
									this.$('#div_serviciosI').html('<select id="select_ServI" class="menuServicios" name="idservicio" multiple placeholder="Buscar servicios" style="width:400px;"></select>');
									this.$('#div_serviciosC').html('<select id="select_ServC" class="menuServicios" name="idservicio" multiple placeholder="Buscar servicios" style="width:400px;"></select>');
									here.cargarServicios();
								}
							});
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Removemos su atributo class
							.html('<label class="icon-uniF479 exito"></label>');
						},
						error   : function (error) {
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Sustituimos html por uno nuevo
							.html('<label class="icon-uniF478 error"></label>');
						}
					});
					Backbone.emulateHTTP = false;
					Backbone.emulateJSON = false;
				};
			};
		};

		if ( (elem.type === 'change' || elem.which == 13) && $(elem.currentTarget).attr('id') == 'select_ServC' ) {
			var servicioCliente = app.coleccionServiciosClientesC.findWhere({ idservicio : $(elem.currentTarget).val()[0], idcliente : this.model.get('id') });
			if (servicioCliente != undefined) {
				if ( ( servicioCliente.get('status') == '1' || servicioCliente.get('status') == true ) && servicioCliente != undefined ) {
					alerta('El servicio ya está en la lista',function () {});
					return;
				} else if( ( servicioCliente.get('status') == '0' || servicioCliente.get('status') == false ) && servicioCliente != undefined ) {
					servicioCliente.save({
						status:'1'
					},{
						wait: true,
						patch: true,
						success : function () {
							here.agregarServciciosClienteC();
							here.$('#serviciosCuenta small .editar').toggleClass('editando');
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Removemos su atributo class
							.html('<label class="icon-uniF479 exito"></label>');
						},
						error	: function () {
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Sustituimos html por uno nuevo
							.html('<label class="icon-uniF478 error"></label>');
						}
					});
				};
			} else{
				if( app.coleccionServicios.findWhere({ id : $(elem.currentTarget).val()[0] }) ){
					Backbone.emulateHTTP = true;
					Backbone.emulateJSON = true;
					app.coleccionServiciosClientesC.create({
						idcliente:here.model.get('id'),
						idservicio:$(elem.currentTarget).val(),
						status:true,
					},{
						wait:true,
						success:function (exito) {
							app.coleccionServiciosClientesC.fetch({
								reset:true,
								success:function () {
									here.$('#serviciosCuenta small .editar').toggleClass('editando');
								}
							});
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Removemos su atributo class
							.html('<label class="icon-uniF479 exito"></label>');
						},
						error:function () {
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Sustituimos html por uno nuevo
							.html('<label class="icon-uniF478 error"></label>');
						}
					});
					Backbone.emulateHTTP = false;
					Backbone.emulateJSON = false;          
				} else {
					Backbone.emulateHTTP = true;
					Backbone.emulateJSON = true;
					app.coleccionServicios.create({
						idcliente           : here.model.get('id'),
						nombre              : $(elem.currentTarget).val(),
						servicioscuenta     : 'servicioscuenta',
						status              : ['1']
					},{
						wait    : true,
						success : function (exito) {
							app.coleccionServiciosClientesC.fetch({
								reset:true,
								success:function () {
									here.$('#serviciosCuenta small .editar').toggleClass('editando');
								}
							});
							app.coleccionServicios.fetch({
								reset:true,
								success: function (coleccion) {
									this.$('#div_serviciosI').html('<select id="select_ServI" class="menuServicios" name="idservicio" multiple placeholder="Buscar servicios" style="width:400px;"></select>');
									this.$('#div_serviciosC').html('<select id="select_ServC" class="menuServicios" name="idservicio" multiple placeholder="Buscar servicios" style="width:400px;"></select>');
									here.cargarServicios();
								}
							});
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Removemos su atributo class
							.html('<label class="icon-uniF479 exito"></label>');
						},
						error   : function (error) {
							$(elem.currentTarget)
							//Nos hubicamos en el padre del selector
							.parents('tr')
							//Buscamos al hijo con la clase especificada
							.children('.respuesta')
							//Sustituimos html por uno nuevo
							.html('<label class="icon-uniF478 error"></label>');
						}
					});
					Backbone.emulateHTTP = false;
					Backbone.emulateJSON = false;
				};
			};
		};
	},
	editando                  	: function () {
		// var here = this;
		
		// this.verInfo(); //Lamar esta función duplica el modal (ANOMALIA)
		// this.verInfo(function () {
		if (this.$btn_editar
			.children()
			.attr('class') == 
			'icon-edit2 MO icon-back'
		) {
			this.$btn_editar.children().toggleClass('MO icon-back');
			this.$editarAtributo.toggleClass('editando');
			this.$('#cerrar_consulta').click();
			this.render();
			this.$('.icon-eye').click();
		} 
		else{
			this.cargarServicios();
			this.$btn_editar.children().toggleClass('MO icon-back');
			this.$editarAtributo.toggleClass('editando');
		};
		// });  
	},
	eliminarDelDOM            	: function () {
		this.$el.remove();
	},
	visibilidad               	: function() {
		var here = this;
		// if (confirm('¿Deseas eliminar al cliente?')) {
			//El cierre del modal lo realiza bootstrap
			// console.log();
		confirmar('¿Está seguro de que desea eliminar al cliente <b>'+this.model.get('nombreComercial')+'<b>?',
			function () {
				here.$('#cerrar_consulta').click();
				here.model.cambiarVisibilidad();
				here.$el.remove();
			},
			function () {});
			// 
		// };
	},
	cancelar                  	: function (elem) {
		$(elem.currentTarget)
		.parents('#advertencia')
		.children('.close')
		.click();
	},
	validarTelefono           	: function (elem) {
		if(!(/^\d{10,20}$/.test($(elem.currentTarget).val().trim())) && $(elem.currentTarget).val().trim() != '' ) {
			alerta('No ingrese letras u otros símbolos<br>Establezca un tipo de teléfono<br>Escriba 10 números como mínimo o 20 como máximo',function () {});
			$(document.getElementsByTagName('body')).find('#alertify-ok').on('click',function(){
				$(elem.currentTarget).focus();
			});
			$(elem.currentTarget).css('border-color','#a94442');
			return false;
		} else{
			$(elem.currentTarget).css('border-color','#CCC');
			$(elem.currentTarget).next().children('select').focus();
			return true;
		};
	},
	validarCorreo             	: function (elem) {
		if( !(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(elem.currentTarget).val().trim()))) {
			alerta('No es un correo valido',function () {});
			$(document.getElementsByTagName('body')).find('#alertify-ok').on('click',function(){
				$(elem.currentTarget).focus();
			});
			$(elem.currentTarget).css('border-color','#a94442');
			return false;
		} else{
			$(elem.currentTarget).css('border-color','#CCC');
			return true;
		};
	},
	validarPaginaWeb          	: function (elem) {
		if (!($(elem.currentTarget).val().trim().match(/^[a-z0-9\.-]+\.[a-z]{2,4}/gi))) {
			alerta('La dirección de la página web no es correcta',function () {});
			$(document.getElementsByTagName('body')).find('#alertify-ok').on('click',function(){
				$(elem.currentTarget).focus();
			});
			$(elem.currentTarget).css('border-color','#a94442');
			return false;
		} else{
			$(elem.currentTarget).css('border-color','#CCC');
			return true;
		};
	},
	verContactos              	: function () {
		/*Si existe, eliminamos el modal que contiene el formulario
		para nuevo contacto o representante. Debe realizarse debido a 
		que dicho modal no se encuentra dentro del divContactos que sí
		se limpia cada vez que se preciona el boton para ver contactos
		*/
		this.$el.children('#modalNuevoContacto'+this.model.get('id')).remove();
		/*Desabilitamos los botones de eliminar y editar
		  para que el usuario entienda que ahora solo 
		  podrá editar a los contactos*/
		this.$btn_eliminar.toggleClass('disabled');
		this.$btn_editar.toggleClass('disabled');

		if (this.$divContactos.parent().attr('class') == 
			'visible oculto'
		) {
			// this.$divContactos.html(''); //Para el boton
			//CAMBIA LA IMAGEN DEL BOTON
			this.$btn_contactos.children().toggleClass('MO icon-back');
			/*Cargamos el dentro del contenedor mediante la
			  funcion agregarContactos solo si la clase del
			  contenedor es la especificada en la condición*/
			this.agregarContactos();
			this.agregarRepresentantes();
			/*Quitamos la clase oculto del contenedor para
			  que solo quede como visible mediante el 
			  toogleClass*/
			this.$panelBody.children().toggleClass('oculto');
		} else{
			//CAMBIA LA IMAGEN DEL BOTON
			this.$btn_contactos.children().toggleClass('MO icon-back');
			/*Limpiar el contenedor debido a la funcion append
			  que se ejecuta en la funcion agregarContacto()*/
			this.$divContactos.html('');
			/*Se agrega la clase oculto al contenedor para
			  regresar al conenedor del cliente*/
			this.$panelBody.children().toggleClass('oculto');
		};
		
		this.$el.append( this.plantillaModalContacto( {id:this.model.get('id')} ) );

		/*Formulario para nuevo contacto. Hacemos referencia al
		elemento mediante su selector*/
		this.$formNuevoContacto = this.$('#formNuevoContacto');

		var here = this;

		/*Las siguientes lineas resetean el formulario cuando el
		usuario cierra el modal*/
		var modal = this.$el.find('#modalNuevoContacto'+this.model.get('id'));
		modal.on('hidden.bs.modal', function () {
			here.$formNuevoContacto[0].reset();
		});
	},
	agregarContacto           	: function (tipo, esDe) {
		var vista = new app.VistaContacto({model:tipo});
		this.$divContactos.prepend(vista.render().el);
		// vista.establecerEtiqueta(etiqueta);
	},
	agregarContactos          	: function () {
		/*Solo cuando se requiere ver los contactos
		  here se crean. No al momento de crear al cliente*/
		var contactos = app.coleccionContactos.where( {
			idcliente:this.model.get('id')
		});     
		if (contactos != undefined) {
			this.recursividadContactos(contactos, 'Contacto');
		};

		// //OBTENER EL "title" DEL BOTON "conmutar"
		// var title = this.$btn_contactos.children().attr('title');
		
		// //CAMBIA EL "title"
		// if (title == 'Contactos') {
		//  this.$btn_contactos.children().attr(
		//      'title',
		//      'Información'
		//  );  
		// } else {
		//  this.$btn_contactos.children().attr(
		//      'title',
		//      'Contactos'
		//  );
		// };

		//Activar visibilidad de contenedor de contactos
		// this.$panelBody.children().toggleClass('oculto');
	},
	recursividadContactos     	: function (tipo) {
		if (tipo.length) {
			for (var i = 0; i < tipo.length; i++) {
				this.recursividadContactos(tipo[i]);/*, etiqueta*/
			};
		} else{
			if (tipo != '') {
				this.agregarContacto(
					tipo,
					tipo.get('idcliente')/*,
					etiqueta*/
				);
			};
		};
	},
	agregarRepresentante      	: function (tipo, esDe) {
		var vista = new app.VistaRepresentante({model:tipo});
		this.$divContactos.prepend(vista.render().el);
		// vista.establecerEtiqueta(etiqueta);
	},
	agregarRepresentantes     	: function () {

		var representante = app.coleccionRepresentantes.where( {
			idcliente:this.model.get('id')
		});
		if (representante != undefined) {
			this.recursividadRepresentantes(representante,'Representante');
		};

		// //OBTENER EL "title" DEL BOTON "conmutar"
		// var title = this.$btn_contactos.children().attr('title');
		
		// //CAMBIA EL "title"
		// if (title == 'Contactos') {
		//  this.$btn_contactos.children().attr(
		//      'title',
		//      'Información'
		//  );  
		// } else {
		//  this.$btn_contactos.children().attr(
		//      'title',
		//      'Contactos'
		//  );
		// };

		//Activar visibilidad de contenedor de contactos
		// this.$panelBody.children().toggleClass('oculto');
	},
	recursividadRepresentantes	: function (tipo) {
		if (tipo.length) {
			for (var i = 0; i < tipo.length; i++) {
				this.recursividadRepresentantes(tipo[i]);/*, etiqueta*/
			};
		} else{
			if (tipo != '') {
				this.agregarRepresentante(
					tipo,
					tipo.get('idcliente')/*,
					etiqueta*/
				);
			};
		};
	},
	actualizarFoto				: function (elem) {	
		this.model.save({
				foto : urlFoto()	
			},{
					wait    : true,//Esperamos respuesta del server
					patch   : true,//Evitamos enviar todo el modelo
					success : function (exito) {//Encaso del exito
						obtenerFoto(elem);
					},
					error   : function (error) {//En caso de error
					}
				}
			);
	}
});