<?=script_tag('js/tablas/jquery-latest.min.js').
    script_tag('js/tablas/jquery.tablesorter.js').
    script_tag('js/tablas/jquery.tablesorter.widgets.js').
    script_tag('js/tablas/widget-cssStickyHeaders.js').
    script_tag('js/tablas/estilo_tabla.js');
?>
	<div class="contenedor_modulo">
		<section id="cabecera_modulo">
			<h1 id="titulo_del_modulo"><label>Cotizaciones</label></h1>
			<nav>
				<ul id="menu_modulo" class="nav nav-pills">
					<li>
						<a href="cotizaciones_consulta">
							<div class="icono_menu_modulo">
								<span class="icon-rawaccesslogs"></span>
							</div>
							Cotizaciones
						</a>
					</li>
					<li>
						<a href="cotizaciones_nuevo">
							<div class="icono_menu_modulo">
								<span class="icon-calculator"></span>
							</div>
							Nuevo
						</a>
					</li>
				</ul>
			</nav>
		</section>
		<section id="formulario_nueva_cotizacion">
		