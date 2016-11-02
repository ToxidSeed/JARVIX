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
    
    const STATUS_PROCESO_CONTROL_REGISTRADO = 0;
    
    
    public function wrt(){    
        try{
            $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');
            $dmnProcesoControl = new DomainProcesoControl($this->getField('proceso_control_id'));
            $dmnProcesoControl->setControl(new DomainTipoControl($this->getField('control_id')));
            $dmnProcesoControl->setProceso(new DomainProceso($this->getField('proceso_id')));
            $dmnProcesoControl->setNombre($this->getField('nombre'));
            $dmnProcesoControl->setComentarios($this->getField('comentarios'));
            $this->ProcesoControlBO->setDomain($dmnProcesoControl);

            if($this->getField('proceso_control_id') == 0 || $this->getField('proceso_control_id') == null ){
                $dmnProcesoControl->setAlcanceCompletadoInd(self::STATUS_PROCESO_CONTROL_REGISTRADO);
                $this->ProcesoControlBO->add();
            }else{
                //@TEMPORAL: se debe quitar este estado;
                 $dmnProcesoControl->setAlcanceCompletadoInd(self::STATUS_PROCESO_CONTROL_REGISTRADO);
                $this->ProcesoControlBO->upd();
            }
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
    
//    public function getPropiedades(){
//        try{
//            $this->load->model('Mapper/Finders/Procesos/FinderProcesoControlPropiedad','FinderProcesoControlPropiedad');                                    
//            $response = $this->FinderProcesoControlPropiedad->getPropiedades(
//                        $this->getField('ControlId'),
//                        $this->getField('ProcesoControlId')
//                    );                                
//            $this->getPropiedadesReferencias($response);
//            echo json_encode(Response::asResults($response));
//        } catch (Exception $ex) {
//            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
//                echo $this->getAnswer()->getAsJSON();
//            }else{
//                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
//            }
//        }        
//    }
//    private function getPropiedadesReferencias($response){
//        $objects = $response->getResults();
//        foreach($objects as $domain){
//            $domain->Mapper()->getPropiedad();
//        }
//    }
        
          public function getPropiedadesDisponibles(){
        //        $config = array();
                $this->load->model('Mapper/Finders/Propiedad/PropiedadFRM1','PropiedadFRM1');
                $response = $this->PropiedadFRM1->search(
                            array(
                                    'ControlId' => $this->getField('ControlId') ,
                                    'ProcesoControlId' => $this->getField('ProcesoControlId')
                                )
                        );
                 
                foreach($response->getResults() as $dmnPropiedad){                    
                    $dmnPropiedad->mapper()->getEditor();
                }
                                
                 echo json_encode(Response::asResults($response));
            }  
    
    public function getPropiedadesSeleccionadas(){
//        $config = array();
        $this->load->model('Mapper/Finders/Procesos/ProcesoControlPropiedadFRM1','ProcesoControlPropiedadFRM1');
        $response = $this->ProcesoControlPropiedadFRM1->search(
                    array(
                            'ControlId' => $this->getField('ControlId'),
                            'ProcesoControlId' => $this->getField('ProcesoControlId')
                        )
                );
        
        foreach($response->getResults() as $record){
           $myPropiedad =  $record->mapper()->getPropiedad();
           $myPropiedad->mapper()->getEditor();
        }
                
        
//        echo json_encode($config);
        //echo json_encode(Response::asResults($config));
         echo json_encode(Response::asResults($response));
    }    
        
    public function getEventosSeleccionados(){
        try{
            $this->load->model('Mapper/Finders/Procesos/ProcesoControlEventoFRM2','EventosSeleccionados');
            $response = $this->EventosSeleccionados->search(
                        array(
                            'ProcesoControlId' => $this->getField('ProcesoControlId')
                        )                        
                    );
            foreach($response->getResults() as $records){
                $records->mapper()->getEvento();                
            }            
            echo json_encode(Response::asResults($response));
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    public function getEventosDisponibles(){
        try{
            $this->load->model('Mapper/Finders/Procesos/ProcesoControlEventoFRM1','ProcesoControlEventoFRM1');
            $response = $this->ProcesoControlEventoFRM1->search(
                        array(
                            'ProcesoControlId' => $this->getField('ProcesoControlId'),
                            'ControlId' => $this->getField('ControlId'),
                            'NombreEvento' => $this->getField('NombreEvento')                            
                        )                                                
            );                                
                        
            echo json_encode(Response::asResults($response));
        }catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }   
    }
    
    
    
    
    /*private function getEventosReferencias($response){
        $objects = $response->getResults();
        foreach($objects as $domain){
            $domain->Mapper()->getEvento();
        }
    }*/
    
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
            $this->load->model('Mapper/ProcesoControlMapper','ProcesoControlMapper');
            $dmnProceso = $this->ProcesoControlMapper->find($this->getField('id'));
            $dmnProceso->Mapper()->getControl();
            echo json_encode(Response::asSingleObject($dmnProceso));
        } catch (Exception $ex) {
            echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
        }
    }
    public function add_propiedades(){
        try{
              $arr_propiedades = array();  
                
              $proceso_control_id = $this->getField('proceso_control_id');
              $records = json_decode($this->getField('propiedades'),true);
              
              foreach($records as $propiedad_data){
                  $dmnProcesoControlPropiedad = new DomainProcesoControlPropiedad();
                  $dmnProcesoControlPropiedad->setProcesoControl(new DomainProcesoControl($proceso_control_id));
                  $dmnProcesoControlPropiedad->setControl(new DomainTipoControl($this->getField('control_id')));
                  $dmnProcesoControlPropiedad->setPropiedad(new DomainPropiedad($propiedad_data["propiedad_id"]));
                  $dmnProcesoControlPropiedad->setValor($propiedad_data["valor"]);
                  $arr_propiedades[] = $dmnProcesoControlPropiedad;
              }
              
              $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');
              $this->ProcesoControlBO->propiedades = $arr_propiedades;
              $this->ProcesoControlBO->add_propiedades();
              $this->getAnswer()->setSuccess(true);
              $this->getAnswer()->setMessage('Actualizado Correctamente');
              $this->getAnswer()->setCode(0);
              //$this->getAnswer()->AddExtraData('ProcesoControlId',$dmnProcesoControl->getId());
              echo $this->getAnswer()->getAsJSON();                           
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    public function add_eventos(){
         try{
              $arr_eventos = array();  
                
              $proceso_control_id = $this->getField('proceso_control_id');
              $records = json_decode($this->getField('eventos'),true);
              
              foreach($records as $evento){
                  $dmnProcesoControlEvento = new DomainProcesoControlEvento();
                  $dmnProcesoControlEvento->setProcesoControl(new DomainProcesoControl($proceso_control_id));
                  $dmnProcesoControlEvento->setControl(new DomainTipoControl($this->getField('control_id')));
                  $dmnProcesoControlEvento->setEvento(new DomainEvento($evento["EventoId"]));                  
                  $arr_eventos[] = $dmnProcesoControlEvento;
              }
              
              $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');
              $this->ProcesoControlBO->set_eventos($arr_eventos); 
              $this->ProcesoControlBO->add_eventos();
              $this->getAnswer()->setSuccess(true);
              $this->getAnswer()->setMessage('Actualizado Correctamente');
              $this->getAnswer()->setCode(0);
              //$this->getAnswer()->AddExtraData('ProcesoControlId',$dmnProcesoControl->getId());
              echo $this->getAnswer()->getAsJSON();                           
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    public function del_eventos(){
        try{
            $records = json_decode($this->getField('eventos'),true);
            
//            print_r($records);
            
            $eventos = array();
            foreach($records as $row){
                $eventos[] = new DomainProcesoControlEvento($row['EventoId']);
            }
            $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');
            $this->ProcesoControlBO->set_eventos($eventos);
            $this->ProcesoControlBO->del_eventos();
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Actualizado Correctamente');
            $this->getAnswer()->setCode(0);
            //$this->getAnswer()->AddExtraData('ProcesoControlId',$dmnProcesoControl->getId());
            echo $this->getAnswer()->getAsJSON();                           
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    
    
    public function del_propiedades(){
        try{            
            $records = json_decode($this->getField('propiedades'),true);
            $arr_procesos = array();
            foreach($records as $row){
                $dmnProcesoControlPropiedad = new DomainProcesoControlPropiedad($row['proceso_control_propiedad_id']);
                $arr_procesos[] = $dmnProcesoControlPropiedad;
            }
            
            $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');
            $this->ProcesoControlBO->propiedades = $arr_procesos;
            $this->ProcesoControlBO->del_propiedades();
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Actualizado Correctamente');
            $this->getAnswer()->setCode(0);
            //$this->getAnswer()->AddExtraData('ProcesoControlId',$dmnProcesoControl->getId());
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
//        $dmnProcesoControlPropiedad->setControlPropiedad(new DomainControlPropiedad($this->getField('ControlPropiedadId')));
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
    
    
    private function updEvento(){
        $dmnProcesoControlEvento = new DomainProcesoControlEvento($this->getField('ProcesoControlEventoId'));
        $dmnProcesoControlEvento->setValor($this->getField('Valor'));
        $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlBO','ProcesoControlBO');        
        $this->ProcesoControlBO->updSingleEvent($dmnProcesoControlEvento);        
        
    }
    
}