<?=	link_tag('css/estilo_dashboard_gustavo.css').
	link_tag('css/theme.default.css');
?>
<style>
.warning{
	color:#f89406
}
</style>
<div class="contenedor_modulo">
	<h1 id="titulo_del_modulo" style="display: block; position: fixed; z-index: 1; width: 100%;"><label>Escritorio</label></h1>
    
	<section class="container" style="padding-top:8%;">
		<div class="row">
			<!-- <h3></h3> -->
			<div class="row">
			  	<div class="col-md-6">
				  	<div class="panel panel-default">
						<div class="panel-heading color">
					    	<h3 class="panel-title">Dominios</h3>
					    	<span id="icono_panel" class="icon-domain2" ></span>
					    </div>
					  	<div  class="panel-body" style="overflow: auto; height: 250px;">
						   <table class="table table-striped ">
						   	<thead>
						   		<tr>
						   			<th>Dominio</th>
						   			<th>Vencimiento</th>
						   		</tr>
						   	</thead>
						   	<tbody >
						   		<?php if(isset($dominios)&&is_array($dominios)): ?>
						   			<tr><td><?=$dominio;?></td> <td><?=$vencimiento;?></td></tr>
						   		<?php endif ?>
						   	</tbody>
						   </table>
						</div>
					</div>
			  	</div>
			  	<div class="col-md-6">
			  		<div class="panel panel-default">
						<div class="panel-heading color">
					    	<h3 class="panel-title">Pagos de clientes</h3>
					    	<span id="icono_panel" class="icon-uniF4E7" ></span>
					    </div>
					  	<div class="panel-body" style="height: 250px;">
						    <ul class="nav nav-tabs" role="tablist">
							  <li class="active"><a href="#evento" role="tab" data-toggle="tab">Evento</a></li>
							  <li><a href="#iguala" role="tab" data-toggle="tab">Iguala Mensual</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade in active" id="evento" style="overflow: auto; height: 185px;">
									<table class="table table-striped">
									   	<thead >
									   		<tr>
									   			<th>Cliente</th>
									   			<th>Monto</th>
									   			<th>Vencimiento</th>
									   		</tr>
									   	</thead>
									   	<tbody>
									   		<?php if(isset($pagosxI)&&is_array($pagosxI)):?>
									   		<tr>
									   			<td><?=$cliente;?></td>
									   			<td><?=$monto;?></td>
									   			<td><?=$vencimiento;?></td>
									   		</tr>
									   	<?php endif;?>
									   	</tbody>
									</table>							
								</div>
							    <div class="tab-pane fade" id="iguala" style="overflow: auto; height: 185px;">
							    	<table class="table table-striped">
									   	<thead >
									   		<tr>
									   			<th>Cliente</th>
									   			<th>Monto</th>
									   			<th>Vencimiento</th>
									   		</tr>
									   	</thead>
									   	<tbody>
											<?php 
												if(isset($pagosxE)&&is_array($pagosxE)):?>
									   			<tr>
									   				<td><?=$cliente;?></td>
									   				<td><?=$monto;?></td>
									   				<td><?=$vencimiento;?></td>
									   			</tr>
									   		<?php endif;?>									   		
									   	</tbody>
									</table>	
							    </div>
						    </div>
						</div>
					</div>
			  	</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading color" >
			    	<h3 class="panel-title">Mis Actividades</h3>		    	
			    	<span id="icono_panel" class="icon-calendar2" ></span>
			    </div>
			  	<div class="panel-body">
			  		<div class="row">
			  			<div class="col-md-6" style="width: 25%  !important">
			  				<div class="datepicker"></div>
			  			</div>
			  			<div class="col-md-6" style="width: 75% !important">
			  				<table class="table table-hover">
							   	<thead >
							   		<tr>
							   			<th>Actividad</th>
							   			<th>Fecha</th>
							   			<th>Hora</th>
							   		</tr>
							   	</thead>
							   	<tbody>
							   		<?php if(isset($actividades)&&is_array($actividades)) : ?>
							   			<tr>
							   				<td><?=$actividad;?></td>
							   				<td><?=$fecha;?></td>
							   				<td><?=$hora;?></td>
							   			</tr>							   		
							   		<?php endif ?>
							   	</tbody>
							</table>	
			  			</div>
			  		</div>		   
				</div>
		    </div>
		    <div class="panel panel-default">
				<div class="panel-heading color" >
			    	<h3 class="panel-title">Cotizaciones Realizadas</h3>
			    	<span id="icono_panel" class="icon-calculator" ></span>
			    </div>
			  	<div class="panel-body">
				    <table class="table table-striped ">
					   	<thead>
					   		<tr>
					   			<th>Prospecto</th><th>Servicio</th>
					   			<th>Realizó</th><th>Importe</th>
					   			<th>Fecha</th><th>Tools</th>
					   		</tr>
					   	</thead>
					   	<tbody >
					   		<?php 
					   			if(isset($cotizaciones)&&is_array($cotizaciones))
					   			{
					   				foreach ($cotizaciones as $key => $value) 
					   				{?>

					   				<tr>
					   					<td><?=$cliente;?></td><td><?=$titulo;?></td>
					   					<td><?=$empleado;?></td><td><?=$importe;?></td>
					   					<td><?=$fecha;?></td><td>Operaciones</td>
					   				</tr>
					   					
					   				<?php }
					   			}
					   		?>
					   	</tbody>
					</table>
				</div>
		    </div>
		    <div class="panel panel-default">
				<div class="panel-heading color" >
			    	<h3 class="panel-title">Status Proyectos</h3>
			    	<span id="icono_panel" class="icon-uniF53D" ></span>
			    </div>
			  	<div class="panel-body">
			  		<table id="tbla_cliente" class="table table-striped">
						<thead>
					        <tr id="color_titulos">					
								<th>Cliente</th>
								<th>Proyecto</th>			
								<th>Entrega</th>     
								<th>Status</th>         
								<th>Responsable</th>
					        </tr>
						</thead>      
						<tbody>
							<?php if(isset($proyectos)&&is_array($proyectos)) : ?>
								<tr>							
									<td><?=$cliente;?></td>
									<td><?=$proyecto;?></td>						
									<td><?=$entrega;?></td>
									<td>		
										<span class="badge list-group-item-success">
										<?=$status;?>
										</span>		
									</td>      							
									<td><?=$responsable;?></td> 							        
					        	</tr>
					    	<?php endif; ?>
				    	</tbody> 
					</table>
				</div>
		    </div>
	   	  	<div class="panel panel-default">
				<div class="panel-heading color">
				   	<h3 class="panel-title">Ingresos</h3>
				   	<span id="icono_panel" class="icon-stocks" ></span>
				</div>
				<div  class="panel-body" style="overflow: auto; height: 560px;">
				 	<label for="from">From</label>
					<input type="text" class="form-control" id="from" name="from" style="width: 30%; display: inline-block">
					<label for="to">to</label>
					<input type="text" class="form-control" id="to" name="to" style="width: 30%; display: inline-block">
					<span id="span_ingreso" class="badge">$100,000</span>     
					<table class="table table-hover ">
						<thead>
							<tr>
								<th>Cliente</th>
								<th>Servicio</th>
								<th>Monto</th>
							</tr>
						</thead>
					   	<tbody>
					   		<?php if(isset($ingresos)&&is_array($ingresos)):?>
					   			<tr>	
					   				<td><?=$web;?></td>
					   				<td><?=$servicio;?></td>
					   				<td><?=$monto;?></td>
					   			</tr>
					   		<?php endif ?>
					   	</tbody>
					   </table>
					</div>
				</div>		  
		</div>
	</section>
</div>  
<?= 
	script_tag("js/jquery-ui-1.9.2.custom.min.js").
	script_tag('css/bootstrap-3.1.1-dist/js/collapse.js').
	script_tag('css/bootstrap-3.1.1-dist/js/transition.js').
	script_tag('css/bootstrap-3.1.1-dist/js/tap.js');
?>
<script>
  $(function() {
    $( ".datepicker" ).datepicker();
  });
</script>
<script>
  $(function() {
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      // changeMonth: true,
      // numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      // changeMonth: true,
      // numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
</script>