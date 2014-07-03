	<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_proyectos.css'?>" type="text/css">

	<div class="alert alert-warning oculto" id="advertencia">
		<button type="button" class="close cerrar">×</button>
		<h4>¡Advertencia!</h4>
		<p id="comentario"></p>
		<br>
		<button type="button" id="cancelar" class="btn btn-danger">Borrar</button>
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

	<h1>Nuevo Proyecto</h1>

	<style type="text/css">
		/*#divSecciones {
			position: relative;
		}
		#divSecciones section {
			box-sizing: border-box;
			width: 100%;
			position: absolute;
		}
		#divSecciones section:not(:first-of-type) {
			display: none;
		}
		#progressbar {
			margin-bottom: 30px;
			overflow: hidden;
			counter-reset: step;
		}
		#progressbar li {
			list-style-type: none;
			text-transform: uppercase;
			text-align: center;
			font-size: 9px;
			width: 25%;
			float: left;
			position: relative;
		}
		#progressbar li:before {
			content: counter(step);
			counter-increment: step;
			line-height: 20px;
			display: block;
			font-size: 10px;
			color: #333;
			background: white;
			margin: 0 auto 5px auto;
		}
		#progressbar li:first-child:after {
			content: none; 
		}
		#progressbar li.active:before,  #progressbar li.active:after{
			background: #27AE60;
			color: white;
		}*/
	</style>
	<div id="divSecciones">
		<!-- <ul id="progressbar">
			<li class="active">Datos de proyecto</li>
			<li>Roles del proyecto</li>
			<li>Archivos del proyecto</li>
			<li>Guardar proyecto</li>
		</ul> -->
		<section id="paso1" class="section_Visible"><!-- section_Oculto -->
			<div class="panel panel-primary">
				<div class="panel-heading">Datos de proyecto</div>
				<div class="panel-body">
					<form id="formNuevoProyecto">
						<div class="row">
							<div class="col-md-3">
								<fieldset>
									<legend> <h5>Cliente y nombre del proyecto</h5> </legend>
									<div class="form-group has-feedback">
									  	<input type="text" id="busqueda" class="form-control" placeholder="Buscar cliente" style="width: 100%;">
									  	<span class="glyphicon glyphicon-search form-control-feedback" style="top:0px"></span>
										<input type="hidden" id="hidden_idCliente" name="idcliente">
									</div>
									<input type="text" class="form-control" placeholder="Nombre del proyecto" style="width:100%" name="nombre">
								</fieldset>
							</div>
							<div class="col-md-9">
								<fieldset>
									<legend> <h5>Establecer fecha de inicio y fecha de entrega del proyecto</h5> </legend>
									<div class="row">
										<div class="col-md-3">
											<div style="margin: 23px 0px 21px 0px;"><b>Inicio</b></div>
								    		<input id="fechaInicio" class="form-control datepicker" type="text" name="fechainicio">
										</div>
										<div class="col-md-3">
											<div style="margin: 23px 0px 21px 0px;"><b>Termino</b></div>
											<input id="fechaEntrega" class="form-control datepicker" type="text" name="fechafinal">
										</div>
										<div class="col-md-3">
											<div style="margin: 23px 0px 21px 0px;"><b>Duración en días</b></div>
											<input type="number" id="duracion" class="form-control" min="1">
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						<br>
						<fieldset>
							<legend> <h5>Servicios que integrarán el proyecto</h5> </legend>
							<div class="row">
								<div class="col-md-3">
									<table class="table table-hover table-curved"><!--  tbla_apilacion -->
										<thead class="cabecera_serv2">
											<tr class="color_th">						
											  <th>Servicios</th>
											</tr>
										</thead>
										<tbody id="tbody_servicios" class="scrolltbla">
										</tbody>
									</table>	
								</div>
								<div class="col-md-7">
									<table id="tbla_roles" class="table table-striped table-curved">
										<thead>
											<tr class="color_th">
												<th>&nbsp;&nbsp;&nbsp;</th>
												<th>Servicio seleccionado</th>
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
						</fieldset>

						<textarea class="form-control" rows="4" placeholder="Descripción del proyecto" name="descripcion"></textarea>
						
					</form>
				</div>
				<!-- <div class="panel-footer">
					<button type="button" id="btn_cancelarProyecto" class="btn btn-default">Cancelar</button>
					<button type="button" class="btn btn-default btn_siguiente">Siguiente</button>
				</div> -->
			</div>
		</section>

		<section id="paso2" class="section_Visible">
			<div class="panel panel-primary">
				<div class="panel-heading">Roles del proyecto</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<fieldset>
								<legend><h5>Establecer participantes en el proyecto y sus respectivos roles</h5></legend>
							</fieldset>
						</div>
						<div class="col-md-3">
							<table class="table table-hover table-curved"><!--  tbla_apilacion -->
								<thead class="cabecera_serv2">
									<tr class="color_th">						
									  <th>Empleado</th>
									</tr>
								</thead>
								<tbody id="tbody_empleados" class="scrolltbla">
								</tbody>
							</table>
						</div>
						<div class="col-md-9">
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
											<!-- <div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default btn-xs"> -->
													<input type="checkbox" id="checkboxEmpleados" class="btn_marcarTodos"> Marcar todos
												<!-- </label> -->
											</div>
											<button type="button" class="btn btn-danger btn-xs checkboxEmpleados btn_eliminarMarcados">Eliminar marcados</button>
								    	</td>
								    </tr>
							    </tfoot>
							</table>
						</div>
					</div> <!-- Fin class row -->
				<!-- <div class="progress">
					<div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
						40%
					</div>
				</div> -->
				</div>
				<!-- <div class="panel-footer">
					<button type="button" class="btn btn-default btn_regresar">Atrás</button>
					<button type="button" id="btn_omitir_paso" class="btn btn-default">Omitir paso</button>
					<button type="button" class="btn btn-default btn_siguiente">Siguiente</button>
				</div> -->
			</div>
		</section>

		<section id="paso3" class="section_Visible">
			<div class="panel panel-primary">
				<div class="panel-heading">Archivos del proyecto</div>
				<div class="panel-body">
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
				</div>
				<!-- <div class="panel-footer">
					<button type="button" class="btn btn-default btn_regresar">Atrás</button>
					<button type="button" class="btn btn-default btn_siguiente">Siguiente</button>
				</div> -->
			</div>
		</section>
		<button type="button" id="btn_guardarProyecto" class="btn btn-primary btn-lg">Guardar</button>
		<button type="button" id="btn_cancelarProyecto" class="btn btn-default btn-lg">Cancelar</button>
	</div>
