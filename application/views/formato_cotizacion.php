<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Cotizacion</title>	
		<?=
			script_tag('js/jquery.js').
			script_tag('js/plugin/jsPDF/jspdf.min.js').
			link_tag("css/estilo_formato_cotizacion.css").
			link_tag('http://fonts.googleapis.com/css?family=Philosopher').
			link_tag("css/bootstrap-3.1.1-dist/css/bootstrap.min.css").
			link_tag("css/bootstrap-3.1.1-dist/css/bootstrap-theme.css").
			script_tag("css/bootstrap-3.1.1-dist/js/bootstrap.min.js");
		?>
	</head>
	<body>
		<div id="contenedor_formato">
			<!-- <button type="button" id="imprimir" class="btn btn-default" onclick="print()">Inprimir</button> -->
			<button type="button" id="imprimir" class="btn btn-default">Inprimir</button>
			<div id="previaCotizacion">
			</div>
			<div class="desborde"></div>

			<table class="table table-condensed">			
				<thead>
				    <tr>
						<th width="200">Servicio</th>
						<th width="430">Descripción</th>
						<th width="50">Horas</th>
						<th width="100" style="text-align: right;">Precio</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
				</tfoot>
			</table>
			<div id="div_terminos">
				<p style="margin: 0 38px;"><b>Términos y condiciones</b></p>
					<ul>
					    <li>Para iniciar el trabajo se requiere un brief, la información solicitada completa y haber cubierto el monto del anticipo.
					    </li>
					    <li>Al aprobar la cotización, enviaremos un cronograma de actividades con fechas de revisión y entrega.
						 </li>
						 <li>Se entregará una propuesta gráﬁca para su aprobación, una vez aprobada cualquier cambio generará
						  costo adicional.
					     </li>
						 <li>Los precios NO incluyen IVA.</li>
						 <li>Anticipo del 50% y saldo contra entrega del 50%. Anticipo no reembolsable.</li>
						 <li>El archivo ﬁnal es propiedad del cliente, el proyecto no.</li>
						 <li>El presupuesto se considera aprobado al recibir una copia del mismo firmada por el destinatario.</li>
					</ul>	
			</div>	
			<div id="pie" style=" ">    	
			</div>
		</div>	
		<!-- <td><%-importe%></td> -->
	</body>
</html>
<!-- Plantilla -->
<script type="text/template" id="datosCliente">
	<div id="cabecera">
		<div id="contenedor_izq">
			<label id="p_titulo" >PRESUPUESTO</label>
			<div class="desborde"></div>
			<label  id="label_nomcotizacion"><%- titulo %></label>
		</div>

		<div id="contenedor_derecho">
			<img  src="http://crmqualium.com/img/formatoCotizacion/logoQualium.png" alt="" width="150px" height="150px" style="margin-top: 10px; margin-left: -30px;">
			<div id="div_fecha">
				<label><b class="white"><%-fecha%></b></label>
			</div>
			<div id="lbl_cliente">
				<label><font color="white"><b class="white">Cliente:</b></font></label>
		    </div>
		    <div id="lbl_nomcliente">
		    <label  class="white"><%- nombreComercial %></label>
		    </div>
		    <div id="lbl_representante">
		    <label  class="white">Representante: </label>
		    </div>
		    <div id="lbl_nombrerepresentante">
		    <label  class="white"><%- nombre%> </label>
		    </div>
		</div>    
	    				
	</div>
	<div class="desborde"></div>
	<div id="barra">
	</div>
	<div id="detalles">	
		<div>
			<p style="margin-top: -1px;"><b>Detalle</b></p>					
				<p style="color:gray !important;"><%- detalles %></p>					
		</div>
		<div id="caract">
			<p style="margin-top: -1px;"><b>Características:</b></p>
		    <p style="color:gray !important;">	<%- caracteristicas%></p>
		</div>		    
	</div>

	<div id="info_contacto">
		<p style="margin-left:15px; margin-top: 10px;" class="white"><b class="white">Contacto</b><br>
		Email: contacto@qualium.mx<br>
		Teléfono: (999)2852274<br>
		Dirección: Calle 22 x 7 y 9
		Col.México, C.P. 97113. Mérida, Yucatán.<br>
	    <a href="http://qualium.mx/" target="_blank" >www.qualium.mx</a><br><br>
        <b  class="white">Horario de  atención</b><br>
		Lunes  a viernes 9am - 6pm</font></p>
	</div>
	<div class="desborde"></div>
	<div id="redes_sociales">
		<img  src="<?=base_url().'img/formatoCotizacion/face.png'?>" alt="" class="img_redesociales">
		<img src="<?=base_url().'img/formatoCotizacion/twitter.png'?>" alt="" class="img_redesociales">
		<img src="<?=base_url().'img/formatoCotizacion/google.png'?>" alt="" class="img_redesociales">
		<img src="<?=base_url().'img/formatoCotizacion/in.png'?>" alt="" class="img_redesociales">
		<img src="<?=base_url().'img/formatoCotizacion/be.png'?>" alt="" class="img_redesociales">
		<img src="<?=base_url().'img/formatoCotizacion/vine.png'?>" alt="" class="img_redesociales">
	</div>
