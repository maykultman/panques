
	<section class="container-fluid contenedor_principal_modulos">
		<section id="seccion_cotizaciones">
			<div id="div_fullHeight">    
		        <div id="posicion_infotd">
		    		<div id="clientes" class="wrapper"> 
					    <table id="tabla_cotizaciones" class="table table-striped tablesorter">
							<thead>
								<tr>
									<th class="sorter-false">
										<input id="todos" type="checkbox" name="todos" style="margin-left: 4px;">
									</th>
									<th class="sorter-false">
										<!-- Títulos -->
										<input type="search" class="form-control search input-sm" data-column="1" placeholder="Título">
										<span class="icon-search busqueda"></span>
									</th>
									<th class="sorter-false">
										<!-- Cliente -->
										<input type="search" class="form-control search input-sm" data-column="2" placeholder="Cliente">
									    <span class="icon-search busqueda"></span>
									</th>
									<th class="sorter-false">
										<!-- Relizado por -->
										<input type="search" class="form-control search input-sm" data-column="3" placeholder="Relizado por">
										<span class="icon-search busqueda"></span>
									</th>
									<th class="sorter-false">
										fecha
										<!-- <div id="bfecha" class="abajo" style="margin-left:5px;"><span id="fecha" class="downt"></span></div> -->
									</th>
									<th class="filter-false">Total</th>
									<th class="sorter-false">Operaciones</th>
								</tr>
							</thead>
							<tbody id="tbody_cotizaciones">
								<!-- Lista de las ultimas cotizaciones-->
							</tbody>		
						</table>
					</div>
					<button  type="button" id="btn_eliminarVarios" class="btn btn-danger">  Borrar varios </button>
					<button type="button" id="btn_restaurarVarios" class="btn btn-default">Restaurar varios</button> 
				</div>
			</div>
		</section>
	</section><!-- /.contenedor_principal_modulos -->
</div>

	<script type = "text/plantilla" id="tds_Cotizacion">
		<td><input type="checkbox" class="todos" name="todos" value="<%= id %>" />
		<td>	<%=cliente%>								</td>
		<td>	<%=titulo%>								</td>
		<td>	<%=empleado%>								</td>
		<td>	<%=formatearFechaUsuario(new Date(fecha))%>	</td>
		<td>   $<%=total%>									</td>
		<td class="icon-operaciones">
			<span class="icon-restore span_restaurar"		data-toggle="tooltip" data-placement="top" title="Restaurar"></span>
			<span class="icon-circledelete span_borrar"	data-toggle="tooltip" data-placement="top" title="Borrar permanentemente"></span>
		
		</td>
	</script>
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
	<script type="text/template" id="td_seccionReal">
		<td style="border:0px;">
			<form class="form_servicio">
				<input type="hidden" name="idservicio" value="<%= idservicio %>">
				<input type="hidden" name="seccion" value="<%= seccion %>">
				<input type="hidden" name="descripcion" value="<%= descripcion %>">
				<input type="hidden" name="horas" 		value="<%= horas %>">
				<!--<input type="hidden" name="precio_hora">-->
			</form>
		</td>
		<td><input type="text" 		id="seccion"		class="form-control input-sm" 			 			style="min-width:150px;" 			value="<%= seccion %>">		</td>
		<td><textarea 				id="descripcion"	class="form-control" rows="3" 			 			style="min-width:150px;"><%= descripcion %></textarea>			</td>
		<td><input type="number" 	class="form-control input-sm number horas" 								min="1" 							value="<%= horas %>">		</td>
		<td><input type="number" 	class="form-control input-sm number precio_hora" 						style="visibility:hidden;" min="1" 	value="<%= preciohora %>">	</td>
		<td><input type="text" 							class="form-control input-sm costoSeccion"	disabled>																</td>
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
	app.coleccionDeCotizaciones   	= <?php echo json_encode($cotizaciones)   	  ?>;
	app.coleccionDeServicios      	= <?php echo json_encode($servicios)      	  ?>;
	app.coleccionDeClientes       	= <?php echo json_encode($clientes)       	  ?>;
	app.coleccionDeRepresentantes 	= <?php echo json_encode($representantes) 	  ?>;
	app.coleccionDeEmpleados      	= <?php echo json_encode($empleados) 		  ?>;
	app.coleccionServiciosCotizados = <?php echo json_encode($serviciosCotizados) ?>;
</script>
<?=
	script_tag('js/funcionescrm.js').
	script_tag('js/backbone/modelos/ModeloServicio.js').
	script_tag('js/backbone/modelos/ModeloCotizacion.js').
	script_tag('js/backbone/modelos/ModeloCliente.js').
	script_tag('js/backbone/modelos/ModeloEmpleado.js').
	script_tag('js/backbone/modelos/ModeloRepresentante.js').
	script_tag('js/backbone/modelos/ModeloServicioCotizado.js').
	script_tag('js/backbone/modelos/ModeloLocalCotizacion.js').

	script_tag('js/backbone/colecciones/ColeccionServicios.js').
	script_tag('js/backbone/colecciones/ColeccionCotizaciones.js').
	script_tag('js/backbone/colecciones/ColeccionLocalCotizaciones.js').
	script_tag('js/backbone/colecciones/ColeccionClientes.js').
	script_tag('js/backbone/colecciones/ColeccionServiciosCotizados.js').
	script_tag('js/backbone/colecciones/ColeccionEmpleados.js').
	script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').

	script_tag('js/backbone/vistas/VistaServicio.js').
	script_tag('js/backbone/vistas/VistaNuevaCotizacion.js').
	/*script_tag('js/backbone/vistas/VistaServicioCotizacion.js').*/
	script_tag('js/backbone/vistas/VistaConsultaCotizaciones.js');
?>
<script>
	app.cotizaciones = new app.CotizacionesEliminadas();
</script>