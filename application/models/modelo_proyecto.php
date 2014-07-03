<?php
	require_once 'Modelo_crud.php';
	class Modelo_proyecto extends Modelo_crud
	{
		public function __construct(){}

		# DATOS DEL MODELO PROYECTO
		# $post['idcliente'   ], $post['nombre'    ], 
		# $post['fecha inicio'], $post['fechafinal'], 
		# $post['descripción' ]	

		public function create($args)
        {   
            $this->db->insert('proyectos', $args);
            return $this->get($this->db->insert_id());     
        }
        
        public function get ( $id = FALSE ) 
        {  
           $reply = $this->where( $id );  # Ejecutamos el metodo where...      
           return $this->db->get  ( 'proyectos' )->$reply();  # Este metodo ejecuta get con y sin ID...
        }

        public function save (  $id,  $put ) 
        {   
            return $this->db->update('proyectos', $put, array('id' => $id)  );   
        }       
        
        /*Anterior mente decia delete y le cambie a destroy*/
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('proyectos', array('id' => $id)  ); 
        }

	} # Fin de la clase Modelo_proyecto

// Metodos alternativos se pueden usar desde el controlador son metodos de la clase modelo_crud es generica...
// return $this->crud('roles', 'insert', '', $post);
// return $this->crud('roles','get', $id);			
// return $this->crud('roles', 'update',$id, $put);
// return $this->crud('roles', 'delete', $id);