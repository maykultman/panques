<?php
	require_once 'Modelo_crud.php';
	class Modelo_permisoPerfil extends Modelo_crud
	{
		public function __construct(){}

		#				            DATOS DEL MODELO ROL
		#				 $post ['nombre']........$post ['descripcion']
		
		public function create($args)
        {   
            $this->db->insert('permisos_perfil', $args);
            return $this->get($this->db->insert_id());     
        }
        
        public function get ( $id = FALSE ) 
        {  
           $reply = $this->where( $id );  # Ejecutamos el metodo where...      
           return $this->db->get  ( 'permisos_perfil' )->$reply();  # Este metodo ejecuta get con y sin ID...
        }

        public function save (  $id,  $put ) 
        {   #var_dump($put); die();
            return $this->db->update('permisos_perfil', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('permisos_perfil', array('id' => $id)  ); 
        }

	} # Fin de la clase Modelo_proyecto