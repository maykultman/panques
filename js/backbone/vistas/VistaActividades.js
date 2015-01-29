var app = app || {};
app.VistaActividades = Backbone.View.extend({
	el:'#contenedor_principal_modulos'
	events  	: {
		'click #getList' : 'consultar'
	},
	initialize 	: function () {},
	crear 		: function () {},
	consultar 	: function (e) {
		$.get()
		e.preventDefault();
	},
	actualizar 	: function () {},
	eliminar 	: function () {},
});