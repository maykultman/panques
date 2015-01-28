<div class="contenedor_modulo">  
	<section class="container">		    
		<div class="row">
			<h1 id="titulo_del_modulo"><label>Configurar mi cuenta</label></h1>
			<!-- <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
				<label>Mi foto</label>
			</div>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-10">
				<label>Mi foto</label>
			</div><br><br>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
				<label>Usuario</label>
			</div>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-10">
				<input type="text" name="user" value="" class="form-control">
			</div><br><br>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
				<label>Contraseña</label>
			</div>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-10">
				<input type="text" name="user" value="" class="form-control">
			</div>			 -->
			<form>
				<div class="form-group">
					<label for="exampleInputEmail1">Usuario</label>
				    <input type="text" class="form-control" id="exampleInputEmail1" value="<?=$this->session->userdata('usuario')?>" placeholder="Enter email">
				</div>
			  	<div class="form-group">
			    	<label for="exampleInputPassword1">Contraseña</label>
			    	<input type="text" class="form-control" id="exampleInputPassword1" value=""placeholder="Contraseña">
			  	</div>
			  	<!-- <div class="form-group">
				    <label for="exampleInputFile">File input</label>
				    <input type="file" id="exampleInputFile">
				    <p class="help-block">Example block-level help text here.</p>
				</div>	 -->		  	
			  	<button type="submit" class="btn btn-default">Guardar</button>
			</form>
		</div>
	</div>
</div>