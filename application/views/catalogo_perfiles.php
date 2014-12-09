<?= script_tag('css/bootstrap-3.1.1-dist/js/modal.js'); ?>
<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>" type="text/css">
    <section>
	    	<h3 class="titulo">Perfiles</h3>
	    	<button id="perfil_nuevo" class="btn btn-primary" data-toggle="modal" data-target=".fade">Nuevo Perfil
			</button>
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
                           	<input id="nombre1" name="nombre" type="search" class="form-control" placeholder="Nombre del perfil"></div>					            
						    <div class="btn-group" data-toggle="buttons">				            
						        <button type="button" id="guardar" class="btn btn-default" data-dismiss="modal">Guardar</button>
						        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>						           
					        </div>
						    <div class="posiciontab" style="margin-top:10px;">
						      	<input type="checkbox" id="idpermisos" class="btn_marcarTodos"> Marcar todos los permisos
							    <ul id="modulos" class="nav nav-tabs" role="tablist">
							        <!-- Menu de opciones-->
							    </ul>
							    <form id="arraypermisos">
							       	<div id="submodulos" class="tab-content"></div>
							    </form>
							</div>
				        </div>					       
		            </div>
		            <!-- /.modal-content -->
		        </div><!-- /.modal-dialog -->
	        </div><!-- /.modal -->
			<hr style="margin-top: 0px !important">


			<div style="margin-top:15px;" id="misperfiles">
				<div id="perfiles">
					<!-- EN ESTA SECCION SE UBICA LA LISTA DE PERFILES -->
				</div> 	
            </div>

        </section>    
    </section>
</div>
<script type="text/plantilla" id="permisos">
	<a href="#<%-modulo%>" role="tab" data-toggle="tab">  <%- modulo %>	</a>
</script>

<script type="text/plantilla" id="divperfil">
<div class="user-wrapper">
	<center>
		<img class="img-circle" src="<?=base_url()?>/img/sinfoto.png" alt="Imagen-Usuario" width="85" height="85">
		<h4><b><%-nombre%> </b></h4>
	    <div class="btn-group">       	
	      	<button class="delete btn btn-default">Eliminar</button>
	       	<button class="edit btn btn-default" data-toggle="modal" data-target="#modaledicion<%-id%>">Editar</button> 
	    </div>	    
	</center>
</div>
<div id="edicion"></div>
</script>

<script type="text/plantilla" id="miperfil">
	<div class="modal fade" id="modaledicion<%-id%>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div id="contenido_nuevoperfil"  class="modal-content">
			    <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title">Nuevo Perfil</h4>
			    </div>					    
		        <div class="modal-body">
                         <div style="display:inline-block"> <input name="nombre" type="text" value="<%-nombre%>" class="form-control" placeholder="Nombre del perfil"></div>					            
				    <div class="btn-group" data-toggle="buttons">				            
				        <button type="button" class="btn btn-default" data-dismiss="modal">Guardar</button>
				        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>						           
			        </div>
				    <div class="posiciontab" style="margin-top:10px;">
				      	<input type="checkbox" id="idpermisos" class="btn_marcarTodos"> Marcar todos los permisos
					    <ul id="moduloss" class="nav nav-tabs" role="tablist">
					        <!-- Menu de opciones-->
					    </ul>
					    <form id="arraypermisos">
					       	<div id="submoduloss" class="tab-content"></div>
					    </form>
					</div>
		        </div>	<!--modal body-->				       
		    </div> <!-- /.modal-content -->		         
		</div><!-- /.modal-dialog -->
	</div>
</script>

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
								<%if(submodulos[i] == 'Empleados'||submodulos[i]=='Perfiles'	||submodulos[i] == 'Puestos'		
									||submodulos[i]=='Roles'||submodulos[i] == 'Servicios')
									{%>  <input id="2" name="<%-modulo%><%-submodulos[i]%>" value="2" class="chek" type="checkbox" ><p>Nuevo</p> <%}%>
								<input id="2" name="<%-modulo%><%-submodulos[i]%>" value="2" class="chek" type="checkbox" ><p>Consultar</p>
								<input id="3" name="<%-modulo%><%-submodulos[i]%>" value="3" class="chek" type="checkbox" ><p>Editar</p>
								<input id="4" name="<%-modulo%><%-submodulos[i]%>" value="4" class="chek" type="checkbox" ><p>Eliminar</p>
						<%}%>

					
					</div>
				</div>
			<% } %>	
	</div>
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