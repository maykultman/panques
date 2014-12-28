
		<section id="catalogoPuestos">	   
		  	<h3>Nuevo Puesto</h3>
			<hr><br>
			<div class="row">
				<form id="registroPuesto">     
					<div class="col-md-11">					   		
						<input id="puesto" type="text"  name="nombre" class="form-control" placeholder="Nombre del puesto" style="width:100% !important; display: inline-block;">											
		            </div>
		            <div class="col-md-1">
		            	<button id="guardar" type="button" class="btn btn-primary" style="margin-top: 15px; margin-left: -15px;">Guardar</button>  
		            </div>
		        </form>			
			</div><br>			
		    <h3>Lista de puestos</h3>
			<hr>
			<input id="buscar_puesto" type="search" class="form-control" placeholder="Busqueda" style="width:100%; ">
	        <span id="busqueda_icono" class="glyphicon glyphicon-search"></span>
	        <div class="panel panel-primary" >		     
		      <div class="panel-body" style="overflow: auto; height: 253px; padding: 0px !important;">
		        <table class="table table-hover" style="margin-bottom: 0px !important">
		  			<tbody id="scroll_puestos">																									
					</tbody>									
				</table>
		      </div>
		    </div>		  	       
		</section>			
     </section> <!--Esta fin de sección pertenece al menú principal del contenido de esta página. -->
</div>


<?=
	script_tag('js/backbone/app.js').
	script_tag('js/funcionescrm.js');
?>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDePuestos = <?php echo json_encode($puestos)  ?>;
</script>


<script type = "text/plantilla" id="listaPuestos">	
	<td>			
		<label name="<%- nombre %>"  class="visibleR"><%- nombre %></label>
		<input id="epuesto" type="text" class="valor ocultoR" value="<%- nombre %>">		
			
	</td>
	<td class="icon-operaciones text-right">		
		<span class="icon-trash" data-toggle="tooltip" title="Eliminar"></span>
		<span class="icon-edit"  data-toggle="tooltip"  title="Editar"></span>					
	</td>
</script>
<?=
//Librerias
	script_tag('js/backbone/modelos/ModeloPuesto.js').
	script_tag('js/backbone/colecciones/ColeccionPuestos.js').
	script_tag('js/backbone/vistas/VistaCatalogoPuestos.js');
?>
