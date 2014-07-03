var app = app || {};

app.VistaTelefono = Backbone.View.extend({
	tagName	: 'div',
	className	: 'divTelefono',
	plantilla : _.template($('#plantilla_telefono').html()),
	events	: {
		'keypress #numero'	: 'actualizarNumero',
		'change #numero'	: 'actualizarNumero',
		'change #tipo'	: 'actualizarTipo',
		
		/*Eventos de eliminación*/
		'click #intentarEliminacion'	: 'advertenciaEliminar',
		'click #alertasTelefono #eliminar'	: 'eliminar',
		'click #alertasTelefono #cancelar'	: 'cancelar',

		// 'blur #numero'	: 'validarTelefono',
		// 'click .close'	: 'cerrarAlerta'
		// 'click #editar'	: 'editando'
	},
	initialize	: function () {
		// this.listenTo(this.model, 'destroy', this.remove);
	},
	render	: function () {
		this.$el.html(this.plantilla( this.model.toJSON() ));
		this.$editar = this.$('.editar');
		return this;
	},

	//---------------------------------------------

	actualizarNumero	: function (elemento) {
		if (elemento.keyCode === 13 || elemento.type === 'change') {
			elemento.preventDefault();
			if (this.validarTelefono(elemento) === false) {
				return;
			};
			this.actualizar(elemento);
		};
	},

	actualizarTipo	: function (elemento) {
		if (elemento.type === 'change') {
			this.actualizar(elemento);
		};
	},

	actualizar 	: function (elemento) {
		this.model.save(
			pasarAJson(
				$(elemento.currentTarget).serializeArray()
			),
			{
				wait	: true,//Esperamos respuesta del server
				patch	: true,//Evitamos enviar todo el modelo
				success	: function (exito) {//En caso del exito
					$(elemento.currentTarget)//Selector
					//Nos hubicamos en el padre del selector
					.parents('tr')
					//Buscamos al hijo con la clase especificada
					.children('.respuesta')
					//Removemos su atributo class
					.html('<label class="icon-uniF479 exito"></label>');
				},
				error	: function (error) {//En caso de error
					$(elemento.currentTarget)//Selector
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

	advertenciaEliminar : function (elemento) {
		// if (elemento.keyCode != 13) {
		    // console.log(elemento);
			// elemento.preventDefault();
		    // return;
			this.$('#advertencia #comentario').text('El teléfono se eliminará por completo');
		    this.$('#advertencia').toggleClass('oculto');
			elemento.preventDefault();
		// };
	},

	eliminar	: function (elemento) {
		// if ($(elemento.currentTarget).attr('id') == 'eliminar') {
			// this.$('#advertencia #comentario').html('El teléfono se eliminará por completo');
	        // this.$('#advertencia').removeClass('oculto');
		// if (confirm('El teléfono se eliminará por completo')) {
		var esto = this;
		this.model.destroy({
			success	: function () {
				$(elemento.currentTarget)//Selector
				//Nos hubicamos en el padre del selector
				.parents('tr')
				//Buscamos al hijo con la clase especificada
				.children('.respuesta')
				//Removemos su atributo class
				.html('<label class="icon-uniF479 exito"></label>');
				esto.$el.remove();
			},
			error 	: function (error) {
				$(elemento.currentTarget)//Selector
				//Nos hubicamos en el padre del selector
				.parents('tr')
				//Buscamos al hijo con la clase especificada
				.children('.respuesta')
				//Sustituimos html por uno nuevo
				.html('<label class="icon-uniF478 error"></label>');
			}
		});
		// };
		// };
	},

	cancelar	: function (elemento) {
		$(elemento.currentTarget).parents('#advertencia').children('.close').click();
	},

	validarTelefono	: function (elemento) {
	    if ($(elemento.currentTarget).val().trim() == '') {
	    	$(elemento.currentTarget).parents('#advertencia').children('.close').click();
	    	
	        // this.$('#advertencia').removeClass('oculto');
	        this.advertenciaEliminar();
	        return false;
	    };
		// if(isNaN($(elemento.currentTarget).val().trim()) && $(elemento.currentTarget).val().trim() != '' ) {
		if(!(/^\d{10}$/.test($(elemento.currentTarget).val().trim())) ) {
	        this.$('#error #comentario').html('No ingrese letras u otros símbolos<br>Escriba 10 números<br>Establezca un tipo de teléfono');
	        this.$('#error').removeClass('oculto');
	        $(elemento.currentTarget).focus();
	    	return false;
	    } else{
	    	return true;
	    };
	    /*EL cierre de la alerta se realiza en en archivo VistaContacto.js*/
	},
	// cerrarAlerta	: function (elemento) {
	// 	console.log($(elemento.currentTarget).parent().attr('class'));
	// 	$(elemento.currentTarget).parent().addClass('oculto');
	// },
});