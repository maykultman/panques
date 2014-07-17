<?php
	// session_start();
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

		public function session($user, $pass)
		{
			$this->db->where(array('usuario' =>$user ,'contrasenia'=>$pass ));
			$query = $this->db->get('usuarios');
            if($query->num_rows == 1 )
            {
            	return $query->row();
            }
            else
            {
                $this->session->set_flashdata('mensaje', 'El usuario o contraseña es incorrecto');
                redirect(base_url());
            }
		}

		public function save (  $id,  $put ) 
        {   
        	return $this->db->update('usuarios', $put, array('id' => $id)  );   
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