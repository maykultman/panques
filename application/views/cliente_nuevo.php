	<?=link_tag('css/estilos_modulo_clientes_nuevo.less')?>
	<div class="container">
		<section>
			<?php /*echo '<button id="toggle">Toggle</button>';*/ ?>
			<!-- REGISTRO DEL CLIENTE -->
			<div id="formularioCliente">
				<!-- <button type="button" id="ir" class="btn btn-default btn-xs">Conmutar</button> -->
				<!-- <h2>Registro para nuevo cliente</h2> -->
				<!-- <hr> -->
				<h3>Datos básicos</h3>
				<hr>
				<div class="form-group">
					<label for="">Tipo de cliente</label>
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default">
							<input type="radio" class="tipo_cliente" name="tipo_cliente" id="prospecto" value="prospecto"> Prospecto
						</label>
						<label class="btn btn-default">
							<input type="radio" class="tipo_cliente" name="tipo_cliente" id="cliente" value="cliente"> Cliente
						</label>
					</div>
					<span class="label label-info" style="width:19% !important;display:inline;">Requerido</span>
				</div>
				
				<div class="desborde"></div> 
				<div class="row">
					<div class="col-md-6">                
						<!-- <div class="input_info"> -->
							<div class="form-group">
								<label for="nombreComercial">Nombre comercial o persona</label>
								<input type="text" id="nombreComercial"  class="form-control form_input" placeholder="Nombre comercial / Persona" style="margin-bottom: 0px; width:80% !important;display:inline;"> <span class="label label-info" style="width:20% !important;display:inline;">Requerido</span>
							</div>
							<div class="form-group">
								<label for="nombreFiscal">Nombre fiscal</label>
								<input type="text" id="nombreFiscal" class="form-control form_input" placeholder="Nombre fiscal">
							</div>
							<div class="form-group">
								<label for="rfc">R.F.C.</label>
								<input type="text" id="rfc" class="form-control form_input" placeholder="RFC">
							</div>
							<div class="form-group">
								<label for="giro">Giro de la empresa</label>
								<select id="giro" class= "form-control form_input" > 
									<option value="" disabled style='display:none;'>Giro</option> 
									<option> Manufacturera </option> 
									<option> Agropecuaria </option> 
									<option> Comercial </option> 
									<option> Transporte </option> 
									<option> Educación </option> 
									<option> Servicios públicos </option>
									<option> Salud </option> 
									<option> Comunicación </option> 
									<option selected disabled>Giro</option>
								</select>
							</div>
								  
					   <!--  </div>    --> 
					</div>          
					<div class="col-md-6">
						<!-- <div class="input_info"> -->
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" id="email" class="form-control form_input" onkeyup="validarEmail(this)" placeholder="Email">
						</div>
						<div class="form-group">
							<label for="paginaCliente">Sitio web del cliente</label>
							<input type="text" id="paginaCliente"  class="form-control form_input" onkeyup="validarURL(this)" placeholder="Página web">
						</div>
						<div class="form-group">
							<label for="txtareaDireccion">Domicilio</label>
							<textarea id="txtareaDireccion" class="form-control form_input" rows="3" placeholder="Dirección" style="height: 34px !important;"></textarea>
						</div>
						<div class="form-group">
							<label for="">Teléfonos</label>
							<div class="telefonos">
							<div class="form-group div_telefono" style="display:block;">
								<div class="row">
									<div class="col-xs-4 col-sm-7">
										<input type="text" class="form-control telefonoCliente" name="numero" onkeyup="validarTelefono(this)" placeholder="Teléfono, de 10 a 20 dígitos">
									</div>
									<div class="col-xs-4 col-sm-3">
										<select class="form-control tipoTelefonoCliente" name="tipo">
											<option value="No definido" selected style="display:none;">Tipo</option><option value="Casa">Casa</option><option value="Fax">Fax</option><option value="Movil">Movil</option><option value="Oficina">Oficina</option><option value="Personal">Personal</option><option value="Trabajo">Trabajo</option><option value="Otro">Otro</option>
										</select>
									</div>
									<div class="col-xs-4 col-sm-2">
										<div class="btn-group" role="group" aria-label="...">
											<button type="button" class="btn btn-default eliminarCopia">&ndash;</button>
											<button type="button" class="btn btn-default otroTelefono">+</button>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>
						 <!-- </div>  -->               
					</div>
				</div>             
				<!-- <input type="text" class="form-control" placeholder="Telefono movil"> -->
				<!-- Este es el pequeño formulario para registrar teléfonos -->      
				<div class="desborde"></div><br>
				<div class="row">
					<div class="col-md-6">               
						<div class="form-group">
							<label for="">Servicios que le interesa el cliente</label>
							<select class="menuServicios"  name="serviciosInteres[]" multiple placeholder="Buscar servicios">
							</select>
						</div>
					</div>
					<div class="col-md-6">                
						<div class="form-group">
							<label for="">Servicios con los que cuenta el cliente</label>
							<select class="menuServicios"  name="serviciosCuenta[]" multiple placeholder="Buscar servicios">
							</select>
						</div>
					</div>
				</div>
				<br>
				<div class="form-group">
					<label for="logoCliente">Adjuntar logotipo del cliente</label>
					<form id="formularioFoto">
						<label class="btn btn-default fileinput-button">
							<span class="icon-paperclip"></span>
							<span>Adjuntar Logotipo</span>
							<input type="file" id="logoCliente" name="logoCliente">
						</label>
					</form>
					<img id="direccion" alt="foto del cliente" class="img-thumbnail" width="160" style="margin-top: 20px;">
				</div>
				<br>
				<div class="form-group">
					<label for="comentarioCliente">Comentarios</label>
			   		<textarea id="comentarioCliente" class="form-control" rows="5" placeholder=""></textarea>
				</div>
				<br><br>
				<button type="button" id="btn_crear" class="btn btn-primary">Guardar</button>
				<a id="btnCancelar_cliente" href="consulta_clientes" class="btn btn-default">Cancelar</a>

			</div>
			<!-- REGISTRO DEL CONTACTO -->
			<div id="formularioContacto">
				<!-- <button type="button" id="ir" class="btn btn-default btn-xs">Conmutar</button> -->
				<!-- <div id="div_nombreCliente"> -->
					<!-- <h2>Backbone</h2><h3>Registro para representante y contactos</h3> -->
				<!-- </div> -->
				<h3><span id="span_nombreCliente"></span> <small>Registro para representante y contactos</small></h3>
				<hr>
				<div class="row">
					<div class="col-md-6">
						<!-- <div class="dato_contacto"> -->
							<div><h3>Datos de Representante</h3></div>
							<hr>
							<div class="form-group">
								<label for="nombreRepresentante">Nombre completo</label>
								<input type="text" id="nombreRepresentante"  class="form-control form_input" placeholder="Nombre">
							</div>
							<div class="form-group">
								<label for="emailRepresentante">Email</label>
								<input type="text" id="emailRepresentante" class="form-control form_input" onkeyup="validarEmail(this)" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="cargoRepresentante">Cargo</label>
								<input type="text" id="cargoRepresentante" class="form-control form_input " placeholder="Cargo">
							</div>
							<div class="form-group">
								<label for="">Teléfonos</label>
								<div class="telefonos">
									<div class="form-group div_telefono" style="display:block;">
										<div class="row">
											<div class="col-xs-4 col-sm-7">
												<input type="text" class="form-control telefonoRepresentante" name="numero" onkeyup="validarTelefono(this)" placeholder="Teléfono, de 10 a 20 dígitos">
											</div>
											<div class="col-xs-4 col-sm-3">
												<select class="form-control tipoTelefonoRepresentante" name="tipo">
													<option value="No definido" selected style="display:none;">Tipo</option><option value="Casa">Casa</option><option value="Fax">Fax</option><option value="Movil">Movil</option><option value="Oficina">Oficina</option><option value="Personal">Personal</option><option value="Trabajo">Trabajo</option><option value="Otro">Otro</option>
												</select>
											</div>
											<div class="col-xs-4 col-sm-2">
												<div class="btn-group" role="group" aria-label="...">
													<button type="button" class="btn btn-default eliminarCopia">&ndash;</button>
													<button type="button" class="btn btn-default otroTelefono">+</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					   <!--  </div> -->
					</div>
					<div id="div_contactos" class="col-md-6">
						 <!-- <div class="dato_contacto" id="div_contactos" style="position:relative"> -->
							<div id="listaContactosCliente">
							<h3>Datos de contacto</h3><br><button id="btn_otroContacto" class="btn btn-default btn-sm" ><span class="icon-addfriend"></span></button>
							</div>
							<div class="desborde"></div>
							<hr>

							<div>
								<div class="tab-content">
									<!-- PLANTILLA FORMULARIO DE CONTACTO -->
								</div>
								<ul class="pagination pagination-ms">
									<!-- <li id="pagina1" class="active"><a href="#1" data-toggle="tab">1</a></li> -->
								</ul>
							</div>
						<!-- </div> -->
					</div>                
				</div>          
				<div class="desborde"></div>
				<br>
				<button id="btn_guardarContactos" class="btn btn-primary">Guardar</button>
				<a id="btnCancelar_contacto" href="consulta_clientes" class="btn btn-default">Cancelar</a>
				<!-- <a href="modulo_consulta_clientes" id="btn_nuevoContacto" class="btn btn-primary" role="button">Registrar Contactos</a> -->
				  <!-- visibleR ocultoR -->          
			</div>
		</section>
	</div>
