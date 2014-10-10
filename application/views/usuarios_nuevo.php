   <?=script_tag('js/jquery-ui-1.10.4.custom.js');?>
   <section id="datosUsuario">
		    <h3>Nuevo Usuario</h3>
		    <hr>			    
		 	<div class="row">
		 		<form id="registroUsuario">	 		
				    <div class="col-md-4">		  		
					  	<select id="idempleado" class="selectized" name="idempleado">
                   		</select>  

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
				    </form>	
				    <div class="col-md-8" style="background:#eaeaea; border:1px solid #eee; width:600px; border-radius:4px; height:auto;">
				    	
				        <ul id="modulos" class="nav nav-tabs" role="tablist">
				          <!-- Menu de opciones-->
				        </ul>

				     <form id="arraypermisos">
				        <div id="submodulos" class="tab-content">
				        	
				        	
				        </div>
				    </form>
		      			
				    </div>	  
				  
				    
						    
	        </div>      
        </section> 
    </section>
</div>

<script type="text/plantilla" id="tsubmodulos">	
	
	<div class="tab-pane <% if(active!=undefined){ %> <%- active %> <% } %>" id="<%-modulo %>">
	<% var cont=0; for(i in submodulos){  cont++; %>
		<div id="toggle">
					<div class="tohead"><%- submodulos[i] %></div>
					<div id="<%-modulo%><%- submodulos[i] %>" class="ui-widget-content ui-corner-all conf" style="display:none;">
					
						<% if(submodulos[i]=='Nuevo'||submodulos[i]=='Cronograma'||submodulos[i]=='Usuarios'){%>
							<input name="<%-modulo%><%-submodulos[i]%>" value="1" class="chek" type="checkbox" >Acceso
						<%}else{%>

							<% if(submodulos[i]=='Papelera'){%>
								<input name="<%-modulo%><%-submodulos[i]%>" value="6" class="chek" type="checkbox" ><p>Restaurar</p>
								<input name="<%-modulo%><%-submodulos[i]%>" value="4" class="chek" type="checkbox" ><p>Eliminar</p>
							<%}%>

							<% if(submodulos[i]=='Prospectos'){%>								
								<input name="<%-modulo%><%-submodulos[i]%>" value="5" class="chek" type="checkbox" ><p>Pasar a Cliente</p>															
							<%}%>
														
						<%}%>
						<% if(	submodulos[i]=='Prospectos'||submodulos[i]=='Clientes'||
								submodulos[i]=='Proyectos'||submodulos[i]=='Cotizaciones'||
								submodulos[i]=='Contratos'
						){ %>
								<input name="<%-modulo%><%-submodulos[i]%>" value="2" class="chek" type="checkbox" ><p>Consultar</p>
								<input name="<%-modulo%><%-submodulos[i]%>" value="3" class="chek" type="checkbox" ><p>Editar</p>
								<input name="<%-modulo%><%-submodulos[i]%>" value="4" class="chek" type="checkbox" ><p>Eliminar</p>
						<%}%>

					
					</div>
				</div>
			<% } %>	
	
	</div>

</script>

<!-- <input name="idpermisos" value="" class="chek" type="checkbox" ><p>Imprimir</p>
							<input name="idpermisos" value="" class="chek" type="checkbox" ><p>Consultar</p>
							<input name="idpermisos" value="" class="chek" type="checkbox" ><p>Editar</p>
							<input name="idpermisos" value="" class="chek" type="checkbox" ><p>Eliminar</p> -->

<script type="text/plantilla" id="Permiasos">
	<input id='permiso_<%-id%>' name="idpermisos" value="<%-id%>" class="chek" type="checkbox" ><%- nombre %>	
</script>

<script type="text/plantilla" id="permisos">
	<a href="#<%-modulo%>" role="tab" data-toggle="tab">  <%- modulo %>	</a>
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

<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaNuevoUsuario.js'?>">	   		    </script>
