<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once FINDERPATH.'ProcesoRequerimiento/ProcesoRequerimientoFRM2.php';

class ProcesoRequerimientoFuncionalBO extends BaseBO{
    function __construct() {
        parent::__construct();
        $this->ProcesoRequerimientoFuncionalMapper = new ProcesoRequerimientoFuncionalMapper();
    }
           
    private $ProcesoRequerimientoFuncionalMapper;
    private $Object;
    
//    public function setObject($object){
//        $this->Object = $object;
//    }
//    
    public function relacionar(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            if ($this->getDomain()->getId() == null){
                $this->add();
            }else{
                $this->upd();
            }
            
            $this->db->trans_commit();
            
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    
    public function quitar(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $this->del();
            
            $this->db->trans_commit();
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    
    private function add(){
        $this->ProcesoRequerimientoFuncionalMapper->insert($this->getDomain());
    }
    private function upd(){
        $this->ProcesoRequerimientoFuncionalMapper->update($this->getDomain());
    }
    private function del(){
        $this->ProcesoRequerimientoFuncionalMapper->delete($this->getDomain());
    }
    
    public function getRequerimientos($procesoId){
        $finder = new ProcesoRequerimientoFRM2();
        $results = $finder->search(array('parProcesoId'=>$procesoId));
        return $this->getRefRequerimientos($results);
    }
    
    private function getRefRequerimientos(ResponseModel $results){
        $objects = $results->getResults();
        foreach($objects as $record){
            $record->Mapper()->getRequerimientoFuncional();
        }
        return $results;
    }
            
            
}