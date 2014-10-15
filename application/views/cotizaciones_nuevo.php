<?=script_tag('js/autocompletes.js')?>
<?=script_tag('js/jquery-ui-1.10.4.custom.js');?>
<section class="contenedor_principal_modulos"> 
	<h3>Información Básica</h3>
	<hr>
	<div class="row">
		<div class="col-md-4"><form id="registroCotizacion">
			<input id="titulo"        type="text"   value="" class="form-control input_datos" placeholder="Titulo de Cotización">
			<input id="cliente" 	  type="search" value="" class="form-control input_datos" placeholder="Buscar cliente"><span id="busqueda_icono" class="icon-search"></span>
			<input id="representante" type="text"   value="" class="form-control input_datos" placeholder="Representante" disabled="true">	
			
				<input type="hidden" id="htitulo"    name="titulo"  class="input_datos"  value="">			
				<input type="hidden" id="idcliente"  name="idcliente" class="input_datos" value="">
				<input type="hidden" id="idrepresentante" class="input_datos" name="idrepresentante" value="">
				<input id="fecha"   type="text" name="fecha" class="form-control input_datos" val="" disabled="true" >	
		</div>
		<div class="col-md-4">
			<textarea id="detalles" name="detalles" class="form-control input_datos" placeholder="Detalles" style="height: 180px;"></textarea>
		</div>
		<div class="col-md-4">
			<textarea id="caracteristicas" name="caracteristicas" class="form-control input_datos"  placeholder="Caracteristicas" style="height: 180px;"></textarea>
		</div>
		</form>
	</div>
    <div class="desborde"></div>			
	<h3>Inversión & Tiempo</h3>
	<hr>		
	<div class="row">
		<div class="col-md-4">
			<!-- <input type="text" id="bserv" style = "width : 100%; height:35px;" class="valor" val="" placeholder="Buscar Servicios"> -->
			<!-- <div class="panel panel-primary" style="margin-top: 20px">
		      <div class="panel-heading">
		        <h3 class="panel-title">Seleccionar servicios</h3>
		      </div>
		      <div class="panel-body" style="overflow: auto; height: 216px; padding: 0px !important;">
		        <table id="listaServicios" class="table table-hover">
		        	<tbody >	
			    		
					</tbody>
		        </table>	
		      </div>
		    </div>	 -->
			<div class="div_table_overflow">
				<table id="table_servicios" class="table table-hover"><!-- table_proyecto -->
					<thead class="thead_overflow">
						<tr>
							<th class="sorter-false">
								<input class="form-control input-sm search-services" type="search" data-column="all" placeholder="Servicios">
							</th>
						</tr>
					</thead>
					<tbody id="tbody_servicios">
						<!-- PLANTILLAS DE SERVICIOS -->
					</tbody>
			  	</table>
			</div>
		</div>
		<div class="col-md-8" id="div_cotizando">
			<table class="table"> <!-- id="mostrarTabla" -->
				<thead style="background : #F9F9F9;">
					<tr>
						<th><input id="todos" type="checkbox"></th>
						<th style="min-width:170px;">Servicios a cotizar</th>
						<th style="min-width:170px;"><textarea class="form-control" rows="1" style="min-width:150px; visibility:hidden;" disabled></textarea></th>
						<th><input type="text" class="form-control input-sm" style="visibility:hidden;" disabled></th>
						<th><input type="text" class="form-control input-sm" style="visibility:hidden;" disabled></th>
						<th>Importe</th>
						<th class="iconos-operaciones">
							<!-- <span class=" icon-scaleup span_toggleAllSee" title="Abrir/Cerrar seleccionados"></span> -->
							<span class="icon-uniF4E5 span_toggleAllSee" title="Abrir/Cerrar seleccionados"></span>
							<span class="icon-circledelete span_deleteAll" title="Eliminar seleccionados"></span>
						</th>
					</tr>
				</thead>
				<tbody id="tbody_servicios_seleccionados">
					<!-- PLANTILLAS DE SERVICIOS COTIZADOS -->
				</tbody>
					<!-- <tr class="info"> 
						<td></td> 
						<td colspan="5">Total</td> 
						<td><p id="total">0.00</p></td>
						<td></td>
					</tr> -->			
				<tfoot style="background : #F9F9F9;">
					<!-- <tr>
						<th colspan="7">
						</th>
					</tr> -->
					<tr>
						<th></th>
						<th></th>
						<th style="text-align: right;">Total horas</th>
						<th><input type="text" class="form-control input-sm" id="totalHoras" value="0" disabled></th>
						<th></th>
						<th></th>
						<th class="iconos-operaciones">
							<!-- <span class=" icon-scaleup span_toggleAllSee" title="Abrir/Cerrar seleccionados"></span> -->
							<span class="icon-uniF4E5 span_toggleAllSee" title="Abrir/Cerrar seleccionados"></span>
							<span class="icon-circledelete span_deleteAll" title="Eliminar seleccionados"></span>
						</th>
					</tr>
					<tr>
						<th></th>
						<th style="text-align: right;">Precio/Hora</th>
						<th>
							<input type="number" class="form-control input-sm" id="precio_hora" value="300" min="1">
						</th>
						<th></th>
						<th> Subtotal </th>
						<th>
							<label id="label_subtotal">$0</label>
							<input type="text" class="form-control input-sm input-tfoot" id="subtotal" style="display:none;" value="0">
						</th>
						<th> </th>
					</tr>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th> Descuento </th>
						<th style="position: relative;">
							<input type="number" name="descuento" class="form-control input-sm input-tfoot" value="0">
							<span class="icon-percent" style="position: absolute; top: 18px; left: 40px; font-size:10px;"></span>
						</th>
						<th>
						</th>
					</tr>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th> I.V.A. </th>
						<th style="position: relative;">
							<input type="number" class="form-control input-sm input-tfoot" value="16" disabled>
							<span class="icon-percent" style="position: absolute; top: 18px; left: 40px; font-size:10px;"></span>
						</th>
						<th>
						</th>
					</tr>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th> Total </th>
						<th>
							<label id="label_total">$0</label>
						</th>
						<th>
						</th>
					</tr>
					<!-- <tr>
					    <td><button id="delete"  type="button" class="btn btn-danger">Eliminar varios 			</button>
					    <td>
						    <button id="vistaPrevia"    type="button" class="btn btn-primary"> 
						    	<span class="icon-preview"></span> Vista previa 
						    </button>
						</td>		
					</tr> -->
				</tfoot>
			</table>
		</div>
	</div>		
	<div class="desborde"></div><br><br> 
	<button id="guardar"   type="button" class="btn btn-default"> Guardar  </button>		    
	<button id="cancelar"  type="button" class="btn btn-default"> Cancelar </button>		
	<!-- </div>	 -->
    </section>

