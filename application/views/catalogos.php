<?=link_tag('css/estilos_modulo_usuarios.css');?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/usermovil.css">
<style type="text/css">
@media(max-width:767px){
	#menucatalogo{
		display: none;
		background: #0492e6;
		position: absolute;
		width: 100%;
		z-index: 20;
		margin-top: 70px;
	}
	#menu_modulo{ 
		background: #0492e6; 
		position: relative;
	}
	#pboton{
		display: block;
		right: 2%;
		font-size: 25px;
		color: #fff;
		padding-top: 4%;
		cursor: pointer;
		position: absolute;
		width: 100px;
		z-index: 30;
	}
}
@media(min-width: 768px){
#pboton{
	display: none;
	}
	#menucatalogo{
		display: block!important;
		background: #0492e6;
	}

}
#menucatalogo li a span{
	font-size: 30px;
}
#menucatalogo li{
	padding: 0%;
}
</style>
<?=link_tag('css/estilos_catalogo_servicios.css')?>
<div class="contenedor_modulo">  
	<section>
	   <h1 id="titulo_del_modulo"><label>Catálogos</label></h1>
	   	<nav id="menu_modulo" class="container-fluid">
		   	<div class="row">
		   		<p id="pboton"><span id="btn-menu" class="glyphicon glyphicon-align-justify"></span>&nbsp;Menu</p>
				<ul id="menucatalogo" class="nav nav-pills">
					<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		            	<a href="catalogo_empleados">		             	   
		                	 <span class="icon-businesscard2"></span><br>
		                	 Empleados
		                </a>
		            </li>
					
					 <li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		            	<a href="catalogo_perfiles">		             	   
		                	 <span class="icon-user"></span><br>
		                	 Perfiles
		                </a>
		            </li>
				    <li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		            	<a href="catalogo_puestos">
		                	<span class=" icon-avatar2"></span><br>
		                	Puestos
		                </a>
		            </li>
		            <li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		            	<a href="catalogo_roles">
		             	    <span class="icon-friends"></span><br>
		             	    Roles
		                </a>
		            </li>		  			       			
		 			<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		            	<a href="catalogo_servicios">		             	   
		                	 <span class="icon-websitebuilder"></span><br>
		                	 Servicios
		                </a>
		            </li>        
		            <li class="hidden-xs col-sm-2 col-md-2 col-lg-7"></li>                     
			    </ul>			    
			</div>
		</nav>	  
    </section>
    <section id="contenedor_principal_modulos" class="container"> 
		<div class="row">
<script type="text/javascript">
$('#pboton').click(function(){	$('ul.nav-pills').slideToggle('fast');	});
</script>