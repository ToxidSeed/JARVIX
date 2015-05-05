<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainProcesoRequerimientoFuncional.php';
require_once DOMAINPATH.'DomainProceso.php';

class ProcesoRequerimientoFuncional extends BaseController{
    function __construct() {
        parent::__construct();
    }   

    public function asociar(){
        $myRequeriments = json_decode($this->getField('Requerimientos'),true);
        foreach($myRequeriments as $record){
            $this->singleAsociar($record);
        }
    }
    
    public function singleAsociar($record){
        try{
            $dmnObject = new DomainProcesoRequerimientoFuncional();
            $dmnObject->setProceso(new DomainProceso($this->getField('procesoId')));
            $dmnObject->setRequerimientoFuncional(new DomainRequerimiento($this->getField('requerimientoFuncionalId')));
            $this->load->model('ProcesoFlujoBO/ProcesoRequerimientoFuncionalBO','ProcesoRequerimientoFuncionalBO');
            $this->ProcesoRequerimientoFuncionalBO->setObject($dmnObject);
            $this->ProcesoRequerimientoFuncionalBO->relacionar();
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Actualizado Correctamente');
            $this->getAnswer()->setCode(0);
            echo $this->getAnswer()->getAsJSON(); 
            
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    public function getRequerimientos(){
        try{
            $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoRequerimientoFuncionalBO','ProcesoRequerimientoFuncionalBO');
            $results = $this->ProcesoRequerimientoFuncionalBO->getRequerimientos();
            echo json_encode(Response::asResults($results));
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }                
    }    
}
?>