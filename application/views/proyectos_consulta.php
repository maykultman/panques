<?php 
$activa_p = array();
function menu($arg, $perm)
{
	$resp=0;
	if(is_array($arg))	
	{		
	    foreach ($arg as $key => $value) 
	    {
	        if($value==$perm)
	        {
	            $resp = $value;
	        }
	    }
	     return $resp;
	}
}
if(isset($this->session->userdata('Proyectos')[1]['permisos']))
{    
    $activa_p[0] = menu($this->session->userdata('Proyectos')[1]['permisos'], 1);
    $activa_p[1] = menu($this->session->userdata('Proyectos')[1]['permisos'], 2);
    $activa_p[2] = menu($this->session->userdata('Proyectos')[1]['permisos'], 3);
    $activa_p[3] = menu($this->session->userdata('Proyectos')[1]['permisos'], 4);
    // var_dump($activa_p[3]); die();
}
?>	
	<section id="contenedor_principal_modulos" class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- <div id="div_fullHeight"> -->
					<div id="posicion_infotd">
						<div id="div_tabla_proyectos" class="wrapper">
							<table id="tabla_principal" class="table table-hover tablesorter">
								<thead>
									<tr>
										<th class="sorter-false"><input type="checkbox" class="todos" style="margin-left: 4px;"></th>
										<th class="sorter-false">
											<input class="form-control input-sm search" type="search" placeholder="Cliente" data-column="1">
											<span class="icon-search busqueda"></span>
											 
											<!-- Cliente -->
										</th>
										<th class="sorter-false">
											 <input class="form-control input-sm search" type="search" placeholder="Proyecto" data-column="2">                          
											 <span class="icon-search busqueda"></span>
											<!-- Proyecto -->
										</th>  
										<!-- <th><input type="text" class="form-control" placeholder="Rsponsable">
											<span class="icon-search busqueda"></span>
										</th> -->
										<th class="sorter-false">Inicio</th>
										<th class="sorter-false">Entrega</th>     
										<th class="sorter-false"> Plazo</th>         
										<th class="sorter-false">Operaciones</th>
										<th class="sorter-false"></th>
									</tr>
								</thead>      
								<tbody id="tbody_proyectos" style="line-height: 3;">
								</tbody> 
							</table>
						</div><!-- /#wrapper -->
						<button type="button" id="btn_eliminarVarios" class="btn btn-danger">Eliminar varios</button>
						<button type="button" id="btn_entregarVarios" class="btn btn-default margin-15px-top">Entregar</button>
					</div><!-- /#posicion_infotd -->
				<!-- </div>/#div_fullHeight -->
			</div>
		</div><!-- /.row -->
	</section><!-- /#contenedor_principal_modulos -->
</div><!-- /.contenedor_modulo -->


<script type="text/javascript">
	var meses = new Array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
