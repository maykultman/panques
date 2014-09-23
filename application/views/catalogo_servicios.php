		<?=	link_tag('css/estilos_catalogo_servicios.css').
			link_tag('css/theme.default.css');
		?>
		<section id="catalogo_servicio">			
			<h3>Nuevo Servicio</h3>
			<hr><br>
			<form id="formServicio">
				<div class="row">
					<div class="col-md-6">
						<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre">
						<input type="text" id="precio" name="precio" class="form-control" placeholder="Precio">
					</div>
					<div class="col-md-6">
						<input type="text" id="concepto" name="concepto" class="form-control" placeholder="Concepto">
						<input type="text" id="realizacion" name="realizacion" class="form-control" placeholder="Tiempo Estimado">
					</div>
				</div>				
				<div class="desborde"></div>
				<div class="row">
					<div class="col-md-12">
						<textarea id="descripcion" name="descripcion" class="form-control" placeholder="Descripción"></textarea>
					</div>
				</div>			
				<button id="enviar" style=";" type="button" class="btn btn-default">Guardar</button>
				<button id="btn_cancelar" type="button" class="btn btn-default">Cancelar</button>	
			</form><br>
			<h3>Servicios</h3>
			<hr><br>
			<div  id="consulta_servicios" class="wrapper">	
				<table id="consulta_tablaservicio" class="tablesorter table-striped" style="line-height: 3;">
					<thead>
						<tr>
							<th class="sorter-false">Todos <input type="checkbox" ></th>
							<th>Nombre</th>
							<th class="sorter-false" >Concepto</th>
							<th class="sorter-false" >Precio</th>
							<th class="sorter-false" >Realización</th>
							<th class="sorter-false">Descripción</th>						
							<th class="sorter-false">Opciones</th>
						</tr>	
					</thead>
					<tbody>							
					</tbody>					
				</table>
			</div><br>
			<button id="eliminar"  type="button" class="btn btn-danger">  Eliminar varios </button>			
		</section>
    </section>
</div>	
<!--Plantillas -->
<script type="text/plantilla" id="plantilla_servicio">

	<td><input type="checkbox"></td>
	<td style="width:17%"> <label class="oculto2 visible2"><%- nombre %></label><input type="text" name="nombre" value="<%- nombre %>" class="valor oculto2"> </td>
	<td style="width:18%;"> <label class="oculto2 visible2"><%- concepto %> </label><input type="text" name="concepto" value="<%- concepto %>" class="valor oculto2"></td>
	<td style="width:12%;"> <label class="oculto2 visible2"><%- precio %> </label><input type="text" name="precio" value="<%- precio %>" class="valor oculto2"> </td>
	<td style="width:12%;"> <label class="oculto2 visible2"><%- realizacion %> </label><input type="text" name="realizacion" value="<%- realizacion %>" class="valor oculto2"></td>
	<td><label  class="oculto2 visible2"><%- descripcion %> </label><input type="text" name="descripcion" value="<%- descripcion %>" class="valor oculto2"></td>
	 <!-- <td> <label class="oculto2 visible2"><%- masiva %> </label><input type="text" name="masiva" value="<%- masiva %>" class="oculto2"> -->
	 <td class="icon-operaciones">
		<div >
	     <span class="icon-trash eliminar2"   data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
	     <span class="icon-uniF756 editar2"   data-toggle="tooltip" data-placement="top" title="Editar"></span>
	    </div>
	</td>
 </script>
<!-- Utilerias -->
    <!-- <script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>-->
<!-- Librerias -->
<?=
	script_tag('js/backbone/lib/jquery.js').
	script_tag('js/backbone/lib/underscore.js').
	script_tag('js/backbone/lib/backbone.js');
?>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDeServicios = <?php echo json_encode($servicios) ?>;
</script>
<!--MV*-->
   	<!-- modelos -->
		<?=script_tag('js/backbone/modelos/ModeloServicio.js');?>

    <!-- colecciones -->
		<?=script_tag('js/backbone/colecciones/ColeccionServicios.js');?>

     <!-- Vistas -->
	<?=
		script_tag('js/backbone/vistas/VistaServicio.js').
		script_tag('js/backbone/vistas/VistaCatalogoServicio.js').
		script_tag('js/backbone/vistas/VistaConsultaServicios.js');
	?>
<script type="text/javascript">
	var app = app || {};
</script>
<!-- <script type="text/javascript" src="js/backbone/vista_servicio.js"></script> -->

<!-- Librerias para el thead fijo y  scroll de la tabla   -->
<?=
	script_tag('js/tablas/jquery-latest.min.js').
	script_tag('js/tablas/jquery.tablesorter.js').
	script_tag('js/tablas/jquery.tablesorter.widgets.js').
	script_tag('js/tablas/widget-cssStickyHeaders.js').
	script_tag('js/tablas/estilo_tabla.js');
?>

<!-- libreria para el theaad fijo de las tablas -->  
 