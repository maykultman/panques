<?=	link_tag('css/estilo_dashboard_gustavo.css').
	link_tag('css/graficas.css').
	link_tag('css/theme.default.css');
?>
<?php 
// setlocale (LC_TIME, "es_ES"); 


function pagoz($arg)
{	
	echo '<table class="table table-striped">
			<thead><tr><th>Cliente</th><th>Monto</th><th>Vencimiento</th><th>Pagar</th></tr></thead>
			<tbody>';

	foreach ($arg as $pik => $piv) 
	{ 	
		$class = 'alert';
		$class .= ($piv['fechapago'] < date('Y-m-d')) ? ' alert-danger': ' alert-success';				
		echo "<tr>
			<td>".$piv['cliente']."</td>
			<td>$".number_format($piv['pago'], 2)."</td>
			<td><span class='".$class."' style='padding:0 5px;'>".strftime('%d, %b %Y',strtotime($piv['fechapago']))."</span>
			</td><td><span class='icon-uniF4E7 span_pagos' data-toggle='modal' data-target='bs-example-modal-sm2' title='Pagos'></span></td>
		</tr>";
	}
	echo "</tbody></table>";
} 

function toMoney($val)
{
	$symbol='$'; $r=2;

    $n = $val; 
    $c = is_float($n) ? 1 : number_format($n,$r);
    $d = '.';
    $t = ',';
    $sign = ($n < 0) ? '-' : '';
    $i = $n=number_format(abs($n),$r); 
    $j = (($j = count($i)) > 3) ? $j % 3 : 0; 

   return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;

}
?>

