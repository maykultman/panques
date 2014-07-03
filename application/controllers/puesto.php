<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Puesto extends REST {

	public function __construct() 
    {
        parent::__construct();
        $this->load->model('Model_puesto', 'puesto');             
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }
    
    private function create()
    {
        $query = $this->puesto->create(  $this->ipost()  );
        $this->pre_response($query, 'create');                  
    }

    private function get()
    {
        $query = $this->puesto->get( $this->id() ); 
        $this->pre_response($query, 'get'); 
    }

    private function update()
    {
        $query = $this->puesto->save(  $this->id(), $this->put()  );
        $this->pre_response($query, 'update');                 
    }

    private function delete()
    {
        $query = $this->puesto->destroy(  $this->id()  ); 
        $this->pre_response($query, 'delete');        
    }   
} # Fin de la Clase Api_cliente