	<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_proyectos.css'?>" type="text/css">
	<!-- plugin selectize css -->
		<link rel="stylesheet" href="<?=base_url().'js/plugin/selectize/selectize.default.css'?>">

	<style type="text/css">
		.spin{
			width: 25px;
			height: 25px;
			background-image: url(http://crmqualium.com/img/ajax-loader25x25.gif);
			background-size: 100% 100%;
		}
	</style>

	<div id="divSecciones">
		<section id="paso1" class="section_Visible"><!-- section_Oculto -->
			<div class="panel panel-default">
				<div class="panel-heading"><b>Datos de proyecto</b></div>
				<div class="panel-body">
					<form id="formNuevoProyecto">
						<div class="row">
							<div class="col-md-5">								
								<legend><h5><b>Cliente y nombre del proyecto</b></h5> </legend>
								<select id="busqueda" name="idcliente" placeholder="Buscar cliente"></select>
								<input type="text" class="form-control" placeholder="Nombre del proyecto" style="width:100%" name="nombre">						
							</div>
							<div class="col-md-7">								
								<legend> <h5><b>Establecer fecha de inicio y fecha de entrega del proyecto</h5></b></legend>
								<div class="row" style="margin-top: -8px;">
									<div class="col-md-4">
										<div style="margin: 23px 0px 21px 0px;"><b>Inicio</b></div>
										<input id="fechaInicio" class="form-control datepicker" type="text" name="fechainicio">
									</div>
									<div class="col-md-4">
										<div style="margin: 23px 0px 21px 0px;"><b>Termino</b></div>
										<input id="fechaEntrega" class="form-control datepicker" type="text" name="fechafinal">
									</div>
									<div class="col-md-4">
										<div style="margin: 23px 0px 21px 0px;"><b>Duración en días</b></div>
										<div class="row">
											<div class="col-md-6"><input type="number" id="duracion" class="form-control" min="1" style="margin:0px;"></div>
											<div class="col-md-6" style="margin: 0px 0px 21px -20px;"><h5><span class="label label-info">días habiles</span></h5></div>
										</div>
									</div>
								</div>								
							</div>
						</div>
						<br>						
						<legend> <h5><b>Seleccionar los servicios que integrarán el proyecto</b></h5> </legend>
						<div class="row">
							<div class="col-md-5">
								<div class="div_table_proyecto">
									<table id="table_servicios" class="table table-hover table_proyecto">
										<thead class="thead_proyecto">
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
							<div class="col-md-7">
								<table id="tbla_roles" class="table table-striped table-curved">
									<thead>
										<tr class="color_th">
											<th>&nbsp;&nbsp;&nbsp;</th>
											<th>Servicios seleccionados</th>
											<th>&nbsp;&nbsp;&nbsp;</th>
										</tr>
									</thead>
									<tbody id="tbody_servicios_seleccionados">
										<!-- PLANTILLA SERVICIOS SELECCIONADOS -->
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4">
												<!-- <button type="button" id="checkboxServicios" class="btn_marcarTodos">Marcar todos</button> -->
												<div class="btn-group" data-toggle="buttons">
													<label class="btn btn-default btn-xs">
														<input type="checkbox" id="checkboxServicios" class="btn_marcarTodos"> Marcar todos
													</label>
												</div>
												<button type="button" class="btn btn-danger btn-xs checkboxServicios btn_eliminarMarcados">Eliminar marcados</button>
											</td>
										</tr>
									</tfoot>		
								</table>
							</div>
						</div> <!-- Fin class row -->
						<div class="row">
							<div class="col-md-12">
								<textarea class="form-control" rows="4" placeholder="Descripción del proyecto" name="descripcion" style="width: 100% !important;"></textarea>
							</div>
						</div>						
					</form>
				</div>
			</div>
		</section>
		<section id="paso2" class="section_Visible">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Roles del proyecto</b></div>
				<div class="panel-body">
					<legend><h5><b>Establecer participantes en el proyecto con sus respectivos roles</b></h5></legend>							
					<div class="row">
						<div class="col-md-5">
							<div class="div_table_proyecto">
								<table id="table_empleados" class="table table-hover table_proyecto">
									<thead class="thead_proyecto">
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
						<div class="col-md-7">
							<table id="tbla_roles" class="table table-striped table-curved">
								<thead>
									<tr class="color_th">
										<th>&nbsp;&nbsp;&nbsp;</th>
										<th style="width: 200px;">Empleados</th>
										<th style="width: 400px;">Roles (<small>Establesca un responsable para el nuevo proyecto</small>)</th>
										<th></th>
									</tr>
								</thead>
								<tbody id="tbody_empleados_seleccionados">
									<!-- PLANTILLA EMPLEADOS SELECCIONADOS -->
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4">
											<button id="checkboxEmpleados" class="btn_marcarTodos"></button>
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default btn-xs">
													<input type="checkbox" id="checkboxEmpleados" class="btn_marcarTodos"> Marcar todos
												</label>
											</div>
											<button type="button" class="btn btn-danger btn-xs checkboxEmpleados btn_eliminarMarcados">Eliminar marcados</button>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="paso3" class="section_Visible">
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
					<label class="btn btn-success fileinput-button">
						<span class="icon-paperclip"></span>
						<span>Adjuntar archivos</span>
						<input type="file" id="inputArchivos" multiple name="archivo[]">
					</label>
					<button type="submit" id="btn_subirArchivo" class="btn btn-primary start" style="display:none;">
						<i class="glyphicon glyphicon-upload"></i>
						<span>Subir</span>
					</button>
					<button type="reset" id="btn_cancelarArchivo" class="btn btn-warning cancel">
						<i class="glyphicon glyphicon-ban-circle"></i>
						<span>Borrar lista</span>
					</button>
					<form id="form_subirArchivos">
						<input type="hidden" id="idpropietario" name="idpropietario">
						<input type="hidden" id="tabla" name="tabla" value="proyectos">
						<input type="hidden" id="fecha_creacion" name="fecha_creacion">
					</form>
					<br>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Archivos a subir</th>
								<th>Tipo</th>
								<th>Tanaño</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="tbody_archivos">
						</tbody>
					</table>
				</div>
			</div>
		</section>
		<button type="button" id="btn_guardarProyecto" class="btn btn-primary">Guardar</button>
		<button type="button" id="btn_cancelarProyecto" class="btn btn-default">Cancelar</button>
	</div>
</div> <!-- LA APERTURA DE ESTA ETIQUETA ESTÁ EN OTRO DOCUMENTO. NO BORRAR!! -->


<!-- plantillas -->
	<script type="text/template" id="tds_servicio">
		<td style="padding:0px">
			<label class="label_servicio" for="servicio_<%= id %>"><%= nombre %></label>
			<div class="check_posicion"><!---->
				<input type="checkbox" id="servicio_<%= id %>" class="checkbox_servicio">
			<div>
		</td>
	</script>

	<script type="text/template" id="tds_servicio_seleccionado">
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
		<td>
			<input type="checkbox" class="checkbox_empleados" name="checkboxEmpleados">
		</td>
		<td>
			<%= nombre %>
		</td>
		<td class="td_roles">
				<div>
					<div class="row">
						<div class="col-md-6">
							<select class="form-control input-sm select_rol" style="width:auto;margin:0;">
								<option selected disabled>Seleccione un rol...</option>
								<!-- PLANTILLA DE ROL -->
							</select>
						</div>
						<div class="col-md-6">
							<div class="input-group input-group-sm" style="width:auto;">
								<input type="text" id="" class="form-control text_nuevoRol" placeholder="Nuevo Rol">
								<span class="input-group-btn">
									<button type="button" id="" class="btn btn-default btn_nuevoRol">Agregar</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<form class="form_participante">
					<input type="hidden" name="idproyecto" value="">
					<input type="hidden" name="idpersonal" value="<%= id %>">
				</form>
		</td>
		<td class="icon-eliminar">
			<label id="empleado_<%= id %>" class="icon-circledelete eliminarDeTabla_empleados" data-toggle="tooltip" data-placement="top" title="Eliminar"></label>
		</td>
	</script>

	<script type="text/template" id="option_rol">
		<%= nombre %>
	</script>

	<script type="text/template" id="input_rol">
		<div class="tag_rol">
			<div class="btn-group btn-group-xs">
				<button class="btn btn-default btn_eliminarRol" value="<%= id %>">
					<span class="icon-circledelete"></span>
				</button>
				<button type="button" class="btn btn-default" disabled="disabled">
					<%= nombre %>
				</button>
			</div>
			<input type="hidden" class="rol" name="<%= name %>" value="<%= id %>">
		</div>
	</script>

	<script type="text/template" id="tr_archivo">
		<tr class="<%= i %>">
			<td><%= nombre %></td>
			<td><%= tipo %></td>
			<td><%= tamaño %></td>
			<td class="icon-eliminar">
				<label id="<%= i %>" class="icon-circledelete eliminarArchivo"></label>
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
<!-- Utilerias -->
	<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
	<!-- plugin jquery -->
		<!-- <script type="text/javascript" src="js/plugin/jquery.easing.min.js"></script> -->
		<script src="<?=base_url().'js/plugin/selectize/selectize.min.js'?>"></script>
<!-- Librerias Backbone -->
	<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>"></script>

<!-- MV* -->
	<!-- modelos -->
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloCliente.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicio.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicioProyecto.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloRol.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloProyecto.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloEmpleado.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloRolProyecto.js'?>"></script>
	<!-- colecciones -->
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionClientes.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServicios.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionRoles.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionProyectos.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServiciosProyecto.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionEmpleados.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionRolesProyectos.js'?>"></script>
		<script type="text/javascript">
			app.coleccionProyectos = new ColeccionProyectos();
			app.coleccionServiciosProyecto = new ColeccionServiciosProyecto();
			app.coleccionRolesProyectos = new ColeccionRolesProyectos();
		</script>
	<!-- vistas -->
		<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaRol.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaEmpleado.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaServicio.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaNuevoProyecto.js'?>"></script>

	<script type="text/javascript">
		
	</script>