<div class="contenedor_modulo">
	<h1 id="titulo_del_modulo" style="display: block; position: fixed; z-index: 1; width: 100%;"><label>Escritorio</label></h1>
    
	<section class="container" style="padding-top:8%;">
		<div class="row">
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
						   			<th>Cliente</th>
						   			<th>Monto</th>
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
								<div class="tab-pane fade in active" id="iguala" style="overflow:auto;height:185px;position:relative;">
									<?php 
									$div = '<div style="border-radius:0 0 5px 5px;position:absolute;width:100%;height: 100%;"></div><h3 style="padding:10%0;text-align: center;">No hay pagos pendientes por el momento</h3>';
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
				    <table class="table table-striped">
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
					<div  class="panel-body" style="height:570px;">
					 	<label for="from">From</label>
						<input type="text" class="form-control from" name="from" style="width: 30%; display: inline-block">
						<label for="to">to</label>
						<input type="text" class="form-control to" name="to" style="width: 30%; display: inline-block">
						
						<hr>
						<ul class="nav nav-tabs" role="tablist">
							<?php 
								$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
								// $mesesi = array('January' ,'February' ,'March' ,'April' ,'May' ,'June' ,'July' ,'August' ,'September' ,'October' ,'November' ,'December');
								$mesesi = array('01','02','03','04','05','06','07','08','09','10','11','12');
								$servmes =0;
							?>
							<?php while( $servmes < 12 ): ?>
								<li <?php if($servmes==0){ echo 'class="active"';}?> >
									<a href="#s<?=$meses[$servmes];?>" role="tab" data-toggle="tab"><?=$meses[$servmes]?></a>
								</li>
							<?php $servmes++; endwhile;?>
						</ul>
						<div class="tab-content" style="position:relative;">
							<img src="<?=base_url()?>img/logoQualium.png">
							<?php $servmes=0;?>
							<?php while( $servmes < 12 ): ?>
								<div id="s<?=$meses[$servmes];?>" 
									<?php 
										if($servmes==0)
										{ 
											echo 'class="tab-pane fade in active"'; 
										}
										else
										{
											echo 'class="tab-pane fade"';
										}
								?> >
									<div class="parent">									
										<?php $while=0; foreach($servicios as $sk => $sv): ?>
											<div class="child" data-toggle="tooltip" data-placement="bottom" title="Servicio<?=$sv['nombre']?>"> <div class="barra" style="height:<?=($sv['idservicio'] / $sv['id'])?>%"><span class="max" data-toggle="tooltip" data-placement="top" title="$1000.00">$</span> </div> </div>
										<?php $while++; endforeach;?>
									</div> 
								</div>
							<?php $servmes++; endwhile;?>
						</div>		
					</div>
				</div>	

				<div class="panel panel-default">
					<div class="panel-heading color">
					   	<h3 class="panel-title">Ingresos por clientes</h3>
					   	<span id="icono_panel" class="icon-stocks" ></span>
					</div>
					<div  class="panel-body" style="height:600px;">
						
						<div class="col-md-4">
							<select class="form-control">
								<?php $cont=1;?>
								<?php while($cont < 20):?>
									<option value="<?=( 2014 + $cont)?>"><?=( 2014 + $cont)?></option>
								<?php $cont++; endwhile; ?>
							</select>
						</div>
						<div class="col-md-4">
							<div class="btn btn-default">Buscar</div>
						</div>
						<div class="clearfix"></div>
					 	<!-- <label for="from">From</label>
						<input type="text" class="form-control from" name="from" style="width: 30%; display: inline-block">
						<label for="to">to</label>
						<input type="text" class="form-control to" name="to" style="width: 30%; display: inline-block"> -->
						<hr>
						<ul class="nav nav-tabs" role="tablist">
							<?php $servmes=0;?>
							<?php while( $servmes < 12 ): ?>
								<li <?php if($servmes==0){ echo 'class="active"';}?> >
									<a href="#c<?=$meses[$servmes];?>" role="tab" data-toggle="tab"><?=$meses[$servmes]?></a>
								</li>
							<?php $servmes++; endwhile;?>
						</ul>
						<div class="tab-content" style="position:relative;">
							<?php 
								$servmes=0; 
								$fecha = date('Y-m');
							?>
							<?php while( $servmes < 12 ): ?>
								<div id="c<?=$meses[$servmes];?>" 
									<?php 
										if($servmes==0)
										{ 
											echo 'class="tab-pane fade in active"'; 
										}
										else
										{
											echo 'class="tab-pane fade"';
										}
								?> >
									
									<table class="table table-striped">
										<thead>
											<th>Cliente</th>
											<th>Ingresos</th>
										</thead>
										<tbody>
											<?php foreach($clientes as $gck => $gcv):?>
												<?php if( $mesesi[$servmes] ==  explode('-',$gcv->fechapago)[1] ):?>
													<tr>
														<td><?=$gcv->nombreComercial;?></td><td><?=toMoney($gcv->pago);?></td>
													</tr>
												<?php endif;?>
											<?php endforeach; ?>
										</tbody>
									</table>

								</div>
							<?php $servmes++; endwhile;?>
							
							
						</div>
					</div>
				</div>	<!--panel panel-default-->
			<?php endif ?>
		</div>
	</section>
</div>  

<script>
  	$(function() {
	    $( ".to" ).datepicker({dateFormat:'YYY', changeYear: true});
	  	
  		$('[data-toggle="tooltip"]').tooltip();
	    // $( ".from" ).datepicker({
	    //   	defaultDate: "+1w",
	    //   	// changeMonth: true,
	    //   	// numberOfMonths: 3,
	    //   	onClose: function( selectedDate ) {
	    //     	// $( ".to" ).datepicker( "option", "minDate", selectedDate );
	    //     	$(".to").datepicker({changeYear: true});
	    // 	}
    	// });

    	// $( ".to" ).datepicker({
     //  		defaultDate: "+1w",
     //  		// changeMonth: true,
     //  		// numberOfMonths: 3,
     //  		onClose: function( selectedDate ) {
     //    		$( ".from" ).datepicker( "option", "maxDate", selectedDate );
     //  		}
    	// });
  });
</script>