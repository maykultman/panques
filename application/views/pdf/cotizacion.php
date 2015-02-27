<?php 
# Cargamos la librería dompdf.
require_once 'dom/dompdf_config.inc.php';

$html = '<html>
<head>
	<title></title>
</head>
<style>

html, body{
	margin: 0;
	font-family:sans-serif;
	font-size:12px;
	color:#555;
}

.header{
	background: rgba(64, 64, 64, 1);
	color: white;
	height: 150px;
}
.footer{
	position: absolute;
	bottom: 0;
	height: 20px;
	left: 0;
	right: 0;
	background: rgb(64, 64, 64);
	color: #fff;
}
.body, .terminos{
	
	padding: 0 10%;
}
.terminos{
	margin-top: 15%;
}
.body table{
	margin: 5% auto;
	width: 100%;
	border:none;
}
.body table thead{
	background-color: rgba(192, 192, 192, 1);
	color:#000;
	line-height:2.2;
}
.body table td{
	line-height:2;
}
.body table tbody{
	background: rgba(235, 235, 235, 1);
}
.body table tr th{
	text-align: left;
}
.dos{
	text-align:center;
}
.uno, .dos, .tres{
	width:33%;
	float: left;
}
.detalles p{
	color:#000;
}
.tit{
	margin-left: 2cm;
	text-shadow: 0px 3px 20px black;
	font-size: x-large;
	text-transform: uppercase;
}
</style>
<body>

	<div class="header">
		<table>
		<tr>
			<td style="width: 30%;">
				<h1 class="tit">COTIZAICÓN NO. 706</h1>
			</td>
			<td style="width: 25%; text-align:center;">
				<img width="100" src="logoQualium.png">
			</td>
			<td style="width:25%;padding-top:1%;"><p>
				<b>Qualium Puplicidad y Marqueting</b><br>
				RFC:QPM1201103S5<br>
				Email: <u>contacto@qualium.mx</u><br>
				Teléfono: (999)2852274<br>
				Dirección: Calle 22 #52 x 7 y 9 México Norte, C.P. 97128. Mérida, Yucatán
			</p></td>
			<td style="width:10%""></td>
		</tr>
		</table>
	</div>
	<div class="body">
		<div class="detalles">
		<h4>Detalle</h4>
		<p>
			Un título de crédito, también llamado título valor, es aquel "documento necesario para 
			ejercer el derecho literal y autónomo expresado en el mismo"
		</p>
		</div>
		<table class="concepto" cellspacing="0">
			<thead>
				<tr>
					<th>Servicios</th>
					<th>Horas</th>
					<th>P/Hora</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Página web</td>
					<td> 40hrs. </td>
					<td> $300.00 </td>
					<td>$1200.00</td>
				</tr>
			</tbody>
		</table>

	</div>
	<div class="terminos">
		
		<ul>
			<h4>Términos y condiciones</h4> 
			<li>Para iniciar el trabajo se requiere un brief, la información solicitada completa y haber cubierto el monto del anticipo.</li>
			<li>Al aprobar la cotización, enviaremos un cronograma de actividades con fechas de revisión y entrega.</li>
			<li>Se entregará una propuesta gráfica para su aprobación, una vez aprobada cualquier cambio generará costo adicional.</li>
			<li>Los precios incluyen IVA.</li>
			<li>Anticipo del 50% y saldo contra entrega del 50%. Anticipo no reembolsable.</li>
			<li>El archivo final es propiedad del cliente, el proyecto no.</li>
			<li>El presupuesto se considera aprobado al recibir una copia del mismo firmada por el destinatario.</li>

		</ul>
	</div>
	<div class="footer"></div>

</body>
</html>';
# Instanciamos un objeto de la clase DOMPDF.
$mipdf = new DOMPDF();
 
# Definimos el tamaño y orientación del papel que queremos.
# O por defecto cogerá el que está en el fichero de configuración.landscape
$mipdf ->set_paper("Letter", "portrait");
 
# Cargamos el contenido HTML.
$mipdf ->load_html($html);
 
# Renderizamos el documento PDF.
$mipdf ->render();
 
# Enviamos el fichero PDF al navegador.
$mipdf ->stream('FicheroEjemplo.pdf',array('Attachment'=>0));
?>
