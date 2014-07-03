<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  RolesDeProyecto extends REST {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Modelo_proyectoRoles', 'proyRol');       
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }

    private function create()
    {   # La función ipost()... Recupera todos los post que viene desde la petición        
        $query = $this->proyRol->insertProyRol($this->ipost());
        $this->pre_response($query, 'create');                  
    }

    private function get()
    {
       $query = $this->proyRol->getProyRol($this->id()); 
       $this->pre_response($query, 'get'); 
    }
    private function update()
    {        
        # La función put(); Devuelve el array con los campos espicificos para actualizar              
        $query = $this->proyRol->updateProyRol($this->id(), $this->put());
             
        $this->pre_response($query, 'update');         
    }

    private function delete()
    {
        $query = $this->proyRol->deleteProyRol($this->id());
        $this->pre_response($query, 'delete'); 
    }

} # Fin de la Clase Api_cliente

