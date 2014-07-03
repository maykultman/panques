<?php
	/**
	* Operaciones en la tabla Servicios de la bd...
	*/
	class Modelo_actividades extends CI_Model
	{
		
		function __construct()
		{
						
		}

		public function insert_act($post)
		{
			$query = $this->db->insert('actividades', $post);
			return $query; 
		}

		public function get_act($id=NULL)
		{
			$this->db->select('*');
			($id==NULL) ? $query = $this->db->get('actividades') :
			$this->db->where('id', $id); $query = $this->db->get('actividades');			
			
			return $query->result();			
		}

		public function update_act($id, $put)
		{
			$this->db->where('id', $id);
			# la variable $put devuelve los campos especificando que datos se actualizaron.
			$query = $this->db->update('actividades', $put);
			# Regresa true o false dependiendo de la consulta.
			return $query;
		}
		public function delete_act($id)
		{
			$query = $this->db->delete('actividades', array('id' => $id));
			return $query;
		}

	} # Fin de la clase Model_phones