<?php
	require_once 'Modelo_crud.php';
	class Modelo_usuarios extends Modelo_crud
	{
		
		function __construct()
		{                    }

		public function create($post)
		{	
			$this->db->insert('usuarios', $post);
            return $this->get($this->db->insert_id());
        }

		public function get($id)
		{  
			$reply = $this->where(  $id  );  # Ejecutamos el metodo where...      
            return $this->db->get  ( 'usuarios' )->$reply();  # Este metodo ejecuta get con y sin ID...
		}

		

		public function session($post)
		{   

			$this->db->select('id, permiso');
			$permisos = $this->db->get('permisos')->result_array();
			

			$where = array('usuario'=>$post['usuario'], 'contrasenia'=>$post['contrasenia']); 
			$this->db->select('idperfil'); 
			($post) ? $query = $this->db->get_where('usuarios', $where) : $query=FALSE;	 		
			$existe = $query->result(); 
			if($existe)
			{
				$this->db->select('*');
				$query = $this->db->get_where('perfiles', array('idperfil'=>$existe[0]->idperfil));
				$resp = $query->result_array();
				
				
				for ($i=0; $i <count($resp) ; $i++) { 
					for ($x=0; $x <count($permisos) ; $x++) { 
						
						if($resp[$i]['idpermiso']==$permisos[$x]['id'])
						{
							$privilegios[$permisos[$x]['permiso']] = $permisos[$x]['permiso'];
						}

					}
				}
				
           	} #var_dump($privilegios); die();
           	return $privilegios;			
		}

		public function update_user($id, $put)
		{
			$this->db->where('id', $id);
			# la variable $put devuelve los campos especificando que datos se actualizaron.
			$query = $this->db->update('usuarios', $put);
			# Regresa true o false dependiendo de la consulta.
			return $query;
		}
		public function delete_user($id)
		{
			$query = $this->db->delete('usuarios', array('id' => $id));
			return $query;
		}

	} # Fin de la clase Model_phones