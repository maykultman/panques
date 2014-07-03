<?php
 require_once 'Modelo_crud.php';

 class Model_payment extends Modelo_crud
 {
 	public function __construct(){}

 	public function create($post)
 	{
 		
 		for ($i=0; $i <count($post['pago']) ; $i++) { 
 			
 			$this->db->insert('pagos', 
 				array("idcontrato"=>$post['idcontrato'],
 					  "fechapago"=>$post['fechapago'][$i],
 					  "pago"=>$post['pago'][$i])
 				);
 		}
 		return true;
 		// return $this->db->insert_batch('pagos', $post);
		// return $this->get( $this->db->insert_id() );
 	}

 	public function get ( $id = FALSE )
 	{
 		$reply = $this->where( $id );
 		return $this->db->get( 'pagos')->$reply();
 	}

 	public function save ( $id, $put )
 	{
 		return $this->db->update ( 'pagos', $put, array('id' => $id ) );
 	}

 	public function destroy ( $id )
 	{
 		return $this->db->delete( 'pagos', array('id' => $id) );
 	}
 }  