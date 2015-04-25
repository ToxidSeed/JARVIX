<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once CONTROLLERSPATH.'GestionControles/GestionControlesController.php';

class AddLinkedEvent extends  GestionControlesController{
    function __construct() {
        parent::__construct();
    }
    public function Add(){
        try{
            $dmnControl = new DomainTipoControl();
            
            $ControlId = $this->getField('ControlId');
            if($ControlId != null){
                $dmnControl->setId($ControlId);
            }else{
                $dmnControl->setNombre($this->getField('nombre'));
                $dmnControl->setEstado(new DomainEstado(1));
            }
            //
            $this->load->model('Bussiness/ControlBO/AddLinkedEventBO','AddLinkedEventBO');
            
            $this->AddLinkedEventBO->setDomain($dmnControl);
            $this->RecordsToEvents();
            $this->AddLinkedEventBO->Add();
            
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Registrado Correctamente');
            $this->getAnswer()->setCode(0);
            $this->getAnswer()->AddExtraData('ControlId',$dmnControl->getId());                        
            echo $this->getAnswer()->getAsJSON();
            
        }catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    private function RecordsToEvents(){
        $records = json_decode($this->getField('records'),true);
//        print_r($records);
        foreach($records as $row){
            $dmnEvento = new DomainEvento();
            $dmnEvento->setId($row['id']);
            $dmnEvento->setNombre($row['nombre']);
            $this->AddLinkedEventBO->addRecord($dmnEvento);
        }
    }
}

?>
