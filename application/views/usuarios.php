<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>" type="text/css">
<!--plugin selectize css-->
<?= script_tag('js/plugin/selectize/selectize.min.js').

	link_tag('css/theme.default.css').
	link_tag('js/plugin/selectize/selectize.default.css');?>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/usermovil.css">

<div class="contenedor_modulo">  
	<h1 id="titulo_del_modulo"><label>Usuarios</label></h1>
	<p id="pboton"><span id="btn-menu" class="glyphicon glyphicon-align-justify"></span>&nbsp;Menu</p>
	<nav id="menu_modulo" class="container-fluid">
	   	<div class="row">
			<ul id="menucatalogo" class="nav nav-pills">
				<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
	            	<a href="usuarios_consulta">	             	  
	                	<span class="icon-friends"></span><br>Usuarios
	                </a>
	            </li>		  
				<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
                	<a href="usuarios_nuevo">
                 		<span class="icon-uniF476"></span><br>Nuevo
                    </a>
                </li>                                              
		    </ul> 
		</div>
	</nav>	  
<section id="contenedor_principal_modulos" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:11%;"> 
