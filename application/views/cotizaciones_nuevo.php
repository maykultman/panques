<section class="container-fluid contenedor_principal_modulos">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-lg-10 col-md-9 col-xs-8">
					<h3>Datos básicos</h3>
					<hr>
				</div>
				<div class="col-lg-2 col-md-3 col-xs-4" style="text-align:center;">
					<h3 id="h4_folio"></h3>
					<hr>
				</div>
			</div>
			<form id="formPrincipal">
				
			</form>
		</div>
	</div>
	<div class="modal fade" id="modal-newClient">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Registro rápido de <b>prospecto</b></h4>
				</div>
				<form id="form-newClient" role="form">
					<input type="hidden" name="tipoCliente" value="prospecto">
					<input type="hidden" name="foto" value="img/sinfoto.png">
					<div class="modal-body">
						<p>
							<div class="form-group">
								<label for="nombreC">Nombre comercial <span class="label label-info">Requerido</span></label>
								<input type="text" class="form-control" id="nombreC" name="nombreComercial" onkeyup="textoObligatorio(this)" placeholder="Nombre comercial">
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="text" class="form-control" id="email" name="email" onkeyup="validarEmail(this)" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="telefono">Teléfono (de 10 a 20 dígitos)</label>
								<div class="row">
									<input type="hidden" name="tabla" value="clientes">
									<div class="col-xs-9">
										<input type="text" class="form-control" id="telefono" name="numero" onkeyup="validarTelefono(this)" placeholder="Teléfono">
									</div>
									<div class="col-xs-3">
										<select class="form-control" name="tipo">
											<option value="No definido" selected style="display:none;">Tipo</option><option value="Casa">Casa</option><option value="Fax">Fax</option><option value="Movil">Movil</option><option value="Oficina">Oficina</option><option value="Personal">Personal</option><option value="Trabajo">Trabajo</option><option value="Otro">Otro</option>
										</select>
									</div>
								</div>
							</div>
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" id="button_cancelClient" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" id="button_saveClient">Guardar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</section>
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
	<script type="text/template" id="plantilla-formulario">
		<div class="row">
			<div class="col-md-4">
				<input  type="text" id="titulo" class="form-control input_datos" name="titulo" placeholder="Título (Aparecerá en el PDF)">
				<input type="text" class="form-control" name="nombreversion" placeholder="Nombre de versión">
				<select id="busqueda" name="idcliente" placeholder="Buscar cliente..."></select>
				<!--<input  id="nombreRepresentante" type="text" class="form-control input_datos" placeholder="Representante" disabled="true">          -->
				<!--<input type="hidden" id="idrepresentante" class="input_datos" name="idrepresentante">-->
				<input type="hidden" name="folio">
				<input id="fecha"   type="text" name="fecha" class="form-control input_datos" disabled="true">
				<div class="btn-group input-group" data-toggle="buttons">
					<span class="input-group-addon">Tipo de plan </span>
					<label class="btn btn-default">
						<input type="radio" class="btn_plan" name="plan" value="evento" autocomplete="off"> Por Evento
					</label>
					<label class="btn btn-default">
						<input type="radio" class="btn_plan" name="plan" value="iguala" autocomplete="off"> Iguala Mensual
					</label>
				</div>
			</div>
			<div class="col-md-8">
				<textarea id="detalles" name="detalles" class="form-control input_datos" placeholder="Detalles" style="height: 180px;">Un título de crédito, también llamado título valor, es aquel "documento necesario para ejercer el derecho literal y autónomo expresado en el mismo"</textarea>
			</div>
			<!--<div class="col-md-4">
				<textarea id="caracteristicas" name="caracteristicas" class="form-control input_datos"  placeholder="Caracteristicas" style="height: 180px;">De las diversas clases de títulos de crédito ... Sección Segunda - De los títulos nominativos</textarea>
			</div>-->
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
			<div class="col-md-8" id="">
				<table class="table"> <!-- id="mostrarTabla" -->
					<thead style="background : #F9F9F9;">
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
					<tbody style="background : #F9F9F9;">
						<tr>
							<td colspan="3" style="min-width: 361px;"><label><input class="todos" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Servicios a cotizar</label></td>
							<td><input type="text" class="form-control input-sm" style="visibility: hidden;"></td>
							<td><input type="text" class="form-control input-sm" style="visibility: hidden;"></td>
							<td><input type="text" class="form-control input-sm" style="visibility: hidden;"></td>
							<td class="iconos-operaciones">
								<span class="icon-uniF4E5 span_toggleAllSee" title="Abrir/Cerrar seleccionados"></span>
								<span class="icon-circledelete span_deleteAll" title="Eliminar seleccionados"></span>
							</td>
						</tr>
					</tbody>
					<!--SEPARACION--><tbody><tr><td colspan="7" rowspan="" headers=""></td></tr></tbody>
					<thead class="thead_evento thead_visible thead_oculto" style="background : #F9F9F9;">
						<tr>
							<td></td>
							<td></td>
							<td style="text-align: right;">Total horas</td>
							<td><input type="text" class="form-control input-sm" id="totalHoras" value="0" disabled></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="number" class="form-control input-sm input-plan" name="npagos" value="1" min="1" style="visibility: hidden;"></td>
							<td style="text-align: right;">Precio/Hora</td>
							<td><input type="number" class="form-control input-sm" id="precio_hora" name="preciotiempo" value="300" min="1"></td>
							<td> Subtotal </td>
							<td>
								<label class="label_subtotal">$0</label>
								<input type="text" class="form-control input-sm input-tfoot" id="subtotal_evento" style="display:none;" value="0">
							</td>
							<td></td>
						</tr>
					</thead>
					<thead class="thead_iguala thead_visible thead_oculto" style="background : #F9F9F9;">
						<tr>
							<td style="text-align: right;">Precio/Mes</td>
							<td><input type="number" class="form-control input-sm input-plan" id="precio_mes" name="preciotiempo" value="3000" min="1"></td>
							<td style="text-align: right;"># de meses</td>
							<td><input type="number" class="form-control input-sm input-plan" name="npagos" value="1" min="1"></td>
							<td> Subtotal </td>
							<td>
								<label class="label_subtotal">$0</label>
							</td>
							<td></td>
						</tr>
					</thead>
					<!--SEPARACION--><tbody><tr><td colspan="7" rowspan="" headers=""></td></tr></tbody>
					<tfoot style="background : #F9F9F9;">
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
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td> I.V.A. </td>
							<td style="position: relative;">
								<input type="number" id="iva" class="form-control input-sm input-tfoot" value="16" disabled>
								<span class="icon-percent" style="position: absolute; top: 18px; left: 40px; font-size:10px;"></span>
							</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td> Total </td>
							<td>
								<label id="label_total">$0</label>
							</td>
							<td></td>
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
				<input type="hidden" name="horas"       value="1">
				<!--<input type="hidden" name="precio_hora">-->
			</form>
		</td>
		<td><input type="text"      id="seccion"        class="form-control input-sm"               style="min-width:150px;">                   </td>
		<td><textarea               id="descripcion"    class="form-control" rows="3"               style="min-width:150px;"></textarea>        </td>
		<td><input type="number"    id=""               class="form-control input-sm number horas"      min="1" value="1">                      </td>
		<td><input type="number"    id=""               class="form-control input-sm number precio_hora" style="visibility:hidden;"     min="1"></td>
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

