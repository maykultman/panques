	<section class="container-fluid contenedor_principal_modulos">
		<!-- <section class="secciones1"> -->
			<form id="formPrincipal">
		   	</form>
		<!-- </section>  -->
		<!-- <section class="secciones2" style="display:none">
			<h1>Vispre previa del contrato</h1> <button id="cerrar_vistaPrevia">Cerrar vista previa</button>
			<div id="divVistapreviaContrato">
			</div>
		</section>     -->	 
	</section><!-- /.contenedor_principal_modulos -->            
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
					<input type="text" id="prestacion" class="form-control" name="prestaciones" placeholder="Prestaciones">			
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
					<select id="busqueda" name="idcliente" placeholder="Buscar cliente"></select>
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
	<script type="text/javascript">
		// app = app || {};
		// var V_HojaContrato = Backbone.View.extend({
		// 	tagName			: 'div',
		// 	plantilla	: _.template($('#plantilla_contrato').html()),
		// 	render		: function () {
		// 		this.$el.html(this.plantilla(this.model.toJSON()));
		// 		return this;
		// 	}
		// });

		// var Consulta_Hoja	= Backbone.View.extend({
		// 	el	: '#divVistapreviaContrato',
		// 	initialize	: function () {
		// 		this.cargarContratos();
		// 	},
		// 	cargarContrato	: function (contrato) {
		// 		contrato.set({nombreCliente:app.coleccionClientes.get({id:contrato.get('idcliente')}).get('nombreComercial')});
		// 		contrato.set({nombreRepresentante:app.coleccionRepresentantes.get({id:contrato.get('idrepresentante')}).get('nombre')});

		// 		var precio = 0.0;
		// 		var descuento = 0.0;
		// 		var total = 0.0;

		// 		var cantidades = app.coleccionServiciosContrato_LocalStorage.pluck('cantidad');
		// 		var precios = app.coleccionServiciosContrato_LocalStorage.pluck('precio');
		// 		var descuentos = app.coleccionServiciosContrato_LocalStorage.pluck('descuento');

		// 		for (var i = 0; i < cantidades[0].length; i++) {
		// 			precio 		= cantidades[0][i] * precios[0][i];
		// 			descuento 	=precio * ( descuentos[0][i]/100 );
		// 			total 		+= parseFloat((precio - descuento).toFixed(2));
		// 		};
		// 		console.log((total + (total*app.iva)).toFixed(2));
		// 		contrato.set({total:(total + (total*app.iva)).toFixed(2)});
		// 		var vista = new V_HojaContrato({model:contrato});
		// 		this.$el.html(vista.render().el);
		// 	},
		// 	cargarContratos	: function () {
		// 		app.coleccionContratos_LocalStorage.each(this.cargarContrato, this);
		// 	}
		// });
	</script>
	<?=
		script_tag('js/backbone/vistas/VistaServicio.js').// <!-- Heredamos la clase VistaServicio -->
		script_tag('js/backbone/vistas/VistaNuevaCotizacion.js').
		script_tag('js/backbone/vistas/VistaNuevoContrato.js');
	?>

		<script type="text/javascript">
			app.vistaNuevoContrato = new app.VistaNuevoContrato();
		</script>
