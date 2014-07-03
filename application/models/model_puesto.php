<?php
	require_once 'Modelo_crud.php';
	class Model_puesto extends Modelo_crud
	{
		public function __construct(){}

		#				            DATOS DEL MODELO Puesto
		#				 $post ['nombre']........$post ['descripcion']
		
		public function create($args)
        {  
            $this->db->insert('puestos', $args);
            return $this->get($this->db->insert_id());     
        }
        
        public function get ($id=FALSE) 
        {  
           $reply = $this->where( $id );  # Ejecutamos el metodo where... 
           $this->db->order_by('nombre', 'asc');    
           return $this->db->get  ( 'puestos' )->$reply();  # Este metodo ejecuta get con y sin ID...
        }

        public function save (  $id,  $put ) 
        {   #var_dump($put); die();
            return $this->db->update('puestos', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('puestos', array('id' => $id)  ); 
        }

	} # Fin de la clase Modelo_proyecto