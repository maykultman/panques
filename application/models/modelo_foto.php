 <?php

    require_once 'Modelo_crud.php';
    class Modelo_foto extends Modelo_crud
    { 
      public function __construct( ) {}      

        public function create()
        {   
            if(!empty($_FILES))
          {
               if(array_key_exists('fotoCliente', $_FILES)&&$_FILES['fotoCliente']['name']!="")
               {
                   $carpeta="img/fotosClientes/";
                   opendir($carpeta);
                   $destino=$carpeta.$_FILES['fotoCliente']['name'];  
                   if(copy($_FILES['fotoCliente']['tmp_name'], $destino))
                   {
                       return $_FILES['fotoCliente']['name'];
                   }
                   return FALSE;  
               }
               elseif(array_key_exists('fotoUsuario', $_FILES)&&$_FILES['fotoUsuario']['name']!="")
               {
                   $carpeta="img/fotosUsuarios/";
                   opendir($carpeta);
                   $destino=$carpeta.$_FILES['fotoUsuario']['name'];  
                   if(copy($_FILES['fotoUsuario']['tmp_name'], $destino))
                   {
                       return $_FILES['fotoUsuario']['name'];
                   }
                   return FALSE;   
               }
        }
        
        public function get ( $id = FALSE ) 
        {  
          $reply = $this->where(  $id  );  # Ejecutamos el metodo where...      
          return $this->db->get  ( 'contactos' )->$reply();  # Este metodo ejecuta get con y sin ID...
        }

        public function save (  $id,  $put ) 
        {   
            return $this->db->update('contactos', $put, array('id' => $id)  );   
        }       
        
        public function destroy (  $id  ) 
        {   
            return $this->db->delete('contactos', array('id' => $id)  ); 
        }
    }    