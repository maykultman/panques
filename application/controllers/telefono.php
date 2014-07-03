<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Telefono extends REST {

	public function __construct() {
        parent::__construct();
        $this->load->model('Model_phone', 'phone');             
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }
    
    private function create()
    {        
        $query = $this->phone->create($this->ipost());
        $this->pre_response($query, 'create');                  
    }

    private function get()
    {
    	$query = $this->phone->get($this->id());                            
    	$this->pre_response($query, 'get'); 
    }

    private function update()
    {
        $query = $this->phone->save($this->id(), $this->put());
        $this->pre_response($query, 'update');         
    }

    private function delete()
    {
    	$query = $this->phone->destroy($this->id());    	
        $this->pre_response($query, 'delete'); 
    }
} # Fin de la Clase Api_cliente