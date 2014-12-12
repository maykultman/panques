<?php
  class modelo_representante extends CI_Model
  { 

      public function create($args)
      {   
            $this->db->insert('representantes', $args);
            return $this->get($this->db->insert_id());     
      }
        
      public function get ( $id = FALSE ) 
      {
          $reply = 'result';
          if(is_numeric($id))
          {
              $this->db->where( 'id', $id );
              $reply = 'row';
          }
        return $this->db->get  ( 'representantes' )->$reply(); // # Este metodo ejecuta get con y sin ID...
      }

      public function save (  $id,  $put ) 
      {   
        return $this->db->update('representantes', $put, array('id' => $id)  );   
      }       
        
      public function destroy (  $id  ) 
      {   
        return $this->db->delete('representantes', array('id' => $id)  ); 
      }
  }    