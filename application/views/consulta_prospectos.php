    <div id="div_fullHeight"> 
        <?=link_tag('css/theme.default.css').
            //plugin selectize css
            link_tag('js/plugin/selectize/selectize.default.css');?>

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
            <button id="btn_eliminarVarios" class="btn btn-primary">Eliminar varios</button>
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
    </div><!-- /div_fullHeight -->
    <!--  ----------Consulta clientes-------- -->
     <!-- PLANTILLAS -->
    <script type="text/templates" id="plantilla_td_de_cliente">

        <td class="td_tablaPricipal"><input type="checkbox" class="todos" name="todos" value="<%- id %>"></td>
        <td>
            <% if (typeof foto != "undefined") { %>
                <img src="<?=base_url().'<%- foto %>'?>" alt="" class="foto">
            <%} else{%>
                <img src="" alt="" class="foto">
            <%}; %>
        </td>
        <td><%- nombreComercial %></td>
        
        <% if(typeof giro != "undefined") { %>
            <td><%- giro %></td>
        <% } else { %>
            <td>No especificado</td>
        <% }; %>
    
        <% if(typeof paginaWeb != "undefined") { %>
            <td><%- paginaWeb %></td>
        <% } else { %>
            <td>No especificado</td>
        <% }; %>

        <td>
            Módulo de actividad
        </td>
        <td class="icon-operaciones">
            
            <span class="icon-trash" id="tr_btn_eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar"></span>
            <span class="icon-edit2" id="tr_btn_editar" data-toggle="modal" data-target="#modal<%- id %>" title="Editar"></span>
            <span class="icon-email" data-toggle="modal" data-placement="top" data-target="#modalCorreo" title="Enviar"></span>
            <span class="icon-eye verInfo" data-toggle="modal" data-target="#modal<%- id %>" title="Ver información"></span>
            <span class="icon-shortcut" id="tr_btn_actualizarTipo" title="Actualizar a cliente"></span>
        </td>
    </script>
    
    <script type="text/template" id="modalCliente">
        <div class="modal fade" id="modal<%- id %>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div id="icon-operaciones2">
                    <div class="btn-group-vertical">
                        <button type="button" class="btn btn-primary" id="modal_btn_eliminar"><label class="icon-trash"   data-toggle="tooltip" data-placement="top" title="Eliminar"></label></button>
                        <button type="button" class="btn btn-primary" id="modal_btn_editar"><label class="icon-edit2"  data-toggle="tooltip" data-placement="top" title="Editar"></label></button>
                        <button type="button" class="btn btn-primary" id="btn_verContactos"><label class="icon-friends"  data-toggle="tooltip" data-placement="top" title="Contactos"></label></button>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <p class="panel-title"><h4>Información</h4></p>
                        <span id="cerrar_consulta" class="glyphicon glyphicon-remove" style="float:right" data-dismiss="modal" aria-hidden="true"></span>
                    </div>
                    <table style="margin-left:15px; margin-top:15px;">
                        <tr>
                            <td rowspan="3">
                                <img class="img-rounded" id="direccion" src="<?=base_url().'<%- foto %>'?>" alt="Imagen-Cliente" width="150" height="150">
                            </td>
                            <td style="padding:0px 10px 0px 10px; vertical-align: bottom;">
                                <h3 class="editar editando"><b><%- nombreComercial %></b></h3>
                                <input type="text" id="nombreComercial" class="form-control input-lg editar" name="nombreComercial" value="<%- nombreComercial %>">
                            </td>
                            <td class="respuesta" style="vertical-align: bottom;"></td>
                        </tr>
                        <tr>
                            <td style="padding:0px 10px 0px 10px;">
                                Cliente desde
                                <label>
                                    <% var Año_Mes_dia = fechaCreacion.split('-'); %>
                                    <%- Año_Mes_dia[2] %>
                                    <% for (var i = 0; i < meses.length+1; i++) { %>
                                        <% if (i == Año_Mes_dia[1]) { %>
                                            <%- meses[i-1] %>
                                            <% break; %>
                                        <% }; %>
                                    <% }; %>
                                    <%- Año_Mes_dia[0] %>
                                </label>
                            </td>
                            <td class="respuesta"></td>
                        </tr>
                        <tr>
                            <td style="padding:0px 10px 0px 10px; vertical-align: top;">
                                <a href="#">Ir a proyecto</a>
                            </td>
                            <td class="respuesta" style="vertical-align: top;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="editar">
                               <!--BOTON PARA ACTUALIZAR FOTO DEL CLIENTE-->
                                <form id="formularioFoto" style="margin: 5px 0px 0px 17px;">
                                    <label class="btn btn-default btn-xs" for="logoCliente">
                                        Actualizar logotipo
                                        <input type="file" id="logoCliente" name="logoCliente" style="display:none;">
                                    </label>
                                </form>
                            </td>
                        </tr>
                    </table>


                    <div class="panel-body">
                        <div class="editar">Precione la tecla <kbd>Enter</kbd> para actualizar<br><br></div>
                        
                        <!-- -------PRIMERA PAGINA DE INFORMACION DEL CLIENTE------- -->
                        <div class="visible" id="divCliente">
                            <table class="table table-striped">
                                <tr class="trCliente"> <!--Nombre fical-->
                                    <td class="atributo"><b>Nombre Físcal:</b></td>
                                    <td>
                                        <% if (typeof nombreFiscal != "undefined") { %>
                                            <label class="editar editando">
                                                <%- nombreFiscal %>
                                            </label>
                                            <input type="text" class="form-control editar" name="nombreFiscal" value="<%- nombreFiscal %>">
                                        <% } else{ %>
                                            <label class="editar editando">
                                                No especificado
                                            </label>
                                            <input type="text" class="form-control editar" name="nombreFiscal">
                                        <% }; %>
                                    </td>
                                    <td class="respuesta">
                                         <span class="icon-uniF55C" style="visibility: hidden;"></span>
                                        <!--RESPUESTA-->
                                    </td>
                                </tr>
                                <tr class="trCliente"> <!--RFC-->
                                    <td class="atributo"><b>R.F.C:</b></td>
                                    <td>
                                        <% if (typeof rfc != "undefined") { %>
                                            <label class="editar editando">
                                                <%- rfc %>
                                            </label>
                                            <input type="text" class="form-control editar" name="rfc" value="<%- rfc %>">
                                        <% } else{ %>
                                            <label class="editar editando">
                                                No especificado
                                            </label>
                                            <input type="text" class="form-control editar" name="rfc">
                                        <% }; %>
                                    </td>
                                    <td class="respuesta">
                                         <span class="icon-uniF55C" style="visibility: hidden;"></span>
                                        <!--RESPUESTA-->
                                    </td>
                                </tr>
                                <tr class="trCliente"> <!--Giro-->
                                    <td class="atributo"><b>Giro:</b></td>
                                    <td>
                                        <select class="form-control editar" name="giro"> 
                                            <option> Manufacturera </option> 
                                            <option> Agropecuaria </option> 
                                            <option> Comercial </option> 
                                            <option> Transporte </option> 
                                            <option> Educación </option> 
                                            <option> Servicios públicos </option>
                                            <option> Salud </option> 
                                            <option> Comunicación </option>
                                        <% if (typeof giro != "undefined") { %>
                                                <option selected style='display:none;'><%- giro %></option> 
                                            </select>
                                            <label class="editar editando">
                                                <%- giro %>
                                            </label>
                                        <% } else{ %>
                                                <option selected disabled>Giro</option>
                                            </select>
                                            <label class="editar editando">
                                                No especificado
                                            </label>
                                        <% }; %>
                                    </td>
                                    <td class="respuesta">
                                         <span class="icon-uniF55C" style="visibility: hidden;"></span>
                                        <!--RESPUESTA-->
                                    </td>
                                </tr>
                                <tr class="trCliente"> <!--Dirección-->
                                    <td class="atributo"><b>Dirección:</b></td>
                                    <td>
                                        <% if (typeof direccion != "undefined") { %>
                                            <label class="editar editando">
                                                <%- direccion %>
                                            </label>
                                            <input type="text" class="form-control editar" name="direccion" value="<%- direccion %>">
                                        <% } else{ %>
                                            <label class="editar editando">
                                                No especificado
                                            </label>
                                            <input type="text" class="form-control editar" name="direccion">
                                        <% }; %>
                                    </td>
                                    <td class="respuesta">
                                         <span class="icon-uniF55C" style="visibility: hidden;"></span>
                                        <!--RESPUESTA-->
                                    </td>
                                </tr>
                                <tr class="trCliente"> <!--Telófono-->
                                    <td class="atributo">
                                        <b>Telefono:</b>
                                        <!--<button type="button" id="btn_nuevoTelefono" class="btn btn-primary btn-xs editar">Nuevo</button>-->
                                    </td>
                                    <td id="telefonos">
                                        <label class="editar editando">No especificado</label>
                                        <div class="editar" id="formularioTelefono">
                                            <div class="input-group">
                                                <input type="text" id="numeroNuevo" class="form-control" name="numero" placeholder="Nuevo Teléfono" minlength="10" maxlength="20">
                                                <div class="input-group-btn">
                                                    <select id="tipoNuevo" class="btn btn-default" name="tipo">
                                                        <option value="No definido" selected style="display:none;">Tipo</option>
                                                        <option value="Casa">Casa</option>
                                                        <option value="Fax">Fax</option>
                                                        <option value="Movil">Movil</option>
                                                        <option value="Oficina">Oficina</option>
                                                        <option value="Personal">Personal</option>
                                                        <option value="Trabajo">Trabajo</option>
                                                        <option value="Otro">Otro</option>
                                                    </select>
                                                    <button id="enviarTelefono" class="btn btn-default"><label class="icon-save"></label></button>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                    </td>
                                    <td class="respuesta">
                                         <span class="icon-uniF55C" style="visibility: hidden;"></span>
                                        <!--RESPUESTA-->
                                    </td>
                                </tr>
                                <tr class="trCliente"> <!--Correo-->
                                    <td class="atributo"><b>Correo electrónico:</b></td>
                                    <td>
                                        <% if (typeof email != "undefined") { %>
                                            <a class="editar editando" href="#">
                                                <%- email %>
                                            </a>
                                            <input type="text" id="mail" class="form-control editar" name="email" value="<%- email %>">
                                        <% } else { %>
                                            <label class="editar editando">No especificado</label>
                                            <input type="text" id="mail" class="form-control editar" name="email">
                                        <% }; %>
                                    </td>
                                    <td class="respuesta">
                                         <span class="icon-uniF55C" style="visibility: hidden;"></span>
                                        <!--RESPUESTA-->
                                    </td>
                                </tr>
                                <tr class="trCliente"> <!--Página-->
                                    <td class="atributo"><b>Página Web:</b></td>
                                    <td>
                                        <% if (typeof paginaWeb != "undefined") { %>
                                            <a class="editar editando" href="#">
                                                <%- paginaWeb %>
                                            </a>
                                            <input type="text" id="url" class="form-control editar" name="paginaWeb" value="<%- paginaWeb %>">
                                        <% } else { %>
                                            <label class="editar editando">No especificado</label>
                                            <input type="text" id="url" class="form-control editar" name="paginaWeb">
                                        <% }; %>
                                    </td>
                                    <td class="respuesta">
                                         <span class="icon-uniF55C" style="visibility: hidden;"></span>
                                        <!--RESPUESTA-->
                                    </td>
                                </tr>
                                <tr class="trCliente"> <!--Servicios I-->
                                    <td class="atributo"><b>Servicios de interes:</b></td>
                                    <td>
                                        <div class="editar">
                                            <div id="div_serviciosI">
                                                <select id="select_ServI" class="menuServicios" name="idservicio" multiple placeholder="Buscar servicios" style="width:400px;">
                                                </select>
                                            </div>
                                        </div>
                                        <div id="serviciosInteres"></div>
                                    </td>
                                    <td class="respuesta">
                                        <span class="icon-uniF55C" style="visibility: hidden;"></span>
                                        <!--RESPUESTA-->
                                    </td>
                                </tr>
                                <tr class="trCliente"> <!--Servicios C-->
                                    <td class="atributo">
                                        <b>Servicios actuales:</b><br>
                                        <h6>servicios con lo que cuenta actualmente<h6>
                                    </td>
                                    <td>
                                        <div class="editar">
                                            <div id="div_serviciosC">
                                                <select id="select_ServC" class="menuServicios" name="idservicio" multiple placeholder="Buscar servicios" style="width:400px;">
                                                </select>
                                            </div>
                                        </div>
                                        <div id="serviciosCuenta"></div>
                                    </td>
                                    <td class="respuesta">
                                        <span class="icon-uniF55C" style="visibility: hidden;"></span>
                                        <!--RESPUESTA-->
                                    </td>
                                </tr>
                                <tr>
                                    <td class="atributo">Comentarios</td>
                                    <td>
                                        <% if (typeof comentarioCliente != "undefined") { %>
                                            <p class="editar editando"><%- comentarioCliente %></p>
                                            <textarea id="comentario" class="form-control editar" name="comentarioCliente" rows="3"><%- comentarioCliente %></textarea>
                                        <% } else { %>
                                            <p class="editar editando">No especificado.</p>
                                            <textarea id="comentario" class="form-control editar" name="comentarioCliente" rows="3"></textarea>
                                        <% }; %>
                                    </td>
                                    <td class="respuesta">
                                        <!--<span class="icon-uniF55C" style="visibility: hidden;"></span>-->
                                        <div id="spin"><div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- -------PRIMERA PAGINA DE INFORMACION DEL CLIENTE------- -->
                        <!-- -------SEGUNDA PAGINA DE INFORMACION DEL CLIENTE------- --> 
                        <div class="visible oculto">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalNuevoContacto<%- id %>">Nuevo representante o contacto</button>
                            <div id="divContactos">
                                <!--AQUÍ VAN LOS CONTACTOS-->
                            </div>
                        </div>
                        <!-- -------SEGUNDA PAGINA DE INFORMACION DEL CLIENTE------- -->                         
                    </div>
                </div>
            </div>
        </div>
    </script>
    
    <script type="text/template" id="modalContacto">
        <div class="modal fade" id="modalNuevoContacto<%- id %>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Nuevo representante o contacto</h4>
                    </div>
                    <div class="modal-body">
                        <form id="formNuevoContacto" role="form">
                            <div class="form-group">
                                <select name="persona" class="form-control">
                                    <option value="representante">Representante</option>
                                    <option value="contacto">Contacto</option>
                                    <option selected disabled value="">¿Qué desea registar?</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <input type="text" id="nuevoMail" class="form-control" name="correo" placeholder="Correo">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="cargo" placeholder="Cargo">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" id="nuevoNumero" class="form-control" name="numero" placeholder="Número telefónico" minlength="10" maxlength="20">
                                    <div class="input-group-btn">
                                        <select id="tipo" class="btn btn-default" name="tipo">
                                            <option value="No definido" selected style="display:none;">Tipo</option>
                                            <option value="Casa">Casa</option>
                                            <option value="Fax">Fax</option>
                                            <option value="Movil">Movil</option>
                                            <option value="Oficina">Oficina</option>
                                            <option value="Personal">Personal</option>
                                            <option value="Trabajo">Trabajo</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                        <!--<button id="otroTelefono" class="btn btn-default"><label class="icon-uniF476"></label></button>-->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_nuevoContacto">Guardar contacto</button>
                        <button type="button" class="btn btn-default" id="btn_cerrarNuevoContacto" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="text/templates" id="plantilla_contactos">
        <div id="icon-operacionesContacto">
            <div class="btn-group-vertical">
                <button type="button" class="btn btn-primary" id="btn_eliminar"><label class="icon-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></label></button>
                <button type="button" class="btn btn-primary" id="btn_editar"><label class="icon-edit2"  data-toggle="tooltip" data-placement="top" title="Editar"></label></button>
            </div>
        </div>
        <h3><%- etiqueta %></h3>
        <div class="editar">Precione la tecla <kbd>Enter</kbd> para actualizar</div>
        <br>
        <br>
        <table class="table table-striped tbla_contacto">
            <tr class="trContacto">
                <td class="atributo"><b>Nombre:</b></td>
                <td class="divDatoContacto">
                    <label class="editar editando"><%- nombre %></label>
                    <input type="text" class="form-control editar" name="nombre" value="<%- nombre %>">
                </td>
                <td class="respuesta">
                     <span class="icon-uniF55C" style="visibility: hidden;"></span>
                    <!--RESPUESTA-->
                </td>
            </tr>
            <tr class="trContacto">
                <td class="atributo"><b>Correo:</b></td>
                <td class="divDatoContacto">
                    <% if (typeof correo != 'undefined' && correo != '') { %>
                        <a class="editar editando" href="<%- correo %>"><%- correo %></a>
                        <input type="text" id="mail" class="form-control editar" name="correo" value="<%- correo %>">
                    <% } else{ %>
                        <label class="editar editando">No especificado</label>
                    <% }; %>
                </td>
                <td class="respuesta">
                     <span class="icon-uniF55C" style="visibility: hidden;"></span>
                    <!--RESPUESTA-->
                </td>
            </tr>
            <tr class="trContacto">
                <td class="atributo"><b>Cargo:</b></td>
                <td class="divDatoContacto">
                <% if (typeof cargo != 'undefined' && cargo != '') { %>
                        <label class="editar editando"><%- cargo %></label>
                        <input type="text" class="form-control editar" name="cargo" value="<%- cargo %>">
                <% } else{ %>
                    <label class="editar editando">No especificado</label>
                    <input type="text" class="form-control editar" placeholder="Cargo">
                <% }; %>                            
                </td>
                <td class="respuesta">
                     <span class="icon-uniF55C" style="visibility: hidden;"></span>
                    <!--RESPUESTA-->
                </td>
            </tr>
            <tr class="trContacto">
                <td class="atributo"><b>Teléfonos:</b></td>
                <td class="divDatoContacto" id="telefonos">
                    <label class="editar editando">No especificado</label>
                    <div class="editar">
                        <div class="input-group">
                            <input type="text" id="numeroNuevo" class="form-control" name="numero" placeholder="Nuevo Teléfono" minlength="10" maxlength="20">
                            <div class="input-group-btn">
                                <select id="tipoNuevo" class="btn btn-default" name="tipo">
                                    <option value="No definido" selected style="display:none;">Tipo</option>
                                    <option value="Casa">Casa</option>
                                    <option value="Fax">Fax</option>
                                    <option value="Movil">Movil</option>
                                    <option value="Oficina">Oficina</option>
                                    <option value="Personal">Personal</option>
                                    <option value="Trabajo">Trabajo</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                <button id="enviarTelefono" class="btn btn-default"><label class="icon-save"></label></button>
                            </div>
                        </div>
                        <br>
                    </div>
                </td>
                <td class="respuesta">
                     <span class="icon-uniF55C" style="visibility: hidden;"></span>
                    <!--RESPUESTA-->
                </td>
            </tr>
            <!--<tr>
                <td colspan="2" class="divDatoContacto">
                    <button type="submit" class="btn btn-primary editar">Actualizar</button>
                </td>
            </tr>-->
        </table>
    </script>

    <script type="text/templates" id="plantilla_telefono">
        <div class="editar editando">
            <div class="div_tipoTelefono"><b><%-tipo%></b></div>
            <div class="div_telefono"><%-numero%></div>
        </div>
        <div class="editar">
            <div class="input-group">
                <input type="text" id="numero" class="form-control" name="numero" value="<%-numero%>" placeholder="<%-numero%>" minlength="10" maxlength="20">
                <div class="input-group-btn">
                    <select id="tipo" class="btn btn-default" name="tipo">
                        <option value="No definido" selected style="display:none;"><%-tipo%></option>
                        <option value="Casa">Casa</option>
                        <option value="Fax">Fax</option>
                        <option value="Movil">Movil</option>
                        <option value="Oficina">Oficina</option>
                        <option value="Personal">Personal</option>
                        <option value="Trabajo">Trabajo</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <button type="button" id="eliminar" class="btn btn-default"><label class="icon-uniF478"></label></button>
                </div>
            </div>
        </div>
        <br>
    </script>

    <script type="text/template" id="serviciosI">
        <div>
            <label for="<%- id %>"><%- nombre %></label>
            <!--<label for="<%- id %>" class="concepto"><%- concepto %></label>-->
            <div class='check_posicion'>
                <input type="checkbox" class="serviciosInteres editando" name="nameServiciosInteres" value="<%- id %>" id="<%- id %>">
            </div>
        </div>
    </script>

    <script type="text/template" id="serviciosC">
        <div>
            <label for="<%- id %>"><%- nombre %></label>
            <!--<label for="<%- id %>" class="concepto"><%- concepto %></label>-->
            <div class='check_posicion'>
                <input type="checkbox" class="serviciosCuenta editando" name="nameServiciosCuenta" value="<%- id %>" id="<%- id %>">
            </div>
        </div>
    </script>

    <script type="text/template" id="servicioCliente">
        <label class="editar"><label id="<%- idservicio %>" class="icon-uniF478 eliminarSC"></label></label>
        <%- nombre %>
        <br>
    </script>
   
