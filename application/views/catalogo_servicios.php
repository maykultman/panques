		<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_catalogos.css'?>" type="text/css">
		<section id="catalogo_servicio">			
			<h3>Nuevo Servicio</h3>
			<hr><br>
			<form id="formServicio">
				<div class="nuevoServicio">	
					<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre">
					<input type="text" id="precio" name="precio" class="form-control" placeholder="Precio">
				</div>
				<div class="nuevoServicio">
				 	<input type="text" id="concepto" name="concepto" class="form-control" placeholder="Concepto">
					<input type="text" id="realizacion" name="realizacion" class="form-control" placeholder="Tiempo Estimado">
				</div>
				<div class="desborde"></div>
				<textarea id="descripcion" name="descripcion" class="form-control" placeholder="Descripción"></textarea><br>
				<button id="enviar" style=";" type="button" class="btn btn-default">Guardar</button>
				<button id="btn_cancelar" type="button" class="btn btn-default">Cancelar</button>	
			</form><br>
			<h3>Servicios</h3>
			<hr><br>
			<div  id="consulta_servicios" class="panel panel-primary" style="width:100%;">	
				<table id="consulta_tablaservicio" class="table table-striped">
					<thead style="display: inline-table">
						<tr>
							<th style="width: 80px;"></th>
							<th style="width: 335px;">Nombre</th>
							<th style="width: 180px;">Concepto</th>
							<th style="width: 100px;">Precio</th>
							<th style="width: 160px;">Realización</th>
							<th style="width: 300px;">Descripción</th>						
							<th style="width: 70px;">Opciones</th>
						</tr>	
					</thead>
					<tbody class="scrollCatalogo">
					</tbody>	
					
				</table>
			</div>
			<!-- {{{{{ALERTAS}}}}}}}}}-->
		    <div id="alertasCliente">
		        <!-- Mensaje de advertencia y erro. Se establece el mensaje desde backbone
		        a medida que ocurren los errores del usuario -->
		    	<div class="alert alert-warning oculto" id="advertencia">
		            <button type="button" class="close cerrar">×</button>
		            <h4>¡Advertencia!</h4>
		            <p id="comentario"></p>
		            <br>
		            <button type="button" id="eliminar" class="btn btn-danger">Eliminar</button>
		            <button type="button" id="cancelar" class="btn btn-default">Cancelar</button>
		        </div>
		        <div class="alert alert-warning oculto" id="advertencia2">
		            <button type="button" class="close cerrar">×</button>
		            <h4>¡Advertencia!</h4>
		            <p id="comentario"></p>
		            <br>
		            <button type="button" id="eliminar" class="btn btn-default">Aceptar</button>
		            <button type="button" id="cancelar" class="btn btn-default">Cancelar</button>
		        </div>
		        <div class="alert alert-danger alert-dismissable oculto" id="error">
		          <button type="button" class="close cerrar">&times;</button>
		          <strong>¡Error!</strong>
		          <div id="comentario"></div>
		        </div>
		        <div class="alert alert-success alert-dismissable oculto" id="exito">
		          <button type="button" class="close cerrar">&times;</button>
		          <strong>¡Exito!</strong>
		          <div id="comentario"></div>
		        </div>
		    </div>
		    <!-- {{{{{ALERTAS}}}}}}}}} -->
		</section>
    </section>
</div>	
<!--Plantillas -->
<script type="text/plantilla" id="plantilla_servicio">

	<td style="width:80px;"><input type="checkbox"></td>
	<td style="width:310px;"> <label class="oculto2 visible2"><%- nombre %></label><input type="text" name="nombre" value="<%- nombre %>" class="oculto2"> </td>
	<td style="width:180px;"> <label class="oculto2 visible2"><%- concepto %> </label><input type="text" name="concepto" value="<%- concepto %>" class="oculto2"> </td>
	<td style="width:100px;"> <label class="oculto2 visible2"><%- precio %> </label><input type="text" name="precio" value="<%- precio %>" class="oculto2"> </td>
	<td style="width:160px;"> <label class="oculto2 visible2"><%- realizacion %> </label><input type="text" name="realizacion" value="<%- realizacion %>" class="oculto2"></td>
	<td style="width:300px;"><label  class="oculto2 visible2"><%- descripcion %> </label><input type="text" name="descripcion" value="<%- descripcion %>" class="oculto2"></td>
	 <!-- <td> <label class="oculto2 visible2"><%- masiva %> </label><input type="text" name="masiva" value="<%- masiva %>" class="oculto2"> -->
	<td style="width:70px;"class="iconos-operaciones">
		<div>
	     <span class="icon-trash eliminar2"   data-toggle="tooltip" data-placement="top" title="Eliminar"></span><span class="icon-uniF756 editar2"   data-toggle="tooltip" data-placement="top" title="Editar"></span>
	    </div>
	</td>
        
	<!--<button class="editar2">Editar</button>--> 
	<!--<button class="eliminar2">Eliminar</button>-->
</script>



<!-- Utilerias -->
    <!-- <script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>-->
<!-- Librerias -->
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/jquery.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>"></script>
<script type="text/javascript">
	var app = app || {};
	app.coleccionDeServicios = <?php echo json_encode($servicios) ?>;
</script>
<!--MV*-->
   <!-- modelos -->
<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicio.js'?>"></script>
   <!-- modelos -->

    <!-- colecciones -->
<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServicios.js'?>"></script>
     <!-- colecciones -->

     <!-- Vistas -->
 <script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaServicio.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaNuevoServicio.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaCatalogoServicio.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaConsultaServicios.js'?>"></script>
       <!-- Vistas -->
<script type="text/javascript">
	var app = app || {};
</script>



<!-- <script type="text/javascript" src="js/backbone/vista_servicio.js"></script> -->
