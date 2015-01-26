<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include 'REST.php';
class Escritorio extends REST {
	
	public function __construct() 
	{		
        parent::__construct();
		$this->load->library('form_validation');
        $this->load->model('model_customer', 	     'customer');        
        $this->load->model('modelo_servicios',       'serv');
        $this->load->model('model_phone', 		     'telefono');
        $this->load->model('modelo_representante',   'representa');
        $this->load->model('modelo_proyecto',        'proyecto');
        $this->load->model('modelo_proyectoRoles',   'proyectoRoles');
        $this->load->model('model_serviciosInteres', 'servInteres');
        $this->load->model('model_servicioCliente',  'servCliente');
        $this->load->model('model_rol',              'Roles');
        $this->load->model('modelo_usuarios',        'usuario');
        $this->load->model('modelo_empleado',        'empleado');
        $this->load->model('Model_budget',           'budget');
        $this->load->model('Modelo_servicioCotizado','SC');
        $this->load->model('modelo_archivos',        'archivo');
    }  

	public function index()
	{ 	
		if($this->session->userdata('usuario'))
		{
			$this->modulo();
		}
		else
		{
			$data['token'] = $this->token();
			$this->load->view('login', $data);
		}
	}

	public function token()
	{
		$token = md5(uniqid(rand(), true));
		$this->session->set_userdata('token', $token);
		return $token;
	}

