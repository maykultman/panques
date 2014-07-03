var app = app || {};

app.VistaServicio = Backbone.View.extend({
	tagName		: 'li',
	events	: {
	},

	render	: function () {
		this.$el.html(this.plantillaDefault( this.model.toJSON() ));
		return this;
	}
});

app.VistaServicioInteres = app.VistaServicio.extend({
	plantillaDefault	: _.template($('#serviciosI').html()),

	events	: {
		'click .serviciosInteres'	: 'agregarIntereces'
	},

	initialize	: function () {
		this.$listaInteres        = $('#listaInteres');
	},

	agregarIntereces	: function () {
		var intereses = document.getElementsByName('nameServiciosInteres');
		for (var i = 0; i < intereses.length; i++) {
			if ($(intereses[i]).is(':checked')) {
				this.$listaInteres.append('<li class="list-group-item">'+$(intereses[i]).parent().parent().parent().first().text()+'<label id="'+$(intereses[i]).attr('id')+'" class="icon-uniF470" style="float: right;"><span></span></label><input type="checkbox" class="check_posicion" name="serviciosInteres" value="'+$(intereses[i]).attr('id')+'" checked></li>');
				$(intereses[i]).attr('checked',false);
				break;
			};
		};
	}	
});

app.VistaServicioCuenta = app.VistaServicio.extend({
	plantillaDefault	: _.template($('#serviciosC').html()),

	events	: {
		'click .serviciosCuenta'	: 'agregarCuentas'
	},

	initialize	: function () {
		this.$listaCuenta         = $('#listaCuenta');
	},

	agregarCuentas	: function () {
		var cuenta = document.getElementsByName('nameServiciosCuenta');
		for (var i = 0; i < cuenta.length; i++) {
			if ($(cuenta[i]).is(':checked')) {
				this.$listaCuenta.append('<li class="list-group-item">'+$(cuenta[i]).parent().parent().parent().first().text()+'<label id="'+$(cuenta[i]).attr('id')+'" class="icon-uniF470" style="float: right;"><span></span></label><input type="checkbox" class="check_posicion" name="serviciosCuenta" value="'+ (parseInt($(cuenta[i]).attr('id'))-100) +'" checked></li>');
				$(cuenta[i]).attr('checked',false);
				break;
			};
		};
	}	
});


/*Clase para el modulo de proyecto nuevo*/
// app.VistaServicioProyecto = app.VistaServicio.extend({
// 	tagName	: 'tr',
// 	plantilla	: _.template($('#tds_servicio').html())
// });