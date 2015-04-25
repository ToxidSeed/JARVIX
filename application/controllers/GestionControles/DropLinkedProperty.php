<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once CONTROLLERSPATH.'GestionControles/GestionControlesController.php';
require_once DOMAINPATH.'DomainControlPropiedad.php';

class DropLinkedProperty extends GestionControlesController{
    function __construct() {
        parent::__construct();
    }
    
    public function Drop(){
        try{
            $this->load->model('Bussiness/ControlBO/DropLinkedPropertyBO','DropLinkedPropertyBO');                
            $this->recordsToLinkedProperties();
            $this->DropLinkedPropertyBO->Drop();
            echo Answer::setSuccessMessage('Borrado Correctamente',0);
        }catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    private function recordsToLinkedProperties(){
        $records = json_decode($this->getField('records'),true);        
        foreach($records  as $row){
            $this->DropLinkedPropertyBO->addRecord(new DomainControlPropiedad($row['id']));
        }                
    }
}
 
?>
