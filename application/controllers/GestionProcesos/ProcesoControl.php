<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainTipoControl.php';
require_once DOMAINPATH.'DomainProceso.php';
require_once DOMAINPATH.'DomainProcesoControlPropiedad.php';
require_once DOMAINPATH.'DomainProcesoControlEvento.php';
require_once DOMAINPATH.'DomainPropiedad.php';
require_once DOMAINPATH.'DomainEvento.php';
require_once DOMAINPATH.'DomainProcesoControl.php';
require_once DOMAINPATH.'DomainControlPropiedad.php';
require_once DOMAINPATH.'DomainControlEvento.php';

class ProcesoControl extends BaseController{
    function __construct() {
        parent::__construct();
    }
    public function Add(){
    try{
        $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');
        $dmnProcesoControl = new DomainProcesoControl();
        $dmnProcesoControl->setControl(new DomainTipoControl($this->getField('ControlId')));
        $dmnProcesoControl->setProceso(new DomainProceso($this->getField('ProcesoId')));
        $dmnProcesoControl->setNombre($this->getField('nombre'));
        $dmnProcesoControl->setComentarios($this->getField('comentarios'));
        //$dmnProcesoControl->set
        $this->ProcesoControlBO->setDomain($dmnProcesoControl);
        $this->ProcesoControlBO->add();
        $this->getAnswer()->setSuccess(true);
        $this->getAnswer()->setMessage('Registrado Correctamente');
        $this->getAnswer()->setCode(0);
        $this->getAnswer()->AddExtraData('ProcesoControlId',$dmnProcesoControl->getId());   
        echo $this->getAnswer()->getAsJSON(); 
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
        public function upd(){
            try{
                $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');
                $dmnProcesoControl = new DomainProcesoControl();
                $dmnProcesoControl->setId($this->getField('ProcesoControlId'));
                $dmnProcesoControl->setControl(new DomainTipoControl($this->getField('ControlId')));
                $dmnProcesoControl->setProceso(new DomainProceso($this->getField('ProcesoId')));
                $dmnProcesoControl->setNombre($this->getField('nombre'));
                $dmnProcesoControl->setComentarios($this->getField('comentarios'));
                //$dmnProcesoControl->set
                $this->ProcesoControlBO->setDomain($dmnProcesoControl);
                $this->ProcesoControlBO->upd();
                $this->getAnswer()->setSuccess(true);
                $this->getAnswer()->setMessage('Actualizado Correctamente');
                $this->getAnswer()->setCode(0);
                $this->getAnswer()->AddExtraData('ProcesoControlId',$dmnProcesoControl->getId());
                echo $this->getAnswer()->getAsJSON(); 
            }catch(Exception $ex){
                if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                    echo $this->getAnswer()->getAsJSON();
                }else{
                    echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
                }
            }
        }
    
    public function getPropiedades(){
        try{
            $this->load->model('Mapper/Finders/Procesos/FinderProcesoControlPropiedad','FinderProcesoControlPropiedad');                                    
            $response = $this->FinderProcesoControlPropiedad->getPropiedades(
                        $this->getField('ControlId'),
                        $this->getField('ProcesoControlId')
                    );                                
            $this->getPropiedadesReferencias($response);
            echo json_encode(Response::asResults($response));
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }        
    }
    private function getPropiedadesReferencias($response){
        $objects = $response->getResults();
        foreach($objects as $domain){
            $domain->Mapper()->getPropiedad();
        }
    }
    
    public function getEventos(){
        try{
            $this->load->model('Mapper/Finders/Procesos/FinderProcesoControlEvento','FinderProcesoControlEvento');                                    
            $response = $this->FinderProcesoControlEvento->search(
                        $this->getField('ControlId'),
                        $this->getField('ProcesoControlId')
                    );                                
            
            $this->getEventosReferencias($response);
            echo json_encode(Response::asResults($response));
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }   
    }
    
    private function getEventosReferencias($response){
        $objects = $response->getResults();
        foreach($objects as $domain){
            $domain->Mapper()->getEvento();
        }
    }
    
    public function getControls(){
        try{
             $this->load->model('Mapper/Finders/Procesos/FinderControles','FinderControles');
            
            
            
            $response = $this->FinderControles->search(
                        $this->getField('ProcesoId')
                    );  
            echo json_encode(Response::asResults($response));
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }  
    }
    public function find(){
        try{            
            $this->load->model('Mapper/ProcesoControlMapper','ProcesoControlMapper');
            $dmnProceso = $this->ProcesoControlMapper->find($this->getField('id'));
            $dmnProceso->Mapper()->getControl();
            echo json_encode(Response::asSingleObject($dmnProceso));
        } catch (Exception $ex) {
            echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
        }
    }
    public function writePropiedad(){
        try{
            //Verificar si el dato enviado tiene id
            $id = $this->getField('ProcesoControlPropiedadId');                                    
            if ($id === ''){
                $this->addPropiedad();
            }else{
                $this->updPropiedad();
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
    public function writeEvento(){
        try{
            $id = $this->getField('ProcesoControlEventoId');
            if($id === ''){
                $this->addEvento();
            }else{
                $this->updEvento();
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
    
    private function addPropiedad(){
        $dmnProcesoControlPropiedad = new DomainProcesoControlPropiedad();
        $dmnProcesoControlPropiedad->setValor($this->getField('Valor'));
        $dmnProcesoControlPropiedad->setPropiedad(new DomainPropiedad($this->getField('PropiedadId')));        
        $dmnProcesoControlPropiedad->setProcesoControl(new DomainProcesoControl($this->getField('ProcesoControlId')));        
        $dmnProcesoControlPropiedad->setControlPropiedad(new DomainControlPropiedad($this->getField('ControlPropiedadId')));
        //print_r($dmnProcesoControlPropiedad);
        $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');
        $this->ProcesoControlBO->addSingleProperty($dmnProcesoControlPropiedad);
    }
    private function addEvento(){
        $dmnProcesoControlEvento = new DomainProcesoControlEvento();
        $dmnProcesoControlEvento->setValor($this->getField('Valor'));
        $dmnProcesoControlEvento->setEvento(new DomainEvento($this->getField('EventoId')));
        $dmnProcesoControlEvento->setProcesoControl(new DomainProcesoControl($this->getField('ProcesoControlId')));
        $dmnProcesoControlEvento->setControlEvento(new DomainControlEvento($this->getField('ControlEventoId')));
        $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');
        $this->ProcesoControlBO->addSingleEvent($dmnProcesoControlEvento);
                
    }
    
    private function updPropiedad(){
        $dmnProcesoControlPropiedad = new DomainProcesoControlPropiedad($this->getField('ProcesoControlPropiedadId'));
        $dmnProcesoControlPropiedad->setValor($this->getField('Valor'));
        $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');
        $this->ProcesoControlBO->updSingleProperty($dmnProcesoControlPropiedad);        
    }
    private function updEvento(){
        $dmnProcesoControlEvento = new DomainProcesoControlEvento($this->getField('ProcesoControlEventoId'));
        $dmnProcesoControlEvento->setValor($this->getField('Valor'));
        $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');        
        $this->ProcesoControlBO->updSingleEvent($dmnProcesoControlEvento);        
        
    }
    
    
    
}