<?=link_tag('css/estilo_dashboard_gustavo.css').
	link_tag('css/theme.default.css');?>
<div class="contenedor_modulo">
	<section style="display: block; position: fixed; z-index: 1; width: 100%;" >		 
	   <h1 id="titulo_del_modulo" ><label>Escritorio</label></h1>
	   <nav>
			<ul id="menu_modulo" class="nav nav-pills">
				 <li>
	            	<a href="usuarios_consulta">
	             	   <div class="icono_menu_modulo">
	                	 <span class="icon-friends"></span>
	              	   </div>
	                   dashboard 13
	                </a>
	            </li>		  
				<li>
                	<a href="usuarios_nuevo">
                 		<div class="icono_menu_modulo">
                    		<span class="icon-uniF476"></span>
                  	    </div>
                        dashboard 2
                    </a>
                </li>                                              
		    </ul> 
		</nav>	  	
    </section>

	<section class="contenedor_principal_modulos" style="padding-top: 190px;">
	    <!-- prueba tabla con plugin de jquery -->
	    <div class="wrapper">
	   
	     <table id="table1" class="tablesorter">               
                <thead>
                    <tr>
                        <th class="sorter-false" >Todos <input id="todos" type="checkbox" name="todos"></th>

                        <th ></th>
                        <th>
                            <input class="search" type="search" placeholder="Search" data-column="all">
                        </th>
                        <th >Giro</th>
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
        <td>a</td>
        
        
            <td>b</td>
        
    
        
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
        <td>b</td>
        
        
            <td>a</td>
        
    
        
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
        <td>d</td>
        
        
            <td>c</td>
        
    
        
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
        <td>e</td>
        
        
            <td>d</td>
        
    
        
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
</div>


           
	

</section>     

   
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

<?=
script('js/tablas/jquery-latest.min.js').
script('js/tablas/jquery.tablesorter.js').
script('js/tablas/jquery.tablesorter.widgets.js').
script('js/tablas/widget-cssStickyHeaders.js').
script('js/tablas/estilo_tabla.js');
?>

 





<!-- <table class="table table-hover ">
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
					</table> -->



							<!-- 	<div class="panel panel-default">
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
		    </div> -->
graficaclientes

		    <?php //$servmes=0;?>
							<?php //while( $servmes < 12 ): ?>
								<!-- <div id="c<?//=$meses[$servmes];?>"  -->
									<?php 
										// if($servmes==0)
										// { 
										// 	echo 'class="tab-pane fade in active"'; 
										// }
										// else
										// {
										// 	echo 'class="tab-pane fade"';
										// }
									?> 
									<!-- <div class="parent">
										
										<?php //foreach($clientes as $gck => $gcv):?>										
											<div class="child" data-toggle="tooltip" data-placement="bottom" title="<?//=$gcv->nombreComercial;?>">
												<div class="barra" style="height:30%"><span class="max" data-toggle="tooltip" data-placement="top" title="<?//=(toMoney($gcv->pago));?>">$</span> 
											</div></div>
										<?php //endforeach;?>
									</div>
								</div>
							<?php //$servmes++; endwhile;?> -->