<?php
    class Model_budget extends CI_Model
    {   
        public function __construct(){}       

         #                ...........DATOS DEL MODELO BUDGET.......
         # 'idcliente'  => $post['idcliente' ],  'idrepresentante' =>$post['idrepresentante'],
         # 'idempleado' => $post['idempleado'],  'fecha'           =>$post['fecha'          ],
         # 'detalles'   => $post['detalles'  ]
         
        public function create($post)
        {   
            $post['fechacreacion'] = date('Y-m-d');          
            
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
                $this->db->where( 'id', $id );
                $reply = 'row';
                return $this->db->get( 'cotizaciones' )->$reply();
            } else {
                $this->db->order_by('fechacreacion', 'desc');  
                $data['cotizaciones'] = $this->db->get( 'cotizaciones' )->result();
                $this->db->order_by('id', 'desc');
                $data['folio'] = $this->db->get( 'folios_cotizaciones' )->row();
                return $data;
            }
            // if($soloCot)
            // {
            //     $this->db->where( 'id', $id );
            //     $reply = 'row';
            //     return $this->db->get( 'cotizaciones' )->$reply();
            // }
            // else{
            //     $this->db->select('*');
            //     $this->db->order_by('fechacreacion','desc');
            //     $this->db->from('cotizaciones');
            //     $this->db->from('secciones_cotizacion');

            //     $join = 'servicios_cotizados.id = secciones_cotizacion.idserviciocotizado AND ';
            //     $join .= 'servicios_cotizados.idcotizacion = cotizaciones.id';
            //      // Traemos todas las cotizaciones
            //     $this->db->join('servicios_cotizados', $join);
            //     $data['cotizaciones'] =  $this->db->get()->result();
            //     // Traemos los folios
            //     $this->db->order_by('id', 'desc');
            //     $data['folio'] = $this->db->get( 'folios_cotizaciones' )->row();
            //     foreach ($data['cotizaciones'] as $key => $value) {
            //         foreach ($value as $vk => $vv) {
            //             echo $vk.'=>'.$vv.'<br>';
            //         }
            //     }
            //     // var_dump($data['cotizaciones']); 
            //     die();
            //     return $data;
            // }
            
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
       
