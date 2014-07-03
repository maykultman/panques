<?php
	require_once 'Modelo_crud.php';
	class Modelo_catalogoTelefonos extends Modelo_crud
	{
		public function __construct(){}

		#	     DATOS DEL MODELO CATALOGO TELEFONOS
		#	$post ['nombre']........$post ['descripcion']
		
		public function create($args)
        {   
            $this->db->insert('catalogoTelefonos', $args);
            return $this->get($this->db->insert_id());     
        }
        
        public function get ( $id = FALSE ) 
        {  
          $reply = $this->where(  $id  );  # Ejecutamos el metodo where...      
          return $this->db->get  ( 'catalogoTelefonos' )->$reply();  # Este metodo ejecuta get con y sin ID...
        }

        public function save (  $id,  $put ) 
        {   
            return $this->db->update('catalogoTelefonos', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('catalogoTelefonos', array('id' => $id)  ); 
        }

	} # Fin de la clase Modelo_proyecto