<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	* 
	*/
	class Pdfs extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('Modelo_pdf','cotizacion');
		}

		public function get_cotizacion($id=FALSE)
		{
			$query = $this->cotizacion->get_cotizacion($id);
			$this->load->view('pdf/cotizacion.php',$query);
		}

	}
