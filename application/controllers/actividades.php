<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';

class  Actividades extends REST {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_Actividades', 'Actividades');
    }

    private function index() { }
    
    public function api() {
        $metodo = $this->request();
        // $this->$metodo();
        var_dump($metodo);

    }
    private function create() {
        $query = $this->Customer->insert_customer($this->ipost());
        $this->pre_response($query, 'create'); 
    }

    private function get($id){
        $query = $this->Customer->get($id); 
        $this->pre_response($query, 'get'); 
    }

    private function update($id) {
        $query = $this->Customer->patch_customer($id, $this->put());             
        $this->pre_response($query, 'update'); 
    }

    private function delete($id) {
        $query = $this->Customer->delete_customer($id);
        $this->pre_response($query, 'delete');
    }
} # Fin de la Clase Api_cliente