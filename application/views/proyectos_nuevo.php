		<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_proyectos.css'?>" type="text/css">

		<style type="text/css">
			.spin{
				width: 25px;
				height: 25px;
				background-image: url(http://crmqualium.com/img/ajax-loader25x25.gif);
				background-size: 100% 100%;
			}
		</style>
	<seccion id="contenedor_principal_modulos">
		<div class="container">
			<br>
			<section id="paso1" class="section_Visible">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Datos básicos</b></div>
					<div class="panel-body">
						<form id="formDatosBasicos">
							<input type="hidden" id="hidden-idcontrato" name="idcontrato" value="">
							<div class="row">
								<div class="col-md-4">
									<legend><h5><b>Cliente y nombre del proyecto</b></h5></legend>
									<div class="form-group">
										<label for="busqueda">Cliente</label>
										<select id="busqueda" name="idcliente" placeholder="Buscar cliente..."></select>
									</div>
									<div class="form-group">
										<label for="nombreproyecto">Nombre del proyecto o contrato origen</label>
										<select id="nombreproyecto" name="nombre" placeholder="Nombre del proyecto o contrato origen"></select>
									</div>
									<div class="form-group">
										<label for="">Tipo de plan</label>
										<div class="btn-group input-group" data-toggle="buttons">
											<label class="btn btn-default">
												<input type="radio" class="btn_plan" name="plan" id="porEvento" value="evento" autocomplete="off"> Por Evento
											</label>
											<label class="btn btn-default">
												<input type="radio" class="btn_plan" name="plan" id="iguala" value="iguala" autocomplete="off"> Iguala Mensual
											</label>
										</div>
									</div>
								</div>
								<div class="col-md-8">
									<legend> <h5><b>Establecer fecha de inicio y fecha final del proyecto</h5></b></legend>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="fechaInicio">Inicio</label>
												<input id="fechaInicio" class="form-control datepicker" type="text">
												<input type="hidden" name="fechainicio">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="fechaEntrega">Fin</label>
												<input id="fechaEntrega" class="form-control datepicker" type="text">
												<input type="hidden" name="fechafinal">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="duracion">Duración <small><label class="label label-info">días habiles</label></small></label>
												<input type="number" id="duracion" class="form-control" min="1">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<p class="text-info"><b>Nota.</b> Si establece la fecha de inicio y la fecha final, se calculará la duración del proyecto sin tomar en cuenta fines de semana. Si establece la duración, automaticamente se determinará la fecha final diferente de sábado o domingo, a partir del día actual.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="descripcion">Descripción general</label>
								<textarea id="descripcion" class="form-control" rows="4" placeholder="Descripción general" name="descripcion" style="width: 100% !important;"></textarea>
							</div>
						</form>
					</div><!-- /.panel-body -->
				</div><!-- /.panel panel-default -->
			</section>
			<section id="paso2" class="section_Visible">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Servicios de proyecto</b></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<legend><h5><b>Seleccionar los servicios que integrarán el proyecto</b></h5></legend>
							</div>	
							<div class="col-md-4">
								<div class="div_table_overflow">
									<table id="table_servicios" class="table table-hover"><!-- table_proyecto -->
										<thead class="thead_overflow">
											<tr>
												<th class="sorter-false">
													<input class="form-control input-sm search-services" type="search" data-column="all" placeholder="Servicios">
													<div id="alert_anadirNuevioServicio" class="alert alert-info" role="alert">Enter para añadir...</div>
												</th>
											</tr>
										</thead>
										<tbody id="tbody_servicios">
											<!-- PLANTILLAS DE SERVICIOS -->
										</tbody>
									</table>
								</div>
							</div>	
							<div class="col-md-8">
								<table class="table">
									<thead style="background : #F9F9F9;">
										<tr>
											<th colspan="6" style="min-width:200px;"><label><input class="todos" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Servicios</label></th>
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
									<thead style="background : #F9F9F9;">
										<tr>
											<td colspan="" style="min-width:200px;"><label><input class="todos" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Servicios</label></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td class="iconos-operaciones">
												<!-- <span class=" icon-scaleup span_toggleAllSee" title="Abrir/Cerrar seleccionados"></span> -->
												<span class="icon-uniF4E5 span_toggleAllSee" title="Abrir/Cerrar seleccionados"></span>
												<span class="icon-circledelete span_deleteAll" title="Eliminar seleccionados"></span>
											</td>
										</tr>
									</thead>
									<thead class="thead_evento thead_visible thead_oculto">
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>
												<div class="row">
													<div class="col-xs-4 col-xs-offset-4">
														Total horas
													</div>
													<div class="col-xs-4">
														<input type="text" class="form-control input-sm" id="totalHoras" value="0" disabled>
													</div>
												</div>
											</td>
											<td></td>
										</tr>
									</thead>
									<thead class="thead_iguala thead_visible thead_oculto">
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div><!-- /.panel-body -->
				</div><!-- /.panel panel-default -->
			</section>
			<section id="paso3" class="section_Visible">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Roles del proyecto</b></div>
					<div class="panel-body">
						<legend><h5><b>Establecer participantes en el proyecto con sus respectivos roles</b></h5></legend>							
						<div class="row">
							<div class="col-md-4">
								<div class="div_table_overflow">
									<table id="table_empleados" class="table table-hover table_overflow">
										<thead class="thead_overflow">
											<tr>
												<th class="sorter-false">
													<input class="form-control input-sm search-employees" type="search" data-column="all" placeholder="Empleados">
												</th>
											</tr>
										</thead>
										<tbody id="tbody_empleados">
											<!-- PLANTILLAS DE SERVICIOS -->
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-md-8">
								<table id="tbla_roles" class="table table-striped table-curved">
									<thead style="background : #F9F9F9;">
										<tr>
											<th colspan="2" style="min-width:200px;"><label><input class="todos" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Empleados</label></th>
											<th>Roles <small><label class="label label-info">Establesca un responsable para el nuevo proyecto</label></small></th>
											<th class="icon-eliminar">
												<span class="icon-circledelete eliminarVarios"></span>
											</th>
										</tr>
									</thead>
									<tbody id="tbody_empleados_seleccionados">
										<!-- PLANTILLA EMPLEADOS SELECCIONADOS -->
									</tbody>
									<tfoot style="background : #F9F9F9;">
										<tr>
											<th colspan="3" style="min-width:200px;"><label><input class="todos" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Empleados</label></th>
											<th class="icon-eliminar">
												<span class="icon-circledelete eliminarVarios"></span>
											</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section id="paso4" class="section_Visible">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Archivos del proyecto</b></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<fieldset>
									<legend><h5>Adjunta los archivos para el proyecto. No seleccione carpetas.(Los archivos deben estár en la misma carpeta) </h5></legend>
								</fieldset>
							</div>
						</div>
						<label class="btn btn-default input-sm fileinput-button">
							<i class="glyphicon icon-paperclip"></i>
							<span>Abrir</span>
							<input type="file" id="inputArchivos" multiple name="archivo[]">
						</label>
						<button type="submit" id="btn_subirArchivo" class="btn btn-default input-sm start" style="display:none;">
							<i class="glyphicon glyphicon-upload"></i>
							<span>Subir</span>
						</button>
						<button type="reset" id="btn_cancelarArchivo" class="btn btn-default input-sm cancel">
							<i class="glyphicon glyphicon-ban-circle"></i>
							<span>Borrar lista</span>
						</button>
						<br><br>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Tipo</th>
									<th>Tamaño</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="tbody_archivos">
							</tbody>
						</table>
					</div>
				</div>
			</section>
			<div><!--  class="botones-finales-fixed" -->
				<button type="button" id="btn_guardarProyecto" class="btn btn-primary">Guardar</button>
				<button type="button" id="btn_cancelarProyecto" class="btn btn-default">Cancelar</button>	
			</div>
		</div>
	</section><!-- /#contenedor_principal_modulos -->
</div> <!-- /.contenedor_modulo -->


<!-- plantillas -->
	<script type="text/template" id="tds_servicio">
		<td style="padding:0px">
			<%if(typeof eliminar != 'undefined'){%>
				<label class="label_servicio" for="servicio_<%= id %>">
					<%= nombre %>
					<span class="icon-circledelete span_eliminarNuevo"></span>
				</label>
			<%} else{%>
				<label class="label_servicio" for="servicio_<%= id %>">
					<%= nombre %>
					<!--<span class="icon-circledelete span_eliminarNuevo"></span>-->
				</label>
			<%};%>
			<div class="check_posicion">
				<input type="checkbox" id="servicio_<%= id %>" class="checkbox_servicio">
			</div>
		</td>
	</script>
	<script type="text/template" id="tds_servicio_seleccionado">
		<td class="td_servicio" colspan="7" style="padding:0px;">
			<table id="table_servicio_<%= id %>" class="table" style="margin-bottom:0px;">
				<thead>
					<tr class="info">
						<td>
							<input type="checkbox" name="todos" id="servicio_<%= id %>/toggleSee_<%= id %>">
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
							<input type="text" class="form-control input-sm" style="visibility: hidden;" disabled>
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
						<td></td>
						<td></td>
						<td>Horas</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<!-- tr secciones - #tr_seccion-->
				</tbody>
				<tfoot>
					<tr>
						<td style="border:0px;"></td>
						<td colspan="6" style="border:0px;"><button type="button" id="span_otraSeccion" class="btn btn-default btn-xs"><span class="icon-circleadd"></span> sección</button></td>
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
				<input type="hidden" name="horas"       value="1">
				<!--<input type="hidden" name="precio_hora">-->
			</form>
		</td>
		<td><input type="text"      id="seccion"        class="form-control input-sm"               style="min-width:150px;">                   </td>
		<td colspan="3"><textarea   id="descripcion"    class="form-control" rows="3"               style="min-width:150px;"></textarea>        </td>
		<td><input type="number"    class="form-control input-sm number horas" min="1" value="1"> </td>
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
		<td colspan="3"><textarea 				id="descripcion"	class="form-control" rows="3" 			 			style="min-width:150px;"><%= descripcion %></textarea>			</td>
		<td><input type="number" 	class="form-control input-sm number horas" min="1" value="<%= horas %>"> </td>
		<td class="iconos-operaciones" style="border:0px;">
			<span class="icon-circledelete span_eliminar_seccion"></span>
		</td>
	</script>

	<script type="text/template" id="tds_empleado">
		<td style="padding:0px">
			<label class="label_empleado" for="empleado_<%= id %>"><%= nombre %></label>
			<div class="check_posicion"><!---->
				<input type="checkbox" id="empleado_<%= id %>" class="checkbox_empleado">
			<div>
		</td>
	</script>
	<script type="text/template" id="tds_empleado_seleccionado">
		<td colspan="2">
			<input type="checkbox" name="todos" id="empleado_<%= id %>/toggleSee_<%= id %>">&nbsp;&nbsp;&nbsp;&nbsp;<%= nombre %>
		</td>
		<td class="td_roles">
				<form class="form_participante">
					<select class="select_rol" name="idrol" style="width:auto;margin:0;" placeholder="Seleccione un rol..." multiple>
						<!-- PLANTILLA DE ROL -->
					</select>
					<input type="hidden" name="idpersonal" value="<%= id %>">
				</form>
		</td>
		<td class="icon-eliminar">
			<label id="empleado_<%=id%>" class="icon-circledelete eliminarParticipacion" data-toggle="tooltip" data-placement="top" title="Eliminar"></label>
		</td>
	</script>
	<script type="text/template" id="option_rol">
		<%= nombre %>
	</script>

	<script type="text/template" id="tr_archivo">
		<tr class="<%= i %>">
			<td><%= nombre %></td>
			<td><%= tipo %></td>
			<td><%= tamaño %></td>
			<td class="icon-eliminar">
				<!-- <span id="<%= i %>" class="icon-circledelete span_eliminarArchivo"></span> -->
			</td>
		</tr>
	</script>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDeClientes  = <?php echo json_encode($clientes)?>;
	app.coleccionDeServicios = <?php echo json_encode($servicios)?>;
	app.coleccionDeEmpleados = <?php echo json_encode($empleados)?>;
	app.coleccionDeRoles 	 = <?php echo json_encode($roles)?>;
</script>

<!-- MV* -->
<?= 
	script_tag('js/backbone/lib/backbone.localStorage.js').
	//  modelos
	script_tag('js/backbone/modelos/ModeloCliente.js').
	script_tag('js/backbone/modelos/ModeloServicio.js').
	script_tag('js/backbone/modelos/ModeloServicioProyecto.js').
	// script_tag('js/backbone/modelos/ModeloRol.js').
	script_tag('js/backbone/modelos/ModeloEmpleado.js').
	script_tag('js/backbone/modelos/ModeloRolProyecto.js').
	// colecciones
	script_tag('js/backbone/colecciones/ColeccionClientes.js').
	script_tag('js/backbone/colecciones/ColeccionServicios.js').
	script_tag('js/backbone/colecciones/ColeccionRoles.js').
	script_tag('js/backbone/colecciones/ColeccionProyectos.js').
	script_tag('js/backbone/colecciones/ColeccionServiciosProyecto.js').
	script_tag('js/backbone/colecciones/ColeccionEmpleados.js').
	script_tag('js/backbone/colecciones/ColeccionRolesProyectos.js').
	script_tag('js/backbone/colecciones/ColeccionContratos.js').
	script_tag('js/backbone/colecciones/ColeccionArchivos.js').
	// vistas 
	script_tag('js/backbone/vistas/VistaRol.js').
	script_tag('js/backbone/vistas/VistaEmpleado.js').
	script_tag('js/backbone/vistas/VistaServicio.js').
	script_tag('js/backbone/vistas/VistaNuevaCotizacion.js').
	script_tag('js/backbone/vistas/vistaArchivos.js').
	// script_tag('js/backbone/vistas/VistaConsultaCotizaciones.js').
	script_tag('js/backbone/vistas/VistaNuevoProyecto.js');
?>

	<script type="text/javascript">
		app.coleccionServiciosContrato 	= new ColeccionServiciosContrato();
		app.coleccionContratos 			= new ColeccionContratos();
		app.coleccionContratos.fetch();
		app.coleccionServiciosContrato.fetch();
		app.coleccionProyectos 			= new ColeccionProyectos();
		app.coleccionArchivos 			= new ColeccionArchivos();
		app.coleccionServiciosProyecto 	= new ColeccionServiciosProyecto();
		app.coleccionRolesProyectos 	= new ColeccionRolesProyectos();
	</script>

	<script type="text/javascript">
		var vistaArchivos = new app.VArchivos();
		app.vistaNuevoProyecto = new app.VistaNuevoProyecto();
		vistaTablaRoles = new app.VistaTablaRoles();
	</script>
