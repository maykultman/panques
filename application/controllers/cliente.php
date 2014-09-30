<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Cliente extends REST {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Model_customer', 'Customer');
    }

    public function api($id=NULL) 
    {
        $metodo = $this->request();
        $this->$metodo($id);
    }

    private function create()
    { 
        # La función ipost()... Recupera todos los post que viene desde la petición        
        $query = $this->Customer->insert_customer($this->ipost());
        $this->pre_response($query, 'create');                  
    }

    private function get($id)
    {
       $query = $this->Customer->get($id); 
       $this->pre_response($query, 'get'); 
    }

    private function update($id)
    {        
        # La función put(); Devuelve el array con los campos espicificos para actualizar              
        $query = $this->Customer->patch_customer($id, $this->put());             
        $this->pre_response($query, 'update');         
    }

    private function delete($id)
    {
        $query = $this->Customer->delete_customer($id);
        $this->pre_response($query, 'delete'); 
    }

} # Fin de la Claase Api_cliente

