<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainProceso.php';
require_once DOMAINPATH.'DomainProyecto.php';
require_once DOMAINPATH.'DomainAplicacion.php';

class GestionProcesosController extends BaseController{
    function __construct() {
        parent::__construct();
    }
    public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('GestionProcesosView.php');
        $this->load->view('Base/Footer.php');
    }
    public function addOption(){        
        //Load Proyect Information
        try{            
            $this->load->model('Mapper/ProyectoMapper','ProyectoMapper');
            $dmnProyecto = $this->ProyectoMapper->find($this->getField('proyectoid'));
            //echo json_encode(Response::asSingleObject($dmnProyecto));
        } catch (Exception $ex) {
            echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
        }
        
        $data = array(
            'id' => 0,
            'proyecto_id' => $dmnProyecto->getId(),
            'nombre_proyecto' => $dmnProyecto->getNombre(),
            'aplicacion_id' => $dmnProyecto->getAplicacion()->getId()
        );
        
        //print_r($data);
        //exit();
        $this->load->view('Base/Header.php');
        $this->load->view('GestionProcesosMainView.php',$data);
        $this->load->view('Base/Footer.php');
    }

    public function updateOption(){
        $this->load->model('Mapper/ProyectoMapper','ProyectoMapper');
        $dmnProyecto = $this->ProyectoMapper->find($this->getField('proyecto_id'));
        $data = array(
            'id' => $this->getField('id'),
            'proyecto_id' => $dmnProyecto->getId(),
            'nombre_proyecto' => $dmnProyecto->getNombre(),
            'aplicacion_id'  =>  $dmnProyecto->getAplicacion()->getId()
            
        );
        $this->load->view('Base/Header.php');
        $this->load->view('GestionProcesosMainView.php',$data);
        $this->load->view('Base/Footer.php');
    }

    public function add(){
        try{
            
            $data = $this->cargarArchivo();
            
            if($data == null){
                exit();
            }
            
            $this->formValidation(__CLASS__,'', __FUNCTION__);                        
            $dmnProceso = new DomainProceso();
            $dmnProceso->setNombre($this->getField('nombre'));
            $dmnProceso->setEstado(new DomainEstado(0));//Estado Activo
            $dmnProceso->setProyecto(new DomainProyecto($this->getField('ProyectoId')));
            $dmnProceso->setAplicacion(new DomainAplicacion($this->getField('AplicacionId')));
            //Setting file path
            $filePath = base_url().'uploads/'.$data['file_name'];            
            $fileName = $filePath;
            $dmnProceso->setRutaPrototipo($fileName);
            $this->load->model('Bussiness/ProcesoBO','ProcesoBO');
            $this->ProcesoBO->setDomain($dmnProceso);
            $this->ProcesoBO->add();
            
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Registrado Correctamente');
            $this->getAnswer()->setCode(0);
            $this->getAnswer()->AddExtraData('ProcesoId',$dmnProceso->getId());                        
            echo $this->getAnswer()->getAsJSON();                        
        }catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    private function cargarArchivo(){       
            $data = NULL;
            $error = array();
            
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']	= '2000000';
            $config['max_width']  = '2000';
            $config['max_height']  = '2000';
            
            //print_r($_FILES);
            
            $this->load->library('upload', $config);    
            if ( ! $this->upload->do_upload('prototypeUpload'))
            {
                $error = array('error' => $this->upload->display_errors());   
            }else{
                $data = $this->upload->data();               
            }
            
            if (count($error) > 0 ){                
                foreach($error as $message){
                    $this->getAnswer()->addFailMessage($message,1);
                }
                $this->getAnswer()->setSuccess(true);
                echo $this->getAnswer()->getAsJSON();              
            }
            return $data;
    }
    
    public function find(){
        try{            
            $this->load->model('Mapper/ProcesoMapper','ProcesoMapper');
            $dmnProceso = $this->ProcesoMapper->find($this->getField('id'));                        
            
            echo json_encode(Response::asSingleObject($dmnProceso));
        } catch (Exception $ex) {
            echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
        }
    }
    
    /*
     * Método que realiza la lista de procesos que se encuentran en el sistema
     */
    public function getList(){
        $this->load->model('Mapper/Finders/Procesos/FinderProcesos','FinderProcesos');
        $response = $this->FinderProcesos->search(array(
            'ProyectoId' => $this->getField('proyectoId')
        ));
        echo json_encode(Response::asResults($response));        
    }
    
    /*
    Metodo para obtener los flujos
    */
    public function getFlujos(){
        $this->load->model('Mapper/Finders/Procesos/FinderProcesosFlujos','FinderProcesosFlujos');
        $response = $this->FinderProcesosFlujos->getFlujosRegistradosByProceso($this->getField('ProcesoId'));
        echo json_encode(Response::asResults($response)); 
    }
    
    public function getRequerimientos(){    
        //Check DataType Validation
        $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoBO','ProcesoBO');
        $response = $this->ProcesoBO->getRequerimientos(
                    $this->getField('ProcesoId')
                );
        echo json_encode(Response::asResults($response));    
    } 
    
    
}
?>
