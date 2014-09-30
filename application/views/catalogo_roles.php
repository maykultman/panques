		<section id="catalogo_roles">		    
		  	<h3>Nuevo Rol</h3>
		  	<hr><br>
		  	<div class="row">
		  		<form id="registro_rol">	  
			  		<div class="col-md-11">		  			      						
						<input id="rol" type="text" name="nombre" class="form-control" placeholder="Nombre del rol" style="width:100%;">			   
			  		</div>
			  		<div class="col-md-1">
						<button id="guardar" type="button" class="btn btn-primary"
						style="margin-top: 15px; margin-left: -15px;" >Guardar</button>
			       	    <!-- <button type="button" class="btn btn-default">Cancelar</button> -->   
			  		</div>
		  		</form>		  						
		  	</div><br>			
		    <h3>Roles</h3>
		  	<hr>	       
	        <input id="buscar_rol" type="search" class="form-control" placeholder="Search" style="width:100%; ">
	        <span id="busqueda_icono" class="glyphicon glyphicon-search"></span>
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
		<label name="<%- nombre %>"  class="ocultoR visibleR"><%- nombre %></label>
		<input id="erol" type="text" class="valor ocultoR" value="<%- nombre %>">
	</td>
	<td class="icon-operaciones">		
	<div class="eliminar_permiso">
		<span class="icon-trash" id="" data-toggle="tooltip" title="Eliminar"></span>
		<span class="icon-edit" id="" data-toggle="tooltip"  title="Editar"></span>				
	</div>
	</td>

</script>
<?=	script_tag('js/backbone/modelos/ModeloRol.js').
	script_tag('js/backbone/colecciones/ColeccionRoles.js').
	script_tag('js/backbone/vistas/VistaCatalogoRol.js');
?>