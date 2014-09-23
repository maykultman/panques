		<?=link_tag('css/estilos_modulo_contratos.css');?>
		<!-- scrpit de prueba para la fecha y efecto de toggle para mostrar detalles del servicio -->
		<section class="secciones1">
			<form id="formulario">
				<div class="row" >
					<div class="col-md-6">
						<h3>Datos basicos</h3>					
						<hr>
						<div>
							<input type="text" id="busqueda" class="form-control input_largo" placeholder="Buscar cliente">
							<input type="hidden" id="hidden_idCliente" name="idcliente">
							<span id="span_buscar" class="icon-search"></span>
							<!--  -->	
							<input type="text" id="input_Representante" class="form-control input_largo" disabled placeholder="Representante">
							<input type="hidden" id="hidden_idRepresentante" name="idrepresentante">
							<!--  -->
							<input type="text" class="form-control input_largo" name="titulocontrato" placeholder="Nombre para el contrato">
							<!--  -->
							<input type="text" id="fechaFirma" class="form-control datepicker input_largo" placeholder="Fecha en que se firmará el contrato">
							<input type="hidden" id="hidden_fechafirma" name="fechafirma">
							<input type="hidden" id="hidden_idEmpleado" name="idempleado" value="65"><!-- BOORAR CUANDO EXISTAN SESIONES -->
					    </div><br>						
						
						<h5 style="display: inline-block"><b>Eliga Tipo de plan:</b></h5>
						<div id="planes" class="btn-group" data-toggle="buttons">
							<label for="evento" class="btn btn-primary">
								<input type="radio" name="plan" id="evento" class="btn_plan" value="evento">Por Evento
							</label>
							<label for="iguala" class="btn btn-primary">
								<input type="radio" name="plan" id="iguala" class="btn_plan" value="iguala">Iguala Mensual
							</label>			
						</div>
					</div>					
					<div class="col-md-6" >	
						<h3>Servicios a contratar</h3>
						<hr>								            
						<div id="tabla_servicios" class="panel panel-primary">
					        <!-- Default panel contents -->
					        <div class="panel-heading">Seleccionar Servicios</div>
					        <!-- Table -->
					        <table class="table">
					        <tbody id="tbody_servicios">
					        	<!-- PLANTILLAS DE SERVICIOS -->
							</tbody>
					      </table>
					    </div>
					</div>    
				</div>
				<br><br>        			    
			    <table id="tabla_contrato" class="table table-striped"><!--  border="1" -->
					<thead style="background-color: #f9f9f9!important;">
						<tr>
							<td></td>
							<td><b>Servicio</b></td>
							<!-- <td><b>Realización</b></td> -->
							<td><b>Cantidad</b></td>							
							<td><b>P/Unitario</b></td>
							<td><b>Descuento</b></td>
							<td><b>Precio</b></td>
						    <td></td>					
						</tr>							
					</thead>			
					<tbody id="tbody_servicios_seleccionados">
						<!-- PLANTILLAS DE SERVICIOS A CONTRATAR -->
					</tbody>
					<tbody id="totales">
						<tr class="warning">
							<td></td>
							<td colspan="4"><b>Importe</b></td>						
							<td><b id="importe">$0.00</b></td>						
							<td></td>					
					    </tr>
					    <tr>
							<td></td>
							<td colspan="4"><b>IVA</b></td>						
							<td><b id="IVA">$0.00</b></td>						
							<td></td>					
					    </tr>
					    <tr class="info">
							<td></td>
							<td colspan="4"><b>Total Neto</b></td>
							<td><b id="totalNeto">$0.00</b></td>						
							<td></td>					
					    </tr>
					    <tr style="height: 100px">
					    	<td colspan="8">				    		
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default btn-xs">
										<input type="checkbox" id="checkboxServicios" class="btn_marcarTodos"> Marcar todos
									</label>
								</div>
								<button type="button" class="btn btn-danger btn-xs checkboxServicios btn_eliminarMarcados">Eliminar marcados</button>
					    	</td>
						</tr>
					</tbody>				
			        <thead id="tbody_porEvento" class="tabla_oculto" style="background-color: #f9f9f9!important;">
				    	<tr>
							<td colspan="8">
								<div class="row">
									<div class="col-md-3">
										<input class="form-control datepicker inputs_planEvento input_fechaInicioPago" type="text"  placeholder="Inicio">
										<input type="hidden" id="fechainicio" name="fechainicio">
									</div>
									<div class="col-md-3">
										<input type="number" id="plazo"  class="form-control inputs_planEvento" name="plazo" min="1" max="" placeholder="Plazo en días">	
									</div>
									<div class="col-md-3">
										<input type="number" class="form-control inputs_planEvento n_pagos" name="nPlazos" min="1" max="" placeholder="Numero de Plazos">	
									</div>
									<div class="col-md-3">
										<input id="vencimientoPlanEvento" class="form-control datepicker inputs_planEvento" disabled type="text" placeholder="Vencimiento">
										<input id="fechafinalEvento" type="hidden" id="" name="fechafinal">
									</div>									
								</div>
							</td>	       									          			         
				        </tr>
				        <tr>
				          <td colspan="2"><b>No. de Pago</b></td>
				          <td colspan="3"><b>Fecha de pago</b></td>
				          <td colspan="3"><b>Renta Mensual</b> <button type="button"><span id="btn_recargarPagos" class="icon-refresh"></button> </td>
				        </tr>
					</thead>
					<thead id="tbody_iguala" class="tabla_oculto" style="background-color: #f9f9f9!important;">
				    	<tr>
							<td colspan="8">
								<div class="row">
									<div class="col-md-4">
										<input class="form-control datepicker inputs_planIguala input_fechaInicioPago" type="text"  placeholder="Inicio">
									</div>
									<div class="col-md-4">
										<select class="form-control inputs_planIguala n_pagos" name="mensualidades">
										  <option value="1">1 Mes</option>
										  <option value="3">3 Meses</option>
										  <option value="6">6 Meses</option>
										  <option value="12">12 Meses</option>
										  <option value="18">18 meses</option>
										  <option value="24">24 meses</option>
										  <option value="48">48 meses</option>
										  <option selected value="">Seleccione duración de contrato</option>
										</select>	
									</div>
									<div class="col-md-4">
										<input id="vencimientoPlanIguala" class="form-control datepicker inputs_planIguala" disabled type="text" placeholder="Vencimiento">
										<input id="fechafinalIguala" type="hidden" id="" name="fechafinal">
									</div>									
								</div>
							</td>	       									          			         
				        </tr>
				        <tr>
							<td colspan="2"><b>No. de Pago</b></td>
							<td colspan="3"><b>Fecha de pago</b></td>
							<td colspan="3">
								<b>Renta Mensual</b>
								<input type="texto" class="form-control input-sm inputs_planIguala" name="mensualidadletras" placeholder="Pago mensual en letras">
							</td>
				        </tr>
					</thead>
					<!-- <tbody>
				        <tr>
				          <td colspan="2"><b>No. de Pago</b></td>
				          <td colspan="3"><b>Fecha de pago</b></td>
				          <td colspan="3"><b>Renta Mensual</b></td>
				        </tr>
					</tbody> -->
					<tbody id="tbody_pagos">					
				       <!-- PLANTILLAS DE PAGOS DE CONTRATO -->
					</tbody>
					<tbody>
						<tr>
							<td colspan="2"></td>
							<td colspan="3"></td>
							<td colspan="3" id="margen">$0.00</td>
						</tr>
					</tbody>
			    </table>
			    <input id="version" type="hidden" name="version" value="1">
			   	<div class="desborde"></div>		 
			   	<button type="submit" id="btn_guardar" class="btn btn-default">Guardar</button>
			   	<a id="btn_vistaPrevia" target="_blanck" class="btn btn-primary" href="formatoContrato"><span class="icon-preview"></span>Vista previa</a>
			   	<button type="button" id="btn_calcelar" class="btn btn-default">Cancelar</button>
		   	</form>
		</section> 
		<section class="secciones2" style="display:none">
			<h1>Vispre previa del contrato</h1> <button id="cerrar_vistaPrevia">Cerrar vista previa</button>
			<div id="divVistapreviaContrato">
			</div>
		</section>    	 
	</section>	                
