 app = app || {};

var pdatos = Backbone.View.extend({
 	tanName : 'div',
 	plantilla : _.template($('#datosCliente').html()),
 
 	render : function()
 	{
 		this.$el.html(this.plantilla(this.model.toJSON()));
 		return this;
 	}
 });

var pServicios = Backbone.View.extend({
 	tagName : 'tr',
 	className : '.table',
 	plantilla : _.template($('#filaServicio').html()),
 
 	render : function()
 	{
 		this.$el.html(this.plantilla(this.model.toJSON()));
 		return this;
 	}
 });

var pPreviaCotizacion = Backbone.View.extend({
 	el : 'body',

 	initialize : function()
 	{
 		this.array = 0,
 		app.coleccionCotizaciones.fetch();
 		this.cargarCotizaciones();
 		app.coleccionServicios.fetch();
 		this.cargarServicios();

 	},

 	cargarCotizacion : function(modelo)
 	{
 		// console.log(fecha);
 		modelo.set({ fecha      :  formatearFechaUsuario(new Date(modelo.get('fecha')))  });
 		modelo.set({nombreComercial:app.coleccionClientes.get({id:modelo.get('idcliente')}).get('nombreComercial')});	
 		modelo.set({nombre:app.coleccionRepresentantes.get({id:modelo.get('idrepresentante')}).get('nombre')});	
 		var cotizacion = new pdatos({ model : modelo});
 		this.$('#previaCotizacion').html(cotizacion.render().el);
 	},

 	cargarCotizaciones : function()
 	{
 		app.coleccionCotizaciones.each(this.cargarCotizacion, this);
 	},
 	cargarServicio : function(modelo)
 	{
 		modelo.set({ idservicio : app.coleccionServicios.get
 				  ({ id         : modelo.get('idservicio')}).get('nombre'),
 				     importe    : (Number(modelo.get( 'precio'    ) ) )*
 				     			  (Number(modelo.get( 'cantidad'  ) ) )-
 				     			  (Number(modelo.get( 'descuento' ) ) ) 				  	 
 				  });

 		var vista = new Servicios({ model: modelo});
 		this.$('#tbody').append( vista.render().el);
 		this.array += parseInt(modelo.get('importe'));		
 		
 	},

 	cargarServicios : function()
 	{
 		app.coleccionServicios.each(this.cargarServicio, this);
 		$('#total').text('$'+this.array);
 	}
 });

 app.ppreviaCotizacion = new pPreviaCotizacion();