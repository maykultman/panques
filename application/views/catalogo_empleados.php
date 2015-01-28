<?=link_tag('css/empleados.css')?>
<?php 
$activa_p = array();
function menu($arg, $perm)
{
	$resp=0;
	foreach ($arg as $key => $value) {
		if($value==$perm)
		{
			$resp = $value;
		}
	}
	return $resp;
}
if(isset($this->session->userdata('Catálogos')[0]['permisos']))
{
	$activa_p[0] = menu($this->session->userdata('Catálogos')[0]['permisos'], 1);
	$activa_p[1] = menu($this->session->userdata('Catálogos')[0]['permisos'], 2);
	$activa_p[2] = menu($this->session->userdata('Catálogos')[0]['permisos'], 3);
	$activa_p[3] = menu($this->session->userdata('Catálogos')[0]['permisos'], 4);
}
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3 class="titulo">Empleados</h3> 
		<button <?=($activa_p[0]=='1') ? '':'disabled';?>id="nuevo_empleado" class="btn btn-primary" data-toggle="modal" data-target="#modal_nuevo_empleado">
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
					    <form id="registro" class="row">
					       	<div class="col-xs-2 visible-xs"></div>	
					        <div class="col-xs-8 col-sm-4 col-md-4 col-md-offset-1">
					        	<div id="femp">	
					        		<label class="btn fileinput-button">
			    						<span class="icon-uniF580"></span>
			    						<input type="file" id="fotou" data-url="<?=base_url()?>api_foto" name="logoUsuario">			                    				               
			    					</label><img id="direccionn" class="" width="100%">
					        	</div>								        		
					        </div>						        	
					        <div class="col-xs-2 visible-xs"></div>
					        <div class="clearfix visible-xs"></div>
							<div class="col-md-6">
								<br>
								<input id="nemp" name="nombre" type="text" class="form-control" placeholder="Nombre"><br>
								<select name="puesto" class="jobs" placeholder="Seleccione o añada un puesto"></select>
							</div> 
							<div class="clearfix"></div>
							<div class="col-md-10 col-md-offset-1"><br><input name="direccion" 		    type="text"   class="form-control" 			   placeholder="Dirección"		   ><br></div>
							<div class="col-md-10 col-md-offset-1"><input id="cel" name="movil"     type="text"   class="form-control" onkeypress="num(this)"            placeholder="Telefono Móvil"	   ><br></div>
							<div class="col-md-10 col-md-offset-1"><input id="casa" name="casa"     type="text"   class="form-control" onkeypress="num(this)"            placeholder="Telefono casa"	   ><br></div>
							<div class="col-md-10 col-md-offset-1"><input id="correo" name="correo" type="email"  class="form-control" 			   placeholder="Email"   ><br></div>
							<div class="col-md-10 col-md-offset-1"><input name="fecha_nacimiento"   type="text"   class="form-control datepicker"  placeholder="Fecha de nacimiento" ></div>
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
<style>
.yes{
	-webkit-animation: efectoOpacidad 3s;	
	opacity: 0;
	position: absolute;
	z-index: 1;
	display: block!important;
	background: #fff;
	padding: 1px;
	border-radius: 50%;
}
.icon-uniF479{display: none; color: rgb(8, 142, 239);}
.icon-uniF478{display: none; color: #f33}
</style>

<script type="text/plantilla" id="empleado">
 	<%  
 		var placet = (telefono=='') ? 'Sin Teléfono':'';
 		var placec = (movil=='') ? 'Sin Celular':'';
 	%> 	
	<div class="user-wrapper alto">	
	<i id="true<%-id%>" class="icon-uniF479"></i>
	<i id="not<%-id%>" class="icon-uniF478"></i>
	<form id="dateEmp">
		<div class="fotoe">
			<img id="direccion<%-id%>" class="img-circle2" src="<?=base_url()?><%-foto%>" alt="Imagen-Usuario">
			<input type="hidden" name="oldFoto" value="<%-foto%>">
			<div class="vendrs saveUp">
			<i class="update glyphicon glyphicon-floppy-disk"></i>
			<label class="cua">				
				<i class="glyphicon glyphicon-edit"></i>
				<input type="file" class="botonf" id="foto<%-id%>" data-url="<?=base_url()?>api_foto" name="logoUsuario">			                    				               
			</label> 
			</div>			
		</div>
		<div class="inf">
			<b><%-nombre%></b><br>
			<small><%-nompuesto%></small><br>
		</div>
		<i <?=($activa_p[2]=='3') ? '':'disabled';?> class="vendrs icon-circleup" data-toggle="tooltip" data-placement="bottom" title="Click para ver el contenido"></i>
		<div class="vendrs edit">
			<div class="ed">
				<i class="glyphicon glyphicon-remove"></i>
				
				<label class="col-md-3 hidden-xs hidden-sm">Nombre</label>	<div class="col-md-9"><input type="text" class="form-control nombem" name="nombre" value="<%-nombre%>"></div>
				<br class="hidden-xs hidden-sm"><br>
				<label class="col-md-3 hidden-xs hidden-sm">Puesto</label>	<div class="col-md-9"><select id="job" class="form-control" name="puesto"></select></div>
				<br class="hidden-xs hidden-sm"><br>
				<label class="col-md-3 hidden-xs hidden-sm">Telefono</label><div class="col-md-9"><input type="text" class="form-control telc" name="telefono" value="<%-telefono%>" placeholder="<%-placet%>"></div>
				<br class="hidden-xs hidden-sm"><br>
				<label class="col-md-3 hidden-xs hidden-sm">Celular</label>	<div class="col-md-9"><input type="text" class="form-control telm" name="movil" value="<%-movil%>" placeholder="<%-placec%>"></div>
				<br class="hidden-xs hidden-sm"><br>
				<label class="col-md-3 hidden-xs hidden-sm">Domicilio</label><div class="col-md-9"><input type="text" class="form-control" name="direccion" value="<%-direccion%>"></div>
				<br class="hidden-xs hidden-sm"><br>
				<label class="col-md-3 hidden-xs hidden-sm">Fec. Nac.</label><div class="col-md-9"><input type="text" class="form-control" name="fecha_nacimiento" value="<%-fecha_nacimiento%>"></div>
				<br class="hidden-xs hidden-sm"><br>
				</form>
				<div class="btn-group" role="group">       	
			   		<button <?=($activa_p[3]=='4') ? '':'disabled';?> id="<%-id%>" type="button" data-count="<%-isuser%>" class="remov btn btn-default"><i class="glyphicon glyphicon-trash"></i></button>		   			
					<button <?=($activa_p[2]=='3') ? '':'disabled';?> id="d<%-id%>" type="button" class="edita btn btn-default"><i class="glyphicon glyphicon-floppy-disk"></i></button>					
				</div>
			</div>
		</div>

	</div><!--user-wrapper-->
	<div class="visible-xs visible-sm clearfix"></div>
	</script>

<script>
    $(function() {
	    $( ".datepicker" ).datepicker({
   	        changeMonth : true,
		    changeYear  : true,
		    yearRange   : "1970 : 2000",
		    dateFormat  : 'yy-mm-dd'
		});
	});

	function num(e)
	{
		if( (event.keyCode < 48) || (event.keyCode > 57) )
    	{        
        	event.returnValue = false;
    	}
	}
</script>
<!-- Librerias -->
<script type="text/javascript">
	var app = app || {};
	app.coleccionDeEmpleados = <?php echo json_encode($empleados) ?>;
	app.coleccionDeTelefonos = <?php echo json_encode($telefonos) ?>;
	app.coleccionDePuestos   = <?php echo json_encode($puestos)   ?>;
</script>
<!-- title="Editar"  -->
<?=
	script_tag('js/backbone/modelos/ModeloEmpleado.js').
	script_tag('js/backbone/modelos/ModeloPuesto.js').

	script_tag('js/backbone/colecciones/ColeccionEmpleados.js').
	script_tag('js/backbone/colecciones/ColeccionTelefonos.js').
	script_tag('js/backbone/colecciones/ColeccionPuestos.js').

	script_tag('js/backbone/vistas/VistaCatalogoEmpleado.js').
	script_tag('js/backbone/vistas/VistaNuevoEmpleado.js');
?>

<!-- <script src="http://CRMQualium.com/js/backbone/vistas/VistaNuevoEmpleado.js" language="javascript" type="text/javascript" /></script> -->