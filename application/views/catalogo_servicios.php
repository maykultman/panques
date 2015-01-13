		<?=	link_tag('css/estilos_catalogo_servicios.css').
			link_tag('css/theme.default.css');
		?>
		<section id="catalogo_servicio">			
			<h3>Nuevo Servicio</h3>
			<hr><br>
			<form id="formServicio">
				<div class="row">
					<div class="col-md-6">
						<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre"><br>
						<input type="text" id="precio" name="precio" class="form-control" placeholder="Precio"><br>
					</div>
					<div class="col-md-6">
						<input type="text" id="concepto" name="concepto" class="form-control" placeholder="Concepto"><br>
						<input type="text" id="realizacion" name="realizacion" class="form-control" placeholder="Tiempo Estimado"><br>
					</div>
											
					<div class="col-md-12">
						<textarea id="descripcion" name="descripcion" class="form-control" placeholder="Descripción"></textarea>					
						<br>		
						<button id="enviar" style=";" type="button" class="btn btn-default">Guardar</button>
						<button id="btn_cancelar" type="button" class="btn btn-default">Cancelar</button>	
					</div>
				</div>
			</form><br>
			<h3>Servicios</h3>
			<hr><br>
			<div  id="" class="wrapper">	
				<table id="" class="tablesorter table-striped">
					<thead>
						<tr>
							<th class="sorter-false">Todos<input type="checkbox" class="todos"></th>
							<th>Nombre</th>
							<th class="sorter-false">Concepto</th>
							<th class="sorter-false">Precio</th>
							<th class="sorter-false">Realización</th>
							<th class="sorter-false">Descripción</th>						
							<th class="sorter-false">Opciones</th>
						</tr>	
					</thead>
					<tbody class="tbody-servicios">
					</tbody>					
				</table>
			</div><br>
			<button id="eliminar"  type="button" class="btn btn-danger">  Eliminar varios </button>			
		</section>
    </section>
</div>	
<!--Plantillas -->
<script type="text/plantilla" id="plantilla_servicio">
	<td><input type="checkbox" name="todos" value="<%= id %>"></td>
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
		script_tag('js/backbone/vistas/VistaConsultaServicios.js');
	?>
 