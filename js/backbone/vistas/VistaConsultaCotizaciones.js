var app = app || {};
app.VistaEdicionCotizacion = app.VistaNuevaCotizacion.extend({
	el : '#section_actualizar',

	events : {
		'click #guardarEdicion' : 'guardarVersion'
	},

	establecerCotizacion : function()
	{
		var self = this;
		this.$('#titulo').val(this.model.get('titulo'));
		this.$('#cliente').val(this.model.get('cliente'));
		this.$('#fecha').val(this.model.get('fecha'));
		this.$('#detalles').val(this.model.get('detalles'));
		this.$('#caracteristicas').val(this.model.get('caracteristicas'));
		var rep = app.coleccionRepresentantes.findWhere({id : this.model.get('idrepresentante')}).get('nombre');

		this.$('#htitulo').val(this.model.get('titulo'));
		this.$('#idcliente').val(this.model.get('idcliente'));
		this.$('#idrepresentante').val(this.model.get('idrepresentante'));

		this.$('#representante').val(rep);
		
		this.$('#trServicio').html('');
		_.filter(app.coleccionServiciosCotizados.models, function(model){
			if(model.get('idcotizacion')==self.model.get('id'))
			{
				self.apilarServicioCotizacion(model);
			}
		});
	},

	apilarServicioCotizacion : function(modelo)
	{
		var servicio = app.coleccionServicios.get({ id : modelo.get('idservicio')});

		modelo.set({
			nombre : servicio.get('nombre'),
		});
		
		var vista = new app.VistaTablaCotizaciones ({ model : modelo});
		this.$('#trServicio').append(vista.render().el);
	},

	guardarVersion : function()
	{
		var f = new Date();
        var modelocotizacion = pasarAJson($('#registroCotizacion').serializeArray());

        modelocotizacion.fecha = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
        modelocotizacion.idempleado = '65';
         
        var serviciosCotizados = pasarAJson($('.filas').serializeArray());
        var longitud = serviciosCotizados.id;
        
	}
});
app.VistaCotizacion = Backbone.View.extend({
	tagName : 'tr',

	plantilla : _.template($('#tabla_Cotizacion').html()),

	events : {
		'click .icon-trash' : 'eliminarCotizacion',
		'click .icon-uniF5E2' : 'pasarAContrato',
		'click .tr_btn_editar' : 'edicionCotizacion'
	},

	initialize : function (){
		this.listenTo( this.model, 'destroy', this.remove);
	},

	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	},

	eliminarCotizacion : function ()
	{
		this.model.destroy();
	},

	edicionCotizacion : function()
	{
		vista = new app.VistaEdicionCotizacion({ model : this.model});
		vista.establecerCotizacion();
	},

	pasarAContrato : function()
	{
		alert('contrato');
	}

});

