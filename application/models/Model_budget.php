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
            // var_dump($post); die();
            $this->db->insert('cotizaciones', $post);
            $dataCot = $this->get($this->db->insert_id(), TRUE);
            $data = array(
                    'folio' => $post['folio'],
                    'cotizacion' => true,
                    'contrato' => false
                );
            $this->db->insert('folios', $data);
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
                $datos['cotizaciones'] = $this->db->get  ( 'cotizaciones' )->$reply();
                $this->db->order_by('id', 'desc');
                $datos['folio'] = $this->db->get  ( 'folios' )->row();
                return $datos;
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
       