<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'ProcesoMapper.php';

class ProcesoBO extends BaseBO{
    function __construct() {
        parent::__construct();
    }
    
    public function wrt(){
        try{
            $dmnProceso = $this->getDomain();
            if($dmnProceso->getId() > 0 ){
                $this->upd();
            }else{
                $this->add();
            }            
        }catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    function add(){
          try{
              $this->load->database();
              $this->db->trans_start();
              
              $mprProceso = new ProcesoMapper();             
              $mprProceso->insert($this->getDomain());
              
              $this->db->trans_commit();
          }catch(Exception $ex){
              $this->db->trans_rollback();
              throw new Exception($ex->getMessage(),$ex->getCode());   
          }
    }
    public function upd(){
        try{
              $this->load->database();
              $this->db->trans_start();
              
              $mprProceso = new ProcesoMapper();             
              $mprProceso->update($this->getDomain());
              
              $this->db->trans_commit();
          }catch(Exception $ex){
              $this->db->trans_rollback();
              throw new Exception($ex->getMessage(),$ex->getCode());   
          }
    }
}
?>
