<?php
    class Model_rol extends CI_Model
    {
        public function __construct(){}

        #                           DATOS DEL MODELO ROL
        #                $post ['nombre']........$post ['descripcion']
        
        public function create($args)
        {   
            $this->db->insert('roles', $args);
            return $this->get($this->db->insert_id());

            // Guarda varios roles
            /*if(!$args['nombre'][0])
            {
                $this->db->insert('roles', $args);
                return $this->get( $this->db->insert_id() );
            }

            for($i = 0; $i<count($args['nombre']); $i++)
            {
                $this->db->insert('roles', $args );  
                $id[$i] = $this->db->insert_id();

            }
            return $id;*/
        }
        
        public function get ( $id = FALSE ) 
        {
            $reply = 'result';
            if(is_numeric($id))
            {
                $this->db->where( 'id', $id  );
                $reply = 'row';
            }
           return $this->db->get  ( 'roles' )->$reply();  # Este metodo ejecuta get con y sin ID...
        }

        public function save (  $id,  $put ) 
        {   #var_dump($put); die();
            return $this->db->update('roles', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('roles', array('id' => $id)  ); 
        }

    } # Fin de la clase Modelo_proyecto