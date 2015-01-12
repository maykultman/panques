var app = app || {};

app.ModeloProyecto = Backbone.Model.extend({
	urlRoot:'http://crmqualium.com/api_proyectos',
	defaults: {
		entregado:false
	},
	conmutarStatus: function () {
		self = this;
		this.save({
				status: function (status) {
					if ( _.isBoolean( status ) ) {
						return !status
					} else{
						return !parseInt(status)
					};
				}(this.get('status'))
			},{
				wait:true, 
				patch:true,
				success:function (model) {
					// console.log(exito.toJSON());
				},
				error:function (model) {
					if (model.toJSON().status == '1' || model.toJSON().status == true) {
						error('Error al intentar pausar el proyecto');
					} else{
						error('Error al intentar reanudar el proyecto');
					};
				}
			}
		);
	},
	conmutarEntrega: function () {
		self = this;
		if ( this.get('entregado') != '1' || this.get('entregado') != true ) {
			this.save({
					entregado: function (entregado) {
						if ( _.isBoolean( entregado ) ) {
							return !entregado
						} else{
							return !parseInt(entregado)
						};
					}(this.get('entregado'))
				},{
					wait:true, 
					patch:true,
					success:function (model) {
						// console.log(exito.toJSON());
					},
					error:function (model) {
						if (model.toJSON().entregado == '1' || model.toJSON().entregado == true) {
							error('Error al intentar pausar el proyecto');
						} else{
							error('Error al intentar reanudar el proyecto');
						};
					}
				});
		};
	}
});

var ColeccionProyectos = Backbone.Collection.extend({
	
	model	: app.ModeloProyecto,

	url: 'http://crmqualium.com/api_proyectos',
	// localStorage	: new Backbone.LocalStorage('proyectos-backbone'),

	obtenerTodos : function () {
		return this.filter( function (proyecto){
			return proyecto.get('id');
		});
	},

	obtenerUltimoId	: function () {
		return this.last().get('id');
	},

	obtenerUltimo	: function () {
		return this.last();
	},

	// parse	: function (response) {
	// 	return response;
	// },
});

