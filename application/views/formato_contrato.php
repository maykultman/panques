<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<div id="divVistapreviaContrato"></div>
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
	nplazos: 				<%- nplazos %>											<br>
	plan: 					<%- plan %>												<br>
	plazo: 					<%- plazo %>											<br>
	nombreComercial: 		<%- nombreComercial %>									<br>
	nombreRepresentante: 	<%- nombreRepresentante %>								<br>
	titulocontrato: 		<%- titulocontrato %>									<br>
	total: 					<%- total %>											<br>
	pago mensual:			<%- (total/nplazos).toFixed(2) %>						<br>
</script>

<script type="text/template" id="plantilla_contrato">
	<% var meses = new Array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'), Anio_Mes_dia %>
		
	
	<div style="width: 612px; height: 792px; margin-left: auto; margin-right: auto;">
		<h3 style="text-align: center;"><font face="Tahoma"><b>Contrato de prestación de servicios</b></font></h3>

		<p style="text-align:justify;line-height: 2em; font-size: 11pt; margin-top: -20"><span
		style='font-family:"Tahoma","sans-serif"'><br>
		Entre <b><u>Qualium Publicidad y Marketing
		SCP.</u> ,</b> con domicilio principal en la ciudad de Mérida, Yucatán, quien en adelante se denominará CONTRATISTA, identificado como aparece al pie de su
		firma y por otra parte 
		
		<b><u><%- nombreComercial %></u></b>,
		quien se identifica como aparece al pie de su
		firma y en adelante se denominará CONTRATANTE, hemos convenido en celebrar un
		contrato de prestación de servicios profesionales que se regulará por las
		cláusulas que a continuación se expresan y en general por las disposiciones del
		Código Civil y Código de Comercio aplicables a la materia de que trata este
		contrato:</span></p>

		<p style="text-align:justify;line-height: 2em; font-size: 11pt"><b><span  style='font-family:"Tahoma","sans-serif"'>Primera</span></b><span style='font-family:"Tahoma","sans-serif"'>. Objeto. El CONTRATISTA,de manera independiente, sin subordinación o dependencia, utilizando sus propios medios, elementos de trabajo, personal a su cargo, prestará el servicio de 



		<b><u><%- titulocontrato %></u></b> que incluirán lo presentado en la cotización.<u></u></span></p>



		<p style="text-align:justify;line-height: 2em; font-size: 11pt" ><b><span  style='font-family:"Tahoma","sans-serif"'>Segunda</span></b><span
		style='font-family:"Tahoma","sans-serif"'>. Término del Contrato.
		Este Contrato de Prestación de Servicios se extenderá por un periodo de 


		<u><b><%= nplazos == 1 ? nplazos+' mes' : nplazos+' meses' %> ( 
		<% Anio_Mes_dia = fechainicio.split('-'); %>
		<% for (var i = 0; i < meses.length+1; i++) { %>
			<% if (i == Anio_Mes_dia[1]) { %>
				<%- meses[i-1] %>
			<% }; %>
		<% }; %>
		 de <%-Anio_Mes_dia[0]%> 
		<span></span>a 
		 <% Anio_Mes_dia = fechafinal.split('-'); %> 
		<% for (var i = 0; i < meses.length+1; i++) { %>
			<% if (i == Anio_Mes_dia[1]) { %>
				<%- meses[i-1] %>
			<% }; %>
		<% }; %>
		 de <%-Anio_Mes_dia[0]%>).</b></u></span></p>

		<p style="text-align:justify;line-height: 2em; font-size: 11pt"><b><span  style='font-family:"Tahoma","sans-serif"'>Tercero</span></b><span
		 style='font-family:"Tahoma","sans-serif"'>. Honorarios. – El
		CONTRATANTE pagará al CONTRATISTA por concepto de honorarios <u><span></span><b><%- mensualidadletras %></b></u><b> ($<%- (total/nplazos).toFixed(2) %>) mensuales.</b></span></p>






		<p style="text-align:justify;line-height: 2em; font-size: 11pt"><b><span  style='font-family:"Tahoma","sans-serif"'>Cuarta</span></b><span
		 style='font-family:"Tahoma","sans-serif"'>. Prorroga. Si vencido el
		plazo establecido para la ejecución del contrato de prestación de servicios el
		CONTRATANTE decide ampliar el plazo de vencimiento, se suscribirá minuta
		suscrita por las partes, que hará parte integral de este contrato. </span></p>

		<p style="text-align:justify;line-height: 2em; font-size: 11pt"><b><span  style='font-family:"Tahoma","sans-serif"'>Quinta</span></b><span
		 style='font-family:"Tahoma","sans-serif"'>. Nuevo servicio. Si
		finalizado el objeto del servicio contratado, el CONTRATANTE necesita un nuevo
		servicio del CONTRATISTA, se deberá hacer un nuevo Contrato de Prestación de
		Servicios y no se entenderá como prorroga por desaparecer las causas
		contractuales que dieron origen a este contrato.</span></p>

		<p style="text-align:justify;line-height: 2em; font-size: 11pt"><b><span  style='font-family:"Tahoma","sans-serif"'>Sexta</span></b><span
		 style='font-family:"Tahoma","sans-serif"'>. Obligaciones del CONTRATISTA.
		Son<span >  </span>obligaciones del CONTRATISTA: 1.
		Obrar con seriedad y diligencia en el servicio contratado, 2. Realizar informes
		quincenales hasta el término de las páginas web. 3. Atender las solicitudes y
		recomendaciones que haga el CONTRATANTE o sus delegados, con la mayor
		prontitud. 4. Proveer al CONTRATANTE o un delegado información pertinente para
		el desarrollo del proyecto. </span></p>

		<p style="text-align:justify;line-height: 2em; font-size: 11pt"><b><span  style='font-family:"Tahoma","sans-serif"'>Séptima</span></b><span
		 style='font-family:"Tahoma","sans-serif"'>. Obligaciones del CONTRATANTE.
		Son obligaciones del CONTRATANTE:1. Cancelar los honorarios fijados al
		CONTRATISTA, según la forma que se pacto dentro del término debido. 2. Entregar
		toda la información que solicite el CONTRATISTA para poder desarrollar con
		normalidad su labor independiente.</span></p>   

		<p style="text-align:justify;line-height: 2em; font-size: 11pt"><b><span  style='font-family:"Tahoma","sans-serif"'>Octava</span></b><span
		 style='font-family:"Tahoma","sans-serif"'>. Terminación anticipada o
		anormal. – Incumplir las obligaciones propias de cada una de las partes, dará
		lugar a la otra para terminar unilateralmente el Contrato de Prestación de
		Servicio. </span></p>

		<p style="text-align:justify;line-height: 2em; font-size: 11pt"><b><span  style='font-family:"Tahoma","sans-serif"'>Novena</span></b><span
		 style='font-family:"Tahoma","sans-serif"'>. Terminación del contrato.
		– El contrato se dará como finalizado al término del pago de las meses
		pactados.</span></p>

		<p style="text-align:justify;line-height: 2em; font-size: 11pt"><span 
		style='font-family:"Tahoma","sans-serif"'>En todo caso, este contrato presta
		mérito ejecutivo por ser una obligación clara, expresa y exigible para ambas
		partes.</span></p>

		<% Anio_Mes_dia = fechafirma.split('-'); %>

		<p style="text-align:justify;line-height: 2em; font-size: 11pt"><span 
		style='font-family:"Tahoma","sans-serif"'>Este Contrato de Prestación de
		Servicios se firma en dos ejemplares para las partes en Mérida, Yucatán <%= Anio_Mes_dia[2] == 01 ? 'al (' +Anio_Mes_dia[2]+ ') día' : 'a los (' +Anio_Mes_dia[2]+ ') días' %>
		 del mes de 
		<% for (var i = 0; i < meses.length+1; i++) { %>
			<% if (i == Anio_Mes_dia[1]) { %>
				<%- meses[i-1] %>
			<% }; %>
		<% }; %>
		 del año <u><%- Anio_Mes_dia[0] %></u>.</span></p>
		 <br><br>
		 <div style="width:50%; display: inline-block; ">

		 <h3 style="text-align:center">El contratante</h3>
		 <hr style="margin-top:60px; margin-left:20px; margin-right:20px;" >		
		 <p style="line-height: 2em; font-size: 12pt; margin-top:-5px; text-align: center;" ><span 
		  style='font-family:"Tahoma","sans-serif"'><%- nombreComercial %></span></p>
		 </div>
		 <div style="width:49%; display: inline-block; ">

		 <h3 style="text-align:center">El contratista</h3>
		 <hr style="margin-top:60px; margin-left:20px; margin-right:20px;">		
		 <p style="line-height: 2em; font-size: 12pt; margin-top:-5px; text-align: center;" ><span 
		  style='font-family:"Tahoma","sans-serif"'>Qualium Publicidad y Marketing
		SCP</span></p>
		 </div>
	</div>

