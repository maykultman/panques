var app = app || {};

app.VistaServicio = Backbone.View.extend({
	tagName : 'tr',

	plantillaDefault	: _.template($('#plantilla_servicio').html()),

	events	: {
		'click .editar2' 		: 'habilitarEdicion',
		'click .eliminar2'		: 'eliminar',
		'keypress .visible2'	: 'actualizar'
	},

	initialize	: function () {
		this.listenTo(this.model, 'change', this.render);
		this.listenTo(this.model, 'destroy', this.remove);
	},

	render	: function () {
		// console.log(this.model.toJSON());
		this.$el.html( this.plantillaDefault( this.model.toJSON() ) );
		return this; //Siempre es bueno retornar this enel render		
	},

	habilitarEdicion	: function () {
		this.$el.children().children().toggleClass('visible2');
	},

	actualizar	: function (elemento) {
		if (elemento.keyCode === 13) {
			var propiedadDelModelo = pasarAJson( $(elemento.currentTarget).serializeArray() );

			this.model.save(
				propiedadDelModelo, 
				{
					wait:true,
					patch:true,
					success: function (exito){
						console.log(exito);
					}, 
					error: function (error){
						console.log(error);
					}
				}
			);
			elemento.preventDefault();
		};
	},

	eliminar	: function (e) {
		var isuser = $(e.currentTarget).data('set');		
		var self = this;
		if(isuser==1)
		{
			confirmar('<b>El Servico de '+this.model.get('nombre')+' no se puede eliminar esta siendo utilizado</b>', 
						function () {}, function () {});
		}else{
			confirmar('¿Desea eliminar este servicio?', function(){
				self.model.destroy();
			},function(){});
		}
	}
});

app.VistaConsultaServicios = Backbone.View.extend({
	el : '#contenedor_principal_modulos',

	events	: {
		'click #enviar'		  : 'guardarServicio',
		'click .cerrar'		  : 'cerrarAlerta',
		'click #btn_cancelar' : 'cancelarRegistro'
	},

	initialize	: function () {
		this.listenTo( app.coleccionServicios, 'add', this.cargarServicio );
	    this.listenTo( app.coleccionServicios, 'reset', this.cargarServicios );

		this.$tbody_servicios = this.$('.tbody-servicios');
	    this.$nombre		= this.$('#nombre');
		this.$concepto		= this.$('#concepto');
		this.$precio		= this.$('#precio');
		//this.$masiva		= this.$('#masiva');
		this.$realizacion	= this.$('#realizacion');
		this.$descripcion	= this.$('#descripcion');

		this.cargarServicios();
		// app.coleccionServicios.fetch();
	},

	render	: function () {},

	cargarServicios : function ()
	{	
		var self=this;
		app.coleccionServicios.each(function(servicio){
			self.$tbody_servicios.append(new app.VistaServicio({model:servicio}).render().el);
		},this);
	},
	guardarServicio	: function (elemento) {
		var modeloServicio = this.obtenerJsonServicio();
		// console.log(modeloServicio.nombre);
		 $('#formServicio')[0].reset();		 

		
		globaltrue();//vease en el archivo funcionescrm.js		
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
		globalfalse();//vease en el archivo funcionescrm.js	
       
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