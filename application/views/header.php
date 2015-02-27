<header id="cabecera">
	<div id="divLogo">
		<a href="dashboard"><div id="logo"></div></a>
	</div>
	<div class="hidden-xs">
		<ul id="accesosRapidos" class="nav nav-pills">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					Nuevo <span class="icon-uniF476"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="cliente_nuevo">Cliente</a></li>
					<li><a href="contratos_nuevo">Contrato</a></li>
					<li><a href="cotizaciones_nuevo">Cotización</a></li>					
					<li><a href="proyectos_nuevo">Proyecto</a></li>
					<li><a href="usuarios_nuevo">Usuario</a></li><!---->
				</ul>
			</li>
		</ul>
	</div>

	
	<div id="divUsuario" class="hidden-xs">
		<div id="foto"><img class="img-circle pull-left" src="<?=base_url()?><?=$this->session->userdata('foto')?>"></div>
		<div class="usuario">
			<div id="nombre" class="datosU"><?=$this->session->userdata('usuario')?></div>
			<div id="perfil" class="datosU"><?=$this->session->userdata('perfil')?></div>
		</div>
		<div id="configuracionUsuario">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="">
						<span class="glyphicon glyphicon-cog"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Cambiar contraseña</a></li>
						<li><a href="logout">Cerrar sesión</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</header>	
