<section class="container-fluid contenedor_principal_modulos">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-10"><h3>Información Básica</h3></div>
				<div class="col-md-2"><h3 id="h4_folio"></h3></div>
			</div>
			<form id="registroCotizacion">
				
			</form>
		</div>
	</div>	
</section>
	<script type="text/template" id="tds_servicio">
		<td style="padding:0px">
			<label class="label_servicio" for="servicio_<%= id %>"><%= nombre %></label>
			<div class="check_posicion">
				<input type="checkbox" id="servicio_<%= id %>" class="checkbox_servicio">
			<div>
		</td>
	</script>
	<script type="text/template" id="plantilla-formulario">
		<div class="row">
			<div class="col-md-4">
				<input  type="text" id="titulo" class="form-control input_datos" name="titulo" placeholder="Título de la cotización">
				<select id="busqueda" name="idcliente" placeholder="Buscar cliente..."></select>
				<input  id="nombreRepresentante" type="text" class="form-control input_datos" placeholder="Representante" disabled="true">			
				<input type="hidden" id="idrepresentante" class="input_datos" name="idrepresentante">
				<input id="fecha"   type="text" name="fecha" class="form-control input_datos" disabled="true">	
			</div>
			<div class="col-md-4">
				<textarea id="detalles" name="detalles" class="form-control input_datos" placeholder="Detalles" style="height: 180px;">Un título de crédito, también llamado título valor, es aquel "documento necesario para ejercer el derecho literal y autónomo expresado en el mismo"</textarea>
			</div>
			<div class="col-md-4">
				<textarea id="caracteristicas" name="caracteristicas" class="form-control input_datos"  placeholder="Caracteristicas" style="height: 180px;">De las diversas clases de títulos de crédito ... Sección Segunda - De los títulos nominativos</textarea>
			</div>
		</div>
	    <div class="desborde"></div>
		<h3>Inversión & Tiempo</h3>
		<hr>		
		<div class="row">
			<div class="col-md-4">
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
							<th colspan="2" style="min-width:200px;"><label><input id="todos" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Servicios a cotizar</label></th>
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
					<tfoot style="background : #F9F9F9;">
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
								<input type="number" class="form-control input-sm" id="precio_hora" name="preciohora" value="300" min="1">
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
								<input type="number" name="descuento" class="form-control input-sm input-tfoot" value="0" min="0" max="100">
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
					</tfoot>
				</table>
			</div>
		</div>		
		<br><br> 
		<button id="guardar"   type="button" class="btn btn-primary"> Guardar  </button>		    
		<button id="cancelar"  type="button" class="btn btn-default"> Cancelar </button>
		<button id="vista-previa"  type="button" class="btn btn-default"> Vista previa </button>		
	</script>
	<script type="text/template" id="tds_servicio_seleccionado">
		<td class="td_servicio" colspan="7" style="padding:0px;">
				<table id="table_servicio_<%= id %>" class="table" style="margin-bottom:0px;">
					<thead>
						<tr class="info">
							<td>
								<input type="checkbox" class="todos" name="todos" id="servicio_<%= id %>/toggleSee_<%= id %>">
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
							<td style="border:0px;"></td>
							<td colspan="6" style="border:0px;"><button type="button" id="span_otraSeccion" class="btn btn-primary btn-xs"><span class="icon-circleadd"></span> sección</button></td>
						</tr>
					</tfoot>
				</table>
		</td>
	</script>
	<script type="text/template" id="td_seccion">
		<td style="border:0px;">
			<form class="form_servicio">
				<input type="hidden" name="idservicio" value="<%= id %>">
				<input type="hidden" name="seccion">
				<input type="hidden" name="descripcion">
				<input type="hidden" name="horas" 		value="1">
				<!--<input type="hidden" name="precio_hora">-->
			</form>
		</td>
		<td><input type="text" 		id="seccion"		class="form-control input-sm" 			 	style="min-width:150px;">					</td>
		<td><textarea 				id="descripcion"	class="form-control" rows="3" 			 	style="min-width:150px;"></textarea>		</td>
		<td><input type="number" 	id=""				class="form-control input-sm number horas" 	 	min="1" value="1">						</td>
		<td><input type="number" 	id=""				class="form-control input-sm number precio_hora" style="visibility:hidden;"	 	min="1"></td>
		<td><input type="text" 							class="form-control input-sm costoSeccion"	disabled>									</td>
		<td class="iconos-operaciones" style="border:0px;">
			<span class="icon-circledelete span_eliminar_seccion"></span>
		</td>
	</script>

<!-- Librerias -->
<?=
script_tag('js/backbone/app.js').
script_tag('js/backbone.localStorage.js');?>

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

<script>
	app.vistaNuevaCotizacion = new app.VistaNuevaCotizacion();
</script>