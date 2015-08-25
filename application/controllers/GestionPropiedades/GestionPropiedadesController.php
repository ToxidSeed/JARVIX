<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once BASEMODELPATH.'Constraints.php';
require_once DOMAINPATH.'DomainPropiedad.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GestionPropiedadesController extends BaseController{
    function __construct() {
        parent::__construct();
    }
    public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('GestionPropiedadesView.php');
        $this->load->view('Base/Footer.php');
    }
    public function add(){
        try{
            $this->formValidation(__CLASS__,'', __FUNCTION__);
            
            $dmnPropiedad = new DomainPropiedad();
            $dmnPropiedad->setNombre($this->getField('Nombre'));
            //$dmnPropiedad->setFechaRegistro(date(APPDATESTNFORMAT));
            //$dmnPropiedad->setFechaUltAct(date(APPDATESTNFORMAT));
            $this->load->model('Bussiness/PropiedadBO','PropiedadBO');  
            $this->PropiedadBO->setDomain($dmnPropiedad);
            $this->PropiedadBO->add();
            echo Answer::setSuccessMessage('Se guardo correctamente la propiedad con nombre: '.$dmnPropiedad->getNombre());            
        }
        catch(Exception $ex){
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
            
            $dmnPropiedad = new DomainPropiedad($this->getField('id'));
            $dmnPropiedad->setNombre($this->getField('nombre'));
            $dmnPropiedad->setFechaRegistro(date(APPDATESTNFORMAT));
            $dmnPropiedad->setFechaUltAct(date(APPDATESTNFORMAT));
            $this->load->model('Bussiness/PropiedadBO','PropiedadBO');  
            $this->PropiedadBO->setDomain($dmnPropiedad);
            $this->PropiedadBO->update();
            echo Answer::setSuccessMessage('Se Actualizó correctamente la propiedad con nombre: '.$dmnPropiedad->getNombre());            
        }
        catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
     
     public function getPropiedades(){
        try{
            $this->load->model('Mapper/PropiedadMapper','PropiedadMapper');
            $start = $this->getField('start');
            $limit = $this->getField('limit');
            $myConstraints = new Constraints();
            $myConstraints->field('id')->eq($this->getField('id'));
            $myConstraints->field('nombre')->like($this->getField('nombre'));
            $myConstraints->field('fechaRegistro')->greaterTO($this->getField('fechaRegistroDesde'));
            $myConstraints->field('fechaRegistro')->lowerTO($this->getField('fechaRegistroHasta'));
            $myConstraints->field('fechaUltAct')->greaterTO($this->getField('fechaUltActDesde'));
            $myConstraints->field('fechaUltAct')->lowerTO($this->getField('fechaUltActHasta'));        
            $response = $this->PropiedadMapper->search($myConstraints,$start,$limit);
            echo json_encode(Response::asResults($response));                                   
        }catch(Exception $ex){
            //Setting the Error Code     
        }
    }
    
    public function find(){
        try{
            $this->load->model('Mapper/PropiedadMapper','PropiedadMapper');
            $domain = $this->PropiedadMapper->find($this->getField('id'));
            echo json_encode(Response::asSingleObject($domain));
        }catch(Exception $ex){
            echo Answer::setFailedMessage($ex->getMessage(),$e->getCode());
        }
    }
}
?>
