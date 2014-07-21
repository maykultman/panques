    <link rel="stylesheet" type="text/css" href="<?=base_url().'css/estilos_modulo_clientes_nuevo.less'?>">
    <!-- plugin selectize css -->
        <link rel="stylesheet" href="<?=base_url().'js/plugin/selectize/selectize.default.css'?>">

    <style type="text/css">
        /*.obligatorio{
            color: red;
        }*/
    </style>
    <section style="position: relative !important;">
        <!-- REGISTRO DEL CLIENTE -->
        <div id="formularioCliente" class="visibleR">
            <!-- <button type="button" id="ir" class="btn btn-default btn-xs">Conmutar</button> -->
            <!-- <h2>Registro para nuevo cliente</h2> -->
            <!-- <hr> -->
            <h4>Datos básicos</h4>
            <hr style="margin-top: -1px;"><br>
            Tipo de cliente <!-- <small><span class="icon-asterisk2 obligatorio"></span></small> --> 
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary">
                    <input type="radio" class="tipo_cliente" name="tipo_cliente" id="prospecto" value="prospecto"> Prospecto
                </label>
                <label class="btn btn-primary">
                    <input type="radio" class="tipo_cliente" name="tipo_cliente" id="cliente" value="cliente"> Cliente
                </label>
            </div>
            <div class="desborde"></div>
            <br>  
            <div class="row">
                <div class="col-md-6">                
                    <!-- <div class="input_info"> -->
                        <input type="text" id="nombreComercial"  class="form-control form_input" placeholder="Nombre comercial / Persona">
                         <input type="text" id="nombreFiscal" class="form-control form_input" placeholder="Nombre fiscal">                    
                        <input type="text" id="rfc" class="form-control form_input" placeholder="RFC">
                         <select id="giro" class= "form-control form_input" > 
                            <option value="" disabled style='display:none;'>Giro</option> 
                            <option> Manufacturera </option> 
                            <option> Agropecuaria </option> 
                            <option> Comercial </option> 
                            <option> Transporte </option> 
                            <option> Educación </option> 
                            <option> Servicios públicos </option>
                            <option> Salud </option> 
                            <option> Comunicación </option> 
                            <option selected disabled>Giro</option>
                        </select>
                              
                   <!--  </div>    --> 
                </div>          
                <div class="col-md-6">
                    <!-- <div class="input_info"> -->
                    <input type="email" id="email" class="form-control form_input" placeholder="Email">
                    <input type="text" id="paginaCliente"  class="form-control form_input" placeholder="Página web">         
                    <textarea id="txtareaDireccion" class="form-control form_input" rows="3" placeholder="Dirección" style="height: 34px !important;"></textarea>
                     <div class="telefonos">
                        <div class="div_telefono">

                            <div class="input-group form_input">
                                <input type="text" class="form-control telefonoCliente form_input" name="numero" placeholder="Teléfono" minlength="10">
                                <div class="input-group-btn">
                                    <select class="btn btn-default tipoTelefonoCliente" name="tipo"  style="height: 34px;">
                                        <option value="No definido" selected style="display:none;">Tipo</option>
                                        <option value="Casa">Casa</option>
                                        <option value="Fax">Fax</option>
                                        <option value="Movil">Movil</option>
                                        <option value="Oficina">Oficina</option>
                                        <option value="Personal">Personal</option>
                                        <option value="Trabajo">Trabajo</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                    <button type="button" class="btn btn-default eliminarCopia"><span class="icon-uniF477"></span></button>
                                    <button type="button" class="btn btn-default otroTelefono"><span class="icon-uniF476"></span></button>
                                </div>
                            </div>
                            <br>
                        </div> <!-- /Contenedor del form de teléfono -->
                    </div>                    
                     <!-- </div>  -->               
                </div>
            </div>               
            <!-- <input type="text" class="form-control" placeholder="Telefono movil"> -->
            <!-- Este es el pequeño formulario para registrar teléfonos -->      
            <div class="desborde"></div><br>
            <div class="row">
                <div class="col-md-6">               
                   <h4>Servicios que le interesa el cliente</h4>
                   <hr style="margin-top: -1px;">
                   <select class="menuServicios"  name="serviciosInteres[]" multiple placeholder="Buscar servicios">
                   </select>                
                </div>
                <div class="col-md-6">                
                   <h4>Servicios con los que cuenta el cliente</h4>
                   <hr style="margin-top: -1px;">
                   <select class="menuServicios"  name="serviciosCuenta[]" multiple placeholder="Buscar servicios">
                   </select>               
                </div>
            </div>       
            <br><br>
            <div class="row">        
               <!-- <h4>Adjuntar logotipo del cliente</h4>
               <hr style="margin-top: -1px;"> --> 
               <div class="col-md-12">         
                    <form id="formularioFoto">
                         <label class="btn btn-default fileinput-button">
                            <span class="icon-paperclip"></span>
                            <span>Adjuntar Logotipo</span>
                            <input type="file" id="fotoCliente" name="fotoCliente">          
                         </label>               
                    </form>
                    <img id="direccion" alt="foto del cliente" class="img-thumbnail" width="140" style="margin-top: 30px;">
                    <br><br>
                     <textarea id="comentarioCliente" class="form-control" rows="6" placeholder="Comentarios sobre el nuevo cliente"></textarea>       
                </div>             
           </div>
           <br><br>
           <button type="button" id="btn_crear" class="btn btn-primary">Guardar</button>
           <a href="modulo_consulta_clientes" class="btn btn-default">Cancelar</a>
           <br>
           <br>
           <br> <!-- visibleR -->
        </div>
        <!-- REGISTRO DEL CONTACTO -->
        <div id="formularioContacto" class="visibleR ocultoR">
            <!-- <button type="button" id="ir" class="btn btn-default btn-xs">Conmutar</button> -->
            <!-- <div id="div_nombreCliente"> -->
                <!-- <h2>Backbone</h2><h3>Registro para representante y contactos</h3> -->
            <!-- </div> -->
            <div class="page-header">
                <h1><span id="span_nombreCliente"></span> <small>Registro para representante y contactos</small></h1>
            </div>
            <!-- <hr> -->
            <div class="row">
                <div class="col-md-6">
                    <!-- <div class="dato_contacto"> -->
                        <div><h3>Datos de Representante</h3></div>
                        <hr>
                        <input type="text" id="nombreRepresentante"  class="form-control form_input " placeholder="Nombre completo del representante">
                        <input type="text" id="emailRepresentante" class="form-control form_input " placeholder="Correo">
                        <input type="text" id="cargoRepresentante" class="form-control form_input " placeholder="Cargo">
                        <div class="telefonos">
                            <div class="div_telefono">
                                <div class="input-group form_input">
                                    <input type="text" class="form-control telefonoRepresentante" name="numero" placeholder="Teléfono" minlength="10" maxlength="20">
                                    <div class="input-group-btn">
                                        <select class="btn btn-default tipoTelefonoRepresentante" name="tipo"  style="height: 34px;">
                                            <option value="No definido" selected style="display:none;">Tipo</option>
                                            <option value="Casa">Casa</option>
                                            <option value="Fax">Fax</option>
                                            <option value="Movil">Movil</option>
                                            <option value="Oficina">Oficina</option>
                                            <option value="Personal">Personal</option>
                                            <option value="Trabajo">Trabajo</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                        <button type="button" class="btn btn-default eliminarCopia"><span class="icon-uniF477"></span></button>
                                        <button type="button" class="btn btn-default otroTelefono"><span class="icon-uniF476"></span></button>
                                    </div>
                                </div>
                                <br>
                            </div> <!-- /Contenedor del form de teléfono -->
                        </div>
                   <!--  </div> -->
                </div>
                <div id="div_contactos" class="col-md-6">
                     <!-- <div class="dato_contacto" id="div_contactos" style="position:relative"> -->
                        <div id="listaContactosCliente">
                        <h3>Datos de contacto</h3><br><button id="btn_otroContacto" class="btn btn-primary btn-sm" style="margin-right: -115px;"><span class="icon-addfriend"></span></button>
                        </div>
                        <div class="desborde"></div>
                        <hr>

                        <div>
                            <div class="tab-content">
                                <!-- PLANTILLA FORMULARIO DE CONTACTO -->
                            </div>
                            <ul class="pagination pagination-ms">
                                <!-- <li id="pagina1" class="active"><a href="#1" data-toggle="tab">1</a></li> -->
                            </ul>
                        </div>
                    <!-- </div> -->
                </div>                
            </div>          
            <div class="desborde"></div>
            <br>
            <button id="btn_guardarContactos" class="btn btn-primary">Guardar Contactos</button>
            <a href="modulo_consulta_clientes" class="btn btn-default">Cancelar</a>
            <!-- <a href="modulo_consulta_clientes" id="btn_nuevoContacto" class="btn btn-primary" role="button">Registrar Contactos</a> -->
              <!-- visibleR ocultoR -->          
        </div>
    </section>
