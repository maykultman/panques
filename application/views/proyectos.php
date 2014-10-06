<?= script_tag('js/tablas/jquery-latest.min.js').
    script_tag('js/tablas/jquery.tablesorter.js').
    script_tag('js/tablas/jquery.tablesorter.widgets.js').
    script_tag('js/tablas/widget-cssStickyHeaders.js').
    script_tag('js/tablas/estilo_tabla.js');
?>
<?=script_tag('js/jquery-ui-1.10.4.custom.js');?>
<div class="contenedor_modulo"> 
<!-- <div id="contenedor"> -->
	<section>
	   <h1 id="titulo_del_modulo"><label>Proyectos</label></h1>
	   <nav>
			<ul id="menu_modulo" class="nav nav-pills">
				<li>
					<a href="proyectos_cronograma">
					<div class="icono_menu_modulo">
						<span class="icon-diskspace2"></span>
				    </div>
					Cronogroma
		            </a>
				</li>
	  			<li>
					<a href="proyectos_consulta">
					<div class="icono_menu_modulo">
						<span class="icon-uniF64E"></span>
				    </div>
			        Proyectos
			        </a>
				</li>          			
     			<li>
                	<a href="proyectos_nuevo">
                 		<div class="icono_menu_modulo">
                    		<span class="icon-uniF476"></span>
                  	    </div>
                        Nuevo
                    </a>
                </li>        
		    </ul>		   
	    </nav>		  
   </section>
<section class="contenedor_principal_modulos"> 