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
            $args = array(
                          'idcliente'       => $post[  'idcliente'       ],
                          'idrepresentante' => $post[  'idrepresentante' ],
                          'idempleado'      => $post[  'idempleado'      ],
                          'titulo'          => $post[  'titulo'          ],
                          'fecha'           => $post[  'fecha'           ],
                          'detalles'        => $post[  'detalles'        ],
                          'caracteristicas' => $post[  'caracteristicas' ] 

                        );
            $this->db->insert('cotizaciones', $args);
            return $this->get($this->db->insert_id());     
        }
        
        public function get ( $id = FALSE ) 
        {  
           $reply = $this->where( $id );  # Ejecutamos el metodo where...   
           $this->db->order_by('fecha', 'desc');    
           return $this->db->get  ( 'cotizaciones' )->$reply();  # Este metodo ejecuta get con y sin ID...
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
       