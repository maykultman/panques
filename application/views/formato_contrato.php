<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<style type="text/css">
		* {
			font-family: Open Sans;
		}
		body {
			margin: 0px;
		}
		section {
			background: white;
			width: 15.59cm;
			height: 22.94cm; /*1056px = 27.94cm*/
			padding: 2.5cm 3cm 2.5cm 3cm;
			position: relative;
			margin: auto;
			-webkit-box-shadow: 0px 20px 50px gray;
			box-shadow: 0px 20px 50px gray;
		}
		section * {
			padding: 0px;
		}
	</style>
	<title>Contrato</title>
</head>
<body>
	<section>
		<p>
			<b>CONTRATO DE PRESTACION DE SERVICIOS QUE CELEBRAN POR UNA PARTE, QUALIUM PUBLICIDAD Y MARKETING, S.C.P., A TRAVÉS DE SU REPRESENTANTE LEGAL, DAVID ENRIQUE XACUR SALVATIERRA, Y POR LA OTRA PARTE <u>nombre comercial</u>, A QUIENES EN LO SUCESIVO Y PARA EFECTOS DEL PRESENTE CONTRATO SE LES DENOMINARÁ COMO “EL PRESTADOR DE SERVICIOS” Y “EL CLIENTE”, RESPECTIVAMENTE; AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS:</b>
		</p>
		<p align="center"><b>D E C L A R A C I O N E S</b></p>
		<p>
			<ol type="I">
				<li>
					<b>Declara EL PRESTADOR DE SERVICIOS por conducto de su representante legal que:</b>
					<ol type="a">
						<li>
							Es una sociedad civil debidamente constituida y existente de conformidad con las leyes de los Estados Unidos Mexicanos, otorgada ante la fe del Notario Público número 74 de Mérida, Yucatán, Abogado Mario Enrique Montejo Pérez, debidamente inscrita en el Registro Público de la Propiedad y del Comercio del Instituto de Seguridad Jurídica Patrimonial de Yucatán. 
						</li>
						<li>
							Cuenta con facultades suficientes para la celebración del presente Contrato en su nombre y representación, según consta en la Escritura Pública descrita en el inciso inmediato anterior; asimismo manifiesta que dichas facultades no le han sido revocadas o limitadas en forma alguna.
						</li>
						<li>
							Se encuentra inscrita ante el Registro Federal de Contribuyentes bajo la clave de identificación <b>QPM1201103S5</b>
						</li>
						<li>
							Atendiendo a su objeto social se dedica, entre otras actividades, a la prestación de servicios de <b>Administración de página de Facebook y Facebook Ads</b>. Además, que conforme a su objeto social le está permitido la celebración del presente Contrato.
						</li>
						<li>
							Conoce plenamente la calidad, características, requisitos, mecanismos, procedimientos y necesidades del objeto del presente contrato; que ha considerado todos los factores que intervienen en su celebración y que cuenta con el personal profesional, equipo de cómputo y recursos económicos suficientes para desarrollar eficazmente dicha labor.
						</li>
						<li>
							Para los efectos del presente Contrato, señala como su domicilio fiscal el ubicado en la calle treinta y seis diagonal número trescientos uno, interior tres por la calle veinticuatro del Fraccionamiento Montebello, Código Postal 97113 de esta ciudad de Mérida, Yucatán.
						</li>
					</ol>
				</li>
				<li>
					<b>Declara EL CLIENTE, por conducto de su representante legal que:</b>
					<ol type="a">
						<li>
							Que es una persona física, mayor de edad legal, de nacionalidad Mexicana, en pleno goce y ejercicio de sus facultades legales.
						</li>
						<li>
							Se encuentra inscrita ante el Registro Federal de Contribuyentes bajo la clave de identificación <b>AAGF790710UH6</b>.
						</li>
						<li>
							Para los efectos legales del presente instrumento señala como su domicilio el ubicado en la <b>calle veinte siete por dieciséis y dieciocho número 101 I colonia Francisco I madero, código postal 97240, de la ciudad de Mérida, Yucatán</b>.
						</li>
					</ul>
				</li>
				<li>
					<b>Las partes declaran que:</b>
				</li>
			</ol>
		</p>
	</section>
</body>
</html>

