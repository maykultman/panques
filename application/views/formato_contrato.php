<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<h1>Contratito</h1>
	<section id="sectionContrato"></section>
</body>
</html>

<script type="text/template" id="plantilla_contrato">
	<h2><%- fechacreacion %></h2>
	<h2><%- fechafinal %></h2>
	<h2><%- fechafirma %></h2>
	<h2><%- fechainicio %></h2>
	<h2><%- id %></h2>
	<h2><%- idcliente %></h2>
	<h2><%- idrepresentante %></h2>
	<h2><%- nplazos %></h2>
	<h2><%- plan %></h2>
	<h2><%- plazo %></h2>
</script>

<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type="text/javascript">
	var app = app || {};
	
	
	
</script>
<!-- Utilerias -->
	<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<!-- Librerias Backbone -->
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
		app.coleccionServiciosContrato_LocalStorage = new ColeccionServiciosContrato_LocalStorage();
		app.coleccionPagos_LocalStorage = new ColeccionPagos_LocalStorage();
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
			el	: '#sectionContrato',
			initialize	: function () {
				this.cargarContratos();
			},
			cargarContrato	: function (contrato) {
				var vista = new V_HojaContrato({model:contrato});
				this.$el.append(vista.render().el);
			},
			cargarContratos	: function () {
				app.coleccionContratos_LocalStorage.each(this.cargarContrato, this);
			}
		});

		var consulta_Hoja = new Consulta_Hoja();
	</script>