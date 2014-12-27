<?php

 class Model_payment extends CI_Model
 {
 	public function __construct(){}

 	public function create($post)
 	{
 		if ( is_array($post['pago']) ) {
 			for ($i=0; $i <count($post['pago']) ; $i++) {
	 			$this->db->insert('pagos', 
	 				array("idcontrato"=>$post['idcontrato'],
	 					  "fechapago"=>$post['fechapago'][$i],
	 					  "pago"=>$post['pago'][$i]
	 					)
	 			);
	 		}
 		} else {
 			$this->db->insert('pagos', 
 				array("idcontrato"=>$post['idcontrato'],
 					  "fechapago"=>$post['fechapago'],
 					  "pago"=>$post['pago']
 					)
 			);
 		}
 		

 		return true; //$this->get(false);
 	}

 	public function get ($id=FALSE)
 	{
 		$reply = 'result';
		if(is_numeric($id))
		{
			$this->db->where(  'id',$id  );
			$reply = 'row';
		}
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