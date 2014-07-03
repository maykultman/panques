<?php
	require_once 'Modelo_crud.php';
	class Modelo_perfil extends Modelo_crud
	{
		
		function __construct(){}

		public function create($post) 
        {   
	        $this->db->insert('perfiles', $post);
	        return $this->get($this->db->insert_id());  
      	}

      # Este metodo línea hace dos cosas devuelve todos los registros o devuelve el especificado con el ID
      	public function get ( $id = FALSE ) 
        {  
	        $reply = $this->where($id);
	        return $this->db->get  ( 'perfiles' )->$reply();
      	}

      	public function save (  $id,  $put ) 
        { 
        	return $this->db->update('perfiles', $put, array('id' => $id)  ); 
      	}   
      
      	public function destroy (  $id  ) 
        { 
        	return $this->db->delete('perfiles', array('id' => $id)  ); 
      	}
    } # Fin de la clase Model_perfil

		// public function get_perfil($id)
		// {
		// 	$permi=array();   
		// 	$i=0;

	 //        $this->db->select('perfil.id, perfil.perfil, perfil_permisos.idpermiso');
	 //        $this->db->from('perfil');
	 //        $this->db->join('perfil_permisos', 'perfil_permisos.idperfil = perfil.id');
	 //        $perfil = $this->db->get();  
	 //        ################################################
	 //        $this->db->select('permisos.id, permisos.permiso');
	 //        $this->db->from('permisos'); 
	 //        $this->db->join('perfil_permisos', 'perfil_permisos.idpermiso = permisos.id');
	 //        $perper = $this->db->get(); 			
	 //        ################################################
		// 	foreach ($perfil->result() as $key) 
		// 	{
		// 		if($key->id===$id)
		// 		{	
		// 			foreach ($perper->result() as $key2 => $value2) 
		// 			{
		// 				if($key->idpermiso==$value2->id)
		// 				{	
		// 					$permi['perfil'] = $key->perfil;
		// 					$permi['permiso'][$i] =$value2->permiso; $i++;
		// 				} # Fin de if key->idpermiso 	
		// 			} # Fin del foreach $query2
		// 		} # Fin del if key->id
		// 	}# Fin del foreach $query
				
		// 	return $permi;		
		// } # Fin del metodo get_perfil() 

	