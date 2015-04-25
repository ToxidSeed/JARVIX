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

class UpdatePasoFlujo extends BaseController{
	function __construct(){
		parent::__construct();
	}

    const ALTERNATEWORKFLOWID = 2;
    const EXCEPTIONWORKFLOWID = 3;

    private $dmnPasoFlujo;
    //Aqui se tiene que determinar si es que el paso es el primero que se inserta en el flujo, 
    //caso contrario, identificar el paso correto.
	public function Update(){
		try{            
            //  $this->formValidation(__CLASS__, '', __FUNCTION__);
            $dmnPasoFlujo = new DomainPasoFlujo($this->getField('PasoFlujoId'));                 
            $dmnPasoFlujo->setDescripcion($this->getField('Descripcion'));
            $this->dmnPasoFlujo = $dmnPasoFlujo;          
            $this->load->model('Bussiness/ProcesoFlujoBO/PasoFlujoUpdateBO','PasoFlujoUpdateBO');
            
            
            $this->PasoFlujoUpdateBO->setDomain($dmnPasoFlujo);            
            $this->PasoFlujoUpdateBO->update();
            
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Actualizado Correctamente Correctamente');
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