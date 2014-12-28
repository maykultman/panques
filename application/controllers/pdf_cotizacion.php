<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pdf_cotizacion extends CI_Controller 
{
 
    public function __construct()
    {
        parent::__construct();
        //cargamos la libreria html2pdf
        $this->load->library('html2pdf');
        // cargarmos los modelos necesario
        $this->load->model('model_budget');
        $this->load->model('modelo_servicioCotizado');
        $this->load->model('modelo_servicios');
    }
 
    private function createFolder()
    {
        if(!is_dir("./archivos"))
        {
            mkdir("./archivos", 0777);
            mkdir("./archivos/pdfs", 0777);
            mkdir("./archivos/pdfs/cotizaciones", 0777);
        }
    }
 
 
    public function index($id) {
    }
    public function get_cotizacion ($id) {
        //establecemos la carpeta en la que queremos guardar los pdfs,
        //si no existen las creamos y damos permisos
        $this->createFolder();
 
        //importante el slash del final o no funcionará correctamente
        $this->html2pdf->folder('./archivos/pdfs/cotizaciones/');
        
        //establecemos el nombre del archivo
        $this->html2pdf->filename('cotizacion.pdf');
        
        //establecemos el tipo de papel
        $this->html2pdf->paper('letter', 'portrait');
        
        //datos que queremos enviar a la vista, lo mismo de siempre
        $data = array(
            'cotizacion'    => $this->model_budget->get($id, true),
            'cotizados'     => $this->modelo_servicioCotizado->get($id),
            'servicios'     => $this->modelo_servicios->get_s()
        );
        
        //hacemos que coja la vista como datos a imprimir
        //importante utf8_decode para mostrar bien las tildes, ñ y demás
        $this->html2pdf->html(utf8_decode($this->load->view('pdf_cotizacion', $data, true)));
        
        //si el pdf se guarda correctamente lo mostramos en pantalla
        if($this->html2pdf->create('save')) 
        {
            $this->show();
        }
    }
 
    //funcion que ejecuta la descarga del pdf
    public function downloadPdf()
    {
        //si existe el directorio
        if(is_dir("./archivos/pdfs/cotizaciones"))
        {
            //ruta completa al archivo
            $route = base_url("archivos/pdfs/cotizaciones/cotizacion.pdf"); 
            //nombre del archivo
            $filename = "cotizacion.pdf"; 
            //si existe el archivo empezamos la descarga del pdf
            if(file_exists("./archivos/pdfs/cotizaciones/".$filename))
            {
                header("Cache-Control: public"); 
                header("Content-Description: File Transfer"); 
                header('Content-disposition: attachment; filename='.basename($route)); 
                header("Content-Type: application/pdf"); 
                header("Content-Transfer-Encoding: binary"); 
                header('Content-Length: '. filesize($route)); 
                readfile($route);
            }
        }    
    }
 
 
    //esta función muestra el pdf en el navegador siempre que existan
    //tanto la carpeta como el archivo pdf
    public function show()
    {
        if(is_dir("./archivos/pdfs/cotizaciones"))
        {
            $filename = "cotizacion.pdf"; 
            $route = base_url("archivos/pdfs/cotizaciones/cotizacion.pdf"); 
            if(file_exists("./archivos/pdfs/cotizaciones/".$filename))
            {
                header('Content-type: application/pdf'); 
                readfile($route);
            }
        }
    }
    
    //función para crear y enviar el pdf por email
    //ejemplo de la libreria sin modificar
    public function mail_pdf()
    {
        
        //establecemos la carpeta en la que queremos guardar los pdfs,
        //si no existen las creamos y damos permisos
        $this->createFolder();
 
        //importante el slash del final o no funcionará correctamente
        $this->html2pdf->folder('./archivos/pdfs/');
        
        //establecemos el nombre del archivo
        $this->html2pdf->filename('test.pdf');
        
        //establecemos el tipo de papel
        $this->html2pdf->paper('a4', 'portrait');
        
        //datos que queremos enviar a la vista, lo mismo de siempre
        $data = array(
            'title' => 'Listado de las provincias españolas en pdf'
        );
        
        //hacemos que coja la vista como datos a imprimir
        //importante utf8_decode para mostrar bien las tildes, ñ y demás
        $this->html2pdf->html(utf8_decode($this->load->view('pdf', $data, true)));
 
 
        //Check that the PDF was created before we send it
        if($path = $this->html2pdf->create('save')) 
        {
 
            $this->load->library('email');
 
            $this->email->from('your@example.com', 'Your Name');
            $this->email->to('israel965@yahoo.es'); 
            
            $this->email->subject('Email PDF Test');
            $this->email->message('Testing the email a freshly created PDF');    
 
            $this->email->attach($path);
 
            $this->email->send();
            
            echo "El email ha sido enviado correctamente";
                        
        }
        
    } 
}
/* End of file pdf_cotizacion.php */
/* Location: ./application/controllers/pdf_cotizacion.php */