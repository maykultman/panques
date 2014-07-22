<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>">	</script>
<script type="text/javascript" src="<?=base_url().'js/autocompletes.js'?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url().'css/estilos_modulo_cotizaciones.less'?>">
<style type="text/css">
	#posicion_infotd, #section_actualizar {
		/*float: left;*/
		/*width: 100%;*/
	}
	.contenedor_principal_modulos{
		position: relative;
	}
	.visiblito{
		transition: all 300ms ease-in;
		opacity: 1;
		/*display: block;*/
	}
	.ocultito{
		transition: all 300ms ease-in;
		opacity: 0;
		position: absolute;
		/*position: absolute;*/
		/*display: none;*/
	}
	#h3_tituloActualizar {
		background: #FFF;
	}
</style>
	<section class="contenedor_principal_modulos">
		<section id="posicion_infotd" class="visiblito">
		    <table id="tabla_cotizaciones" class="table table-striped table-curved">
				<tr id="color_titulos">
					<th style="text-align:center; width:40px; ">Marcar <input id="todos" type="checkbox" name="todos"></th>
					<th>
						<input id="buscarCliente" class="form-control" type="text" placeholder="Cliente">
					    <span class="icon-search busqueda"></span>
					</th>
					<th>
						<input id="buscarEmpleado" class="form-control" type="text" placeholder="Relizado por">
						<span class="icon-search busqueda"></span>
					</th>

					<th><div id="bfecha" class="abajo" style="margin-left:5px;">Fecha&nbsp;<span id="fecha" class="downt"></span></div></th>
					<th>&nbsp;Total</th>
					<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Operaciones</th>
				</tr>					
				<tbody id="lista_cotizaciones">
					<!-- Lista de las ultimas cotizaciones-->
				</tbody>		
			</table>
				<button id="eliminar"  type="button" class="btn btn-danger">  Eliminar varios </button>
	</section>

	<section id="section_actualizar" class="visiblito ocultito">
	<h3>Información Básica</h3>
	<hr>
	<div class="row">
		<div class="col-md-4">
			<input id="titulo" value="" class="form-control input_datos" placeholder="Titulo de Cotización">
			<input id="cliente" 	  type="search" value="" class="form-control input_datos" placeholder="Buscar cliente"><span id="busqueda_icono" class="icon-search"></span>
			<input id="representante" type="text"   value="" class="form-control input_datos" placeholder="Representante" disabled="true">	
			<form id="registroCotizacion">
				<input type="hidden" id="hid" 				name="id" 				value="">
				<input type="hidden" id="htitulo"    		name="titulo"   		value="">			
				<input type="hidden" id="idcliente" 		name="idcliente" 		value="">
				<input type="hidden" id="idrepresentante" 	name="idrepresentante" 	value="">
				<input id="fecha"   type="text" name="fecha" class="form-control input_datos" val="" disabled="true" >	
		</div>
		<div class="col-md-4">
			<textarea id="detalles" name="detalles" class="form-control input_datos" placeholder="Detalles" style="height: 180px;"></textarea>
		</div>
		<div class="col-md-4">
			<textarea id="caracteristicas" name="caracteristicas" class="form-control input_datos"  placeholder="Caracteristicas" style="height: 180px;"></textarea>
		</div>
		</form>
	</div>
    <div class="desborde"></div>			
	<h3>Inversión & Tiempo</h3>
	<hr>		
	<div class="row">
		<div class="col-md-6" style="width: 30% !important">
			<input type="text" id="bserv" style = "width : 100%; height:35px;" class="valor" val="" placeholder="Buscar Servicios">
			<div class="panel panel-primary" style="margin-top: 20px">
		      <div class="panel-heading">
		        <h3 class="panel-title">Seleccionar servicios</h3>
		      </div>
		      <div class="panel-body" style="overflow: auto; height: 230px; padding: 0px !important;">
		        <table id="listaServicios" class="table table-hover" >
		        	<tbody style="width :100%;">	
			    		<!-- Esta sección contiene la lista de los servicios - -->
					</tbody>
		        </table>	
		      </div>
		    </div>			
		</div>
		<div class="col-md-6" style="width: 70% !important">
			<table id="mostrarTabla" class="table table-striped">
				<thead style="background : #F9F9F9;">
					<tr>
						<th>Todos<input id="todos" type="checkbox" style=""></th> <th>Servicio </th> <th>Duración</th> <th>Cantidad</th>
						<th>P/Unitario					</th> <th>Descuento</th> <th>Importe </th> <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
					</tr>
				</thead>
				<tbody id="trServicio"></tbody>
					<tr class="info"> 
						<td></td> 
						<td colspan="5">Total</td> 
						<td><p id="total">0.00</p></td>
						<td></td>
					</tr>			
				<tfoot>
					<tr>
					    <td><button id="delete"  type="button" class="btn btn-danger">Eliminar varios 			</button>
					    <td>
						    <button id="vistaPreviaversion"    type="button" class="btn btn-primary"> 
						    	<span class="icon-preview "></span> Vista previa 
						    </button>
						</td>		
					</tr>
				</tfoot>
			</table>
		</div>
	</div>		
	<div class="desborde"></div><br><br> 
	<button id="guardarEdicion"   type="button" class="btn btn-default"> Guardar  </button>		    
	<button id="btn_calcelar"  type="button" class="btn btn-default"> Cancelar </button>		

	</section>

