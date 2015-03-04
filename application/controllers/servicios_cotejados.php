<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	include 'REST.php';
	class Servicios_cotejados extends REST
	{
		public function __construct() {
	        parent::__construct();
	        $this->load->model('Model_servicio_cotejado', 'servicio_cotejado');             
	    }

	    public function api() 
    	{
        	$metodo = $this->request();
        	$this->$metodo();
    	}

	    public function create()
 		{
 			$post = $this->ipost();
 			$query = $this->servicio_cotejado->create($post);
 			$this->pre_response($query, 'create');
 		}

 		public function documento()
 		{
 			return ( $this->uri->segment(1) == 'api_servicioCotizado') ? 'cotizacion' : 'contrato';
 		}

 		public function get()
 		{
 			$doc = $this->documento();
 			$query = $this->servicio_cotejado->get($this->id(), $doc);                        
    		$this->pre_response($query, 'get');
 		}

 		private function update()
 		{
 			$doc = $this->documento();
	    	$query = $this->servicio->update_servCliente($this->id(), $this->put(), $doc);
	        $this->pre_response($query, 'update');         
	    }

	    private function delete()
	    {
	    	$doc = $this->documento();
	    	$query = $this->servicio->delete_servCliente($this->id(), $doc);    	
	        $this->pre_response($query, 'delete'); 
	    }

	}