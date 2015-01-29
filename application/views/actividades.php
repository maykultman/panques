<div class="contenedor_modulo">
	<section>
		<h1 id="titulo_del_modulo"><label>Actividades</label></h1>
		<nav></nav>
	</section>
	<seccton id="contenedor_principal_modulos">
		<div class="container">
			<?php 
				if (isset($authUrl) && $authUrl) {
					// var_dump($authUrl);
					echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
				} else {
					echo "<a class='logout' href='salir'>Salir</a>";
				}
			?>
			<hr>
			<div class="row">
				<div class="col-md-3">
					<!-- <form action="" method="post" accept-charset="utf-8">
						<fieldset>
							<legend>Nuevo evento</legend>
							<div class="form-group">
								<input type="text" class="form-control input-lg" name="summary" value="" placeholder="Evento sin título">
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-6">
										De
										<input type="text" class="form-control input-sm" name="" value="" placeholder="">
									</div>
									<div class="col-xs-6">
										a
										<input type="text" class="form-control input-sm" name="" value="" placeholder="">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label for="">
										<input type="checkbox" name="" value="">
										Todo el día	
									</label>
								</div>
								<div class="checkbox">
									<label for="">
										<input type="checkbox" name="" value="" data-toggle="modal" data-target="#modalRepetir">
										Repetir...	
									</label>
									<div class="modal fade" id="modalRepetir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel">Modal title</h4>
												</div>
												<div class="modal-body">
													<div class="form-horizontal">
														<div class="form-group">
															<label for="" class="col-sm-2 control-label">Se repite</label>
															<select name="">
																<option value="">Cada día</option>
																<option value="">Todos los laborales (de lunes a viernes)</option>
																<option value="">Todos los lunes, miercoles y viernes</option>
																<option value="">Todos los martes y jueves</option>
																<option value="">Cada semana</option>
																<option value="">Cada mes</option>
																<option value="">Cada año</option>
															</select>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="button" class="btn btn-primary">Save changes</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<input type="text" class="form-control input-sm" name="location" value="" placeholder="Introduce una ubicación">
						</fieldset>
						<fieldset>
							<legend>información del evento</legend>
							<input type="text" name="" value="" placeholder="">
							<label for="">Creado por "alguien"</label>
							<textarea name=""></textarea>
						</fieldset>
						<fieldset>
							<legend>Añadir invitados</legend>
							<input type="text" name="" value="" placeholder="">
							<legend>Los invitados pueden</legend>
							<input type="checkbox" name="" value=""> Editar evento
							<input type="checkbox" name="" value=""> Invitar a otros
							<input type="checkbox" name="" value=""> Ver la lista de invitados
						</fieldset>
						<input type="submit" class="btn btn-primary" name="" value="Crear">
						<input type="reset" class="btn btn-default" name="" value="Cancelar">
					</form> -->
					<button id="getList" type="button">Obtener eventos</button>
				</div>
				<div class="col-md-9">
					<?php
						if ( isset($interface) && $interface ) {
							echo $interface;
						}
					?>
				</div>
			</div>
		</div>
	</seccton>
</div>
<?= script_tag('js/backbone/vistas/VistaActividades.js'); ?>