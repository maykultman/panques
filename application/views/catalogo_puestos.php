<?php 
$activa_p = array();
function menu($arg, $perm)
{
	$resp=0;
	foreach ($arg as $key => $value) {
		if($value==$perm)
		{
			$resp = $value;
		}
	}
	return $resp;
}
if(isset($this->session->userdata('Catálogos')[1]['permisos']))
{
	$activa_p[0] = menu($this->session->userdata('Catálogos')[2]['permisos'], 1);
	$activa_p[1] = menu($this->session->userdata('Catálogos')[2]['permisos'], 2);
	$activa_p[2] = menu($this->session->userdata('Catálogos')[2]['permisos'], 3);
	$activa_p[3] = menu($this->session->userdata('Catálogos')[2]['permisos'], 4);
}
?>
	<section id="catalogoPuestos" class="container-fluid">	 
		<div class="row">  		  		
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h3>Nuevo Puesto</h3>
				<hr style="margin-left:0; width:100%;"><br>
				<form id="registroPuesto">     
					<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11" style="padding:0">					   		
						<input id="puesto" type="text"  name="nombre" class="form-control" placeholder="Nombre del puesto">											
			        </div><br class="visible-xs"><br class="visible-xs">
			        <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
			           	<button id="guardar" type="button" class="btn btn-primary">Guardar</button>  
			        </div>
			    </form>	
		    </div>				
			<br><br>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			    <h3>Lista de puestos</h3>
				<hr style="margin-left:0; width:100%;">
				<input id="buscar_puesto" type="search" class="form-control" placeholder="Busqueda">
		        <span id="busqueda_icono" class="glyphicon glyphicon-search"></span>
		        <br>
		        <div class="panel panel-primary" >		     
			      	<div class="panel-body" style="overflow: auto; height: 253px; padding: 0px !important;">
			        	<table class="table table-hover" data-column="all" style="margin-bottom: 0px !important; width:100%;">
			  				<tbody id="contenidotbody">																									
							</tbody>									
						</table>
			      	</div>
			    </div>	
			</div>
		</div>	  	       
	</section>			
</section> <!--Esta fin de sección pertenece al menú principal del contenido de esta página. -->
</div>
<!--  tablesorter table-striped -->

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
		<input id="epuesto" type="text" class="form-control ocultoR" value="<%- nombre %>">		
			
	</td>
	<td class="icon-operaciones text-right">		
		<?php if($activa_p[3]=='4'){?><span class="icon-trash" data-toggle="tooltip" title="Eliminar" data-set="<%-asignado%>"></span><?php } ?>
		<?php if($activa_p[2]=='3'){?><span class="icon-edit"  data-toggle="tooltip"  title="Editar"></span>					<?php } ?>
	</td>
</script>
<?=
//Librerias
	script_tag('js/backbone/modelos/ModeloPuesto.js').
	script_tag('js/backbone/colecciones/ColeccionPuestos.js').
	script_tag('js/backbone/vistas/VistaCatalogoPuestos.js');
?>