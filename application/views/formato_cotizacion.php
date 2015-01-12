<!doctype html>
<html>
	<head>
		<style type="text/css">
			@page {
				size: portrait;
				page-size: letter;
				margin: 0px 0px;
			}
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
				margin: 20px auto;
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

			#imprimir {
				background: orange;
				border: 3px solid gray;
				border-radius: 3px 3px;
				padding: 10px;
				font-weight: bold;
			}
			@media screen {
			}
			@media print {
				#imprimir {
					display:none;
				}
				section {
					margin: 0px;
				}
			}
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Cotización</title>	
		<?=
			script_tag('js/backbone/lib/jquery-1.11.1.min.js').
			script_tag('js/plugin/jsPDF/jspdf.min.js');
		?>
	</head>
	<body>
		<section id="contenedor_formato">
			<button type="button" id="imprimir" onclick="print()" class="btn btn-default">Imprimir...</button>
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
<script type="text/template" id="template-filaServicioEvento">
	<tr>
		<td>
			<b><%= servicio %></b>
			<ul><%= descripcion %></ul>
		</td>
		<td style="text-align: center;">
			<%= horas %>
		</td>
		<td style="text-align: center;"><%= preciotiempo %></td>						
		<td class="importe" style="text-align: center;"> <%= importe %>	</td>
	<tr>
