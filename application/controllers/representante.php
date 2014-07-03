<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Representante extends REST {

    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo_representante', 'rep');             
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }

    private function create()
    {
        $query = $this->rep->create(  $this->ipost()  );
        # El metodo pre_response() establece el codigo de respuesta y acepta dos parametros 
        # El resultado de la $query y el metodo que se acaba de ejecutar...
        $this->pre_response($query, 'create');        
    }

    private function get()
    {
        $query = $this->rep->get( $this->id() ); 
        $this->pre_response($query, 'get');     
    }

    private function update()
    {
        $query = $this->rep->save(  $this->id(), $this->put()  );
        $this->pre_response($query, 'update');  
    }

    private function delete()
    {
        $query = $this->rep->delete(  $this->id()  ); 
       $this->pre_response($query, 'delete');  
    }   
} # Fin de la Clase Api_contacto