</script>

<?=script_tag('js/backbone/app.js')?>
<script type="text/javascript">
	var app = app || {};
	app.iva = 0.16;
	
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
	script_tag('js/backbone/colecciones/ColeccionContratos.js').
	script_tag('js/backbone/colecciones/ColeccionServiciosContrato.js').
	script_tag('js/backbone/colecciones/ColeccionPagos.js');
?>
	<script type="text/javascript">
		app.coleccionContratos = new ColeccionContratos();
		app.coleccionServiciosContrato = new ColeccionServiciosContrato();
		app.coleccionPagos = new ColeccionPagos();

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
			el	: '#divVistapreviaContrato',
			initialize	: function () {
				// this.listenTo(app.coleccionContratos_LocalStorage,'add',this.cargarContrato);
				app.coleccionContratos_LocalStorage.fetch();
				app.coleccionServiciosContrato_LocalStorage.fetch();
				app.coleccionPagos_LocalStorage.fetch();
				
				
				
				this.cargarContratos();

			},
			cargarContrato	: function (contrato) {
				contrato.set({nombreComercial:app.coleccionClientes.get({id:contrato.get('idcliente')}).get('nombreComercial')});
				contrato.set({nombreRepresentante:app.coleccionRepresentantes.get({id:contrato.get('idrepresentante')}).get('nombre')});

				var precio = 0.0;
				var descuento = 0.0;
				var total = 0.0;

				var cantidades = app.coleccionServiciosContrato_LocalStorage.pluck('cantidad');
				var precios = app.coleccionServiciosContrato_LocalStorage.pluck('precio');
				var descuentos = app.coleccionServiciosContrato_LocalStorage.pluck('descuento');
				if ($.isArray(cantidades[0])) {
					for (var i = 0; i < cantidades[0].length; i++) {
						precio 		= cantidades[0][i] * precios[0][i];
						descuento 	=precio * ( descuentos[0][i]/100 );
						total 		+= parseFloat((precio - descuento).toFixed(2));
					};
				} else{
					precio 		= cantidades[0] * precios[0];
					descuento 	=precio * ( descuentos[0]/100 );
					total 		+= parseFloat((precio - descuento).toFixed(2));
				};
				console.log(contrato);
				contrato.set({total:(total + (total*app.iva)).toFixed(2)});
				var vista = new V_HojaContrato({model:contrato});
				this.$el.html(vista.render().el);
			},
			cargarContratos	: function () {
				app.coleccionContratos_LocalStorage.each(this.cargarContrato, this);
			}
		});

		var consulta_Hoja = new Consulta_Hoja();

		app.coleccionContratos_LocalStorage.each(function (model){ 
			model.destroy();
		},this);
		app.coleccionServiciosContrato_LocalStorage.each(function (model){ 
			model.destroy();
		},this);
		app.coleccionPagos_LocalStorage.each(function (model){ 
			model.destroy();
		},this);
	</script>