</section>
</div>
<script type = "text/plantilla" id="PCservicios">
	<td   class="icon-operaciones">
		<span id="infoSC" class="icon-info" ></span>

		<label id="input_td" for="<%- id %>"><%- nombre %></label>
		<ul class="ocultoI">		
			<li> Concepto    : &nbsp;&nbsp; <%- concepto    %>  </li>   
			<li> Precio      : &nbsp;&nbsp; <%- precio      %>  </li>    
			<li> +Iva        : &nbsp;&nbsp; <%- masiva      %>  </li>   
			<li> Realización : &nbsp;&nbsp; <%- realizacion %>  </li>
		</ul>
        <input type="checkbox" class="serviciosCotizar" id="<%- id %>">  	  
	</td>
</script>
<script type = "text/plantilla" id="serviciosAgregado">	

		<td><input type="checkbox" id="<%- id %>" name="todos"></td><td><%-nombre %></td>
		<td><input type="text" id="duracion"  name="duracion"  value="<%-duracion%>"  class="valor">   </td>
		<td><input type="text" id="cantidad"  name="cantidad"  value="1"				 class="valor">   </td>
		<td><input type="text" id="precio"    name="precio"    value="<%-precio     %>"  class="valor">   </td>
		<td><input type="text" id="descuento" name="descuento" value="0" 				 class="valor">   </td>		
		<td><input 			   id="importe"   name="importes" 						     class="importes">
		<form class="filas">
			  <input type="hidden"   				 name="id" 		  value="<%-idservicio%>"		   >
		      <input type="hidden"  id="hduracion"   name="duracion"  value="<%-duracion%>" >
		      <input type="hidden"  id="hcantidad"   name="cantidad"  value="1"                > 
		      <input type="hidden"  id="hprecio"     name="precio" 	  value="<%-precio     %>" >
		      <input type="hidden"  id="hdescuento"  name="descuento" value="0"                >
		</form>
		</td>

		<td class="iconos-operaciones">			
			<span class="icon-circledelete btndelete"  data-toggle="tooltip" title="Eliminar" id="<%- id %>"></span>
		</td>	
</script>



<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type = "text/plantilla" id="tabla_Cotizacion">
	<td><input type="checkbox" class="checkCot" name="todos"/>

	<td><%-cliente%></td> <td><%-empleado%></td> <td><%-formatearFechaUsuario(new Date(fecha))%></td> <td>$<%-total%></td>
	<td class="icon-operaciones">
		<span class="icon-trash"    data-toggle="tooltip" data-placement="top" title="Eliminar">		  </span>
		<span class="icon-preview"  data-toggle="tooltip" data-placement="top" title="Ver cotización">	  </span>
		<span class="icon-uniF7D5"  data-toggle="tooltip" data-placement="top" title="Descargar PDF">	  </span>
		<span class="icon-edit2 tr_btn_editar"    data-toggle="tooltip" data-placement="top" title="Editar">			  </span>
		<span class="icon-uniF5E2"  data-toggle="tooltip" data-placement="top" title="Realizar contrato"> </span>
	</td>
</script>
<!-- Librerias -->
<script src="<?=base_url().'js/plugin/Gantt/js/jquery.fn.gantt.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>">		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone.localStorage.js'?>"></script>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDeCotizaciones   	= <?php echo json_encode($cotizaciones)   	  ?>;
	app.coleccionDeServicios      	= <?php echo json_encode($servicios)      	  ?>;
	app.coleccionDeClientes       	= <?php echo json_encode($clientes)       	  ?>;
	app.coleccionDeRepresentantes 	= <?php echo json_encode($representantes) 	  ?>;
	app.coleccionDeEmpleados      	= <?php echo json_encode($empleados) 		  ?>;
	app.coleccionServiciosCotizados = <?php echo json_encode($serviciosCotizados) ?>;
</script>
<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<!-- MVC -->

<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloServicio.js'			       ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloCotizacion.js'               ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloCliente.js'                  ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloEmpleado.js'                 ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloRepresentante.js'            ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloServicioCotizado.js'         ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloLocalCotizacion.js'         ?>" > </script>

<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/ColeccionServicios.js'	           ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/ColeccionCotizaciones.js'      ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/ColeccionLocalCotizaciones.js' ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/ColeccionClientes.js'		   ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/coleccionServiciosCotizados.js'?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/ColeccionEmpleados.js'         ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/ColeccionRepresentantes.js'    ?>" > </script>

<script type ="text/javascript"  src = " <?=base_url().'js/backbone/vistas/VistaServicio.js'				      ?>"> </script>
<script type ="text/javascript"  src = " <?=base_url().'js/backbone/vistas/VistaServicioCotizacion.js'	      ?>"> </script>
<script type ="text/javascript"  src = " <?=base_url().'js/backbone/vistas/VistaNuevaCotizacion.js'		      ?>"> </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/vistas/VistaConsultaCotizaciones.js'	   ?>" > </script>