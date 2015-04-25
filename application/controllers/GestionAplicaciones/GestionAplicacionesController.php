<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once BASEMODELPATH.'Constraints.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainAplicacion.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GestionAplicacionesController extends BaseController{
    function __construct() {
        parent::__construct();
    }
    public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('GestionAplicacionesView.php');
        $this->load->view('Base/Footer.php');
    }
    public function add(){
        try{
            $this->formValidation(__CLASS__, '', __FUNCTION__);
            $dmnAplicacion = new DomainAplicacion();
            $dmnAplicacion->setNombre($this->getField('nombre'));
            $dmnAplicacion->setRutaPublicacion($this->getField('rutaPublicacion'));
            $dmnAplicacion->setServidor($this->getField('servidor'));
            $dmnAplicacion->setBaseDatos($this->getField('baseDatos'));
            $dmnAplicacion->setUsername($this->getField('username'));
            $dmnAplicacion->setPassword($this->getField('password'));
            $dmnAplicacion->setEstado(new DomainEstado(1));//Inserting Active Status
            $dmnAplicacion->setFechaRegistro(date(APPDATESTNFORMAT));
            $dmnAplicacion->setFechaModificacion(date(APPDATESTNFORMAT));
            $this->load->model('Bussiness/AplicacionBO','AplicacionBO');
            $this->AplicacionBO->setDomain($dmnAplicacion);
            $this->AplicacionBO->add();
            echo Answer::setSuccessMessage('Se guardo correctamente la aplicacion con nombre: '.$dmnAplicacion->getNombre());
        }catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }    
        }
    }
    public function getAplicaciones(){
        try{
            $this->load->model('Mapper/AplicacionMapper','AplicacionMapper');
            $start = $this->getField('start');
            $limit = $this->getField('limit');
            $myConstraints = new Constraints();
            $myConstraints->field('id')->eq($this->getField('id'));
            $myConstraints->field('nombre')->like($this->getField('nombre'));
            $response = $this->AplicacionMapper->search($myConstraints,$start,$limit);
            
            foreach($response->getResults() as $dmnAplicacion){
                $dmnAplicacion->mapper()->getEstado();
            }
            echo json_encode(Response::asResults($response));
        }catch(Exception $ex){
            //Exception Code Here    
        }
    }
    
    public function find(){
        try{
            $this->load->model('Mapper/AplicacionMapper','AplicacionMapper');
            $dmnAplicacion = $this->AplicacionMapper->find($this->getField('id'));
            $dmnAplicacion->mapper()->getEstado();
            echo json_encode(Response::asSingleObject($dmnAplicacion));
        }catch(Exception $ex){
            echo Answer::setFailedMessage($ex->getMessage(),$e->getCode());
        }
    }
    
    public function update(){
        try{
            $this->formValidation(__CLASS__, '', __FUNCTION__);
            $dmnAplicacion = new DomainAplicacion($this->getField('id'));
            $dmnAplicacion->setNombre($this->getField('nombre'));
            $dmnAplicacion->setFechaModificacion(date(APPDATESTNFORMAT));
            $this->load->model('Bussiness/AplicacionBO','AplicacionBO');            
            $this->AplicacionBO->setDomain($dmnAplicacion);
            $this->AplicacionBO->update();
            echo Answer::setSuccessMessage('Se modificó correctamente la aplicacion con nombre: '.$dmnAplicacion->getNombre(),0);            
        }catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    public function ChangeStatus(){
        try{
            $this->formValidation(__CLASS__, '', __FUNCTION__);
            $dmnAplicacion = new DomainAplicacion($this->getField('id'));
            $dmnAplicacion->setNombre($this->getField('nombre'));
            $dmnAplicacion->setEstado(new DomainEstado($this->getField('currentStatus')));
            $dmnAplicacion->setFechaModificacion(date(APPDATESTNFORMAT));
            $this->load->model('Bussiness/AplicacionBO','AplicacionBO');                                                
            $this->AplicacionBO->setDomain($dmnAplicacion);
            $this->AplicacionBO->ChangeStatus();
            echo Answer::setSuccessMessage('Se ha cambiado el estado correctamente'.$dmnAplicacion->getNombre());            
        }catch(Exception $e){
            if($e->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($e->getMessage(),$e->getCode());
            }
        }
    }
}
?>