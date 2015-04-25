<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'TipoControlMapper.php';
require_once MAPPERPATH.'ControlPropiedadMapper.php';
require_once DOMAINPATH.'DomainControlPropiedad.php';

class AddPropertyBO extends BaseBO{
    private $records = array();
    public function addRecord(DomainPropiedad $record){
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
            //Add Properties
            $this->AddProperties();
            
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
        //else nothinh
    }
    
    
    
    private function AddProperties(){        
        foreach($this->records as $dmnPropiedad){
            //Lo inserta si no encuentra ninguna propiedad relacionada
            if($this->checkExistLinkedProperty($this->domain->getId(), $dmnPropiedad->getId()) == null){
                $dmnControlPropiedad = new DomainControlPropiedad();            
                $dmnControlPropiedad->setPropiedad($dmnPropiedad);
                $dmnControlPropiedad->setControl($this->domain);
                $this->AddSingleProperty($dmnControlPropiedad);
            }            
        }
    }
    private function AddSingleProperty($dmnControlPropiedad){
         $mprControlPropiedad = new ControlPropiedadMapper();
         $mprControlPropiedad->Insert($dmnControlPropiedad);
    }
    
    private function checkExistLinkedProperty($myControlId,$myPropertyId){
        $mprControlPropiedad = new ControlPropiedadMapper();
        $mprControlPropiedad->addUnique('controlid', $myControlId);
        $mprControlPropiedad->addUnique('propiedadid', $myPropertyId);
        $dmnControlPropiedad =  $mprControlPropiedad->find();
        return $dmnControlPropiedad;
    }
}

?>
