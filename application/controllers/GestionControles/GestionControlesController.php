<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once BASEMODELPATH.'Constraints.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainTipoControl.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GestionControlesController extends BaseController{
    function __construct() {
        parent::__construct();
    }
    public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('GestionControles.php');
        $this->load->view('Base/Footer.php');
    }
    public function getControles(){
        $this->load->model('Mapper/TipoControlMapper','TipoControlMapper');
        $start = $this->getField('start');
        $limit = $this->getField('limit');
        $myConstraints = new Constraints();
        $myConstraints->field('id')->eq($this->getField('id')); 
        $myConstraints->field('nombre')->like($this->getField('nombre'));
        $myConstraints->field('fechaRegistro')->greaterTO($this->getField('fechaRegistroDesde'));
        $myConstraints->field('fechaRegistro')->lowerTO($this->getField('fechaRegistroHasta'));
        $myConstraints->field('fechaUltAct')->greaterTO($this->getField('fechaUltActDesde'));
        $myConstraints->field('fechaUltAct')->lowerTO($this->getField('fechaUltActHasta'));        
        $response = $this->TipoControlMapper->search($myConstraints,$start,$limit);        
        echo json_encode(Response::asResults($response));                                   
    }
    public function add(){
        try{                       
            $this->formValidation(__CLASS__,'', __FUNCTION__);
            $dmnTipoControl = new DomainTipoControl();
            $dmnTipoControl->setNombre($this->getField('nombre'));
            $dmnTipoControl->setFechaRegistro(date(APPDATESTNFORMAT));
            $dmnTipoControl->setFechaUltAct(date(APPDATESTNFORMAT));
            $dmnTipoControl->setEstado(new DomainEstado(1)); //1 is Active
            //Loading the instance OF BO object
            $this->load->model('Bussiness/TipoControlBO','TipoControlBO');            
            $this->TipoControlBO->setDmnTipoControl($dmnTipoControl);
            //Adding the new Domain
            $this->TipoControlBO->add();
            echo Answer::setSuccessMessage('Se guardo correctamente el tipo de control con nombre: '.$dmnTipoControl->getNombre());            
        }catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
            
        }        
    }
    public function update(){
        try{
            $this->formValidation(__CLASS__,'', __FUNCTION__);
            $dmnTipoControl = new DomainTipoControl($this->getField('id'));
            $dmnTipoControl->setNombre($this->getField('nombre'));            
            $dmnTipoControl->setFechaUltAct(date(APPDATESTNFORMAT));
            $dmnTipoControl->setEstado(new DomainEstado(1)); //1 is Active
            //Loading the instance OF BO object
            $this->load->model('Bussiness/TipoControlBO','TipoControlBO');            
            $this->TipoControlBO->setDmnTipoControl($dmnTipoControl);
            //Adding the new Domain
            $this->TipoControlBO->update();
            echo Answer::setSuccessMessage('Se modificó correctamente el tipo de control con nombre: '.$dmnTipoControl->getNombre());            
        }catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    public function inactivate(){
        try{
            $this->formValidation(__CLASS__,'', __FUNCTION__);            
            $dmnTipoControl = new DomainTipoControl($this->getField('id'));         
            $dmnTipoControl->setNombre($this->getField('nombre'));
            $dmnTipoControl->setFechaUltAct(date(APPFORMAT));
            $dmnTipoControl->setEstado(new DomainEstado(0)); //1 is Inactive
            //Loading the instance OF BO object
            $this->load->model('Bussiness/TipoControlBO','TipoControlBO');            
            $this->TipoControlBO->setDmnTipoControl($dmnTipoControl);
            //Adding the new Domain
            $this->TipoControlBO->Inactivate();
            echo Answer::setSuccessMessage('Se Inactivo correctamente el tipo de control con nombre: '.$dmnTipoControl->getNombre());            
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
            $this->load->model('Mapper/TipoControlMapper','TipoControlMapper');
            $dmnTipoControl = $this->TipoControlMapper->find($this->getField('id'));
            echo json_encode(Response::asSingleObject($dmnTipoControl));
        }catch(Exception $ex){
            echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
        }
    }
    
    public function GetActiveProperties(){
        $this->load->model('Mapper/Finders/FinderActivePropiedades','FinderActivePropiedades');
        $this->FinderActivePropiedades->nombre = $this->input->get_post('nombre');
        $response = $this->FinderActivePropiedades->Search() ;
        echo json_encode(Response::asResults($response)); 
    }    
    
    public function GetLinkedProperties(){
        $this->load->model('Mapper/Finders/Controles/FinderLinkedProperties','FinderLinkedProperties');
        $this->FinderLinkedProperties->setDmnControl(new DomainTipoControl($this->input->get_post('ControlId')));
        $response = $this->FinderLinkedProperties->search();
        foreach($response->getResults() as $dmnControlPropiedad){
            $dmnControlPropiedad->mapper()->getControl();
            $dmnControlPropiedad->mapper()->getPropiedad();
        }
        echo json_encode(Response::asResults($response)); 
    }
    public function getActiveEvents(){
        $this->load->model('Mapper/Finders/Controles/FinderActiveEventos','FinderActiveEventos');
        $response = $this->FinderActiveEventos->search();
        echo json_encode(Response::asResults($response));
        
    }
    
    public function GetLinkedEvents(){
        $this->load->model('Mapper/Finders/Controles/FinderLinkedEvents','FinderLinkedEvents');
        $this->FinderLinkedEvents->setDmnControl(new DomainTipoControl($this->input->get_post('ControlId')));
        $response = $this->FinderLinkedEvents->search();
        foreach($response->getResults() as $dmnControlEvento){
            $dmnControlEvento->mapper()->getControl();
            $dmnControlEvento->mapper()->getEvento();                    
        }
        
        echo json_encode(Response::asResults($response));        
    }
}
?>