</script>
<!-- plantillas -->
	<script type="text/template" id="plantilla_tr_proyecto">
		<td>
			<input type="checkbox" name="todos" value="<%- id %>">
		</td>
		<td><%- propietario %></td>
		<td><%- nombre %></td>                     
		<!-- <td>Responsable</td> -->
		<td >
			<%= fechaAmigable( new Date(fechaEstandar(fechainicio)) ) %>
		</td> 
		<td >
			<%= fechaAmigable( new Date(fechaEstandar(fechafinal)) ) %>
		</td> 
		<td >
			<%if (entregado == '0' || entregado == false) {%>
				<% if (duracion.porcentaje > 100) { %>
					<span class="badge">
						Empieza en <%= duracion.queda - duracion.plazo %>
						<%= duracion.queda - duracion.plazo == 1 ? 'día' : 'días' %>
					</span>
				<% }; %>
				<% if (duracion.porcentaje >= 51 && duracion.porcentaje <= 100) { %>
					<span class="badge color_success">
						Queda <%- duracion.queda %> <%= duracion.queda == 1 ? 'día' : 'días' %>
					</span>
				<% }; %>
				<% if ( duracion.porcentaje >= 15 && duracion.porcentaje < 51) { %>
					<span class="badge color_warning">
						Queda <%- duracion.queda %> <%= duracion.queda == 1 ? 'día' : 'días' %>
					</span>
				<% }; %>
				<% if (duracion.porcentaje >= 0 && duracion.porcentaje < 15) { %>
					<span class="badge color_error">
						Queda <%- duracion.queda %> <%= duracion.queda == 1 ? 'día' : 'días' %>
					</span>
				<% }; %>
				<% if (duracion.porcentaje < 0) { %>
					<span class="badge color_error">
						<%- -(duracion.queda) %> <%= -(duracion.queda) == 1 ? 'día' : 'días' %> de atraso
					</span>
				<% }; %>
			<%} else{%>
				<span class="text-success">Entregado</span>
			<%};%>
		</td>
		<%if ( entregado == '1' || entregado == true ) {%>
			<td>
				<span class="icon-checkmark text-success span-conmutar-entrega" title="Finalizado"></span>
			</td>
		<%} else{%>
			<td class="icon-operaciones">

				<?php if($activa_p[3]== 4){?>
					<div class="eliminar_cliente">
				 		<span class="icon-circledelete eliminar"   data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
					</div>
				 <?php }?>
				<?php if($activa_p[2]==3){ ?><span id="tr_btn_editar" class="icon-edit2"  data-toggle="modal" data-target="#modal<%- id %>" title="Editar"></span><?php } ?>
				<?php if($activa_p[1]==2){ ?><span id="tr_btn_verInfo" class="icon-eye"  data-toggle="modal" data-target="#modal<%- id %>" title="Ver proyecto"></span><?php } ?>
				<span class="icon-raceflag span-conmutar-entrega" title="Entregar"></span>
			</td>
		<%};%>
			
		<td class="td_modal"></td>
	</script>
	<script type="text/template" id="plantillaModalProyecto">
		<div class="modal fade" id="modal<%- id %>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">    
				<div class="panel panel-primary">
					<div class="panel-heading">
						<p class="panel-title"><h4><b>Información</b></h4></p>
						<span id="cerrar_consulta" class="glyphicon glyphicon-remove" style="float:right" data-dismiss="modal" aria-hidden="true"></span>
					</div>
					<div class="panel-body">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#home" data-toggle="tab">Datos</a></li>
							<li><a href="#services" data-toggle="tab">Servicios</a></li>  
							<li><a href="#roles" data-toggle="tab">Roles</a></li>  
							<li><a href="#profile" data-toggle="tab">Archivos</a></li>  
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="home">
								<br>
								<div class="row">
									<div class="col-xs-10">
										<table>
											<tr>
												<td colspan="3">
													<small class="editar">Presione la tecla <kbd>enter</kbd> para actualizar el campo</small>
												</td>
											</tr>
										</table>
										<table id="" class="table">
											<tr class="filaInformacion">
												<td class="atributo"><b>Proyecto</b></td>
												<td>
													<div class="editar editando">
														<%- nombre %>
													</div>
													<div class="editar">
														<input type="text" id="nombreProyecto" class="form-control" placeholder="Nombre de proyecto" name="nombre" value="<%- nombre %>">
													</div>
												</td>
												<td class="respuesta">
													<span class="icon-uniF55C" style="visibility: hidden;"></span>
												</td>
											</tr>
											<tr class="filaInformacion"><!-- Cliente -->
												<td class="atributo"><b>Cliente</b></td>
												<td>
													<%- propietario %>
												</td>
												<td><!--td SIN UTILIZAR--></td>
											</tr>
											<tr class="filaInformacion"><!-- Representante -->
												<td class="atributo"><b>Plan</b></td>
												<td>
													<%= plan.toUpperCase() %>
												</td>
												<td><!--td SIN UTILIZAR--></td>
											</tr>
											<tr class="filaInformacion"><!-- Representante -->
												<td class="atributo"><b>Representante</b></td>
												<td>
													<% if ( typeof representante != 'undefined' ) { %>
														<%- representante %>
													<% } else { %>
														Sin representante.
													<% }; %>
												</td>
												<td><!--td SIN UTILIZAR--></td>
											</tr>
											<tr class="filaInformacion"><!-- Fecha de inicio -->
												<td class="atributo"><b>Fecha de inicio</b></td>
												<td>
													<%if ( idcontrato != '0' ) {%>
														<div>
													<%} else {%>
														<div class="editar">
															<input type="text" class="form-control datepicker" value="<%- fechainicio.split('-').reverse().join('/') %>" name="fechainicio">
														</div>
														<div class="editar editando">
													<%};%>
															<% Anio_Mes_dia = fechainicio.split('-'); %>
															<%- Anio_Mes_dia[2] %>
															<% for (var i = 0; i < meses.length+1; i++) { %>
															 <% if (i == Anio_Mes_dia[1]) { %>
																 <%- meses[i-1] %>
															 <% }; %>
															<% }; %>
															<%- Anio_Mes_dia[0] %>
														</div>
												</td>
												<td class="respuesta">
													<span class="icon-uniF55C" style="visibility: hidden;"></span>
												</td>
											</tr>
											<tr class="filaInformacion"><!-- Fecha de entrega -->
												<td class="atributo"><b>Fecha de entrega</b></td>
												<td>
													<!-- -----------------DATOS------------------ -->
														<div class="editar editando">
															<% Anio_Mes_dia = fechafinal.split('-'); %>
															<%- Anio_Mes_dia[2] %>
															<% for (var i = 0; i < meses.length+1; i++) { %>
															 <% if (i == Anio_Mes_dia[1]) { %>
																 <%- meses[i-1] %>
															 <% }; %>
															<% }; %>
															<%- Anio_Mes_dia[0] %>
														</div>
													<!-- ----------------EDICION----------------- -->
														<div class="editar">
															<input type="text" class="form-control datepicker" value="<%- Anio_Mes_dia[2] %>/<%- Anio_Mes_dia[1] %>/<%- Anio_Mes_dia[0] %>" name="fechafinal">
															<%if ( idcontrato != '0' ) {%>
																<p class="text-warning"><small>Este proyecto pertenece a un contrato, si desea aplazar la fecha de entrega tome en cuenta que la fecha de término de contrato no será el mismo que la fecha de entrega del proyecto.</small></p>
															<%};%>
														</div>
												</td>
												<td class="respuesta">
													<span class="icon-uniF55C" style="visibility: hidden;"></span>
												</td>
											</tr>
											<tr class="filaInformacion"><!-- Duración -->
												<td class="atributo"><b>Duración</b></td>
												<td>
													<% if (duracion.porcentaje > 100) { %>
														<span class="badge">
															Empieza en <%= duracion.queda - duracion.plazo %>
															<%= duracion.queda - duracion.plazo == 1 ? 'día' : 'días' %>
														</span>
													<% }; %>
													<% if (duracion.porcentaje >= 51 && duracion.porcentaje <= 100) { %>
														<span class="badge color_success">
															Queda <%- duracion.queda %> <%= duracion.queda == 1 ? 'día' : 'días' %>
														</span>
													<% }; %>
													<% if ( duracion.porcentaje >= 15 && duracion.porcentaje < 51) { %>
														<span class="badge color_warning">
															Queda <%- duracion.queda %> <%= duracion.queda == 1 ? 'día' : 'días' %>
														</span>
													<% }; %>
													<% if (duracion.porcentaje >= 0 && duracion.porcentaje < 15) { %>
														<span class="badge color_error">
															Queda <%- duracion.queda %> <%= duracion.queda == 1 ? 'día' : 'días' %>
														</span>
													<% }; %>
													<% if (duracion.porcentaje < 0) { %>
														<span class="badge color_error">
															<%- -(duracion.queda) %> <%= -(duracion.queda) == 1 ? 'día' : 'días' %> de atraso
														</span>
													<% }; %>
												</td>
												<td><!--td SIN UTILIZAR--></td>
											</tr>             
											<tr>
												<td colspan="2">
												<b>Descripción general</b>
													<!-- -----------------DATOS------------------ -->
														<div class="editar editando">
															<div class="well"><p><%- descripcion %></p></div>
														</div>
													<!-- ----------------EDICION----------------- -->
														<div class="editar">
															<textarea id="descripcion" class="form-control" rows="4" placeholder="Descripción del proyecto" name="descripcion">
																<%- descripcion %>
															</textarea>
														</div>
												</td>
												<td class="respuesta">
													<div id="spin"></div>
												</td>
											</tr>
										</table>
									</div>
									<div class="col-xs-2">
										<div class="btn-group-vertical">
											<button type="button" class="btn btn-default" id="modal_btn_editar"><label class="icon-edit2"  data-toggle="tooltip" data-placement="top" title="Editar"></label></button>
											<button type="button" class="btn btn-danger" id="modal_btn_eliminar"><label class="icon-trash"   data-toggle="tooltip" data-placement="top" title="Eliminar"></label></button>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="services">
								<br>
								<label>Nueva sección/actividad</label>
								<form id="form_seccion">
									<input type="hidden" name="idproyecto" value="<%= id %>">
									<input type="hidden" name="status" value="1">
									<div class="row">
										<div class="col-xs-6">
											<div class="margin-5px-botton">
												<select id="select_servicios" class="" name="idservicio" placeholder="Servicio...">
													<option disabled>Seleccione servicio...</option>
												</select>
											</div>
											<div class="margin-5px-botton">
												<input type="text" class="form-control" name="seccion" value="" placeholder="Sección/Actividad">
											</div>
											<div class="margin-5px-botton">
												<input type="number" class="form-control" name="horas" value="" placeholder="Horas"
												<%if ( plan == 'iguala' ) {%>
													disabled
												<%};%>
												><!--no borrar-->
											</div>
										</div>
										<div class="col-xs-6">
											<div class="margin-5px-botton">
												<textarea class="form-control" name="descripcion" rows="3" placeholder="Descripción"></textarea>
											</div>
											<div class="margin-5px-botton">
												<button type="submit" id="btn_agregarServicio" class="btn btn-default">Agregar</button>
												<button type="reset" class="btn btn-default">Cancelar</button>
											</div>
										</div>
									</div>
								</form>
								<br>
								<label>Haga clic en servivio para ver las secciones/actividades</label>
								<div class="panel-group" id="serviciosProyecto" role="tablist" aria-multiselectable="true">
								</div>
							</div>
							<div class="tab-pane" id="roles">
								<br>
								<label>Nuevo rol de empleado</label>
								<form id="form_roles">
									<input type="hidden" name="idproyecto" value="<%= id %>">
									<div class="margin-5px-botton">
										<select id="select_empleados" class="" name="idpersonal" placeholder="Seleccione empleado...">
											<option>Seleccione empleado...</option>
										<select>
									</div>
									<div class="margin-5px-botton">
										<select id="select_rol" class="" name="idrol" placeholder="Seleccione rol...">
										</select>
									</div>
									<button type="submit" id="btn_enviarRolesProy" class="btn btn-default">Agregar</button>
									<button type="reset" class="btn btn-default">Cancelar</button>
								</form>
								<br>
								<label>Lista de empleados y roles</label>
								<ul id="ul-rolesProyecto" class="list-group">
									<!--PLANTILLAS DE EMPLEADOS INVOLUCRADOS-->
								</ul>
							</div>
							<div class="tab-pane" id="profile">
								<br>
								<div class="panel panel-default">
									<div class="panel-heading">Adjunta archivos</div>
									<div class="panel-body">
										<label class="btn btn-default input-sm fileinput-button">
											<i class="glyphicon icon-paperclip"></i>
											<span>Abrir</span>
											<input type="file" id="inputArchivos" multiple name="archivo[]">
										</label>
										<button type="submit" id="btn_subirArchivo" class="btn btn-default input-sm start">
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
								<div class="panel panel-default">
									<div class="panel-heading">Archivos</div>
									<div class="panel-body">
										<table class="table table-hover">
											<tbody id="tbody-archivos-subidos">
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>
	<script type="text/template" id="plantillaServicioProyecto">
		<!-- -----------------DATOS------------------ -->
			<div class="panel-heading" role="tab" id="heading<%= id %>">
				<a data-toggle="collapse" data-parent="#" href="#servicio<%= id %>" aria-expanded="true" aria-controls="servicio<%= id %>">
					<%- nombre %>
				</a>
			</div>
			<div id="servicio<%= id %>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<%= id %>">
				<div class="panel-body">
					<div class="container-fluid secciones">
						
					</div>
					<div class="container-fluid secciones-eliminadas">
						
					</div>
				</div>
			</div>
			
	</script>
	<script type="text/template" id="row-seccion">
		<form>
			<input type="hidden" name="idproyecto" value="<%= idproyecto %>">
			<input type="hidden" name="idservicio" value="<%= idservicio %>">
			<input type="hidden" name="status" value="<%= status %>">
			<div class="col-xs-8">
				<b>Sección/Actividad:</b>
				<div class="editar editando">
					<%= seccion %>
				</div>
				<div class="editar">
					<input type="text" class="form-control input-sm" name="seccion" value="<%= seccion %>" placeholder="Nombre Sección/Actividad">
				</div>
			</div>
			<div class="col-xs-3">
				<b>Horas:</b>
				<div class="editar editando">
					<%= horas %>
				</div>
				<div class="editar">
					<input type="number" class="form-control input-sm" name="horas" value="<%= horas %>" placeholder="Horas">
				</div>
			</div>
			<div class="col-xs-11">
				<b>Descripción:</b>
				<div class="editar editando">
					<%= descripcion %>
				</div>
				<div class="editar">
					<textarea class="form-control input-sm" name="descripcion" rows="3" placeholder="Descripción"><%= descripcion %></textarea>
				</div>
			</div>
			<div class="btn-group-vertical  btn-group-xs" role="group" aria-label="...">
				<button type="submit" class="btn btn-default icon-save btn_actualizar" disabled></button>
				<button type="button" class="btn btn-default icon-edit2 btn_editar_seccion"></button>
				<button type="button" class="btn btn-warning icon-trash btn-conmutar-status-seccion"></button>
			</div>
		</form>
		<div class="col-xs-12">
			<br>
		</div>
	</script>
	<script type="text/template" id="seccion-eliminada">
			<button type="button" class="btn btn-default btn-conmutar-status-seccion icon-restore"></button>
			<button type="button" class="btn btn-default" disabled><%= seccion %></button>
			<button type="button" class="btn btn-danger btn_eliminar_seccion icon-circledelete"></button>
	</script>
	<script type="text/template" id="plantillaRolProyecto">
		<!-- -----------------DATOS------------------ -->
			<span class="icon-uniF478 btn_eliminar"></span>
			<span class="badge"><%- nombreRol %></span> <%- nombrePersonal %></div>
	</script>
	<script type="text/template" id="tr_archivo">
		
			<% if (	nombre.split('.')[1] == 'jpg' ||
					nombre.split('.')[1] == 'png' ||
					nombre.split('.')[1] == 'gif'
			) { %>
				<td>
					<img src="<?=base_url()?><%- ruta %>" style="width:50px;">
				</td>
				<td>
					<%- nombre %>
				</td>
					
			<% } else { %>
				<td colspan="2">
					<a href="<?=base_url()?><%- ruta %>" download><%- nombre %></a>
				</td>
			<% }; %>
		
		<td class="icon-operaciones">
			<div class="btn_eliminar_archivo">
				<span class="icon-circledelete eliminar" data-toggle="tooltip" title="Eliminar"></span>
			</div>
			<a href="<?=base_url()?><%- ruta %>" download>
				<span class="icon-uniF7D5" data-toggle="tooltip" data-placement="top" title="Descargar">
			</a>
		</td>
	</script>

	<script type="text/template" id="tr_archivoNuevo">
		<tr class="<%= i %>">
			<td><%= nombre %></td>
			<td><%= tipo %></td>
			<td><%= tamaño %></td>
			<td class="icon-eliminar">
				<!-- <span id="<%= i %>" class="icon-circledelete span_eliminarArchivo"></span> -->
			</td>
		</tr>
	</script>