</section>
</div>


<script type="text/javascript" src="<?=base_url().'js/backbone/app.js'?>"></script>
<script type="text/javascript">
    app.coleccionDeClientes = <?=json_encode($clientes)?>;
    app.coleccionDeServicios = <?php echo json_encode($servicios) ?>;
</script>
<!-- Utilerias -->
    <script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>

<!-- Plantillas -->
    <script type="text/template" id="serviciosI">
        <div>
            <label for="<%- id %>"><%- nombre %></label>
            <!--<label for="<%- id %>" class="concepto"><%- concepto %></label>-->
            <div class='check_posicion'>
                <input type="checkbox" class="serviciosInteres" name="nameServiciosInteres" id="<%- id %>">
            </div>
        </div>
    </script>
    <script type="text/template" id="serviciosC">
        <div>
            <label for="<%- 1+id %>"><%- nombre %></label>
            <!--<label for="<%- 1+id %>" class="concepto"><%- concepto %></label>-->
            <div class='check_posicion'>
                <input type="checkbox" class="serviciosCuenta" name="nameServiciosCuenta" id="<%- 1+id %>">
            </div>
        </div>
    </script>
    <script type="text/template" id="plantillaFormContacto">
        <div class="tab-pane active" id="<%- i %>">
            <button id="eliminar" class="btn btn-danger btn-sm" style="position:absolute; top: 20px; right: 45px;"><%- i %> <span class="icon-trash"></span></button>
            <input type="text" id="contactoNombre" class="form-control form_input" value="Nombre completo del contacto">
            <input type="text" id="contactoEmail" class="form-control form_input" value="Correo">
            <input type="text" id="contactoCargo" class="form-control form_input" value="Cargo">
            <div class="telefonos">
                <div class="div_telefono">
                    <div class="input-group form_input">
                        <input type="text" class="form-control telefonoContacto" name="numero" value="Teléfono" minlength="10" maxlength="20">
                        <div class="input-group-btn">
                            <select class="btn btn-default tipoTelefonoContacto" name="tipo"  style="height: 34px;">
                                <option value="No definido" selected style="display:none;">Tipo</option>
                                <option value="Casa">Casa</option>
                                <option value="Fax">Fax</option>
                                <option value="Movil">Movil</option>
                                <option value="Oficina">Oficina</option>
                                <option value="Personal">Personal</option>
                                <option value="Trabajo">Trabajo</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <button type="button" class="btn btn-default eliminarCopiaC"><span class="icon-uniF477"></span></button>
                            <button type="button" class="btn btn-default otroTelefono"><span class="icon-uniF476"></span></button>
                        </div>
                    </div>
                    <br>
                </div> <!-- /Contenedor del form de teléfono -->
            </div>
        </div>
    </script>
