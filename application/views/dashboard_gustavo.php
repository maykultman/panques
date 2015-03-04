<?=	link_tag('css/estilo_dashboard_gustavo.css').
	link_tag('css/graficas.css').
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
					<div  class="panel-body" style="height:570px;">
					 	<label for="from">From</label>
						<input type="text" class="form-control from" name="from" style="width: 30%; display: inline-block">
						<label for="to">to</label>
						<input type="text" class="form-control to" name="to" style="width: 30%; display: inline-block">
						
						<hr>
						<ul class="nav nav-tabs" role="tablist">
							<ul class="nav nav-tabs" role="tablist">
						   	<li class="active"><a href="#sEnero" role="tab" data-toggle="tab"> Enero </a></li>
						  	<li><a href="#sFebrero" role="tab" data-toggle="tab"> Febrero </a></li>							  
						  	<li><a href="#sMarzo" role="tab" data-toggle="tab"> Marzo </a></li>
						  	<li><a href="#sAbril" role="tab" data-toggle="tab"> Abril </a></li>
						  	<li><a href="#sMayo" role="tab" data-toggle="tab"> Mayo </a></li>
						  	<li><a href="#sJunio" role="tab" data-toggle="tab"> Junio </a></li>
						  	<li><a href="#sJulio" role="tab" data-toggle="tab"> Julio </a></li>
						  	<li><a href="#sAgosto" role="tab" data-toggle="tab"> Agosto </a></li>
						  	<li><a href="#sSeptiembre" role="tab" data-toggle="tab"> Septiembre </a></li>
						  	<li><a href="#sOctubre" role="tab" data-toggle="tab"> Octubre </a></li>
						  	<li><a href="#sNoviembre" role="tab" data-toggle="tab"> Noviembre </a></li>
						  	<li><a href="#sDiciembre" role="tab" data-toggle="tab"> Diciembre </a></li>						
						</ul>
						<div class="tab-content" style="position:relative;">
						
							<div class="tab-pane fade in active" id="sEnero">
								<div class="parent">
									<img src="<?=base_url()?>img/logoQualium.png">
									<?php $while=0; while($while < 25): ?>
									<div class="child" data-toggle="tooltip" data-placement="bottom" title="Servicio<?=$while?>"> <div class="barra" style="height:<?=$while?>%"><span class="max" data-toggle="tooltip" data-placement="top" title="$1000.00">$</span> </div> </div>
									<?php $while++; endwhile;?>
								</div>
							</div>
							<div class="tab-pane fade" id="sFebrero">s1</div>
							<div class="tab-pane fade" id="sMarzo">s2</div>
							<div class="tab-pane fade" id="sAbril"></div>
							<div class="tab-pane fade" id="sMayo"></div>
							<div class="tab-pane fade" id="sJunio"></div>
							<div class="tab-pane fade" id="sJulio"></div>
							<div class="tab-pane fade" id="sAgosto"></div>
							<div class="tab-pane fade" id="sSeptiembre"></div>
							<div class="tab-pane fade" id="sOctubre"></div>
							<div class="tab-pane fade" id="sNoviembre"></div>
							<div class="tab-pane fade" id="sDiciembre"></div>
						</div>		
					</div>
				</div>	

				<div class="panel panel-default">
					<div class="panel-heading color">
					   	<h3 class="panel-title">Ingresos por clientes</h3>
					   	<span id="icono_panel" class="icon-stocks" ></span>
					</div>
					<div  class="panel-body" style="overflow: auto; height:600px;">
					 	<label for="from">From</label>
						<input type="text" class="form-control from" name="from" style="width: 30%; display: inline-block">
						<label for="to">to</label>
						<input type="text" class="form-control to" name="to" style="width: 30%; display: inline-block">
						<!-- <span id="span_ingreso" class="badge">$100,000</span>      -->
						<hr>
						<ul class="nav nav-tabs" role="tablist">
						   	<li class="active"><a href="#cEnero" role="tab" data-toggle="tab"> Enero </a></li>
						  	<li><a href="#cFebrero" role="tab" data-toggle="tab"> Febrero </a></li>							  
						  	<li><a href="#cMarzo" role="tab" data-toggle="tab"> Marzo </a></li>
						  	<li><a href="#cAbril" role="tab" data-toggle="tab"> Abril </a></li>
						  	<li><a href="#cMayo" role="tab" data-toggle="tab"> Mayo </a></li>
						  	<li><a href="#cJunio" role="tab" data-toggle="tab"> Junio </a></li>
						  	<li><a href="#cJulio" role="tab" data-toggle="tab"> Julio </a></li>
						  	<li><a href="#cAgosto" role="tab" data-toggle="tab"> Agosto </a></li>
						  	<li><a href="#cSeptiembre" role="tab" data-toggle="tab"> Septiembre </a></li>
						  	<li><a href="#cOctubre" role="tab" data-toggle="tab"> Octubre </a></li>
						  	<li><a href="#cNoviembre" role="tab" data-toggle="tab"> Noviembre </a></li>
						  	<li><a href="#cDiciembre" role="tab" data-toggle="tab"> Diciembre </a></li>
						</ul>
						<div class="tab-content" style="position:relative;">
							<!-- <div class="tab-pane fade in active" id="mensualc">
								<table style="margin-top: 15%;">
									<?php //if(isset($clientes)&&is_array($clientes)): ?>
										<tr class="text-center">
											<?php //foreach ($clientes as $ks1 => $vs1): ?>
												<td><?php
													?>
													<img src="<?=base_url()?>img/graf.png" width="20px" height="echo 2*($vs1->cant+1)?>">
													<?php  //endif; ?>
												</td>

											<?php //endforeach;?>
										</tr>
										<tr class="trserv">
											

											<?php //foreach ($clientes as $kc => $vc): ?>
												<td><?//=$vc->id?><div class="nomserv"><?=$vc->nombreComercial?></div></td>
											<?php //endforeach; endif;?>
										</tr>	
								</table>
							</div> -->
							
							<div class="tab-pane fade in active" id="cEnero">c</div>
							<div class="tab-pane fade" id="cFebrero">c1</div>
							<div class="tab-pane fade" id="cMarzo">c2</div>
							<div class="tab-pane fade" id="cAbril"></div>
							<div class="tab-pane fade" id="cMayo"></div>
							<div class="tab-pane fade" id="cJunio"></div>
							<div class="tab-pane fade" id="cJulio"></div>
							<div class="tab-pane fade" id="cAgosto"></div>
							<div class="tab-pane fade" id="cSeptiembre"></div>
							<div class="tab-pane fade" id="cOctubre"></div>
							<div class="tab-pane fade" id="cNoviembre"></div>
							<div class="tab-pane fade" id="cDiciembre"></div>
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