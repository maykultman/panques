var app = app || {};

app.VistaServicioCotizacion = app.VistaServicio.extend({
	tagName : 'tr',
	plantillaDefault  : _.template($('#PCservicios').html()),

	serviciosAgregado : _.template($('#serviciosAgregado').html()),

	events : {
		'click .icon-info'        : 'mostrarDetalles',
		'click .serviciosCotizar' : 'agregarServiciosCo',		
	},

	initialize : function () {
		this.$trServicio = this.$('#trServicio');		
	},

	mostrarDetalles : function (icono) {
		this.$el.children().children().toggleClass('visibleI');			
	},

	agregarServiciosCo : function (elemento){

		// Instanciamos un modelo de servicio
		var vistaTrServicio = new app.VistaTablaCotizaciones({model : this.model});
		/* Llamamos a la funcion render de la clase app.VistaTablaCotizaciones
		   para que la pinte la vista agregada...*/
		$('#trServicio').append(vistaTrServicio.render().el);
		// Dado que solo una vez se agrega el servicio lo desactivamos de la lista...
		this.$(elemento.currentTarget).attr('disabled',true);		
	}

});

//###########################################################
app.VistaTablaCotizaciones = Backbone.View.extend({
	tagName : 'tr',
	className : 'fila',
    
	serviciosAgregado : _.template($('#serviciosAgregado').html()),

	events : {
		'keyup  .valor'     : 'establecerImporte2', 
        'click  .btndelete' : 'restarTotal'
 	},

	initialize : function(){
		this.$mostrarTabla = this.$('#mostrarTabla');
	},

	render : function(){
		/* Recibe el modelo de la vista servicio cotización y la pinta en pantalla */
		this.$el.html(this.serviciosAgregado( this.model.toJSON() ));
		/* Esta función establece el importe con los datos por default del servicio...*/
		this.establecerImporte();
		return this;
	},
	/* Habilita los inputs para la edicion de servicios que estan en la lista de servicios cotizando...*/
	habilitarEdicion : function (elemento){		
		this.$el.children().children().toggleClass('visibleI');		
	},

	/* Esta función obtiene los valores de la vista que se acaba de 
	   agregar o que se esta editando para sacar el importe del servicio...*/
	establecerImporte : function(){

        var total = Number($('#total').text());
		var cantidad  = this.$('#cantidad').val();			
		var precio    = this.$('#precio').val();
		var descuento = this.$('#descuento').val();
		var importe   = (cantidad * precio) - descuento;
		this.$('#importe').val(importe);		
        $('#total').text(total + importe);
	},

	establecerImporte2 : function(){

        var total 	  = Number($('#total').text());
		var cantidad  = this.$('#cantidad').val();			
		var precio    = this.$('#precio').val();
		var descuento = this.$('#descuento').val();
		var importe   = (cantidad * precio) - descuento;
		this.$('#importe').val(importe);
		
		this.$('#hduracion' ).val(this.$('#duracion' ).val());
        this.$('#hcantidad' ).val(this.$('#cantidad' ).val());
        this.$('#hprecio'   ).val(this.$('#precio'   ).val());
        this.$('#hdescuento').val(this.$('#descuento').val());

        
	},

    restarTotal : function(){
        var total   = Number($('#total').text());
        var importe = Number(this.$('#importe').val());
        $('#total').text(total - importe);
    }

});

