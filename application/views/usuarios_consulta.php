<section id="consultaDeUsuarios" style="padding:0% 2%;">
    <label style="padding:0% 2%;"><b id="cantidadDeUsuarios"></b></label>
	<hr style="margin-top: 0px;">
	<div class="panel-group" id="accordion" >
 		<!-- En Esta sección se renderiza la vista de usuario -->
	</div>
</section>

</div> 	<!-- Div General-->

<script type="text/plantilla" id="usuario">
	<div class='user-wrapper'>	
		<img class="img-circle" src="<?=base_url()?>{{foto}}" alt="Imagen-Usuario" width="85" height="85">
		<h4><b>{{usuario}} </b></h4>
	    <h6><b>{{perfil}}</b></h6> 
	    <div class="btn-group">       	
	      	<button data-url="<?=base_url()?>api_usuarios/" data-perfil="{{idperfil}}" class="delete btn btn-default">Eliminar</button>
	       	<button class="edit btn btn-default" data-toggle="modal" data-target="#myModal{{id}}">Editar</button>
	    </div>	        
	</div>
	<div id="edicion"></div>
</script>
<!-- Modal -->
<script type="text/plantilla" id="user">

<div  class="modal fade" id="myModal<%-id%>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <label>Editar Usuario</label>
      </div>
      <div class="modal-body">
      		<form id="edicionUsuario<%-id%>">      		
      		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	      		<span>Usuario</span>
				<input id="usuarioi" class="form-control" name="usuario" type="text" placeholder="Nombre del Usuario" value="<%-usuario%>">
			</div>	
			<div class="col-md-6 col-lg-6">							
				<span>Perfil</span>
				<select id="idperfil<%-id%>" name="idperfil" class="form-control" value="">									 
				</select>   
			</div>
			<div class="clearfix"></div><br><br>
				<ul id="moduloss" class="nav nav-tabs" role="tablist"></ul>
				<form id="arraypermisos" class="posiciontab">
					<div id="submoduloss" class="tab-content heightm"></div>
				</form>
	      		<br>		    	  	      						
				</form>
		    	<div class="btn-group"> 
		       		<button type="button" class="cancelar btn btn-default" data-dismiss="modal">Cancelar</button> 
		       		<button type="button" class="guardar btn btn-default">Guardar</button>
		    	</div>
	    	
    </div>
  </div>
</div>
</script>
<?php include "tpl-submodulos.php";?>

<script type="text/javascript">
	app.coleccionDeUsuarios  = <?=json_encode($usuarios) ?>;
	app.coleccionDeEmpleados = <?=json_encode($empleados)?>;
	app.coleccionDePermisos  = <?=json_encode($permisos) ?>;
	app.coleccionDePerfiles  = <?=json_encode($perfiles) ?>;

</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloUsuario.js'?>">          </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloEmpleado.js'?>">          </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPermiso.js'?>">          </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPerfiles.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionUsuarios.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPermisos.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionEmpleados.js'?>">  </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaUsuario.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaConsultaUsuario.js'?>">  </script>

