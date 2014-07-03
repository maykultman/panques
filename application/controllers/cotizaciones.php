<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Cotizaciones extends REST {

	public function __construct() {
        parent::__construct();
        $this->load->model('Model_budget', 'budget');             
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }
    
    private function create()
    {   
        $query = $this->budget->create(  $this->ipost()  );
        $this->pre_response($query, 'create');                  
    }

    private function get()
    {
        $query = $this->budget->get( $this->id() );
    	$this->pre_response($query, 'get'); 
    }

    private function update()
    {
    	$query = $this->budget->save(  $this->id(), $this->put()  );
        $this->pre_response($query, 'update');               
    }

    private function delete()
    {
    	$query = $this->budget->destroy(  $this->id()  ); 
        $this->pre_response($query, 'delete');        
    }

} # Fin de la Clase Cotizaciones