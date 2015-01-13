<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>" type="text/css">
<!--plugin selectize css-->
<?= script_tag('js/plugin/selectize/selectize.min.js').

	link_tag('css/theme.default.css').
	link_tag('js/plugin/selectize/selectize.default.css');?>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/usermovil.css">

<div class="contenedor_modulo">  
	<section>
	   <h1 id="titulo_del_modulo"><label>Usuarios</label></h1>
	   <nav>
			<ul id="menu_modulo" class="nav nav-pills">
				 <li>
	            	<a href="usuarios_consulta">
	             	   <div class="icono_menu_modulo">
	                	 <span class="icon-friends"></span>
	              	   </div>
	                   Usuarios
	                </a>
	            </li>		  
				<li>
                	<a href="usuarios_nuevo">
                 		<div class="icono_menu_modulo">
                    		<span class="icon-uniF476"></span>
                  	    </div>
                        Nuevo
                    </a>
                </li>                                              
		    </ul> 
		</nav>	  
    </section>
<section id="contenedor_principal_modulos" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
