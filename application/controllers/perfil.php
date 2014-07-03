<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Perfil extends REST{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Modelo_perfil', 'perfil');             
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }
    
    private function create()
    {
        $query = $this->perfil->create($this->ipost());
        $this->pre_response($query, 'create');                  
    }

    private function get()
    {
        $query = $this->perfil->get($this->id());                        
        $this->pre_response($query, 'get'); 
    }

    private function update()
    {
        $query = $this->perfil->save($this->id(), $this->put());
        $this->pre_response($query, 'update');         
    }

    private function delete()
    {
        $query = $this->perfil->destroy($this->id());        
        $this->pre_response($query, 'delete'); 
    }

} # Fin de la Clase Api_cliente