		<?=
		//script_tag('js/jquery-ui-1.9.2.custom.min.js').
		script_tag('css/bootstrap-3.1.1-dist/js/tab.js');?>
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
	<style type="text/css">
		.fulls{
			transform: translateY(-100%);
			margin-top: 1.8%;
			background: #fff;
			box-shadow: inset 0 1px 0 #fff, inset 0 0 40px rgba(0,0,0,0.05), 0 0 6px rgba(0,0,0,0.1);	
		}
		.edit{
			transition: .5s;
			height: 99%;
			width: 100%;
			position: absolute;
			left: 0;
			border-radius: 4px;
			text-align: left;
			padding: 15% 0% 0%;	
		}
		.ed{
			display: none;
		}
		.edb{
			display: block;
		}
		.glyphicon-remove{ 
			position: absolute;
			right: 5%;
			top: 5%;
			cursor: pointer;
		}
		.fotoe
		{
			position: absolute;
			top: 0;
			left: 0;
			text-align: center;
			width: 100%;
			height: 70%;
			overflow: hidden;
		}
		img{
			width: 100%;
			padding: 0px;
			border: none;
			border-radius: 4px 4px 0px 0px;
		}
		.inf{
			position: relative;
			margin-top: 73%;
			margin-bottom: 2%;
			font-size: 16px;
		}
		.icon-circleup{
			cursor: pointer;
			font-size: 22px;
		}
		.btn-group{
			margin-left: 70%;
		}
	</style>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
				    <ul id="listaPuesto" class="nav nav-tabs"><!--Menu de opciones--></ul>

				    <div id="empleados" class="tab-content" style="padding:2% 0%;"></div>
		      	</div>			     
			</div>
		</div>
	</div> 
</div>  
<script type="text/plantilla" id="ppuestos">
	<a href="#tab<%-id%>" data-toggle="tab">  <%- nombre %>	</a>
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
 	<% 
 		var placet = (telefono=='') ? 'Sin Teléfono':'';
 		var placec = (movil=='') ? 'Sin Celular':'';
 	%>
	<div class="user-wrapper alto">
		<div class="fotoe">
			<img class="img-circle2" src="<?=base_url()?>/img/sonrie.jpg" alt="Imagen-Usuario"><br>
		</div>
		<div class="inf">
		<b><%-nombre%></b><br>
		<small><%-nompuesto%></small><br>
		</div>
		<i class="icon-circleup"></i>
		<div class="edit">
			<div class="ed">
				<i class="glyphicon glyphicon-remove"></i>
				<form id="dateEmp">
				<label class="col-md-3">Nombre</label>		<div class="col-md-9"><input type="text" class="form-control" name="nombre" value="<%-nombre%>"></div><br><br>
				<label class="col-md-3">Puesto</label>		<div class="col-md-9"><select id="job" class="form-control" name="puesto"></select></div><br><br>
				<label class="col-md-3">Telefono</label>	<div class="col-md-9"><input type="text" class="form-control" name="telefono" value="<%-telefono%>" placeholder="<%-placet%>"></div><br><br>
				<label class="col-md-3">Celular</label>		<div class="col-md-9"><input type="text" class="form-control" name="movil" value="<%-movil%>" placeholder="<%-placec%>"></div><br><br>
				<label class="col-md-3">Domicilio</label>	<div class="col-md-9"><input type="text" class="form-control" name="direccion" value="<%-direccion%>"></div><br><br>
				<label class="col-md-3">Fec. Nac.</label>	<div class="col-md-9"><input type="text" class="form-control" name="fecha_nacimiento" value="<%-fecha_nacimiento%>"></div><br><br>
				</form>
				<div class="btn-group" role="group">       	
			   		<button id="<%-id%>" type="button" class="remov btn btn-default"><i class="glyphicon glyphicon-trash"></i></button>		   			
					<button id="<%-id%>" type="button" class="edita btn btn-default"><i class="glyphicon glyphicon-floppy-disk"></i></button>
				</div>
			</div>
		</div>

	</div><!--user-wrapper-->
	

</script>

<script type = "text/plantilla" id="datosEmpleadoz">
	
		<div class="panel-heading">
		    <h4 class="panel-title">
			    <a data-toggle="collapse" data-parent="#liEmpleado" href="#collapse<%- id %>">
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
	script_tag('js/backbone/modelos/ModeloPuesto.js').

	script_tag('js/backbone/colecciones/ColeccionEmpleados.js').
	script_tag('js/backbone/colecciones/ColeccionTelefonos.js').
	script_tag('js/backbone/colecciones/ColeccionPuestos.js').

	script_tag('js/backbone/vistas/VistaCatalogoEmpleado.js').
	script_tag('js/backbone/vistas/VistaNuevoEmpleado.js');
	// script_tag('js/backbone/vistas/VistaCatalogoPuestos.js');
?>