</script>
<script type="text/template" id="filaServicio">
	<td><%= servicio	%></td>
	<td> <ul style="margin:0px; padding-left:20px;"><%= descripcion	%></ul>  </td>
	<td style="text-align: left;"> <%= horas 	%>	</td>						
	<td class="importe" style="text-align: right;"> <%= importe %>	</td>
</script>
<script id="tfoot">
	<tr>
		<td colspan="3" style="text-align: right;">Subtotal: </td>
		<td style="text-align: right;"><%= subtotal %></td>					
	</tr>
	<% if (descuento > 1) { %>
		<tr>
			<td colspan="3" style="text-align: right;">Descuento (<%= descuento %>%): </td>
			<td style="text-align: right;"><%= valordescuento %></td>					
		</tr>
	<% }; %>
	<tr>
		<td colspan="3" style="text-align: right;">I.V.A. (16%): </td>
		<td style="text-align: right;"><%= iva %></td>					
	</tr>
	<tr>
		<td colspan="3" style="text-align: right;">Total: </td>
		<td style="text-align: right;"><%= total %></td>					
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
	script_tag('js/backbone/modelos/ModeloLocalCotizacion.js'). 

	script_tag('js/backbone/colecciones/ColeccionClientes.js').
	script_tag('js/backbone/colecciones/ColeccionServicios.js').
	script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
	script_tag('js/backbone/colecciones/ColeccionLocalCotizaciones.js');
?> 

<script type="text/javascript">
 app = app || {};

 var VistaPrevia = Backbone.View.extend({
 	el : 'body',
 	plantillas	: {
 		datos 		: _.template($('#datosCliente').html()),
 		servicio 	: _.template($('#filaServicio').html()),
 		totales 	: _.template($('#tfoot').html()),
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
 		app.coleccionLocalCotizaciones.fetch();
 		this.cargarCotizacion();
 		app.coleccionLocalServicios.fetch();
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
			, loremipsum = this.$el.html();

			// Margins:
			doc.setDrawColor(0, 255, 0)
				.setLineWidth(1/72)
				.line(margin, margin, margin, 11 - margin)
				.line(8.5 - margin, margin, 8.5-margin, 11-margin);

			// the 3 blocks of text
			for (var i in fonts){
				if (fonts.hasOwnProperty(i)) {
					font = fonts[i];
					size = sizes[i];

					lines = doc.setFont(font[0], font[1])
								.setFontSize(size)
								.splitTextToSize(loremipsum, 7.5);
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
				}
			}

		doc.save('Test.pdf');
 	},
 	cargarCotizacion : function(modelo) {

 		var json = app.coleccionLocalCotizaciones.toJSON()[0];

 		json.fecha = formatearFechaUsuario(new Date(json.fecha));
		json.nombreComercial = app.coleccionClientes.get({id:json.idcliente}).get('nombreComercial');
		json.nombre = app.coleccionRepresentantes.get({id:json.idrepresentante}).get('nombre');

 		this.$('#previaCotizacion').html( this.plantillas.datos(json) );
 		this.preciohora = Number(json.preciohora);
 		this.descuento = Number(json.descuento);
 	},

 	cargarServicios : function () {
 		var idservicios = app.coleccionLocalServicios.pluck('idservicio'),
 		
 		idservicios = _.union(idservicios);

 		for (var i = 0; i < idservicios.length; i++) {
 			// vista = new Servicios({ model: modelo});
	 		this.$('tbody').append( '<tr>'+this.plantillas.servicio(this.obtenerServicio(idservicios[i]))+'</tr>' );
 		};

 		this.totales();
 	},
 	
 	obtenerServicio : function (idservicio) {
 		var json = {
 				idservicio 	: '',
 				descripcion : '',
 				horas 		: 0,
 			},
 			modelos,
 			importe = 0;

 		modelos = app.coleccionLocalServicios.where( {idservicio: idservicio} );

 		for (var i = 0; i < modelos.length; i++) {
 			json.descripcion += '<li>'+(modelos[i].get('descripcion')+'</li>');
 			json.horas += Number(modelos[i].get('horas'));
 		};
 		json.servicio = app.coleccionServicios.get(idservicio).get('nombre');
 		json.importe = json.horas * this.preciohora;

 		/*Variables globales*/
 		this.horas += json.horas;
 		
 		return json;
 	}, 
 	totales : function () {
 		var total = 0,
 			json = {};
 		total = this.horas * this.preciohora;
 				json.subtotal = ''+total.toFixed(2);
				json.descuento = this.descuento;
				json.valordescuento = ''+(total * this.descuento/100).toFixed(2);
		total = total - total * (this.descuento/100).toFixed(2);
				json.iva = ''+(total * 0.16).toFixed(2);
		total = total + total * 0.16;
		total = '' + total.toFixed(2);
		total = total.split('.');
		decimales = total[1];
		total = conComas(total[0].split(''));
				json.total = '$'+total+'.'+decimales;
		
		this.$('tfoot').html( this.plantillas.totales(json) );
 	}
});

 app.vistaPrevia = new VistaPrevia();

</script>