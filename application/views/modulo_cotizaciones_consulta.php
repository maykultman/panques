<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>">	</script>
<script type="text/javascript" src="<?=base_url().'js/autocompletes.js'?>"></script>
	<section class="contenedor_principal_modulos">
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
</div>

<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type = "text/plantilla" id="tabla_Cotizacion">
	<td><input type="checkbox" class="checkCot" name="todos"/>

	<td><%-cliente%></td> <td><%-empleado%></td> <td><%-fecha%></td> <td>$<%-total%></td>
	<td class="iconos-operaciones">
		<span class="icon-trash"    data-toggle="tooltip" data-placement="top" title="Eliminar">		  </span>
		<span class="icon-preview"  data-toggle="tooltip" data-placement="top" title="Ver cotización">	  </span>
		<span class="icon-uniF7D5"  data-toggle="tooltip" data-placement="top" title="Descargar PDF">	  </span>
		<span class="icon-edit2"    data-toggle="tooltip" data-placement="top" title="Editar">			  </span>
		<span class="icon-uniF5E2"  data-toggle="tooltip" data-placement="top" title="Realizar contrato"> </span>
	</td>
</script>
<!-- Librerias -->
<script src="js/plugin/Gantt/js/jquery.fn.gantt.js"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>">		</script>
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
<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloCotizacion.js'               ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloCliente.js'                  ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloEmpleado.js'                 ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/modelos/ModeloServicioCotizado.js'         ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/ColeccionCotizaciones.js'      ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/ColeccionClientes.js'		   ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/coleccionServiciosCotizados.js'?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/colecciones/ColeccionEmpleados.js'         ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/vistas/VistaCotizacion.js'				   ?>" > </script>
<script type = "text/javascript" src = " <?=base_url().'js/backbone/vistas/VistaConsultaCotizaciones.js'	   ?>" > </script>