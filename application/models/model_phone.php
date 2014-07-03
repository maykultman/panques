<?php

	require_once 'Modelo_crud.php';
	class Model_phone extends Modelo_crud
	{
		public function __construct(){}
		# DATOS DEL MODELO TELEFONOS
		# $post ['ipropietario']         $post ['tabla']
		# $post ['numero'      ] 		 $post ['tipo' ]
		
		public function create($args)
        {   
            $this->db->insert('telefonos', $args);
            return $this->get($this->db->insert_id());     
        }
        
        public function get ( $id = FALSE ) 
        {  
          $reply = $this->where(  $id  );  # Ejecutamos el metodo where...      
          return $this->db->get  ( 'telefonos' )->$reply();  # Este metodo ejecuta get con y sin ID...
        }

        public function save (  $id,  $put ) 
        {   
            return $this->db->update('telefonos', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('telefonos', array('id' => $id)  ); 
        }
	} # Fin de la clase Modelo_proyecto


		