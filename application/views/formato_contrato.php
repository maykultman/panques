<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<h1>Contratito</h1>
	<!-- <section id="sectionContrato"> -->
		<div id="divVistapreviaContrato"></div>
	<!-- </section> -->
</body>
</html>

<script type="text/template" id="plantilla_contrato">
		fechacreacion: 			<%- formatearFechaUsuario(new Date(fechacreacion)) %>	<br>
		fechafinal: 			<%- formatearFechaUsuario(new Date(fechafinal)) %>		<br>
		fechafirma: 			<%- formatearFechaUsuario(new Date(fechafirma)) %>		<br>
		fechainicio: 			<%- formatearFechaUsuario(new Date(fechainicio)) %>		<br>
		id: 					<%- id %>												<br>
		idcliente: 				<%- idcliente %>										<br>
		idrepresentante: 		<%- idrepresentante %>									<br>
		nplazos: 				<%- nplazos %>											<br>
		plan: 					<%- plan %>												<br>
		plazo: 					<%- plazo %>											<br>
		
	</script>

<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type="text/javascript">
	var app = app || {};
	app.iva = 0.16;
	
	
	
	
	
</script>
<!-- Utilerias -->
	<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<!-- Librerias Backbone -->
	<script type="text/javascript" src="<?=base_url().'js/backbone/lib/jquery.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.localStorage.js'?>"></script>
<!-- modelos -->
	<!-- <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloCliente.js'?>"></script> -->
	<!-- <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloRepresentante.js'?>"></script> -->
	<!-- <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicio.js'?>"></script> -->
<!-- colecciones -->
	<!-- <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionClientes.js'?>"></script> -->
	<!-- <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionRepresentantes.js'?>"></script> -->
	<!-- <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServicios.js'?>"></script> -->
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionContratos.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServiciosContrato.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPagos.js'?>"></script>
	<script type="text/javascript">
		app.coleccionContratos_LocalStorage = new ColeccionContratos_LocalStorage();
		// app.coleccionServiciosContrato_LocalStorage = new ColeccionServiciosContrato_LocalStorage();
		// app.coleccionPagos_LocalStorage = new ColeccionPagos_LocalStorage();
	</script>
<!-- vistas -->
	<script type="text/javascript">
		app = app || {};
		var V_HojaContrato = Backbone.View.extend({
			tagName			: 'div',
			plantilla	: _.template($('#plantilla_contrato').html()),
			render		: function () {
				this.$el.html(this.plantilla(this.model.toJSON()));
				return this;
			}
		});

		var Consulta_Hoja	= Backbone.View.extend({
			el	: '#divVistapreviaContrato',
			initialize	: function () {
				this.listenTo(app.coleccionContratos_LocalStorage,'add',this.cargarContrato);
				app.coleccionContratos_LocalStorage.fetch();
				
				
				
				// this.cargarContratos();

			},
			cargarContrato	: function (contrato) {
				// var precio = 0.0;
				// var descuento = 0.0;
				// var total = 0.0;

				// var cantidades = app.coleccionServiciosContrato_LocalStorage.pluck('cantidad');
				// var precios = app.coleccionServiciosContrato_LocalStorage.pluck('precio');
				// var descuentos = app.coleccionServiciosContrato_LocalStorage.pluck('descuento');

				// for (var i = 0; i < cantidades[0].length; i++) {
				// 	precio 		= cantidades[0][i] * precios[0][i];
				// 	descuento 	=precio * ( descuentos[0][i]/100 );
				// 	total 		+= parseFloat((precio - descuento).toFixed(2));
				// };
				// contrato.set({total:(total + (total*app.iva)).toFixed(2)});
				var vista = new V_HojaContrato({model:contrato});
				this.$el.html(vista.render().el);
				// var ventana = window.open("formatoCotizacion","miventana","menubar=no");
				// console.log(ventana);
			},
			cargarContratos	: function () {
				app.coleccionContratos_LocalStorage.each(this.cargarContrato, this);
			}
		});

		var consulta_Hoja = new Consulta_Hoja();
	</script>