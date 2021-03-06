<?php
	/**
	* Operaciones en la tabla Servicios de la bd...
	*/
	class Modelo_servicios extends CI_Model
	{		
		function __construct()
		{
			
		}

		public function insert_s($post)
		{  //var_dump($post); die();

			// if(!$post['nombre'][0])
			// {
			// 	$this->db->insert('servicios', $post['nombre']); 	$id = $this->db->insert_id();
			// 	return $this->get_s($id); 						
			// }

			if(!is_array($post['nombre']))
			{
				$this->db->insert('servicios', $post); 	$id = $this->db->insert_id();
				return $this->get_s($id); 	
			}
			
			
			# Servicios nuevos creados desde el modulo de clientes
			for ($i = 0 ; $i<count($post['nombre']); $i++)
			{
				$this->db->insert('servicios',array('nombre'=> $post['nombre'][$i])); 
				$ids[$i] = $this->db->insert_id();		
			}
			# con los id´s de los servicios acabados de ingresar los enviamos a la tabla de servicios cuenta.
			if(array_key_exists('servicioscuenta', $post))
			{
				for ($h = 0 ; $h<count($post['nombre']); $h++)
				{
					$this->db->insert('servicios_cliente',array('idcliente'=> $post['idcliente'],
																'idservicio'=>$ids[$h],
																'status'=> $post['status'][$h])); 
					$resp[$h] = $this->db->insert_id();		
				}
				return count($resp);
			}
			if(array_key_exists('serviciosinteres', $post))
			{
				for ($j = 0 ; $j<count($post['nombre']); $j++)
				{
					$this->db->insert('servicios_interes',array('idcliente'=> $post['idcliente'],
																'idservicio'=>$ids[$j],
																'status'=> $post['status'][$j])); 
					$resp[$j] = $this->db->insert_id();		
				}
				return count($resp);
			}
				

		} # Fin del metodo insertar...

		public function get_s($id=FALSE)
		{
            $reply = 'result';
            if(is_numeric($id))
            {
                $this->db->where( 'id', $id );
                $reply = 'row';
            }

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
