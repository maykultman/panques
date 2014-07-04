	 	 <link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_usuarios.css'?>" 
          type="text/css">
        <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/collapse.js'?>">
        </script>
        <script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/transition.js'?>">
        </script>
	 	<section>
	 	    <label>15 Usuarios</label>
	 		<hr style="margin-top: 0px;">
	 		<div class="panel-group" id="accordion">
			  <div class="panel panel-default">
			    <div class="panel-heading">
			     
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
			        	<h4 class="panel-title">
			            <b>Usuario 1</b>
			            <span class=" icon-uniF48B flecha_abajo"></span>  
			           </h4>
			        </a>			     
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse ">
			      <div class="panel-body">
			      	<div class="row">
					  <div class="col-md-4" style="width: 15% !important;"> 
					  <img src="" alt="" class="img-thumbnail img_usuario" style="margin-left: 30px; margin-top: 5px;">
					  </div>
					  <div class="col-md-4" style="width: 42.5% !important">
					  	<div class="padre">
					  			<label>Usuario</label>
					  			<div style="display: table-cell">  				
					  		 		<input id="" name="usuario" type="text" class="form-control input_margen" placeholder="Nombre del Usuario" value="">
								</div>
							</div>
							<div class="padre">
					  			<label>Contraseña</label>
					  			<div style="display: table-cell">				  				
					  		 		<input id="" name="nombre" type="password" class="form-control input_margen" placeholder="Password" value="">
								</div>
							</div>
					    </div>
					  <div class="col-md-4" style="width: 42.5% !important;">
					  	<div class="padre">
				  			<label>Nombre del Empleado</label>
				  			<div style="display: table-cell">				  				
				  		 		<input id="" name="nombre" type="text" class="form-control input_margen" placeholder="Nombre Empleado" value="">
							</div>
						</div>
							<div class="padre">
					  			<label>Perfil</label>
					  			<div style="display: table-cell">
									<select id="idperfil" name="idperfil" class="form-control input_margen">
									  <!-- Lista de Opciones de perfil  -->
									  <option selected="" disabled="">--Seleccione su Perfil--</option>
									  <option value="1" id="1">
									   Director General 
									  </option>
									  <option value="2" id="2">
										Director Administrativo 
									   </option>
									  <option value="3" id="3">
										Director Comercial 
									  </option>
									  <option value="4" id="4">
										Gerente Comercial 
									  </option>
									  <option value="5" id="5">
										Community Manager 
									  </option>
									  <option value="6" id="6">
										Diseñador Gráfico Sr 
									  </option>
									</select>					  		 		
								</div>					  
					   		</div>
					  </div>
					</div>
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Permisos</h3>
					  </div>
					  <div class="panel-body">
					    checbox con permisos , ya sabes!!!
					  </div>
					</div>     
			      </div>
			    </div>
			  </div>
			   <div class="panel panel-default">
			    <div class="panel-heading">
			     
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
			        	<h4 class="panel-title">
			            <b>Usuario 2 </b>
			            <span class=" icon-uniF48B flecha_abajo"></span>  
			           </h4>
			        </a>			     
			    </div>
			    <div id="collapse2" class="panel-collapse collapse ">
			      <div class="panel-body">
			       <img src="" alt="" class="img-thumbnail img_usuario">
			      </div>
			    </div>
			  </div>
			   <div class="panel panel-default">
			    <div class="panel-heading">
			     
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
			        	<h4 class="panel-title">
			            <b>Usuario 3</b>
			            <span class=" icon-uniF48B flecha_abajo"></span>  
			           </h4>
			        </a>			     
			    </div>
			    <div id="collapse3" class="panel-collapse collapse ">
			      <div class="panel-body">
			       <img src="" alt="" class="img-thumbnail img_usuario">
			      </div>
			    </div>
			  </div>
			   <div class="panel panel-default">
			    <div class="panel-heading">
			     
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
			        	<h4 class="panel-title">
			            <b>Usuario 4</b>
			            <span class=" icon-uniF48B flecha_abajo"></span>  
			           </h4>
			        </a>			     
			    </div>
			    <div id="collapse4" class="panel-collapse collapse ">
			      <div class="panel-body">
			        <img src="" alt="" class="img-thumbnail img_usuario">
			      </div>
			    </div>
			  </div>
			</div>
	 	</section>
 	</section>	
</div> 		