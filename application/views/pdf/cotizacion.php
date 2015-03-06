<?php 
# Cargamos la librería dompdf.
require_once 'dom/dompdf_config.inc.php';

$trserv = '';
$hrs=0;
$subtotal=0;
$cont=0;	
$hight = '';
// Procesa primero \r\n así no es convertido dos veces.
$order   = array("\r\n", "\n", "\r");
foreach ($servicios as $key => $val) 
{
	$trserv .='<tr><td style="padding-left:10px;"><strong>'.$val->nombre.'</strong><br>';
	$secciones = json_decode( $val->secciones );

	foreach ($secciones as $sk => $sv) {

		$enter = ( !empty( $sv->seccion ) ) ? '<br>' :'';
		$trserv .= $sv->seccion.' '.$sv->descripcion.$enter;
		$hrs += $sv->horas;

		if($cont<13)
		{
			
			if($cont==12)
			{
				$hight = "margin-top:80%;";
			}else{
				$hight = "position:absolute;bottom:80px;";
			}
			$cont++;
		}
	}

	$trserv .= '</td><td>'.$hrs.'</td>';
	$trserv .= '<td>$'.$cotizacion->preciotiempo.'</td>';
	$trserv .= '<td>$'.( $hrs * $cotizacion->preciotiempo ).'</td>';
	$trserv .='</td></tr>';
	$subtotal += ( $hrs * $cotizacion->preciotiempo );
	$hrs =0;
}	

$iva = round( ( $subtotal * 0.16 ), 2);
$trserv .= '<tr><td></td><td></td><td>Total:</td><td>$'.$subtotal.'</td></tr>';
$trserv .= '<tr><td></td><td></td><td>IVA</td><td>$'.$iva.'</td></tr>';
$trserv .= '<tr><td></td><td></td><td>Precio Neto:</td><td>$'.( $subtotal + $iva ).'</td></tr>';

$html = '<html><style>
html, body{
	margin: 0;
	font-family:sans-serif;
	font-size:12px;
	color:#555;
}
.header{
	background: rgba(64, 64, 64, 1);
	color: white;
	height: 130px;
	padding-top:1%;
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
.terminos{'.$hight.'
	width:100%;
}
.body table{
	margin: 2% auto;
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
.detalles h4, .detalles p{
	padding:0;
	margin:0;
}
.detalles h4{
	margin-top:15px;
}
.tit{
	margin-left: 2cm;
	text-shadow: 0px 3px 20px black;
	font-size: x-large;
	text-transform: uppercase;
}
.datosq{
	padding-top:1%;
	font-size:10px;
}
</style>
<body>
	<div class="header"><table ><tr><td width="280px"><h1 class="tit">'.$cotizacion->titulo.'</h1></td>
		<td width="160px" style="padding-left:10px;">
			<img width="100" src="'.base_url().'img/logoQualium.png">
		</td>
		<td width="200px" class="datosq"><p>
			<b>Qualium Puplicidad y Marqueting</b><br>
			RFC:QPM1201103S5<br>
			Email: <u>contacto@qualium.mx</u><br>
			Teléfono: (999)2852274<br>
			Dirección: Calle 22 #52 x 7 y 9 México Norte, C.P. 97128. Mérida, Yucatán
		</p></td>
		</tr>
		</table>
	</div>
	<div class="body">
		<div class="detalles">
			<h4>Detalle</h4>
			<p>'.$cotizacion->detalles.'</p>
		</div>
		<table class="concepto" cellspacing="0">
			<thead>
				<tr>
					<th style="padding-left:10px;">Servicios</th>
					<th>Horas</th>
					<th>P/Hora</th>
					<th></th>
				</tr>
			</thead>
			<tbody>'.$trserv.'</tbody></table>
	</div><br><br><br>
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

		</ul></div><div class="footer"></div></body></html>';

// die($html);
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
