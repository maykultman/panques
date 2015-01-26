<meta charset="utf-8">
<div id="contenedor">
<div id="block"> <p>Por favor espere...</p> </div>
<input type="checkbox" id="btn_menu" checked>
<?php 
//$modulos = $this->session->userdata('permisos');
function permiso($submodulos)
{ 
	$band = 0;
    foreach ($submodulos as $key) 
    {
        if(array_key_exists('permisos', $key) )
        {
            $band = 1;
        }
    }
    return $band;
}
?>
<nav id="menu" role="navigation">
<ul id="menu-lista">	
	<li class="item">
		<a class="anclaMenu" href="dashboard" title="Escritorio"><span class="icono icon-uniF006" style="float:left"></span> <span class="item-text">Escritorio</span></a>
		<div style="clear:both"></div>
	</li>
	<?php
	// var_dump($this->session->userdata('Clientes')); die();
		$print = permiso($this->session->userdata('Clientes')['submodulos']);
	 	if($this->session->userdata('Clientes')['nombre']=='Clientes'&&$print==1){?>	   
		<li class="item">
			<a class="anclaMenu" href="consulta_clientes" title="Clientes"><span class="icono icon-phpbb" style="float:left"></span> <span class="item-text">Clientes</span></a>
			<div style="clear:both"></div>
		</li>
	<?php } 
	$print = permiso($this->session->userdata('Proyectos')['submodulos']);
	
	if($this->session->userdata('Proyectos')['nombre']=='Proyectos'&&$print==1){?>
	<li class="item">
		<a class="anclaMenu" href="proyectos_consulta" title="Proyectos"><span class="icono icon-uniF53D" style="float:left"></span> <span class="item-text">Proyectos</span></a>
		<div style="clear:both"></div>
	</li>
	<?php }
	$print = permiso($this->session->userdata('Contratos')['submodulos']);
	if($this->session->userdata('Contratos')['nombre']=='Contratos'&&$print==1){?>
	<li class="item">
		<a class="anclaMenu" href="contratos_historial" title="Contratos"><span class="icono icon-uniF5E2" style="float:left"></span> <span class="item-text">Contratos</span></a>
		<div style="clear:both"></div>
	</li>
	<?php }  

	$print = permiso($this->session->userdata('Cotizaciones')['submodulos']);
	if($this->session->userdata('Cotizaciones')['nombre']=='Cotizaciones'&&$print==1){?>
	<li class="item">
		<a class="anclaMenu" href="cotizaciones_consulta" title="Cotización"><span class="icono icon-calculator" style="float:left"></span> <span class="item-text">Cotización</span></a>
		<div style="clear:both"></div>
	</li>
	<?php } 
	$print = permiso($this->session->userdata('Actividades')['submodulos']);
	if($this->session->userdata('Actividades')['nombre']=='Actividades'&&$print==1){?>
	<li class="item">
		<a class="anclaMenu" href="#" title="Actividades"><span class="icono icon-calendar2" style="float:left"></span> <span class="item-text">Actividades</span></a>
		<div style="clear:both"></div>
	</li>
	<?php } 
	
	$print = permiso($this->session->userdata('Catálogos')['submodulos']);
	if($this->session->userdata('Catálogos')['nombre']=='Catálogos'&&$print==1){
		$href='';
		$variable = $this->session->userdata('Catálogos')['submodulos'];		
		foreach ($variable as $key=>$valu) {			
			if(isset($valu['permisos']))
			{	$href = 'catalogo_'.$valu['nombre'];
				break;
			}
		}		
	?>
	<li class="item">
		<a class="anclaMenu" href="<?=$href?>" title="Catálogos"><span class="icono icon-book" style="float:left"></span> <span class="item-text">Catálogos</span></a>
		<div style="clear:both"></div>
	</li>
	<?php } 
	$print = permiso($this->session->userdata('Usuarios')['submodulos']);
	if($this->session->userdata('Usuarios')['nombre']=='Usuarios'&&$print==1){?>
	<li class="item">
		<a class="anclaMenu" href="usuarios_consulta" title="Usuarios"><span class="icono icon-user" style="float:left"></span> <span class="item-text">Usuarios</span></a>
		<div style="clear:both"></div>
	</li>
	<?php } ?>
	
	<li class="item">
		<a class="anclaMenu" href="configuracion" title="Configuración"><span class="icono icon-uniF00F" style="float:left"></span> <span class="item-text">Configuración</span></a>
		<div style="clear:both"></div>
	</li>
	
	<li class="item">
		<label  for="btn_menu" style="display:block !important"><span class="icono icon-uniF472" id="btn" style="float:left"></span></label>
		<div style="clear:both"></div>
	</li>

</ul>
</nav>