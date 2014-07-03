<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_proyectos.css'?>" type="text/css">
<style type="text/css">
	#color_titulos hr {
		line-height: 10px;
	}
	.trProyecto{
		height: 51px;
		width: 100%;
	}

	#info_proyecto, #archivos_proy{
		margin-top: -21px;
	}

	#icon_operaciones_proy{
		display: inline-block;
		right: 15px;
		position: absolute;
		margin-top: -45px;
	}

	/*CSS contruido en el desarrollo frontend */
		.editar2 {
			display: none;
		}
		.editando2 {
			display: inline;
		}
		option:disabled { /*Color de fondo para los option desactivados*/
			background: #F1F1f1;
		}

		span.icon-uniF478:hover {
			background: red;
			color: white;
			border-radius: 3px;
		}
	/*CSS contruido en el desarrollo frontend */

	.panel-body span{
		padding: 5px;
	}
	.btn_eliminar_archivo {
		display: inline-block;
	}
	.btn_eliminar_archivo .icon-circledelete:hover{ 
		background: red;
		border-radius: 3px;
		cursor: pointer;
		color: white;
	}
	.icon-circledelete{
		vertical-align: center;
	}


	#cerrar_modal{
		margin-top: -25px;
	}
</style>
	<!-- Alertas -->
		<div class="alert alert-warning oculto" id="advertencia">
			<button type="button" class="close cerrar">×</button>
			<h4>¡Advertencia!</h4>
			<p id="comentario"></p>
			<br>
			<button type="button" id="cancelar" class="btn btn-danger">Cancelar</button>
			<button type="button" id="continuar" class="btn btn-default">Continuar</button>
		</div>
		<div class="alert alert-danger alert-dismissable oculto" id="error">
			<button type="button" class="close cerrar">&times;</button>
			<strong>¡Error!</strong>
			<div id="comentario"></div>
		</div>
		<div class="alert alert-success alert-dismissable oculto" id="exito">
			<button type="button" class="close cerrar">&times;</button>
			<strong>¡Exito!</strong>
			<div id="comentario"></div>
		</div>

	<div id="posicion_infotd">
		<table id="tbla_cliente" class="table table-striped">
			<thead>
		        <tr id="color_titulos">
					<th style="text-align:center;">Todos<!-- <input type="checkbox"> --></th>
					<th>
				        <input type="text" class="form-control" placeholder="Clientes">
				        <!-- Cliente -->
					</th>
					<th>
						<input type="text" class="form-control" placeholder="Proyecto">
						<span class="icon-search busqueda"></span>
						<!-- Proyecto -->
					</th>  
					<!-- <th><input type="text" class="form-control" placeholder="Rsponsable">
						<span class="icon-search busqueda"></span>
					</th> -->
					<th>Inicio</th>
					<th>Entrega</th>     
					<th>Status</th>         
					<th>Operaciones</th>
		        </tr>
			</thead>      
			<tbody id="tbody_proyectos">
			</tbody> 
	    </table>
	    <button type="button" class="btn btn-default">Eliminar varios</button>
	    <button type="button" class="btn btn-default">Entregar</button>  
	</div>
</div>


<script type="text/javascript">
	var meses = new Array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
