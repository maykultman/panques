<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  ServiciosCliente extends REST {

	public function __construct() {
        parent::__construct();
        $this->load->model('Model_servicioCliente', 'servicio');             
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }
    
    private function create(){
       
        $query = $this->servicio->insert_servCliente($this->ipost());
        # $query regresa true o false y con esto enviamos un codigo de respuesta al cliente...
        $this->pre_response($query, 'create');                  
    }

    private function get(){

    	$query = $this->servicio->get_servCliente($this->id());                        
    	$this->pre_response($query, 'get'); 
    	
    }

    private function update(){

    	$query = $this->servicio->update_servCliente($this->id(), $this->put());
        $this->pre_response($query, 'update');         
    }

    private function delete(){

    	$query = $this->servicio->delete_servCliente($this->id());    	
        $this->pre_response($query, 'delete'); 
    }

} # Fin de la Clase Api_cliente