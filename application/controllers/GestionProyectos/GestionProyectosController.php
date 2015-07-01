<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once BASEMODELPATH.'Constraints.php';
require_once DOMAINPATH.'DomainProyecto.php';
require_once DOMAINPATH.'DomainAplicacion.php';
require_once DOMAINPATH.'DomainEstado.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GestionProyectosController extends BaseController{
    function __construct() {
        parent::__construct();
    }
    public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('GestionProyectosView.php');
        $this->load->view('Base/Footer.php');
    }
    public function add(){
        try{
            $this->formValidation(__CLASS__,'', __FUNCTION__);            
            $dmnProyecto = new DomainProyecto();
            $dmnProyecto->setNombre($this->getField('nombre'));   
            $dmnProyecto->setAplicacion(new DomainAplicacion($this->getField('aplicacionid')));
            $dmnProyecto->setDescripcion($this->getField('descripcion'));
            $dmnProyecto->setFechaRegistro(date(APPDATESTNFORMAT));
            $dmnProyecto->setFechaModificacion(date(APPDATESTNFORMAT));            
            $dmnProyecto->setEstado(new DomainEstado(1));
            $this->load->model('Bussiness/ProyectoBO','ProyectoBO');  
            $this->ProyectoBO->setDomain($dmnProyecto);
            $this->ProyectoBO->add();
         
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Registrado Correctamente');
            $this->getAnswer()->setCode(0);
            $this->getAnswer()->AddExtraData('ProyectoId',$dmnProyecto->getId());
            echo $this->getAnswer()->getAsJSON(); 
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
            
            $dmnProyecto = new DomainProyecto($this->getField('id'));
            $dmnProyecto->setNombre($this->getField('nombre'));            
            $this->load->model('Bussiness/ProyectoBO','ProyectoBO');  
            $this->ProyectoBO->setDomain($dmnProyecto);
            $this->ProyectoBO->update();
            echo Answer::setSuccessMessage('Se Actualizó correctamente el Proyecto con nombre: '.$dmnProyecto->getNombre());            
        }
        catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    public function getList(){
         try{
            $this->load->model('Mapper/ProyectoMapper','ProyectoMapper');
            $start = $this->getField('start');
            $limit = $this->getField('limit');
            $myConstraints = new Constraints();
//            $myConstraints->field('id')->eq($this->getField('id'));
//            $myConstraints->field('nombre')->like($this->getField('nombre'));            
            $response = $this->ProyectoMapper->search($myConstraints,$start,$limit);            
            echo json_encode(Response::asResults($response));                                   
        }catch(Exception $ex){
            //Setting the Error Code 
            echo $ex->getMessage();
        }
    }
    public function find(){
        try{
            $this->load->model('Mapper/ProyectoMapper','ProyectoMapper');
            $dmnProyecto = $this->ProyectoMapper->find($this->getField('id'));            
            $dmnProyecto->mapper()->getEstado();
            $dmnProyecto->mapper()->getAplicacion();
            echo json_encode(Response::asSingleObject($dmnProyecto));
        }catch(Exception $ex){
            echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
        }
    }
    
    public function ChangeStatus(){
        try{
            $this->formValidation(__CLASS__,'',__FUNCTION__);
            $dmnProyecto = new DomainProyecto($this->getField('id'));
            $dmnProyecto->setNombre($this->getField('nombre'));
            $dmnProyecto->setEstado(new DomainEstado($this->getField('currentStatus')));
            $dmnProyecto->setFechaModificacion(date(APPDATEFROMDBFORMAT));
            $this->load->model('Bussiness/ProyectoBO','ProyectoBO');
            $this->ProyectoBO->setDomain($dmnProyecto);
            $this->ProyectoBO->ChangeStatus();
            echo Answer::setSuccessMessage('Se ha cambiado el estado correctamente'.$dmnProyecto->getNombre());            
        }catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    public function getNoParticipantes(){
         try{
             $this->load->model('Mapper/Finders/SysUsuario/SysUsuarioFRM1','SysUsuarioFRM1');
             
             $constraints = array(
                'Nombre' => $this->getField('Nombre'),
                'ProyectoId' => $this->getField('ProyectoId')
             );
             
             $response = $this->SysUsuarioFRM1->search($constraints);
             echo json_encode(Response::asResults($response));                
        }catch(Exception $ex){
            //Setting the Error Code 
            echo $ex->getMessage();
        }
    }
    public function updParticipantes(){
        try{
            $varUsuariosAsignados = json_decode($this->getField('selected'),true);            
            $varProyectoId = $this->getField('ProyectoId');
            
            $this->load->model('Bussiness/Proyecto/WriteParticipanteBO','WriteParticipanteBO');
            $this->WriteParticipanteBO->write($varProyectoId,$varUsuariosAsignados);
            $result = $this->WriteParticipanteBO->getAnswer();
            $result->showSuccessMessage('Se Asignaron Participantes al proyecto correctamente');            
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
