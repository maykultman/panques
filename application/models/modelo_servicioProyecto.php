<?php
	// require_once 'Modelo_crud.php';
	class Modelo_servicioProyecto extends CI_Model
	{
		# ............DATOS MODELO SERVICIO PROYECTO...........
		# $post['idproyecto'], $post['idservicio'], $post['status']
		
		function __construct(){ }

		public function create($post) 
		{   					 	
			$this->db->insert('servicios_proy', $post);
			return $this->get($this->db->insert_id()); 
		}
		
		public function get($id=FALSE) 
		{
			$reply = 'result';
			if($id)
			{
				$this->db->where('id',$id);  
				#$reply = 'row';
			}          
			return $this->db->get  ( 'servicios_proy' )->$reply();
		}

		public function save (  $id,  $put ) 
		{	
			return $this->db->update ( 'servicios_proy', $put, array('id' => $id)  );	
		}
		public function destroy (  $id  ) 
		{	
			return $this->db->delete ( 'servicios_proy', array('id' => $id)  );	
		}

	} # Fin de la clase Model_phones