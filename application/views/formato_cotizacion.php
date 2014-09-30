<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Cotizacion</title>	
		<?=
			link_tag("../../css/estilo_formato_cotizacion.css").
			link_tag('http://fonts.googleapis.com/css?family=Philosopher').
			link_tag("../../css/bootstrap-3.1.1-dist/css/bootstrap.min.css").
			link_tag("../../css/bootstrap-3.1.1-dist/css/bootstrap-theme.css").
			link_tag("../../css/bootstrap-3.1.1-dist/js/bootstrap.min.js").
			script_tag('js/jquery.js');
		?>
	</head>
<body>
	<div id="contenedor_formato" >
		<div id="previaCotizacion">
		</div>
		<div class="desborde"></div>

		<div id="servicios">
			<div id="contenedor_cotizados">
				<table >			
					<thead id="theadz">
					    <tr class="taches">
							<th width="400"><p class="servicio">Servicio</p></th><th width="180">Días</th><th width="100">P/Unitario</th><th width="100">Precio</th>
						</tr>
					</thead>
					<tbody id="tbody">
						
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" style="text-align: right;"><p>Total:&nbsp;&nbsp;</p></td>
							<td><p id="total"></p></td>					
						</tr>
					</tfoot>
				</table>
		    </div>
		</div>
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
				<img  src="../../img/formatoCotizacion/face.png" alt="" class="img_redesociales">
				<img src="http://crmqualium.com/img/formatoCotizacion/twitter.png" alt="" class="img_redesociales">
				<img src="http://crmqualium.com/img/formatoCotizacion/google.png" alt="" class="img_redesociales">
				<img src="http://crmqualium.com/img/formatoCotizacion/in.png" alt="" class="img_redesociales">
				<img src="http://crmqualium.com/img/formatoCotizacion/be.png" alt="" class="img_redesociales">
				<img src="http://crmqualium.com/img/formatoCotizacion/vine.png" alt="" class="img_redesociales">
			</div>
</script>
<script type="text/template" id="filaServicio">
	<td><p class="servicio">  <%- idservicio	%><p>	</td>
	<td> <%- duracion	%>  </td>
	<td> <%- precio 	%>	</td>						
	<td class="importe"> <%- importe 	%>	</td>
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
script_tag('js/jquery.js').
script_tag('js/backbone/lib/underscore.js').
script_tag('js/backbone/lib/backbone.js').
script_tag('js/backbone.localStorage.js').

// <!-- MVC -->
script_tag('js/backbone/modelos/ModeloCliente.js').
script_tag('js/backbone/modelos/ModeloRepresentante.js').
script_tag('js/backbone/modelos/ModeloServicio.js').
script_tag('js/backbone/modelos/ModeloLocalCotizacion.js'). 

script_tag('js/backbone/colecciones/ColeccionClientes.js').
script_tag('js/backbone/colecciones/ColeccionServicios.js').
script_tag('js/backbone/colecciones/coleccionRepresentantes.js').
script_tag('js/backbone/colecciones/ColeccionLocalCotizaciones.js');
?> 

<script type="text/javascript">
 app = app || {};

 var datos = Backbone.View.extend({
 	tanName : 'div',
 	plantilla : _.template($('#datosCliente').html()),
 
 	render : function()
 	{
 		this.$el.html(this.plantilla(this.model.toJSON()));
 		return this;
 	}
 });

 var Servicios = Backbone.View.extend({
 	tagName : 'tr',
 	className : '.table',
 	plantilla : _.template($('#filaServicio').html()),
 
 	render : function()
 	{
 		this.$el.html(this.plantilla(this.model.toJSON()));
 		return this;
 	}
 });

 var PreviaCotizacion = Backbone.View.extend({
 	el : 'body',

 	initialize : function()
 	{
 		this.array = 0,
 		app.coleccionLocalCotizaciones.fetch();
 		this.cargarCotizaciones();
 		app.coleccionLocalServicios.fetch();
 		this.cargarServicios();

 	},

 	cargarCotizacion : function(modelo)
 	{
 		// var fecha = formatearFechaUsuario(new Date(modelo.get('fecha')));
 		// console.log(fecha);
 		modelo.set({ fecha      :  formatearFechaUsuario(new Date(modelo.get('fecha')))  });
 		modelo.set({nombreComercial:app.coleccionClientes.get({id:modelo.get('idcliente')}).get('nombreComercial')});	
 		modelo.set({nombre:app.coleccionRepresentantes.get({id:modelo.get('idrepresentante')}).get('nombre')});	
 		var cotizacion = new datos({ model : modelo});
 		this.$('#previaCotizacion').html(cotizacion.render().el);
 	},

 	cargarCotizaciones : function()
 	{
 		app.coleccionLocalCotizaciones.each(this.cargarCotizacion, this);
 	},
 	cargarServicio : function(modelo)
 	{
 		modelo.set({ idservicio : app.coleccionServicios
 				  ({ id         : modelo.get('idservicio')}).get('nombre'),
 				     importe    : (Number(modelo.get( 'precio'    ) ) )*
 				     			  (Number(modelo.get( 'cantidad'  ) ) )-
 				     			  (Number(modelo.get( 'descuento' ) ) ) 				  	 
 				  });

 		var vista = new Servicios({ model: modelo});
 		this.$('#tbody').append( vista.render().el);
 		this.array += parseInt(modelo.get('importe'));		
 		
 	},

 	cargarServicios : function()
 	{
 		app.coleccionLocalServicios.each(this.cargarServicio, this);
 		$('#total').text('$'+this.array);
 	}
 });

 app.previaCotizacion = new PreviaCotizacion();
</script>