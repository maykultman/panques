<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';

class  Actividades extends REST {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_activities', 'Activities');
    }

    private function index() { }
    
    public function api() {
        $access_token = $this->session->userdata('access_token');
        if ( isset( $access_token ) && $access_token ) {

            $this->Activities->client->setAccessToken( $access_token );

            $metodo = $this->request();
            $this->$metodo();
        } else {
            $metodo = $this->request();
            $this->$metodo();
            echo "No hay access_token";
        }
    }
    private function create() {
        $this->Activities->create( $this->ipost() );
    }

    private function get(){
        return $this->Activities->get($this->id());
    }

    private function update($id) {
        $query = $this->Customer->patch_customer($id, $this->put());             
        $this->pre_response($query, 'update'); 
    }

    private function delete() {
        return $this->Activities->destroy($this->id());
    }
} # Fin de la Clase Api_cliente