<?=script_tag('js/validaciones.js').script_tag('js/backbone/app.js');?>

<!-- <script type = "text/plantilla" id="plantilla_Cotizacion"></script> -->

<!-- plantillas -->
	<script type = "text/plantilla" id="PCservicios">
		<td   class="icon-operaciones">
			<span id="infoSC" class="icon-info" ></span>

			<label id="input_td" for="<%- id %>"><%- nombre %></label>
			<ul class="ocultoI">		
				<li> Concepto    : &nbsp;&nbsp; <%- concepto    %>  </li>   
				<li> Precio      : &nbsp;&nbsp; <%- precio      %>  </li>    
				<li> +Iva        : &nbsp;&nbsp; <%- masiva      %>  </li>   
				<li> Realización : &nbsp;&nbsp; <%- realizacion %>  </li>
			</ul>
	        <input type="checkbox" class="serviciosCotizar" id="<%- id %>">  	  
		</td>
	</script>
	<script type = "text/plantilla" id="serviciosAgregado">	

			<td><input type="checkbox" id="<%- id %>" name="todos"></td><td><%-nombre %></td>
			<td><input type="text" id="duracion"  name="duracion"  value="<%-realizacion%>"  class="valor">   </td>
			<td><input type="text" id="cantidad"  name="cantidad"  value="1"				 class="valor">   </td>
			<td><input type="text" id="precio"    name="precio"    value="<%-precio     %>"  class="valor">   </td>
			<td><input type="text" id="descuento" name="descuento" value="0" 				 class="valor">   </td>		
			<td><input 			   id="importe"   name="importes" 						     class="importe">
			<form class="filas">
				  <input type="hidden"   				 name="id" 		  value="<%-id%>"		   >
			      <input type="hidden"  id="hduracion"   name="duracion"  value="<%-realizacion%>" >
			      <input type="hidden"  id="hcantidad"   name="cantidad"  value="1"                > 
			      <input type="hidden"  id="hprecio"     name="precio" 	  value="<%-precio     %>" >
			      <input type="hidden"  id="hdescuento"  name="descuento" value="0"                >
			</form>
			</td>

			<td class="iconos-operaciones">			
				<span class="icon-circledelete btndelete"  data-toggle="tooltip" title="Eliminar" id="<%- id %>" style="vertical-align: middle;"></span>
			</td>	
	</script>
	<script type="text/template" id="tds_servicio">
		<td style="padding:0px">
			<label class="label_servicio" for="servicio_<%= id %>"><%= nombre %></label>
			<div class="check_posicion"><!---->
				<input type="checkbox" id="servicio_<%= id %>" class="checkbox_servicio">
			<div>
		</td>
	</script>
	<!--<script type="text/template">
		<tr>
			<td>
				<input type="checkbox" class="checkbox_servicios" name="checkboxServicios"></td>
			<td>
				<%= nombre %>
				<input type="hidden" name="servicios" value="<%= id %>">
			</td>
			<td class="icon-eliminar">
				<label id="servicio_<%= id %>" class="icon-circledelete eliminarDeTabla_servicios" title="Eliminar"></label>
			</td>
		</tr>
	</script>-->
	<script type="text/template" id="tds_servicio_seleccionado">
		<td class="td_servicio" colspan="7" style="padding:0px;">
				<table id="table_servicio_<%= id %>" class="table" style="margin-bottom:0px;">
					<thead>
						<tr class="active">
							<td>
								<input type="checkbox" class="todos" name="todos" value="servicio_<%= id %>/toggleSee_<%= id %>">
							</td>
							<td style="min-width:150px;"><%= nombre %></td>
							<td>
								<textarea class="form-control" rows="1" style="min-width:150px; visibility: hidden;" disabled></textarea>
							</td>
							<td>
								<input type="text" class="form-control input-sm" style="visibility: hidden;" disabled>
							</td>
							<td>
								<input type="text" class="form-control input-sm" style="visibility: hidden;" disabled>
							</td>
							<td>
								<input type="text" class="form-control input-sm importe" name="importes" disabled>
							</td>
							<td class="iconos-operaciones">
								<span class="icon-circleup icon-circledown span_toggleSee" id="toggleSee_<%= id %>"></span>
								<span class="icon-circledelete span_eliminar_servicio" id="servicio_<%= id %>"></span>
							</td>
						</tr>
						<tr id="tr_titulos_secciones">
							<td></td>
							<td>Sección</td>
							<td>Observaciones</td>
							<td>Horas</td>
							<td></td>
							<td>Costo</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<!-- tr secciones - #tr_seccion-->
					</tbody>
					<tfoot>
						<tr>
							<td style="border:0px;padding:0px 8px 8px 0px;"></td>
							<td style="border:0px;padding:0px 8px 8px 0px;" class="iconos-operaciones" colspan="6"><span id="span_otraSeccion" class="icon-circleadd"></span></td>
						</tr>
					</tfoot>
				</table>
		</td>
	</script>
	<script type="text/template" id="td_seccion">
		<td style="border:0px;">
			<form class="form_servicio">
				<input type="hidden" name="idServicio" value="<%= id %>">
				<input type="hidden" name="seccion">
				<input type="hidden" name="descripcion">
				<input type="hidden" name="horas" 		value="1">
				<input type="hidden" name="precio_hora">
			</form>
		</td>
		<td><input type="text" 		id="seccion"		class="form-control input-sm" 			 	style="min-width:150px;"></td>
		<td><textarea 				id="descripcion"	class="form-control" rows="3" 			 	style="min-width:150px;"></textarea></td>
		<td><input type="number" 	id=""				class="form-control input-sm number horas" 	 	min="1" value="1"></td>
		<td><input type="number" 	id=""				class="form-control input-sm number precio_hora" style="visibility:hidden;"	 	min="1"></td>
		<td>
			<input type="text" 							class="form-control input-sm costoSeccion"	disabled>
		</td>
		<td class="iconos-operaciones" style="border:0px;">
			<span class="icon-circledelete span_eliminar_seccion"></span>
		</td>
	</script>

