<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<style type="text/css">
		@page {
			size: portrait;
			page-size: letter;
			margin: 2.5cm 3cm;
		}
		* {
			font-family: Open Sans;
		}
		body {
			margin: 0px;
		}
		section {
			background: white;
			/*height: 22.94cm;*/ /*1056px = 27.94cm*/
			position: relative;
			margin: auto;
			text-align: justify;
		}
		ul, ol {
			padding: 0px;
		}
		ol ol, ol ul, ul ol, ul ul {
			padding: 0px 0px 0px 24px;
		}
		p p, li {
			margin: 10px 0px;
		}
		th, td {
			width: 50%;
			text-align: center;
			vertical-align: top;
		}
		.titulos {
			text-align: center;
			margin: 30px 0px;
			letter-spacing: 5px;
		}
		.textUppercase {
			text-transform: uppercase;
		}
		.textLowercase {
			text-transform: lowercase;
		}
		@media screen {
			section {
				width: 15.59cm;
				padding: 2.5cm 3cm 2.5cm 3cm;
				-webkit-box-shadow: 0px 20px 50px gray;
				box-shadow: 0px 20px 50px gray;
				margin: 20px auto;
			}
		}
		@media print {
			
		}
	</style>
	<?=
		// <!-- Utilerias -->
			script_tag('js/funcionescrm.js').
			script_tag('js/numero-a-letras.js');

	?>
	<title>Contrato</title>
</head>
<body>
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
	pago: 					<%- pago %>											<br>
	mensualidades:			<%- mensualidades %>									<br>
</script>
<script type="text/template">
	<%= JSON.stringify(json) %>
</script>

