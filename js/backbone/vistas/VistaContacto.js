var app = app || {};

app.VistaContacto = Backbone.View.extend({
	tagName	: 'div',
	className	: 'contenedorContacto',

	plantilla : _.template($('#plantilla_contactos').html()),

	events	: {
		'click #btn_eliminarContacto'	: 'advertenciaEliminar',
		'click #alertasContacto #eliminar'	: 'eliminar',
		'click #alertasContacto #cancelar'	: 'cancelar',




		'click #btn_editarContacto'	: 'editando',

		'keypress .editando'	: 'actualizarAtributo',

		'click #enviarTelefono'	: 'crearTelefono',
		'blur #numeroNuevo'	: 'validarTelefono',


		/*Eventos para las advertencias*/
			'click .cerrar'	: 'cerrarAlerta',
			// 'click #cancelar'	: 'cerrarAlerta'
	},
	advertenciaEliminar : function (elemento) {
			this.$('#alertasContacto #advertencia #comentario')
			.html('¿Deseas eliminar al contacto <strong>'
				+this.model.get('nombre')+'</strong>?');
		    
		    this.$('#alertasContacto #advertencia').
		    toggleClass('oculto');
	},
	initialize	: function () {
		this.model.set({etiqueta:'Contacto'});
		this.listenTo(this.model, 'destroy', this.remove);
	},
	render	: function () {
		this.$el.html(this.plantilla( this.model.toJSON() ));

		this.$telefonos = this.$('#telefonos');
		this.agregarTelefono(this.model.get('id'), 'contactos');

		this.$btn_EditarContacto = this.$('#btn_editarContacto');
		this.$editarAtributo = this.$('.editar');

		/*En caso de no haber teléfonos se hace referencia al
		formulario que tiene la plantilla por default*/
		this.$numeroNuevo = this.$('#numeroNuevo');
		this.$tipoNuevo = this.$('#tipoNuevo');

		return this;
	},
	actualizarAtributo	: function (elemento) {
		/*Cada vez que ocurre el evento keypress este metoso se 
		ejecuta; solo cuando el valos de la propiedad es igual 13 
		equivalente a precionar la tecla enter*/
		if (elemento.keyCode === 13 || elemento.type === 'change') {

			if (
				$(elemento.currentTarget).parent().attr('id') == 
				'telefonos') {
				elemento.preventDefault();
				return;
			};

			var valorJson = $(elemento.currentTarget)
							.serializeArray();

			if (valorJson.length == 0) {
				return;
			};

			if ($(elemento.currentTarget).attr('id') == 'mail') {
	        	console.log($(elemento.currentTarget).attr('id'));
	        	if (this.validarCorreo(elemento) == false) {
	        		elemento.preventDefault();
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
					wait	: true,//Esperamos respuesta del server
					patch	: true,//Evitamos enviar todo el modelo
					success	: function (exito) {//Encaso del exito
						$(elemento.currentTarget)//Selector
						//Salimos del elemento
						.blur()
						//Nos hubicamos en el padre del selector
						.parents('tr')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Removemos su atributo class
						.html('<label class="icon-uniF479 exito"></label>');
					},
					error	: function (error) {//En caso de error
						$(elemento.currentTarget)//Selector
						//Salimos del elemento
						.focus()
						//Nos hubicamos en el padre del selector
						.parents('tr')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Sustituimos html por uno nuevo
						.html('<label class="icon-uniF478 error"></label>');
					}
				}
			);
			elemento.preventDefault();
		};
	},
	// establecerEtiqueta	: function (etiqueta) {
	// 	this.$('#etiqueta').html(etiqueta);
	// },
	eliminar	: function (elemento) {
		var esto = this;
		this.model.destroy({
			success	: function () {
				esto.$el.remove();
			}
		});
		elemento.preventDefault();
	},
	cancelar	: function (elemento) {
		$(elemento.currentTarget)
		.parents('#advertencia')
		.children('.close')
		.click();
	},
	crearTelefono	: function (elemento) {
		if (this.$numeroNuevo.val() != '' 
			&& typeof this.$tipoNuevo.val() != 'undefined') {

			/*Antes de guardar el nuevo telefono se valida
			  nuevamente que el número sea correcto*/
			if ( this.validarPreenvioTelefono(this.$numeroNuevo.val()) 
				== false) {
				/*En caso de que el número no sea correcto,
				  evitamos recargar el botón*/
				elemento.preventDefault();
				/*Se evita seguir con la función*/
				return;
			};

			var json1 = pasarAJson(this.$numeroNuevo.serializeArray());
			var json2 = pasarAJson(this.$tipoNuevo.serializeArray());
			json1.tipo = json2.tipo;
			json1.idpropietario = this.model.get('id');
			json1.tabla = 'contactos';
			
			var esto = this;

			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionTelefonos.create(
				json1,
				{
					wait	: true,//Esperamos respuesta del server
					// patch	: true,//Evitamos enviar todo el modelo
					success	: function (exito) {//Encaso del exito
						$(elemento.currentTarget)//Selector
						//Salimos del elemento
						.blur()
						//Nos hubicamos en el padre del selector
						.parents('tr')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Removemos su atributo class
						.html('<label class="icon-uniF479 exito"></label>');
						//Borrar el contenido del td para telefonos
						esto.$telefonos.html('');
						//Imprimir el formulario para nuevo telefono
						esto.$telefonos.html('<div class="editar"><div class="input-group"><input type="text" id="numeroNuevo" class="form-control" name="numero" maxlength="10" placeholder="Nuevo Teléfono"><div class="input-group-btn"><select id="tipoNuevo" class="btn btn-default" name="tipo"><option value="Casa">Casa</option><option value="Fax">Fax</option><option value="Movil" selected>Movil</option><option value="Oficina">Oficina</option><option value="Personal">Personal</option><option value="Trabajo">Trabajo</option><option value="Otro">Otro</option><option selected disabled>Tipo</option></select><button id="enviarTelefono" class="btn btn-default"><label class="glyphicon glyphicon-send"></label></button></div></div></div>');
						//Obtener nuevamente los telefonos del cliente
						esto.agregarTelefono(esto.model.get('id'), 'contactos');

						esto.$editarAtributo.toggleClass('editando');
						esto.$editarAtributo = esto.$('.editar');
						esto.$editarAtributo.toggleClass('editando');
					},
					error	: function (error) {//En caso de error
						$(elemento.currentTarget)//Selector
						//Salimos del elemento
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
		} else{
			this.$('#alertasContacto #error #comentario').html('Escriba un teléfono correcto y seleccione su tipo');
			this.$('#alertasContacto #error').toggleClass('oculto');
			// this.$numeroNuevo.focus();
		};
		elemento.preventDefault();
	},
	agregarTelefono	: function (idPropietario, tabla) {
		var telefonos = app.coleccionTelefonos.where(
			{idpropietario:idPropietario, tabla:tabla}
		);
		/*Pasa el filtro del if solo si el arreglo de telefonos
		contiene por almenos un valor*/
		if (telefonos.length > 0) {
			/*Limpiamos el td de la tabla para los telefonos*/
			// this.$telefonos.children('label').remove();
			// this.$telefonos.html('<hr>');
			this.$telefonos.children('label').remove();
			for (var i = 0; i < telefonos.length; i++) {
				/*Instanciar un objeto telefono*/
				var vistaTelefono = new app.VistaTelefono({
					model:telefonos[i]
				});
				/*Agregar td que contentran los telefonos
				de este cliente*/
				this.$telefonos.prepend(vistaTelefono.render().el);
			};
		};
		this.$numeroNuevo = this.$('#numeroNuevo');
		this.$tipoNuevo = this.$('#tipoNuevo');
	},
	editando	: function () {
		if (this.$btn_EditarContacto.children().attr('class') 
			== 'icon-edit2 MO icon-back'
		) {
			this.$btn_EditarContacto
			.children()
			.toggleClass('MO icon-back');

			this.$editarAtributo.
			toggleClass('editando');

			this.render();
		} 
		else{
			this.$btn_EditarContacto
			.children()
			.toggleClass('MO icon-back');

			this.$editarAtributo
			.toggleClass('editando');
		};
	},
	validarTelefono	: function (elemento) {
		if( !(/^\d{10}$/.test($(elemento.currentTarget).val().trim()))) {
			/*En caso de que el usaurio no escriba nada,
			se evita desplegar en mensaje, de lo contrario
			será molesto ver un mensaje de error incluso
			si no queremos enviar un teléfono nuevo*/
			if ($(elemento.currentTarget).val() == '') return;
			this.$('#alertasContacto #error #comentario').html('No ingrese letras u otros símbolos<br>Escriba 10 números<br>Establezca un tipo de teléfono');
			this.$('#alertasContacto #error').toggleClass('oculto');
			$(elemento.currentTarget).focus();
	    	return false;
	    } else{
	    	this.$tipoNuevo.focus();
	    };
	},
	validarPreenvioTelefono	: function (numero) {
		if( !(/^\d{10}$/.test(numero))) {
	       this.$('#alertasContacto #error #comentario').html('No ingrese letras u otros símbolos<br>Escriba 10 números<br>Establezca un tipo de teléfono');
	       this.$('#alertasContacto #error').toggleClass('oculto');
	       this.$numeroNuevo.focus();
	    	return false;
	    }
	},
	validarCorreo	: function (elemento) {
		if( !(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(elemento.currentTarget).val().trim())) ) {
			/*Usamos las alertas que se encuentran en el td de los teléfonos*/
			this.$('#alertasContacto #error #comentario').html('No es un correo valido');
			/*Usamos las alertas que se encuentran en el td de los teléfonos*/
			this.$('#alertasContacto #error').removeClass('oculto');
			// $(elemento.currentTarget).focus();
			return false;
	    };
	},
	cerrarAlerta	: function (elemento) {
		$(elemento.currentTarget).parent().addClass('oculto');
		elemento.preventDefault();
	},
});

app.VistaRepresentante = app.VistaContacto.extend({
	render	: function () {
		this.model.set({etiqueta:'Representante'});
		this.$el.html(this.plantilla( this.model.toJSON() ));

		this.$telefonos = this.$('#telefonos');
		this.agregarTelefono(this.model.get('id'), 'representantes');

		this.$btn_EditarContacto = this.$('#btn_editarContacto');
		this.$editarAtributo = this.$('.editar');

		/*En caso de no haber teléfonos se hace referencia al
		formulario que tiene la plantilla por default*/
		this.$numeroNuevo = this.$('#numeroNuevo');
		this.$tipoNuevo = this.$('#tipoNuevo');

		return this;
	},
	crearTelefono	: function (elemento) {
		if (this.$numeroNuevo.val() != '' 
			&& typeof this.$tipoNuevo.val() != 'undefined') {

			/*Antes de guardar el nuevo telefono se valida
			  nuevamente que el número sea correcto*/
			if ( this.validarPreenvioTelefono(this.$numeroNuevo.val()) 
				== false) {
				/*En caso de que el número no sea correcto,
				  evitamos recargar el botón*/
				elemento.preventDefault();
				/*Se evita seguir con la función*/
				return;
			};

			var json1 = pasarAJson(this.$numeroNuevo.serializeArray());
			var json2 = pasarAJson(this.$tipoNuevo.serializeArray());
			json1.tipo = json2.tipo;
			json1.idpropietario = this.model.get('id');
			json1.tabla = 'contactos';
			
			var esto = this;

			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionTelefonos.create(
				json1,
				{
					wait	: true,//Esperamos respuesta del server
					// patch	: true,//Evitamos enviar todo el modelo
					success	: function (exito) {//Encaso del exito
						$(elemento.currentTarget)//Selector
						//Salimos del elemento
						.blur()
						//Nos hubicamos en el padre del selector
						.parents('tr')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Removemos su atributo class
						.html('<label class="icon-uniF479 exito"></label>');
						//Borrar el contenido del td para telefonos
						esto.$telefonos.html('');
						//Imprimir el formulario para nuevo telefono
						esto.$telefonos.html('<div class="editar"><div class="input-group"><input type="text" id="numeroNuevo" class="form-control" name="numero" maxlength="10" placeholder="Nuevo Teléfono"><div class="input-group-btn"><select id="tipoNuevo" class="btn btn-default" name="tipo"><option value="Casa">Casa</option><option value="Fax">Fax</option><option value="Movil" selected>Movil</option><option value="Oficina">Oficina</option><option value="Personal">Personal</option><option value="Trabajo">Trabajo</option><option value="Otro">Otro</option><option selected disabled>Tipo</option></select><button id="enviarTelefono" class="btn btn-default"><label class="glyphicon glyphicon-send"></label></button></div></div></div>');
						//Obtener nuevamente los telefonos del cliente
						esto.agregarTelefono(esto.model.get('id'), 'representantes');

						esto.$editarAtributo.toggleClass('editando');
						esto.$editarAtributo = esto.$('.editar');
						esto.$editarAtributo.toggleClass('editando');
					},
					error	: function (error) {//En caso de error
						$(elemento.currentTarget)//Selector
						//Salimos del elemento
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
		} else{
			this.$('#alertasContacto #error #comentario').html('Escriba un teléfono correcto y seleccione su tipo');
			this.$('#alertasContacto #error').toggleClass('oculto');
			// this.$numeroNuevo.focus();
		};
		elemento.preventDefault();
	},
	advertenciaEliminar : function (elemento) {
			this.$('#alertasContacto #advertencia #comentario')
			.html('¿Deseas eliminar al representante <strong>'
				+this.model.get('nombre')+'</strong>?');
		    
		    this.$('#alertasContacto #advertencia').
		    toggleClass('oculto');
	},
});
