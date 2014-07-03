<?php
	/**
	* Operaciones en la tabla Servicios de la bd...
	*/
	require_once 'modelo_crud.php';
	class Modelo_servicios extends Modelo_crud
	{		
		function __construct()
		{
			
		}

		public function insert_s($post)
		{  

				$this->db->insert('servicios', $post); 	$id = $this->db->insert_id();
				return $this->get_s($id); 	

		} # Fin del metodo insertar...

		public function get_s($id=FALSE)
		{
			$reply = $this->where( $id );     
            return $this->db->get  ( 'servicios' )->$reply();   			
		}
		# Esta funcion le sirve a la interfaz de modulo cliente_nuevo y consulta_cliente...

		public function get_sNuevoCliente()
		{
			$this->db->select('id, nombre, concepto');
			$this->db->order_by('nombre', 'asc');
			$query = $this->db->get('servicios');
			if($query){ return $query->result(); }else{ return false;}		
		}

		# Devuelve el id y el nombre para la busqueda de servicios en el
		# modulo de proyetos...
		public function get_Servicios_Proyecto()
		{
			$this->db->select('id, nombre');
			return $this->db->get('servicios')->result();
		}

		public function patch_s($id, $put)
		{
			(array_key_exists(0, $put)&&is_object($put[0])) ? $put = (array)$put[0] : $put = $put;	
			$this->db->where('id', $id);
			# la variable $put devuelve los campos especificando que datos se actualizaron.
			return $this->db->update('servicios', $put);
		
		}

		public function update_s($id, $put)
		{
			$this->db->where('id', $id);
			# la variable $put devuelve los campos especificando que datos se actualizaron.
			return $query = $this->db->update('servicios', $put);			
		}

		public function delete_s($id)
		{
			return $this->db->delete('servicios', array('id' => $id));			
		}

	} # Fin de la clase Model_phones
