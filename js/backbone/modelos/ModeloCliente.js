var app = app || {};
var f = new Date();
app.ModeloCliente = Backbone.Model.extend({

	urlRoot	:'http://qualium.mx/sites/crmqualium/api_cliente',
	
	defaults	: {
			   // nombreComercial : '',
			 //      nombreFiscal : '',
			 //             email : '',
			 //               rfc : '',
			 //         paginaWeb : '',
			 //              giro : '',
			 // comentarioCliente : '',
			 //         direccion : '',
			       // tipoCliente : '',
			 //  telefonosCliente : '',
			 //  serviciosInteres : '',
			 //   serviciosCuenta : '',
			 //              logo : '',
					  visibilidad : true,
					fechaCreacion : f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate()
	},

	cambiarVisibilidad: function () {
		this.respuesta = 'no lo pasa';
		var esto = this;
		this.save(
			{
				visibilidad: !this.get('visibilidad')
			},
			{
				wait:true, 
				patch:true,
				success:function () {
				},
				error:function () {
				}
			}
		);
	},
	
	// conmutar	: function () {
	// 		if (this.get('visibilidad') == 0) {
	// 			return 1;
	// 		} else{
	// 			return 0;
	// 		};
	// 	}
	// validate: function (atributos) {
	// 	if (atributos.nombreComercial == "") {
	// 		alert('especifique el un nombre para el cliente');
	// 	}
	// 	if (atributos.tipoCliente == "") {
	// 		alert('especifique el tipo de cliente');
	// 	}
	// },

	// fechaCreacion : function () {
	 	
	//  	return '' + f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate() + '';
	// }
});

// app.clienteDefault = new app.ModeloClente();
// console.log(app.clienteDefault.toJSON()); //Imprime el modelo
// console.log(app.clienteDefault.get('tipoCliente')); //Imprime el atributo especificado