		<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_contratos.css'?>" type="text/css">
		<!-- scrpit de prueba para la fecha y efecto de toggle para mostrar detalles del servicio -->
		<script>
		 //  $(function() {
		 //    $( ".datepicker" ).datepicker({
		 //      changeMonth: true,
		 //      changeYear: true
		 //    });
		 //  });

			// $(document).ready(function(){
			//   $(".icon_detalles").click(function(){
			//     $("#div_info").slideToggle();
			//   });
			// });		

			// $(document).ready(function() {
			//     $("input[name$='options']").click(function() {
			//         var test = $(this).val();

			//         $("div.desc").hide();
			//         $("#Cars" + test).show();
			//     });
			// 	var cont= 1;

			// 	$('.btn-primary').on('change',function (){

			// 		if ( cont==1 ){}


			// 		// console.log($(this).html());
			// 		$('.tabla_visible').toggleClass('tabla_oculto');
			// 	});
			// });		
		</script>
		<section>
			<form id="formulario">
				<div class="row" >
					<div class="col-md-6">
						<h3>Datos basicos</h3>					
						<hr>
						<div>						  
							<input type="text" id="busqueda" class="form-control input_largo" placeholder="Buscar cliente">
							<input type="hidden" id="hidden_idCliente" name="idcliente">
							<span id="span_buscar" class="icon-search"></span>			
							<input type="text" id="input_Representante" class="form-control input_largo" disabled placeholder="Representante">
							<input type="hidden" id="hidden_idRepresentante" name="idrepresentante">
							<input type="text" id="fechaFirma" class="form-control datepicker input_largo" placeholder="Fecha en que se firmará el contrato">
							<input type="hidden" id="hidden_fechafirma" name="fechafirma">
					    </div>
						
						
						<h5 style="display: inline-block"><b>Eliga Tipo de plan:</b></h5>
						<div id="planes" class="btn-group" data-toggle="buttons">
							<label for="porEvento" class="btn btn-primary">
								<input type="radio" name="plan" id="porEvento" class="btn_plan" value="evento">Por Evento
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
				<br>        			    
			    <table id="tabla_contrato" class="table table-striped">
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
				          <td colspan="3"><b>Renta Mensual</b></td>
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
			   	<div class="desborde"></div>		 
			   	<button type="submit" id="btn_guardar" class="btn btn-default">Guardar</button>
			   	<button type="button" id="btn_vistaPrevia" class="btn btn-primary"><span class="icon-preview"></span>Vista previa</button>
			   	<button type="button" class="btn btn-default">Cancelar</button>
		   	</form>
		</section>   	 
	</section>   	                
</div>


<!-- plantillas -->
	<script type="text/template" id="plantillaServicio">
		<td style="width: 580px ">
			<span   class="icon-info icon_detalles" data-toggle="tooltip" title="Información"></span>
			<label for="servicio_<%- id %>"><%- nombre %></label>
			<div id="div_info">
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
		<td><%- nombre %><input type="hidden" name="idservicio" value="<%- id %>"></td>
		<!-- <td><input id="realizacion" class="input_precio inputsServicios" 	name="realizacion"	type="text" value="<%- realizacion %>" placeholder="Realización"></td> -->
		<td><input id="cantidad" 	class="input_precio inputsServicios" 	name="cantidad"		type="number" value="<%- cantidad %>" min="1"></td>
		<td><input id="precio" 		class="input_precio inputsServicios"	name="precio"		type="number" value="<%- precio %>"></td>
		<td><input id="descuento" 	class="input_descuento inputsServicios" name="descuento"	type="number" min="0" max="100" value="<%- descuento %>"> %</td>
		<td>$<%- total %> <input type="hidden" class="total" value="<%- total %>"></td>
		<td class="icon-eliminar">
        	<div class="eliminar_cliente">
    			<span id="<%- id %>" class="icon-circledelete eliminar"  data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
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

<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDeClientes 		= <?php echo json_encode($clientes) ?>;
	app.coleccionDeServicios 		= <?php echo json_encode($servicios) ?>;
	app.coleccionDeRepresentantes 	= <?php echo json_encode($representantes) ?>;
</script>
<!-- Utilerias -->
	<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<!-- Librerias Backbone -->
    <script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/lib/backbone.localStorage.js'?>"></script>
<!-- modelos -->
	<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloCliente.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloRepresentante.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicio.js'?>"></script>
<!-- colecciones -->
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionClientes.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionRepresentantes.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServicios.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionContratos.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServiciosContrato.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPagos.js'?>"></script>
	<script type="text/javascript">
		app.coleccionContratos = new ColeccionContratos();
		app.coleccionServiciosContrato = new ColeccionServiciosContrato();
		app.coleccionPagos = new ColeccionPagos();
	</script>
<!-- vistas -->
	<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaServicio.js'?>"></script> <!-- Heredamos la clase VistaServicio -->
	<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaNuevoContrato.js'?>"></script>