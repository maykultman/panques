var app = app || {};

app.Telefono = app.VistaTelefono.extend({
	plantilla : _.template($('#plantilla_telefono').html())
});

app.VistaContacto = Backbone.View.extend({
	tagName				: 'div',

	className			: 'contenedorContacto',

	plantilla 			: _.template($('#plantilla_contactos').html()),

	events				: {
		'click #btn_eliminar'	: 'eliminar',




		'click #btn_editar'	: 'editando',

		'keypress .editando'	: 'actualizarAtributo',

		// 'keyup #nuevoMail'		: 'validarEmail',
		'click #enviarTelefono'	: 'crearTelefono',
		// 'blur #numeroNuevo'		: 'validarTelefono',


		/*Eventos para las advertencias*/
			'click .cerrar'	: 'cerrarAlerta',
			// 'click #cancelar'	: 'cerrarAlerta'
	},
	initialize			: function () {
		this.model.set({etiqueta:'Contacto'});
		this.listenTo(this.model, 'destroy', this.remove);
	},
	render				: function () {
		this.$el.html(this.plantilla( this.model.toJSON() ));

		this.$telefonos = this.$('#telefonos');
		this.agregarTelefono(this.model.get('id'), 'contactos');

		this.$btn_editar = this.$('#btn_editar');
		this.$editarAtributo = this.$('.editar');

		/*En caso de no haber teléfonos se hace referencia al
		formulario que tiene la plantilla por default*/
		this.$numeroNuevo = this.$('#numeroNuevo');
		this.$tipoNuevo = this.$('#tipoNuevo');

		return this;
	},
	actualizarAtributo	: function (e) {
		/*Cada vez que ocurre el evento keypress este metoso se 
		ejecuta; solo cuando el valos de la propiedad es igual 13 
		equivalente a precionar la tecla enter*/
		if (e.keyCode === 13 || e.type === 'change') {

			if (
				$(e.currentTarget).parent().attr('id') == 
				'telefonos'
			) {
				e.preventDefault();
				return;
			};

			var valorJson = $(e.currentTarget)
							.serializeArray();

			if (valorJson.length == 0) {
				return;
			};

			if ($(e.currentTarget).attr('id') == 'mail') {
	        	// console.log($(e.currentTarget).attr('id'));
	        	if (validarEmail($(e.currentTarget))) {

	        		e.preventDefault();
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
						$(e.currentTarget)//Selector
						//Salimos del e
						.blur()
						//Nos hubicamos en el padre del selector
						.parents('tr')
						//Buscamos al hijo con la clase especificada
						.children('.respuesta')
						//Removemos su atributo class
						.html('<label class="icon-uniF479 exito"></label>');
					},
					error	: function (error) {//En caso de error
						$(e.currentTarget)//Selector
						//Salimos del e
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
			e.preventDefault();
		};
	},
	eliminar			: function (elemento) {
		var here = this;
		confirmar('¿Deseas eliminar al contacto <strong>'+this.model.get('nombre')+'</strong>?',
			function () {
			here.model.destroy({
				success	: function (model) {
					here.eliminarTelefonos(model.get('id'));
					here.$el.remove();
				},
				error 	: function (model) {
					here.eliminarTelefonos(model.get('id'));
				}
			});
			},function () {}); 
		elemento.preventDefault();
	},
	crearTelefono		: function (e) {
		if (this.$numeroNuevo.val() != '' 
			&& typeof this.$tipoNuevo.val() != 'undefined') {

			/*Antes de guardar el nuevo telefono se valida
			  nuevamente que el número sea correcto*/
			if ( validarTelefono(this.$numeroNuevo) ) {
				/*En caso de que el número no sea correcto,
				  evitamos recargar el botón*/
				e.preventDefault();
				/*Se evita seguir con la función*/
				return;
			};

			var json1 = pasarAJson(this.$numeroNuevo.serializeArray());
			var json2 = pasarAJson(this.$tipoNuevo.serializeArray());
			json1.tipo = json2.tipo;
			json1.idpropietario = this.model.get('id');
			json1.tabla = 'contactos';
			
			var here = this;

			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionTelefonos.create(
				json1,
				{
					wait	: true,//Esperamos respuesta del server
					// patch	: true,//Evitamos enviar todo el modelo
					success	: function (exito) {//Encaso del exito
						$(e.currentTarget)//Selector
						//Salimos del e
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
						here.$telefonos.html('<div class="editar"><div class="form-group"><div class="row"><div class="col-xs-4 col-sm-6"><input type="text" id="numeroNuevo" class="form-control" name="numero" onkeyup="validarTelefono(this)" placeholder="De 10 a 20 dígitos"></div><div class="col-xs-4 col-sm-4"><select id="tipoNuevo" class="form-control" name="tipo"><option value="No definido" selected style="display:none;">Tipo</option><option value="Casa">Casa</option><option value="Fax">Fax</option><option value="Movil">Movil</option><option value="Oficina">Oficina</option><option value="Personal">Personal</option><option value="Trabajo">Trabajo</option><option value="Otro">Otro</option></select></div><div class="col-xs-4 col-sm-2"><div class="btn-group" role="group" aria-label="..." style="margin:0px !important;"><button type="button" id="enviarTelefono" class="btn btn-default"><label class="icon-save"></label></button></div></div></div></div></div>');
						//Obtener nuevamente los telefonos del cliente
						here.agregarTelefono(here.model.get('id'), 'contactos');

						here.$editarAtributo.toggleClass('editando');
						here.$editarAtributo = here.$('.editar');
						here.$editarAtributo.toggleClass('editando');
					},
					error	: function (error) {//En caso de error
						$(e.currentTarget)//Selector
						//Salimos del e
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
		} else{ };
		e.preventDefault();
	},
	agregarTelefono		: function (idPropietario, tabla) {
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
				var vistaTelefono = new app.Telefono({
					model:telefonos[i]
				});
				/*Agregar td que contentran los telefonos
				de este cliente*/
				this.$telefonos.append(vistaTelefono.render().el);
			};
		};
		this.$numeroNuevo = this.$('#numeroNuevo');
		this.$tipoNuevo = this.$('#tipoNuevo');
	},
	editando			: function () {
		if (this.$btn_editar.children().attr('class') 
			== 'icon-edit2 MO icon-back'
		) {
			this.$btn_editar
			.children()
			.toggleClass('MO icon-back');

			this.$editarAtributo.
			toggleClass('editando');

			this.render();
		} 
		else{
			this.$btn_editar
			.children()
			.toggleClass('MO icon-back');

			this.$editarAtributo
			.toggleClass('editando');
		};
	},
	eliminarTelefonos 	: function (idpropietario) {
		var telefonos = app.coleccionTelefonos.where({
			idpropietario:idpropietario,
			tabla:'contactos'
		});
		for (var i = 0; i < telefonos.length; i++) {
			telefonos[i].destroy({ wait:true })
		};
	},
});

app.VistaRepresentante = app.VistaContacto.extend({
	render				: function () {
		this.model.set({etiqueta:'Representante'});
		this.$el.html(this.plantilla( this.model.toJSON() ));

		this.$telefonos = this.$('#telefonos');
		this.agregarTelefono(this.model.get('id'), 'representantes');

		this.$btn_editar = this.$('#btn_editar');
		this.$editarAtributo = this.$('.editar');

		/*En caso de no haber teléfonos se hace referencia al
		formulario que tiene la plantilla por default*/
		this.$numeroNuevo = this.$('#numeroNuevo');
		this.$tipoNuevo = this.$('#tipoNuevo');

		return this;
	},
	crearTelefono		: function (e) {
		if (this.$numeroNuevo.val() != '' 
			&& typeof this.$tipoNuevo.val() != 'undefined') {

			/*Antes de guardar el nuevo telefono se valida
			  nuevamente que el número sea correcto*/
			if ( validarTelefono( this.$numeroNuevo ) ) {
				/*En caso de que el número no sea correcto,
				  evitamos recargar el botón*/
				e.preventDefault();
				/*Se evita seguir con la función*/
				return;
			};

			var json1 = pasarAJson(this.$numeroNuevo.serializeArray());
			var json2 = pasarAJson(this.$tipoNuevo.serializeArray());
			json1.tipo = json2.tipo;
			json1.idpropietario = this.model.get('id');
			json1.tabla = 'representantes';
			
			var here = this;

			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionTelefonos.create(
				json1,
				{
					wait	: true,//Esperamos respuesta del server
					// patch	: true,//Evitamos enviar todo el modelo
					success	: function (exito) {//Encaso del exito
						$(e.currentTarget)//Selector
						//Salimos del e
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
						here.$telefonos.html('<div class="editar"><div class="form-group"><div class="row"><div class="col-xs-4 col-sm-6"><input type="text" id="numeroNuevo" class="form-control" name="numero" onkeyup="validarTelefono(this)" placeholder="De 10 a 20 dígitos"></div><div class="col-xs-4 col-sm-4"><select id="tipoNuevo" class="form-control" name="tipo"><option value="No definido" selected style="display:none;">Tipo</option><option value="Casa">Casa</option><option value="Fax">Fax</option><option value="Movil">Movil</option><option value="Oficina">Oficina</option><option value="Personal">Personal</option><option value="Trabajo">Trabajo</option><option value="Otro">Otro</option></select></div><div class="col-xs-4 col-sm-2"><div class="btn-group" role="group" aria-label="..." style="margin:0px !important;"><button type="button" id="enviarTelefono" class="btn btn-default"><label class="icon-save"></label></button></div></div></div></div></div>');
						//Obtener nuevamente los telefonos del cliente
						here.agregarTelefono(here.model.get('id'), 'representantes');

						here.$editarAtributo.toggleClass('editando');
						here.$editarAtributo = here.$('.editar');
						here.$editarAtributo.toggleClass('editando');
					},
					error	: function (error) {//En caso de error
						$(e.currentTarget)//Selector
						//Salimos del e
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
		} else{ };
		e.preventDefault();
	},
	eliminarTelefonos 	: function (idpropietario) {
		var telefonos = app.coleccionTelefonos.where({
			idpropietario:idpropietario,
			tabla:'representantes'
		});
		for (var i = 0; i < telefonos.length; i++) {
			telefonos[i].destroy({ wait:true })
		};
	},
});
