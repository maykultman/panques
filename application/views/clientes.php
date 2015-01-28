<?php $modulos = $this->session->userdata('Clientes'); ?>
<div class="contenedor_modulo"> 
	<h1 id="titulo_del_modulo"><label>Clientes</label></h1>
		<nav id="menu_modulo" class="container-fluid">
		 	<div class="row">
				<ul id="menucatalogo" class="nav nav-pills">
					<?php if(isset($modulos[0]['permisos'])){?>
					<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
						<a href="cliente_nuevo">						
							<span class="icon-uniF476"></span><br>	
							Nuevo
						</a>
					</li><?php }
					if(isset($modulos[1]['permisos'])){?>
					<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
						<a href="consulta_prospectos">						
							<span class="icon-contact"></span><br>
							Prospectos
						</a>
					</li>
					<?php }
					if(isset($modulos[2]['permisos'])){?>
					<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
						<a href="consulta_clientes">
							<span class="icon-phpbb"></span><br>
							Clientes
						</a>
					</li> 
					<?php }
					if(isset($modulos[2]['permisos'])){?>
					<li class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
						<a href="consulta_clientes_eliminados">
							<span class="icon-trash"></span><br>
							Papelera
						</a>
					</li>  <?php } ?>      		     
				</ul>
			</div>
		</nav>		  	
<section id="contenedor_principal_modulos" class="container-fluid" style="padding-left:4%;padding-right:3%;"> 
<div class="row">