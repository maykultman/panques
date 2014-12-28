		<?=
		script_tag('js/jquery-ui-1.9.2.custom.min.js').
		script_tag('css/bootstrap-3.1.1-dist/js/tab.js');?>

        <section>
		<script>
		  $(function() {
		    $( ".datepicker" ).datepicker({
		      changeMonth : true,
		      changeYear  : true,
		      yearRange   : "1970 : 2000",
		      dateFormat  : 'yy-mm-dd'
		    });
		  });
		</script>  
		<section id='#catalogo_empleados'>			
			<h3 class="titulo">Empleados</h3> 
			<button id="nuevo_empleado" class="btn btn-primary" data-toggle="modal" data-target="#modal_nuevo_empleado">
			  Nuevo
			</button>		   
			<hr style="margin-top: 0px !important;">			
			<div id="modal_nuevo_empleado" class="modal fade">
			  <div class="modal-dialog">
			    <div class="modal-content">
			        <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				        <h4 class="modal-title">Nuevo Empleado</h4>
			        </div>
			        <div class="modal-body">
				        <form id="registro">
				        	<div style="margin-left:85px; ">
								<input  id="nombre" name="nombre" type="text"  class="form-control" placeholder="Nombre" >
								<select id="puesto"  name="puesto"              class="form-control"                      >
								  <option selected disabled> Cargo   </option>
								</select>
								<input name="direccion" 		  type="text"   class="form-control" 			 placeholder="Dirección"		   >
								<input id="cel" name="movil"      type="text"   class="form-control"             placeholder="Telefono Móvil"	   >
								<input id="casa" name="casa"      type="text"   class="form-control"             placeholder="Telefono casa"	   >									
								<input id="correo" name="correo"    		  type="email"  class="form-control" 			 placeholder="Email"			   >
								<input name="fecha_nacimiento"    type="text"   class="form-control datepicker"  placeholder="Fecha de nacimiento" >
							</div>
						</form>	
				    </div>
			        <div class="modal-footer">
				      	<button id="guardar"  type="button" class="btn btn-primary">Guardar</button>
				        <button id="cancelar" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>		        
			        </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal --><br>

			<div id="consultaEmpleado" class="tabbable tabs-right">
		        <ul id="listaPuesto" class="nav nav-tabs">
		          <!--Menu de opciones-->
		        </ul>

		        <div id="empleados" class="tab-content">
<!-- 		            <div  class="tab-pane active" id="rA">		            	
						<div  class="panel-group" id="accordion"><br>
											
						</div>
					</div>		 -->				
      			</div>
      			<!-- <div id="empleados"></div> -->
      		</div>			     
		</section>
	</section>
</div>
<!-- <select id="puesto" name="puesto" class="form-control" style="width : 350px;">
		<input id="puesto" name="puesto" type="text" class="form-control ancho_campos2" value="<%-puesto%>">						 
						</select> -->
<script type="text/plantilla" id="ppuestos">
	<a href="#rA" data-toggle="tab">  <%- nombre %>	</a>
</script>

<script type="text/plantilla" id="selectpuesto">
	<%- nombre %> 
</script>

<script type="text/plantilla" id="telefono">
	
	<label>Teléfono <%-tipo %> </label>
	<div style="display: table-cell">	
		<input id="tel" name="numero" type="text"  class="form-control ancho_campos2 tel" value="<%- numero %>">
	</div>	
	<div class="resp" style="display: table-cell"></div>
	
</script>

<script type="text/plantilla" id="empleado">
<article class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
<div class="user-wrapper">
	<div id="carnet<%-id%>">
		<img class="img-circle" src="<?=base_url()?>/img/sinfoto.png" alt="Imagen-Usuario" width="65" height="65"><br>
		<b><%-nombre%></b><br>
		<small><%-puesto%></small><br>
	    <div class="btn-group">       	
	      	<button id="<%-id%>" class="delete btn btn-default">Eliminar</button>
	       	<button id="<%-id%>" class="edit btn btn-default">Editar</button>
	    </div>	    
	</div>
	<div id="verinfo<%-id%>" class="editinfo">
		<label>Nombre</label>				<input type="text" name="" value="<%-nombre%>"><br><br>
		<label>Puesto</label>				<input type="text" name="" value="<%-puesto%>"><br><br>
		<!--<label>Teléfono</label>			<input type="text" name="" value="<%-telefono%>"><br>-->
		<label>Domicilio</label>			<input type="text" name="" value="<%-direccion%>"><br><br>
		<label>Fecha de nacimiento</label>	<input type="text" name="" value="<%-fecha_nacimiento%>"><br><br>
		<button id="<%-id%>" class="guardar btn btn-default">Guardar</button>
		<button id="<%-id%>" class="cancel btn btn-default">Cancelar</button>
	</div>
