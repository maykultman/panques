<?php
    #           ..........DATOS DEL MODELO CONTACTO....
    #  'idcliente' => $post['idcliente' ],  'nombre' =>$post['nombre'],
    #  'correo'    => $post['correo'    ],  'cargo'  =>$post['cargo' ],

    // require_once 'modelo_crud.php';
    class Model_contact extends CI_Model
    { 
      public function __construct( ) {}      

        public function create($args)
        {   
            $this->db->insert('contactos', $args);
            return $this->get($this->db->insert_id());     
        }
        
        public function get ( $id = FALSE ) 
        {  
          //$reply = $this->where(  $id  );  # Ejecutamos el metodo where...      
          //return $this->db->get  ( 'contactos' )->$reply();  # Este metodo ejecuta get con y sin ID...

          $reply = 'result';
          if(is_numeric($id))
          {
            $this->db->where(  'id',$id  );
            $reply = 'row';
          }
          return $this->db->get  ( 'contactos' )->$reply();
        }

        public function save (  $id,  $put ) 
        {   
            return $this->db->update('contactos', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('contactos', array('id' => $id)  ); 
        }
    }    