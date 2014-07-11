<link rel="stylesheet" type="text/css" href="js/plugin/Gantt/css/style.css">
<script src="js/plugin/Gantt/js/jquery.fn.gantt.js"></script>
<h3><b> Cronograma de Proyectos </b></h3>
<div class="gantt">
	<!-- Contiene el diagrama de proyectos -->
</div>
<script type="text/javascript">
	var app = app || {};
	app.colecionDeClientes = <?=json_encode($clientes)?>;
	app.colecionDeProyectos = <?=json_encode($proyectos)?>;
</script>
<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloCliente.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloProyecto.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionClientes.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionProyectos.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaConsultaProyectos.js'?>"></script>

