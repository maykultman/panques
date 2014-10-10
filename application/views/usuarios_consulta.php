<section id="consultaDeUsuarios">
	 	    <label><b id="cantidadDeUsuarios"></b></label>
	 		<hr style="margin-top: 0px;">

	 		<div class="panel-group" id="accordion">
	 		<!-- En Esta sección se renderiza la vista de usuario -->
			</div>
			
			
	 </section>

</section>	
</div> 	<!-- Div General-->

<script type="text/plantilla" id="selectperfil">
	{{nombre}}
</script>

<script type="text/plantilla" id="Permisosz">
	<input id='permiso_{{id}}' class="chek" type="checkbox" name="idpermisos" value="{{id}}" {{palomita}}><p style='margin-left:10px'>{{ nombre }}</p>
</script>

<script type="text/plantilla" id="usuario">
	<center>
		<img class="img-circle" src="<?=base_url()?>{{foto}}" alt="Imagen-Usuario" width="85" height="85">
		<h4><b>{{usuario}} </b></h4>
	    <h6><b>{{perfil}}</b></h6> 
	    <div class="btn-group">       	
	      	<button class="delete btn btn-default">Eliminar</button>
	       	<button class="edit btn btn-default" data-toggle="modal" data-target="#myModal{{id}}">Editar</button>
	    </div>	    
	</center>
    
</script>
<!-- Modal -->
<script type="text/plantilla" id="edicion">

<div  class="modal fade" id="myModal{{id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <label>Editar Usuario</label>
      </div>
      <div class="modal-body">
      		<form id="edicionUsuario{{id}}">
	      		<label>Usuario</label>
					<input id="usuarioi" class="valor" name="usuario" type="text" placeholder="Nombre del Usuario" value="{{usuario}}">
					<div class="resp" style="display: table-cell"><!-- Indicador de modificación--></div>
							
					<label>Perfil</label>
					<select id="idperfil{{id}}" name="idperfil" class="valor" value="">									 
					</select>   

					<br>
					<ul id="modulos" class="nav nav-tabs" role="tablist">
					  <li class="active"><a href="#home" role="tab" data-toggle="tab">Clientes</a></li>
					  <li><a href="#profile" role="tab" data-toggle="tab">Proyectos</a></li>
					  <li><a href="#messages" role="tab" data-toggle="tab">Contratos</a></li>
					  <li><a href="#settings" role="tab" data-toggle="tab">Cotizaciones</a></li>
					  <li><a href="#settings" role="tab" data-toggle="tab">Actividades</a></li>
					  <li><a href="#settings" role="tab" data-toggle="tab">Catalógos</a></li>
					  <li><a href="#settings" role="tab" data-toggle="tab">Usuarios</a></li>
					  <li><a href="#settings" role="tab" data-toggle="tab">Configuraciones</a></li>
					</ul>


					<div class="tab-content">
					  <div class="tab-pane active" id="home">Este es el modulo de clientes</div>
					  <div class="tab-pane" id="profile">..sdfsdfsdfsd.</div>
					  <div class="tab-pane" id="messages">..sdfsdfsdf.</div>
					  <div class="tab-pane" id="settings">...sdfsdfsdfsdf</div>
					</div>
      				<br>
		    	  	      						
			</form>	<br>	
	    <div class="btn-group"> 
	       <button type="button" class="cancelar btn btn-default" data-dismiss="modal">Cancelar</button> 

	       <button type="button" class="guardar btn btn-default">Guardar</button>
	    </div>
    </div>
  </div>
</div>
</script>


<script type="text/javascript">
	app.coleccionDeUsuarios  = <?=json_encode($usuarios) ?>;
	app.coleccionDeEmpleados = <?=json_encode($empleados)?>;
	app.coleccionDePermisos  = <?=json_encode($permisos) ?>;
	app.coleccionDePerfiles  = <?=json_encode($perfiles) ?>;

</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPerfil.js'?>">          </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloUsuario.js'?>">          </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloEmpleado.js'?>">          </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPermiso.js'?>">          </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPerfiles.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionUsuarios.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPermisos.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionEmpleados.js'?>">  </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaUsuario.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaConsultaUsuario.js'?>">  </script>

