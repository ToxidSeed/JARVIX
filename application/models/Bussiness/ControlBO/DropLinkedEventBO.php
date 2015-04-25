<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'ControlEventoMapper.php';
require_once DOMAINPATH.'DomainControlEvento.php';

class DropLinkedEventBO extends BaseBO{
    private $records = array();
    
    public function addRecord(DomainControlEvento $record){
        $this->records[] = $record;
    }
    
    public function setRecords($records){
        $this->records = $records;
    }
    
    function __construct() {
        parent::__construct();
    }
    
    public function Drop(){
        
        try{
            $this->load->database();
            $this->db->trans_start();

            $this->DropLinkedEvents();

            $this->db->trans_complete();
        } catch (Exception $ex) {
            $this->db->trans_rollbac();
            throw new Exception($ex->getMessage());
        }        
    }
    
    private function DropLinkedEvents(){
        $mprControlEvento = new ControlEventoMapper();
        foreach($this->records as $dmnControlEvento){
            $mprControlEvento->Delete($dmnControlEvento);
        }
    }
}