<script type="text/template" id="plantilla_contrato">
	<p>
		<b>CONTRATO DE PRESTACION DE SERVICIOS QUE CELEBRAN POR UNA PARTE, QUALIUM PUBLICIDAD Y MARKETING, S.C.P., A TRAVÉS DE SU REPRESENTANTE LEGAL, DAVID ENRIQUE XACUR SALVATIERRA, Y POR LA OTRA PARTE <u class="textUppercase"><%= cliente.nombreComercial %></u>, A QUIENES EN LO SUCESIVO Y PARA EFECTOS DEL PRESENTE CONTRATO SE LES DENOMINARÁ COMO “EL PRESTADOR DE SERVICIOS” Y “EL CLIENTE”, RESPECTIVAMENTE; AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS:</b>
	</p>
	<p class="titulos"><b>DECLARACIONES</b></p>
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
						Atendiendo a su objeto social se dedica, entre otras actividades, a la prestación de servicios de <b><u><%= datos.serviciosolicitado %></u></b>. Además, que conforme a su objeto social le está permitido la celebración del presente Contrato.
					</li>
					<li>
						Conoce plenamente la calidad, características, requisitos, mecanismos, procedimientos y necesidades del objeto del presente contrato; que ha considerado todos los factores que intervienen en su celebración y que cuenta con el personal profesional, equipo de cómputo y recursos económicos suficientes para desarrollar eficazmente dicha labor.
					</li>
					<!--<div class="break"></div>-->
					<!--<div class="marginTop"></div>-->
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
						Se encuentra inscrita ante el Registro Federal de Contribuyentes bajo la clave de identificación <b><%= cliente.rfc %></b>.
					</li>
					<li>
						Para los efectos legales del presente instrumento señala como su domicilio el ubicado en la <b><%= cliente.direccion %></b>.
					</li>
				</ol>
			</li>
			<li>
				<b>Las partes declaran que:</b>
				<p>
					Han negociado libremente los términos y condiciones del presente Contrato y que tienen pleno conocimiento de sus derechos y obligaciones establecidas en el mismo, por tanto es su voluntad celebrar el presente instrumento de Prestación de Servicios de conformidad con las siguientes:
				</p>
				<p class="titulos"><b>CLÁUSULAS</b></p>
				<p>
					<b>PRIMERA.- DEL OBJETO.-</b> Por el presente contrato <b>“EL CLIENTE”</b> encomienda a <b>“EL PRESTADOR DE SERVICIOS”</b> y éste se obliga a prestarle 
					<% 	if (secciones.length > 1) {
							var nombres = _.uniq(_.pluck(secciones, 'nombre')),
								ultimo = nombres.pop();
							nombres = nombres.join(', ') + ' y ' + ultimo; %>
							los servicios de <b>
							<%= nombres %>
					<% 	} else{ %>
							el servicio de <b>
							<%= secciones[0].nombre %>
					<% 	} %>
					</b>., en lo sucesivo <b>“LOS SERVICIOS”</b>, en el estado de Yucatán.
				</p>
				<p>
					<b>SEGUNDA.- DE LA PRESTACIÓN DE LOS SERVICIOS.-</b> En congruencia a lo dispuesto en la cláusula anterior, <b>“EL PRESTADOR DE SERVICIOS”</b> se compromete a brindar <b>“LOS SERVICIOS”</b> de manera enunciativa más no limitativa conforme a lo siguiente:
					<ol type="a">
						<% datos.enunciado = datos.enunciado.split(',.,') %>
						
							<%for (var i = 0; i < datos.enunciado.length; i++) {%>
								<li><%= datos.enunciado[i] %>.</li>
							<%};%>
					</ol>
				</p>
				<p>
					<p>
						<b>TERCERA.- DEL MONTO Y FORMA DE PAGO.-</b> Las partes acuerdan expresamente que como contraprestación por todas y cada una de las obligaciones que <b>“EL PRESTADOR DE SERVICIOS”</b> asume a su cargo a favor de <b>“EL CLIENTE”</b>, ésta le pagará 
						
						<%if (datos.plan == 'iguala') {%>
							<%if (datos.npagos == '1'){%>
								una mensualidad
							<%} else{%>
								de manera mensual
							<%};%>
						<%} else{%>
							<%if (datos.npagos == '1'){%>
								unicamente
							<%} else{%>
								periodicamente
							<%};%>
						<%};%>

						por los servicios objeto de este contrato,

						<%if ( datos.plan == 'iguala' ) {%>
							la cantidad de<b>
							<%if ( _.isArray( datos.pago ) ) {%>
								$<%=conComas(Number(datos.pago[0]).toFixed(2))%></b>
							<%} else{%>
								$<%=conComas(Number(datos.pago).toFixed(2))%></b>
							<%};%>
							
						<%} else{%>
							<%if ( _.isArray( datos.pago ) && datos.pago.length > 1 ) {%>
								las cantidades de<b>
								<%= (function (pagos) {
									for (var i = 0; i < pagos.length; i++) {
										pagos[i] = '$'+conComas(Number(pagos[i]).toFixed(2));
									};
									return pagos.join(', ');
								})(datos.pago) %></b>
							<%} else if ( _.isArray( datos.pago ) && datos.pago.length == 1 ) {%>
								la cantidad de<b>
								$<%=conComas(Number(datos.pago[0]).toFixed(2))%></b>
							<%} else{%>
								la cantidad de<b>
								$<%=conComas(Number(datos.pago).toFixed(2))%></b>
							<%};%>
						<%};%>

						<%if ( datos.plan == 'iguala' ) {%>
							<%if ( datos.npagos == '1' ){%>
								<b>(Son: <%= datos.totalletra %> Moneda Nacional)</b>.
							<%} else{%>
								<b>(Son: <%= datos.totalletra %> Moneda Nacional)</b> mensuales.
							<%};%>
						<%} else{%>
							<%if (datos.npagos == '1'){%>
								<b>(Son: <%= datos.totalletra %> Moneda Nacional)</b>.
							<%} else{
								var pago = function () {
									var total = 0.0;
									for (var i = 0; i < datos.pago.length; i++) {
										total += Number( (function (pago){
											pago = pago.split(',');
											return pago.join('');
										})(datos.pago[i].substring(1)) );
									};
									return total;
								}();%>
								hasta cubrir la cantidad de <b>$<%=conComas(pago.toFixed(2))%>
								(Son: <%= datos.totalletra %> Moneda Nacional)</b>
							<%};%>
							
						<%}%>
					</p>
					<p>
						<b>“EL CLIENTE”</b> efectuará el pago a <b>“EL PRESTADOR DE SERVICIOS”</b> de la cantidad a que se refiere el primer párrafo de la presente cláusula, 
							<%if (datos.plan == 'iguala'){%>
								<%if ( _.isArray(datos.fechapago) && datos.fechapago.length > 1 ){%>
									el día <%= (function (num){
										if (num == 'un') {
											return 'uno'
										} else{
											return num;
										};
									})(SoloNumerosALetras(datos.fechapago[0].split('-')[2] -1)) %> de cada mes
									durante <%= SoloNumerosALetras(datos.fechapago.length) %> meses.
								<%} else if( _.isArray(datos.fechapago) && datos.fechapago.length == 1 ){%>
									el día <%= (function (num){
										if (num == 'un') {
											return 'uno'
										} else{
											return num;
										};
									})(SoloNumerosALetras(datos.fechapago[0].split('-')[2] -1)) %> del mes de <%= meses[parseInt(datos.fechapago[0].split('-')[1]) -1] %> del <%= datos.fechapago[0].split('-')[0] %>.
								<%} else{%>
									el día <%= (function (num){
										if (num == 'un') {
											return 'uno'
										} else{
											return num;
										};
									})(SoloNumerosALetras(datos.fechapago.split('-')[2] -1)) %> del mes de <%= meses[parseInt(datos.fechapago.split('-')[1]) -1] %> del <%= datos.fechapago.split('-')[0] %>.
								<%};%>
							<%} else{%>
								<%if ( _.isArray(datos.fechapago) && datos.fechapago.length > 1 ){%>
									cada <%= SoloNumerosALetras(datos.plazo) %> días
									por <%= SoloNumerosALetras(datos.npagos) %> periodos.
								<%} else if ( _.isArray(datos.fechapago) && datos.fechapago.length == 1 ){%>
									en un solo pago.
								<%} else{%>
									en un solo pago.
								<%};%>
							<%};%>
							En caso de que el día señalado de pago sea inhábil, el pago procederá al siguiente día hábil que corresponda.
					</p>
				</p>
				<p>
					<b>CUARTA.- DE LA VIGENCIA Y TERMINACIÓN ANTICIPADA.-</b> El presente contrato será por 
					<%if (datos.plan == 'iguala') {%>
						<%= SoloNumerosALetras(parseInt(datos.npagos) * 30) %>
						<%if ( parseInt(datos.npagos) * 30 > 1 ){%>
							días.
						<%} else{%>
							día.
						<%}%>
					<%} else {%>
						<%= SoloNumerosALetras(parseInt(datos.npagos) * parseInt(datos.plazo)) %>
						<%if ( parseInt(datos.npagos) * parseInt(datos.plazo) ){%>
							días.
						<%} else{%>
							día.
						<%}%>
					<%};%>
					Incumplir las obligaciones propias de cada una de las partes, dará lugar a la otra para terminar unilateralmente el Contrato de Prestación de Servicio.
				</p>
				<p>
					<b>QUINTA.- DE LA SUPERVISIÓN.-</b> <b>“EL CLIENTE”</b> podrá en todo momento, a través de quien al efecto designe, supervisar y vigilar que los servicios a que se refiere este contrato se ajusten a los términos convenidos y dar a <b>“EL PRESTADOR DE SERVICIOS”</b> las instrucciones que estime convenientes para su mejor ejecución, sin que esto implique modificaciones a las obligaciones a cargo de <b>“EL PRESTADOR DE SERVICIOS”</b>, a fin de que se ajuste a las características y especificaciones que en su caso convenga con <b>“EL CLIENTE”</b>.
				</p>
				<p>
					<p>
						<b>SEXTA.- DE LAS CAUSAS DE RESCISIÓN.-</b> Las partes están de acuerdo en que el presente contrato podrá rescindirse, sin responsabilidad para ellas y sin que sea necesaria resolución de autoridad alguna al respecto, en los casos que de manera enunciativa más no limitativa se señalan a continuación: 
					</p>
					<ol type="a">
						<li>
							Si <b>“EL PRESTADOR DE SERVICIOS”</b> no cumple con el objeto de este contrato en el lapso convenido y conforme a lo establecido;
						</li>
						<li>
							Si <b>“EL PRESTADOR DE SERVICIOS”</b> suspende injustificadamente el objeto de este contrato; o 
						</li>
						<li>
							Por incumplimiento a cualquiera de los términos y demás obligaciones estipuladas en este contrato por cualquiera de las partes.
						</li>
					</ol>
					<p>
						En el momento en que “EL CLIENTE” tenga conocimiento de que “EL PRESTADOR DE SERVICIOS” no ha cumplido con alguna o algunas de las obligaciones derivadas de este instrumento, deberá notificarlo en forma fehaciente, para que ponga efectivo remedio al retraso o a la indebida prestación de la obligación convenida por acción u omisión, según se trate, para que en un término no mayor a 5 (cinco) días naturales, “EL PRESTADOR DE SERVICIOS” cumpla, de manera inmediata con sus obligaciones. En caso de continuar el incumplimiento en forma total o parcial, “EL CLIENTE” podrá rescindir el contrato.
					</p>
				</p>
				<p>
					<p><b>SÉPTIMA.- DISPOSICIONES GENERALES.</b></p>
					<ol type="A">
						<li>
							<b>DE LA CONFIDENCIALIDAD.- “EL PRESTADOR DE SERVICIOS”</b> se obliga a guardar absoluta confidencialidad de toda la información que bajo el presente contrato reciba de <b>“EL CLIENTE”</b> durante y posterior a la ejecución del mismo y a no hacer uso de esta información más que para lo estrictamente indispensable en la prestación de los servicios objeto de este instrumento jurídico. Una vez concluida la vigencia de este contrato, <b>“EL PRESTADOR DE SERVICIOS”</b> está de acuerdo en destruir o regresar cualquier información confidencial que tenga de <b>“EL CLIENTE”</b>.
						</li>
						<li>
							<b>DE LOS DERECHOS DE PROPIEDAD.-</b> El presente contrato, no transfiere a <b>“EL PRESTADOR DE SERVICIOS”</b> ningún derecho o título de propiedad sobre las marcas, nombres comerciales, slogans publicitarios, derechos de autor, o algún otro derecho de propiedad industrial, que sea propiedad de <b>“EL CLIENTE”</b> o de cualquiera de sus socios, sus filiales, subsidiarias y cualquier otra persona física o moral que tuviese relación en la producción, distribución, comercialización o venta de los productos que elabora <b>“EL CLIENTE”</b>.
							<br>
							En virtud de lo anterior, <b>“EL PRESTADOR DE SERVICIOS”</b> se obliga a no llevar a cabo directa ni indirectamente, acto alguno que pueda poner en peligro los derechos de <b>“EL CLIENTE”</b> respecto de los derechos de propiedad.
						</li>
						<li>
							<b>DE LAS OBLIGACIONES FISCALES.-</b> Cada una de las partes se obliga a dar cumplimiento a las obligaciones fiscales que le correspondan y que se encuentren vigentes a la fecha de su exigibilidad.
						</li>
						<li>
							<b>DE LAS LICENCIAS Y/O PERMISOS.- “EL PRESTADOR DE SERVICIOS”</b> se obliga a contar con todos los permisos, licencias y/o autorizaciones administrativas o de cualquier otra índole que se requieren para la debida prestación de los servicios objeto del presente contrato, siendo el único responsable ante cualquier autoridad, federal, estatal o municipal o cualquier otro tercero que pudiera resultar perjudicado por no contar con dichas autorizaciones, debiendo en todo caso deslindar a <b>“EL CLIENTE”</b> cualquier responsabilidad al respecto. 
						</li>
						<li>
							<b>DE LA RELACION CONTRACTUAL.</b> Queda claramente definido y se entiende por las partes contratantes que la actividad y servicios que desarrollará <b>“EL PRESTADOR DE SERVICIOS”</b> son extraordinarios y estrictamente de carácter profesional, libremente ejercidos, sin subordinación alguna a <b>“EL CLIENTE”</b>, con sus medios propios y que no implica relación de trabajo alguna entre las partes. 
						</li>
						<li>
							<b>DE LA CESIÓN DE DERECHOS.- “EL PRESTADOR DE SERVICIOS”</b> se obliga a no ceder, transferir, enajenar o negociar en cualquier forma a terceras personas físicas o morales sus derechos y obligaciones derivadas de este contrato; salvo que cuente con la previa autorización por escrito de <b>“EL CLIENTE”</b>.
						</li>
						<li>
							<b>DEL CASO FORTUITO O FUERZA MAYOR.-</b> El incumplimiento a las obligaciones previstas en este contrato originado por caso fortuito o fuerza mayor no será causa de responsabilidad contractual para ninguna de las partes y ambas tendrán derecho a suspender las obligaciones contenidas en este contrato, previa notificación por escrito.
						</li>
						<li>
							<b>DE LAS MODIFICACIONES AL CONTRATO.-</b> Las modificaciones al presente contrato se efectuarán mediante documento por escrito debidamente firmado por las partes. Cualquier modificación que se lleve a cabo sin cumplir con las formalidades previstas en esta cláusula, no surtirá efectos entre las partes.
						</li>
						<li>
							<b>DE LAS NOTIFICACIONES.-</b> Todos los avisos y notificaciones que las partes deban darse, de acuerdo con los términos estipulados en el presente Contrato, se realizarán en los domicilios señalados en el apartado de Declaraciones de este documento.
						</li>
					</ol>

				</p>
				<p>
					<b>DÉCIMA.- DE LA INTERPRETACIÓN Y CUMPLIMIENTO DEL CONTRATO.-</b> Para la interpretación y cumplimiento de este contrato, las partes se someten expresamente a las leyes y a la jurisdicción y competencia de los Tribunales del fuero común en la ciudad de Mérida Yucatán renunciando expresamente a cualquier otro fuero que pudiera corresponderles por razón de su domicilio presente o futuro. Leído que fue el presente contrato y enteradas las partes de su contenido y alcance legal, lo firman de conformidad y para constancia, en la ciudad de Mérida, Yucatán, <b class="textLowercase">
					<%= (function (num) {
						if (num == 'un') {
							return 'al primer día'
						} else{
							return 'a los '+ num +' días';
						};
					})( SoloNumerosALetras(datos.fechafirma.split('-')[2]) ) %> del mes de <%= meses[parseInt(datos.fechafirma.split('-')[1]) -1] %> del <%= datos.fechafirma.split('-')[0] %></b>.
				</p>
			</li>
		</ol>
		<br>
		<br>
		<table>
			<thead>
				<tr>
					<th>POR “EL PRESTADOR DE SERVICIOS”</th>
					<th>POR “EL CLIENTE”</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2" style="color:white;">espacio</td>
				</tr>
				<tr>
					<td colspan="2" style="color:white;">espacio</td>
				</tr>
				<tr>
					<td>C. <%= datos.firmaempleado %></td>
					<td>
						C. <%= representante.nombre %>
						<br>
						<%= cliente.nombreFiscal %>
					</td>
				</tr>
			</tbody>
		</table>
	</p>
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
// <!-- Librerias Backbone -->
	script_tag('js/backbone/lib/jquery-1.11.1.min.js').
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
		$(document).on('ready', function () {
			// $('section').height( (1056 - (94.48818897638 * 2)).toFixed() ).append('<div class="break"></div>');
		});
	</script>
