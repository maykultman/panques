<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
# Catalogo para el registro de los tipos de telefonos.
include 'REST.php';
class  catalogoTelefonos extends REST {

	public function __construct() {
        parent::__construct();
        $this->load->model('Modelo_catalogoTelefonos', 'Ctel');             
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }

    private function create()
    {
        $query = $this->Ctel->create(  $this->ipost()  );
        $this->pre_response($query, 'create');                  
    }

    private function get()
    {
        $query = $this->Ctel->get( $this->id() ); 
        $this->pre_response($query, 'get'); 
    }

    private function update()
    {
        $query = $this->Ctel->update(  $this->id(), $this->put()  );
                 $this->pre_response             (  $query, 'update'           );
    }

    private function delete()
    {
        $query = $this->Ctel->delete(  $this->id()  ); 
        $this->pre_response($query, 'delete'); 
    }   
} # Fin de la Clase Api_cliente