<!-- Utilerias -->
    <script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
    <!-- plugins -->
        <script src="<?=base_url().'js/plugin/selectize/selectize.min.js'?>"></script>
<!-- Librerias Backbone -->
    <script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.localStorage.js'?>"></script>
<!--MV*-->
    <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloContacto.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloRepresentante.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloCliente.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloTelefono.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicio.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloServicioCliente.js'?>"></script>
    <!-- <script type="text/javascript" src="js/backbone/modelos/ModeloArchivo.js"></script> -->
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServicios.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionTelefonos.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionContactos.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionRepresentantes.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionClientes.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServicios.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionServiciosClientes.js'?>"></script>
    <!-- <script type="text/javascript" src="js/backbone/colecciones/ColeccionArchivos.js"></script> -->
    <!-- <script type="text/javascript" src="js/backbone/vistas/VistaContacto.js"></script> -->
    <!-- <script type="text/javascript" src="js/backbone/vistas/VistaCliente.js"></script> -->
    <script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaTelefono.js'?>"></script>
    <!-- <script type="text/javascript" src="js/backbone/vistas/VistaArchivo.js"></script> -->
    <script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaServicio.js'?>"></script>
    <script type="text/javascript" src="<?=base_url().'js/backbone/vistas/VistaNuevoCliente.js'?>"></script>