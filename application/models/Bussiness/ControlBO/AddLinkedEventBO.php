<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'TipoControlMapper.php';
//require_once MAPPERPATH.'ControlEventoMapper.php';
//require_once DOMAINPATH.'DomainControlEvento.php';
require_once MAPPERPATH.'EventoMapper.php';

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
            
            $mprEvento = new EventoMapper();
            $mprEvento->insert($this->domain);
                        
            $this->db->trans_commit();
        }catch(Exception $ex){
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage());
        }
    }        
}

?>
