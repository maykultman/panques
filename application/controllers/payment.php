<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
include 'REST.php';
class Payment extends REST
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_payment', 'payment');
	}

	public function api()
	{
		$metodo  = $this->request();
		$this->$metodo();
	}

	private function create()
	{
		$query = $this->payment->create( $this->ipost() );
		$this->pre_response( $query, 'create' );
	}

	private function get()
	{
		$query = $this->payment->get( $this->id() );
		$this->pre_response( $query, 'get' );
	}

	private function update()
	{
		$query = $this->payment->save( $this->id(), $this->put() );
		$this->pre_response( $query, 'update' );
	}

	private function delete()
	{
		$query = $this->payment->destroy( $this->id() );
		$this->pre_response( $query, 'delete' );
	}
} # Fin de la API Servicios de Contrato
