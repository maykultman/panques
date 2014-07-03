
	<div id="tituloR"><br/>
		<h4>Inicia sesión</h4>
	</div>
		<?php echo validation_errors(); ?>
     	<?php echo form_open('escritorio/index') ?> <!--Hace uso del helper para crear un formulario-->
		<table><tr>
		<tr><td><label for="usuario">usuario</label></td>
		<td><input type="input" name="usuario"/></td></tr>

		<tr><td><label for="contrasenia">contrasenia</label></td>
		<td><input type="input" required name="contrasenia"/></td></tr>
		<tr><td colspan="2">
			<center><input type="submit" name="submit" value="Iniciar Session"/></center>
		</td></tr>
		</table>
		</form>
	</div>