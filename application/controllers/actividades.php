<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'api.php';
class  Actividades extends Api {

    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo_actividades', 'activ');             
    }

    public function api() {

        # Con esta funcion obtnemos el id de la petición.
        # get(), update(), delete()
        $id = $this->uri->segment(2);      

        switch ($this->metodo()) {
            case 'post':
                $this->insert_actividades();
                break;
            case 'get':
                $this->get_actividades($id);
                break;  
            case 'put':
                 $this->update_actividades($id);
                break;  
            case 'delete':
                $this->delete_actividades($id);
                break;
            default:
                $this->response('',405);
                break;
        }

    }
    
    private function insert_actividades(){

        # Con $this->inpost() recuperamos las variables post y lo enviamos al modelo...
        $post = $this->ipost();         
        $query = $this->activ->insert_act($post);
        # $query regresa true o false y con esto enviamos un codigo de respuesta al cliente...
        ($query) ? $this->response($query, 201) : $this->response($query, 406);
    }

    private function get_actividades($id){

        $query = $this->activ->get_act($id);                        
        ($query) ? $this->response($query, 200) : $this->response($query, 404);
        
    }

    private function update_actividades($id){

        $put = $this->put();
        $query = $this->activ->update_act($id, $put);
        ($query) ? $this->response($query, 200) : $this->response($query, 204);        
    }

    private function delete_actividades($id){

        $query = $this->activ->delete_act($id);        
        ($query)? $this->response($query, 200) : $this->response($query, 406);        
    }

} # Fin de la Clase Api_cliente