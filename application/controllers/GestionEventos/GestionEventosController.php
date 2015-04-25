<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once BASEMODELPATH.'Constraints.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainEvento.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GestionEventosController extends BaseController{
    function __construct() {
        parent::__construct();
    }
    public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('GestionEventosView.php');
        $this->load->view('Base/Footer.php');
    }
    
    public function add(){
        try{
            $this->formValidation(__CLASS__,'', __FUNCTION__);
            $dmnEvento = new DomainEvento();
            $dmnEvento->setNombre($this->getField('nombre'));
            $dmnEvento->setFechaRegistro(date(APPDATESTNFORMAT));
            $dmnEvento->setFechaUltAct(date(APPDATESTNFORMAT));
            $dmnEvento->setEstado(new DomainEstado(1)); //1 is Active
            $this->load->model('Bussiness/EventoBO','EventoBO');
            $this->EventoBO->setDmnEvento($dmnEvento);
            $this->EventoBO->add();
            echo Answer::setSuccessMessage('Se guardo correctamente el evento con nombre: '.$dmnEvento->getNombre());            
        }catch(Exception $e){
            if($e->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($e->getMessage(),$e->getCode());
            }
            
        }
    }
    
    public function getEventos(){
        try{
            $this->load->model('Mapper/EventoMapper','EventoMapper');
            $start = $this->getField('start');
            $limit = $this->getField('limit');
            $myConstraints = new Constraints();
            $myConstraints->field('id')->eq($this->getField('id'));
            $myConstraints->field('nombre')->like($this->getField('nombre'));
            $myConstraints->field('fechaRegistro')->greaterTO($this->getField('fechaRegistroDesde'));
            $myConstraints->field('fechaRegistro')->lowerTO($this->getField('fechaRegistroHasta'));
            $myConstraints->field('fechaUltAct')->greaterTO($this->getField('fechaUltActDesde'));
            $myConstraints->field('fechaUltAct')->lowerTO($this->getField('fechaUltActHasta'));        
            $response = $this->EventoMapper->search($myConstraints,$start,$limit);
            echo json_encode(Response::asResults($response));                                   
        }catch(Exception $ex){
            //Setting the Error Code     
        }
    }
    
    public function find(){
        try{
            $this->load->model('Mapper/EventoMapper','EventoMapper');
            $dmnEvento = $this->EventoMapper->find($this->getField('id'));
            echo json_encode(Response::asSingleObject($dmnEvento));
        }catch(Exception $ex){
            echo Answer::setFailedMessage($ex->getMessage(),$e->getCode());
        }
    }
    public function update(){
        try{
            $this->formValidation(__CLASS__,'', __FUNCTION__);
            $dmnEvento = new DomainEvento($this->getField('id'));
            $dmnEvento->setNombre($this->getField('nombre'));
            $dmnEvento->setFechaUltAct(date(APPDATESTNFORMAT));
            $dmnEvento->setEstado(new DomainEstado(1));
            $this->load->model('Bussiness/EventoBO','EventoBO');
            $this->EventoBO->setDmnEvento($dmnEvento);
            $this->EventoBO->update();
            echo Answer::setSuccessMessage('Se modificó correctamente el evento con nombre: '.$dmnEvento->getNombre());            
        }catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
}

?>