<!-- vistas -->
	<script type="text/javascript">
		app = app || {};
		var V_HojaContrato = Backbone.View.extend({
			tagName			: 'section',
			plantilla	: _.template($('#plantilla_contrato').html()),
			render		: function (json) {
				// this.$el.html(JSON.stringify(json));
				this.$el.html(this.plantilla( json ));
				return this;
			}
		});

		var Consulta_Hoja	= Backbone.View.extend({
			el	: 'body',
			initialize	: function () {
				app.coleccionContratos_L.fetch();
				
				this.cargarContratos();

			},
			cargarContrato	: function (contrato) {
				contrato = contrato.toJSON();
				contrato.cliente = _.omit(
						app.coleccionClientes.get(contrato.datos.idcliente).toJSON(),
						'id' /*Omitimos el id*/
					);

				contrato.representante = app.coleccionRepresentantes.get(contrato.datos.idrepresentante).toJSON();

				var pago,
					mensualidades = '';

				if (_.isArray(contrato.secciones)) {
					for (var i = 0; i < contrato.secciones.length; i++) {
						contrato.secciones[i].nombre = app.coleccionServicios.get(contrato.secciones[i].idservicio).get('nombre');
					};
				} else{
					contrato.secciones.nombre = app.coleccionServicios.get(contrato.secciones.idservicio).get('nombre');
				};

				if ( _.isArray(contrato.datos.pago) ) {
					mensualidades = contrato.datos.pago.length;
				} else{
					mensualidades = 1;
				};
				pago = contrato.datos.pago;

				contrato.datos.pago = pago;
				contrato.datos.mensualidades = mensualidades;
				// this.$el.html(JSON.stringify(contrato));return;
				var vista = new V_HojaContrato();

				this.$el.html(vista.render(contrato).el);
			},
			cargarContratos	: function () {
				app.coleccionContratos_L.each(this.cargarContrato, this);
			}
		});

		var consulta_Hoja = new Consulta_Hoja();

		// app.coleccionContratos_L.each(function (model){ 
		// 	model.destroy();
		// },this);
		// app.coleccionServiciosContrato_L.each(function (model){ 
		// 	model.destroy();
		// },this);
		// app.coleccionPagos_L.each(function (model){ 
		// 	model.destroy();
		// },this);
	</script>