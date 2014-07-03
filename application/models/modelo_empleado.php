<?php
	require_once 'Modelo_crud.php';
	class Modelo_empleado extends Modelo_crud
	{
		public function __construct () { }

		#	            DATOS DEL MODELO EMPLEADO
		#	$post ['nombre']........$post ['descripcion']
		
	  public function create($post) 
      {   
        $this->db->insert('empleados', $post);
        return $this->get($this->db->insert_id());  
      }

      # Este metodo línea hace dos cosas devuelve todos los registros o devuelve el especificado con el ID
      public function get ( $id = FALSE ) 
      {  
        $reply = $this->where($id);
        return $this->db->get  ( 'empleados' )->$reply();
      }

      public function save (  $id,  $put ) 
      { 
        return $this->db->update('empleados', $put, array('id' => $id)  ); 
      }   
      
      public function destroy (  $id  ) 
      { 
        return $this->db->delete('empleados', array('id' => $id)  ); 
      }

	} # Fin de la clase Modelo_proyecto