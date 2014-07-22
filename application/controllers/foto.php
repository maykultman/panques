<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Foto extends REST {

  public function __construct() {   parent::__construct();   }

    public function api() 
    {   
        $metodo = $this->request(); # El metodo request() hace un switch al metodo de petición
        $this->$metodo();           # y la variable $metod según la respuesta del switch es create, get, update, delete
    }
    
    private function create()
    {
        if(array_key_exists('fotoCliente', $_FILES)) 
        {
            $carpeta="img/fotosClientes/";
            opendir($carpeta);
            $destino=$carpeta.$_FILES['fotoCliente']['name'];  
            if(copy($_FILES['fotoCliente']['tmp_name'], $destino))
            {
                $this->pre_response($_FILES['fotoCliente']['name'],'create');
                    
            }
        }
        if(array_key_exists('fotoUsuario', $_FILES))
        {
            $carpeta="img/fotosUsuarios/";
            opendir($carpeta);
            $destino=$carpeta.$_FILES['fotoUsuario']['name'];  
            if(copy($_FILES['fotoUsuario']['tmp_name'], $destino))
            {
                $this->pre_response($_FILES['fotoUsuario']['name'], 'create');
                   
            }
        }
        else
        {
            $this->response(false, 200);
        }        
    }

} # Fin de la Clase archivosimedia