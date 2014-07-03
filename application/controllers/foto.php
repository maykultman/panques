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
        if(!empty($_FILES))
        {
            if(array_key_exists('fotoCliente', $_FILES)&&$_FILES['fotoCliente']['name']!="")
            {
                $carpeta="img/fotosClientes/";
                opendir($carpeta);
                $destino=$carpeta.$_FILES['fotoCliente']['name'];  
                if(copy($_FILES['fotoCliente']['tmp_name'], $destino))
                {
                    $this->pre_response($_FILES['fotoCliente']['name'],'create');
                    
                }
                return FALSE;  
            }
            elseif(array_key_exists('fotoUsuario', $_FILES)&&$_FILES['fotoUsuario']['name']!="")
            {
                $carpeta="img/fotosUsuarios/";
                opendir($carpeta);
                $destino=$carpeta.$_FILES['fotoUsuario']['name'];  
                if(copy($_FILES['fotoUsuario']['tmp_name'], $destino))
                {
                    $this->pre_response($_FILES['fotoUsuario']['name'], 'create');
                    
                }
                return FALSE;   
            }
        }
    }

} # Fin de la Clase archivosimedia