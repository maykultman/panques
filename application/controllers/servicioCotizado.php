<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  ServicioCotizado extends REST {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Modelo_servicioCotizado', 'servCotizado');
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }

    private function create()
    { 
        # La función ipost()... Recupera todos los post que viene desde la petición        
        $query = $this->servCotizado->create($this->ipost());
        $this->pre_response($query, 'create');                  
    }

    private function get()
    {
       $query = $this->servCotizado->get($this->id()); 
       $this->pre_response($query, 'get'); 
    }

    private function update($id)
    {   
        $query = $this->servCotizado->save($id, $this->put());
        $this->pre_response($query, 'update');         
    }

    private function delete($id)
    {
        $query = $this->servCotizado->delete($id);
        $this->pre_response($query, 'delete'); 
    }

} # Fin de la Claase Api_cliente

