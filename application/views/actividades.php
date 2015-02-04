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
				<div class="col-md-4">
					<form id="form-nueva-actividad" action="" method="post" accept-charset="utf-8">
						<fieldset>
							<legend>Nuevo evento</legend>
							<div class="form-group">
								<input type="text" class="form-control input-lg" name="summary" value="Evento X" placeholder="Evento sin título">
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-6">
										De
										<input type="text" id="datepickerDe" class="form-control" name="start" value="" placeholder="">
									</div>
									<div class="col-xs-6">
										a
										<input type="text" id="datepickerA" class="form-control" name="end" value="" placeholder="">
									</div>
								</div>
								<div class="row">
									<div class="col-xs-1"></div>
									<div class="col-xs-5"><input type="time" class="form-control input-sm timepicker" name="" value="00:00"></div>
									<div class="col-xs-1"></div>
									<div class="col-xs-5"><input type="time" class="form-control input-sm timepicker" name="" value="01:00"></div>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" id="allDay" name="allDay"> Todo el día
									</label>
								</div>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="location" value="" placeholder="Introduce una ubicación">
							</div>
							<div class="form-group">
								<select id="invitados" name="attendees" multiple placeholder="Seleccione invitados">
								</select>
							</div>
							<div class="form-group">
								<textarea class="form-control" name="description" rows="5"></textarea>
							</div>
						</fieldset>
						<input id="crear" type="submit" class="btn btn-primary" value="Crear">
						<input type="reset" class="btn btn-default" name="" value="Cancelar">
					</form>
				</div>
				<div class="col-md-8">
					<div id="calendar"></div>
					<div id="loading"></div>
				</div>
			</div>
		</div>
	</seccton>
</div>
<?= 
	link_tag('js/plugin/fullcalendar/fullcalendar.min.css').
	link_tag('js/plugin/fullcalendar/fullcalendar.print.css').
	script_tag('js/plugin/fullcalendar/lib/moment.min.js').
	script_tag('js/plugin/fullcalendar/fullcalendar.min.js').
	script_tag('js/plugin/fullcalendar/lang-all.js').

	link_tag('js/plugin/timepicker/jquery.ui.timepicker.css').
	script_tag('js/plugin/timepicker/jquery.ui.timepicker.js').

	script_tag('js/backbone/modelos/ModeloCliente.js').
	script_tag('js/backbone/modelos/ModeloEmpleado.js').
	script_tag('js/backbone/colecciones/ColeccionClientes.js').
	script_tag('js/backbone/colecciones/ColeccionEmpleados.js').
	script_tag('js/backbone/colecciones/ColeccionActividades.js').
	script_tag('js/backbone/vistas/VistaActividades.js');
?>

<script type="text/javascript">
	app.coleccionClientes = new ColeccionClientes();
	app.coleccionEmpleados = new ColeccionEmpleados();
	app.coleccionActividades = new ColeccionActividades();
	app.vistaActividades = new app.VistaActividades();
</script>