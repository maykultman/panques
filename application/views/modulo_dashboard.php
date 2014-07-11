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
	<section class="contenedor_principal_modulos" style="padding-top: 90px;">
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



	</section>
</div>	