<style type="text/css">
	.btn-delete{
		position: absolute;
		bottom: 20px;
		right: 20px;
	}
	.fc-event-container {
		cursor:pointer;
	}
</style>
<div class="contenedor_modulo">
	<section>
		<h1 id="titulo_del_modulo"><label>Actividades</label></h1>
		<nav></nav>
	</section>
	<seccton id="contenedor_principal_modulos">
		<div class="container">
			<?php 
				/*Descomentar si se requiere un control manual para acceder a los datos
				de google calendar, hay una descripcion en el controlador escritorio, en
				la funcion actividades para saber que hacer.*/
				// if (isset($authUrl) && $authUrl) {
				// 	// var_dump($authUrl);
				// 	echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
				// } else {
				// 	echo "<a class='logout' href='salir'>Salir</a>";
				// }
			?>
			<div class="row" id="div-form-and-div-calendar">
				<div class="col-md-4" id="div-new-event">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Nuevo Evento</h3>
						</div>
						<div class="panel-body">
							<?php include('actividades/template-form-event.php'); ?>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-body">
							<div id="calendar"></div>
							<div id="loading"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</seccton>
</div>

<script type="text/template" id="form-event-update-template">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Actualizar Evento</h4>
				</div>
				<div class="modal-body">
					<?php include('actividades/template-form-event.php'); ?>
					<button type="button" id="eliminar" class="btn btn-danger btn-delete" title="Elimina el evento totalmente">
						Borrar
						<!-- <span class="icon-trash"></span> -->
					</button>
				</div>
				<div class="modal-footer text-muted">
					<small>
						<b>Datos de Google Calendar</b><br>
						<div class="google-info"></div>
					</small>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
</script>

<?= 
	link_tag('js/plugin/fullcalendar/fullcalendar.min.css').
	// link_tag('js/plugin/fullcalendar/fullcalendar.print.css').
	script_tag('js/plugin/fullcalendar/moment.min.js').
	script_tag('js/plugin/fullcalendar/fullcalendar.min.js').
	script_tag('js/plugin/fullcalendar/es.js').

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
	var expire_in = <%?= $expire_in; %>;
	app.coleccionClientes = new ColeccionClientes();
	app.coleccionEmpleados = new ColeccionEmpleados();
	app.coleccionActividades = new ColeccionActividades();
	app.vistaActividades = new app.VistaActividades();
</script>