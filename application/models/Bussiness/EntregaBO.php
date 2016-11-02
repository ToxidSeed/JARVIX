<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'EntregaMapper.php';

class EntregaBO extends BaseBO{
    function __construct() {
        parent::__construct();
    }
    
    //@wrt
    public function wrt(DomainEntrega $dmnEntrega){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $mprEntregaMapper = new EntregaMapper();
            //var_dump($dmnEntrega->getId());
            //exit();
            if($dmnEntrega->getId() === NULL || $dmnEntrega->getId() ==='' ){
                //Update
                $mprEntregaMapper->insert($dmnEntrega);
            }else{
                $mprEntregaMapper->update($dmnEntrega);                                
                //Insert                
            }            
            $this->db->trans_commit();
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode()); 
        }
    }    
}