app.VistaConsultaCotizaciones = Backbone.View.extend({
	 el : '.contenedor_principal_modulos',

	 events : 
	 {
	 	'click  #marcar'    	 : 'marcarTodos',
	 	'click  #desmarcar' 	 : 'desmarcarTodos',
	 	'click  #eliminar'  	 : 'eliminarMarcados',
        'click  #buscarCliente'  : 'busqueda',
        'click  #todos' 		 : 'marcarTodosCheck',
        'click  #buscarEmpleado' : 'busqueda',
        'keyup  #buscarCliente'  : 'borrayRenderiza',        
        'keyup  #buscarEmpleado' : 'borrayRenderiza',
        'click 	.abajo'          : 'ordenarporfecha',
		'click  .arriba'         : 'ordenarporfecha',
	 },

	 initialize : function ()
	 {
	 	this.$tablaCotizaciones = this.$('#lista_cotizaciones');
	 	this.cargarCotizaciones(); 
	 	
		this.listenTo( app.coleccionCotizaciones, 'add', this.cargarCotizacion );
		this.listenTo( app.coleccionCotizaciones, 'reset', this.cargarCotizaciones);	 			
	 },

	cargarCotizacion : function (modelo)
	{
	 	var cantidad  = 0;	 	var precio = 0;	 	
	 	var descuento = 0;	 	var total  = 0;
	 	
	 	/* Busqueda de id´s en cada colección*/
	 	var servicio = app.coleccionServiciosCotizados.where ({ idcotizacion : modelo.get( 'id' ) });

	 	 /*Este ciclo es para calcular el total de todos los servicios que le pertenece a una cotización*/
	 	for(var i = 0; i < servicio.length; i++ )
	 	{
	 		/*...Le pedimos el dato para hacer la operación total a la colección de servicios...*/
	 		cantidad  = Number( servicio[i].get( 'cantidad'  ) );
	 	 	precio 	  = Number( servicio[i].get( 'precio'    ) );
	 	 	descuento = Number( servicio[i].get( 'descuento' ) );
	 	 	/*Despues de obtener los datos hacemos la operación para calcular el total*/
	 	 	total 	  += cantidad * precio - descuento;
	 	}
	 	/*...Añadimos campos a la colección de modelocotización...*/ 	 	
	 	modelo.set
	 	({    
	 		'empleado' : app.coleccionEmpleados.get ({ id : modelo.get( 'idempleado' )} ).get('nombre'),
	 		'cliente'  : app.coleccionClientes. get ({ id : modelo.get( 'idcliente'  )} ).get('nombreComercial'), 
			'total'    : total
	 	});
	 	
	 	/*...Ahora Instanciamos nuestra vistaCotización y le enviamos el modelo acabado de crear...*/
	 	var vistaCotizacion = new app.VistaCotizacion({model : modelo});
	 	/*...Lo añadimos a la tabla para que se apile en la interfaz, mediante el metodo render de la vistaCotización...*/
	 	this.$tablaCotizaciones.append( vistaCotizacion.render().el);
	},

	cargarCotizaciones : function ()
	{
		this.$tablaCotizaciones.html('');
	 	app.coleccionCotizaciones.each(this.cargarCotizacion, this);
	},

	ordenarporfecha : function(fecha)
	{	app.coleccionCotizaciones.reset( app.coleccionCotizaciones.toJSON().reverse() );
		// app.coleccionDeCotizaciones = app.coleccionCotizaciones.toJSON();
		ordenar(fecha);
	},

	busqueda : function(elemento)
	{
		autocompleteGenerico(elemento, this, app.coleccionCotizaciones, this.$tablaCotizaciones);
	},	

    borrayRenderiza	: function (e) 
    {
		if(e.keyCode===8)
        {
        	this.cargarCotizaciones();
        }
	},

	marcarTodosCheck : function(elemento)
	{
		marcarCheck(elemento);
    },

    eliminarMarcados : function()
    {
    	var ides = document.getElementsByName('todos');
         var array = new Array();
         for (var i = 0; i < ides.length; i++) 
         {
            if ($(ides[i]).is(':checked')) {
               array.push(ides[i]);
            };
         };

         for (var i = 0; i < array.length; i++) 
         {
            $(array[i])
            .parents('tr')
            .children('.iconos-operaciones')
            .children('.icon-trash')
            .click();
         };

         $('#todos').attr('checked', false);
         event.preventDefault(); 
    }
});

app.VistaGeneral = Backbone.View.extend({
	el 		: '.contenedor_principal_modulos',
	events	: {
		'click .icon-edit2'	: 'editar',
		'click #btn_calcelar'	: 'cancelar'
	},
	editar 		: function () {
		$('.visiblito').toggleClass('ocultito');
	},
	cancelar	: function () {
		$('.visiblito').toggleClass('ocultito');
		window.scrollTo(0,0);
	},
});

app.vistaGeneral = new app.VistaGeneral();
app.vistaConsultaCotizaciones = new app.VistaConsultaCotizaciones();