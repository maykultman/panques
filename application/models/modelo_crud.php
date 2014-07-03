<?php
	class Modelo_crud extends CI_Model
	{
		public function __construct()
		{	
		 	parent::__construct();			
		}

        public function where($id)
      	{
	        $reply = 'result';
	        if ( $id ) 
	        { 
	          $reply = 'row';   # row devuelve una sola fila.
	          $this->db->where( 'id', $id  );  # Ejecutamos el metodo where...      
	        }
	        return $reply;
      	}

		# Destruimos el $this despues de usarlo en esta clase
		function __destruct(){	unset($this);  }
		
	} # Fin de la clase Model_crud

		
