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
	establecerDatos	: function () {
		var idcotizacion 	= this.model.get('id'),
			secciones 		= app.coleccionServiciosCotizados
								 .where({
								 	idcotizacion:idcotizacion
								 }),
			idservicio 		= '',
			json 			= {},
			preciohora 		= this.model.get('preciohora'),
			vSeccion,
			folio,
			$select = this.$('#busqueda')[0].selectize,
			// pagos,
			// pago,
			// Modelo,
			// vistaPago = [],
			// enunciados,
			self = this;
		/*La función render de la clase padre no establece
		el nuevo folio para la nueva versión de la cotización.
		esto es porque la longitud de la colección es mayor
		aquí. Tenemos que realizarlo manualmente.
		También tenemos que estanblecer el folio que viene
		desde le servidor, del array de objetos a la coleccion
		de cotizaciones de Backbone. 
		/*--DESCOMENTAR SI LOS FOLIO NUNCA DEBEN REPETIRSE--*/
			// app.coleccionContratos.folio 
			// 	= app.coleccionDeContratos.folio.folio;
			folio = app.coleccionContratos.establecerFolio();
		this.$('#h4_folio')
				.text( 'Folio: '+ folio )
				.fadeIn('fast');
		this.$('input[name="folio"]').val( folio );

		this.$('#prestacion').val(this.model.get('titulo'));
		$select.setValue(this.model.get('idcliente'));
		this.$('input[name="idcliente"]').val(this.model.get('idcliente'));

		this.$('input[name="descuento"]')
			.val(this.model.get('descuento'));

		for(i in secciones) {
			if (secciones[i].get('idcotizacion') == idcotizacion) {
				if (idservicio != secciones[i].get('idservicio')) {
					idservicio = secciones[i].get('idservicio');
					this.$('#servicio_'+idservicio).click();
					this.$el
						.find('#table_servicio_'+idservicio+' tbody')
						.html('');
				};
				json = secciones[i].toJSON();
				json.preciohora = preciohora;
				vSeccion = new VistaSeccion();
				this.$('#table_servicio_'+idservicio+' tbody')
					.append( vSeccion.render(json).el );
			};
		}
		this.$('#precio_hora')
			.val(preciohora)
			.trigger('change');
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