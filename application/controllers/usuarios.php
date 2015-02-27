<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Usuarios extends REST 
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Modelo_usuarios', 'user');             
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }
    
    private function create()
    {
        $post = $this->ipost();
        $post['contrasenia'] = md5($post['contrasenia']);
        $query = $this->user->create($post);
        $this->pre_response($query, 'create');                        
    }

    private function get()
    {
        $query = $this->user->get($this->id());                        
        $this->pre_response($query, 'get'); 
    }

    private function update()
    {
        $query = $this->put();  
        $data = array();     
       
        if(isset($query['contrasena']))
        {
            $query['contrasenia'] = md5($query['contrasena']);            
        }   
        
        $query = $this->user->save($this->id(), $query);
        $this->pre_response($data, 'update');         
    }

    private function delete()
    {
        $query = $this->user->destroy($this->id());        
        $this->pre_response($query, 'delete'); 
    }

} # Fin de la Clase Usuario