<!-- Librerias -->
<?=
script_tag('js/backbone/app.js').
script_tag('js/backbone.localStorage.js');?>

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
	app.coleccionDeServicios          = <?php echo json_encode($servicios)          ?>;
	app.coleccionDeClientes           = <?php echo json_encode($clientes)           ?>;
	app.coleccionDeRepresentantes     = <?php echo json_encode($representantes)     ?>;
</script>
<?=
	// <!-- MVC -->
	script_tag('js/backbone/modelos/ModeloServicio.js').
	script_tag('js/backbone/modelos/ModeloServicioCotizado.js').
	script_tag('js/backbone/modelos/ModeloCliente.js').
	script_tag('js/backbone/modelos/ModeloRepresentante.js').

	script_tag('js/backbone/colecciones/ColeccionServicios.js').
	script_tag('js/backbone/colecciones/ColeccionCotizaciones.js').
	script_tag('js/backbone/colecciones/ColeccionServiciosCotizados.js').
	script_tag('js/backbone/colecciones/ColeccionClientes.js').
	script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
	script_tag('js/backbone/colecciones/ColeccionTelefonos.js').

	script_tag('js/backbone/vistas/VistaServicio.js').
	script_tag('js/backbone/vistas/VistaNuevaCotizacion.js');
?>

<script>
	app.coleccionCotizaciones = new ColeccionCotizaciones(app.coleccionDeCotizaciones);
	app.vistaNuevaCotizacion = new app.VistaNuevaCotizacion();
</script>