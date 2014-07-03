<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Servicios extends REST {

	public function __construct() {
        parent::__construct();
        $this->load->model('Modelo_servicios', 'serv');             
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }
 
    private function create(){

        $query = $this->serv->insert_s($this->ipost());
        $this->pre_response($query, 'create');                  
    }

    private function get(){

    	$query = $this->serv->get_s($this->id());                        
    	$this->pre_response($query, 'get'); 
    	
    }

    private function update(){

    	$query = $this->serv->update_s($this->id(), $$this->put());
        $this->pre_response($query, 'update');         
    }

    private function delete(){

    	$query = $this->serv->delete_s($this->id());    	
        $this->pre_response($query, 'delete'); 
    }

} # Fin de la Clase Api_cliente