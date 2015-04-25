<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once CONTROLLERSPATH.'GestionControles/GestionControlesController.php';
require_once DOMAINPATH.'DomainPropiedad.php';
require_once DOMAINPATH.'DomainEstado.php';

class AddProperties extends GestionControlesController{
    function __construct() {
        parent::__construct();
    }
    public function Add(){
        try{
            //$this->formValidation(__CLASS__,'', __FUNCTION__);
            $dmnControl = new DomainTipoControl();
            //Check if Id Tipo control exists
            $ControlId = $this->getField('ControlId');
            if($ControlId != null){
                $dmnControl->setId($ControlId);                
            }else{
                $dmnControl->setNombre($this->getField('nombre'));
                $dmnControl->setEstado(new DomainEstado(1));//Estado Activo                 
            }
            //            
            $this->load->model('Bussiness/ControlBO/AddPropertyBO','AddPropertyBO');    
            $this->AddPropertyBO->setDomain($dmnControl);
            $this->RecordsToProperties();
            $this->AddPropertyBO->Add();
            
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
    
    private function RecordsToProperties(){        
        $records = json_decode($this->getField('records'),true);        
        foreach($records as $row){
            $dmnPropiedad = new DomainPropiedad();
            $dmnPropiedad->setId($row['id']);
            $dmnPropiedad->setNombre($row['nombre']);
            $this->AddPropertyBO->addRecord($dmnPropiedad);            
        }        
    }
}
?>
