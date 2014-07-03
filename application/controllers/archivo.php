<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Archivo extends REST {

	public function __construct() {
        parent::__construct();
        $this->load->model('Modelo_archivos', 'archivos');             
    }

    public function api() 
    {   
        $metodo = $this->request(); # El metodo request() hace un switch al metodo de petición
        $this->$metodo();           # y la variable $metod según la respuesta del switch es create, get, update, delete
    }
    
    private function create()
    {
        $query = $this->archivos->create($this->ipost());
        $this->pre_response($query, 'create'); 
    }

    private function get()
    {
    	$query = $this->archivos->get($this->id());                        
    	$this->pre_response($query, 'get'); 	
    }

    private function update()
    {
        $query = $this->archivos->save($this->id(), $this->put());
        $this->pre_response($query, 'update');        
    }

    private function delete()
    {
    	$query = $this->archivos->destroy($this->id());    	
        $this->pre_response($query, 'delete');        
    }

} # Fin de la Clase archivosimedia