<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainRequerimiento.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainProyecto.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GestionRequerimientosController extends BaseController{
    function __construct() {
        parent::__construct();
    }
    public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('GestionRequerimientosView.php');
        $this->load->view('Base/Footer.php');
    }
    public function add(){
        try{
            $this->formValidation(__CLASS__, '',__FUNCTION__);
            $dmnRequerimiento = new DomainRequerimiento();
            $dmnRequerimiento->setNombre($this->getField('nombre'));
            $dmnRequerimiento->setCodigo($this->getField('codigo'));
            $dmnRequerimiento->setDescripcion($this->getField('descripcion'));
            $dmnRequerimiento->setEstado(new DomainEstado(0));
            $dmnRequerimiento->setFechaRegistro(date(APPDATESTNFORMAT));
            $dmnRequerimiento->setFechaModificacion(date(APPDATESTNFORMAT));
            $dmnRequerimiento->setProyecto(new DomainProyecto($this->getField('ProyectoId')));
            $dmnRequerimiento->setOrden($this->getField('orden'));
            $this->load->model('Bussiness/RequerimientoBO','RequerimientoBO');
            $this->RequerimientoBO->setDomain($dmnRequerimiento);
            $this->RequerimientoBO->add();
            echo Answer::setSuccessMessage('Se guardo correctamente el requerimiento con nombre: '.$dmnRequerimiento->getNombre());            
        }catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    /**/
    public function update(){
        try{
            $this->formValidation(__CLASS__,'', __FUNCTION__);
            
            $dmnRequerimiento = new DomainRequerimiento($this->getField('id'));
            $dmnRequerimiento->setCodigo($this->getField('codigo'));
            $dmnRequerimiento->setNombre($this->getField('nombre'));
            $dmnRequerimiento->setDescripcion($this->getField('descripcion'));
            $dmnRequerimiento->setFechaModificacion(date(APPDATESTNFORMAT));
            $dmnRequerimiento->setEstado(new DomainEstado(0));
            $this->load->model('Bussiness/RequerimientoBO','RequerimientoBO');  
            $this->RequerimientoBO->setDomain($dmnRequerimiento);
            $this->RequerimientoBO->update();
            echo Answer::setSuccessMessage('Se Actualizó correctamente el Proyecto con nombre: '.$dmnRequerimiento->getNombre());            
        }
        catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    public function search(){
        $this->load->model('Mapper/RequerimientoFinder','RequerimientoFinder');        
        $response = $this->RequerimientoFinder->getList(
                $this->getField('ProyectoId'),
                $this->getField('nombre')
                );        
        echo json_encode(Response::asResults($response));
    }
    
    public function find(){
        try{
            $this->load->model('Mapper/RequerimientoMapper','RequerimientoMapper');
            $dmnRequerimiento = $this->RequerimientoMapper->find($this->getField('id'));
            $dmnRequerimiento->mapper()->getEstado();                        
            echo json_encode(Response::asSingleObject($dmnRequerimiento));            
        }catch(Exception $ex){
            echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
        }
    }
    
    public function ChangeStatus(){
        try{
            $this->formValidation(__CLASS__,'',__FUNCTION__);
            $dmnRequerimiento = new DomainRequerimiento($this->getField('id'));
            $dmnRequerimiento->setNombre($this->getField('nombre'));
            $dmnRequerimiento->setEstado(new DomainEstado($this->getField('currentStatus')));
            $this->load->model('Bussiness/RequerimientoBO','RequerimientoBO');  
            $this->RequerimientoBO->setDomain($dmnRequerimiento);
            $this->RequerimientoBO->ChangeStatus();
            echo Answer::setSuccessMessage('Se Actualizó correctamente el estado con nombre: '.$dmnRequerimiento->getNombre());            
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
