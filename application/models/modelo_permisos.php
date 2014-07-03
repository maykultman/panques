<?php
	#            DATOS DEL MODELO PERMISO
	# $post ['nombre']........$post ['descripcion']
	require_once 'Modelo_crud.php';
	class Modelo_permisos extends Modelo_crud
	{
		public function __construct(){}

		public function create($post) 
		{   
			$this->db->insert('permisos', $post);
			return $this->get($this->db->insert_id());	
		}

		# Este metodo línea hace dos cosas devuelve todos los registros o devuelve el especificado con el ID
		public function get ( $id = FALSE ) 
		{ 	
			$reply = $this->where($id);
			return $this->db->get  ( 'permisos' )->$reply();
		}

		public function save (  $id,  $put ) 
		{	
			return $this->db->update('permisos', $put, array('id' => $id)  );	
		}		
		
		public function destroy (  $id  ) 
		{	
			return $this->db->delete('permisos', array('id' => $id)  );	
		}

	} # Fin de la clase Modelo_permisos