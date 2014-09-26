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
        $foto = array_keys($_FILES); 
        
        switch ($foto[0]) 
        {
            case 'logoCliente':
                    $save = $this->saveLogo($foto[0]);
                    $this->pre_response($save,'create');
            break;

            case 'logoUsuario':
                    $save = $this->saveLogo($foto[0]);
                    $this->pre_response($save,'create');
            break;

            // case 'archivo' :
            //         $save = $this->saveFile();
            //         $this->pre_response($save,'create');
            // break;
            default:
                    $this->response(false, 200);
                break;
        }
    }

    private function saveLogo($string)
    {
        $carpeta='img/'.$string.'/';
        $oldImg = $this->ipost();
    
        opendir($carpeta); 
        $destino=$carpeta.$_FILES[$string]['name'];  
        if($oldImg['oldFoto']!= $carpeta.'sinfoto.png')
        {
            if(file_exists($oldImg['oldFoto']))
            {
                unlink($oldImg['oldFoto']);    
            }            
        }
        if(copy($_FILES[$string]['tmp_name'], $destino))
        {  
            $config['image_library'] = 'GD';
            $config['source_image'] = $destino;
            $config['maintain_ratio'] = TRUE;
            $config['width']    = 150;
            $config['height']   = 150;

            $this->load->library('image_lib', $config); 

            $this->image_lib->resize();
            return $destino;                   
        } 
                    
    }

} # Fin de la Clase archivosimedia