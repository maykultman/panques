<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
include 'REST.php';
class ServiciosDeContrato extends REST
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_ServiceContract', 'msc');
	}

	public function api()
	{
		$metodo  = $this->request();
		$this->$metodo();
	}

	private function create()
	{
		$query = $this->msc->create( $this->ipost() );
		$this->pre_response( $query, 'create' );
	}

	private function get()
	{
		$query = $this->msc->get( $this->id() );
		$this->pre_response( $query, 'get' );
	}

	private function update()
	{
		$query = $this->msc->save( $this->id(), $this->put() );
		$this->pre_response( $query, 'update' );
	}

	private function delete()
	{
		$query = $this->msc->destroy( $this->id() );
		$this->pre_response( $query, 'delete' );
	}
} # Fin de la API Servicios de Contrato