	public function login()
	{
		$this->load->model('modelo_perfil','perfil');
		if($this->input->post('token') && $this->input->post('token')== $this->session->userdata('token'))
		{
			$this->form_validation->set_rules('user', 'Nombre Usuario', 'required|trim|min_length[4]|max_length[50]|xss_clean');
			$this->form_validation->set_rules('pass', 'Password', 'required|trim|min_length[3]|max_length[50]|xss_clean');

			$this->form_validation->set_message('required', 'El %s es requerido');
			$this->form_validation->set_message('min_length', 'El %s debe tener al menos %s carácteres');
			$this->form_validation->set_message('max_length', 'El %s debe tener al menos %s carácteres');

			if($this->form_validation->run() === FALSE)
			{
				$this->index();
			}
			else
			{
				$user  = $this->input->post('user');
				$pass  = $this->input->post('pass');
				$query = $this->usuario->session($user, $pass);


				if($query == TRUE)
				{
					$perfil = $this->perfil->get($query->idperfil);
					$permisos = json_decode($query->idpermisos, true);
					//Establecemos el array de permisos.
					foreach ($permisos as $key=>$mod) {
						$data[$mod['nombre']] = $mod;
					}
					$data['is_logued_in'] = TRUE;
					$data['id_usuario'] = $query->id;
					$data['perfil'] = $perfil->nombre;
					$data['usuario'] = $query->usuario;
					$data['foto'] = $query->foto;
					
					$this->session->set_userdata($data);
					$this->index();
				}
			}
		}
		else
		{	
			redirect(base_url().'escritorio');	
		}		
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'escritorio');
	}

	public function modulo()
	{

		if($this->session->userdata('usuario'))
		{ 
			if(!$this->ruta())
			{
				redirect('escritorio/dashboard');
			}
			if($this->ruta()==='dashboard'||$this->ruta()==='login')
			{
				$this->dashboard();				
			}
			if($this->ruta()==='cliente_nuevo'||$this->ruta()==='consulta_clientes'||$this->ruta()==='consulta_prospectos'||$this->ruta()==='consulta_clientes_eliminados')
			{

				$this->clientes(); 
			}
			if($this->ruta()==='proyectos_consulta'||$this->ruta()==='proyectos_nuevo'||$this->ruta()==='proyectos_cronograma')
			{
				$this->proyectos();				
			}
			if($this->ruta()==='contratos_nuevo'||$this->ruta()==='contratos_historial'||$this->ruta()==='contratos_papelera')
			{
				$this->contratos();				
			}
			if($this->ruta()==='cotizaciones_nuevo'||$this->ruta()==='cotizaciones_consulta'||$this->ruta()==='cotizaciones_papelera')
			{
				$this->cotizaciones();				
			}
			if
			(   
				$this->ruta()==='catalogo_Servicios'||
				$this->ruta()==='catalogo_Perfiles' ||
				$this->ruta()==='catalogo_Permisos' ||
				$this->ruta()==='catalogo_Empleados'||
				$this->ruta()==='catalogo_Roles'    ||
				$this->ruta()==='catalogo_Puestos'
			)
			{
				$this->catalogos();
				
			}			
			if($this->ruta()==='usuarios_consulta'||$this->ruta()==='usuarios_nuevo')
			{
				$this->usuarios();				
			}
			if($this->ruta()==='formatoCotizacion'||$this->ruta()==='formatoContrato'||$this->ruta()==='vistaPreviaCotizacion')
			{
				$this->formato();
			}
			if($this->ruta()==='configuracion')
			{
				$this->configuracion();				
			}
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function pdf()
	{ 	 
		$this->load->view('pruebapdf');
	} 
	public function dashboard()
	{ 	

		$this->area_Estatica('dashboard_gustavo');
	} 
	
	public function activaCatalogo()
	{
		$variable = $this->session->userdata('Catálogos')['submodulos'];
		$catalogos=array();
		foreach ($variable as $key => $value) {
			if(isset($value['permisos']))
			{
				$catalogos[] = 'catalogo_'.$value['nombre'];
			}
		}			
		return $catalogos;
	}
	public function catalogos()
	{
		$this->area_Estatica('catalogos');
		$this->load->model('Modelo_permisos', 'permisos');
		$elcatalogo = $this->session->userdata('permisos')[5];
		$seccion = $this->activaCatalogo();
		
		
		if($this->ruta() == 'catalogo_Servicios'&&in_array('catalogo_Servicios', $seccion))
		{
			$data['servicios'] = $this->serv->get_s();
			$this->load->view($this->ruta(), $data);	
		}
		if($this->ruta() == 'catalogo_Perfiles'&&in_array('catalogo_Perfiles', $seccion))
		{
			$this->load->model('modelo_perfil','perfil');
			$data['perfiles'] = $this->perfil->get();
			$data['permisos'] = $this->permisos->get();
			$this->load->view($this->ruta(), $data);	
		}

		if($this->ruta() == 'catalogo_Permisos'&&in_array('catalogo_Permisos', $seccion))
		{
			$data['permisos'] = $this->permisos->get();
			$this->load->view($this->ruta(), $data);	
		}
		
		if($this->ruta() == 'catalogo_Empleados'&&in_array('catalogo_Empleados', $seccion))
		{
			$this->load->model('model_puesto', 'puesto');
			$data['empleados'] = $this->empleado->get();
			$data['telefonos'] = $this->telefono->get();
			$data['puestos']   = $this->puesto->get();
			$this->load->view($this->ruta(), $data);		
		}

		
		if($this->ruta() == 'catalogo_Roles'&&in_array('catalogo_Roles', $seccion))
		{
			$data['roles'] = $this->Roles->get();
			$this->load->view($this->ruta(), $data);	
		}
		if($this->ruta() == 'catalogo_Puestos'&&in_array('catalogo_Puestos', $seccion))
		{
			$this->load->model('model_puesto', 'puesto');
			$data['puestos']   = $this->puesto->get();
			$this->load->view($this->ruta(), $data);	
		}
	}

	public function clientes()
	{
		$this->area_Estatica('clientes');  # Carga la vista por default + la vista del modulo

		if($this->ruta() == 'cliente_nuevo')
		{
			$this->datosCliente($this->ruta());
		}
		# TipoCliente= 'cliente o prospecto' y como los dos cargan los mismos datos entonces lo asignamos a una función
		# Y simplemente lo llamamos para que nos cargue los datos y la vista.
		
		if($this->ruta() == 'consulta_clientes')   {	$this->datosCliente($this->ruta());	}
		if($this->ruta() == 'consulta_prospectos') {	$this->datosCliente($this->ruta());	}
		if($this->ruta() == 'consulta_clientes_eliminados') {	$this->datosCliente($this->ruta());	}
	
	} # Fin del metodo clientes...

	private function datosCliente($vista)
	{
		$this->load->model('model_contact','contacto');
		$data['clientes']		  = $this->customer->get($this->ruta());	# Lista de clientes
		$data['telefonos'] 		  = $this->telefono->get();					    # Lista de telefonos
		$data['servicios'] 		  = $this->serv->get_sNuevoCliente();              	# Lista de Servicios
		$data['serviciosInteres'] = $this->servInteres->get_servInteres();  		# Servicios de interes del cliente
		$data['serviciosCliente'] = $this->servCliente->get_servCliente();  		# servicios con los que cuenta el cliente
		$data['contactos']		  = $this->contacto->get();					# Lista Contactos
		$data['representantes']	  =$this->representa->get();					# List de representantes

		$this->load->view($vista, $data); # Cargamos la vista
	}

	public function proyectos()
	{
		$this->area_Estatica('proyectos');
		$this->load->model('modelo_servicioProyecto', 'serProy');
		$this->load->model('modelo_archivos', 'archivos');

		$data['clientes']    	= $this->customer->get_customerProyect();	# Lista de clientes
		$data['empleados'] 	 	= $this->empleado->get();  				# Proyectos
		$data['servicios'] 	 	= $this->serv->get_Servicios_Proyecto();   # Servicios Relacionados con los proyectos
		$data['roles']			= $this->Roles->get();  					# Lista de Roles.
		$data['proyectoRoles']  = $this->proyectoRoles->getProyRol();	# Roles del personal en algún proyecto
		$data['proyectos']		= $this->proyecto->get();					# Proyectos 
		$data['servicios_proy'] = $this->serProy->get();	# Servicios relacionados con el proyecto
		$data['archivos'] 		= $this->archivos->get('','proyectos');		# Archivos Relacionados con el proyecto
		$data['representantes'] = $this->representa->get();
		
		if($this->ruta() == 'proyectos_nuevo'){	$this->load->view($this->ruta(), $data);  }
		
		if($this->ruta() == 'proyectos_consulta')
		{			
			$this->load->view($this->ruta(), $data);			
		}

		if($this->ruta() == 'proyectos_cronograma')
		{	
			$this->load->view($this->ruta(), $data);			
		}
	}

	public function cotizaciones()
	{
		$this->area_Estatica('cotizaciones');
		$data['clientes']		  = $this->customer->get();	# Lista de clientes
		$data['servicios'] 		  = $this->serv->get_s();  	# Lista de Servicios
		$data['representantes']	  = $this->representa->get();					# List de representantes
		$data['empleados']	      = $this->empleado->get();
		$data['serviciosCotizados'] = $this->SC->get();
		if($this->ruta() == 'cotizaciones_nuevo')
		{
			$this->load->view($this->ruta(), $data);
		}
		if($this->ruta() == 'cotizaciones_consulta')
		{   
			$data['cotizaciones'] = $this->budget->get();
			$this->load->view($this->ruta(), $data);
		}
		if($this->ruta() == 'cotizaciones_papelera')
		{   
			$data['cotizaciones'] = $this->budget->get();
			$this->load->view($this->ruta(), $data);
		}
	}

	public function contratos()
	{
		$this->area_Estatica('contratos');
		$data['clientes']		= $this->customer->get_customerProyect($this->ruta());	# Lista de clientes
		$data['servicios'] 		= $this->serv->get_s();			              	# Lista de Servicios
		$data['representantes']	= $this->representa->get();
		$data['empleados']		= $this->empleado->get();		# List de representantes
		if($this->ruta() == 'contratos_nuevo')
		{
			// $this->load->view('formularioContrato');
			$this->load->view($this->ruta(), $data);
		}
		if($this->ruta() == 'contratos_historial' || $this->ruta() == 'contratos_papelera')
		{
			$this->load->model('Model_ServiceContract');
			$this->load->model('Model_contract');
			$this->load->model('Model_payment');

			$data['contratos'] = $this->Model_contract->get();
			$data['serviciosDeContrato'] = $this->Model_ServiceContract->get();
			$data['pagos'] = $this->Model_payment->get();

			
			$this->load->view($this->ruta(), $data);
			// $this->load->view('formularioContrato');
		}
	}

	public function formato ()
	{
		
		if($this->ruta()==='formatoCotizacion')
		{
			$this->load->model('modelo_servicioProyecto');
			$data['clientes']		  = $this->customer->get_customerProyect();	# Lista de clientes
			$data['servicios'] 		  = $this->serv->get_Servicios_Proyecto();  	# Lista de Servicios
			$data['representantes']	  = $this->representa->get();

			$this->load->view('formato_cotizacion', $data);
		}
		if($this->ruta()==='formatoContrato')
		{
			$this->load->model('modelo_servicioProyecto');
			$data['clientes']		  = $this->customer->get();	# Lista de clientes
			$data['servicios'] 		  = $this->serv->get_Servicios_Proyecto();  	# Lista de Servicios
			$data['representantes']	  = $this->representa->get();

			$this->load->view('formato_contrato', $data);
		}
		if($this->ruta()==='vistaPreviaCotizacion')
		{
			$this->load->model('modelo_servicioProyecto');
			$data['clientes']		  = $this->customer->get_customerProyect();	# Lista de clientes
			$data['servicios'] 		  = $this->serv->get_Servicios_Proyecto();  	# Lista de Servicios
			$data['representantes']	  = $this->representa->get();
			$data['cotizaciones'] 	  = $this->budget->get();
			$this->load->view('vistaPreviaCotizacion', $data);
		}
		
	}

	public function actividades(){
		$this->area_Estatica('actividades.html');
	}

	public function usuarios()
	{
		$this->area_Estatica('usuarios');

		$this->load->model('Modelo_permisos', 'permisos');
		
		$this->load->model('modelo_perfil','perfil');
		$data['permisos'] = $this->permisos->get();
		$data['empleados'] = $this->empleado->get();
		$data['perfiles'] = $this->perfil->get();
		if($this->ruta() == 'usuarios_nuevo')
		{
			
			$this->load->view($this->ruta(), $data);
		}
		if($this->ruta() == 'usuarios_consulta')
		{
						
			$data['usuarios'] = $this->usuario->get(false);
			$this->load->view($this->ruta(), $data);
		}
	}

	public function configuracion(){
		
		$this->area_Estatica($this->ruta());		
		// $this->load->view($this->ruta());
	}

	// public function cargarCatalogo($array)
	// {
	// 	foreach ($array as $key=>$valu) {			
	// 		if(isset($valu['permisos']))
	// 		{	
	// 			redirect('escritorio/catalogo_'.$valu['nombre']);
	// 			break;
	// 		}
	// 	}	
	// }

}//FIN DE LA CLASE...
