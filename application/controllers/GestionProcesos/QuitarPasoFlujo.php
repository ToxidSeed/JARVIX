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
/**
 * Description of QuitarPasoFlujo
 *
 * @author usuario
 */
class QuitarPasoFlujo extends BaseController{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    public function quitar(){
        try{
            $dmnPasoFlujo = new DomainPasoFlujo($this->getField('pasoFlujoId'));
            $this->load->model('Bussiness/ProcesoFlujoBO/PasoFlujoQuitarBO','PasoFlujoQuitarBO');
            $this->PasoFlujoQuitarBO->setDomain($dmnPasoFlujo);
            $this->PasoFlujoQuitarBO->quitar();
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Registrado Correctamente');
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
