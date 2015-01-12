var app = app || {};

app.VistaConsultaProyectos = Backbone.View.extend({
	el	: '#div_fullHeight',
	events	: {
		'click .todos'	    : 'marcarTodosCheck',
		'click #btn_eliminarVarios'	: 'eliminarVarios',
		'click #btn_entregarVarios'	: 'entregarVarios',
	},

	initialize	: function () {
		this.$tbody_proyectos = this.$('#tbody_proyectos');
		this.listenTo( app.coleccionProyectos, 'add', this.cargarProyecto );
		this.cargarProyectos();
		this.cargarPlugin();
	},
	render	: function () {},
	marcarTodosCheck : function(e) {
        marcarCheck(e, '#'+this.$el.attr('id'));
    },
    eliminarVarios 				: function () {
		var mensaje, ids, self = this;
		if (this.$('input[name="todos"]:checked').val()) {
			mensaje = '¿Deseas borrar los proyectos seleccionados?<br><b>Toda la información relacionada con los proyectos será borrada</b>';
			confirmar(mensaje,
				function () {
					ids = pasarAJson(self.$('input[name="todos"]:checked').serializeArray()).todos;
					if ($.isArray(ids)) {
						for (var i = 0; i < ids.length; i++) {
							app.coleccionProyectos.get(ids[i]).destroy({
								wait 	: true,
								success	: function (exito) {
								},
								error	: function (error) {
									error('Error al Borrar a <b>'+error.toJSON().nombre+'</b>. Intentelo más tarde');
								}
							});
						};
					} else{
						app.coleccionProyectos.get(ids).destroy({
							wait 	: true,
							success	: function (exito) {
							},
							error	: function (error) {
								error('Error al Borrar a <b>'+error.toJSON().nombre+'</b>. Intentelo más tarde');
							}
						});
					};
				},
				function () {});
		};
	},
	entregarVarios 	: function () {
		var mensaje, ids, self = this;
		if (this.$('input[name="todos"]:checked').val()) {
			mensaje = '¿Deseas dar por terminado y entregar los proyectos seleccionados?<br><b>No podrás revertir esta acción.</b>';
			confirmar(mensaje,
				function () {
					ids = pasarAJson(self.$('input[name="todos"]:checked').serializeArray()).todos;
					if ($.isArray(ids)) {
						for (var i = 0; i < ids.length; i++) {
							app.coleccionProyectos.get(ids[i]).conmutarEntrega({
								wait : true,
								success	: function (exito) {
								},
								error	: function (error) {
									error('No se pudo dar por terminado <b>'+error.toJSON().nombre+'</b>. Intentelo más tarde');
								}
							});
						};
					} else{
						app.coleccionProyectos.get(ids).conmutarEntrega({
							wait : true,
							success	: function (exito) {
							},
							error	: function (error) {
								error('No se pudo dar por terminado <b>'+error.toJSON().nombre+'</b>. Intentelo más tarde');
							}
						});
					};
				},
				function () {});
		};
	},
	cargarProyecto	: function (modeloProyecto) {
		var propietario = app.coleccionClientes.get({id:modeloProyecto.get('idcliente')});
		if (typeof propietario != 'undefined') {
			modeloProyecto.set({propietario:propietario.get('nombreComercial')});
			var vistaProyecto = new app.VistaProyecto( {model:modeloProyecto} );
			this.$tbody_proyectos.append( vistaProyecto.render().el );
		};
	},
	cargarProyectos	: function () {
		app.coleccionProyectos.each( this.cargarProyecto, this );
	},
	cargarPlugin 	: function () {
		var options = {
			widthFixed : true,
			showProcessing: true,
			headerTemplate: '{content} {icon}', // Add icon for jui theme; new in v2.7!

			widgets: [ 'zebra', 'cssStickyHeaders', 'filter' ],

			widgetOptions: {
				filter_columnFilters   : false,
				filter_external : '.search',
				cssStickyHeaders_offset        : 0,
				cssStickyHeaders_addCaption    : true,
				cssStickyHeaders_attachTo      : null,
				cssStickyHeaders_filteredToTop : true,
				cssStickyHeaders_zIndex        : 1
			}

		};
		/* make second table scroll within its wrapper */
		options.widgetOptions.cssStickyHeaders_attachTo = '.wrapper'; // or $('.wrapper')
			this.$("#tabla_principal").tablesorter(options);
	}
});

app.vistaConsultaProyectos = new app.VistaConsultaProyectos();