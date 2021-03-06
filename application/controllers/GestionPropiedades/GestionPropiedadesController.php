<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once BASEMODELPATH.'Constraints.php';
require_once DOMAINPATH.'DomainPropiedad.php';
require_once DOMAINPATH.'DomainTipoControl.php';
require_once DOMAINPATH.'DomainEditor.php';
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
    public function writeRecord(){        
        $dmnPropiedad = new DomainPropiedad($this->getField('PropiedadId'));        
        $dmnPropiedad->setNombre($this->getField('Nombre'));
        $dmnPropiedad->setEditor(new DomainEditor($this->getField('EditorId')));
        $valores = json_decode($this->getField('Valores'),true);
                
        $valoresEliminar = json_decode($this->getField('ValoresEliminar'),true);

        $dmnControl = new DomainTipoControl($this->getField('ControlId'));
        $dmnPropiedad->setControl($dmnControl);
        
        if($dmnPropiedad->getId() == null){
            $this->add($dmnPropiedad,$valores);
        }else{
            $this->upd($dmnPropiedad,$valores,$valoresEliminar);
        }
    }
    
    public function add($dmnPropiedad,$valores){
        try{
            $this->formValidation(__CLASS__,'', __FUNCTION__);
            
            $this->load->model('Bussiness/PropiedadBO','PropiedadBO');  
            $this->PropiedadBO->setDomain($dmnPropiedad);
            $this->PropiedadBO->setValores($valores);
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
    
    
    public function upd($dmnPropiedad,$valores,$valoresEliminar){
        try{
            //print_r($valores);
            //print_r($valoresEliminar);
            //exit();
            $this->formValidation(__CLASS__,'', __FUNCTION__);                        
            $this->load->model('Bussiness/PropiedadBO','PropiedadBO');  
            $this->PropiedadBO->setDomain($dmnPropiedad);
            $this->PropiedadBO->setValores($valores);
            $this->PropiedadBO->setValoresEliminar($valoresEliminar);
//            print_r($dmnPropiedad);
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
    
    public function getValores(){
        $this->load->model('Mapper/Finders/ValorPropiedad/ValorPropiedadFRM1','ValorPropiedadFRM1');
        //$this->FinderActivePropiedades->nombre = $this->input->get_post('PropiedadId');
        $filters = array(
            'PropiedadId' =>   $this->getField('PropiedadId')
        );
        $response = $this->ValorPropiedadFRM1->Search($filters) ;
        echo json_encode(Response::asResults($response)); 
    }
    
    public function find(){
        try{
            $this->load->model('Mapper/PropiedadMapper','PropiedadMapper');
            $domain = $this->PropiedadMapper->find($this->getField('PropiedadId'));
            $domain->mapper()->getEditor();
            echo json_encode(Response::asSingleObject($domain));
        }catch(Exception $ex){
            echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
        }
    }
    
    public function get_editores(){
        $this->load->model('Mapper/Finders/ValorPropiedad/ValorPropiedadFRM1','ValorPropiedadFRM1');        
        $filters = array(
            'PropiedadId' =>   $this->getField('PropiedadId')
        );
        $response = $this->ValorPropiedadFRM1->Search($filters) ;
        echo json_encode(Response::asResults($response)); 
    }
}