</div>


<!-- plantillas -->
	<script type="text/template" id="plantillaServicio">
		<td style="width: 580px">
			<!--<span   class="icon-info icon_detalles" data-toggle="tooltip" title="Información"></span>-->
			<label class="clasePrueba" for="servicio_<%- id %>" style="width:100% !important;"><%- nombre %></label>
			<div class="div_info" style="display: none;">
				<ul>	
					<li>Concepto: 		<h7><%- concepto %>		</h7><li>
					<li>P/Unitario: 	<h7>$<%- precio %>		</h7><li>
					<li>+IVA: 			<h7>$<%- masiva %>		</h7><li>
					<li>Realización: 	<h7><%- realizacion %>	</h7><li>
					<li>Descripcion: 	<h7><%- descripcion %>	</h7><li>
			    </ul>
		    </div>
		    <div class="check_posicion">
		    	<input type="checkbox" id="servicio_<%- id %>" class="checkbox_servicio">
		    </div>
		</td>
	</script>
	<script type="text/template" id="servicioContratado">
		<td style="width: 50px;"><input type="checkbox"></td>
		<td><%- nombre %><input type="hidden" name="idservicio" value="<%- idserv %>"></td>
		<!-- <td><input id="realizacion" class="input_precio inputsServicios" 	name="realizacion"	type="text" value="<%- realizacion %>" placeholder="Realización"></td> -->
		<td><input id="cantidad" 	class="input_precio inputsServicios" 	name="cantidad"		type="number" value="<%- cantidad %>" min="1"></td>
		<td><input id="precio" 		class="input_precio inputsServicios"	name="precio"		type="number" value="<%- precio %>"></td>
		<td><input id="descuento" 	class="input_descuento inputsServicios" name="descuento"	type="number" min="0" max="100" value="<%- descuento %>"> %</td>
		<td>$<%- total %> <input type="hidden" class="total" value="<%- total %>"></td>
		<td class="icon-eliminar">
        	<div class="eliminar_cliente">
    			<span id="<%- idserv %>" class="icon-circledelete eliminar"  data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
           </div>
       </td>
	</script>
	<script type="text/template" id="tr_pagos">
			<td colspan="2"><%- n %></td>
			<td colspan="3">
				<%- fecha %>
				<input type="hidden" name="fechapago" value="<%- fecha2 %>">
			</td>
			<td colspan="3">
				$
				<input type="number" id="<%- id %>" min="1" max="" value="<%- pago %>" class="<%- atrClase %>" <%- checked %>>
				<input type="hidden" class="hidden_renta" name="pago" value="<%- pago %>">
				<span class="<%- candado %>"></span>
			</td>
	</script>
	<script type="text/template" id="plantilla_contrato">
		<!--fechacreacion: 			<%- formatearFechaUsuario(new Date(fechacreacion)) %>	<br>
		fechafinal: 			<%- formatearFechaUsuario(new Date(fechafinal)) %>		<br>
		fechafirma: 			<%- formatearFechaUsuario(new Date(fechafirma)) %>		<br>
		fechainicio: 			<%- formatearFechaUsuario(new Date(fechainicio)) %>		<br>
		id: 					<%- id %>												<br>
		idcliente: 				<%- idcliente %>										<br>
		idrepresentante: 		<%- idrepresentante %>									<br>
		nplazos: 				<%- nplazos %>											<br>
		plan: 					<%- plan %>												<br>
		plazo: 					<%- plazo %>											<br>
		nombreCliente: 			<%- nombreCliente %>									<br>
		nombreRepresentante: 	<%- nombreRepresentante %>								<br>
		nombrecontrato: 		<%- nombrecontrato %>									<br>
		total: 					<%- total %>											<br>
		pago mensual:			<%- (total/nplazos).toFixed(2) %>						<br>-->
	</script>

