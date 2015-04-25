<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'TipoControlMapper.php';
require_once MAPPERPATH.'ControlEventoMapper.php';
require_once DOMAINPATH.'DomainControlEvento.php';

class AddLinkedEventBO extends BaseBO{
    private $records = array();
    
    public function addRecord(DomainEvento $record){
        $this->records[] = $record;
    }
    
    public function setRecords($records){
        $this->records = $records;
    }
    
    function __construct() {
        parent::__construct();
    }
    
    public function Add(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $this->checkObject();
            //Save Control
            $this->SaveControl();
            //Add Events
            $this->AddLinkedEvents();
                        
            $this->db->trans_commit();
        }catch(Exception $ex){
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage());
        }
    }
    
    private function SaveControl(){
        if($this->getDomain()->getId() == null || $this->getDomain()->getId() == 0){
            $mprTipoControl = new TipoControlMapper();
            $mprTipoControl->insert($this->domain);
        }
    }
    
    private function AddLinkedEvents(){
        foreach($this->records as $dmnEvento){
            if($this->checkExistLinkedEvent($this->domain->getId(), $dmnEvento->getId()) == null){
                $dmnControlEvento = new DomainControlEvento();
                $dmnControlEvento->setEvento($dmnEvento);
                $dmnControlEvento->setControl($this->domain);
                $this->AddSingleEvent($dmnControlEvento);
            }
        }
    }
    
    private function AddSingleEvent($dmnEvento){
        $mprControlEvento = new ControlEventoMapper();
        $mprControlEvento->Insert($dmnEvento);
    }
    
    private function checkExistLinkedEvent($myControlId,$myEventId){
        $mprControlEvent = new ControlEventoMapper();
        $mprControlEvent->addUnique('controlid', $myControlId);
        $mprControlEvent->addUnique('eventoid', $myEventId);
        $dmnControlEvento = $mprControlEvent->find();
        return $dmnControlEvento;
    }
}

?>
