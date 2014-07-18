	 	<link   type="text/css" rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>">
        <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/collapse.js'?>">  </script>
        <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/transition.js'?>"></script>
        <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/tab.js'?>"        >  </script>
	 	<section id="consultaDeUsuarios">
	 	    <label><b id="cantidadDeUsuarios"></b></label>
	 		<hr style="margin-top: 0px;">

	 		<div class="panel-group" id="accordion">
	 		<!-- En Esta sección se renderiza la vista de empleado -->
			</div>
	 	</section>
 	</section>	
</div> 	
<script type="text/plantilla" id="selectperfil">
	{{nombre}}
</script>
<script type="text/plantilla" id="Permisos">
	<input id='permiso_{{id}}' name="idpermisos" value="{{id}}" class="chek" type="checkbox" {{palomita}}>{{ nombre }}
</script>
<script type="text/template" id="usuario">

	<div class="panel-heading">
		<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{id}}">
			<h4 class="panel-title">
				<b id="t_usuario{{id}}">{{usuario}}</b><span class="icon-uniF48B flecha_abajo"></span>  
			</h4>
		</a>			     
	</div>
	<div id="collapse{{id}}" class="panel-body panel-collapse collapse">
		
			<div class="row">
				<div class="col-md-4" style="width: 15% !important;"> 
					<img class="img-circle pull-left" src="<?=base_url()?>{{foto}}" alt="Imagen-Usuario" width="120">
				</div>
			<form id="edicionUsuario{{id}}">
				<div class="col-md-4" style="width: 42.5% !important">
					
				  		<label>Usuario</label>
				  		<div style="display: table-cell">  				
					 		<input id="usuarioi" name="usuario" type="text" class="form-control input_margen" placeholder="Nombre del Usuario" value="{{usuario}}">
						</div>
						
						<label>Contraseña</label>
						<div style="display: table-cell">				  				
					 		<input id="contrasenia" name="contrasenia" type="password" class="form-control input_margen" placeholder="Password" value="{{contrasenia}}">
						</div>
						<div class="resp" style="display: table-cell"><!-- Indicador de modificación--></div>
					
				</div>
				<div class="col-md-4" style="width: 42.5% !important;">
				  						
						<div style="display: table-cell">
							<p><b>Nombre del Empleado :</b>&nbsp;{{empleado}}</p>
						</div>						
										
					
						<label>Perfil</label>
						<div style="display: table-cell">
							<select id="idperfil" name="idperfil" class="form-control sperfil" style="width : 350px;">									 
							</select>					  		 		
						</div>
				</div>
			</div>
			</form>

			<div style="width:100%;" class="panel panel-primary">  
				<div class="panel-heading">Asignar Permisos</div>           
				<form id="permisoz{{id}}">
				<div id="ListaPermisos" class="row {{id}}">										
					<!--lista de permisos	 -->  	 
				</div>  	
				</form>
			</div>			    
		
		<button id="guardar" type="button" class="btn btn-default"> Guardar  </button>
	</div>
</script>
<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/validaciones.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/autocompletes.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/handlebars.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>">		</script>
<script type="text/javascript">
	app.coleccionDeUsuarios  = <?=json_encode($usuarios) ?>;
	app.coleccionDeEmpleados = <?=json_encode($empleados)?>;
	app.coleccionDePermisos  = <?=json_encode($permisos) ?>;
	app.coleccionDePerfiles  = <?=json_encode($perfiles) ?>;

</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPerfil.js'?>">          </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloUsuario.js'?>">          </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloEmpleado.js'?>">          </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloPermiso.js'?>">          </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPerfiles.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionUsuarios.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionPermisos.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionEmpleados.js'?>">  </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaRenderizaPermiso.js'?>">	   </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaUsuario.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaConsultaUsuario.js'?>">  </script>