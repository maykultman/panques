<?php
	function setDescripcion ($cotizados) {
		$array_completo = array();
		$array_ids = array();
		$i = 0;
		foreach ($cotizados as $cotizado) {
			array_push($array_ids, $cotizado->idservicio);
		}

		$array_ids = array_values( array_unique($array_ids) );

		
	}
	setDescripcion($cotizados);
?>
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
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Cotización</title>
	</head>
	<body>
		<section id="contenedor_formato">
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
				<p id="detalles">
					<h2>Detalle</h2>
					<?php echo (isset($cotizacion->detalles)) ? $cotizacion->detalles : ' '; ?>
				</p>
				<br>
				<table border="1">
					<thead>
						<tr>
							<th style="width:55%;">Servicios</th>
							<th style="text-align: center; width:15%;">Horas</th>
							<th style="text-align: center; width:15%;">P/por hora</th>
							<th style="text-align: center; width:15%;"></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$obs = '';
							$i = 0;
							foreach ($cotizados as $cotizado) {
								# code...
							}
							echo '<tr>';
								echo '<td>';
									echo '<ul>';
										foreach ($cotizados as $cotizado) {
											if ($cotizados[$i]->idservicio == $cotizado->idservicio) {
												echo '<li>'.$cotizados[$i]->descripcion.'</li>';
											}
											$i++;
										}
									echo '</ul>';
								echo '</td>';
								echo '<td style="text-align: center;"></td>';
								echo '<td style="text-align: center;"></td>';
								echo '<td class="importe" style="text-align: center;"></td>';
							echo '</tr>';	
						?>
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