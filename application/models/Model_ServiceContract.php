<?php
 // require_once 'modelo_crud.php';

 class Model_ServiceContract extends CI_Model
 {
 	public function __construct(){}

 	public function create($post) 
        {  
          $this->db->insert('servicios_contrato', $post);
          return $this->get($this->db->insert_id());  
        }# Fin del metodo insert_mcontact()...

 	public function get ()
 	{
 		$this->db->select('*');
 		$this->db->from('servicios_x_contrato');
 		$this->db->join('servicios_contrato','servicios_contrato.idservicioxcontrato=servicios_x_contrato.id');
 		return $this->db->get()->result();
 		// return $this->db->get( 'servicios_contrato')->result();
 	}

 	public function save ( $id, $put )
 	{
 		return $this->db->update ( 'servicios_contrato', $put, array('id' => $id ) );
 	}

 	public function destroy ( $id )
 	{
 		return $this->db->delete( 'servicios_contrato', array('id' => $id) );
 	}
 }  