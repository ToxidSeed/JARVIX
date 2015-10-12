<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once CONTROLLERSPATH.'GestionControles/GestionControlesController.php';
require_once DOMAINPATH.'DomainEvento.php';

class AddLinkedEvent extends  GestionControlesController{
    function __construct() {
        parent::__construct();
    }
    public function Add(){
        try{
           
            $dmnEvento = new DomainEvento();
            $dmnEvento->setControl(new DomainTipoControl($this->getField('ControlId')));
            $dmnEvento->setNombre($this->getField('Nombre'));
                    
            $this->load->model('Bussiness/ControlBO/AddLinkedEventBO','AddLinkedEventBO');
            
            $this->AddLinkedEventBO->setDomain($dmnEvento);            
            $this->AddLinkedEventBO->Add();
            
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Registrado Correctamente');
            $this->getAnswer()->setCode(0);
            //$this->getAnswer()->AddExtraData('ControlId',$dmnControl->getId());                        
            echo $this->getAnswer()->getAsJSON();
            
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
