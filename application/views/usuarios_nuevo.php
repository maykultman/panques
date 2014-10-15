   <?=script_tag('js/jquery-ui-1.10.4.custom.js');?>
   <section id="datosUsuario">
		    <h3 style="margin-bottom:-10px;">Nuevo Usuario</h3>
		    <hr>			    
		 	<div class="row" style="margin-left:20px;">
		 		<form id="registroUsuario">	 		

				    <div class="col-md-5">		 
				    	<label class="btn btn-default fileinput-button">
			                    <span class="icon-uniF580"></span><span> Foto</span>
			                    <input type="file" id="fotou" name="logoUsuario">			                    				               
			            </label> 
				    	<img id="direccion" alt="Mi Foto" class="img-thumbnail" width="100" style="margin-top: 10px; margin-left:40px; border-radius:10px;">
				    	
				    	<br><br>		
					  	<select id="idempleado" class="selectized" placeholder="Buscar Empleado" name="idempleado" style="width:369px; height:34px;">
					  	</select>  

					  	<select id="idperfil" name="idperfil" class="form-control ancho_campos">
						  <!-- Lista de Opciones de perfil  -->						  
						</select>

						<input type="text" id="usuario" name="usuario" class="form-control ancho_campos" placeholder="Usuario">
				        <input type="password" name ="contrasenia" class="form-control ancho_campos" id="contrasena" placeholder="Password">
				        <button id="guardar" type="button" class="btn btn-default">Guardar</button>
					    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        		
				    </div>
				</form>	
				<div class="col-md-7 posiciontab">
				        <ul id="modulos" class="nav nav-tabs" role="tablist">
				          <!-- Menu de opciones-->
				        </ul>
				     <form id="arraypermisos">
				        <div id="submodulos" class="tab-content"></div>
				    </form>
				</div>	  
				   
	        </div>      
        </section> 
    </section>
</div>

<script type="text/plantilla" id="tsubmodulos">	
	
	<div class="tab-pane <% if(active!=undefined){ %> <%- active %> <% } %>" id="<%-modulo %>" >
	<% var cont=0; for(i in submodulos){  cont++; %>
		<div id="toggle">
					<div class="tohead">
						<div style="display:inline-bock; float:left; margin-left:20px"><%- submodulos[i]%></div>						
						<div id="fl" style="display:inline-bock; float:right; margin-right:15px; font-size:14px!important; margin-top:5px;">
							<span id="<%-submodulos[i]%>2" class="icon-circledown"></span>						
						</div>
						<div style="clear:both"></div>
					</div>
					<div id="<%-modulo%><%- submodulos[i] %>" class="ui-widget-content ui-corner-all conf" style="display:none;">
					
						<% if(submodulos[i]=='Nuevo'||submodulos[i]=='Cronograma'||submodulos[i]=='Usuarios'){%>
							<input id="1" name="<%-modulo%><%-submodulos[i]%>" value="1" class="chek" type="checkbox" >Acceso
						<%}else{%>

							<% if(submodulos[i]=='Papelera'){%>
								<input id="6" name="<%-modulo%><%-submodulos[i]%>" value="6" class="chek" type="checkbox" ><p>Restaurar</p>
								<input id="4" name="<%-modulo%><%-submodulos[i]%>" value="4" class="chek" type="checkbox" ><p>Eliminar</p>
							<%}%>

							<% if(submodulos[i]=='Prospectos'){%>								
								<input id="5" name="<%-modulo%><%-submodulos[i]%>" value="5" class="chek" type="checkbox" ><p>Pasar a Cliente</p>															
							<%}%>
														
						<%}%>
						<% if(	submodulos[i]=='Prospectos'	||	submodulos[i] == 'Clientes'		||
								submodulos[i]=='Proyectos'	||	submodulos[i] == 'Cotizaciones'	||
								submodulos[i]=='Contratos'	||	submodulos[i] == 'Empleados'	||
								submodulos[i]=='Perfiles'	||	submodulos[i] == 'Puestos'		||
								submodulos[i]=='Roles'		||	submodulos[i] == 'Servicios'	
						){ %>
								<input id="2" name="<%-modulo%><%-submodulos[i]%>" value="2" class="chek" type="checkbox" ><p>Consultar</p>
								<input id="3" name="<%-modulo%><%-submodulos[i]%>" value="3" class="chek" type="checkbox" ><p>Editar</p>
								<input id="4" name="<%-modulo%><%-submodulos[i]%>" value="4" class="chek" type="checkbox" ><p>Eliminar</p>
						<%}%>

					
					</div>
				</div>
			<% } %>	
	
	</div>

</script>


<script type="text/plantilla" id="permisos">
	<a href="#<%-modulo%>" role="tab" data-toggle="tab">  <%- modulo %>	</a>
</script>

<script type="text/javascript">
	var app = app || {};
	app.coleccionDePerfiles  = <?php echo json_encode( $perfiles  ) ?>;
	app.coleccionDePermisos  = <?php echo json_encode( $permisos  ) ?>;	
	app.coleccionDeEmpleados = <?php echo json_encode( $empleados ) ?>;

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
