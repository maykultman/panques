<!doctype html>
<html>
	<head>
		<style type="text/css">
			* {
				font-family: Open Sans;
			}
			body {
				margin: 0px;
			}
			section {
				background: white;
				width: 664.8188976378px;
				height: 931.51181102362px; /*1056px = 27.94cm*/
				padding: 94.48818897638px 2cm 0px 2cm;
				position: relative;
				margin: auto;
				border-bottom: 30px solid rgba(64, 64, 64, 1);
				-webkit-box-shadow: 0px 20px 50px gray;
				box-shadow: 0px 20px 50px gray;
			}

			header {
				padding: auto;
				position: absolute;
				top: 0px;
				left: 0px;
				width: 100%;
				background: rgba(64, 64, 64, 1);
				color: white;
				height: 150px;
			}

			header table {
				width: 100%;
				height: 100%;
			}
			header table tr td {
				width: 214.9396325459333px;
			}
			header table tr td h1 {
				margin-left: 2cm;
				text-shadow: 0px 3px 20px black;
				font-size: x-large;
				text-transform: uppercase;
			}
			header table tr td address {
				margin-right: 2cm;
				font-size: 10px;
				font-style: normal;
				line-height: 120%;
			}
			.td_logo {
				text-align: center;
			}
			header img {
				height: auto;
				width: 30%;
			}

			article {
				margin-top: 2cm;
			}
			article,
			article h2,
			footer,
			footer h2 {
				font-size: 13px;
			}
			footer {
				position: absolute;
				bottom: 30px;
				width: 17.59cm;
			}

			article table {
				border-spacing: 0px;
				width: 100%;
			}
			article table thead {
				background: rgba(192, 192, 192, 1);
			}
			article table tbody,
			article table tfoot {
				background: rgba(235, 235, 235, 1);
			}
			article table tbody tr td ul li:before
			{
				content: '-';
			    /*content: '\2713';*/ /*Palomita*/
			    margin: 0 5px;    /* any design */
			}
			article table tfoot tr td {
				text-align: center;
			}
			article table tr td,
			article table tr th {
				padding: 5px 5px;
				text-align: left;
			}
			article table tbody tr td {
				padding-bottom: 15px;
			}

			article table tr td,
			footer ul,
			h2 {
				color: #555;
			}

			article table tr td ul,
			footer ul {
				padding: 0px;
				list-style-type: none;
				margin: 0px;
				line-height: 110%;
			}
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Cotización</title>	
		<?=
			script_tag('js/jquery-1.11.1.min.js').
			script_tag('js/plugin/jsPDF/jspdf.min.js');
		?>
	</head>
	<body>
		<section id="contenedor_formato">
			<button type="button" id="imprimir" class="btn btn-default">Inprimir</button>
			<header>
				<table>
					<tr>
						<td><h1></h1></td>
						<td class="td_logo"><img  src="http://crmqualium.com/img/formatoCotizacion/logoQualium.png" alt="logo qualium"></td>
						<td>
							<address>
								<b>Qualium Puplicidad y Marqueting</b><br>
								<b>RFC:QPM1201103S5</b><br>
								Email: <u>contacto@qualium.mx</u><br>
								Teléfono: (999)2852274<br>
								Dirección: Calle 22 #52 x 7 y 9 México Norte, C.P. 97128. Mérida, Yucatán.
							</address>
						</td>
					</tr>
				</table>
			</header>
			<article>
				<p id="detalles"></p>
				<br>
				<table>
					<thead>
						<tr>
							<th style="width:55%;">Servicios</th>
							<th style="text-align: center; width:15%;">Horas</th>
							<th style="text-align: center; width:15%;">P/por hora</th>
							<th style="text-align: center; width:15%;"></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
					</tfoot>
				</table>
			</article>
			<footer>
				<br>
				<h2>Términos y condiciones</h2>
				<ul>
					<li>· Para iniciar el trabajo se requiere un brief, la información solicitada completa y haber cubierto el monto del anticipo. </li>
					<li>· Al aprobar la cotización, enviaremos un cronograma de actividades con fechas de revisión y entrega. </li>
					<li>· Se entregará una propuesta gráfica para su aprobación, una vez aprobada cualquier cambio generará costo adicional. </li>
					<li>· Los precios incluyen IVA. </li>
					<li>· Anticipo del 50% y saldo contra entrega del 50%. Anticipo no reembolsable.</li>
					<li>· El archivo final es propiedad del cliente, el proyecto no. </li>
					<li>· El presupuesto se considera aprobado al recibir una copia del mismo firmada por el destinatario.</li>
				</ul>
			</footer>
		</section>
	</body>
