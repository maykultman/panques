		<section id="catalogo_roles">		    
		  	<h3>Nuevo Rol</h3>
		  	<hr>
		  	<div class="row">
		  		<form id="registro_rol">	  
			  		<div class="col-md-11">		  			      						
						<input id="rol" type="text" name="nombre" class="form-control" placeholder="Nombre del rol" style="width:100%;">			   
			  		</div>
			  		<div class="col-md-1">
						<button id="guardar" type="button" class="btn btn-primary">Guardar</button>			       	    
			  		</div>
		  		</form>		  						
		  	</div>
		    <h3>Roles</h3>
		  	<hr>	       
	        <input id="buscar_rol" type="search" class="form-control" placeholder="Search">
	        <span id="busqueda_icono" class="glyphicon glyphicon-search"></span><br>
	        <div class="panel panel-primary" >		     
		      <div class="panel-body" style="overflow: auto; height: 253px; padding: 0px !important;">
		        <table class="table table-hover" style="margin-bottom: 0px !important">
    				<tbody id="scroll_roles"></tbody>
				</table>
		      </div>
		    </div>            
		</section>
	</section>
<div>

<?=
	script_tag('js/backbone/app.js').
	script_tag('js/funcionescrm.js');
?>

<script type="text/javascript">
	var app = app || {};
	app.coleccionDeRoles = <?php echo json_encode($roles)  ?>;
</script>
<script type = "text/plantilla" id="listaRoles">	
	<td>			
		<label name="<%- nombre %>"  class="visibleR"><%- nombre %></label>
		<input id="erol" type="text" class="valor ocultoR" value="<%- nombre %>">
	</td>
	<td class="icon-operaciones text-right">		
		<span class="icon-trash" data-toggle="tooltip" title="Eliminar"></span>
		<span class="icon-edit"  data-toggle="tooltip"  title="Editar"></span>					
	</td>

</script>
<?=	script_tag('js/backbone/modelos/ModeloRol.js').
	script_tag('js/backbone/colecciones/ColeccionRoles.js').
	script_tag('js/backbone/vistas/VistaCatalogoRol.js');
?>