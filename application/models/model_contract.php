<?php
		require_once 'Modelo_crud.php';

		#  DATOS DEL MODELO CONTRATO....
		#  'fecha'       => $post['fecha'       ],  'fecha_inicio' =>$post['fecha_inicio'],
		#  'fecha_final' => $post['fecha_final' ],  'honorario'    =>$post['honorario'   ],

	class Model_contract extends Modelo_crud
	{ 
			public function __construct(){}
			
			// public function create($post) 
			// {   
			//   $this->db->insert('contratos', $post);
			//   return $this->get($this->db->insert_id());  
			// }

			public function create($post) 
			{
				$this->db->insert('contratos', $post);
				$dataCont = $this->get($this->db->insert_id(), TRUE);
				$data = array( 'folio' => $post['folio'] );
            	$this->db->insert('folios_contratos', $data);
				return $dataCont;
			}

			public function get ( $id = FALSE, $soloCont = FALSE ) 
			{  
				if ($soloCont) {
					$reply = $this->where( $id );
					return $this->db->get( 'contratos' )->$reply();
				} else {
					$reply = $this->where($id);
					$this->db->order_by('fechacreacion', 'desc'); 
					$data['contratos'] = $this->db->get  ( 'contratos' )->$reply();
					$this->db->order_by('id', 'desc');
               		$data['folio'] = $this->db->get  ( 'folios_contratos' )->row();
					return $data;
				}
				
					
			}

			// public function folios () {
			// 	$this->db->select('*');
			// 	// $this->db->order_by('id', 'desc'); 
			// 	return $this->db->get  ( 'folios_contratos' )->row();
			// }

			public function save (  $id,  $put ) 
			{ 
				return $this->db->update('contratos', $put, array('id' => $id)  ); 
			}   
			
			public function destroy (  $id  ) 
			{ 
				
				return $this->db->delete('contratos', array('id' => $id)  ); 
			}
	}    