<?=script_tag('js/backbone/app.js');?>
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
	script_tag('js/backbone/colecciones/ColeccionPagos.js');?>
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
		// app = app || {};
		// var V_HojaContrato = Backbone.View.extend({
		// 	tagName			: 'div',
		// 	plantilla	: _.template($('#plantilla_contrato').html()),
		// 	render		: function () {
		// 		this.$el.html(this.plantilla(this.model.toJSON()));
		// 		return this;
		// 	}
		// });

		// var Consulta_Hoja	= Backbone.View.extend({
		// 	el	: '#divVistapreviaContrato',
		// 	initialize	: function () {
		// 		this.cargarContratos();
		// 	},
		// 	cargarContrato	: function (contrato) {
		// 		contrato.set({nombreCliente:app.coleccionClientes.get({id:contrato.get('idcliente')}).get('nombreComercial')});
		// 		contrato.set({nombreRepresentante:app.coleccionRepresentantes.get({id:contrato.get('idrepresentante')}).get('nombre')});

		// 		var precio = 0.0;
		// 		var descuento = 0.0;
		// 		var total = 0.0;

		// 		var cantidades = app.coleccionServiciosContrato_LocalStorage.pluck('cantidad');
		// 		var precios = app.coleccionServiciosContrato_LocalStorage.pluck('precio');
		// 		var descuentos = app.coleccionServiciosContrato_LocalStorage.pluck('descuento');

		// 		for (var i = 0; i < cantidades[0].length; i++) {
		// 			precio 		= cantidades[0][i] * precios[0][i];
		// 			descuento 	=precio * ( descuentos[0][i]/100 );
		// 			total 		+= parseFloat((precio - descuento).toFixed(2));
		// 		};
		// 		console.log((total + (total*app.iva)).toFixed(2));
		// 		contrato.set({total:(total + (total*app.iva)).toFixed(2)});
		// 		var vista = new V_HojaContrato({model:contrato});
		// 		this.$el.html(vista.render().el);
		// 	},
		// 	cargarContratos	: function () {
		// 		app.coleccionContratos_LocalStorage.each(this.cargarContrato, this);
		// 	}
		// });
	</script>
	<?=
		script_tag('js/backbone/vistas/VistaServicio.js').// <!-- Heredamos la clase VistaServicio -->
		script_tag('js/backbone/vistas/VistaNuevoContrato.js');?>

		<script type="text/javascript">
			app.vistaNuevoContrato = new app.VistaNuevoContrato();
		</script>
	<?=script_tag('js/backbone/routers/router.js');?>
