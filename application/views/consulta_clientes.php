<?php 
$activa_p = array();
function menu($arg, $perm)
{
    $resp=0;
    foreach ($arg as $key => $value) {
        if($value==$perm)
        {
            $resp = $value;
        }
    }
    return $resp;
}
if(isset($this->session->userdata('Clientes')[2]['permisos']))
{    
    $activa_p[0] = menu($this->session->userdata('Clientes')[2]['permisos'], 2);
    $activa_p[1] = menu($this->session->userdata('Clientes')[2]['permisos'], 3);
    $activa_p[2] = menu($this->session->userdata('Clientes')[2]['permisos'], 4);
}
?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       <!--  <div id="div_fullHeight"> -->
            <div id="posicion_infotd">
        		<div id="clientes" class="wrapper">                            
        			<table id="tbla_cliente" class="table table-striped tablesorter">
        				<!-- BOTON PARA PRUEBAS -->
        				<!-- <tr><td colspan="7"><button id="obtenerEliminados">Clientes eliminados</button></td></tr> -->
        				<thead>
        					<tr>
        						<th class="sorter-false"><input type="checkbox" class="todos"></th>
        						<th class="sorter-false" colspan="2">
        							<input class="form-control input-sm search" type="search" placeholder="Cliente" data-column="all">
        							<span class="icon-search busqueda"></span>
        						</th>
        						<th class="sorter-false">Giro</th>
        						<th class="sorter-false">
        							Página web
        						</th>
        						<th class="sorter-false" style="text-align=center;">Ultima actividad</th>
        						<th class="sorter-false">Operaciones</th>
                                <th class="sorter-false"></th>
        					</tr>
        				</thead>
        				<tbody id="filasClientes">
        				</tbody>
        			</table>
        		</div> 
                <?php if($activa_p[2]=='4'){ ?><button id="btn_eliminarVarios" class="btn btn-danger">Eliminar varios</button><?php }?>
        		<!-- <button type="button" id="marcar" class="btn btn-default">Marcar todos</button> 
        		<button type="button" id="desmarcar" class="btn btn-default">Desmarcar todos</button>
        		<button type="button" id="eliminar" class="btn btn-default">Eliminar varios</button> -->
        		
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
        <!--</div> /div_fullHeight -->
    </div>
    <!--  ----------Consulta clientes-------- -->
    <!-- PLANTILLAS -->
        <script type="text/templates" id="plantilla_td_de_cliente">

            <td class="td_tablaPricipal"><input type="checkbox" name="todos" value="<%- id %>"></td>
            <td class="td_tablaPricipal">
                <% if (typeof foto != "undefined") { %>
                    <img src="<?=base_url()?><%- foto %>" class="foto" >
                <%} else{%>
                    <img src="" alt="" class="foto">
                <%}; %>
            </td>
            <td class="td_tablaPricipal"><%- nombreComercial %></td>
            
            <% if(typeof giro != "undefined") { %>
                <td class="td_tablaPricipal"><%- giro %></td>
            <% } else { %>
                <td class="td_tablaPricipal">No especificado</td>
            <% }; %>
        
            <% if(typeof paginaWeb != "undefined") { %>
                <td class="td_tablaPricipal"><%- paginaWeb %></td>
            <% } else { %>
                <td class="td_tablaPricipal">No especificado</td>
            <% }; %>

            <td class="td_tablaPricipal">
                Módulo de actividad en construcción
            </td>
            <td class="td_tablaPricipal icon-operaciones">
                <?php if($activa_p[2]=='4'){ ?><span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span><?php }?>
                <?php if($activa_p[1]=='3'){ ?><span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal<%- id %>" title="Editar"></span><?php }?>
                <span class="icon-email" data-toggle="modal" data-placement="top" data-target="#modalCorreo" title="Enviar"></span>
                <?php if($activa_p[0]=='2'){ ?><span class="icon-eye verInfo" data-toggle="modal" data-target="#modal<%- id %>" title="Ver información"></span><?php }?>
            </td>
            <td class="td_modal"></td>
        </script>
        
        <?php include('clientes/plantillas/comunes_clientes_prospectos.php'); ?>
        
  <?=script_tag('js/backbone/app.js');?> 
<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type="text/javascript">
    app.coleccionDeClientes = <?php echo json_encode($clientes) ?>;
    // {{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}
    app.coleccionDeContactos = <?php echo json_encode($contactos) ?>;
    // {{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}
    app.coleccionDeTelefonos = <?php echo json_encode($telefonos) ?>;
    // {{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}
    app.coleccionDeRepresentantes = <?php echo json_encode($representantes) ?>;
    // {{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}
    app.coleccionDeServicios = <?php echo json_encode($servicios) ?>;

    app.coleccionDeServiciosI = <?php echo json_encode($serviciosInteres) ?>;
    app.coleccionDeServiciosC = <?php echo json_encode($serviciosCliente) ?>;
 </script>
 <!-- Utilerias -->
    <?=
        // MV*
        // modelos
        script_tag('js/backbone/modelos/ModeloServicio.js').
        script_tag('js/backbone/modelos/ModeloRepresentante.js').
        script_tag('js/backbone/modelos/ModeloContacto.js').
        script_tag('js/backbone/modelos/ModeloCliente.js').
        script_tag('js/backbone/modelos/ModeloServicioCliente.js').
        //colecciones

        script_tag('js/backbone/colecciones/ColeccionServicios.js').
        script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
        script_tag('js/backbone/colecciones/ColeccionContactos.js').
        script_tag('js/backbone/colecciones/ColeccionClientes.js').
        script_tag('js/backbone/colecciones/ColeccionTelefonos.js').
        script_tag('js/backbone/colecciones/ColeccionServiciosClientes.js').

        // vistas -->
        script_tag('js/backbone/vistas/VistaServicio.js').
        script_tag('js/backbone/vistas/VistaServicioCliente.js').
        script_tag('js/backbone/vistas/VistaTelefono.js').
        script_tag('js/backbone/vistas/VistaContacto.js').
        script_tag('js/backbone/vistas/VistaCliente.js').
       
        // vista general -->
        script_tag('js/backbone/vistas/VistaConsultaCP.js');
    ?>
    <script type="text/javascript">
        app.vistaConsultaClientes = new app.VistaConsultaClientes();
    </script>
