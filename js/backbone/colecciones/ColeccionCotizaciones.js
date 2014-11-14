var app = app || {};

app.ModeloCotizacion = Backbone.Model.extend({
	urlRoot : 'http://crmqualium.com/api_cotizaciones',

	// defaults: {
	// 	version : 1,
	// 	status:true,
	// 	visibilidad:true
	// },

	cambiarVisibilidad: function () {
		// this.respuesta = 'no lo pasa';
		this.save({
			visibilidad: !parseInt(this.get('visibilidad'))
		},{
			wait:true, 
			patch:true,
			success	:function (exito) {
				// ok('OK');
			},
			error 	:function (error) {
				if (error.toJSON().visibilidad == '1') {
					error('Error al Eliminar a <b>'+error.toJSON().nombreComercial+'</b>. Intentelo más tarde');
				} else{
					error('Error al Restaurar a <b>'+error.toJSON().nombreComercial+'</b>. Intentelo más tarde');
				};
			}
		});
	},
	cambiarStatus	: function () {
		this.save({
			status: !parseInt(this.get('status'))
		},{
			wait:true, 
			patch:true,
			success	:function (exito) {
				// ok('OK');
			},
			error 	:function (error) {
				if (error.toJSON().status == '1') {
					error('Error al Guardar la nueva versión de <b>'+error.toJSON().titulo+'</b>. Intentelo más tarde');
				} else{
					error('Error al Restaurar la nueva versión de <b>'+error.toJSON().titulo+'</b>. Intentelo más tarde');
				};
			}
		});
	},
	eliminarPermanente: function () {
		var arrayModels, original;
		
		// De  qué cotizacion se trata
		switch(this.get('version')) {
		case '1': // Es una original
			// Buscamos sus versiones
			// Los respaldamos en una variable
	        arrayModels = app.coleccionCotizaciones
	        				.where({idcotizacion:this.get('id')});
	        // Añadimos el original al array
	        arrayModels.push(this);
	        // Recorremos el array para
	        // eliminar cada modelos
        	for (var i = 0; i < arrayModels.length; i++) {
        		console.log(arrayModels.length);
				this.destroy_model(arrayModels[i]);
			};
	        break;
		default: // No es la original
			// Bucamos la original
	        original = app.coleccionCotizaciones
	        			.get(this.get('idcotizacion'));
	        // Buscamos las versiones
			arrayModels = app.coleccionCotizaciones
						.where({idcotizacion:original.get('id')});
			// Incluimos el original al array
			arrayModels.push(original);
			// Eliminamos cada uno de los modelos
	        for (var i = 0; i < arrayModels.length; i++) {
				this.destroy_model(arrayModels[i]);
			};
		}
	},
	destroy_model 	: function (model) {
		model.destroy({
			wait : true,
			success	: function (model) { },
			error	: function () {
				alerta('Ha ocurrido un error, inténtelo más tarde', function () {});
			}
		})
	}
});

var ColeccionCotizaciones = Backbone.Collection.extend({
	url   : 'http://crmqualium.com/api_cotizaciones',
	model : app.ModeloCotizacion,
	parse : function (response) {
		this.folio = response.folio.folio;

		return response.cotizaciones;
	},
	establecerFolio : function () {
		try {
			var abc = "ABCDFGHIJKLMNOPQRSTUVWXYZ",
				banderaceros = false;
			// crear array del folio
			this.folio = this.folio.split('');
			// quitamos la letra del folio y lo respaldamos
			// el array ya no tiene la letra
			var letra = this.folio.shift();
			// unimos los caracteres sobrantes
			// que son los números; aun es una cadena
			// respaldamos la cadena resultante
			var solonum = this.folio.join('');
			// respaldamos la longitud de la cadena
			var length = solonum.length;
			// convertimos la cadena en entero lo
			// respaldamos en la variable global del folio
			this.folio = parseInt(solonum);
			// verificamos el número tendría que ser
			// reiniciado u obtener el sig. folio.
			if ( this.folio == 999 ) {
				// obtenemos la siguiente letra del abcdario
				// en la variable abc
				letra = abc.charAt(abc.indexOf(letra) +1);
				// reiniciamos la numeración 
				this.folio = ['0','0','1'];
			} else {
				// aumentamos la numeración del folio
				this.folio = this.folio +1;
				// preparamos la bandera de adicion de ceros
				if (this.folio < 100) banderaceros = true;
				// concatenamos el numero a una cadena vacia
				// para obtener un nuevo array de números
				this.folio = (''+this.folio).split('');
			};
			// si la vandera es true, entonces añadimos los
			// ceros necesarios para acompletar 3 dígitos, de
			// lo contrario es un número mayor de 99 y estos 
			// ya son de 3 dígitos
			if (banderaceros) {
				for (var i = length +1; i > this.folio.length; i--) {
					// añadimos un cero al array por iteracion
					this.folio.unshift('0');
				};
			};
			// añadimos la letra al array folio
			this.folio.unshift(letra);
			// creamos un nueva cadena a partir
			// del array folio
			this.folio = this.folio.join('');
			// devolvemos el nuevo folio
			return this.folio;
		}
		catch(err) {
			return 'A001';
		}
	}
});