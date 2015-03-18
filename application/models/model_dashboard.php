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

						$evento[$cont1]['cliente'] = $resp['cliente'];
						$evento[$cont1]['pago'] = $value->pago;
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

		public function proyectos()
		{
			$this->db->select('*');
			$this->db->where('entregado', 0);
			$this->db->from('proyectos');
			$this->db->join('clientes', 'clientes.id=proyectos.idcliente');			
			return $this->db->get()->result();
		}

		public function servicios()
		{
			// $sum = $this->db->query('SELECT idservicio`, `servicios.nombre` SUM(`servicios_cotejados.idservicio`) GROUP BY `servicios_cotejados.idservicio` ORDER BY SUM(`servicios_cotejados.idservicio`) DESC FROM servicios_cotejados, servicios WHERE `servicios_cotejados.idservicio` = `servicios.id`')->result_array();
			// $sum = $this->db->query('SELECT sc.idservicio, 
			// 						SUM(sc.idservicio) as suma, s.nombre as servicio
			// 						FROM servicios_cotejados as sc
			// 						inner join servicios as s on s.id = sc.idservicio
			// 						GROUP BY idservicio 
			// 						ORDER BY SUM(idservicio) DESC')->result_array();
        		

			$this->db->select('sc.idservicio, s.nombre, s.id');
			$this->db->group_by('sc.idservicio');
			$this->db->order_by('sc.idservicio','DESC');
			$this->db->select_sum('sc.idservicio');
			$this->db->from('servicios_cotejados as sc');
			$this->db->join('servicios as s','s.id=sc.idservicio');
			return $this->db->get()->result_array();
			// var_dump($sum); die();

        	// $table = '<table border="1"><tr><th>Nombre</th><th>idservicio</th><th>Repetidos</th><tr>';
        	
        	// foreach ($sum as $key => $value) {
        		
        	// 	// $table .= '<tr><td>'.$value['idservicio'].'</td><td>'.($value['SUM(idservicio)'] / $value['idservicio']).'</td></tr>';
        	// 	$table .= '<tr><td>'.$value['nombre'].'</td><td>'.$value['id'].'</td><td>'.($value['idservicio'] / $value['id']).'</td></tr>';
        	// }
        	// $table.= '</table>';
        	// die($table);
			// $this->db->select('id,nombre');
			// $query = $this->db->get('servicios')->result();

			// foreach ($query as $key => $value) 
			// {
			// 	foreach ($sum as $sumkey => $sumval) 
			// 	{
			// 		if($value->id==$sumval['idservicio'])
			// 		{

			// 			$query[$key]->cant = intval($sumval["SUM(idservicio)"])/intval($value->id);
			// 		}
			// 		else{
			// 			$query[$key]->cant = 0;
			// 		}
			// 	}
				
			// }
			// return FALSE; //$query;			
		}


		// Consulta de ingresos por cliente.
		public function clientes($fecha=NULL)
		{ 
			$anio = (!$fecha) ? date('Y') : $fecha;
			$this->db->select('fechapago,pago,nombreComercial');
			$this->db->from('clientes');
			$this->db->group_by('idcliente');
			$this->db->group_by('fechapago');			
			$this->db->select_sum('pago');
			$this->db->from('pagos');
			$this->db->like('fechapago', $anio,'after');
			$this->db->where('pagos.status',1);
			$this->db->join('contratos','contratos.idcliente=clientes.id and contratos.id=pagos.idcontrato');
			// $this->db->get()->result();
			// echo $this->db->last_query();
			
			// $query = $this->db->get()->result();
			// foreach ($query as $key => $value) {

			// 	echo $value->fechapago.'---'.$value->pago.'---'.$value->nombreComercial.'<br>';
			// }
			// die();
			// // var_dump($query); die();
			return $this->db->get()->result();
	
		}

		public function graficas()
		{
			$this->db->select_max('idcliente');
			$this->db->order_by('idcliente');
			$query = $this->db->get('cliente_atributo');
			var_dump($query->result()); die();
		}



	}

?>