<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDeClientes       = <?php echo json_encode($clientes)       ?>;
	app.coleccionDeProyectos      = <?php echo json_encode($proyectos)      ?>;
	app.coleccionDeRoles          = <?php echo json_encode($roles)          ?>;
	app.coleccionDeServicios      = <?php echo json_encode($servicios)      ?>;
	app.coleccionDeEmpleados      = <?php echo json_encode($empleados)      ?>;
	app.coleccionDeProyectoRoles  = <?php echo json_encode($proyectoRoles)  ?>;
	app.coleccionDeServicosProyecto = <?php echo json_encode($servicios_proy) ?>;
	app.coleccionArchivosCodeIgniter = <?php echo json_encode($archivos) 	?>;
	app.coleccionDeRepresentantes = <?php echo json_encode($representantes) ?>;
</script>
<!-- Utilerias -->
	<?=
		// <!-- MV* -->
		// <!-- modelos -->
		script_tag('js/backbone/modelos/ModeloCliente.js').
		script_tag('js/backbone/modelos/ModeloRepresentante.js').
		script_tag('js/backbone/modelos/ModeloServicio.js').
		script_tag('js/backbone/modelos/ModeloRolProyecto.js').
		script_tag('js/backbone/modelos/ModeloServicioProyecto.js').
		// <!-- colecciones -->
		script_tag('js/backbone/colecciones/ColeccionClientes.js').
		script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
		script_tag('js/backbone/colecciones/ColeccionProyectos.js').
		script_tag('js/backbone/colecciones/ColeccionRoles.js').
		script_tag('js/backbone/colecciones/ColeccionServicios.js').
		script_tag('js/backbone/colecciones/ColeccionEmpleados.js').
		script_tag('js/backbone/colecciones/ColeccionRolesProyectos.js').
		script_tag('js/backbone/colecciones/ColeccionArchivos.js').
		script_tag('js/backbone/colecciones/ColeccionServiciosProyecto.js');
	?>
		
		<script type="text/javascript">
			app.coleccionArchivos = new ColeccionArchivos(app.coleccionArchivosCodeIgniter);
			app.coleccionProyectos = new ColeccionProyectos(app.coleccionDeProyectos);
			app.coleccionRolesProyectos = new ColeccionRolesProyectos(app.coleccionDeProyectoRoles);
			app.coleccionServiciosProyecto = new ColeccionServiciosProyecto(app.coleccionDeServicosProyecto);
		</script>
	<!-- vistas -->
	<?=	script_tag('js/backbone/vistas/VistaServicio.js').// <!-- Solo heredamos la clase -->
		script_tag('js/backbone/vistas/VistaRol.js'). //<!-- Solo heredamos la clase -->
		script_tag('js/backbone/vistas/VistaArchivo.js').// <!-- Utilizamos app.V_A_ConsultaProyecto -->
		script_tag('js/backbone/vistas/vistaArchivos.js').
		script_tag('js/backbone/vistas/VistaProyecto.js').
		script_tag('js/backbone/vistas/VistaConsultaProyectos.js');
	?>