</html>

<script type="text/template" id="template-detalles">
	<h2>Detalle</h2>
	<%- detalles %><br>
</script>
<script type="text/template" id="template-filaServicio">
	<tr>
		<td>
			<b><%= servicio %></b>
			<ul><%= descripcion %></ul>
		</td>
		<td style="text-align: center;">
			<%= horas %>
		</td>
		<td style="text-align: center;"><%= preciohora %></td>						
		<td class="importe" style="text-align: center;"> <%= importe %>	</td>
	<tr>
</script>
<script type="text/template" id="template-tfoot">
	<tr>
		<td></td>
		<td></td>
		<td>
			<b>Total: </b>
		</td>
		<td>
			<b><%= subtotal %></b>
		</td>
	</tr>
	<% if (descuento > 1) { %>
		<tr>
			<td></td>
			<td></td>
			<td>
				<b>Descuento (<%= descuento %>%): </b>
			</td>
			<td>
				<b><%= valordescuento %></b>
			</td>
		</tr>
	<% }; %>
	<tr>
		<td></td>
		<td></td>
		<td>
			<b>IVA: </b>
		</td>
		<td>
			<b><%= iva %></b>
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
			<b>Precio Neto: </b>
		</td>
		<td>
			<b><%= total %></b>
		</td>
	</tr>
</script>
<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<script type="text/javascript">
	var app = app || {};
		
	app.coleccionDeClientes 		= <?=json_encode($clientes) ?>;
	app.coleccionDeServicios 		= <?=json_encode($servicios) ?>;
	app.coleccionDeRepresentantes 	= <?=json_encode($representantes) ?>;

</script>
<?=
	// <!-- Librerias -->
	script_tag('js/backbone/lib/underscore.js').
	script_tag('js/backbone/lib/backbone.js').
	script_tag('js//backbone/lib/backbone.localStorage.js').

	// <!-- MVC -->
	script_tag('js/backbone/modelos/ModeloCliente.js').
	script_tag('js/backbone/modelos/ModeloRepresentante.js').
	script_tag('js/backbone/modelos/ModeloServicio.js'). 

	script_tag('js/backbone/colecciones/ColeccionClientes.js').
	script_tag('js/backbone/colecciones/ColeccionServicios.js').
	script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
	script_tag('js/backbone/colecciones/ColeccionCotizaciones.js');
?> 

