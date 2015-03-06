<?php
	class Modelo_pdf extends CI_Model
	{
		public function __construct()
		{	
		 	parent::__construct();			
		}

        public function get_cotizacion($id)
      	{
      		$this->db->where('id',$id);
	        $data['cotizacion'] = $this->db->get('cotizaciones')->row();	        

	        $this->db->select('secciones,nombre');
	        $this->db->from('servicios');
	        $this->db->join('servicios_cotejados','servicios_cotejados.idservicio = servicios.id');
	        $this->db->where('iddocumento',$data['cotizacion']->id);
	        $data['servicios'] = $this->db->get()->result();
	        // $data['servicios'] = $this->db->get('servicios_cotejados')->result();
	        return $data;
      	}
		
	} # Fin de la clase Model_crud