<?php
	/**
	* Operaciones en la tabla phones de la bd...
	*/
	class Modelo_proyectoRoles extends CI_Model
	{
		
		function __construct(){	}

		public function insertProyRol($post){
			// return $query = $this->db->insert('rol_emp_proy', $post);

			// $this->db->insert('rol_emp_proy', $post);
			// return $this->getProyRol($this->db->insert_id()); 

			if(!is_array($post['idrol']))
            {
                $this->db->insert('rol_emp_proy', $post);
                return $this->getProyRol($this->db->insert_id());    
            }
            else
            {
                for($i=0; $i<count($post['idrol']); $i++)
                {
                    $this->db->insert('rol_emp_proy',
                    array('idrol'=>$post['idrol'][$i],
						'idpersonal'=> $post['idpersonal'],
						'idproyecto'=>$post['idproyecto']
                          ));
                    $id['exito'][$i] = $this->db->insert_id();
                }
                return $id;
            }
		}
		# Fin del metodo insertar telefono.

		public function getProyRol($id=FALSE)
		{
			$reply = 'result';
			if($id)
			{
				$this->db->where('id',$id);  
				$reply = 'row';
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