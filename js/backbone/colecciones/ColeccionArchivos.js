var app = app || {};

urlRoot	:'http://crmqualium.com/api_archivos'

app.ModeloArchivo = Backbone.Model.extend({
	// defaults	: {
	// 		nombre	: '',
	// 		  tipo	: '',
	// 	comentario	: ''
	// }
});

var ColeccionArchivos = Backbone.Collection.extend({
	model	: app.ModeloArchivo,

	// localStorage	: new Backbone.LocalStorage('archivos-backbone'),
	url 	:'http://crmqualium.com/api_archivos',

	obtenerTodos : function () {
		return this.filter( function (archivo){
			return archivo.get('id');
		});
	},

	/*establecerIdSiguiente	: function () {
		if(!this.length){
			return 1;
		}
		return this.last().get('idArchivo') + 1;
	}*/
});
