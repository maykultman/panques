<?=
	script_tag('js/autocompletes.js').
	link_tag('css/estilos_modulo_contratos.css');
?>
	<section id="seccion_tabla">
		<!-- <div id="div_fullHeight">     -->
	        <div id="posicion_infotd">
	    		<div id="clientes" class="wrapper"> 
				    <table id="tabla_principal" class="table table-striped tablesorter">
						<thead>
							<tr>
								<th class="sorter-false">
									<input class="todos" type="checkbox" style="margin-left: 4px;">
								</th>
								<th class="sorter-false">
									<!-- Títulos -->
									<input type="search" class="form-control search input-sm" data-column="1" placeholder="Servicio solicitado">
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
								<th class="filter-false">Folio</th>
								<th class="filter-false">Total</th>
								<th class="sorter-false">creado en</th>
								<th class="sorter-false">finaliza en</th>
								<th class="sorter-false">Operaciones</th>
							</tr>
						</thead>					
						<tbody id="tbody_contratos">
							<!-- Lista de las ultimas cotizaciones-->
						</tbody>		
					</table>
				</div>
				<button id="btn_eliminarVarios"  type="button" class="btn btn-danger">Eliminar varios</button>
			</div>
		<!-- </div> -->
	</section>
	
</div><!-- /.contenedor_modulo -->
<!-- plantillas -->
	<script type="text/template" id="tds_contrato">
		<td><input type="checkbox" name="todos" value="<%= id %>" /></td>
		<td>	<%=serviciosolicitado%>									</td>
		<td>	<%=cliente%>								</td>
		<td>	<%=empleado%>								</td>
		<td>	<%=folio%>									</td>
		<td>   $<%=total%>									</td>
		<td>	<%= formatearFechaUsuario(new Date(fechacreacion)) %></td>
		<td>	<%= formatearFechaUsuario(new Date(fechafinal)) %></td>
		<td class="icon-operaciones">
			<span class="icon-restore span_restaurar"		data-toggle="tooltip" data-placement="top" title="Restaurar"></span>
			<span class="icon-circledelete span_borrar"	data-toggle="tooltip" data-placement="top" title="Borrar permanentemente"></span>
		</td>
	</script>
	<!-- plantillas para la edicion de contrato -->
		<script type="text/template" id="tds_servicio">
			<td style="padding:0px">
				<label class="label_servicio" for="servicio_<%= id %>"><%= nombre %></label>
				<div class="check_posicion">
					<input type="checkbox" id="servicio_<%= id %>" class="checkbox_servicio">
				</div>
			</td>
		</script>
		<script type="text/template" id="plantilla-formulario">
			<div class="row">
				<div class="col-lg-10 col-md-9 col-xs-8">
					<h3>Datos básicos</h3>
					<hr>
				</div>
				<div class="col-lg-2 col-md-3 col-xs-4" style="text-align:center;">
					<h3 id="h4_folio"></h3>
    				<input type="hidden" name="folio">
					<hr>
				</div>
				<div class="col-md-12">
					<span class="label label-info">Todos los campos son requeridos</span>
				</div>
			</div><!-- /.row -->
			<div class="row">
				<div class="col-md-4">
					<input type="text" id="serviciosolicitado" class="form-control" name="serviciosolicitado" placeholder="Servicio solicitado">			
				</div>
				<div class="col-md-4">
					<select id="select_firmaempleado" name="firmaempleado" placeholder="Firmará">
						<option value="enrique">Enrique</option>
						<option value="willian">William</option>
					</select>
				</div>
				<div class="col-md-4">
					<input type="text" id="fechaFirma" class="form-control datepicker" placeholder="Fecha de firmas">
					<input type="hidden" id="hidden_fechafirma" name="fechafirma">
				</div>
			</div><!-- /.row -->
			<div class="row">
				<div class="col-md-4">
					<select id="busqueda" placeholder="Buscar cliente" disabled></select>
					<input type="hidden" name="idcliente">
				</div>
				<div class="col-md-4">
					<input type="text" id="nombreRepresentante" class="form-control" disabled placeholder="Representante">
					<input type="hidden" id="idrepresentante" name="idrepresentante">
				</div>
				<div class="col-md-4">
					<div class="btn-group input-group" data-toggle="buttons">
						<span class="input-group-addon">Tipo de plan </span>
						<label class="btn btn-default">
							<input type="radio" class="btn_plan" name="plan" id="porEvento" value="evento" autocomplete="off"> Por Evento
						</label>
						<label class="btn btn-default">
							<input type="radio" class="btn_plan" name="plan" id="iguala" value="iguala" autocomplete="off"> Iguala Mensual
						</label>
					</div>
				</div>
				<input type="hidden" id="hidden_idEmpleado" name="idempleado" value="65"><!-- BOORAR CUANDO EXISTAN SESIONES -->
			</div><!-- /.row -->
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
										<div id="alert_anadirNuevioServicio" class="alert alert-info" role="alert">Enter para añadir...</div>
									</th>
								</tr>
							</thead>
							<tbody id="tbody_servicios">
								<!-- PLANTILLAS DE SERVICIOS -->
							</tbody>
					  	</table>
					</div>
					<hr>
					<select id="enunciado" name="enunciado" multiple placeholder="Seleccione o escriba los enunciados del contrato"></select>
				</div><!--/.col-md-4-->
				<div class="col-md-8" id="">
					<table class="table"> <!-- id="mostrarTabla" -->
						<thead style="background : #F9F9F9;"><!--comutadores-->
							<tr>
							<th colspan="6" style="min-width:200px;"><label><input class="todos" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Servicios a cotizar</label> <label style="float:right; margin-bottom: 0px;">Importe</label></th>
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
						<tbody style="background : #F9F9F9;"><!--comutadores-->
							<tr>
								<td><input type="text" class="form-control input-sm" style="visibility: hidden;"></td>
								<td><input type="text" class="form-control input-sm" style="visibility: hidden;"></td>
								<td style="text-align: right;">Total horas</td>
								<td><input type="text" class="form-control input-sm" id="totalHoras" value="0" disabled></td>
								<td><input type="text" class="form-control input-sm" style="visibility: hidden;"></td>
								<td><input type="text" class="form-control input-sm" style="visibility: hidden;"></td>
								<td class="iconos-operaciones">
									<!-- <span class=" icon-scaleup span_toggleAllSee" title="Abrir/Cerrar seleccionados"></span> -->
									<span class="icon-uniF4E5 span_toggleAllSee" title="Abrir/Cerrar seleccionados"></span>
									<span class="icon-circledelete span_deleteAll" title="Eliminar seleccionados"></span>
								</td>
							</tr>
						</tbody>
						<tbody> <!-- Separacion -->
							<tr>
								<td colspan="7"></td>
							</tr>
						</tbody>
						<thead id="thead_evento" class="thead_oculto" style="background-color: #f9f9f9!important;">
					    	<tr>
					    		<td colspan="7"><i>Datos para el contrato <b>por evento</b></i></td>
					    	</tr>
					    	<tr>
								<td colspan="7">
									<div class="row">
										<div class="col-md-3">
											<input id="fechaInicioEvento" class="form-control input-sm datepicker" type="text"  placeholder="Fecha inicio pagos">
											<!--<input type="hidden" class="fehcaInicioEvento" name="fechainicio">-->
										</div>
										<div class="col-md-3">
											<input type="number" id="plazo"  class="form-control input-sm" name="plazo" min="1" max="" placeholder="Plazo en días">	
										</div>
										<div class="col-md-3">
											<input type="number" class="form-control input-sm n_pagos" name="nplazos" min="1" max="" placeholder="Núm. de plazos">	
										</div>
										<div class="col-md-3">
											<input id="vencimientoPlanEvento" class="form-control input-sm datepicker" disabled type="text" placeholder="Vencimiento">
											<input id="fechafinalEvento" type="hidden">
										</div>							
									</div>
								</td>
					        </tr>
					        <tr>
					        	<td colspan="2">No. de Pago</td>
					        	<td colspan="2">Fecha de pago</td>
					        	<td colspan="2">Pago por plazo</td>
					        	<td style="text-align:right;">
					        		<button type="button" id="btn_recargarPagos" class="btn btn-default btn-xs"><span class="icon-refresh"></span></button>
					        	</td>
					        </tr>
						</thead>
						<thead id="thead_iguala" class="thead_oculto" style="background-color: #f9f9f9!important;">
					    	<tr>
					    		<td colspan="7"><i>Datos para el contrato <b>iguala mensual</b></i></td>
					    	</tr>
					    	<tr>
								<td colspan="7">
									<div class="row">
										<div class="col-md-4">
											<input id="fechaInicioIguala" class="form-control input-sm datepicker" type="text"  placeholder="Fecha inicio pagos">
											<!--<input type="hidden" class="fehcaInicioIguala" name="fechainicio">-->
										</div>
										<div class="col-md-4">
											<select class="form-control input-sm n_pagos" name="nplazos" placeholder="Mensualidades...">
											  <option value="1">1 Mes</option>
											  <option value="3">3 Meses</option>
											  <option value="6">6 Meses</option>
											  <option value="12">12 Meses</option>
											  <option value="18">18 meses</option>
											  <option value="24">24 meses</option>
											  <option value="48">48 meses</option>
											  <option style="display:none;" selected>Mensualidades...</option>
											</select>	
										</div>
										<div class="col-md-4">
											<input id="vencimientoPlanIguala" class="form-control input-sm datepicker" disabled type="text" placeholder="Vencimiento">
											<input id="fechafinalIguala" type="hidden">
										</div>									
									</div>
								</td>	       									          			         
					        </tr>
					        <tr>
								<td colspan="1">No. de Pago</td>
								<td colspan="3">Fecha de pago</td>
								<td colspan="3">Renta Mensual</td>
					        </tr>
						</thead>
						<tbody id="tbody_pagos_evento" class="tbody_oculto"></tbody>
						<tbody id="tbody_pagos_iguala" class="tbody_oculto"></tbody>
						<tbody> <!-- Separacion -->
							<tr>
								<td colspan="7">
									<!-- -->
								</td>
							</tr>
						</tbody>		
						<tfoot style="background : #F9F9F9;"><!--Precio/Hora - Subtotal-->
							<tr>
								<td></td>
								<td></td>
								<td style="text-align: right;">Precio/Hora</td>
								<td>
									<input type="number" class="form-control input-sm" id="precio_hora" name="preciohora" value="300" min="1">
								</td>
								<td> Subtotal </td>
								<td>
									<label id="label_subtotal">$0</label>
									<input type="text" class="form-control input-sm input-tfoot" id="subtotal" style="display:none;" value="0">
								</td>
								<td> </td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td> Descuento </td>
								<td style="position: relative;">
									<input type="number" name="descuento" class="form-control input-sm input-tfoot" value="0" min="0" max="100">
									<span class="icon-percent" style="position: absolute; top: 18px; left: 40px; font-size:10px;"></span>
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td> I.V.A. </td>
								<td style="position: relative;">
									<input type="number" class="form-control input-sm input-tfoot" value="16" disabled>
									<span class="icon-percent" style="position: absolute; top: 18px; left: 40px; font-size:10px;"></span>
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<td></td>
								<td><!--Descomentar para desarrollo. suma: <label id="suma">--></label></td>
								<td><!--Descomentar para desarrollo. totalReal: <label id="total">--></label></td>
								<td><!--Descomentar para desarrollo. diferencia: <label id="diferencia">--></label></td>
								<td> Total </td>
								<td>
									<label id="label_total">$0</label>
								</td>
								<td>
								</td>
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
								<div class="input-group input-group-sm">
									<span class="input-group-addon">$</span>
									<input type="text" class="form-control importe" name="importes" disabled>
								</div>
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
					<input type="hidden" name="horas" 		value="1">
					<!--<input type="hidden" name="precio_hora">-->
				</form>
			</td>
			<td><input type="text" 		id="seccion"		class="form-control input-sm" 			 	style="min-width:150px;">					</td>
			<td><textarea 				id="descripcion"	class="form-control" rows="3" 			 	style="min-width:150px;"></textarea>		</td>
			<td><input type="number" 	id=""				class="form-control input-sm number horas" 	 	min="1" value="1">						</td>
			<td><input type="number" 	id=""				class="form-control input-sm number precio_hora" style="visibility:hidden;"	 	min="1"></td>
			<td>
				<div class="input-group input-group-sm">
					<span class="input-group-addon">$</span>
					<input type="text" class="form-control costoSeccion" disabled>
				</div>
			</td>
			<td class="iconos-operaciones" style="border:0px;">
				<span class="icon-circledelete span_eliminar_seccion"></span>
			</td>
		</script>
	<script type="text/template" id="tr_pagos">
			<td colspan="2"><%- n %></td>
			<td colspan="2">
				<%- fecha %>
				<input type="hidden" name="fechapago" value="<%- fecha2 %>">
			</td>
			<td colspan="3">
				<div class="input-group input-group-sm">
					<span class="input-group-addon">$</span>
					<input type="number" id="<%- id %>" min="1" value="<%- pago %>" class="form-control <%- atrClase %>" <%- disabled %>>
					<input type="hidden" class="hidden_renta" name="pago" value="<%- pago %>">
					<span class="input-group-btn">
						<button class="btn btn-default <%= active %> <%= candado %>" type="button" <%- disabled %>></button>
					</span>
				</div>
			</td>
	</script>
	<!-- Plantillas de la consulta cotizaciones -->
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
		<td>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">$</span>
				<input type="text" class="form-control costoSeccion" disabled>
			</div>
		</td>
		<td class="iconos-operaciones" style="border:0px;">
			<span class="icon-circledelete span_eliminar_seccion"></span>
		</td>
	</script>
	<script type="text/template" id="li_version">
		<% _.each(versiones, function(version) { %>
			<% if (actual == version.version) { %>
				<li role="presentation">
					<a role="menuitem" tabindex="-1" href="#">
							<input type="radio" name="status" style="width:auto;" checked disabled>
							<b>Contrato <%= version.version %></b> <small class="label label-info">Actual</small>
						<!--<span id="<%= version.id %>" class="icon-trash span_papeleraVersion"	data-toggle="tooltip" data-placement="top" title="Papelera" style="font-size:13px;"></span>-->
						<!--<span id="<%= version.id %>" class="icon-preview span_vistaPreviaVersion"	data-toggle="tooltip" data-placement="top" title="Ver cotización" style="font-size:13px;"></span>-->
					</a>
				</li>
			<% } else{ %>
				<li role="presentation">
					<a role="menuitem" tabindex="-1" href="#">
						<label for="cotizacion<%= version.id %>" style="margin:0px;">
							<input type="radio" class="label_statusVersion" id="cotizacion<%= version.id %>" name="status" value="<%= version.id %>" style="width:auto;">
							Contrato <%= version.version %>
						</label>
						<span id="<%= version.id %>" class="icon-trash span_papeleraVersion"	data-toggle="tooltip" data-placement="top" title="Papelera" style="font-size:13px;"></span>
						<span id="<%= version.id %>" class="icon-preview span_vistaPreviaVersion"	data-toggle="tooltip" data-placement="top" title="Ver cotización" style="font-size:13px;"></span>
					</a>
				</li>
			<% }; %>
		 <% }); %>
	</script>
	<script type="text/template" id="plantilla-input-group-enunciado">
		<div class="input-group input-group-sm campo-enunciado">
			<textarea class="form-control" name="enunciado" placeholder="¿Que está comprando el cliente?"><%if (typeof enunciado != 'undefined') {%><%= enunciado %><%};%></textarea>
			<span class="input-group-btn">
				<button class="btn btn-default btn_quitarEnunciado" type="button">&ndash;</button>
				<button class="btn btn-default btn_anadirEnunciado" type="button">+</button>
			</span>
		</div><!-- /input-group -->
	</script>