</script>
<script type="text/template" id="template-filaServicioIguala">
	<tr>
		<td>
			<%for (var i = 0; i < servicios.length; i++) {%>
				<b><%= servicios[i].servicio %></b>
				<ul><%= servicios[i].descripcion %></ul>
			<%};%>
		</td>
		<td style="text-align: center;"><%= pagos %></td>
		<td style="text-align: center;"><%= pagomes %></td>						
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
 		servicioEvento 	: _.template($('#template-filaServicioEvento').html()),
 		servicioIguala 	: _.template($('#template-filaServicioIguala').html()),
 		totales 	: _.template($('#template-tfoot').html()),
 	},
 	events : { },

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
 		app.coleccionServicios_L.fetch();
 		this.cargarCotizacion();

 		// localStorage.clear();
 	},
 	cargarCotizacion : function(modelo) {

 		var json = app.coleccionCotizaciones_L.toJSON()[0];
 		this.json = json;
 		console.log(json);

		this.$('h1').text(json.titulo);
 		this.$('#detalles').html( this.plantillas.detalles(json) );


		this.preciotiempo = Number(json.preciotiempo);
		this.descuento 	= Number(json.descuento);
 		switch(json.plan){
 			case 'evento':
 				this.$('thead').append('<tr>'+
							'<th style="width:55%;">Servicios</th>'+
							'<th style="text-align: center; width:15%;">Horas</th>'+
							'<th style="text-align: center; width:15%;">P/por hora</th>'+
							'<th style="text-align: center; width:15%;"></th>'+
						'</tr>');
 				this.cargarServiciosEvento();
 				break;
 			case 'iguala':
 				this.$('thead').append('<tr>'+
							'<th style="width:55%;">Servicios</th>'+
							'<th style="text-align: center; width:15%;">Mensualidades</th>'+
							'<th style="text-align: center; width:15%;">Pago mensual</th>'+
							'<th style="text-align: center; width:15%;"></th>'+
						'</tr>');

 				/*Variables globales*/
 				this.horas += json.npagos;

 				this.cargarServiciosIguala();
 				break;

 			default:
 				statements_def
 				break;
 		}
 	},
 	cargarServiciosEvento : function () {
 		// obtenemos solo los id's de la coleccion localStorage
 		var idservicios = app.coleccionServicios_L.pluck('idservicio');
 		
 		// borramos todos los id's repetidos, el resultado simpre
 		// es un array
 		idservicios = _.union(idservicios);

 		// Iteramos en array de servicios para obtener
 		// cada una de las descripciones de que se 
 		// anotaron en el formulario de contizaciones.
 		for (var i = 0; i < idservicios.length; i++) {
	 		this.$('article table tbody')
	 			.append( this.plantillas.servicioEvento(this.obtenerServicio(idservicios[i])) );
 		};

 		this.totales();
 	},
 	cargarServiciosIguala	: function () {
 		var idservicios = app.coleccionServicios_L.pluck('idservicio');

 		idservicios = _.union(idservicios);

 		this.$('article table tbody')
	 			.append( this.plantillas
	 				.servicioIguala(this.obtenerServicio2(idservicios)) );

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
 			importe = 0,

 			itemLI = '';

 		// Buscamos todas las secciones en las que coincida el
 		// id que se ha pasado como perametro ha esta función.
 		// La función where siempre retorna un arreglo. Esta
 		// linea hace que el modelo se busque así mismo para,
 		// aislarlo de otras secciones que no son del mismo 
 		// servicio.
 		modelos = app.coleccionServicios_L.where( {idservicio: idservicio} );


 		// Iteramos sobre los modelos para contruir un nuevo objeto
 		// que se retornara para contruir el dicumento de cotización.
 		for (var i = 0; i < modelos.length; i++) {
 			if (modelos[i].get('seccion') != '') {
 				itemLI = modelos[i].get('seccion')+'. ';
 			};
 			if (modelos[i].get('descripcion') != '') {
 				itemLI += modelos[i].get('descripcion')+'.';
 			};
 			if (modelos[i].get('seccion') != '' || modelos[i].get('descripcion') != '') {
 				itemLI = itemLI.split('');
	 			itemLI.unshift('<li>');
	 			itemLI.push('</li>');
	 			itemLI = itemLI.join('');
	 			json.descripcion += itemLI;
 			};
	 		itemLI = '';	
 			json.horas += Number(modelos[i].get('horas'));
 		};

 		// Biscamos el nombre del servicio por medio del id
 		// que se pasa como parametro. En caso de que no existe
 		// querra decir que el servicio va ser creado cuando la
 		// cotizacion sea creada. Por lo tanto el nombre viene
 		// en la propiedad id del modelo. La función get devuelve
 		// un Modelo no array de Modelos
 		json.servicio = app.coleccionServicios.get(idservicio);
 		// Si la propiedad servicio de json es undefined entronces
 		// tomamos el id del primer modelo de la variable modelos 
 		// porque allí se enuentra el nombre del servicio temporal.
 		// Sino, la línea anterior devolvió un modelo y tomariamos
 		// el nombre de servicio que contiene.
 		if (!json.servicio) {
 			json.servicio = modelos[0].get('idservicio');
 		} else {
 			json.servicio = json.servicio.get('nombre');
 		};

 		// El precio es una variable global, así como el 
 		// precio por hora
 		json.preciotiempo = '$'+conComas(this.preciotiempo.toFixed(2));
 		json.importe = '$'+conComas((json.horas * this.preciotiempo).toFixed(2));

 		/*Variables globales*/
 		this.horas += json.horas;
 		
 		return json;
 	},
 	obtenerServicio2 : function (idservicios) {
 		var json = {
 				servicios 	: [],
 				pagomes		: this.json.preciotiempo,
				pagos		: this.json.npagos,
				importe		: parseInt(this.json.npagos) * parseInt(this.json.preciotiempo)
 			},
 			modelos;

 		for (var i = 0; i < idservicios.length; i++) {
 			json.servicios.push({
 				servicio 	: '',
 				descripcion : ''
 			});
 			modelos = app.coleccionServicios_L.where( {idservicio: idservicios[i]} );
 			for (var ii = 0; ii < modelos.length; ii++) {
	 			json.servicios[i].descripcion += '<li>'+(modelos[ii].get('descripcion')+'</li>');
	 		};
	 		json.servicios[i].servicio = app.coleccionServicios.get(idservicios[i]);
 			
 			if (!json.servicios[i].servicio) {
	 			json.servicios[i].servicio = modelos[0].get('idservicio');
	 		} else {
	 			json.servicios[i].servicio = json.servicios[i].servicio.get('nombre');
	 		};
 		};
 		return json;
 	}, 
 	totales : function () {
 		var total = 0,
 			json = {};
 		total = this.horas * this.preciotiempo;
 				json.subtotal = '$'+conComas(total.toFixed(2));
				json.descuento = this.descuento;
				json.valordescuento = '$'+(total * this.descuento/100).toFixed(2);
		total = total - total * (this.descuento/100).toFixed(2);
				json.iva = '$'+conComas( (total * 0.16).toFixed(2) );
		total = total + total * 0.16;

		total = conComas(total.toFixed(2));
				json.total = '$'+total;
		
		this.$('tfoot').html( this.plantillas.totales(json) );
 	}
});

 app.vistaPrevia = new VistaPrevia();

</script>