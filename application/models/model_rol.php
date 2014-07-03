<?php
	require_once 'Modelo_crud.php';
	class Model_rol extends Modelo_crud
	{
		public function __construct(){}

		#				            DATOS DEL MODELO ROL
		#				 $post ['nombre']........$post ['descripcion']
		
		public function create($args)
        {   
            $this->db->insert('roles', $args);
            return $this->get($this->db->insert_id());     
        }
        
        public function get ( $id = FALSE ) 
        {  
           $reply = $this->where( $id );  # Ejecutamos el metodo where...      
           return $this->db->get  ( 'roles' )->$reply();  # Este metodo ejecuta get con y sin ID...
        }

        public function save (  $id,  $put ) 
        {   #var_dump($put); die();
            return $this->db->update('roles', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('roles', array('id' => $id)  ); 
        }

	} # Fin de la clase Modelo_proyecto