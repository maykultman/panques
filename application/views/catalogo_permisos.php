		<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>" 
          type="text/css">

          <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/collapse.js'?>">
        </script>
        <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/transition.js'?>">
        </script>
		<section id="catalogoPermisos">	   
		  	<h3>Nuevo Permiso</h3>
			<hr>
			<form id="registroPermiso">
        		
					<input id="permiso" type="text"  name="nombre" class="form-control" placeholder="Nombre del permiso" style="width:85%; display: inline-block;">
					<!-- <textarea id="comentario" name="comentario" class="form-control" rows="4" placeholder="Comentarios"></textarea> -->
				
				<div style="display: inline-block;">
					<button id="guardar" type="button" class="btn btn-primary">Guardar</button>
		       	    <!-- <button type="button" class="btn btn-default">Cancelar</button> -->
	            </div>
		    </form>
		    <h3>Lista de permisos</h3>
			<hr>
			<input id="buscar_permiso" type="search" class="form-control" placeholder="Busqueda" style="width:100%; ">
	        <span id="busqueda_icono" class="glyphicon glyphicon-search"></span>  					
		  	<div class="panel panel-primary" style="width:100%;">
		  		<table class="table table-hover">
		  			<tbody id="scroll_permisos">																									
					</tbody>									
				</table>
			</div>	        
		</section>			
     </section> <!--Esta fin de sección pertenece al menú principal del contenido de esta página. -->
</div>
<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<!-- Utilerias -->
<script type="text/javascript">
var app = app || {};
app.coleccionDePermisos = <?=json_encode($permisos)?>
</script>
<script type = "text/plantilla" id="listarPermisos">

	<td style="width: 1200px; " class="icon-operaciones"><label class="ocultoR visibleR" for="<%- id %>"><%- nombre %></label>
	<input id="epermiso" type="text" class="valor ocultoR" value="<%- nombre %>">		
	<div class="eliminar_permiso">
		<span class="icon-trash" id="" data-toggle="tooltip" title="Eliminar"></span>
		<span class="icon-edit" id="" data-toggle="tooltip"  title="Editar"></span>										
	</div></td>

</script>

<!-- Librerias -->
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js' ?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'   ?>"></script>

<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<!-- MVC -->
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPermiso.js'	    ?>"> </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPermisos.js'?>"> </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaPermiso.js'		    ?>"> </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaNuevoPermiso.js'		?>"> </script>