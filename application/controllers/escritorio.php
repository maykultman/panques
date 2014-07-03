<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include 'REST.php';
class Escritorio extends REST {

	public function __construct() 
	{
        parent::__construct();
		$this->load->library('form_validation');
        $this->load->model('model_customer', 	     'customer');
        $this->load->model('model_contact', 	     'contacto');
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

	//Vista inicial
	public function index(){  $this->area_Estatica('dashboard_gustavo');	} # Cargamos el dashboard
	public function dashboard(){  $this->area_Estatica('dashboard_gustavo');	} # Cargamos el dashboard
	public function prueba()
	{
		$this->load->view('pruebausuario');
	}

	public function catalogos()
	{
		$this->area_Estatica('modulo_catalogos');
		$this->load->model('Modelo_permisos', 'permisos');
		$this->load->model('Modelo_permisoPerfil', 'perper');

		if($this->ruta() == 'catalogo_servicios')
		{
			$data['servicios'] = $this->serv->get_s();
			$this->load->view($this->ruta(), $data);	
		}
		if($this->ruta() == 'catalogo_perfiles')
		{
			$this->load->model('modelo_perfil','perfil');
			$data['perfiles'] = $this->perfil->get();
			$data['permisos'] = $this->permisos->get();
			$data['permisos_perfil'] = $this->perper->get();

			$this->load->view($this->ruta(), $data);	
		}
		if($this->ruta() == 'catalogo_permisos')
		{
			$data['permisos'] = $this->permisos->get();
			$this->load->view($this->ruta(), $data);	
		}
		if($this->ruta() == 'catalogo_empleados')
		{
			$this->load->model('model_puesto', 'puesto');
			$data['empleados'] = $this->empleado->get();
			$data['telefonos'] = $this->telefono->get();
			$data['puestos']   = $this->puesto->get();
			$this->load->view($this->ruta(), $data);	
		}
		if($this->ruta() == 'catalogo_roles')
		{
			$data['roles'] = $this->Roles->get();
			$this->load->view($this->ruta(), $data);	
		}
		if($this->ruta() == 'catalogo_puestos')
		{
			$this->load->model('model_puesto', 'puesto');
			$data['puestos']   = $this->puesto->get();
			$this->load->view($this->ruta(), $data);	
		}
	}

	public function clientes()
	{	
		$this->area_Estatica('modulo_Clientes');  # Carga la vista por default + la vista del modulo

		if($this->ruta() == 'modulo_cliente_nuevo')
		{
			$this->datosCliente($this->ruta());
		}
		# TipoCliente= 'cliente o prospecto' y como los dos cargan los mismos datos entonces lo asignamos a una función
		# Y simplemente lo llamamos para que nos cargue los datos y la vista.
		
		if($this->ruta() == 'modulo_consulta_clientes')   {	$this->datosCliente($this->ruta());	}
		if($this->ruta() == 'modulo_consulta_prospectos') {	$this->datosCliente($this->ruta());	}		
	} # Fin del metodo clientes...

	public function datosCliente($vista)
	{
		$data['clientes']		  = $this->customer->get_customers($this->ruta());	# Lista de clientes
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
		$this->area_Estatica('modulo_proyectos');
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
		
		if($this->ruta() == 'modulo_proyectos_nuevo'){	$this->load->view($this->ruta(), $data);  }
		
		if($this->ruta() == 'modulo_proyectos_consulta')
		{			
			$this->load->view($this->ruta(), $data);			
		}
		if($this->ruta() == 'modulo_proyectos_cronograma')
		{			
			$this->load->view($this->ruta());			
		}
	}

	public function cotizacion()
	{
		$this->area_Estatica('modulo_cotizaciones');
		$data['clientes']		  = $this->customer->get_customerProyect();	# Lista de clientes
		$data['servicios'] 		  = $this->serv->get_s();  	# Lista de Servicios
		$data['representantes']	  = $this->representa->get();					# List de representantes
		$data['empleados']	      = $this->empleado->get();
		$data['serviciosCotizados'] = $this->SC->get();
		if($this->ruta() == 'modulo_cotizaciones_nuevo')
		{
			$this->load->view($this->ruta(), $data);
		}
		if($this->ruta() == 'modulo_cotizaciones_consulta')
		{   
			$data['cotizaciones'] = $this->budget->get();
			$this->load->view($this->ruta(), $data);
		}
	}

	public function contratos()
	{
		$this->area_Estatica('modulo_contratos');
		$data['clientes']		  = $this->customer->get_customerProyect($this->ruta());	# Lista de clientes
		$data['servicios'] 		  = $this->serv->get_s();			              	# Lista de Servicios
		$data['representantes']	  =$this->representa->get();					# List de representantes
		if($this->ruta() == 'modulo_contratos_nuevo')
		{
			$this->load->view($this->ruta(), $data);
		}
		if($this->ruta() == 'modulo_contratos_historial')
		{
			$this->load->model('Model_ServiceContract');
			$this->load->model('Model_contract');
			$this->load->model('Model_payment');

			$data['contratos'] = $this->Model_contract->get();
			$data['serviciosDeContrato'] = $this->Model_ServiceContract->get();
			$data['pagos'] = $this->Model_payment->get();

			$this->load->view($this->ruta(), $data);
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
			$data['clientes']		  = $this->customer->get_customerProyect();	# Lista de clientes
			$data['servicios'] 		  = $this->serv->get_Servicios_Proyecto();  	# Lista de Servicios
			$data['representantes']	  = $this->representa->get();

			$this->load->view('formato_contrato', $data);
		}
		
	}

	public function actividades(){
		$this->area_Estatica('modulo_actividades.html');
	}

	public function pdf(){
		$this->load->view('pruebapdf');
	}



	public function usuarios()
	{
		$this->area_Estatica('modulo_usuarios');

		$this->load->model('Modelo_permisos', 'permisos');
		$this->load->model('Modelo_permisoPerfil', 'perper');
		$this->load->model('modelo_perfil','perfil');
		
		if($this->ruta() == 'modulo_usuarios_nuevo')
		{
			$data['perfiles'] = $this->perfil->get();
			$data['permisos'] = $this->permisos->get();
			$data['permisos_perfil'] = $this->perper->get();
			$data['empleados'] = $this->empleado->get();
			$this->load->view($this->ruta(), $data);
		}
		if($this->ruta() == 'modulo_usuarios_consulta')
		{
			$this->load->view($this->ruta());
		}
	}

	public function configuracion(){
		$this->area_Estatica('configuracion');
	}

}//FIN DE LA CLASE...
