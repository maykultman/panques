<section id="catalogo_roles" class="container-fluid">		    
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
	  		<h3>Nuevo Rol</h3>
	  		<hr style="margin-left:0; width:100%;"><br>
			<form id="registro_rol">	  
		  		<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11" style="padding:0">					   		
					<input id="rol" type="text" name="nombre" class="form-control" placeholder="Nombre del rol" style="width:100%;">			   
	  			</div><br class="visible-xs"><br class="visible-xs">
				<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
					<button id="guardar" type="button" class="btn btn-primary">Guardar</button>			       	    
				</div>
			</form>		  						
		</div>
		<br><br>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		    <h3>Roles</h3>
		  	<hr style="margin-left:0; width:100%;">	       
	        <input id="buscar_rol" type="search" class="form-control" placeholder="Search">
	        <span id="busqueda_icono" class="glyphicon glyphicon-search"></span><br>
	        <br>
	        <div class="panel panel-primary" >		     
		      <div class="panel-body" style="overflow: auto; height: 253px; padding: 0px !important;">
		        <table class="table table-hover" style="margin-bottom: 0px !important">
    				<tbody id="contenidotbody"></tbody>
				</table>
		      </div>
		    </div>
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
		<input id="erol" type="text" class="form-control ocultoR" value="<%- nombre %>">
	</td>
	<td class="icon-operaciones text-right">		
		<span class="icon-trash" data-toggle="tooltip"  title="Eliminar" data-set="<%-asignado%>"></span>
		<span class="icon-edit"  data-toggle="tooltip"  title="Editar"></span>					
	</td>

</script>
<?=	script_tag('js/backbone/modelos/ModeloRol.js').
	script_tag('js/backbone/colecciones/ColeccionRoles.js').
	script_tag('js/backbone/vistas/VistaCatalogoRol.js');
?>