		<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>" 
          type="text/css">

        <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/collapse.js'?>">
        </script>
        <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/transition.js'?>">
        </script>
		<section id="catalogoPuestos">	   
		  	<h3>Nuevo Puesto</h3>
			<hr>
			<div class="row">
				<form id="registroPuesto">     
					<div class="col-md-11">					   		
						<input id="puesto" type="text"  name="nombre" class="form-control" placeholder="Nombre del puesto" style="width:100% !important; display: inline-block;">											
		            </div>
		            <div class="col-md-1">
		            	<button id="guardar" type="button" class="btn btn-primary" style="margin-top: 15px; margin-left: -15px;">Guardar</button>  
		            </div>
		        </form>			
			</div>			
		    <h3>Lista de puestos</h3>
			<hr>
			<input id="buscar_puesto" type="search" class="form-control" placeholder="Busqueda" style="width:100%; ">
	        <span id="busqueda_icono" class="glyphicon glyphicon-search"></span>
	        <div class="panel panel-primary" >		     
		      <div class="panel-body" style="overflow: auto; height: 211px; padding: 0px !important;">
		        <table class="table table-hover">
		  			<tbody id="scroll_puestos">																									
					</tbody>									
				</table>
		      </div>
		    </div>		  	       
		</section>			
     </section> <!--Esta fin de sección pertenece al menú principal del contenido de esta página. -->
</div>


<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDePuestos = <?php echo json_encode($puestos)  ?>;
</script>
<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<script type = "text/plantilla" id="listaPuestos">
	
	<td>			
		<label name="<%- nombre %>"  class="ocultoR visibleR"><%- nombre %></label>
		<input id="epuesto" type="text" class="valor ocultoR" value="<%- nombre %>">		
			
	</td>
	<td class="icon-operaciones">		
		<div class="eliminar_permiso">
			<span class="icon-trash" id="" data-toggle="tooltip" title="Eliminar"></span>
			<span class="icon-edit" id="" data-toggle="tooltip"  title="Editar"></span>			
		</div>
	</td>

</script>
<!-- Librerias -->
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>">	</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>">		</script>

<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPuesto.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPuestos.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaCatalogoPuestos.js'?>"></script>