<script type="text/javascript">
    var app = app || {};
    app.iva = 0.16;
    app.coleccionDeClientes     		= <?=json_encode($clientes) ?>;
    app.coleccionDeServicios    		= <?=json_encode($servicios) ?>;
    app.coleccionDeRepresentantes   	= <?=json_encode($representantes) ?>;
    app.coleccionDeContratos 			= <?=json_encode($contratos)?>;
    app.coleccionDeServiciosContrato 	= <?=json_encode($serviciosDeContrato)?>;
    app.coleccionDePagos 				= <?=json_encode($pagos)?>;
    app.coleccionDeEmpleados			= <?=json_encode($empleados)?>;
</script>
<?=
	// <!-- Utilerias -->
	    // <!-- plugins -->
	// <!-- Librerias Backbone -->
	    script_tag('js/backbone/lib/backbone.localStorage.js').
	    script_tag('js/numero-a-letras.js').
	// <!-- modelos -->
		script_tag('js/backbone/modelos/ModeloServicio.js').
	    script_tag('js/backbone/modelos/ModeloCliente.js').
		script_tag('js/backbone/modelos/ModeloEmpleado.js').
		script_tag('js/backbone/modelos/ModeloRepresentante.js').
	// <!-- colecciones -->
		script_tag('js/backbone/colecciones/ColeccionServicios.js').
	    script_tag('js/backbone/colecciones/ColeccionClientes.js').
		script_tag('js/backbone/colecciones/ColeccionEmpleados.js').
		script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
		// En la colección contratos están el modelo y coleccion de pagos
		script_tag('js/backbone/colecciones/ColeccionContratos.js');
?>
    <script type="text/javascript">
    	app.coleccionServiciosContrato 	= new ColeccionServiciosContrato(app.coleccionDeServiciosContrato);
        app.coleccionContratos 			= new ColeccionContratos(app.coleccionDeContratos.contratos);
        app.coleccionPagos 				= new ColeccionPagos(app.coleccionDePagos);
        app.coleccionEmpleados			= new ColeccionEmpleados(app.coleccionDeEmpleados);
		app.coleccionContratos_L = new ColeccionContratos_L();
    </script>
<!-- vistas -->
<?=	script_tag('js/backbone/vistas/VistaServicio.js').// <!-- Heredamos la clase VistaServicio -->
	script_tag('js/backbone/vistas/VistaNuevaCotizacion.js').
	script_tag('js/backbone/vistas/VistaConsultaCotizaciones.js').
	script_tag('js/backbone/vistas/VistaNuevoContrato.js').
	script_tag('js/backbone/vistas/VistaConsultaContratos.js');
?>
<script>
	app.contratos = new app.ContratosEliminadas();
</script>