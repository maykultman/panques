<style>
.btn-default{right: 1.8%;
position: absolute;}
@media(max-width: 767px){
.etiqueta{
	display: none;
}
}
</style>
<div class="contenedor_modulo">  
	<section class="container">		    
		<div class="row">
			<h1 id="titulo_del_modulo"><label>Configurar mi cuenta</label></h1>		
			<div class="col-xs-12 hidden-xs col-sm-2 col-md-1 col-lg-1">	
				<label class="etiqueta" for="exampleInputEmail1">Usuario</label><br><br><br>
				<label class="etiqueta" for="exampleInputPassword1">Contraseña</label>								
			</div>
			<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
				<input type="text" class="form-control" id="exampleInputEmail1" value="<?=$this->session->userdata('usuario')?>" placeholder="Enter email">				
				<br>
				<input type="text" class="form-control" id="exampleInputPassword1" value=""placeholder="Contraseña">
				<br><button type="submit" class="btn btn-default">Actualizar</button>	
			</div>		
			<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
				<img class="pull-left" src="<?=base_url()?><?=$this->session->userdata('foto')?>">
			</div>
			
		</div>
	</div>
</div>