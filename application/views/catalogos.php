<?=link_tag('css/estilos_modulo_usuarios.css');?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/usermovil.css">
<?=link_tag('css/estilos_catalogo_servicios.css')?>
<?php 
$modulos = $this->session->userdata('Catálogos');
function activaCatalogo($activalink)
{
	$catalogos=array();
	foreach ($activalink as $key => $value) {
		if(isset($value['permisos']))
		{
			$catalogos[] = 'catalogo_'.$value['nombre'];
		}
	}			
	return $catalogos;
}?>
<div class="contenedor_modulo">  	
	<h1 id="titulo_del_modulo"><label>Catálogos</label></h1>
	   	<nav id="menu_modulo" class="container-fluid">
		   	<div class="row">
		   		<p id="pboton"><span id="btn-menu" class="glyphicon glyphicon-align-justify"></span>&nbsp;Menu</p>
				<ul id="menucatalogo" class="nav nav-pills">
					<?php 
					$mod = activaCatalogo($modulos);										
					if(in_array('catalogo_Empleados', $mod)){
					?>

					<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		            	<a href="catalogo_Empleados">		             	   
		                	 <span class="icon-businesscard2"></span><br>
		                	 Empleados
		                </a>
		            </li>
					<?php }?>
					<?php 
					$mod = activaCatalogo($modulos);
					if(in_array('catalogo_Perfiles', $mod)){
					?>
					 <li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		            	<a href="catalogo_Perfiles">		             	   
		                	 <span class="icon-user"></span><br>
		                	 Perfiles
		                </a>
		            </li><?php }
		            $mod = activaCatalogo($modulos);
					if(in_array('catalogo_Puestos', $mod)){
		            ?>
				    <li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		            	<a href="catalogo_Puestos">
		                	<span class=" icon-avatar2"></span><br>
		                	Puestos
		                </a>
		            </li>
		            <?php }
		            $mod = activaCatalogo($modulos);
					if(in_array('catalogo_Roles', $mod)){
		            ?>
		            <li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		            	<a href="catalogo_Roles">
		             	    <span class="icon-friends"></span><br>
		             	    Roles
		                </a>
		            </li>
		            <?php }
		            $mod = activaCatalogo($modulos);
					if(in_array('catalogo_Roles', $mod)){
		            ?>		  			       			
		 			<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		            	<a href="catalogo_Servicios">		             	   
		                	 <span class="icon-websitebuilder"></span><br>
		                	 Servicios
		                </a>
		            </li>  
		            <?php } ?>      
		            <li class="hidden-xs col-sm-2 col-md-2 col-lg-7"></li>                     
			    </ul>			    
			</div>
		</nav>	      
    <section id="contenedor_principal_modulos" class="container"> 
		<div class="row">
<script type="text/javascript">
$('#pboton').click(function(){	$('ul.nav-pills').slideToggle('fast');	});
</script>