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
				if (isset($authUrl) && $authUrl) {
					// var_dump($authUrl);
					echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
				} else {
					echo "<a class='logout' href='salir'>Salir</a>";
				}
			?>
			<hr>
			<div class="row" id="div-form-and-calendar">
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
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Actualizar Evento</h4>
					</div>
					<div class="modal-body">
						<?php include('actividades/template-form-event.php'); ?>
						<button type="button" class="btn btn-danger btn-delete" title="Elimina el evento totalmente">
							Borrar
							<!-- <span class="icon-trash"></span> -->
						</button>
					</div>
					<!-- <div class="modal-footer"></div> -->
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</seccton>
</div>

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
	app.coleccionClientes = new ColeccionClientes();
	app.coleccionEmpleados = new ColeccionEmpleados();
	app.coleccionActividades = new ColeccionActividades();
	app.vistaActividades = new app.VistaActividades();
</script>