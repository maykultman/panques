<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include 'REST.php';
require_once '/google-api-php-client-master/autoload.php';
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


        $client_id = '266013765630-no4316pgdf96q34c98eb0bit2or9ff0s.apps.googleusercontent.com';
        $client_secret = '9eMzpa4ags-xnvzPkEGEqrFs';
        $redirect_uri = 'http://crmqualium.com/escritorio/actividades';

        $this->client = new Google_Client();
        $this->client->setClientId($client_id);
        $this->client->setClientSecret($client_secret);
        $this->client->setRedirectUri($redirect_uri);
        $this->client->addScope("https://www.googleapis.com/auth/calendar");
        $this->client->setAccessType('offline');
        $this->client->setApprovalPrompt('force');

        $this->service = new Google_Service_Calendar($this->client);
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
				$user  = $this->input->post('user', true);
				$pass  = $this->input->post('pass', true);
				$pass = md5($pass);
				$query = $this->usuario->session($user, $pass);


				if($query == TRUE)
				{
					$perfil = $this->perfil->get($query->idperfil);
					$permisos = json_decode($query->idpermisos, true);
					//Establecemos el array de permisos.
					foreach ($permisos as $key=>$mod) {
						$data[$mod['nombre']] = $mod['submodulos'];
					}
					$data['is_logued_in'] = TRUE;
					$data['id_empleado'] = $query->idempleado;
					$data['perfil'] = $perfil->nombre;
					$data['usuario'] = $query->usuario;
					// $data['contrasena'] = $query->contrasenia;
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
			$ruta='';
			if(strpos($this->ruta(),'_'))
			{
				$ruta = explode('_', $this->ruta())[0];
			}
			if(!$this->ruta())
			{
				redirect('escritorio/dashboard');
			}
			if($this->ruta()==='dashboard'||$this->ruta()==='login')
			{
				$this->dashboard();				
			}
					
			if($this->ruta()==='cliente_nuevo'||strpos($this->ruta(), 'cliente')||strpos($this->ruta(), 'prospectos'))
			{

				$this->clientes(); 
			}
			if($ruta==='proyectos'){	$this->proyectos();	}

			if($ruta==='contratos'){	$this->contratos();	}

			if($ruta==='cotizaciones'){	$this->cotizaciones();	}

			if($ruta == 'catalogo'){	$this->catalogos();	}

			if($ruta==='usuarios'){	$this->usuarios();	}

			if($this->ruta()==='formatoCotizacion'||$this->ruta()==='formatoContrato'||$this->ruta()==='vistaPreviaCotizacion')
			{
				$this->formato();
			}
			if($this->ruta()==='configuracion'){	$this->configuracion();	}

			if($this->ruta()==='actividades')
			{
				$this->actividades();
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
		$this->load->model('Model_dashboard', 'dash');

		$data['servicios'] = $this->dash->servicios();
		$data['cotizaciones'] = $this->dash->get_budgets();
		$pagos = $this->dash->get_payments();	
		$data['pagosxI'] = $pagos['iguala'];
		$data['pagosxE'] = $pagos['evento'];	
		$data['proyectos'] = $this->dash->proyectos();
		// $data['servgraficas']= $this->dash->graficas();
		// die();
		$data['clientes'] = $this->dash->clientes();
		$this->area_Estatica('dashboard_gustavo', $data);
	} 
	
	public function activaCatalogo()
	{
		$variable = $this->session->userdata('Catálogos');
		$catalogos=array();
		foreach ($variable as $key => $value) {
			if(isset($value['permisos']))
			{
				$catalogos[] = $value['nombre'];
			}
		}			
		return $catalogos;
	}
	public function catalogos()
	{
		$this->load->model('Modelo_permisos', 'permisos');
		$catalogo = explode('_', $this->ruta())[1];
		$this->area_Estatica('catalogos');
		
		$elcatalogo = $this->session->userdata('permisos')[5];
		$seccion = $this->activaCatalogo();
		
		if( $catalogo == 'Servicios'&&in_array('Servicios', $seccion))
		{
			$data['servicios'] = $this->serv->get_s();
			$this->load->view($this->ruta(), $data);	
		}
		if($catalogo == 'Perfiles'&&in_array('Perfiles', $seccion))
		{
			$this->load->model('modelo_perfil','perfil');
			$data['perfiles'] = $this->perfil->get();
			$data['permisos'] = $this->permisos->get();
			$this->load->view($this->ruta(), $data);	
		}

		if($catalogo == 'Permisos'&&in_array('Permisos', $seccion))
		{
			$data['permisos'] = $this->permisos->get();
			$this->load->view($this->ruta(), $data);	
		}
		
		if($catalogo == 'Empleados'&&in_array('Empleados', $seccion))
		{
			$this->load->model('model_puesto', 'puesto');
			$data['empleados'] = $this->empleado->get();
			$data['telefonos'] = $this->telefono->get();
			$data['puestos']   = $this->puesto->get();
			$this->load->view($this->ruta(), $data);		
		}

		
		if($catalogo == 'Roles'&&in_array('Roles', $seccion))
		{
			$data['roles'] = $this->Roles->get();
			$this->load->view($this->ruta(), $data);	
		}
		if($catalogo == 'Puestos'&&in_array('Puestos', $seccion))
		{
			$this->load->model('model_puesto', 'puesto');
			$data['puestos']   = $this->puesto->get();
			$this->load->view($this->ruta(), $data);	
		}
	}

	public function clientes()
	{
		$this->area_Estatica('clientes');  # Carga la vista por default + la vista del modulo
		$submodulo = explode('_', $this->ruta())[1];

		if( $submodulo == 'nuevo'&&(isset($this->session->userdata('Clientes')[0]['permisos'])) )
		{
			$this->datosCliente($this->ruta());
		}
		
		# TipoCliente= 'cliente o prospecto' y como los dos cargan los mismos datos entonces lo asignamos a una función
		# Y simplemente lo llamamos para que nos cargue los datos y la vista.
		if($submodulo == 'prospectos'&&(isset($this->session->userdata('Clientes')[1]['permisos']))) {	$this->datosCliente($this->ruta());	}
		if($submodulo == 'clientes'&&(isset($this->session->userdata('Clientes')[2]['permisos'])))   {	$this->datosCliente($this->ruta());	}		
		if($submodulo == 'clientes_eliminados'&&(isset($this->session->userdata('Clientes')[3]['permisos']))) {	$this->datosCliente($this->ruta());	}
	
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
		$submodulo = explode('_', $this->ruta())[1];

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
		
		if($submodulo == 'nuevo'){	$this->load->view($this->ruta(), $data);  }
		
		if($submodulo == 'consulta')
		{			
			$this->load->view($this->ruta(), $data);			
		}

		if($submodulo == 'cronograma')
		{	
			$this->load->view($this->ruta(), $data);			
		}
	}

	public function cotizaciones()
	{
		$submodulo = explode('_', $this->ruta())[1];
		$this->area_Estatica('cotizaciones');
		$data['clientes']		  = $this->customer->get();	# Lista de clientes
		$data['servicios'] 		  = $this->serv->get_s();  	# Lista de Servicios
		$data['representantes']	  = $this->representa->get();					# List de representantes
		$data['empleados']	      = $this->empleado->get();
		$data['serviciosCotizados'] = $this->SC->get();
		if($submodulo == 'nuevo')
		{
			$this->load->view($this->ruta(), $data);
		}
		if($submodulo == 'consulta')
		{   
			$data['cotizaciones'] = $this->budget->get();
			$this->load->view($this->ruta(), $data);
		}
		if($submodulo == 'papelera')
		{   
			$data['cotizaciones'] = $this->budget->get();
			$this->load->view($this->ruta(), $data);
		}
	}

	public function contratos()
	{
		$submodulo = explode('_', $this->ruta())[1];
		$this->area_Estatica('contratos');
		$data['clientes']		= $this->customer->get_customerProyect($this->ruta());	# Lista de clientes
		$data['servicios'] 		= $this->serv->get_s();			              	# Lista de Servicios
		$data['representantes']	= $this->representa->get();
		$data['empleados']		= $this->empleado->get();		# List de representantes
		if($submodulo == 'nuevo')
		{
			// $this->load->view('formularioContrato');
			$this->load->view($this->ruta(), $data);
		}
		if($submodulo == 'historial' || $submodulo == 'papelera')
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

	// functiones de calendar
		public function actividades () {
			if ( isset($_GET['code']) ) {
	            $this->client->authenticate($_GET['code']);
	            $this->session->set_userdata('access_token', $this->client->getAccessToken());
	            // $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/escritorio/actividades';
	            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	        }/* else { $this->actividades(); }*/

	        $access_token = $this->session->userdata('access_token');
	        if ( isset( $access_token ) && $access_token ) {
	            $this->client->setAccessToken( $access_token );
	            var_dump( $access_token );
	        } else {
	            $authUrl = $this->client->createAuthUrl();
	        }

	        if ( isset($authUrl) && $authUrl ) {
	        	// $datos = array('authUrl' => $authUrl);
	        	/*Descomentar la linea siguiente y comentar la subsiguiente
	        	para proporcionar una url de accesso para un ancla en la vista
	        	actividades.php. descomentar dicha ancla en la vista.*/
	        	// $this->area_Estatica('actividades', $datos);
	        	header('Location:' . filter_var($authUrl, FILTER_SANITIZE_URL));

	        	break;
	        }

        	$datos = array('expire_in' => $access_token->expire_in);
        	$this->area_Estatica('actividades', $datos);
		}
		public function conectar () {
		}
		public function salir () {
			/*No borrar esta función. sirve para tener un control manual para
			salir de la sesion de google calendar.*/
			$this->session->unset_userdata('access_token');
			header('Location:actividades');
		}

	public function usuarios()
	{
		$this->area_Estatica('usuarios');
		$submodulo = explode('_', $this->ruta())[1];
		$this->load->model('Modelo_permisos', 'permisos');
		
		$this->load->model('modelo_perfil','perfil');
		$data['permisos'] = $this->permisos->get();
		$data['empleados'] = $this->empleado->get();
		$data['perfiles'] = $this->perfil->get();
		if($submodulo == 'nuevo')
		{
			
			$this->load->view($this->ruta(), $data);
		}
		if($submodulo == 'consulta')
		{
						
			$data['usuarios'] = $this->usuario->get(false);
			$this->load->view($this->ruta(), $data);
		}
	}

	public function configuracion(){
		
		$this->area_Estatica($this->ruta());		
		// $this->load->view($this->ruta());
	}

}//FIN DE LA CLASE...
