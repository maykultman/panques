	<section id="contenedor_principal_modulos" class="container-fluid" style="padding-left:4%;padding-right:3%;">
		<form id="formPrincipal">
		</form>
	</section><!-- /#contenedor_principal_modulos -->            
</div><!-- /.contenedor_modulo -->


<!-- plantillas -->
	<!-- Plantillas de cotizaciones -->
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
		<?php include('contratos/formulario.php'); ?>
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
							<td>Sección/Actividad</td>
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
			<td colspan="2">
				<div class="input-group input-group-sm">
					<span class="input-group-addon">$</span>
					<input type="number" id="<%- id %>" min="1" value="<%- pago %>" class="form-control <%- atrClase %>" <%- disabled %>>
					<input type="hidden" class="hidden_renta" name="pago" value="<%- pago %>">
					<span class="input-group-btn">
						<button class="btn btn-default <%= active %> <%= candado %>" type="button" <%- disabled %>></button>
					</span>
				</div>
			</td>
			<td></td>
	</script>
	<script type="text/template" id="plantilla_contrato">
		<!--fechacreacion: 			<%- formatearFechaUsuario(new Date(fechacreacion)) %>	<br>
		fechafinal: 			<%- formatearFechaUsuario(new Date(fechafinal)) %>		<br>
		fechafirma: 			<%- formatearFechaUsuario(new Date(fechafirma)) %>		<br>
		fechainicio: 			<%- formatearFechaUsuario(new Date(fechainicio)) %>		<br>
		id: 					<%- id %>												<br>
		idcliente: 				<%- idcliente %>										<br>
		idrepresentante: 		<%- idrepresentante %>									<br>
		nplazos: 				<%- nplazos %>											<br>
		plan: 					<%- plan %>												<br>
		plazo: 					<%- plazo %>											<br>
		nombreCliente: 			<%- nombreCliente %>									<br>
		nombreRepresentante: 	<%- nombreRepresentante %>								<br>
		nombrecontrato: 		<%- nombrecontrato %>									<br>
		total: 					<%- total %>											<br>
		pago mensual:			<%- (total/nplazos).toFixed(2) %>						<br>-->
	</script>
	<script type="text/template" id="plantilla-input-group-enunciado">
		<div class="input-group input-group-sm campo-enunciado">
			<textarea class="form-control" name="enunciado" placeholder="¿Que está comprando el cliente?"></textarea>
			<span class="input-group-btn">
				<button class="btn btn-default btn_quitarEnunciado" type="button">&ndash;</button>
				<button class="btn btn-default btn_anadirEnunciado" type="button">+</button>
			</span>
		</div><!-- /input-group -->
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
	app.coleccionDeClientes 		= <?= json_encode($clientes); ?>;
	app.coleccionDeServicios 		= <?= json_encode($servicios); ?>;
	app.coleccionDeRepresentantes 	= <?= json_encode($representantes); ?>;
</script>
<?=
// <!-- Utilerias -->
    script_tag('js/backbone/lib/backbone.localStorage.js').
    script_tag('js/numero-a-letras.js').
// <!-- modelos -->
	script_tag('js/backbone/modelos/ModeloCliente.js').
	script_tag('js/backbone/modelos/ModeloRepresentante.js').
	script_tag('js/backbone/modelos/ModeloServicio.js').
// <!-- colecciones -->
	script_tag('js/backbone/colecciones/ColeccionClientes.js').
	script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
	script_tag('js/backbone/colecciones/ColeccionServicios.js').
	// En la colección contratos están el modelo y coleccion de pagos
	script_tag('js/backbone/colecciones/ColeccionContratos.js');?>
	<script type="text/javascript">
		app.coleccionContratos = new ColeccionContratos();
		app.coleccionServiciosContrato = new ColeccionServiciosContrato();
		app.coleccionPagos = new ColeccionPagos();
		app.coleccionContratos_L = new ColeccionContratos_L();
	</script>
<!-- vistas -->
	<?=
		script_tag('js/backbone/vistas/VistaServicio.js').// <!-- Heredamos la clase VistaServicio -->
		script_tag('js/backbone/vistas/VistaNuevaCotizacion.js').
		script_tag('js/backbone/vistas/VistaNuevoContrato.js');
	?>

		<script type="text/javascript">
			app.vistaNuevoContrato = new app.VistaNuevoContrato();
		</script>
