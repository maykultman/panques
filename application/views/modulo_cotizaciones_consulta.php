	<section class="contenedor_principal_modulos">
    <table id="tabla_cotizaciones" class="table table-striped table-curved">
		<thead>
		 <tr id="color_titulos">
			<th style="text-align:center; width:40px; ">Marcar</th>
			<th>
				<input id="buscarCliente" class="form-control" type="text" placeholder="Cliente">
			    <span class="icon-search busqueda"></span>
			</th>
			<th>
				<input id="buscarUsuario" class="form-control" type="text" placeholder="Relizado por"><span class="icon-search busqueda"></span>
			</th>
				<th>&nbsp;Total</th>
				<th>&nbsp;&nbsp;Fecha</th>
				<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Operaciones</th>
		    </tr>					
		</thead>
		<tbody id="lista_cotizaciones">
			<!-- Lista de las ultimas cotizaciones-->
		</tbody>		
	</table>
		<button id="eliminar"  type="button" class="btn btn-danger">  Eliminar varios </button>
		<button id="marcar"    type="button" class="btn btn-default"> Marcar todos    </button>
		<button id="desmarcar" type="button" class="btn btn-default"> Desmarcar todos </button>
	</section>
</div>
<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type="text/javascript">
	$(document).on('ready',function(){
		$('.icon-trash').on('click',function(){
			window.confirm('Estas seguro de eliminar la cotización');
		});
	});
</script>

<script type = "text/plantilla" id="tabla_Cotizacion">
	<td><input type="checkbox" class="checkCot"/>
	<td><a href="#"><%-cliente  %></a></td>
	<td><a href="#"><%-empleado %></a></td>
	<td>$<%- total %></td>
	<td><%- fecha %></td>
	<td class="iconos-operaciones">
		<span class="icon-trash"    data-toggle="tooltip" data-placement="top" title="Eliminar">		  </span>
		<span class="icon-preview"  data-toggle="tooltip" data-placement="top" title="Ver cotización">	  </span>
		<span class="icon-uniF7D5"  data-toggle="tooltip" data-placement="top" title="Descargar PDF">	  </span>
		<span class="icon-edit2"    data-toggle="tooltip" data-placement="top" title="Editar">			  </span>
		<span class="icon-uniF5E2"  data-toggle="tooltip" data-placement="top" title="Realizar contrato"> </span>
	</td>

</script>

<!-- Librerias -->
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>">	</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>">		</script>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDeCotizaciones   	= <?php echo json_encode($cotizaciones)   	?>;
	app.coleccionDeServicios      	= <?php echo json_encode($servicios)      	?>;
	app.coleccionDeClientes       	= <?php echo json_encode($clientes)       	?>;
	app.coleccionDeRepresentantes 	= <?php echo json_encode($representantes) 	?>;
	app.coleccionDeEmpleados      	= <?php echo json_encode($empleados) 			?>;
	app.coleccionServiciosCotizados = <?php echo json_encode($serviciosCotizados) ?>;
</script>
<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
<!-- MVC -->
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloCotizacion.js'?>">			 		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloCliente.js'?>">             		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloEmpleado.js'?>">            		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicioCotizado.js'?>">           </script>

<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionCotizaciones.js'?>"> 		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionClientes.js'?>">     		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/coleccionServiciosCotizados.js'?>">  </script>
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionEmpleados.js'?>">    		</script>

<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaCotizacion.js'?>">			 		</script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaConsultaCotizaciones.js'?>">  		</script>