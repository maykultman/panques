   <section id="datosUsuario">
		    <h3>Nuevo Usuario</h3>
		    <hr>	
		 	<div class="row">
		 		<form id="registroUsuario">	 		
				    <div class="col-md-4">		  		
					  	<select class="semp" name="menunombres" placeholder="Nombre">
                   		</select>  
					  	<input type="hidden" id="hempleado" name="idempleado" value="">
					  	
					  	<select id="idperfil" name="idperfil" class="form-control ancho_campos">
						  <!-- Lista de Opciones de perfil  -->
						  <option selected disabled>--Seleccione su Perfil--</option>
						</select>

						<input type="text" id="usuario" name="usuario" class="form-control ancho_campos" placeholder="Usuario">
				        <input type="password" name ="contrasenia" class="form-control ancho_campos" id="contrasena" placeholder="Password">
				        <label class="btn btn-success fileinput-button" style="float: left;">
			                    <span class="icon-paperclip"></span>
			                    <span>Adjuntar Foto</span>
			                       	<input type="file" id="foto" name="logoUsuario">			                    				               
			                </label><br><br>	              
				        <div id="btn_guardar">
				        	<button id="guardar" type="button" class="btn btn-default">Guardar</button>
					    	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        		</div>
				    </div>

				    <div class="col-md-8" style="background:#eaeaea; border:1px solid #eee; border-radius:4px; height:300px;">
				    	
				        <ul id="moduloss" class="nav nav-tabs" role="tablist">
				          <!--Menu de opciones-->
				        </ul>

				        <div id="submodulos" class="tab-content">

				        </div>
		      	
				    </div>	  
				  
				    
				</form>			    
	        </div>      
        </section> 
    </section>
</div>

<script type="text/plantilla" id="Permiasos">
	<input id='permiso_<%-id%>' name="idpermisos" value="<%-id%>" class="chek" type="checkbox" ><%- nombre %>	
</script>

<script type="text/plantilla" id="selectperfil">
	{{nombre}}
</script>

<script type="text/plantilla" id="permisos">

	<a href="#<%-modulo%>" role="tab" data-toggle="tab">  <%- modulo %>	</a>
</script>


<script type="text/plantilla" id="permisozs">
	
		<div id="togle" class="ui-widget-header"><h4><%- modulo %></h4></div>					  	
		<div id="effect" class="ui-widget-content" style="display:none;">
		dde
		</div>
	
</script>

<script type="text/javascript">
	var app = app || {};
	app.coleccionDePerfiles 	  = <?php echo json_encode( $perfiles        ) ?>;
	app.coleccionDePermisos 	  = <?php echo json_encode( $permisos        ) ?>;	
	app.coleccionDeEmpleados 	  = <?php echo json_encode( $empleados       ) ?>;

</script>
<!-- MVC -->
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPerfil.js'?>">          		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPermiso.js'?>">          		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloUsuario.js'?>">          		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloEmpleado.js'?>">               </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPerfiles.js'?>">  		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPermisos.js'?>">  		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionUsuarios.js'?>">        </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionEmpleados.js'?>">       </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaRenderizaPermiso.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaNuevoUsuario.js'?>">	   		    </script>
