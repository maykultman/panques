        <link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>" 
          type="text/css">
        <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/collapse.js'?>">
        </script>
        <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/transition.js'?>">
        </script>
        <section>
	    	<h3 class="titulo">Perfiles</h3>
	    	<button id="perfil_nuevo" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Nuevo Perfil
			</button>
			<hr style="margin-top: 0px !important">


			<div style="margin-top:15px;" class="panel-group" id="accordion">
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
						            <button type="button" class="btn btn-primary">Guardar</button>
						            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						            
						            <div class="btn-group" data-toggle="buttons">
										<label class="btn btn-default btn-xs">
											<input type="checkbox" id="idpermiso" class="btn_marcarTodos"> Marcar todos
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



<script type="text/plantilla" id="Permisos">
		<% if (typeof palomita != 'undefined') { %>
			<input id='chekPermiso' name="idpermiso" value="<%-id%>" class="chek" type="checkbox" <%-palomita%> ><%- nombre %>
		<% } else{ %>
			<input id='chekPermiso' name="idpermiso" value="<%-id%>" class="chek" type="checkbox"><%- nombre %>
		<% }; %>
		
</script>

<script type="text/plantilla" id="Perfil">
<div class="panel panel-default">
	<div class="panel-heading">
	 	<a data-toggle="collapse" data-parent="#accordion" href="#collapse5<%-id%>">
		    <h4 class="panel-title">
	    		<b id="hperfil"> <%-nombre%></b>
				<span class=" icon-uniF48B flecha_abajo"></span> 
			</h4>	
		</a>
	</div>

	<div id="collapse5<%-id%>" class="panel-collapse collapse">
		<div id="<%-id%>" class="panel-body">
	   		<h4>Permisos</h4>				            
	   		<div id="ListaPermisos" class="row"> 

	   		</div>	
		</div>
	</div>
</div>	

</script>

<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>

<!-- Librerias -->
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>">	</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>">		</script>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDePerfiles = <?php echo json_encode($perfiles) ?>;
	app.coleccionDePermisos = <?php echo json_encode($permisos) ?>;	
	app.coleccionDePermisosPerfil = <?php echo json_encode($permisos_perfil) ?>;
</script>
<!-- MVC -->
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPerfil.js'?>">          		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPermiso.js'?>">          		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPermisoPerfil.js'?>">          </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPerfiles.js'?>">  		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPermisos.js'?>">  		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPermisosPerfil.js'?>">  </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaPerfil.js'?>">	         		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaNuevoPerfil.js'?>">	   			</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaConsultaPerfil.js'?>">	   		</script>