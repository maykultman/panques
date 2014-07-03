<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<section id="catalogo_Perfiles">
		<h1>Inserción</h1>
		<form id="formPerfiles">
			<input type="text" id="perfil" name="nombre" placeholder="nombre" >
			<button id="enviar">Enviar</button>
		</form>
	</section>
	<hr>
	<section>
		<h1>Consulta</h1>
		<div  id="consulta_Perfiles">
			<table id="perfiles">
				
			</table>
		</div>
	</section>
</body>
</html>
<script type="text/plantilla" id="plantilla_perfil">
	<td> <%- perfil %>  <input type="text" name="perfil" value="<%- perfil %>" class="actualizar_atributo"> </td>
	<td> <%- status %>  <input type="text" name="status" value="<%- status %>" class="actualizar_atributo"> </td>
</script>
<!-- Librerias -->
<script type="text/javascript" src="js/backbone/lib/jquery.js"></script>
<script type="text/javascript" src="js/backbone/lib/underscore.js"></script>
<script type="text/javascript" src="js/backbone/lib/backbone.js"></script>

<script type="text/javascript" src="js/backbone/modelos/ModeloPerfil.js"></script>
<script type="text/javascript" src="js/backbone/colecciones/ColeccionPerfiles.js"></script>
<script type="text/javascript" src="js/backbone/vistas/VistaNuevoPerfil.js"></script>

<script type="text/javascript" src="js/backbone/vistas/VistaPerfil.js"></script>
<script type="text/javascript" src="js/backbone/vistas/VistaConsultaPerfiles.js"></script>

<script type="text/javascript">
	var app = app || {};
	
</script>