<script type="text/template">
	fechacreacion: 			<%- formatearFechaUsuario(new Date(fechacreacion)) %>	<br>
	fechafinal: 			<%- formatearFechaUsuario(new Date(fechafinal)) %>		<br>
	fechafirma: 			<%- formatearFechaUsuario(new Date(fechafirma)) %>		<br>
	fechainicio: 			<%- formatearFechaUsuario(new Date(fechainicio)) %>		<br>
	id: 					<%- id %>												<br>
	idcliente: 				<%- idcliente %>										<br>
	idrepresentante: 		<%- idrepresentante %>									<br>
	
	plan: 					<%- plan %>												<br>
	
	nombreComercial: 		<%- nombreComercial %>									<br>
	nombreRepresentante: 	<%- nombreRepresentante %>								<br>
	titulo: 				<%- titulo %>											<br>
	pagomes: 				<%- pagomes %>											<br>
	mensualidades:			<%- mensualidades %>									<br>
</script>
<script type="text/template">
	<%= JSON.stringify(json) %>
</script>

<script type="text/template" id="plantilla_contrato">
	<% var meses = new Array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'), Anio_Mes_dia %>
</script>

<?=script_tag('js/backbone/app.js')?>
<script type="text/javascript">
	var app = app || {};
	// app.iva = 0.16;
	
	app.coleccionDeClientes 		= <?php echo json_encode($clientes) ?>;
	app.coleccionDeServicios 		= <?php echo json_encode($servicios) ?>;
	app.coleccionDeRepresentantes 	= <?php echo json_encode($representantes) ?>;
	
</script>
<?=
// <!-- Utilerias -->
	script_tag('js/funcionescrm.js').
// <!-- Librerias Backbone -->
	script_tag('js/backbone/lib/jquery.js').
    script_tag('js/backbone/lib/underscore.js').
    script_tag('js/backbone/lib/backbone.js').
    script_tag('js/backbone/lib/backbone.localStorage.js').
// <!-- modelos -->
	script_tag('js/backbone/modelos/ModeloCliente.js').
	script_tag('js/backbone/modelos/ModeloRepresentante.js').
	script_tag('js/backbone/modelos/ModeloServicio.js').
// <!-- colecciones -->
	script_tag('js/backbone/colecciones/ColeccionClientes.js').
	script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
	script_tag('js/backbone/colecciones/ColeccionServicios.js').
	// En la colección contratos están el modelo y coleccion de pagos
	script_tag('js/backbone/colecciones/ColeccionContratos.js');
?>
	<script type="text/javascript">
		app.coleccionContratos_L = new ColeccionContratos_L();
	</script>
<!-- vistas -->
	<script type="text/javascript">
		app = app || {};
		var V_HojaContrato = Backbone.View.extend({
			tagName			: 'div',
			plantilla	: _.template($('#plantilla_contrato').html()),
			render		: function () {
				// this.$el.html(this.plantilla( this.model.toJSON() ));
				// return this;
			}
		});

		var Consulta_Hoja	= Backbone.View.extend({
			el	: 'section',
			initialize	: function () {
				app.coleccionContratos_L.fetch();
				
				this.cargarContratos();

			},
			cargarContrato	: function (contrato) {
				contrato.set({nombreComercial:app.coleccionClientes.get({id:contrato.get('idcliente')}).get('nombreComercial')});
				contrato.set({nombreRepresentante:app.coleccionRepresentantes.get({id:contrato.get('idrepresentante')}).get('nombre')});

				var pagomes = 0.0,
					mensualidades = '';

				if ( _.isArray(contrato.get('pago')) ) {
					pagomes = Number(contrato.get('pago')[0]);
					mensualidades = contrato.get('pago').length;
				} else{
					pagomes = Number(contrato.get('pago'));
					mensualidades = 1;
				};

				contrato.set({
					pagomes:(pagomes).toFixed(2),
					mensualidades:mensualidades
				});

				var vista = new V_HojaContrato({model:contrato});

				this.$el.html(vista.render().el);
			},
			cargarContratos	: function () {
				app.coleccionContratos_L.each(this.cargarContrato, this);
			}
		});

		var consulta_Hoja = new Consulta_Hoja();

		app.coleccionContratos_L.each(function (model){ 
			model.destroy();
		},this);
		app.coleccionServiciosContrato_L.each(function (model){ 
			model.destroy();
		},this);
		app.coleccionPagos_L.each(function (model){ 
			model.destroy();
		},this);
	</script>