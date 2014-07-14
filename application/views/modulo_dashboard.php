<link rel="stylesheet" href="<?=base_url().'css/estilo_dashboard_gustavo.css'?>" type="text/css">
<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/collapse.js'?>">
</script>
<script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/transition.js'?>">
</script>
<script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/tap.js'?>">
</script>
<script>
  $(function() {
    $( "#datepicker" ).datepicker();
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
<div class="contenedor_modulo">  
	<section>
	   <h1 id="titulo_del_modulo" style="display: block; position: fixed; z-index: 3; width: 100%;"><label>Escritorio</label></h1>
	   <!-- <nav>
			<ul id="menu_modulo" class="nav nav-pills">
				 <li>
	            	<a href="modulo_usuarios_consulta">
	             	   <div class="icono_menu_modulo">
	                	 <span class="icon-friends"></span>
	              	   </div>
	                   dashboard 1
	                </a>
	            </li>		  
				<li>
                	<a href="modulo_usuarios_nuevo">
                 		<div class="icono_menu_modulo">
                    		<span class="icon-uniF476"></span>
                  	    </div>
                        dashboard 2
                    </a>
                </li>                                              
		    </ul> 
		</nav>	   -->	
    </section>
    <!-----------------------Dashboard 1 ---------------------------------------->	     
	<!-- <section class="contenedor_principal_modulos" style="padding-top: 90px;">
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
					   		<tr>
					   			<td>coliseoyuc.com</td>
					   			<td>04/05/14</td>
					   		</tr>
					   		<tr>
					   			<td>www.clinicadelsureste.com.mx</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>04/04/14</td>
					   		</tr>
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
								   		<tr>
								   			<td>clinica merida</td>
								   			<td>$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
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
								   		<tr>
								   			<td>clinica merida</td>
								   			<td>$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
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
		  				<div id="datepicker"></div>
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
						   		<tr>
						   			<td>Enviar email</td>
						   			<td>10/06/14</td>
						   			<td>10:00 am</td>
						   		</tr>
						   		<tr>
						   			<td>Junta qualium</td>
						   			<td>10/06/14 </td>
						   			<td>11:00 am</td>
						   		</tr>
						   		<tr>
						   			<td>visitar cliente</td>
						   			<td>10/06/14</td>
						   			<td>3:00 pm</td>
						   		</tr>
						   		<tr>
						   			<td>visitar cliente</td>
						   			<td>10/06/14</td>
						   			<td>3:00 pm</td>
						   		</tr>
						   		<tr>
						   			<td>visitar cliente</td>
						   			<td>10/06/14</td>
						   			<td>3:00 pm</td>
						   		</tr>
						   									   		

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
				   			<th>Prospecto</th>
				   			<th>Servicio</th>
				   			<th>Realizó</th>
				   			<th>Importe</th>
				   			<th>Fecha</th>
				   			<th>Tools</th>
				   		</tr>
				   	</thead>
				   	<tbody >
				   		<tr>
				   			<td>coliseoyuc.com</td>
				   			<td>04/05/14</td>
				   			<td>coliseoyuc.com</td>
				   			<td>04/05/14</td>
				   			<td>coliseoyuc.com</td>
				   			<td><span class="icon-download"></span>
				   				<span class=" icon-preview"></span>
				   			</td>
				   			
				   		</tr>
				   		<tr>
				   			<td>www.clinicadelsureste.com.mx</td>
				   			<td>04/04/14</td>
				   			<td>coliseoyuc.com</td>
				   			<td>04/05/14</td>
				   			<td>coliseoyuc.com</td>
				   			<td><span class="icon-download"></span></td>
				   			
				   		</tr>
				   		<tr>
				   			<td>postalia.com</td>
				   			<td>04/04/14</td>
				   			<td>coliseoyuc.com</td>				   			
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td><span class="icon-download"></span></td>
				   			
				   		</tr>
				   		<tr>
				   			<td>postalia.com</td>
				   			<td>04/04/14</td>
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td><span class="icon-download"></span></td>
				   			
				   		</tr>
				   		<tr>
				   			<td>postalia.com</td>
				   			<td>04/04/14</td>
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td><span class="icon-download"></span>
				   				

				   			</td>
				   			
				   		</tr>
				   		<tr>
				   			<td>postalia.com</td>
				   			<td>04/04/14</td>
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td><span class="icon-download"></span></td>				   			
				   			

				   		</tr>
				   		<tr>
				   			<td>postalia.com</td>
				   			<td>04/04/14</td>
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td><span class="icon-download"></span></td>
				   			
				   		</tr>
				   		<tr>
				   			<td>postalia.com</td>
				   			<td>04/04/14</td>
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td>coliseoyuc.com</td>
				   			<td><span class="icon-download"></span></td>
				   			
				   		</tr>
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
						<tr>							
							<td>Qualium</td>
							<td>CrmQualium</td>						
							<td>04/Agosto/2014</td>
							<td>			
								<span class="badge" style="background-color: #f89406; padding: 3px;">
									Quedan 31 días
								</span>		
							</td>      							
							<td>Dante Cervantes</td> 							        
				        </tr>
				        <tr>							
							<td>Qualium</td>
							<td>clinica de merida</td>						
							<td>04/Agosto/2014</td>
							<td>			
								<span class="badge" style="background-color: #f89406; padding: 3px;">
									Quedan 21 días
								</span>		
							</td>      							
							<td>Geyser Ramirez</td> 							        
				        </tr>
				        <tr>							
							<td>Qualium</td>
							<td>kefda Viajero</td>						
							<td>04/Agosto/2014</td>
							<td>			
								<span class="badge" style="background-color: #d9534f; padding: 3px;">
									Quedan 5 días
								</span>		
							</td>      							
							<td>Dante Cervantes</td> 							        
				        </tr>
				        <tr>							
							<td>Qualium</td>
							<td>app farah</td>						
							<td>04/Agosto/2014</td>
							<td>			
								<span class="badge" style="background-color: #d9534f; padding: 3px;">
									Quedan 5 días
								</span>		
							</td>      							
							<td>Dante Cervantes</td> 							        
				        </tr>
			    	</tbody> 
				</table>
			</div>
	    </div>
	</section> -->
	<!------------------------- Dashboard 2 -------------------------->
	<section class="contenedor_principal_modulos" style="padding-top: 90px;">
		<div class="row">
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
								   		<tr class="danger">
								   			<td>clinica merida</td>
								   			<td>$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr class="danger">
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
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
								   		<tr>
								   			<td>clinica merida</td>
								   			<td>$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   		<tr>
								   			<td>clinica merida</td>
								   			<td >$3,000.00</td>
								   			<td>04/05/14</td>
								   		</tr>
								   	</tbody>
								</table>	
						    </div>
					    </div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading color">
				    	<h3 class="panel-title">Entregas/Revisiones</h3>
				    	<span id="icono_panel" class=" icon-uniF5C7" ></span>
				    </div>
				  	<div  class="panel-body" style="overflow: auto; height: 250px;">
					   <table class="table table-hover ">
					   	<thead>
					   		<tr>
					   			<th>Proyecto</th>
					   			<th>Tipo</th>
					   			<th>Fecha</th>
					   		</tr>
					   	</thead>
					   	<tbody >
					   		<tr>
					   			<td>coliseoyuc.com</td>
					   			<td>Revisión</td>
					   			<td>04/05/14</td>
					   		</tr>
					   		<tr>
					   			<td>www.clinicadelsureste.com.mx</td>
					   			<td>Entrega</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Revisión</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Entrega</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Revisión</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Entrega</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Entrega</td>
					   			<td>04/04/14</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Entrega</td>
					   			<td>04/04/14</td>
					   		</tr>
					   	</tbody>
					   </table>
					</div>
				</div>
		  	</div>
		  	<div class="col-md-6">
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
					   	<tbody >
					   		<tr>
					   			<td>coliseoyuc.com</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>
					   		<tr>
					   			<td>www.clinicadeMerida.com.mx</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>
					   		<tr>
					   			<td>crmqualium.com</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>
					   		<tr>
					   			<td>postalia.com</td>
					   			<td>Página web</td>
					   			<td>$20,000</td>
					   		</tr>

					   	</tbody>
					   </table>
					</div>
				</div>
		  	</div>		  	
		</div>
		<div class="panel panel-default">
			<div class="panel-heading color">
		    	<h3 class="panel-title">Mis Actividades</h3>		    	
		    	<span id="icono_panel" class="icon-calendar2" ></span>
		    </div>
		  	<div class="panel-body">
		  		<div class="row">
		  			<div class="col-md-6" style="width: 25%  !important">
		  				<div id="datepicker"></div>
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
						   		<tr>
						   			<td>Enviar email</td>
						   			<td>10/06/14</td>
						   			<td>10:00 am</td>
						   		</tr>
						   		<tr>
						   			<td>Junta qualium</td>
						   			<td>10/06/14 </td>
						   			<td>11:00 am</td>
						   		</tr>
						   		<tr>
						   			<td>visitar cliente</td>
						   			<td>10/06/14</td>
						   			<td>3:00 pm</td>
						   		</tr>
						   		<tr>
						   			<td>visitar cliente</td>
						   			<td>10/06/14</td>
						   			<td>3:00 pm</td>
						   		</tr>
						   		<tr>
						   			<td>visitar cliente</td>
						   			<td>10/06/14</td>
						   			<td>3:00 pm</td>
						   		</tr>
						   	</tbody>
						</table>	
		  			</div>
		  		</div>		   
			</div>
	    </div>
	    <!-- prueba tabla con plugin de jquery -->
	    <table id="tbla_cliente" class="table table-striped tablesorter" >
               
                <thead style="background-color: #f9f9f9; color: #333;">
                    <tr>
                        <th>Todos <input id="todos" type="checkbox" name="todos"></th>

                        <th></th>
                        <th>
                            Nombre Comercial
                        </th>
                        <th>Giro</th>
                        <th>
                            Página web
                        </th>
                        <th style="text-align=center;">Ultima actividad</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody id="filasClientes">
                <tr>

        <td class="contenido_prospecto"><input type="checkbox" name="todos" value="53"></td>
        <td>
            
                <img src="img/fotosClientes/safe_image (12).jpg" alt="" class="foto">
            
        </td>
        <td>rafael cardenas</td>
        
        
            <td>Servicios públicos</td>
        
    
        
            <td>No especificado</td>
        

        <td>
            Módulo de actividad en construcción
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal53" title="Editar"></span>
            <span class="icon-email" data-toggle="tooltip" data-placement="top" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal53" title="Ver información"></span>
           
        </td>
    </tr><tr>

        <td class="contenido_prospecto"><input type="checkbox" name="todos" value="50"></td>
        <td>
            
                <img src="img/fotosClientes/dunosusa.png" alt="" class="foto">
            
        </td>
        <td>Dunosusa</td>
        
        
            <td>Comercial</td>
        
    
        
            <td>www.dunosusa.mx</td>
        

        <td>
            Módulo de actividad en construcción
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal50" title="Editar"></span>
            <span class="icon-email" data-toggle="tooltip" data-placement="top" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal50" title="Ver información"></span>
          
        </td>
    </tr><tr>

        <td class="contenido_prospecto"><input type="checkbox" name="todos" value="48"></td>
        <td>
            
                <img src="img/fotosClientes/undefined" alt="" class="foto">
            
        </td>
        <td>asdfsdf</td>
        
        
            <td>No especificado</td>
        
    
        
            <td>No especificado</td>
        

        <td>
            Módulo de actividad en construcción
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal48" title="Editar"></span>
            <span class="icon-email" data-toggle="tooltip" data-placement="top" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal48" title="Ver información"></span>
           
        </td>
    </tr><tr>

        <td class="contenido_prospecto"><input type="checkbox" name="todos" value="47"></td>
        <td>
            
                <img src="undefined" alt="" class="foto">
            
        </td>
        <td>NUEVOp</td>
        
        
            <td>No especificado</td>
        
    
        
            <td>No especificado</td>
        

        <td>
            Módulo de actividad en construcción
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal47" title="Editar"></span>
            <span class="icon-email" data-toggle="tooltip" data-placement="top" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal47" title="Ver información"></span>
          
           
        </td>
    </tr><tr>

        <td class="contenido_prospecto"><input type="checkbox" name="todos" value="46"></td>
        <td>
            
                <img src="undefined" alt="" class="foto">
            
        </td>
        <td>jose alberto</td>
        
        
            <td>No especificado</td>
        
    
        
            <td>No especificado</td>
        

        <td>
            Módulo de actividad en construcción
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal46" title="Editar"></span>
            <span class="icon-email" data-toggle="tooltip" data-placement="top" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal46" title="Ver información"></span>
          
        </td>
    </tr><tr>

        <td class="contenido_prospecto"><input type="checkbox" name="todos" value="45"></td>
        <td>
            
                <img src="rrr.jpg" alt="" class="foto">
            
        </td>
        <td>beto</td>
        
        
            <td>No especificado</td>
        
    
        
            <td>No especificado</td>
        

        <td>
            Módulo de actividad en construcción
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal45" title="Editar"></span>
            <span class="icon-email" data-toggle="tooltip" data-placement="top" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal45" title="Ver información"></span>
            
        </td>
    </tr><tr>

        <td class="contenido_prospecto"><input type="checkbox" name="todos" value="44"></td>
        <td>
            
                <img src="[object HTMLDivElement]" alt="" class="foto">
            
        </td>
        <td>beto</td>
        
        
            <td>No especificado</td>
        
    
        
            <td>No especificado</td>
        

        <td>
            Módulo de actividad en construcción
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal44" title="Editar"></span>
            <span class="icon-email" data-toggle="tooltip" data-placement="top" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal44" title="Ver información"></span>
          
        </td>
    </tr><tr>

        <td class="contenido_prospecto"><input type="checkbox" name="todos" value="43"></td>
        <td>
            
                <img src="[object HTMLDivElement]" alt="" class="foto">
            
        </td>
        <td>Si sirves</td>
        
        
            <td>No especificado</td>
        
    
        
            <td>No especificado</td>
        

        <td>
            Módulo de actividad en construcción
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal43" title="Editar"></span>
            <span class="icon-email" data-toggle="tooltip" data-placement="top" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal43" title="Ver información"></span>
           
           
        </td>
    </tr><tr>

        <td class="contenido_prospecto"><input type="checkbox" name="todos" value="40"></td>
        <td>
            
                <img src="web2.jpg" alt="" class="foto">
            
        </td>
        <td>rodrigo</td>
        
        
            <td>No especificado</td>
        
    
        
            <td>No especificado</td>
        

        <td>
            Módulo de actividad en construcción
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal40" title="Editar"></span>
            <span class="icon-email" data-toggle="tooltip" data-placement="top" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal40" title="Ver información"></span>
          
            
        </td>
    </tr><tr>

        <td class="contenido_prospecto"><input type="checkbox" name="todos" value="42"></td>
        <td>
            
                <img src="rrr.jpg" alt="" class="foto">
            
        </td>
        <td>José Alberto</td>
        
        
            <td>Transporte</td>
        
    
        
            <td>www.albertandasocities.com</td>
        

        <td>
            Módulo de actividad en construcción
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal42" title="Editar"></span>
            <span class="icon-email" data-toggle="tooltip" data-placement="top" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal42" title="Ver información"></span>
                      
        </td>
    </tr></tbody>
            </table>
	</section>	
</div>


<!-- jQuery -->
	<script src="js/jquery-latest.min.js"></script>	
	<!-- Tablesorter: theme -->
	<link class="theme" rel="stylesheet" href="../css/theme.default.css">
	<!-- Tablesorter script: required -->
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/jquery.tablesorter.widgets.js"></script>
	<script src="js/widget-cssStickyHeaders.js"></script>
	<script id="js">
	$(function(){

	var options = {
		widthFixed : true,
		showProcessing: true,
		headerTemplate: '{content} {icon}', // Add icon for jui theme; new in v2.7!

		widgets: [ 'zebra', 'cssStickyHeaders', 'filter' ],

		widgetOptions: {
			cssStickyHeaders_offset        : 0,
			cssStickyHeaders_addCaption    : true,
			cssStickyHeaders_attachTo      : null,
			cssStickyHeaders_filteredToTop : true,
			cssStickyHeaders_zIndex        : 10
		}

	};

	$("#table1").tablesorter(options);

});</script>
<script>
$(function() {
		$('select:first')
		.append(o)
		.change(function(){
			var theme = $(this).val().toLowerCase(),
				files = $('link.theme').each(function(){
					this.disabled = true;
				})
			files.filter('[href$="theme.' + theme + '.css"]').each(function(){
				this.disabled = false;
			});
			$('table')
				.removeClass('tablesorter-' + t.join(' tablesorter-') + ' tablesorter-jui')
				.addClass('tablesorter-' + theme.replace(/-/,''));
		}).change();
});
</script>	