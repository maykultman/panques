<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Foto extends REST {

  public function __construct() {   parent::__construct();   }

    public function api() 
    {   
        $metodo = $this->request(); # El metodo request() hace un switch al metodo de petición
        $this->$metodo();           # y la variable $metod según la respuesta del switch es create, get, update, delete
    }
    # Esta función guarda el logo del cliente y el del usuario
    private function create()
    {
        $foto = array_keys($_FILES); #Obtenemos el indice del array

        # Si en la varible no hay logo retornamos un nombre de 
        # logo por default para no devolver un error
        if(empty($_FILES[$foto[0]]["name"]))
        {
            return $this->response('img/sinfoto.png',201); 
        }
        else
        {
            $save = $this->saveLogo($foto[0]); 
            return $this->response($save, 201);
        }        
    }

    private function saveLogo($string)
    {
        $carpeta='img/'.$string.'/';
        # Obtenemos el nombre antigüo de la foto para poder eliminarlo y guardar la nueva
        #$oldImg = $this->ipost(); # con esta función capturamos las variables post...
        
        if($this->input->post()) { $oldImg = $this->ipost(); }
        # Abrimos el directorio...
        opendir($carpeta); 
        # Concatenamos el directorio destino con el nombre del archivo.
        $destino=$carpeta.$_FILES[$string]['name']; 
        if(isset($oldImg))
        {
            # Esta condición se ejecuta cuando el usuario va a actualizar una foto.
            if(array_key_exists('oldFoto', $oldImg))
            {
                if($oldImg['oldFoto']!= $carpeta.'sinfoto.png')
                {
                    if(file_exists($oldImg['oldFoto']))
                    {
                        unlink($oldImg['oldFoto']); # Borramos la foto antigüa
                    }            
                }    
            }
        }
        # Ahora guardamos la nueva foto
        if(copy($_FILES[$string]['tmp_name'], $destino))
        {  
            // $config['image_library'] = 'GD';
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