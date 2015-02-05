<?=
	link_tag('css/estilos_modulo_contratos.css');
?>
<?php 
$modulos = $this->session->userdata('Contratos');

function activaCatalogo($activalink)
{
	$catalogos=array();
	foreach ($activalink as $key => $value) 
	{
		if(isset($value['permisos']))
		{
			$catalogos[] = $value['nombre'];
		}
	}			
	return $catalogos;
}
?>
<div class="contenedor_modulo"> 
    <h1 id="titulo_del_modulo"><label>Contratos</label></h1>
	<nav id="menu_modulo" class="container-fluid">
	    <ul id="menucatalogo" class="nav nav-pills" style="margin-left:-13px;">
	    	<?php 
			$mod = activaCatalogo($modulos);
			if(in_array('Nuevo', $mod)){
			?>
				<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
		           	<a href="contratos_nuevo">
		              	<span class="icon-uniF476"></span><br>
		                   Nuevo
		            </a>
	       		</li>   
			<?php } $mod = activaCatalogo($modulos);
			if(in_array('Contratos', $mod)){
			?>
				<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
					<a href="contratos_historial">
						<span class="icon-draft"></span><br>
						Historial
		        	</a>
				</li>
			<?php } 
			$mod = activaCatalogo($modulos);
			if(in_array('Papelera', $mod)){
			?>
				<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
					<a href="contratos_papelera">
						<span class="icon-trash"></span><br>			
						Papelera
			        </a>
				</li>	
			<?php } ?>
		</ul> 
	</nav>	  