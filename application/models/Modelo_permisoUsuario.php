<?php

	require_once 'Modelo_crud.php';
	class Modelo_permisoUsuario extends Modelo_crud
	{
		public function __construct(){}
		# DATOS DEL MODELO TELEFONOS
		# $post ['ipropietario']         $post ['tabla']
		# $post ['numero'      ] 		 $post ['tipo' ]
		
		public function create($args)
        {   
            $this->db->insert('permisousuario', $args);
            return $this->get($this->db->insert_id());     
        }
        
        public function get ( $id = FALSE ) 
        {  
        
          $reply = $this->where(  $id  );  # Ejecutamos el metodo where...      
          return $this->db->get  ( 'permisousuario' )->$reply();  # Este metodo ejecuta get con y sin ID...
        }

        public function save (  $id,  $put ) 
        {   
            return $this->db->update('permisousuario', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('permisousuario', array('id' => $id)  ); 
        }
	} # Fin de la clase Modelo_proyecto
