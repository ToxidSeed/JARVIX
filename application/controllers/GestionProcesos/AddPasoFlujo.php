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

class AddPasoFlujo extends BaseController{
	function __construct(){
		parent::__construct();
	}

    const ALTERNATEWORKFLOWID = 2;
    const EXCEPTIONWORKFLOWID = 3;

    private $dmnPasoFlujo;
    //Aqui se tiene que determinar si es que el paso es el primero que se inserta en el flujo, 
    //caso contrario, identificar el paso correto.
	public function add(){
		try{            
            $this->formValidation(__CLASS__, '', __FUNCTION__);
            $dmnPasoFlujo = new DomainPasoFlujo();
            $dmnProcesoFlujo = new DomainProcesoFlujo($this->getField('ProcesoFlujoId'));
            $dmnPasoFlujo->setProcesoFlujo($dmnProcesoFlujo);
            $dmnPasoFlujo->setDescripcion($this->getField('Descripcion'));
            $dmnPasoFlujo->setNumeroFlujo($this->getField('NumeroFlujo'));
            $dmnTipoFlujo = new DomainTipoFlujo($this->getField('TipoFlujo'));
            $dmnPasoFlujo->setTipoFlujo($dmnTipoFlujo);
            $dmnPasoFlujo->setNumeroPaso($this->getField('NumeroPaso'));
            
            $pasoFlujoReferenciaId = $this->getField('PasoFlujoReferenciaId');
            
            //Si es nulo o vacio
            if($pasoFlujoReferenciaId != null && $pasoFlujoReferenciaId != ""){
                $dmnPasoFlujo->setPasoFlujoReferencia(new DomainPasoFlujo($pasoFlujoReferenciaId));
            }
            
            //print_r($dmnPasoFlujo);
            
            $this->dmnPasoFlujo = $dmnPasoFlujo;
            
            $this->load->model('Bussiness/ProcesoFlujoBO/PasoFlujoAddBO','PasoFlujoAddBO');
                        
            $this->PasoFlujoAddBO->setDomain($dmnPasoFlujo);            
            $this->PasoFlujoAddBO->add();
            
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Registrado Correctamente');
            $this->getAnswer()->setCode(0);
            $this->getAnswer()->AddExtraData('PasoFlujoId',$dmnPasoFlujo->getId());     
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