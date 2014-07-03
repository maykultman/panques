<?php
	/**
	* Operaciones en la tabla Servicios de la bd...
	*/
	class Model_servicioCliente extends CI_Model
	{
	
		function __construct()
		{
			
		}

		public function insert_servCliente($post)
		{
			$query = $this->db->insert('servicios_cliente', $post);
			return $query; 
		}
		// public function get_servCliente($id)
		// {
		// 	($id===False) ? $query = $this->db->get('servicios_cliente') :
  //                           $query = $this->db->get_where('servicios_cliente', array('id'=>$id));
		// 	return $query->result();			
		// }

		public function get_servCliente() 
		{			
		    $this->db->select('servicios_cliente.id, servicios_cliente.idcliente, servicios_cliente.idservicio, servicios.nombre, servicios_cliente.status');
			$this->db->from('servicios');
			$this->db->join('servicios_cliente', 'servicios_cliente.idservicio = servicios.id');
			$query = $this->db->get();
			return $query->result();			
		}

		public function update_servCliente($id, $put)
		{
			$this->db->where('id', $id);
			// $update = array('status'=>$put['status']);
			# la variable $put devuelve los campos especificando que datos se actualizaron.
			$query = $this->db->update('servicios_cliente', array('status'=>$put['status']));
			# Regresa true o false dependiendo de la consulta.
			return $query;
		}
		public function delete_servCliente($id)
		{
			$query = $this->db->delete('servicios_cliente', array('id' => $id));
			return $query;
		}

	} # Fin de la clase Model_phones