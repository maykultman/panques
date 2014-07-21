<!------------ Enviar Correo -------- -->
<div id="modalCorreoNuevo" class="modal fade">
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
