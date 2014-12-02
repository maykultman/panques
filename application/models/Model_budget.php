 <?php
    require_once 'Modelo_crud.php';
    class Model_budget extends Modelo_crud
    {   
        public function __construct(){}       

         #                ...........DATOS DEL MODELO BUDGET.......
         # 'idcliente'  => $post['idcliente' ],  'idrepresentante' =>$post['idrepresentante'],
         # 'idempleado' => $post['idempleado'],  'fecha'           =>$post['fecha'          ],
         # 'detalles'   => $post['detalles'  ]
         
        public function create($post)
        {   
            $post['fechacreacion'] = date('Y-m-d');
            // var_dump($post); die();

            $this->db->insert('cotizaciones', $post);
            $dataCot = $this->get($this->db->insert_id(), TRUE);
            
            $query = $this->db->get_where('folios_cotizaciones', array('folio'=>$post['folio']));
            if($query->num_rows == 0)
            {
                $data = array( 'folio' => $post['folio'] );
                $this->db->insert('folios_cotizaciones', $data);
            }
                
            return $dataCot;
        }
        
        public function get ( $id = FALSE, $soloCot = FALSE) 
        {   
            if ($soloCot) {
                $reply = $this->where( $id );
                return $this->db->get( 'cotizaciones' )->$reply();
            } else {
                $reply = $this->where( $id );
                $this->db->order_by('fechacreacion', 'desc');  
                $data['cotizaciones'] = $this->db->get  ( 'cotizaciones' )->$reply();
                $this->db->order_by('id', 'desc');
                $data['folio'] = $this->db->get  ( 'folios_cotizaciones' )->row();
                return $data;
            }           
        }

        public function save (  $id,  $put ) 
        {   
            return $this->db->update('cotizaciones', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('cotizaciones', array('id' => $id)  ); 
        }

    }       
       