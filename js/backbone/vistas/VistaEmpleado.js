var app = app || {};

app.VistaEmpleado = Backbone.View.extend({
	tagName	: 'tr',
	events	: {
		'click .checkbox_empleado'	: 'apilarEmpleado',
		
	},

	plantillaEmpelado : _.template($('#tds_empleado').html()),

	

	initialize	: function () {
		this.$tbody_empleados_seleccionados = $('#tbody_empleados_seleccionados');
	},

	render	: function () {
		this.$el.html(this.plantillaEmpelado( this.model.toJSON() ));
		return this;
	},

	apilarEmpleado	: function (elemento) {
		var vistaParticipante = new app.VistaParticipante({model:this.model});
		this.$tbody_empleados_seleccionados.append( vistaParticipante.render().el );
		$(elemento.currentTarget).attr('disabled',true);
		
		this.$el.css('color','#CCC');
	},
});

app.VistaParticipante = Backbone.View.extend({
	tagName	: 'tr',
	plantillaSeleccionado	: _.template($('#tds_empleado_seleccionado').html()),
	plantillaRol : _.template($('#input_rol').html()),
	events	: {
		'change .select_rol' : 'agregarRol',
		'click .btn_eliminarRol'	: 'eliminarRol'
	},
	initialize	: function () {
	},
	render	: function () {
		this.$el.html( this.plantillaSeleccionado(this.model.toJSON() ));
		this.$select_rol = this.$('.select_rol');
		this.$form_participante	= this.$('.form_participante');

		var esto = this;

		var text_nuevoRol 		= this.$el.find('.text_nuevoRol');
		var btn_nuevoRol = this.$el.find('.btn_nuevoRol');

		btn_nuevoRol.on('click', function () {
			var nuevoRol = text_nuevoRol.val().trim();
			if (nuevoRol !== '') {
				esto.$form_participante.append(esto.plantillaRol({id:nuevoRol, nombre:nuevoRol, name:'nombre'}));
				text_nuevoRol.val('');
			};
			text_nuevoRol.val('');
		});

		text_nuevoRol.on('keypress', function (e) {
			if (e.keyCode === 13 && $(this).val() !== '') {
				esto.$form_participante.append(esto.plantillaRol({id:$(this).val(), nombre:$(this).val(), name:'nombre'}));
				$(this).val('');
			};
		});

		this.cargarRoles();
		return this;
	},

	cargarRol	: function (rol) {
		var vistaRol = new app.VistaRol({ model:rol });
		this.$select_rol.append( vistaRol.render().el );
	},

	cargarRoles	: function () {
		app.coleccionRoles.each(this.cargarRol, this);
	},

	agregarRol	: function (elemento) {
						/*Obtenemos el valor del atributo value*/
		var opcionRol = $(elemento.currentTarget).val()
						/*Con la funcion split creamos un array*/
						.split('_');
		/**/
		this.$form_participante.append(this.plantillaRol({ id:opcionRol[0], nombre:opcionRol[1], name:'idrol' }));
		this.$select_rol.children('#'+opcionRol[0]).attr('disabled',true);
	},

	nuevoRol 	: function () {
		alert(this.$text_nuevoRol.val().trim());
	},

	eliminarRol 	: function (elemento) {
		this.$select_rol.children('#'+$(elemento.currentTarget).attr('value')).attr('disabled',false);
		$(elemento.currentTarget).parents('.tag_rol').remove();
	}
});
