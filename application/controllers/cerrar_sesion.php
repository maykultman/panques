<?php session_start();
	/**
	* 
	*/
	class Cerrar_sesion extends CI_Controller
	{
		
		public function logout()
		{
			// die('eee');
			// session_start();
			
			// $_SESSION['usuario']='';
			session_destroy();
			// die($_SESSION['usuario']);
			
			redirect(base_url());
		}
	}
?>