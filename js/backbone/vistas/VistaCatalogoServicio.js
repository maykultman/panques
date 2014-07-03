var app = app || {};

app.VistaCatalogoServicio = app.VistaServicio.extend({
	tagName : 'tr',

	plantilla	: _.template($('#plantilla_servicio').html()),

	events	: {
		'click .editar2' : 'habilitarEdicion',
		'click .eliminar2'	: 'eliminar',
		'keypress .visible2'	: 'actualizar'
	},

	initialize	: function () {
		this.listenTo(this.model, 'change', this.render);
		this.listenTo(this.model, 'destroy', this.remove);
	},

	render	: function () {//Sirve para pintar el servicio
		this.$el.html( this.plantilla( this.model.toJSON() ) );
		return this; //Siempre es bueno retornar this enel render		
	},

	habilitarEdicion	: function () {
		this.$el.children().children().toggleClass('visible2');
	},

	actualizar	: function (elemento) {
		if (elemento.keyCode === 13) {
			var propiedadDelModelo = this.pasarAJson( $(elemento.currentTarget).serializeArray() );

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

	eliminar	: function () {
		this.model.destroy();
	},

	pasarAJson : function (objSerializado) {
	    var json = {};
	    $.each(objSerializado, function () {
	        if (json[this.name]) {
	            if (!json[this.name].push) {
	                json[this.name] = [json[this.name]];
	            };
	            json[this.name].push(this.value || '');
	        } else{
	            json[this.name] = this.value || '';
	        };
	    });
	    return json;
	},

	holamundo : function () {
		alert('Hola');
	}
});

/*En este archivo no se instancia un objeto de la clase
app.VistaServicios porque esta vista representa un modelo
cuando se recorra la coleccion de modelos de servicios se
crearan instanciarán objetos de esta clase*/