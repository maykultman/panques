<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Cliente extends REST {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Model_customer', 'Customer');
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }

    private function create()
    { 
        # La función ipost()... Recupera todos los post que viene desde la petición        
        $query = $this->Customer->insert_customer($this->ipost());
        $this->pre_response($query, 'create');                  
    }

    private function get()
    {
       $query = $this->Customer->get_customers($this->ruta()); 
       $this->pre_response($query, 'get'); 
    }

    private function update()
    {        
        # La función put(); Devuelve el array con los campos espicificos para actualizar              
        $query = $this->Customer->patch_customer($this->id(), $this->put());
             
        $this->pre_response($query, 'update');         
    }

    private function delete()
    {
        $query = $this->Customer->delete_customer($this->id());
        $this->pre_response($query, 'delete'); 
    }

} # Fin de la Claase Api_cliente

