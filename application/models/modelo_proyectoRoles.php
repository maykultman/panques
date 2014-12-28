<?php
	/**
	* Operaciones en la tabla phones de la bd...
	*/
	class Modelo_proyectoRoles extends CI_Model
	{
		
		function __construct(){	}

		public function insertProyRol($post){
			// return $query = $this->db->insert('rol_emp_proy', $post);

			$this->db->insert('rol_emp_proy', $post);
			return $this->getProyRol($this->db->insert_id()); 
		}
		# Fin del metodo insertar telefono.

		public function getProyRol($id=FALSE)
		{
			// ($id===FALSE) ? $query = $this->db->get('rol_emp_proy') :
			// 			    $query = $this->db->get_where('rol_emp_proy', array('idproyecto'=>$id));			
			// return $query->result();

			$reply = 'result';
			if($id)
			{
				$this->db->where('id',$id);  
				#$reply = 'row';
			}          
			return $this->db->get  ( 'rol_emp_proy' )->$reply();
		}

		public function patchProyRol($id, $put)
		{
			(!$id) ? $query = $this->db->insert('rol_emp_proy',$put) : # Si no llega id entonces se hace un insert
			         $this->db->where('id', $id); 
			         $query = $this->db->update('rol_emp_proy', $put); # Si llega un id se actualiza ese dato
			return $query;			         
		}
		public function deleteProyRol($id)
		{
			$query = $this->db->delete('rol_emp_proy', array('id' => $id));
			return $query;
		}

	} # Fin de la clase Model_phones