<?=script_tag('js/backbone/app.js');?>
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
    script_tag('js/funcionescrm.js').
    // <!-- plugins -->
    script_tag('js/plugin/selectize/selectize.min.js').         
    // <!-- Librerias Backbone -->
    script_tag('js/backbone/lib/underscore.js').
    script_tag('js/backbone/lib/backbone.js').
    // <!--MV*-->
    // <!-- modelos -->
    script_tag('js/backbone/modelos/ModeloServicio.js').
    script_tag('js/backbone/modelos/ModeloRepresentante.js').
    script_tag('js/backbone/modelos/ModeloContacto.js').
    script_tag('js/backbone/modelos/ModeloCliente.js').
    script_tag('js/backbone/modelos/ModeloTelefono.js').
    script_tag('js/backbone/modelos/ModeloServicioCliente.js').
    // <!-- colecciones -->

    script_tag('js/backbone/colecciones/ColeccionServicios.js').
    script_tag('js/backbone/colecciones/ColeccionRepresentantes.js').
    script_tag('js/backbone/colecciones/ColeccionContactos.js').
    script_tag('js/backbone/colecciones/ColeccionClientes.js').
    script_tag('js/backbone/colecciones/ColeccionTelefonos.js').
    script_tag('js/backbone/colecciones/ColeccionServiciosClientes.js').

    // <!-- vistas -->
    script_tag('js/backbone/vistas/VistaServicio.js').
    script_tag('js/backbone/vistas/VistaServicioCliente.js').
    script_tag('js/backbone/vistas/VistaTelefono.js').
    script_tag('js/backbone/vistas/VistaContacto.js').
    script_tag('js/backbone/vistas/VistaCliente.js').   
    // <!-- vista general -->
    script_tag('js/backbone/vistas/VistaConsultaCP.js');?>

    <script type="text/javascript">
        app.vistaConsultaProspectos = new app.VistaConsultaProspectos();
    </script>

     <!-- Librerias para el scroll de la tabla -->
    <?= script_tag('js/tablas/jquery-latest.min.js').
        script_tag('js/tablas/jquery.tablesorter.js').
        script_tag('js/tablas/jquery.tablesorter.widgets.js').
        script_tag('js/tablas/widget-cssStickyHeaders.js').
        script_tag('js/tablas/estilo_tabla.js');
    ?>
