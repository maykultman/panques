		<section id="catalogoPermisos">	   
		  	<h3>Nuevo Permiso</h3>
			<hr>
			<div class="row">
				<form id="registroPermiso">
					<div class="col-md-11">
						<input id="permiso" type="text"  name="nombre" class="form-control" placeholder="Nombre del permiso" style="width:100%;">
					<!-- <textarea id="comentario" name="comentario" class="form-control" rows="4" placeholder="Comentarios"></textarea> -->
					</div>
					<div class="col-md-1">						
							<button id="guardar" type="button" class="btn btn-primary" style="margin-top: 15px; margin-left:-15px;">Guardar</button>
				       	    <!-- <button type="button" class="btn btn-default">Cancelar</button> -->		            	
					</div>
				 </form>

			</div>		   

		    <h3>Lista de permisos</h3>
			<hr>
			<input id="buscar_permiso" type="search" class="form-control" placeholder="Busqueda" style="width:100%; ">
	        <span id="busqueda_icono" class="glyphicon glyphicon-search"></span>				
		  	
		  	<div class="panel panel-primary" >
		     
		      <div class="panel-body" style="overflow: auto; height: 253px; padding: 0px !important;">
		        <table class="table table-hover" style="margin-bottom: 0px !important">
		  			<tbody id="scroll_permisos">																									
					</tbody>									
				</table>
		      </div>
		    </div>		   
		</section>			
     </section> <!--Esta fin de sección pertenece al menú principal del contenido de esta página. -->
</div>
<?=script_tag('js/backbone/app.js');?>
<!-- Utilerias -->
<script type="text/javascript">
var app = app || {};
app.coleccionDePermisos = <?=json_encode($permisos)?>
</script>
<script type = "text/plantilla" id="listarPermisos">

	<td><label class="ocultoR visibleR" for="<%- id %>"><%- nombre %></label>
	<input id="epermiso" type="text" class="valor ocultoR" value="<%- nombre %>">
	</td>
	<td class="icon-operaciones">		
	<div class="eliminar_permiso">
		<span class="icon-trash" id="" data-toggle="tooltip" title="Eliminar"></span>
		<span class="icon-edit" id="" data-toggle="tooltip"  title="Editar"></span>				
	</div>
	</td>

</script>
<?=
	//MVC
	script_tag('js/backbone/colecciones/ColeccionPermisos.js').
	script_tag('js/backbone/vistas/VistaPermiso.js').		   
	script_tag('js/backbone/vistas/VistaNuevoPermiso.js');
?>		