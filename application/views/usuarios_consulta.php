	<section id="consultaDeUsuarios">
	 	    <label><b id="cantidadDeUsuarios"></b></label>
	 		<hr style="margin-top: 0px;">

	 		<div class="panel-group" id="accordion">
	 		<!-- En Esta sección se renderiza la vista de empleado -->
			</div>
	 	</section>
 	</section>	
</div> 	<!-- Div General-->

<script type="text/plantilla" id="selectperfil">
	{{nombre}}
</script>
<script type="text/plantilla" id="Permisos">
	<input id='permiso_{{id}}' name="idpermisos" value="{{id}}" class="chek" type="checkbox" {{palomita}}>{{ nombre }}
</script>

<script type="text/plantilla" id="usuario">
	<div class="clearfix row-fluid">
	<center>
		<img class="img-circle" src="<?=base_url()?>{{foto}}" alt="Imagen-Usuario" width="80" height="80">
		<div id="veruser{{id}}" class="span6 mostrarform">
        	<h4><b>{{usuario}} </b></h4>
        	<h6><b>{{perfil}}</b></h6>        	
        	<button class="delete btn btn-default">Eliminar</button>
        	<button class="edit btn btn-default">Editar</button>
        </div>

    	<div id="formedit{{id}}" class="row-fluid ocultarform">
    	<form id="edicionUsuario{{id}}">
	 		<label>Editar</label>
			<input id="usuarioi" class="valor" name="usuario" type="text" placeholder="Nombre del Usuario" value="{{usuario}}">
			<div class="resp" style="display: table-cell"><!-- Indicador de modificación--></div>
			<label>Nombre: </label>&nbsp;{{empleado}}</p>
		
			<label>Perfil</label>
			<select id="idperfil" name="idperfil" class="valor">									 
			</select><br>
			<select class="menuServicios" multiple placeholder="Buscar servicios">
            </select>  
			<div class="clearfix">
	            <div class="btn-group">
	                <button class="save btn btn-primary">Save</button>
	                <button class="cancel btn">Cancel</button>
	            </div>
        	</div>				  		 		
		
			</fieldset>
    	</form>
        </div>
    </div>
    
</script>


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
