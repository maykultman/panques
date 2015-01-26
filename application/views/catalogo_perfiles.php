
<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>" type="text/css">
      	<h3 class="titulo">Perfiles</h3>
	   	<button id="perfil_nuevo" class="btn btn-primary" data-toggle="modal" data-target="#nuevop">Nuevo Perfil
		</button>
		<hr style="margin-top: 0px !important">
			 <!-- Modal NUEVO PERFIL-->
            <div class="modal fade" id="nuevop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div id="contenido_nuevoperfil"  class="modal-content">
					    <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title">Nuevo Perfil</h4>
					    </div>					    
				        <div class="modal-body">
                           	<div style="display:inline-block"> 
                           		<input id="nombre1" name="nombre" type="search" class="form-control" placeholder="Nombre del perfil">
                           	</div>		            
						    <div class="btn-group" data-toggle="buttons">							    	
						        <button type="button" id="guardar" class="btn btn-default" data-dismiss="modal">Guardar</button>
						        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>						           
					        </div><div class="clearfix"></div>
					        <br>
					        <div class="todos">
					        	<input type="checkbox" id="idpermisos" class="btn_marcarTodos edperfil">Marcar todos los permisos
					        </div>
						    <div class="posiciontab">						      	
							    <ul id="modulos" class="nav nav-tabs" role="tablist">
							        <!-- Menu de opciones-->
							    </ul>
							    <form id="arraypermisos">
							       	<div id="submodulos" class="tab-content heightm"></div>
							    </form>
							</div>
				        </div>					       
		            </div>
		            <!-- /.modal-content -->
		        </div><!-- /.modal-dialog -->
	        </div><!-- /.modal -->
			

			<div id="perfiles"><!-- EN ESTA SECCION SE UBICA LA LISTA DE PERFILES --></div> 	              
            
            </div><!--row-->
        </div><!--container-->
    </section>
</div>
<script type="text/plantilla" id="permisos">
	<a href="#<%-modulo%>" role="tab" data-toggle="tab"><%- modulo %></a>
</script>

<script type="text/plantilla" id="divperfil">
	<div class="user-wrapper">
		<img class="img-circle" src="<?=base_url()?>/img/sinfoto.png" alt="Imagen-Usuario" width="85" height="85">
		<h4><b><%-nombre%> </b></h4>
	    <div class="btn-group">       	
	      	<button data-perfil="<%-id%>" data-url="<?=base_url()?>api_perfil/" class="delete btn btn-default">Eliminar</button>
	       	<button id="<%-id%>" class="edit btn btn-default" data-toggle="modal" data-target="#modaledicion<%-id%>">Editar</button> 
	    </div>
	</div>
<div id="edicion"></div>
</script>

<script type="text/plantilla" id="miperfil">
	<div class="modal fade" id="modaledicion<%-id%>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div id="contenido_nuevoperfil"  class="modal-content">
			    <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title">Editar Perfil</h4>
			    </div>					    
		        <div class="modal-body">
                         <div style="display:inline-block"> <input type="text" value="<%-nombre%>" class="form-control" placeholder="Nombre del perfil"></div>					            
				    <div class="btn-group" data-toggle="buttons">				            
				        <button id="save" type="button" class="btn btn-default" data-dismiss="modal">Guardar</button>
				        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>						           
			        </div><div class="clearfix"></div><br>
			        <div class="todos">
				      	<input type="checkbox" id="idpermisos" class="btn_marcarTodos"> Marcar todos los permisos
				    </div>
				    <div class="posiciontab">				    
				      	
					    <ul id="moduloss" class="nav nav-tabs" role="tablist">
					        <!-- Menu de opciones-->
					    </ul>
					    <form id="arraypermisos">
					       	<div id="submoduloss" class="tab-content heightm"></div>
					    </form>
					</div>
		        </div>	<!--modal body-->				       
		    </div> <!-- /.modal-content -->		         
		</div><!-- /.modal-dialog -->
	</div>
</script>
<?php include 'tpl-submodulos.php';?>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDePerfiles = <?php echo json_encode($perfiles) ?>;
	app.coleccionDePermisos = <?php echo json_encode($permisos) ?>;	
	
</script>
<?=
//<!-- MVC -->
	script_tag('js/backbone/modelos/ModeloPermiso.js').	
	script_tag('js/backbone/colecciones/ColeccionPerfiles.js').
	script_tag('js/backbone/colecciones/ColeccionPermisos.js').

	script_tag('js/backbone/vistas/VistaRenderizaPermiso.js').	  
	script_tag('js/backbone/vistas/VistaPerfil.js').	     
	script_tag('js/backbone/vistas/VistaNuevoPerfil.js').	
	script_tag('js/backbone/vistas/VistaConsultaPerfil.js');
?>