<script type="text/javascript">
 app = app || {};

 var VistaPrevia = Backbone.View.extend({
 	el : 'body',
 	plantillas	: {
 		detalles 		: _.template($('#template-detalles').html()),
 		servicio 	: _.template($('#template-filaServicio').html()),
 		totales 	: _.template($('#template-tfoot').html()),
 	},
 	events : {
 		'click #imprimir' : 'descargar'
 	},

 	initialize : function() {
 		
 		if (!localStorage.imprimir) {
 			$('head').append('<link href="<?=base_url()?>css/estilo_singuardar.css" rel="stylesheet" type="text/css" media="print">');
 			$('#imprimir').remove();
 		} else {
 			$('head').append('<link href="<?=base_url()?>css/estilo_guardado.css" rel="stylesheet" type="text/css" media="print">');
 			$('#imprimir').css({
 				'position'	: 'fixed',
 				'right'		: '10px',
 				'top' 		:'50%'
 			});
 		};

 		this.horas = 0,
 		app.coleccionCotizaciones_L.fetch();
 		this.cargarCotizacion();
 		app.coleccionServicios_L.fetch();
 		this.cargarServicios();

 		localStorage.clear();
 	},
 	descargar 	: function () {
 		var doc = new jsPDF('p','in','letter')
			, sizes = [12, 16, 20]
			, fonts = [['Times','Roman'],['Helvetica',''], ['Times','Italic']]
			, font, size, lines
			, margin = 0.5 // inches on a 8.5 x 11 inch sheet.
			, verticalOffset = margin
			, loremipsum = $('html').html();

			// Margins:
			// doc.setDrawColor(0, 255, 0)
			// 	.setLineWidth(1/72)
			// 	.line(margin, margin, margin, 11 - margin)
			// 	.line(8.5 - margin, margin, 8.5-margin, 11-margin);

			// the 3 blocks of text
			for (var i in fonts){
				if (fonts.hasOwnProperty(i)) {
					font = fonts[i];
					size = sizes[i];

					lines = doc.setFont(font[0], font[1])
								.setFontSize(size)
								.splitTextToSize('<!doctype html><html>'+loremipsum+'</html>', 7.5);
					// Don't want to preset font, size to calculate the lines?
					// .splitTextToSize(text, maxsize, options)
					// allows you to pass an object with any of the following:
					// {
					// 	'fontSize': 12
					// 	, 'fontStyle': 'Italic'
					// 	, 'fontName': 'Times'
					// }
					// Without these, .splitTextToSize will use current / default
					// font Family, Style, Size.
					doc.text(0.5, verticalOffset + size / 72, lines);

					verticalOffset += (lines.length + 0.5) * size / 72;

					console.log('<!doctype html><html>'+loremipsum+'</html>');
				}
			}

		doc.save('Test.pdf');
 	},
 	cargarCotizacion : function(modelo) {

 		var json = app.coleccionCotizaciones_L.toJSON()[0];

 		// json.fecha = formatearFechaUsuario(new Date(json.fecha));
		// json.nombreComercial = app.coleccionClientes.get({id:json.idcliente}).get('nombreComercial');
		// json.nombre = app.coleccionRepresentantes.get({id:json.idrepresentante}).get('nombre');
		this.$('h1').text(json.titulo);
 		this.$('#detalles').html( this.plantillas.detalles(json) );
 		this.preciohora = Number(json.preciohora);
 		this.descuento = Number(json.descuento);
 	},

 	cargarServicios : function () {
 		var idservicios = app.coleccionServicios_L.pluck('idservicio'),
 		
 		idservicios = _.union(idservicios);

 		for (var i = 0; i < idservicios.length; i++) {
 			// vista = new Servicios({ model: modelo});
	 		this.$('article table tbody').append( this.plantillas.servicio(this.obtenerServicio(idservicios[i])) );
 		};

 		this.totales();
 	},
 	
 	obtenerServicio : function (idservicio) {
 		var json = {
 				idservicio 	: '',
 				descripcion : '',
 				horas 		: 0,
 				preciohora  : ''
 			},
 			modelos,
 			importe = 0;

 		modelos = app.coleccionServicios_L.where( {idservicio: idservicio} );

 		for (var i = 0; i < modelos.length; i++) {
 			json.descripcion += '<li>'+(modelos[i].get('descripcion')+'</li>');
 			json.horas += Number(modelos[i].get('horas'));
 		};
 		json.servicio = app.coleccionServicios.get(idservicio).get('nombre');
 		json.preciohora = '$'+conComas(this.preciohora.toFixed(2));
 		json.importe = '$'+conComas((json.horas * this.preciohora).toFixed(2));

 		/*Variables globales*/
 		this.horas += json.horas;
 		
 		return json;
 	}, 
 	totales : function () {
 		var total = 0,
 			json = {};
 		total = this.horas * this.preciohora;
 				json.subtotal = '$'+conComas(total.toFixed(2));
				json.descuento = this.descuento;
				json.valordescuento = '$'+(total * this.descuento/100).toFixed(2);
		total = total - total * (this.descuento/100).toFixed(2);
				json.iva = '$'+(total * 0.16).toFixed(2);
		total = total + total * 0.16;
		// total = '' + total.toFixed(2);
		// total = total.split('.');
		// decimales = total[1];
		total = conComas(total.toFixed(2));
				json.total = '$'+total;
		
		this.$('tfoot').html( this.plantillas.totales(json) );
 	}
});

 app.vistaPrevia = new VistaPrevia();

</script>