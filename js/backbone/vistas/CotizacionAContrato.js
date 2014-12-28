app = app || {};
app.VistaPago.prototype.modificarPago = function(e){
	clearTimeout(this.timer);
	var self = this;
	this.timer = setTimeout(function() {
		var actual = parseFloat(self.model.get('pago')),
			idVista = parseInt($(e.currentTarget).attr('id'));
		var diferencia = (
			actual - parseFloat( 
						self.model.set({
							pago:$(e.currentTarget).val()
						},{
							wait:true
						}).get('pago') )
					).toFixed(2);
		self.bloquear(e);
		app.vistaEdicion.equilibrarPagos(diferencia, idVista);
		self.desbloquear();
		self.$('#'+idVista).select();
	}, 200);
};

app.CotizacionAContrato = app.VistaNuevoContrato.extend({
	el : '#section_actualizar',

	render 					: function () {
		this.$('#formPrincipal').html( $('#plantilla-formulario-contrato').html() );
		
		// Invocamos el metodo para cargar y pintar los servicios
		this.cargarServicios();

		this.cargarPlugins();

		// this.$('#fecha').val( formatearFechaUsuario(new Date()) );
		/*BORRAR PARA PRODUCCIÓN (HAY MÁS)*/this.$('#prestacion').val('Contrato No. '+(Math.random()).toFixed(3) *1000);

		/*FOLIO. En la cración de una cotización ocurrira el fetch,
		  pero cuando se edite una cotización no se realizará*/
		if (app.coleccionContratos.length == 0) {
			app.coleccionContratos.fetch({reset:true});
		};
		return this;
	},
	establecerDatos : function() {
		var idcotizacion 	= this.model.get('id'),
			arrayServicios	= function () {
				// debido a que los servicios no son ordenados en la 
				// base de datos en el orden en que son enviados, sino
				// que el primero que llega la servidor se almacena;
				// tenemos que ordenarlos manualmente para mostrar la
				// cotizacion tal cual fue creada, con los servicios y
				// secciones correspondientes. De lo contrario no se
				// muestran todas las secciones de la cotización.

				// Funciones Underscorejs: _.where, _.groupBy y _.values

				// Buscamos todos los servicios de la cotización a editar
				var jsonSecciones = _.where(app.coleccionServiciosCotizados.toJSON(),{
					idcotizacion:idcotizacion
				});
				// Agrupanos los servicios por medio del id de servicios.
				// Esto da como resultados un json donde la clave es el id
				// de servicio y el valor es un array que son las secciones
				// de los servicios.
				var groposServicios = _.groupBy(jsonSecciones,'idservicio');
				// Antes de devolver el resultado tenemos que quitar las claves
				// que la instrucción anterior genero, esto para poder manipular
				// el array de arrays con mayor facilidad.
				return _.values(groposServicios);
			}(),
			idservicio 		= '',
			json 			= {},
			preciotiempo 	= this.model.get('preciotiempo'),
			vSeccion,
			folio,
			$select = this.$('#busqueda')[0].selectize;

		this.tipoPlan = this.model.get('plan');

		/*La función render de la clase padre no establece
		el nuevo folio para la nueva versión de la cotización.
		esto es porque la longitud de la colección es mayor
		aquí. Tenemos que realizarlo manualmente.
		También tenemos que estanblecer el folio que viene
		desde le servidor, del array de objetos a la coleccion
		de cotizaciones de Backbone. 
		/*--DESCOMENTAR PARA QUE LOS FOLIO NUNCA SE REPETIRAN--*/
			/*app.coleccionCotizaciones.folio 
				= app.coleccionDeCotizaciones.folio.folio;
			folio = app.coleccionCotizaciones.establecerFolio();*/
		this.$('#h4_folio')
				.text( 'Folio: '+ this.model.get('folio') )
				.fadeIn('fast');
		this.$('input[name="folio"]').val( this.model.get('folio') );

		this.$('#serviciosolicitado').val(this.model.get('titulo'));
		$select.setValue(this.model.get('idcliente'));
		this.$('input[name="idcliente"]').val(this.model.get('idcliente'));

		this.$('input[value="'+this.model.get('plan')+'"]').click();

		this.bloquearInputs();

		this.$('#detalles')
			.val(this.model.get('detalles'));
		/*this.$('#caracteristicas')
			.val(this.model.get('caracteristicas'));*/


		this.$('input[name="descuento"]')
			.val(this.model.get('descuento'));

		// Tenemos las json_secciones de los servicios lista,
		// iteramos sobre el array.
		for(i in arrayServicios) {
			// En primer lugar tenemos que apilar el servicio en
			// la tabla de servicios y borrar las secciones que
			// apila automaticamente.
			idservicio = arrayServicios[i][0].idservicio;
			this.$('#servicio_'+idservicio).click();
			this.$el.find('#table_servicio_'+idservicio+' tbody').html('');
			// Apilamos las secciones del servicio en turno y que son propios
			// de la cotizacion a editar.
			for(j in arrayServicios[i]){
				arrayServicios[i][j].preciotiempo = preciotiempo;
				vSeccion = new VistaSeccion();
				this.$('#table_servicio_'+idservicio+' tbody')
					.append( vSeccion.render(arrayServicios[i][j]).el );
			}
		}

		switch(this.tipoPlan){
			case 'iguala':
				this.$('#precio_mes')
					.val(preciotiempo)
					.trigger('change');
			break;
			case 'evento':
				this.$('#precio_hora')
					.val(preciotiempo)
					.trigger('change');
			break;
		}			
	},
	establecerRegreso : function  () {
		var self = this;
		$('.btn_toggle').on('click', function () {
			// Conmutamos la visibilidad de las
			// secciones
			$('#seccion_tabla').fadeToggle();
			$('#section_actualizar').fadeToggle();
			// Borramos el contenido del formulario
			$('#formPrincipal').html('');
			// Apagamos el evento clic del botón regresar
			$('.btn_toggle').off('click');
			// Apagamos todos los eventos de la vista
			// edición
			self.$el.off();
		});
	},
	guardado				: function () {
		if (this.aumentarContador() == this.totalelementos) {
			var self = this;
			$('#block').toggleClass('activo');
			alerta('¡Contrato guardado!', function () {
				location.href = 'contratos_historial';
			});
		};
	},
});