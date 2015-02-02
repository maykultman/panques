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
	<h1 id="titulo_del_modulo"><label>Configurar mi cuenta</label></h1>	
	<section class="container">		    
		<div class="row">				
			<div class="col-xs-12 hidden-xs col-sm-2 col-md-1 col-lg-1">	
				<label class="etiqueta" for="exampleInputEmail1">Usuario</label><br><br><br>
				<label class="etiqueta" for="exampleInputPassword1">Contraseña</label>								
			</div>
			<div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
				<input type="text" class="form-control user" value="<?=$this->session->userdata('usuario')?>" placeholder="Enter email">				
				<br>
				<input type="text" class="form-control pass" value=""placeholder="Contraseña">
				<br><button type="submit" class="btn btn-default" data-url="<?=base_url()?>api_usuarios/<?=$this->session->userdata('id_usuario')?>">Actualizar</button>	
			</div>		
			<div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
				<img class="pull-left" src="<?=base_url()?><?=$this->session->userdata('foto')?>">
			</div>
			
		</div>
	</div>
</div>

<script>
	
	var destino = $(".btn-default").data('url');
	var user = $('.user').val();
	var pass = $('.pass').val();
	$(".btn-default").click(function(e){
		$.ajax({
	        url: destino,
	        method: 'PUT',
	        async:false,	        
	        data: {'usuario' : user, 'contrasena' : pass},
	   
	        success:function(exito){
	        	alerta('Haz actualizado tu cuenta',function(){});
	        },
	        error: function(error){

	        }
    	});
	});
	

</script>