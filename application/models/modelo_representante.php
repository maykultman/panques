 <?php
    require_once 'Modelo_crud.php';

    #  DATOS DEL MODELO REPRESENTANTE....
    #  'idcliente' => $post['idcliente' ],  'nombre' =>$post['nombre'],
    #  'correo'    => $post['correo'    ],  'cargo'  =>$post['cargo' ],

  class Modelo_representante extends Modelo_crud
  { 
      public function __construct(){}
      
      public function create($args)
      {   
            $this->db->insert('representantes', $args);
            return $this->get($this->db->insert_id());     
      }
        
      public function get ( $id = FALSE ) 
      {  
        $reply = $this->where(  $id  );  # Ejecutamos el metodo where...      
        return $this->db->get  ( 'representantes' )->$reply();  # Este metodo ejecuta get con y sin ID...
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