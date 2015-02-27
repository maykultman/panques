<?=	link_tag('css/estilo_dashboard_gustavo.css').
	link_tag('css/theme.default.css');
?>
<?php 
setlocale (LC_TIME, "es_ES"); 

function pagoz($arg)
{	
	echo '<table class="table table-striped">
			<thead><tr><th>Cliente</th><th>Monto</th><th>Vencimiento</th></tr></thead>
			<tbody>';

	foreach ($arg as $pik => $piv) 
	{ 	
		$class = 'alert';
		$class .= ($piv['fechapago'] < date('Y-m-d')) ? ' alert-danger': ' alert-success';				
		echo "<tr>
			<td>".$piv['cliente']."</td>
			<td>$".number_format($piv['pago'], 2)."</td>
			<td><span class='".$class."' style='padding:0 5px;'>".strftime('%d, %b %Y',strtotime($piv['fechapago']))."</span>
			</td>
		</tr>";
	}
	echo "</tbody></table>";
} 
?>
<style>
	.warning{
		color:#f89406
	}
	.nomserv{
		opacity: 0;
		position: absolute;
		background: rgba(39, 42, 47, 0.67);
		padding: 0 5px;
		border-radius: 0 0 3px 3px;
		left: 50%;
		transform: translateX(-50%);
		transition:.2s;
		bottom: -50px;
		
	}
	.trserv td{
		width:4.1%;
		cursor: pointer;
		text-align: center; 
	}
	.trserv td:hover{
		color: #fff;
		background-color: rgba(39, 42, 47, 0.67);
	}
	.trserv td:hover > .nomserv{
		opacity: 1!important;
	}
	.toltip{
		display: none; 
		background: rgba(5, 5, 5, 0.87);
		border-radius: 2px;
		padding: 1px;
		position: absolute;
		left: -15px;
		font-size: 12px;
		color: #fff;
	}
	.graf{
		position: relative;
	}
	.graf:hover > .toltip{
		display: block;
		cursor: pointer;
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
						   		<?php if(isset($dominios)&&is_array($dominios)){ ?>
						   			<tr><td><?=$dominio;?></td> <td><?=$vencimiento;?></td></tr>
						   		<?php } ?>
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
						    	<li class="active"><a href="#iguala" role="tab" data-toggle="tab">Iguala Mensual</a></li>
							  	<li><a href="#evento" role="tab" data-toggle="tab">Evento</a></li>							  
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade in active" id="iguala" style="overflow: auto; height: 185px;">
									<?php 
									$div = '<div style="border-radius:0 0 5px 5px;position:absolute;width:100%;background:rgba(0, 0, 0, 0.79);height: 100%;"></div><h3 style="padding:10%0;text-align: center;">No hay pagos pendientes por el momento</h3>';
									   	if(isset($pagosxI)&&is_array($pagosxI)){
									   		if(!empty($pagosxI)) {
									   			pagoz($pagosxI);
									   		}									   			
									   	}
									   	else
									   	{ 
									   		echo $div;
									   	}
									?>									 
								</div>
							    <div class="tab-pane fade" id="evento" style="overflow: auto; height: 185px; position:relative">
							    	<?php 
										if(isset($pagosxE)&&is_array($pagosxE)){
											if(!empty($pagosxE)) {												
												pagoz($pagosxE);
											}
										}
										else
										{ 
											echo $div;
										}
									?>
							    </div>
						    </div>
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
					   			<th>Cliente</th><th>Titulo</th>
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
					   					<td><?=$value->idcliente;?></td><td><?=$value->titulo;?></td>
					   					<td><?=$value->nombre;?></td><td><?='$'.$value->preciotiempo;?></td>
					   					<td><?=$value->fechacreacion;?></td><td>Operaciones</td>
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
							<?php if(isset($proyectos)&&is_array($proyectos)) : 
								foreach ($proyectos as $keyp => $vp) {
							?>
								<tr>							
									<td><?=$vp->nombreComercial;?></td>
									<td><?=$vp->nombre;?></td>						
									<td><?=$vp->fechafinal;?></td>
									<td>		
										<span class="badge list-group-item-success">
										<?=($vp->entregado==0) ? 'En desarrollo':'Entrega';?>
										</span>		
									</td>      							
									<td><?php echo 'beto';?></td> 							        
					        	</tr>
					    	<?php } endif; ?>
				    	</tbody> 
					</table>
				</div>
		    </div>

		    <?php if($this->session->userdata('perfil')=='Administrador') : ?>
		   	  	<div class="panel panel-default">
					<div class="panel-heading color">
					   	<h3 class="panel-title">Ingresos por servicios</h3>
					   	<span id="icono_panel" class="icon-stocks" ></span>
					</div>
					<div  class="panel-body" style="overflow: auto; height:400px;">
					 	<label for="from">From</label>
						<input type="text" class="form-control" id="from" name="from" style="width: 30%; display: inline-block">
						<label for="to">to</label>
						<input type="text" class="form-control" id="to" name="to" style="width: 30%; display: inline-block">
						<!-- <span id="span_ingreso" class="badge">$100,000</span>      -->
						
						<hr>
						 <ul class="nav nav-tabs" role="tablist">
							    	<li class="active"><a href="#mensual" role="tab" data-toggle="tab">Mensual</a></li>
								  	<li><a href="#trimestral" role="tab" data-toggle="tab">Trimestral</a></li>							  
								  	<li><a href="#semestral" role="tab" data-toggle="tab">Semestral</a></li>
								  	<li><a href="#anual" role="tab" data-toggle="tab">Anual</a></li>
								  	<li><a href="#dosa" role="tab" data-toggle="tab">2 años</a></li>
								</ul>
								<div class="tab-content" style="position:relative;">
									<div class="tab-pane fade in active" id="mensual">
										<table style="margin-top: 15%;">
										<?php if(isset($servicios)&&is_array($servicios)): ?>
											<tr class="text-center">
												<?php foreach ($servicios as $ks1 => $vs1): ?>
													<td class="graf"><?php if($vs1->cant>0):?>
														<span class="toltip">$50.00</span>
														<img src="<?=base_url()?>img/graf.png" width="20px" height="<?php echo 2*($vs1->cant+1)?>">
														<?php endif; ?>
													</td>

												<?php endforeach;?>
											</tr>
										<tr class="trserv">
											

											<?php foreach ($servicios as $ks => $vs): ?>
												<td><?=$vs->id?><div class="nomserv"><?=$vs->nombre?></div></td>
											<?php endforeach; endif;?>
										</tr>	
										</table>
												
												
										
									</div>
								    <div class="tab-pane fade" id="trimestral">
								    	
								    </div>
								    <div class="tab-pane fade" id="semestral">
								    	
								    </div>
								    <div class="tab-pane fade" id="anual">
								    	
								    </div>
								    <div class="tab-pane fade" id="dosa">
								    	
								    </div>
							    </div>
					</div>
				</div>	

				<div class="panel panel-default">
					<div class="panel-heading color">
					   	<h3 class="panel-title">Ingresos por clientes</h3>
					   	<span id="icono_panel" class="icon-stocks" ></span>
					</div>
					<div  class="panel-body" style="overflow: auto; height:400px;">
					 	<label for="from">From</label>
						<input type="text" class="form-control" id="from" name="from" style="width: 30%; display: inline-block">
						<label for="to">to</label>
						<input type="text" class="form-control" id="to" name="to" style="width: 30%; display: inline-block">
						<!-- <span id="span_ingreso" class="badge">$100,000</span>      -->
						
						<hr>
						 <ul class="nav nav-tabs" role="tablist">
							    	<li class="active"><a href="#mensualc" role="tab" data-toggle="tab">Mensual</a></li>
								  	<li><a href="#trimestralc" role="tab" data-toggle="tab">Trimestral</a></li>							  
								  	<li><a href="#semestralc" role="tab" data-toggle="tab">Semestral</a></li>
								  	<li><a href="#anualc" role="tab" data-toggle="tab">Anual</a></li>
								  	<li><a href="#dosac" role="tab" data-toggle="tab">2 años</a></li>
								</ul>
								<div class="tab-content" style="position:relative;">
									<div class="tab-pane fade in active" id="mensualc">
										<table style="margin-top: 15%;">
										<?php if(isset($clientes)&&is_array($clientes)): ?>
											<tr class="text-center">
												<?php foreach ($clientes as $ks1 => $vs1): ?>
													<td><?php
														?>
														<!-- <img src="<?=base_url()?>img/graf.png" width="20px" height="echo 2*($vs1->cant+1)?>"> -->
														<?php  //endif; ?>
													</td>

												<?php endforeach;?>
											</tr>
										<tr class="trserv">
											

											<?php foreach ($clientes as $kc => $vc): ?>
												<td><?=$vc->id?><div class="nomserv"><?=$vc->nombreComercial?></div></td>
											<?php endforeach; endif;?>
										</tr>	
										</table>
												
												
										
									</div>
								    <div class="tab-pane fade" id="trimestralc">
								    	
								    </div>
								    <div class="tab-pane fade" id="semestralc">
								    	
								    </div>
								    <div class="tab-pane fade" id="anualc">
								    	
								    </div>
								    <div class="tab-pane fade" id="dosac">
								    	
								    </div>
							    </div>
					</div>
				</div>		  
			<?php endif ?>
		</div>
	</section>
</div>  
<? 
	// script_tag("js/jquery-ui-1.9.2.custom.min.js").
	// script_tag('css/bootstrap-3.1.1-dist/js/collapse.js').
	// script_tag('css/bootstrap-3.1.1-dist/js/transition.js').
	// script_tag('css/bootstrap-3.1.1-dist/js/tap.js');
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