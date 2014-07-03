var app = app || {};

var ColeccionArchivos = Backbone.Collection.extend({
	model	: app.ModeloArchivo,

	// localStorage	: new Backbone.LocalStorage('archivos-backbone'),
	url 	:'http://qualium.mx/sites/crmqualium/api_archivos',

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

app.coleccionArchivos = new ColeccionArchivos(app.coleccionArchivosCodeIgniter);
