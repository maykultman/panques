<?php

 class Model_ServiceContract extends CI_Model
 {
 	public function __construct(){}

 	public function create($post) 
    {  
    	// Relación servicios x contrato
    	$rel_sxc = array(
    			'idcontrato' => $post['idcontrato'],
    			'idservicio' => $post['idservicio']
    		);

    	$this->db->insert('servicios_x_contrato', $rel_sxc);
    	$idrel_sxc = $this->db->insert_id();

    	// Relación servicios contratados
    	$rel_sc = array(
    			'seccion'=> $post['seccion'],
    			'descripcion' => $post['descripcion'],
    			'horas' => $post['horas'],
    			'idservicioxcontrato' =>$idrel_sxc
    		);

        $this->db->insert('secciones_contrato', $rel_sc);
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