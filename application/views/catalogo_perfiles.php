<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>" type="text/css">
    <section>
	    	<h3 class="titulo">Perfiles</h3>
	    	<button id="perfil_nuevo" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Nuevo Perfil
			</button>
			<hr style="margin-top: 0px !important">


			<div style="margin-top:15px;" id="accordion">
				<div id="unperfil">
					<!-- EN ESTA SECCION SE UBICA LA LISTA DE PERFILES -->
				</div> 
            </div>

            <!-- Modal NUEVO PERFIL-->
            <div  class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"        
			 aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">

					<div id="contenido_nuevoperfil"  class="modal-content">
					    <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title">Nuevo Perfil</h4>
					    </div>					    
				        <div class="modal-body">
                            <form id="registroPerfil">
					            <input id="nombre" name="nombre" type="search" class="form-control" placeholder="Nombre del perfil"><br>
					            <div style="width:850px;" class="panel panel-primary permisos">  
						            <div class="panel-heading">Asignar Permisos</div>           
					            	
					            	<div id="ListaPermisos" class="row">										
										<!--Fin de la lista de permisos	 -->  	 
									</div> 																   
						    	
						    	</div>
					            <div id="btnes">				            
						            <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
						            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						            
						            <div class="btn-group" data-toggle="buttons">
										<label class="btn btn-default btn-xs">
											<input type="checkbox" id="idpermisos" class="btn_marcarTodos"> Marcar todos
										</label>
									</div>
					            </div>
					        </form>    
				        </div>					       
		            </div>
		            <!-- /.modal-content -->


		        </div><!-- /.modal-dialog -->
	        </div><!-- /.modal -->
        </section>    
    </section>
</div>

<!-- <button id="<%-id%>" class="edit btn btn-default" data-toggle="modal" data-target="#myModal<%-id%>">Editar</button> -->
<script type="text/plantilla" id="divperfil">
<article style="float:left;">
<div class="user-wrapper">
	<center>
		<img class="img-circle" src="<?=base_url()?>/img/sinfoto.png" alt="Imagen-Usuario" width="85" height="85">
		<h4><b><%-nombre%> </b></h4>
	    <div class="btn-group">       	
	      	<button id="<%-id%>" class="delete btn btn-default">Eliminar</button>
	       	<button id="<%-id%>" class="edit btn btn-default">Editar</button>
	    </div>	    
	</center>
	<div id="verpermisos<%-id%>" style="display:none;">holaadsfasdfsdf</div>
</div>

</article>
</script>

<script type="text/plantilla" id="Permisos">		
	<input id='permiso_<%- id %>' name="idpermisos" value="<%-id%>" class="chek" type="checkbox"><%- nombre %>	
</script>


<script type="text/javascript">
	var app = app || {};
	app.coleccionDePerfiles = <?php echo json_encode($perfiles) ?>;
	app.coleccionDePermisos = <?php echo json_encode($permisos) ?>;	
	
</script>
<?=
//<!-- MVC -->
	script_tag('js/backbone/modelos/ModeloPerfil.js').
	script_tag('js/backbone/modelos/ModeloPermiso.js').
	
	script_tag('js/backbone/colecciones/ColeccionPerfiles.js').
	script_tag('js/backbone/colecciones/ColeccionPermisos.js').

	script_tag('js/backbone/vistas/VistaRenderizaPermiso.js').	  
	script_tag('js/backbone/vistas/VistaPerfil.js').	     
	script_tag('js/backbone/vistas/VistaNuevoPerfil.js').	
	script_tag('js/backbone/vistas/VistaConsultaPerfil.js');
?>