<!-- Librerias -->
<?=script_tag('js/backbone.localStorage.js');?>

<script type="text/javascript">
	var app = app || {};
	app.coleccionDeServicios      	  = <?php echo json_encode($servicios)      	?>;
	app.coleccionDeClientes       	  = <?php echo json_encode($clientes)       	?>;
	app.coleccionDeRepresentantes 	  = <?php echo json_encode($representantes) 	?>;
</script>
<?=
	script_tag('js/funcionescrm.js').
	// <!-- MVC -->
	script_tag('js/backbone/modelos/ModeloServicio.js').
	script_tag('js/backbone/modelos/ModeloCotizacion.js').
	script_tag('js/backbone/modelos/ModeloServicioCotizado.js').
	script_tag('js/backbone/modelos/ModeloCliente.js').
	script_tag('js/backbone/modelos/ModeloRepresentante.js').
	script_tag('js/backbone/modelos/ModeloLocalCotizacion.js').

	script_tag('js/backbone/colecciones/ColeccionServicios.js').
	script_tag('js/backbone/colecciones/ColeccionCotizaciones.js').
	script_tag('js/backbone/colecciones/ColeccionServiciosCotizados.js').
	script_tag('js/backbone/colecciones/ColeccionClientes.js').
	script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
	script_tag('js/backbone/colecciones/ColeccionLocalCotizaciones.js').

	script_tag('js/backbone/vistas/VistaServicio.js').
	script_tag('js/backbone/vistas/VistaNuevaCotizacion.js');
?>