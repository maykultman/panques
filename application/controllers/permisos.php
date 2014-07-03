<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'REST.php';
class  Permisos extends REST {

    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo_permisos', 'perm');
        // $this->load->model('Modelo_crud', 'perm');
        // $this->tabla = 'permisos';
                     
    }

    public function api() 
    {
        $metodo = $this->request();
        $this->$metodo();
    }
   
    private function create(){
        
        # $query regresa true o false y con esto enviamos un codigo de respuesta al cliente...
        $query = $this->perm->create ( $this->ipost()   );        
                 $this->pre_response ( $query, 'create' );                  
    }

    private function get(){
        
        $query = $this->perm->get     ( $this->id()   );                        
                 $this->pre_response  ( $query, 'get' ); 
        
    }

    private function update()
    {    
        $query = $this->perm->save   (  $this->id(), $this->put() );
                 $this->pre_response (  $query, 'update'          );         
    }

    private function delete()
    {  
        $query = $this->perm->destroy (  $this->id()      );        
                 $this->pre_response  (  $query, 'delete' ); 
    }

} # Fin de la Clase Api_cliente