</div>

</article>
</script>

<script type = "text/plantilla" id="datosEmpleadoz">
	
		<div class="panel-heading">
		    <h4 class="panel-title">
			    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<%- id %>">
			    	<b id="nombreEmpleado<%- id %>" class="titulo_empleados"><%-nombre%></b>
			    	<span class=" icon-uniF48B flecha_abajo"></span> 
			    </a>
		    </h4>
		</div>

		<div id="collapse<%- id %>" class="panel-collapse collapse">
		  	<div class="panel-body">
		  	<div class="eliminar_permiso">
		    		<span id="<%- id %>" class="icon-trash" data-toggle="tooltip" title="Eliminar"></span>
		    </div>
		    <h4><b>Datos personales</b></h4></br>
		    	
		    <div class="row">
			  	<div class="col-md-4" style="width: 42.5% !important">
			  		<div class="padre">
			  			<label>Nombre</label>
			  			<div style="display: table-cell">				  				
			  		 		<input id="nombrei" name="nombre" type="text" class="form-control ancho_campos2" placeholder="Nombre" value="<%- nombre %>">
						</div>				  			
			  		 	<div class="resp" style="display: table-cell"></div>
					</div>
						

					<div class="padre">
						<label>Puesto</label>
						<div style="display: table-cell">								
							<select id="puesto" name="puesto" class="form-control" style="width : 350px;">	</select>
						</div>
						<div class="resp" style="display: table-cell"></div>
					</div>

					<div class="padre">
						<label>Dirección</label>
						<div style="display: table-cell">									
							<input id="direccion" name="direccion" type="text"  class="form-control ancho_campos2" placeholder="Dirección"      value="<%- direccion  %>">	
				  		</div>
				  		<div class="resp" style="display: table-cell"></div>
					</div>
				</div>

				<div class="col-md-4" style="width: 42.5% !important">
					<div class="padre">
						<label>Correo</label>
						<div style="display: table-cell">
							<input id="correo" name="correo" type="text"  class="form-control ancho_campos2" placeholder="Email" value="<%- correo %>">
						</div>
				  		<div class="resp" style="display: table-cell"></div>
					</div>

					<div class="padre">
						<label>Fecha de Nacimiento</label>
						<div style="display: table-cell">
							<input class="form-control ancho_campos2 datepicker" type="text" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha de nacimiento" value="<%- fecha_nacimiento%>">
						</div>
						<div class="resp" style="display: table-cell"></div>
					</div>
				</div>

				<div id="tel" class="col-md-4" style="width: 42.5% !important">				  	
					
				</div>				  
			</div>				      
		</div> 	
</script>
<!-- Librerias -->
<script type="text/javascript">
	var app = app || {};
	app.coleccionDeEmpleados = <?php echo json_encode($empleados) ?>;
	app.coleccionDeTelefonos = <?php echo json_encode($telefonos) ?>;
	app.coleccionDePuestos   = <?php echo json_encode($puestos)   ?>;
</script>
<?=
	script_tag('js/backbone/modelos/ModeloEmpleado.js').
	script_tag('js/backbone/modelos/ModeloTelefono.js').
	script_tag('js/backbone/modelos/ModeloPuesto.js').

	script_tag('js/backbone/colecciones/ColeccionEmpleados.js').
	script_tag('js/backbone/colecciones/ColeccionTelefonos.js').
	script_tag('js/backbone/colecciones/ColeccionPuestos.js').

	script_tag('js/backbone/vistas/VistaCatalogoEmpleado.js').
	script_tag('js/backbone/vistas/VistaNuevoEmpleado.js').
	script_tag('js/backbone/vistas/VistaCatalogoPuestos.js');
?>
