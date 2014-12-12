<?php
	class Model_customer extends CI_Model
	{
		
		public function __construct(){}

		function insert_customer($post)
		{	
			$post['fechacreacion'] = date('Y-m-d');
			
			$x=0; # Este es un contador para mi array de inserción...	
			# Se almacena campos obligatorios en la tabla de clientes... 						
			$cliente = $this->db->insert('clientes', array('nombreComercial'=>$post['nombreComercial'], 
														 'tipoCliente'=>$post['tipoCliente'],
														 'fechacreacion'=>$post['fechacreacion'],
														 'visibilidad'=>$post['visibilidad']));
			# devolvemos su id_cliente para registrar sus atributos...
			$idcliente = $this->db->insert_id();

			# Traemos la tabla de atributos
			$this->db->select('*');			$atr = $this->db->get('atributo_cliente');

			# Recorremos la consulta de los atributos para conocer el id de cada atributo			
			foreach ($atr->result() as $key => $value) {

				# Recorremos el post...
				foreach ($post as $key2 => $value2) {
					# Verificamos que campos post tienen valor
					if($value2)
					{	
						# Comparamos si la clave del arreglo $post es igual al valor del objeto $value->atributo...
						if($key2==$value->atributo){
							# Si son identicos entonces ya conocemos con certeza a que clave pertenece cada valor...
							# Rellenamos el array con todos los datos no nulos del post...
							$data[$x] = array('idcliente'=>$idcliente, 'idatributo'=>$value->id, 'dato'=>$value2);	
							#incrementamos nuestro contador para acumular el siguiente atributo.
							$x++;							
						} # Fin del if($key2)
					}# Fin del if($value2)
				} # Fin del foreach $post...
			}# Fin del foreach $atributos...

			# Ahora una vez armado el array con los atributos del cliente hacemos una inserción en la bd...
			if(!empty($data)){	$query = $this->db->insert_batch('cliente_atributo', $data); }
	
			return $this->get($idcliente);
		}//	----------FUNCTION INSERT_CUSTOMER--------------

		# Datos del cliente para buscarlo en el modulo del proyecto...
		public function get_customerProyect()
		{
			$this->db->select('id, nombreComercial');
			$this->db->where(array('visibilidad'=>1, 'tipoCliente'=>'cliente' ));
			return $this->db->get('clientes')->result();
		}
		
		public function get($id=NULL)
		{
			#$cont RELLENA EL ARREGLO DATOS, $contrep RELLENA EL ARRELGO DE REPRESENTANTES y $conCont CONTACTOS###
			$cont=0;	$contCont=0;
			#############################TRAEMOS A TODOS LOS CLIENTES#######################################
			$this->db->select('*');
			if(is_numeric($id)) { $this->db->where('id',$id); }
			
			$this->db->order_by('fechacreacion', 'desc'); # Los Ordenamos por fecha de Creación...
			$cliente = $this->db->get('clientes');

			#################################################ATRIBUTOS DEL CLIENTE##################################
			$this->db->select('cliente_atributo.idcliente, atributo_cliente.atributo, cliente_atributo.dato');
			$this->db->from('cliente_atributo'); # de la tabla cliente_atributo
			$this->db->join('atributo_cliente', 'atributo_cliente.id = cliente_atributo.idatributo');
			$atributos = $this->db->get();			
			########Enviamos al metodo joinDinamico los campos y el nombre de las tablas que queremos consultar#####	

			# Hay Clientes????
			if($cliente->result())
			{
			    foreach ($cliente->result() as $key) 
			    {	
			 		foreach ($atributos->result() as $key2=>$value)
			 		{ 
			 			# EL id del cliente es igual al idCliente de la tabla atributos????
			 			if($key->id==$value->idcliente)
				 		{
				 			$datos[$cont]['id'] 			 = $key->id;
				 			$datos[$cont]['nombreComercial'] = $key->nombreComercial;
				 			$datos[$cont]['tipoCliente'] 	 = $key->tipoCliente;
				 			$datos[$cont]['fechacreacion']	 = $key->fechacreacion;
				 			$datos[$cont]['visibilidad'] 	 = $key->visibilidad;
				 			$datos[$cont][$value->atributo]  = $value->dato;
											 					 			
				 		} # Fin del If
				 		else
				 		{
				 			$datos[$cont]['id'] 			 = $key->id;
				 			$datos[$cont]['nombreComercial'] = $key->nombreComercial;
				 			$datos[$cont]['tipoCliente'] 	 = $key->tipoCliente;
				 			$datos[$cont]['fechacreacion']	 = $key->fechacreacion;
				 			$datos[$cont]['visibilidad'] 	 = $key->visibilidad;
				 		}

				 	} # Fin del foreach() $atributos

			 		$cont++;
			    }# Fin del foreach() $clientes
			    
				return (is_numeric($id)) ? $datos[0] : $datos;
			}
			else{return false;}
		}

		public function patch_customer($id, $put)
		{
			$query = false;
			# Consulta las cabeceras de la tabla clientes
			$columna = $this->db->field_data('clientes');
			# La query que contiene este foreach afecta solo a la tabla clientes....				             
			foreach ($columna as $key)
			{ 
				if(array_key_exists($key->name, $put)) # Existe la cabecera en el array $put?
				{
						     $this->db->where('id', $id); 
  		       		$query = $this->db->update('clientes', array($key->name => $put[$key->name]));  		        		
				}
			} # Foreach
			# El query sigue siendo falso...
			if(!$query)
			{
				$this->db->select('id'); 
				# extraemos la clave del $put y le decimos que nos devuelva su id...
				$query = $this->db->get_where('atributo_cliente', array('atributo'=>key($put)));
				$dato = $query->result(); 

				# Armamos el arreglo para almacenar los Datos...
				$datos = array('idatributo' => $dato[0]->id, 'dato' => $put[key($put)]);

				# Armamos un Where AND para hacer una consulta... 
				$where = array('idcliente'=>$id, 'idatributo'=>$dato[0]->id);

				$query = $this->db->get_where('cliente_atributo', $where);				

				$resultado = $query->result();
				if(empty($resultado)) # El resultado de la query esta vacía?...
				{   # Si la query esta vacía, entonces ese atributo para ese cliente no existe y lo creamos...
					$query = $this->db->insert('cliente_atributo',  array('idcliente'=>$id,'idatributo' => $dato[0]->id, 'dato' => $put[key($put)]));						
			    }
			    else
			    {	# Si existe pues simplemente actualizamos...
			    	$this->db->where($where);
					$query = $this->db->update('cliente_atributo', $datos);
			    }
			}
			
			return $query;
		} # Fin de pacth customer

		public function delete_customer($id)
		{
			return $this->db->delete('clientes', array('id' => $id));  		   	
		}
	}//Fin de la clase Model_Customer		

