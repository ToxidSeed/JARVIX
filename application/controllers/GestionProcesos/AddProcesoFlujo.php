<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainProcesoFlujo.php';
require_once DOMAINPATH.'DomainProceso.php';
require_once DOMAINPATH.'DomainPasoFlujo.php';
require_once DOMAINPATH.'DomainTipoFlujo.php';
require_once DOMAINPATH.'DomainProcesoFlujo.php';
require_once DOMAINPATH.'DomainEstadoProcesoFlujo.php';

class AddProcesoFlujo extends BaseController{
    public function __construct() {
        parent::__construct();
    }
    
    const STATUS_PROCESO_FLUJO_REGISTRADO = 0;
    const STATUS_ALCANCE_COMPLETADO = 0;
    
    public function Add(){
        try{
            $this->formValidation(__CLASS__, '', __FUNCTION__);
            $dmnProcesoFlujo = new DomainProcesoFlujo();
            $dmnProcesoFlujo->setProceso(new DomainProceso($this->getField('ProcesoId')));
            $dmnProcesoFlujo->setNombre($this->getField('Nombre'));
            $dmnProcesoFlujo->setDescripcion($this->getField('Descripcion'));                                                
            $dmnProcesoFlujo->setEstado(new DomainEstadoProcesoFlujo(self::STATUS_PROCESO_FLUJO_REGISTRADO));
            $dmnProcesoFlujo->setAlcanceCompletadoInd(self::STATUS_ALCANCE_COMPLETADO);
            
            $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoFlujoAddBO','ProcesoFlujoAddBO');
            $this->ProcesoFlujoAddBO->setDomain($dmnProcesoFlujo);            
            $this->ProcesoFlujoAddBO->add();
            
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Registrado Correctamente');
            $this->getAnswer()->setCode(0);
            $this->getAnswer()->AddExtraData('ProcesoFlujoId',$dmnProcesoFlujo->getId());     
            echo $this->getAnswer()->getAsJSON(); 
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    public function GetConfig(){
        try{
            $this->load->model('Mapper/Finders/TipoFlujo/FinderTipoFlujoDefault','FinderTipoFlujoDefault');
            $dmnTipoFlujo = $this->FinderTipoFlujoDefault->search();
            echo json_encode(Response::asSingleObject($dmnTipoFlujo));
        } catch (Exception $ex) {
            
        }
    }
    
    private function getSteps(DomainProcesoFlujo $dmnProcesoFlujo){

        $steps = $this->getField('Steps');        
        $decodeSteps = json_decode(str_replace("\n",'<br/>',$steps),true);           

        $myArrSteps = array();                
        
        foreach($decodeSteps as $myStep){
            $myDmnPasoFlujo = new DomainPasoFlujo();
            
            if ($myStep['id'] != 'undefined' && $myStep['id'] != null && $myStep['id'] != 'null') {
                $myDmnPasoFlujo->setId($myStep['id']);
            }            
            
            $myDmnPasoFlujo->setProcesoFlujo($dmnProcesoFlujo);
            $myDmnPasoFlujo->setNumeroFlujo($myStep['NumeroFlujo']);
            $myDmnPasoFlujo->setDescripcion($myStep['Descripcion']);
            $myDmnTipoFlujo = new DomainTipoFlujo($myStep['TipoFlujoId']);
            $myDmnPasoFlujo->setTipoFlujo($myDmnTipoFlujo);
            $myDmnPasoFlujo->setNumeroPaso($myStep['Paso']);
            
            //Check if reference Fluj
            if ($myStep['PasoFlujoReferenciaId'] != 'undefined' && $myStep['PasoFlujoReferenciaId'] != null && $myStep['PasoFlujoReferenciaId'] != 'null'){
                $myDmnPasoFlujoReferencia = new DomainPasoFlujo();
                $myDmnPasoFlujoReferencia->setId($myStep['PasoFlujoReferenciaId']);
                $myDmnPasoFlujo->setPasoFlujoReferencia($myDmnPasoFlujoReferencia);
            }else{
                //Caso contrario, verificar si es que tiene algun paso de referencia
                if($myStep['PasoReferencia'] != 'undefined' && $myStep['PasoReferencia'] != 'null' && $myStep['PasoReferencia'] != null){
                    $myDmnPasoFlujoReferencia = new DomainPasoFlujo();
                    $myDmnPasoFlujoReferencia->setNumeroPaso($myStep['PasoReferencia']);
                    $myDmnPasoFlujoReferencia->setNumeroFlujo($myStep['NumeroFlujoReferencia']);
                    $myDmnPasoFlujoReferencia->setTipoFlujo(new DomainTipoFlujo($myStep['TipoFlujoReferenciaId']));
                    $myDmnPasoFlujo->setPasoFlujoReferencia($myDmnPasoFlujoReferencia);
//                }                                
                }
                
            }
            $myArrSteps[] = $myDmnPasoFlujo;
        }    
    return $myArrSteps;
    }


    public function searchSteps(){
        $this->load->model('Mapper/Finders/PasoFlujo/FinderPasoFlujo','FinderPasoFlujo');        
        $procesoFlujoId = $this->getField('ProcesoFlujoId');
        $response = $this->FinderPasoFlujo->search($procesoFlujoId);  

        //print_r($response);
        
        foreach($response->getResults() as $myStep  ){
            $myStep->mapper()->getTipoFlujo();            
            $dmnPasoFlujoReferencia = $myStep->mapper()->getPasoFlujoReferencia();
            if($dmnPasoFlujoReferencia != null){
                $dmnPasoFlujoReferencia->mapper()->getTipoFlujo();
            }
        }
        
        //print_r($response);

        //print_r($response->getResults());
        
        $myArrResults = Response::asResults($response);
        
        //print_r($myArrResults);

        foreach($myArrResults['results'] as $idx => $row){                        
            //print_r($row);
            if ($row['tipoFlujo']['id'] == 2 || $row['tipoFlujo']['id'] == 3){
                $myArrResults['results'][$idx]['Grouper'] = '('.$row['tipoFlujo']['id'].'.'.$row['pasoFlujoReferencia']['numeroPaso'].'.'.$row['numeroFlujo'].')'.'-'.$row['tipoFlujo']['nombre'].' al paso Nro '.$row['pasoFlujoReferencia']['numeroPaso'].' del '.$row['pasoFlujoReferencia']['tipoFlujo']['nombre'];            
            }else{
                $myArrResults['results'][$idx]['Grouper'] = '('.$row['tipoFlujo']['id'].'.'.$row['numeroFlujo'].')'.'-'.$row['tipoFlujo']['nombre'];            
            }
            
        }

        echo json_encode($myArrResults);             
    }


            
}
