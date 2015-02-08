<style type="text/css">
	.input-top{
		border-radius: 4px 4px 0px 0px;
	}
	.input-bottom{
		border-radius: 0px 0px 4px 4px;
		margin-top: -1px;
	}
</style>
<form class="form-event" action="" method="post" accept-charset="utf-8">
	<div class="form-group">
		<input type="text" class="form-control input-lg titulo" name="summary" value="" placeholder="Evento sin título">
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-xs-6">
				De
				<input type="text" class="form-control datepickerDe input-top" name="start" placeholder="Inicio del evento">
				<input type="time" class="form-control input-sm input-bottom timepicker" name="" value="00:00">
			</div>
			<div class="col-xs-6">
				a
				<input 	type="text" 
						class="form-control datepickerA input-top" 
						name="end" 
						data-toggle="tooltip" 
						data-placement="left" 
						title="Si deja este campo vacío, se tomará la misma fecha que el inicio del evento" 
						placeholder="Fin del evento">
				<input type="time" class="form-control input-sm input-bottom timepicker" name="" value="01:00">
			</div>
		</div>
		<div class="checkbox">
			<label>
				<input 	type="checkbox" class="allDay" name="allDay"> 
				Para todo el día.
			</label>
		</div>
	</div>
	<div class="form-group">
		<input type="text" class="form-control location" name="location" value="" placeholder="Introduce una ubicación">
	</div>
	<div 	class="form-group"
			data-toggle="tooltip" 
			data-placement="top" 
			title="Advertir que la dirección email debe ser una cuenta de google (ejemplo@gmail.com)" >
		<select class="invitados" name="attendees" multiple placeholder="Seleccione invitados">
		</select>
	</div>
	<div class="form-group">
		<textarea class="form-control description" name="description" rows="5"></textarea>
	</div>
	<input id="enviar" type="submit" class="btn btn-primary" value="Enviar">
	<input type="reset" id="cancelar" class="btn btn-default" name="" value="Cancelar">
</form>