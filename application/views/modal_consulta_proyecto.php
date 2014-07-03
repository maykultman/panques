<style type="text/css" media="">
  
  .trProyecto{
   height: 51px;
   width: 100%;
  }

  #info_proyecto{
   
   margin-top: -20px;
  }

  #icon_operaciones_proy{
    display: inline-block;
    right: 15px;
    position: absolute;
    margin-top: -45px;

  }

  .panel-body span{
    padding: 5px;
    
}
  .icon_eliminar_archivo .icon-circledelete:hover{ 
    
    background: red;
    border-radius: 3px;
    cursor: pointer;
    color: white;

}
.icon-circledelete{
  vertical-align: center;
}


  #cerrar_modal{

    margin-top: -25px;
  }
</style>
<span class="icon-eye verInfo" data-toggle="modal" data-target="#modal" title="Ver información">    
</span>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" 
 aria-hidden="true">
  <div class="modal-dialog">    
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p class="panel-title"><h4><b>Información</b></h4></p>
        <span id="cerrar_modal" class="glyphicon glyphicon-remove" style="float:right" data-dismiss="modal" aria-hidden="true"></span>
      </div>
      <div class="panel-body">
        <p class="panel-title"><h3 style="text-align: center;"><b>App Farah</b></h3></p>
        <div id="icon_operaciones_proy">
              <div class="btn-group-vertical" style="margin-top: 0px;">
                <button type="button" class="btn btn-primary" id="btn_eliminar_modal"><label class="icon-trash"   data-toggle="tooltip" data-placement="top" title="Eliminar"></label></button>
                <button type="button" class="btn btn-primary" id="btn_editar_modal"><label class="icon-edit2"  data-toggle="tooltip" data-placement="top" title="Editar"></label></button>         
              </div>
            </div>
        <ul class="nav nav-tabs">
          <li class="active"><a href="#home" data-toggle="tab">Datos</a></li>
          <li><a href="#profile" data-toggle="tab">Archivos</a></li>  
        </ul>
        <div class="tab-content">          
          <div class="tab-pane active" id="home"><br>
            
            <small class="editar">Presione la tecla enter para actualizar el campo</small>
            <!-- -------INFORMACION DEL PROYECTO------- -->
            <div class="visible" id="">
              <form class="" method="post">
                <table id="info_proyecto" class="table table-striped" >
                  <tr class="trProyecto"> 
                    <td class="atributo"><b>Cliente</b></td>
                    
                    <td class="respuesta">
                       <span class="icon-uniF55C" style="visibility: hidden;"></span>
                      <!--RESPUESTA-->
                    </td>
                  </tr>
                  <tr class="trProyecto"> 
                    <td class="atributo"><b>Representante:</b></td>
                    
                    <td class="respuesta">
                     <span class="icon-uniF55C" style="visibility: hidden;"></span>
                     <!--RESPUESTA-->
                    </td>
                  </tr>
                  <tr class="trProyecto"> 
                    <td class="atributo"><b>Fecha de Inicio:</b></td>
                   
                    <td class="respuesta">
                     <span class="icon-uniF55C" style="visibility: hidden;"></span>
                     <!--RESPUESTA-->
                    </td>
                  </tr>
                  <tr class="trProyecto"> 
                    <td class="atributo"><b>Fecha Final:</b></td>
                    
                    <td class="respuesta">
                     <span class="icon-uniF55C" style="visibility: hidden;"></span>
                     <!--RESPUESTA-->
                    </td>
                  </tr>
                  <tr class="trProyecto">
                    <td class="atributo"><b>Duracion:</b></td>
                    <td class="respuesta">
                    <span class="icon-uniF55C" style="visibility: hidden;"></span>
                    <!--RESPUESTA-->
                    </td>
                  </tr>
                  <tr class="trProyecto"> 
                    <td class="atributo"><b>Servicios incluidos:</b></td>
                    
                    <td class="respuesta">
                     <span class="icon-uniF55C" style="visibility: hidden;"></span>
                     <!--RESPUESTA-->
                    </td>
                  </tr>                             
                  <tr class="trProyecto">
                    <td class="atributo">
                      <dl class="dl-horizontal">
                        <dt style="width: 180px !important; text-align:left !important; "><b>Empleados involucrados:</b></dt>
                        <dd><b>Lider del proyecto:</b> Enrique Xacur</dd>                
                        <dd><b>Programador:</b> Dante cervantes</dd>
                        <dd><b>Diseñador:</b> Beto canul</dd>         
                      </dl>
                    </td>                    
                    <td class="respuesta">
                     <span class="icon-uniF55C" style="visibility: hidden;"></span>
                     <!--RESPUESTA-->
                    </td>
                  </tr>              
                  <tr>
                    <td class="atributo">Descripción</td>                    
                    <td class="respuesta"><span class="icon-uniF55C" style="visibility: hidden;"></span></td>
                  </tr>
                </table>
              </form>
            </div>
            <!-- ------- Archivos del proyecto------- -->
          </div>
          <div class="tab-pane" id="profile">
            <table id="archivos_proy" class="table table-striped">
              <tr class="trProyecto"> 
                <td class="" style="width: 550px"><b>Imagen.png</b></td>                   
                <td class="icon_eliminar_archivo">
                  <span class="icon-circledelete" id="" data-toggle="tooltip" title="Eliminar"></span>                   
                </td>
              </tr>
              <tr class="trProyecto"> 
                <td class=""><b>Imagen.jpg</b></td>                   
                <td class="icon_eliminar_archivo">
                  <span class="icon-circledelete" id="" data-toggle="tooltip" title="Eliminar"></span>                     
                </td>
              </tr>
              <tr class="trProyecto"> 
                <td class=""><b>Logo</b></td>                   
                <td class="icon_eliminar_archivo">
                  <span class="icon-circledelete" id="" data-toggle="tooltip" title="Eliminar"></span>                    
                </td>
              </tr>
              <tr class="trProyecto"> 
                <td class=""><b>banner</b></td>                   
                <td class="icon_eliminar_archivo">
                  <span class="icon-circledelete" id="" data-toggle="tooltip" title="Eliminar"></span>                    
                </td>
              </tr>                        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
