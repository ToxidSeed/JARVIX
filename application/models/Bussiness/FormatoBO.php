<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'FormatoMapper.php';

class FormatoBO extends BaseBO{
//    function __construct() {
//        parent::__construct();
//    }
    
    function add(){
        try{
            $this->load->database();
            $this->db->trans_start();
            //Check Domain Object setted
            $this->checkObject(); 
            //Saving Object
            $mprFormato = new FormatoMapper();
            $mprFormato->insert($this->domain);        
            $this->db->trans_commit();
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage());
        }
    }
    
    public function update(){
        try{
            $this->load->database();
            $this->db->trans_start();
            //Check Domain Object setted
            $this->checkObject(); 
            //Saving Object
            $mprFormato = new FormatoMapper();
            $mprFormato->update($this->domain);        
            $this->db->trans_commit();
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage());
        }
    }
}