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
		<div id="veruser" class="span6 mostrarform">
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


































 <script id="userEditTemplate" type="text/plantilla">
  <fieldset>
  <form id="edicionUsuario{{id}}">
    <div class="row-fluid">
 		<label>Usuario</label>
		<input id="usuarioi" name="usuario" type="text" placeholder="Nombre del Usuario" value="{{usuario}}">
		<div class="resp" style="display: table-cell"><!-- Indicador de modificación--></div>
		<p><b>Nombre del Empleado :</b>&nbsp;{{empleado}}</p>
		
		<label>Perfil</label>
		<select id="idperfil" name="idperfil" class=".valor" style="width : 150px;">									 
		</select>	
		<div class="clearfix">
            <div class="btn-group">
                <button class="save btn btn-primary">Save</button>
                <button class="cancel btn">Cancel</button>
            </div>
        </div>				  		 		
		
		</fieldset>
    </form>
</script>

<!-- 
<label>Contraseña</label>
				<div style="display: table-cell">				  				
						<input id="contrasenia" name="contrasenia" type="password" class="form-control input_margen" placeholder="Password" value="{{contrasenia}}">
				</div>
<form action="#">
                <fieldset>
                    <div class="row-fluid">
                        <input type="file" value="{{photo}}" />
                        <label>Name</label>
                        <input type="text" class="name" value="{{name}}" class="span12"/>
                        <input id="type" type="hidden" value="{{type}}" />
                        <label>Address</label>
                        <input type="text" class="address" value="{{address}}" class="span12"/>
                        <label>Telephone</label>
                        <input type="tel" class="tel" value="{{tel}}" class="span12"/>
                        <label>Email</label>
                        <input type="email" class="email" value="{{email}}" class="span12"/>
                    </div>
                    <div class="clearfix">
                        <div class="btn-group">
                            <button class="save btn btn-primary">Save</button>
                            <button class="cancel btn">Cancel</button>
                        </div>
                    </div>
                </fieldset>
            </form> -->

<script type="text/template" id="usuarioq">

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
			</div>	<br>		    
		
		<center><button id="guardar" type="button" class="btn btn-primary" > Guardar  </button></center>
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
