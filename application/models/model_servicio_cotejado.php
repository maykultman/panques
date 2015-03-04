<?php
 // require_once 'modelo_crud.php';

 	class Model_servicio_cotejado extends CI_Model
 	{

 		public function create($post)
 		{
 			$this->db->insert('servicios_cotejados',$post);
 			return $this->db->insert_id();
 		}
 		public function get($id=FALSE,$doc=FALSE)
 		{
 			$resp = 'result';
 			if($id){ $this->db->where('iddocumento',$id); $resp = 'row'; }
 			$this->db->where('documento',$doc);
 			return $this->db->get('servicios_cotejados')->$resp();
 		}
 		public function save()
 		{

 		}
 		public function destroy()
 		{

 		}
 	}