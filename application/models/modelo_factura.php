 <?php
    /**
    * Operaciones en la base de datos con los contactos
    */
    class Modelo_factura extends CI_Model
    {          
        function create()
        {
          // var_dump($_FILES); die();
            if(!empty($_FILES))
            {
               if(array_key_exists('factura', $_FILES)&&$_FILES['factura']['name']!="")
               {
                   $carpeta="facturas/";
                   opendir($carpeta);
                   $destino=$carpeta.$_FILES['factura']['name'];  
                   if(copy($_FILES['factura']['tmp_name'], $destino))
                   {
                       
                      $data['archivo'] = $_FILES['factura']['name'];
                      $xml = file_get_contents("facturas/".$_FILES['factura']['name']);
                      $xml = simplexml_load_string($xml);
                      $data['contenido']= json_encode($xml);
                      // $djson = json_decode($json, true);
                      // echo $djson['message'];
                      return $data;
                      // exit;
                   }
                } 
             
            }
           
           return false;
        } # Fin del metodo insert_mcontact()...

        public function get ( $id = FALSE ) 
        {  
           $reply = $this->where( $id );  # Ejecutamos el metodo where...      
           return $this->db->get  ( 'facturas' )->$reply();  # Este metodo ejecuta get con y sin ID...
        }

        public function save (  $id,  $put ) 
        {   
            return $this->db->update('facturas', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('facturas', array('id' => $id)  ); 
        }

    } # Fin de la clase...