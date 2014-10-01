<!-- //plugin selectize css -->
 <!-- Librerias para el scroll de la tabla -->
    <?= script_tag('js/tablas/jquery-latest.min.js').
        script_tag('js/tablas/jquery.tablesorter.js').
        script_tag('js/tablas/jquery.tablesorter.widgets.js').
        script_tag('js/tablas/widget-cssStickyHeaders.js').
        script_tag('js/tablas/estilo_tabla.js');
    ?> 
    <?=script_tag('js/plugin/selectize/selectize.min.js').
 		link_tag('css/theme.default.css').
        //plugin selectize css
        link_tag('js/plugin/selectize/selectize.default.css');?>
  <?=script_tag('js/backbone/lib/backbone.js')?>
  
      
<div class="contenedor_modulo"> 
<!-- <div id="contenedor"> -->
	<section>
		<h1 id="titulo_del_modulo"><label>Clientes</label></h1>
	   <nav>
			<ul id="menu_modulo" class="nav nav-pills">
     			<li >
                	<a href="cliente_nuevo">
                 	   	<div class="icono_menu_modulo">
                    		<span class="icon-uniF476"></span>
                  	   	</div>
                  		Nuevo
                    </a>
                </li>

				<li>
					<a href="consulta_prospectos">
						<div class="icono_menu_modulo">
							<span class="icon-contact"></span>
						</div>
						Prospectos
		            </a>
				</li>

	  			<li>
					<a href="consulta_clientes">
						<div class="icono_menu_modulo">
							<span class="icon-phpbb"></span>
					    </div>
				        Clientes
			        </a>
				</li> 

     			<li >
                	<a href="consulta_clientes_eliminados">
                 	   	<div class="icono_menu_modulo">
                    		<span class="icon-trash"></span>
                  	   	</div>
                  		Papelera
                    </a>
                </li>        		     
		    </ul>
	    </nav>		  
	</section>
<section class="contenedor_principal_modulos"> 