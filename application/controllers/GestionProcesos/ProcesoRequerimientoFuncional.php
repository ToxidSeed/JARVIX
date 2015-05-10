<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainProcesoRequerimientoFuncional.php';
require_once DOMAINPATH.'DomainProceso.php';
require_once DOMAINPATH.'DomainRequerimiento.php';

class ProcesoRequerimientoFuncional extends BaseController{
    function __construct() {
        parent::__construct();
    }   

    public function asociar(){
        $myRequeriments = json_decode($this->getField('Requerimientos'),true);
        foreach($myRequeriments as $record){
            $this->singleAsociar($record);
        }
        $this->getAnswer()->setSuccess(true);
        $this->getAnswer()->setMessage('Actualizado Correctamente');
        $this->getAnswer()->setCode(0);
        echo $this->getAnswer()->getAsJSON(); 
    }
    
    public function singleAsociar($record){
        try{
            $dmnObject = new DomainProcesoRequerimientoFuncional();
            $dmnObject->setProceso(new DomainProceso($this->getField('ProcesoId')));
            $dmnObject->setRequerimientoFuncional(new DomainRequerimiento($record['requerimientoFuncional.id']));
            $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoRequerimientoFuncionalBO','ProcesoRequerimientoFuncionalBO');
            $this->ProcesoRequerimientoFuncionalBO->setDomain($dmnObject);
            $this->ProcesoRequerimientoFuncionalBO->relacionar();
            
            
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
            $varProcesoId = $this->getField('parProcesoId');
            $results = $this->ProcesoRequerimientoFuncionalBO->getRequerimientos($varProcesoId);
            echo json_encode(Response::asResults($results));
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }                
    }
    public function quitar(){
        try{
            $myRequeriments = json_decode($this->getField('Requerimientos'),true);
            $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoRequerimientoFuncionalBO','ProcesoRequerimientoFuncionalBO');
            foreach($myRequeriments as $record){
                $dmnObject = new DomainProcesoRequerimientoFuncional($record['id']);                       
                $this->ProcesoRequerimientoFuncionalBO->setDomain($dmnObject);
                $this->ProcesoRequerimientoFuncionalBO->quitar();                
            }
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
    
}
?>