	    <link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>" type="text/css">	
	    <section id="datosUsuario">
		    <h3>Nuevo Usuario</h3>
		    <hr>	
		 	<div class="row">
		 		<form id="registroUsuario">	 		
				    <div class="col-md-4">		  		
					  	<input type="search" id="empleado" class="form-control ancho_campos" placeholder="Nombre empleado">
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
			                       	<input type="file" id="input_foto" name="fotoUsuario">			                    				               
			                </label><br><br>	              
				        <div id="btn_guardar">
				        	<button id="guardar" type="button" class="btn btn-primary">Guardar</button>
					    	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		        		</div>
				    </div>			  
				    <div class="col-md-8">	
					  	<div style="margin-top:15px;" class="panel panel-primary">	     
				            <div class="panel-heading">Asignar Permisos</div>	           
				        	<div id="ListaPermisos" class="row" style="margin-left:15px; margin-top:10px; margin-bottom:10px;">							  						  	
							  <!-- Lista de permisos -->
							</div>							   
				        </div>
		                <div class="btn-group" data-toggle="buttons">
							<label class="btn btn-default btn-xs">
								<input type="checkbox" id="idpermisos" class="btn_marcarTodos"> Marcar todos
							</label>
						</div>			
				    </div>
				    
				</form>			    
	        </div>      
        </section> 
    </section>
</div>

<script type="text/plantilla" id="Permisos">
	<input id='permiso_<%-id%>' name="idpermisos" value="<%-id%>" class="chek" type="checkbox" ><%- nombre %>	
</script>

<script type="text/plantilla" id="selectperfil">
	{{nombre}}
</script>

<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/autocompletes.js'?>"></script>

<!-- Librerias -->
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>">	</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>">		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/handlebars.js'?>">   </script>
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

<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaRenderizaPermiso.js'?>">	 			</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaNuevoUsuario.js'?>">	   		    </script>
