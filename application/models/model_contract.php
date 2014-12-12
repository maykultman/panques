<?php
	// require_once 'modelo_crud.php';

	#  DATOS DEL MODELO CONTRATO....
	#  'fecha'       => $post['fecha'       ],  'fecha_inicio' =>$post['fecha_inicio'],
	#  'fecha_final' => $post['fecha_final' ],  'honorario'    =>$post['honorario'   ],

	class Model_contract extends CI_Model
	{ 
		public function __construct(){}
		
		// public function create($post) 
		// {   
		//   $this->db->insert('contratos', $post);
		//   return $this->get($this->db->insert_id());  
		// }

		public function create($post) 
		{ 
			$post['fechacreacion'] = date('Y-m-d');
			$this->db->insert('contratos', $post);
			$dataCont = $this->get($this->db->insert_id(), TRUE);
			$data = array( 'folio' => $post['folio'] );
				$this->db->insert('folios_contratos', $data);
			return $dataCont;
		}

		public function get ( $id = FALSE, $soloCont = FALSE ) 
		{	
			if ($soloCont) {
                $this->db->where( 'id', $id );
                $reply = 'row';
                return $this->db->get( 'contratos' )->$reply();
            } else {
                $this->db->order_by('fechacreacion', 'desc');  
                $data['contratos'] = $this->db->get( 'contratos' )->result();
                $this->db->order_by('id', 'desc');
                $data['folio'] = $this->db->get( 'folios_contratos' )->row();
                return $data;
            }
		}

		public function save (  $id,  $put ) 
		{ 
			return $this->db->update('contratos', $put, array('id' => $id)  ); 
		}   
		
		public function destroy (  $id  ) 
		{ 
			
			return $this->db->delete('contratos', array('id' => $id)  ); 
		}
	}
