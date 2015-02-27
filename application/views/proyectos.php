<?php 
$modulos = $this->session->userdata('Proyectos');

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
	<h1 id="titulo_del_modulo"><label>Proyectos</label></h1>
	<nav id="menu_modulo" class="container-fluid">
		<ul id="menucatalogo" class="nav nav-pills">
			<?php 
			$mod = activaCatalogo($modulos);
			if(in_array('Nuevo', $mod)){
			?>
			<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1" style="margin-left:-13px;">
				<a href="proyectos_nuevo">
					<span class="icon-uniF476"></span><br>
					Nuevo
				</a>
			</li>
			<?php } 
			$mod = activaCatalogo($modulos);
			if(in_array('Proyectos', $mod)){
			?>
			<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
				<a href="proyectos_consulta">
					<span class="icon-uniF64E"></span><br>
					Proyectos
				</a>
			</li>
			<?php }
			$mod = activaCatalogo($modulos);
			if(in_array('Cronograma', $mod)){
			?>
			<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
				<a href="proyectos_cronograma">
					<span class="icon-diskspace2"></span><br>
					Cronogroma
				</a>
			</li>
			<?php } ?>
		</ul>
	</nav>
<?=link_tag('css/estilos_modulo_proyectos.css');?>	