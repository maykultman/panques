<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Proyectos extends REST {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Modelo_proyecto', 'proy');  # Cargamos el modelo proyectos      
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }

    private function create()
    {
        $query = $this->proy->create(  $this->ipost()  );
        $this->pre_response($query, 'create');                  
    }

    private function get()
    {
        $query = $this->proy->get( $this->id() ); 
        $this->pre_response($query, 'get'); 
    }

    private function update()
    {
        $query = $this->proy->save( $this->id() , $this->put()  );
        $this->pre_response($query, 'update');                 
    }

    private function delete()
    {
        $query = $this->proy->destroy( $this->id()   ); 
        $this->pre_response($query, 'delete');        
    }   

} # Fin de la Clase Api_cliente


// $query = $this->proy->crud('proyectos','insert', '', $this->ipost());
// $query = $this->proy->crud('proyectos','get', $id); 
// ($put) ? $query = $this->proy->crud('proyectos','update', $id, $put) : $query = true;