</section>
</div>

<script type="text/javascript">
	app.coleccionDeClientes = <?=json_encode($clientes)?>;
	app.coleccionDeServicios = <?php echo json_encode($servicios) ?>;
</script>
<!-- Utilerias -->
	

<!-- Plantillas -->
	<script type="text/template" id="plantillaFormContacto">
		<div class="tab-pane active" id="<%- i %>">
			<button id="eliminar" class="btn btn-danger btn-sm" style="position:absolute; top: 20px; right: 60px;"><%- i %> <span class="icon-trash"></span></button>
			<div class="form-group">
				<label for="contactoNombre">Nombre completo</label>
				<input type="text" id="contactoNombre" class="form-control form_input" placeholder="Nombre">
			</div>
			<div class="form-group">
				<label for="contactoEmail">Email</label>
				<input type="text" id="contactoEmail" onkeyup="validarEmail(this)" class="form-control form_input" placeholder="Correo">
			</div>
			<div class="form-group">
				<label for="contactoCargo">Cargo</label>
				<input type="text" id="contactoCargo" class="form-control form_input" placeholder="Cargo">
			</div>
			<div class="form-group">
				<label for="">Teléfonos</label>
				<div class="telefonos">
					<div class="form-group div_telefono" style="display:block;">
						<div class="row">
							<div class="col-xs-4 col-sm-7">
								<input type="text" class="form-control telefonoContacto" name="numero" onkeyup="validarTelefono(this)" placeholder="Teléfono, de 10 a 20 dígitos">
							</div>
							<div class="col-xs-4 col-sm-3">
								<select class="form-control tipoTelefonoContacto" name="tipo">
									<option value="No definido" selected style="display:none;">Tipo</option><option value="Casa">Casa</option><option value="Fax">Fax</option><option value="Movil">Movil</option><option value="Oficina">Oficina</option><option value="Personal">Personal</option><option value="Trabajo">Trabajo</option><option value="Otro">Otro</option>
								</select>
							</div>
							<div class="col-xs-4 col-sm-2">
								<div class="btn-group" role="group" aria-label="...">
									<button type="button" class="btn btn-default eliminarCopia">&ndash;</button>
									<button type="button" class="btn btn-default otroTelefono">+</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>
<!-- Utilerias -->
	<?=
	//plugins
	script_tag('js/backbone/lib/backbone.localStorage.js').
	//MV*
	script_tag('js/backbone/modelos/ModeloContacto.js').
	script_tag('js/backbone/modelos/ModeloRepresentante.js').
	script_tag('js/backbone/modelos/ModeloCliente.js').	
	script_tag('js/backbone/modelos/ModeloServicio.js').
	script_tag('js/backbone/modelos/ModeloServicioCliente.js').
   
	script_tag('js/backbone/colecciones/ColeccionServicios.js').
	script_tag('js/backbone/colecciones/ColeccionTelefonos.js').
	script_tag('js/backbone/colecciones/ColeccionContactos.js').
	script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
	script_tag('js/backbone/colecciones/ColeccionClientes.js').
	script_tag('js/backbone/colecciones/ColeccionServicios.js').
	script_tag('js/backbone/colecciones/ColeccionServiciosClientes.js').

	script_tag('js/backbone/vistas/VistaTelefono.js').   
	script_tag('js/backbone/vistas/VistaServicio.js').
	script_tag('js/backbone/vistas/VistaNuevoCliente.js');
?>
