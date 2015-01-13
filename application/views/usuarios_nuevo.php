   <style>
   #ajax{
		border: none;
		opacity: .2;
		width: 100px;
   }
   </style>
   <section id="datosUsuario"  style="padding: 0% 2%; margin-bottom:4%;">
		<h3 style="margin-bottom:-10px;">Nuevo Usuario</h3>
		<hr>
		<div class="col-md-5">			    
			<form id="registroUsuario">	 		
			   	<label class="btn btn-default fileinput-button">
			    <span class="icon-uniF580"></span><span> Foto</span>
			    <input type="file" id="fotou" name="logoUsuario">			                    				               
			    </label> 
			  	<img id="direccion" alt="Mi Foto" class="img-thumbnail" width="100">
				    	
			   	<br><br>		
			  	<select id="idempleado" class="selectized" placeholder="Buscar Empleado" name="idempleado" style="width:369px; height:34px;">
			  	</select> <br>
			  	<select id="idperfil" name="idperfil" class="form-control ancho_campos">
			  	<!-- Lista de Opciones de perfil  -->						  
				</select><br>

				<input type="text" id="usuario" name="usuario" class="form-control ancho_campos" placeholder="Usuario"><br>
				<input type="password" name ="contrasenia" class="form-control ancho_campos" id="contrasena" placeholder="Password"><br>
				<button id="guardar" type="button" class="btn btn-default">Guardar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			</form>	        		
		</div>
		
		<div id="areaform" class="col-md-7">
			<div class="todos">
			  	<input type="checkbox" id="idpermisos" class="btn_marcarTodos">Marcar todos los permisos
			</div>
		    <ul id="modulos" class="nav nav-tabs" role="tablist">
		      <!-- Menu de opciones-->
		    </ul>
		    <form id="arraypermisos" class="posiciontab">
		        <div id="submodulos" class="tab-content"></div>
		    </form>
		</div>	
    </section> 

    </section>
</div>


<script type="text/javascript">
	var app = app || {};
	app.coleccionDePerfiles  = <?php echo json_encode( $perfiles  ) ?>;
	app.coleccionDePermisos  = <?php echo json_encode( $permisos  ) ?>;	
	app.coleccionDeEmpleados = <?php echo json_encode( $empleados ) ?>;

</script>
<!-- MVC -->
<?php include 'tpl-submodulos.php';?>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPerfiles.js'?>">  		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPermiso.js'?>">          		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloUsuario.js'?>">          		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloEmpleado.js'?>">               </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPermisos.js'?>">  		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionUsuarios.js'?>">        </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionEmpleados.js'?>">       </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaNuevoUsuario.js'?>">	   		    </script>