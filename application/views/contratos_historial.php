<?=
	script_tag('js/autocompletes.js').
	link_tag('css/estilos_modulo_contratos.css');
?>
	<div id="contenedor_principal_modulos" class="container-fluid" style="padding-left:4%;padding-right:3%;">
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
									<th class="sorter-false"></th>
								</tr>
							</thead>					
							<tbody id="tbody_contratos">
									<!-- Lista de las ultimas cotizaciones-->
								</tbody>		
							</table>
						</div>
						<button id="btn_eliminarVarios"  type="button" class="btn btn-danger">Eliminar varios</button>
					</div>
				</div>
		</section>
		<section id="section_actualizar">
			<div class="container">
				<br>
				<button type="button" class="btn btn-default btn_toggle">Regresar</button>
				<form id="formPrincipal">
			   	</form>
			</div>
		</section><!-- /.row -->
	</div>
</div><!-- /.contenedor_modulo -->
<!-- plantillas -->
	<script type="text/template" id="tds_contrato">
		<td><input type="checkbox" name="todos" value="<%= id %>" /></td>
		<td>	<%=serviciosolicitado%>									</td>
		<td>	<%=cliente%>								</td>
		<td>	<%=empleado%>								</td>
		<td>	<%=folio%>									</td>
		<td>   $<%=total%>									</td>
		<td>	<b><%= formatearFechaUsuario(new Date(fechacreacion)) %></td>
		<td>	<b><%= formatearFechaUsuario(new Date(fechafinal)) %></td>
		<td class="icon-operaciones">
			<span class="icon-trash span_papelera"		data-toggle="tooltip" data-placement="top" title="Papelera"></span>
			<span class="icon-preview span_vistaPrevia"	data-toggle="tooltip" data-placement="top" title="Ver contrato"></span>
			<span class="icon-uniF7D5"  				data-toggle="tooltip" data-placement="top" title="Descargar como PDF"></span>
			<span class="icon-redo span_editar" data-toggle="tooltip" data-placement="top" title="Renovar"><input type="hidden" value="<%= id %>"></span>
			<form><!-- no borrar -->
				<div class="dropdown">
					<span class="icon-uniF73E dropdown-toggle versione" id="versiones"		data-toggle="dropdown" data-placement="top" title="Versiones"></span>
					<ul id="ul-versiones" class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="versiones">
						<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Vacío</a></li>
						<!--<li role="presentation" class="divider"></li>-->
					</ul>
				</div>
			</form>
			<span class="icon-uniF4E7 span_pagos" data-toggle="modal" data-target=".bs-example-modal-sm<%= id %>" title="Pagos"></span>
		</td>
		<td>
			<div class="modal fade bs-example-modal-sm<%= id %> modal-pago" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h5 class="modal-title">Pagos pendientes y realizados</h5>
						</div>
						<div class="modal-body contenedor-pagos">
							
						</div>
					</div>
				</div>
			</div>
		</td>
	</script>
	<!-- plantillas para la edicion de cotizaciones (hacer include's de estas plantillas) -->
		<script type="text/template" id="tds_servicio">
			<td style="padding:0px">
				<label class="label_servicio" for="servicio_<%= id %>"><%= nombre %></label>
				<div class="check_posicion">
					<input type="checkbox" id="servicio_<%= id %>" class="checkbox_servicio">
				</div>
			</td>
		</script>
		<?php include('proyectos/plantillas/formulario.php'); ?>
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
								<div class="input-group input-group-sm input-group-importe">
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
				<div class="input-group input-group-sm input-group-constoSeccion">
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
					<%- fechatabla %>
					<input type="hidden" name="fechapago" value="<%- fechapago %>">
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
	<!-- plantillas para la edicion de contrato -->
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
		<td><input type="number" 	class="form-control input-sm number precio_hora" 						style="visibility:hidden;" min="1" 	value="<%= preciotiempo %>">	</td>
		<td>
			<div class="input-group input-group-sm input-group-constoSeccion">
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
	<script type="text/template" id="pago">
		<div class="content-fluid">
			<%if (status=='0' || status==false) {%>
				<div class="row">
			<%} else if (status=='1' || status==true) {%>
				<div class="row bg-success">
			<%};%>
				<div class="col-xs-6"><%= fechaAmigable(new Date(fechapago)) %></div>
				<div class="col-xs-4">$<%= conComas(Number(pago).toFixed(2)) %></div>
				<div class="col-xs-2">
					<%if (status=='0' || status==false) {%>
						<input type="checkbox" class="pagado">
					<%} else if (status=='1' || status==true) {%>
						<input type="checkbox" class="pagado" checked>
					<%};%>
				</div>
			</div>
		</div>
	</script>

<?=script_tag('js/backbone/app.js');?>
<script type="text/javascript">
	// font-family del folio
	WebFontConfig = {
		google: { families: [ 'Oswald::latin' ] }
	};
	(function() {
		var wf = document.createElement('script');
		wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
		'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		wf.type = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(wf, s);
	})();
	/*----------------------------------------------------------------------*/
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
		// script_tag('js/backbone/colecciones/ColeccionEmpleados.js').
		script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
		script_tag('js/backbone/colecciones/ColeccionUsuarios.js').
		// En la colección contratos están el modelo y coleccion de pagos
		script_tag('js/backbone/colecciones/ColeccionContratos.js');
?>
    <script type="text/javascript">
    	app.coleccionServiciosContrato 	= new ColeccionServiciosContrato(app.coleccionDeServiciosContrato);
        app.coleccionContratos 			= new ColeccionContratos(app.coleccionDeContratos.contratos);
        app.coleccionPagos 				= new ColeccionPagos(app.coleccionDePagos);
        // app.coleccionEmpleados			= new ColeccionEmpleados(app.coleccionDeEmpleados);
		app.coleccionContratos_L 		= new ColeccionContratos_L();
		app.coleccionUsuarios			= new ColeccionUsuarios();
    </script>
<!-- vistas -->
<?=	script_tag('js/backbone/vistas/VistaServicio.js').// <!-- Heredamos la clase VistaServicio -->
	script_tag('js/backbone/vistas/VistaNuevaCotizacion.js').
	script_tag('js/backbone/vistas/VistaConsultaCotizaciones.js').
	script_tag('js/backbone/vistas/VistaNuevoContrato.js').
	script_tag('js/backbone/vistas/VistaConsultaContratos.js');
?>
<script>
	var ajax = app.coleccionUsuarios.fetch();
	ajax.then(function () {
		app.contratos = new app.ContratosVisibles();
	},function () {});
</script>