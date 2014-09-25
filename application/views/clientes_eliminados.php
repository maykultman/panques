	<div id="div_fullHeight"> 
		<?=link_tag('css/theme.default.css').
		//plugin selectize css
		link_tag('js/plugin/selectize/selectize.default.css');
		?>

		<div id="posicion_infotd">
			<div id="clientes" class="wrapper">                            
				<table id="tbla_cliente" class="tablesorter table-striped">
					<!-- BOTON PARA PRUEBAS -->
					<!-- <tr><td colspan="7"><button id="obtenerEliminados">Clientes eliminados</button></td></tr> -->
					<thead>
						<tr>
							<th class="sorter-false"> Todos <input id="todos" type="checkbox" name="todos"></th>
							<th class="sorter-false"></th>
							<th class="sorter-false">
								<input class="form-control search" type="search" placeholder="Nombre comercial" data-column="all">
								<span class="icon-search busqueda"></span>
							</th>
							<th class="sorter-false">Giro</th>
							<th class="sorter-false">
								Página web
							</th>
							<th class="sorter-false" style="text-align=center;">Ultima actividad</th>
							<th class="sorter-false">Operaciones</th>
						</tr>
					</thead>
					<tbody id="filasClientes">
					</tbody>
				</table>            
			</div>   
			<!-- <button type="button" id="marcar" class="btn btn-default">Marcar todos</button> 
			<button type="button" id="desmarcar" class="btn btn-default">Desmarcar todos</button>
			<button type="button" id="eliminar" class="btn btn-default">Eliminar varios</button> -->
			<button class="btn btn-primary" style="margin-top: 8px;">Eliminar varios</button>
			
			<!------------ Enviar Correo -------- -->
			<div id="modalCorreo" class="modal fade">
				<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg-primary">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Mensaje Nuevo</h4>
					</div>
					<div class="modal-body">             
						<label id="destinatario" for="">Para:</label>
						<input class="lbl_correo" type="text" name="" value="" placeholder="" style="outline: 0;">
						<hr class="division">   
						<label id="asunto" for="">Asunto:</label>
						<input class="lbl_correo" type="text" name="" value="" placeholder="" style="outline: 0;">
						<hr class="division">
						<!-- <textarea id="txt_area"></textarea> -->
						<section id="txt_area" contenteditable="true"></section>
					</div>
					<div class="modal-footer" style="background: #f1f1f1; padding: 10px 18px 10px !important;">
						<button type="button" class="btn btn-primary">Enviar</button>
						<label class="btn btn-default fileinput-button">
							<span class="icon-paperclip"></span>
							<span>Adjuntar Foto</span>
							<input id="" type="file"  name="fotoUsuario">          
						</label>                
						<button type="button" class="btn btn-default" data-dismiss="modal" style="float: right;">Cancelar</button>                
					</div>
				</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>
	</div><!-- /div_fullHeight -->