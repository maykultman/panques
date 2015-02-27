var app = app || {};

app.ModeloContacto = Backbone.Model.extend({

	urlRoot	:root+'/api_contactos'
	
	// defaults	: {
	//  idCliente : '',
	// 		 tipo : '',
	// 	   nombre : '',
 //   	   correo : '',
 //    		cargo : '',
	// 	telefonos : ''
	// }
});