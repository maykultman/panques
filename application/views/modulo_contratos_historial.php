 <link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_contratos.css'?>" type="text/css">
 <div id="posicion_infotd">
    <table id="tbla_cliente" class="table table-striped">      
        <tr>
	        <th style="text-align:center;">Todos<br><input type="checkbox"></th>           
	    	<th>
				<input class="form-control" type="text" placeholder="Cliente">
				<span class="icon-search busqueda"></span>
	        </th>
	        <th>
				<input class="form-control" type="text" placeholder="Realizado por">
				<span class="icon-search busqueda"></span>
	        </th>
	        <th>
				<input class="form-control" type="text" placeholder="Fecha de realización">
				<span class="icon-search busqueda"></span>
	        </th>
	        <th>Vencimiento</th>  
	        <th>Operaciones</th>
        </tr>
        <tbody id="tbody_contratos"><!-- PLANTILLAS DE CONTRATOS --></tbody>
    </table>
    <button type="button" class="btn btn-danger">Eliminar varios</button>
    <button type="button" class="btn btn-default">Entregados</button>  
  </div>
</div>

<script type="text/javascript">
	function formatearFechaUsuario (fecha) {
		var fechaFormateada = '';
		if ((fecha.getDate()) < 10 )
		fechaFormateada = '0'+(fecha.getDate());
		else
			fechaFormateada = (fecha.getDate());
		if ((fecha.getMonth() +1) < 10 )
			fechaFormateada += '/0'+(fecha.getMonth() +1);
		else
			fechaFormateada +=  '/'+(fecha.getMonth() +1);

		fechaFormateada +=  '/'+fecha.getFullYear();

		return fechaFormateada;
	}
</script>

<script type="text/template" id="plantilla_tr_contrato">
	<td><input type="checkbox"></td>
	<td><%- nombreComercial %></td>
	<td>(sin sesiones)</td>                     
	<td><%- formatearFechaUsuario(new Date(fechacreacion)) %></td>
	<td><%- formatearFechaUsuario(new Date(fechafinal)) %></td>
	<td class="icon-operaciones">
		<div class="eliminar_cliente">
			<span id="eliminar" class="icon-trash"   data-toggle="tooltip" data-placement="top" title="Eliminar"></span> 
		</div>
		<span id="tr_btn_editar" class="icon-edit2" data-toggle="tooltip" data-placement="top" title="Editar"></span>               
		<span id="tr_btn_verInfo" class="icon-preview" data-toggle="modal" data-target="#modal<%- id %>" title="Ver contrato"></span>
		<span id="" class="icon-uniF7D5" data-toggle="modal" data-target="#modal<%- id %>" title="Descargar"></span>
	</td>
</script>
<script type="text/template" id="plantilla_modal">
	<div class="modal fade" id="modal<%- id %>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="panel panel-primary"><%- formatearFechaUsuario(new Date(fechacreacion)) %></div>
			<div class="panel-heading"><%- nombreComercial %><%- formatearFechaUsuario(new Date(fechafinal)) %></div>
		</div>
	</div>
</script>

<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type="text/javascript">
    var app = app || {};
    app.coleccionDeClientes     		= <?php echo json_encode($clientes) ?>;
    app.coleccionDeServicios    		= <?php echo json_encode($servicios) ?>;
    app.coleccionDeRepresentantes   	= <?php echo json_encode($representantes) ?>;
    app.coleccionDeContratos 			= <?=json_encode($contratos)?>;
    app.coleccionDeServiciosContrato 	= <?=json_encode($serviciosDeContrato)?>;
    app.coleccionDePagos 				= <?=json_encode($pagos)?>;
</script>
<!-- Utilerias -->
    <script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<!-- Librerias Backbone -->
    <script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>"></script>
<!-- modelos -->
    <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloCliente.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloRepresentante.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicio.js'?>"></script>
<!-- colecciones -->
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionClientes.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionRepresentantes.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServicios.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionContratos.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServiciosContrato.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPagos.js'?>"></script>
    <script type="text/javascript">
        app.coleccionContratos 			= new ColeccionContratos(app.coleccionDeContratos);
        app.coleccionServiciosContrato 	= new ColeccionServiciosContrato(app.coleccionDeServiciosContrato);
        app.coleccionPagos 				= new ColeccionPagos(app.coleccionDePagos);
    </script>
<!-- vistas -->
  <script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaServicio.js'?>"></script> <!-- Heredamos la clase VistaServicio -->
  <script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaConsultaContrato.js'?>"></script>