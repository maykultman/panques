var app = app || {};

app.VistaConsultaServicios = Backbone.View.extend({
	el : '.contenedor_principal_modulos',

	events	: {
		'click #enviar'		  : 'guardarServicio',
		'click .cerrar'		  : 'cerrarAlerta',
		'click #btn_cancelar' : 'cancelarRegistro'
	},

	initialize	: function () {
		this.$tablaServicios = this.$('#consulta_tablaservicio');
		this.cargarServicios();
		this.listenTo( app.coleccionServicios, 'add', this.cargarServicio );
	    this.listenTo( app.coleccionServicios, 'reset', this.cargarServicios );

	    this.$nombre		= this.$('#nombre');
		this.$concepto		= this.$('#concepto');
		this.$precio		= this.$('#precio');
		//this.$masiva		= this.$('#masiva');
		this.$realizacion	= this.$('#realizacion');
		this.$descripcion	= this.$('#descripcion');

		// app.coleccionServicios.fetch();
	},

	render	: function () {},

	cargarServicio	: function (modelodeladd) {
		var vistaCatalogoServicio = new app.VistaCatalogoServicio( { model:modelodeladd } );
		this.$tablaServicios.prepend( vistaCatalogoServicio.render().el );
	},

	cargarServicios	: function () {
		app.coleccionServicios.each(this.cargarServicio, this);
	},
	
	guardarServicio	: function (elemento) {
		var modeloServicio = this.obtenerJsonServicio();
		// console.log(modeloServicio.nombre);
		 $('#formServicio')[0].reset();		 

		
		Backbone.emulateHTTP = true; //Variables Globales
		Backbone.emulateJSON = true; //Variables Globales
		app.coleccionServicios.create(
			modeloServicio, 
			{
				wait: true, 
				success: function (exito) {
					$('#nombre').val('');
					console.log('Fue exito ',exito);
					alert("Servicio registrado con exito");

				},
				error: function (error) {
					console.log('Fue error ',error);
					this.$('#alertasCliente #error #comentario')
					.html('Llene todos los campos');
				    this.$('#alertasCliente #error').toggleClass('oculto');
				    elemento.preventDefault();
				    return;
				}
			}
		);
		Backbone.emulateHTTP = false; //Variables Globales
		Backbone.emulateJSON = false; //Variables Globales
       
		elemento.preventDefault();// para que no recargue la pagina

	},

	cancelarRegistro : function (elemento){
             		
		 this.$('#alertasCliente #advertencia #comentario')
		 .html('¿Deseas cancelar el registro?');
		 this.$('#alertasCliente #advertencia').toggleClass('oculto');
		 //$('#formServicio')[0].reset();
	},

    cerrarAlerta	: function (elemento) {
    	console.log(elemento);
		$(elemento.currentTarget).parent().addClass('oculto');
	},

	obtenerJsonServicio	: function () {
		return {
			nombre		: this.$nombre.val().trim(),
			concepto	: this.$concepto.val().trim(),
			precio		: this.$precio.val().trim(),
			// masiva		: this.$masiva.val().trim(),
			realizacion	: this.$realizacion.val().trim(),
			descripcion	: this.$descripcion.val().trim()
		};
	}
});

app.vistaConsultaServicios = new app.VistaConsultaServicios();