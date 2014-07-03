<?php
    require_once 'Modelo_crud.php';

    #  DATOS DEL MODELO CONTRATO....
    #  'fecha'       => $post['fecha'       ],  'fecha_inicio' =>$post['fecha_inicio'],
    #  'fecha_final' => $post['fecha_final' ],  'honorario'    =>$post['honorario'   ],

  class Model_contract extends Modelo_crud
  { 
      public function __construct(){}
      
      public function create($post) 
      {   
        $this->db->insert('contratos', $post);
        return $this->get($this->db->insert_id());  
      }

      public function get ( $id = FALSE ) 
      {  
        $reply = $this->where($id);
        return $this->db->get  ( 'contratos' )->$reply();
      }

      public function save (  $id,  $put ) 
      { 
        return $this->db->update('contratos', $put, array('id' => $id)  ); 
      }   
      
      public function destroy (  $id  ) 
      { 
        
        return $this->db->delete('contratos', array('id' => $id)  ); 
      }
  }    
