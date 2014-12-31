<?php
    // require_once 'modelo_crud.php';
    class Modelo_servicioCotizado extends CI_Model
    {   
        public function create($post) 
        {
          $this->db->insert('servicios_cotizados', $post);
          return $this->get($this->db->insert_id());  
        }# Fin del metodo insert_mcontact()...

        public function get ( $id = FALSE ) 
        {
            // $reply = $this->where($id);
            // return $this->db->get  ( 'servicios_cotizados' )->$reply();

            $reply = 'result';
            if(is_numeric($id))
            {
                $this->db->where( 'id', $id );
                $reply = 'row';
            }
            return $this->db->get  ( 'servicios_cotizados' )->$reply();
        } # Fin del metodo get_cotizacion()...

        public function save (  $id,  $put ) 
        { 
          return $this->db->update('servicios_cotizados', $put, array('id' => $id)  ); 
        }   
      
        public function destroy (  $id  ) 
        { 
          return $this->db->delete('servicios_cotizados', array('id' => $id)  ); 
        }
}