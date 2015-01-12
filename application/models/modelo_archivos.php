 <?php
		// require_once 'Modelo_crud.php';
		class Modelo_archivos extends CI_Model
		{   
			private $archivo; 
		
			public function create($post)
			{
					$this->createFolder($post['idpropietario']);
					if(!empty($_FILES))
					{
						if(array_key_exists('archivo', $_FILES)&&$_FILES['archivo']['name']!="")
						{
							$carpeta="./archivos/proyectos/".$post['idpropietario'];
							opendir($carpeta);
							$destino=$carpeta.'/'.$_FILES['archivo']['name'][0];  

							if(copy($_FILES['archivo']['tmp_name'][0], $destino))
							{
									$this->archivo = 
									array(  'idpropietario'=> $post['idpropietario'],
													'tabla'        => $post['tabla'],
													'nombre'       => $_FILES['archivo']['name'][0],
													'ruta'         => $destino,
													'fechacreacion'=> date('Y-m-d'));

								$this->db->insert('multimedia', $this->archivo);

								return $this->get($this->db->insert_id(), false, false);
							}
							return FALSE;                
						}
					}           
					 return false;
			} # Fin del metodo insert_mult()...

			public function get($id=FALSE, $idpropietario=FALSE, $tabla=FALSE)
			{
				$reply = 'result';
				if ( is_numeric($idpropietario) && $tabla ) {
					$this->db->where(  array('idpropietario' => $idpropietario, 'tabla' => $tabla)  );
					// $reply = 'row';
				} else if( is_numeric($id) ) {
						$this->db->where( 'id', $id  );
						$reply = 'row';
				}
				return $this->db->get  ( 'multimedia' )->$reply();
									
			} # Fin del metodo get_mult()...
			
			public function save (  $id,  $put ) 
			{   
				return $this->db->update( 'multimedia', $put, array('id' => $id)  );   
			}       
			
			public function destroy (  $id  ) 
			{ 
				$consulta = $this->get($id, false, false);
				
				if ( unlink($consulta->ruta) ) {
					return $this->db->delete( 'multimedia', array('id' => $id)  ); 
				} else {
					return false;
				}
			}

			private function createFolder($id)
			{
				if ( !is_dir("./archivos") ) {
					mkdir("./archivos", 0777);
				} else {
					if ( !is_dir("./archivos/proyectos") ) {
						mkdir("./archivos/proyectos", 0777);
					} else {
						if ( !is_dir("./archivos/proyectos/".$id) ) {
							mkdir("./archivos/proyectos/".$id, 0777);
						}
					}
				}
			}
		} # Fin de la clase...
?>