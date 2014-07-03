<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Empleados extends REST {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Modelo_empleado', 'emp');       
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }

    private function create()
    {
        # La función ipost()... Recupera todos los post que viene desde la petición        
        $query = $this->emp->create($this->ipost());
        $this->pre_response($query, 'create');                  
    }

    private function get()
    {
       $query = $this->emp->get($this->id());
       $this->pre_response($query, 'get'); 
    }

    private function update()
    {        
        # La función put(); Devuelve el array con los campos espicificos para actualizar              
        $query = $this->emp->save($this->id(), $this->put());
             
        $this->pre_response($query, 'update');         
    }

    private function delete()
    {
        $query = $this->emp->destroy($this->id());
        $this->pre_response($query, 'delete'); 
    }

} # Fin de la Clase Api_cliente