</div> <!-- LA APERTURA DE ESTA ETIQUETA ESTÁ EN OTRO DOCUMENTO. NO BORRAR!! -->


<!-- plantillas -->
	<!-- <script type="text/template" id="option_cliente">
		<%- nombreComercial %>
	</script> SIN USO TEMPORALMENTE, BORRAR SI NO SE LLEGA A UTILIZAR -->

	<script type="text/template" id="tds_servicio">
		<td style="padding:0px">
			<label class="label_servicio" for="servicio_<%- id %>"><%- nombre %></label>
			<div class="check_posicion"><!---->
	        	<input type="checkbox" id="servicio_<%- id %>" class="checkbox_servicio">
	        <div>
		</td>
	</script>

	<script type="text/template" id="tds_servicio_seleccionado">
		<tr>
    		<td>
    			<input type="checkbox" class="checkbox_servicios" name="checkboxServicios"></td>
		    <td>
		    	<%- nombre %>
		    	<input type="hidden" name="servicios" value="<%- id %>">
		    </td>
		    <td class="icon-eliminar">
		    	<label id="servicio_<%- id %>" class="icon-circledelete eliminarDeTabla_servicios" title="Eliminar"></label>
		    </td>
        </tr>
	</script>

	<script type="text/template" id="tds_empleado">
		<td style="padding:0px">
			<label class="label_empleado" for="empleado_<%- id %>"><%- nombre %></label>
			<div class="check_posicion"><!---->
	        	<input type="checkbox" id="empleado_<%- id %>" class="checkbox_empleado">
	        <div>
		</td>
	</script>

	<script type="text/template" id="tds_empleado_seleccionado">
		<td>
			<input type="checkbox" class="checkbox_empleados" name="checkboxEmpleados">
		</td>
	    <td>
	    	<%- nombre %>
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
	    			<input type="hidden" name="idpersonal" value="<%- id %>">
				</form>
	    </td>
	    <td class="icon-eliminar">
	    	<label id="empleado_<%- id %>" class="icon-circledelete eliminarDeTabla_empleados" data-toggle="tooltip" data-placement="top" title="Eliminar"></label>
	    </td>
	</script>

	<script type="text/template" id="option_rol">
		<%- nombre %>
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
		<tr class="<%- i %>">
			<td><%- nombre %></td>
			<td><%- tipo %></td>
			<td><%- tamaño %></td>
			<td class="icon-eliminar">
		    	<label id="<%- i %>" class="icon-circledelete eliminarArchivo"></label>
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

<!-- plugin jquery -->
	<script type="text/javascript" src="js/plugin/jquery.easing.min.js"></script>
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