</script>
<!-- plantillas -->
	<script type="text/template" id="plantilla_tr_proyecto">
		<td>
			<!-- Alertas -->
				<div class="alert alert-warning oculto" id="advertencia">
					<button type="button" class="close cerrar">×</button>
					<h4>¡Advertencia!</h4>
					<p id="comentario"></p>
					<br>
					<button type="button" id="cancelar" class="btn btn-danger">Cancelar</button>
					<button type="button" id="continuar" class="btn btn-default">Continuar</button>
				</div>
				<div class="alert alert-danger alert-dismissable oculto" id="error">
					<button type="button" class="close cerrar">&times;</button>
					<strong>¡Error!</strong>
					<div id="comentario"></div>
				</div>
				<div class="alert alert-success alert-dismissable oculto" id="exito">
					<button type="button" class="close cerrar">&times;</button>
					<strong>¡Exito!</strong>
					<div id="comentario"></div>
				</div>
			<input  type="checkbox">
		</td>
		<td><%- propietario %></td>
		<td><%- nombre %></td>                     
		<!-- <td>Responsable</td> -->
		<td >
			<% var Anio_Mes_dia = fechainicio.split('-'); %>
			<%- Anio_Mes_dia[2] %>
			<% for (var i = 0; i < meses.length+1; i++) { %>
	         <% if (i == Anio_Mes_dia[1]) { %>
	             <%- meses[i-1] %>
	         <% }; %>
			<% }; %>
			<%- Anio_Mes_dia[0] %>
		</td> 
		<td >
			<% Anio_Mes_dia = fechafinal.split('-'); %>
			<%- Anio_Mes_dia[2] %>
			<% for (var i = 0; i < meses.length+1; i++) { %>
	         <% if (i == Anio_Mes_dia[1]) { %>
	             <%- meses[i-1] %>
	         <% }; %>
			<% }; %>
			<%- Anio_Mes_dia[0] %>
		</td> 
		<td >
			<% if (duracion.porcentaje >= 51 && duracion.porcentaje < 100) { %>
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
		<td class="icon-operaciones">
			<div class="eliminar_cliente">
	     		<span class="icon-trash eliminar"   data-toggle="tooltip" data-placement="top" title="Eliminar"></span> 
			</div>
			<span id="tr_btn_editar" class="icon-edit2"  data-toggle="modal" data-target="#modal<%- id %>" title="Editar"></span>
			<span id="tr_btn_verInfo" class="icon-eye"  data-toggle="modal" data-target="#modal<%- id %>" title="Ver proyecto"></span>
		</td>
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
						<!-- -->
						<div class=" editar2 editando2">
							<p class="panel-title"><h3 style="text-align: center;"><b><%- nombre %></b></h3></p>
						</div>
						<div class="editar2">
							<div class="filaInformacion">
								<div style="display: table-cell;">
									<input type="text" id="nombreProyecto" class="form-control input-lg" placeholder="Nombre de proyecto" name="nombre" value="<%- nombre %>">
								</div>
								<div class="respuesta" style="display: table-cell; padding: 8px;">
									<span class="icon-uniF55C"  style="visibility: hidden;">
								</div>
							</div>
						</div>
						<!-- -->
						<div id="icon_operaciones_proy">
							<div class="btn-group-vertical" style="margin-top: 0px;">
								<button type="button" class="btn btn-primary" id="btn_eliminar"><label class="icon-trash"   data-toggle="tooltip" data-placement="top" title="Eliminar"></label></button>
								<button type="button" class="btn btn-primary" id="btn_editar"><label class="icon-edit2"  data-toggle="tooltip" data-placement="top" title="Editar"></label></button>         
							</div>
						</div>
						<ul class="nav nav-tabs">
							<li class="active"><a href="#home" data-toggle="tab">Datos</a></li>
							<li><a href="#profile" data-toggle="tab">Archivos</a></li>  
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="home"><br>
								<small class="editar">Presione la tecla enter para actualizar el campo</small>
								<!-- -------INFORMACION DEL PROYECTO------- -->
								<div class="visible" id="">
									<table id="info_proyecto" class="table table-striped" >
										<tr class="filaInformacion"><!-- Cliente -->
											<td class="atributo"><b>Cliente</b></td>
											<td>
												<%- propietario %>
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
										<tr class="filaInformacion"><!-- Fecha de Inicio -->
											<td class="atributo"><b>Fecha de Inicio</b></td>
											<td>
												<!-- -----------------DATOS------------------ -->
													<div class="editar2 editando2">
														<% Anio_Mes_dia = fechainicio.split('-'); %>
														<%- Anio_Mes_dia[2] %>
														<% for (var i = 0; i < meses.length+1; i++) { %>
												         <% if (i == Anio_Mes_dia[1]) { %>
												             <%- meses[i-1] %>
												         <% }; %>
														<% }; %>
														<%- Anio_Mes_dia[0] %>
													</div>
												<!-- ----------------EDICION----------------- -->
													<div class="editar2">
														<input type="text" class="form-control datepicker" value="<%- Anio_Mes_dia[2] %>/<%- Anio_Mes_dia[1] %>/<%- Anio_Mes_dia[0] %>" name="fechainicio">
													</div>
											</td>
											<td class="respuesta">
												<span class="icon-uniF55C" style="visibility: hidden;"></span>
											</td>
										</tr>
										<tr class="filaInformacion"><!-- Fecha Final -->
											<td class="atributo"><b>Fecha Final</b></td>
											<td>
												<!-- -----------------DATOS------------------ -->
													<div class="editar2 editando2">
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
													<div class="editar2">
														<input type="text" class="form-control datepicker" value="<%- Anio_Mes_dia[2] %>/<%- Anio_Mes_dia[1] %>/<%- Anio_Mes_dia[0] %>" name="fechafinal">
													</div>
											</td>
											<td class="respuesta">
												<span class="icon-uniF55C" style="visibility: hidden;"></span>
											</td>
										</tr>
										<tr class="filaInformacion"><!-- Duración -->
											<td class="atributo"><b>Duración</b></td>
											<td>
											    <% if (duracion.porcentaje >= 51 && duracion.porcentaje < 100) { %>
													<span class="badge color_success">
														Queda <%- duracion.queda %> <%= duracion.queda == 1 ? 'día' : 'días' %>
													</span>
													 de <%- duracion.plazo %>
												<% }; %>
												<% if ( duracion.porcentaje >= 15 && duracion.porcentaje < 51) { %>
													<span class="badge color_warning">
														Queda <%- duracion.queda %> <%= duracion.queda == 1 ? 'día' : 'días' %>
													</span>
													 de <%- duracion.plazo %>
												<% }; %>
												<% if (duracion.porcentaje >= 0 && duracion.porcentaje < 15) { %>
													<span class="badge color_error">
														Queda <%- duracion.queda %> <%= duracion.queda == 1 ? 'día' : 'días' %>
													</span>
													 de <%- duracion.plazo %>
												<% }; %>
												<% if (duracion.porcentaje < 0) { %>
													<span class="badge color_error">
														<%- -(duracion.queda) %> <%= -(duracion.queda) == 1 ? 'día' : 'días' %> de atraso
													</span>
													 de <%- duracion.plazo %>
												<% }; %>
											</td>
											<td><!--td SIN UTILIZAR--></td>
										</tr>
										<tr class="filaInformacion"><!-- Servicios incluidos -->
											<td class="atributo"><b>Servicios incluidos</b></td>
											<td>
												<!-- ----------------EDICION----------------- -->
													<div class="editar2">
														<div class="input-group">
															<select id="select_servicios" class="form-control" name="idservicio">
																<option disabled>Seleccione servicio...</option>
															</select>
															<span class="input-group-btn" style="padding:0px">
																<button id="btn_agregarServicio" class="btn btn-default" type="button" padding="auto">Agregar</button>
															</span>
														</div><!-- /input-group -->
														<br>
													</div>
												<!-- -----------------DATOS------------------ -->
													<ul id="serviciosProyecto" class="list-group">
														<!--PLANTILLAS DE SERVICIOS DEL PROYECTO-->
													</ul>
											</td>
											<td class="respuesta">
												<span class="icon-uniF55C" style="visibility: hidden;"></span>
											</td>
										</tr>
										<tr class="filaInformacion"><!-- Empleados involucrados -->
											<td class="atributo"><b>Empleados involucrados</b></td>                    
											<td>
												<!-- ----------------EDICION----------------- -->
													<div class="editar2">
									<form id="form_roles">
														<div class="panel panel-default">
															<div class="panel-heading">
																<select id="select_empleados" class="form-control input-sm" name="idpersonal" style="width: 100%;">
																	<option selected disabled>Seleccione nuevo participante o uno existente...</option>
																<select>
																<div class="row">
																	<div class="col-md-6">
																		<select id="select_rol" class="form-control input-sm">
																  	   		<!-- PLANTILLA DE ROL -->
																		</select>
																	</div>
																	<div class="col-md-6">
																		<div class="input-group input-group-sm" style="width:auto;">
																			<input type="text" id="" class="form-control text_nuevoRol" placeholder="Nuevo Rol">
																			<span class="input-group-btn" style="padding:0px">
																				<button type="button" id="" class="btn btn-default btn_nuevoRol">Agregar</button>
																			</span>
																		</div>
																	</div>
																</div>
															</div>
															<div id="rolesNuevosProy" class="panel-body">
																<!-- PLANTILLAS DE ROLES -->
															</div>
															<input type="hidden" name="idproyecto" value="<%- id %>">
															<div class="panel-footer">
																<button type="submit" id="btn_enviarRolesProy" class="btn btn-default btn-sm">Agregar al proyecto</button>
															</div>
														</div>
													</div>
									</form>
													<ul id="rolesProyecto" class="list-group">
														<!--PLANTILLAS DE EMPLEADOS INVOLUCRADOS-->
													</ul>
											</td>
											<td class="respuesta">
												<span class="icon-uniF55C" style="visibility: hidden;"></span>
											</td>
										</tr>              
										<tr>
											<td class="atributo">Descripción</td>                    
											<td>
												<!-- -----------------DATOS------------------ -->
													<div class="editar2 editando2">
														<div class="well"><p><%- descripcion %></p></div>
													</div>
												<!-- ----------------EDICION----------------- -->
													<div class="editar2">
														<textarea id="descripcion" class="form-control" rows="4" placeholder="Descripción del proyecto" name="descripcion">
															<%- descripcion %>
														</textarea>
													</div>
											</td>
											<td class="respuesta">
												<span class="icon-uniF55C" style="visibility: hidden;"></span>
											</td>
										</tr>
									</table>
								</div>
								<!-- ------- Archivos del proyecto------- -->
							</div>
							<div class="tab-pane" id="profile">
								<br>
								<div class="row">
									<div class="col-md-12">
										<fieldset>
											<legend><h5>Adjunta los archivos para el proyecto. No seleccione carpetas. Los archivos deben estár en la misma carpeta</h5></legend>
										</fieldset>
									</div>
								</div>
								<label class="btn btn-success fileinput-button">
				                    <span class="icon-paperclip"></span>
				                    <span>Adjuntar archivos</span>
				                    <input type="file" id="inputArchivos" multiple name="archivo[]">
				                </label>
				                <button type="submit" id="btn_subirArchivo" class="btn btn-primary start">
				                    <i class="icon-upload"></i>
				                    <span>Subir</span>
				                </button>
				                <button type="reset" id="btn_cancelarArchivo" class="btn btn-warning cancel">
				                    <i class="glyphicon glyphicon-ban-circle"></i>
				                    <span>Borrar lista</span>
				                </button>
								<form id="form_subirArchivos">
					                <input type="hidden" id="idpropietario" name="idpropietario" value="<%- id %>">
					                <input type="hidden" id="tabla" name="tabla" value="proyectos">
					                <input type="hidden" id="fecha_creacion" name="fecha_creacion">
							    </form>
							    <br>
								<table class="table table-hover"><!-- style="display: table-cell; width: 400px;" -->
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
								<br>
								<br>
								<h4>Archivos subidos</h4>
								<br>
								<table id="archivos_proy" class="table table-striped">
									<!-- PLANTILLAS TR DE ARCHIVOS -->
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>
	<script type="text/template" id="plantillaServicioProyecto">
		<!-- -----------------DATOS------------------ -->
			<!-- La plantilla es puesta en el DOM con el botón de eliminar
			     visible. En el código de VistaProyecto.js ocultamos el botón,
			     el usuario no ve este efecto, esto se realiza para facilitar
			     la visualización del botón eliminar cuando se agreguen más 
			     servicios y poderlos eliminar en ese momento si se requiere -->
			<div class="editar2 editando2"><span class="icon-uniF478 btn_eliminar"></span></div> <!--botón eliminar-->
			<%- nombre %>
	</script>
	<script type="text/template" id="plantillaRolProyecto">
		<!-- -----------------DATOS------------------ -->
			<% if (idrol == 1) { %>
				<div class="editar2"><span class="icon-uniF478 btn_eliminar"></span></div> <!--botón eliminar-->
				<span class="badge"><%- nombreRol %></span> <%- nombrePersonal %></div>
			<% }else { %>
				<div class="editar2"><span class="icon-uniF478 btn_eliminar"></span></div> <!--botón eliminar-->
				<b><%- nombreRol %></b> <%- nombrePersonal %>
			<% }; %>
			<% if ( typeof exito != 'undefined' ) { %>
				<label class="icon-uniF479 exito"></label>
			<% }; %>
			<% if ( typeof error != 'undefined' ) { %>
				<label class="icon-uniF479 exito"></label>
			<% }; %>
	</script>
	<script type="text/template" id="input_rol">
		<div class="tag_rol">
			<div class="btn-group btn-group-xs">
				<button class="btn btn-default btn_eliminarRol" value="<%- id %>">
					<span class="icon-circledelete"></span>
				</button>
				<button type="button" class="btn btn-default" disabled="disabled">
					<%- nombre %>
				</button>
			</div>
			<input type="hidden" class="rol" name="<%- name %>" value="<%- id %>">
		</div>
	</script>
	<script type="text/template" id="tr_archivo">
		<td>
			<% if (nombre.split('.')[1] == 'jpg') { %>
				<a href="<%- ruta %>" download><img src="<%- ruta %>" style="width:50px; height:50px;"></a>
			<% } else { %>
				<a href="<%- ruta %>" download><%- nombre %></a>
			<% }; %>
		</td>
		<td class="icon-operaciones">
			<div class="btn_eliminar_archivo">
				<span class="icon-circledelete eliminar" data-toggle="tooltip" title="Eliminar"></span>
			</div>
			<a href="<%- ruta %>" download>
				<span class="icon-uniF7D5" data-toggle="tooltip" data-placement="top" title="Descargar">
			</a>
	    </td>
	</script>

	<script type="text/template" id="tr_archivoNuevo">
		<tr class="<%- i %>">
			<td><%- nombre %></td>
			<td><%- tipo %></td>
			<td><%- tamaño %></td>
			<td class="icon-eliminar">
		    	<label id="<%- i %>" class="icon-circledelete eliminarArchivoNuevo"></label>
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
	<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<!-- Librerias Backbone -->
	<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>"></script>
<!-- MV* -->
	<!-- modelos -->
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloCliente.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloRepresentante.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloProyecto.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloRol.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicio.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloEmpleado.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloRolProyecto.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloArchivo.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicioProyecto.js'?>"></script>
	<!-- colecciones -->
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionClientes.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionRepresentantes.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionProyectos.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionRoles.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServicios.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionEmpleados.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionRolesProyectos.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionArchivos.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServiciosProyecto.js'?>"></script>
		<script type="text/javascript">
			app.coleccionProyectos = new ColeccionProyectos(app.coleccionDeProyectos);
			app.coleccionRolesProyectos = new ColeccionRolesProyectos(app.coleccionDeProyectoRoles);
			app.coleccionServiciosProyecto = new ColeccionServiciosProyecto(app.coleccionDeServicosProyecto);
		</script>
	<!-- vistas -->
		<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaServicio.js'?>"></script> <!-- Solo heredamos la clase -->
		<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaRol.js'?>"></script> <!-- Solo heredamos la clase -->
		<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaArchivo.js'?>"></script> <!-- Utilizamos app.V_A_ConsultaProyecto -->
		<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaProyecto.js'?>"></script>
		<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaConsultaProyectos.js'?>"></script>
