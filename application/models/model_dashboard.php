<?php 
	
	/**
	* consultas para el dashboard...
	*/
	class Model_dashboard extends CI_Model
	{
		
		function __construct()
		{
			# code...
		}

		public function get_budgets()
		{
			$this->db->select('*');
			$this->db->from('cotizaciones');
			$this->db->join('empleados','empleados.id=cotizaciones.idempleado');			
			$budgets = $this->db->get()->result();
			$customer = $this->db->get('clientes')->result();

			foreach ($budgets as $y => $bv) 
			{
				foreach ($customer as $e=> $ev) 
				{
					if($bv->idcliente == $ev->id)
					{
						$bv->idcliente = $ev->nombreComercial;						
					}
				}
			}			
			return $budgets;
		}

		public function get_payments()
		{
			$this->db->where('status',0);
			$payment = $this->db->get('pagos')->result();
			if($payment)
			{
				$cont1=0; $cont2=0;
				foreach ($payment as $key => $value) 
				{	
					$resp = $this->nomComercial($value->idcontrato);
					if($resp['plan'] == 'iguala')
					{
						$iguala[$cont1]['cliente'] = $resp['cliente'];
						$iguala[$cont1]['pago'] = $value->pago;
						$iguala[$cont1]['fechapago'] = $value->fechapago;	
						$cont1++;
					}
					else{

						$evento[$cont1]['cliente'] = $resp->cliente;
						$evento[$cont1]['pagos'] = $value->pagos;
						$evento[$cont1]['fechapago'] = $value->fechapago;	
						$cont2++;
					}
					
				}
				$cont1=0; $cont2=0;	
			}
			
			$data['iguala'] = (!empty($iguala))? $iguala:'';
			$data['evento'] = (!empty($evento))? $evento:'';
			return $data;			
		}

		public function nomComercial($idcontrato)
		{	
			//con el idcontrato obtenemos el contrato con el tipo de plan
			$this->db->where('id',$idcontrato);			
			$contratos = $this->db->get_where('contratos')->row();
			//una vez teniendo el contrato, obtenemos el idcliente
			$query = $this->db->get_where('clientes', array('id'=>$contratos->idcliente))->row();						
			//Devolvemos el nombre comercial
			$resp['cliente'] = $query->nombreComercial;
			$resp['plan'] = $contratos->plan;
			return $resp;
		}
	}

?>