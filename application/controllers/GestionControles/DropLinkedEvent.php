<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once CONTROLLERSPATH.'GestionControles/GestionControlesController.php';
require_once DOMAINPATH.'DomainControlEvento.php';

class DropLinkedEvent extends GestionControlesController{
    function __construct() {
        parent::__construct();
    }
    
    public function Drop(){
        try{
            $this->load->model('Bussiness/ControlBO/DropLinkedEventBO','DropLinkedEventBO');
            $this->recordsToLinkedEvents();
            $this->DropLinkedEventBO->Drop();
            echo Answer::setSuccessMessage('Borrado Correctamente',0);
        } catch (Exception $ex) {
           if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    private function recordsToLinkedEvents(){
        $records = json_decode($this->getField('records'),true);
        foreach($records as $row){
            $this->DropLinkedEventBO->addRecord(new DomainControlEvento($row['id']));
        }
    }
}
