<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainProceso.php';

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
        $data = array(
            'id' => 0
        );
        $this->load->view('Base/Header.php');
        $this->load->view('GestionProcesosMainView.php',$data);
        $this->load->view('Base/Footer.php');
    }

    public function updateOption(){
        $data = array(
            'id' => $this->getField('id')
        );
        $this->load->view('Base/Header.php');
        $this->load->view('GestionProcesosMainView.php',$data);
        $this->load->view('Base/Footer.php');
    }

    public function add(){
        try{
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']	= '100';
            $config['max_width']  = '1300';
            $config['max_height']  = '900';
            $this->load->library('upload', $config);    
            if ( ! $this->upload->do_upload('prototypeUpload'))
            {
                $error = array('error' => $this->upload->display_errors());   
            }else{
                $data = $this->upload->data();               
            }
            
            $this->formValidation(__CLASS__,'', __FUNCTION__);                        
            $dmnProceso = new DomainProceso();
            $dmnProceso->setNombre($this->getField('nombre'));
            $dmnProceso->setEstado(new DomainEstado(1));//Estado Activo
            $fileName = base_url().'uploads/'.$data['file_name'];
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
        $response = $this->FinderProcesos->search();
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
