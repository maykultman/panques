var app = app || {};
// var f = new Date();

/*---------------------------------------------------------------*/
app.ModeloPago	= Backbone.Model.extend({
	urlRoot	: 'http://crmqualium.com/api_pagos'
});
var ColeccionPagos= Backbone.Collection.extend({
	model	: app.ModeloPago,
	url		: 'http://crmqualium.com/api_pagos'
});
app.ModeloContrato	= Backbone.Model.extend({
	urlRoot	: 'http://crmqualium.com/api_contratos',
	// defaults	: {
	// 	fechacreacion : f.getFullYear() + "-" + (f.getMonth() +1) + "-" + (f.getDate() +1)
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
					error('Error al Eliminar el contrato. Intentelo más tarde');
				} else{
					error('Error al Restaurar el contrato. Intentelo más tarde');
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
					error('Error al Guardar la nueva versión del contrato. Intentelo más tarde');
				} else{
					error('Error al Restaurar la nueva versión del contrato. Intentelo más tarde');
				};
			}
		});
	},
	eliminarPermanente: function () {
		// Verificamos si la cotización es la versión original
		// y si su eliminación fue como cotizacion activa.
		if (this.get('version')=='1' && this.get('status') == '1') {
			// this es una cotizacion original, entonces buscamos
			// las versiones para eliminarlas para no dejar 
			// residuos en la base de datos.
			var versiones = app.coleccionContratos.where({
				idcontrato:this.get('id'),
				status:'0',
			});
			// armamos un arreglo con todos los modelos para
			// iterar en ellos y eliminarlos.
			versiones = versiones.concat(this);
			for (var i = 0; i < versiones.length; i++) {
				this.destroy_model(versiones[i]);
			};
		} else if (this.get('status') == '1') {
			// this es una cotizacion original,
			// obtenemos cotización original pero que no
			// este activa
			var original = app.coleccionContratos.findWhere({
				id:this.get('idcontrato'),
				status:'0',
			});
			// buscamo las versiones para eliminarlas para
			// no dejar residuos en la base de datos.
			var versiones = app.coleccionContratos.where({
				idcontrato:this.get('idcontrato'),
				status:'0',
			});
			// armamos un arreglo con todos los modelos para
			// iterar en ellos y eliminarlos.
			versiones = versiones.concat(this);
			versiones = versiones.concat(original);
			varsinoes = _.uniq(versiones);
			for (var i = 0; i < versiones.length; i++) {
				this.destroy_model(versiones[i]);
			};
		} else {
			// Esto ocurre cuando la cotizacion tiene un estatus 0.
			// no importa si se trata  de una cotizacion original o
			// una versión.
			this.destroy_model(this);
		};
	},
	obtenerTodos	: function () {
		// 
	},
	destroy_model 	: function (model) {
		model.destroy({
			wait : true,
			success	: function (model) {
				// console.log(model.get('titulo')+' fue borrado');
			},
			error	: function () {
				alerta('Ha ocurrido un error, inténtelo más tarde', function () {});
			}
		})
	}
});
var ColeccionContratos = Backbone.Collection.extend({
	model			: app.ModeloContrato,
	url 	: 'http://crmqualium.com/api_contratos',
	parse : function (response) {
		this.folio = response.folio.folio;

		return response.contratos;
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
app.ModeloServicioContrato	= Backbone.Model.extend({
	urlRoot	: 'http://crmqualium.com/api_serviciosContrato'
});
var ColeccionServiciosContrato = Backbone.Collection.extend({
	model	: app.ModeloServicioContrato,
	url		: 'http://crmqualium.com/api_serviciosContrato'
});
/*---------------------------------------------------------------------------------*/

app.ModeloPago_L	= Backbone.Model.extend({
});
var ColeccionPagos_L = Backbone.Collection.extend({
	model	: app.ModeloPago_L,
	localStorage 	: new Backbone.LocalStorage('pagos-backbone'),
	ordenSiguente	: function () {
		if (!this.length) {
			return 1;
		};
		return this.last().get('id') + 1;
	}
});
app.ModeloContrato_L	= Backbone.Model.extend({
	// defaults	: {
	// 	fechacreacion : f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate()
	// }
});
var ColeccionContratos_L = Backbone.Collection.extend({
	model			: app.ModeloContrato_L,
	localStorage 	: new Backbone.LocalStorage('contratos-backbone'),
	ordenSiguente	: function () {
		if (!this.length) {
			return 1;
		};
		return this.last().get('id') + 1;
	}
});