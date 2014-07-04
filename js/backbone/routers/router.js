var app = app || {};

app.Enrutador = Backbone.Router.extend({
	router 	: {
		'vistaPrevia'	: 'verCotizacion'
	},

	vistaPrevia	: function (algo) {
		console.log(algo);
	}
});
app.enrutador = new app.Enrutador();