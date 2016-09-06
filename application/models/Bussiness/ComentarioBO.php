<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'ComentarioMapper.php';

class ComentarioBO extends BaseBO{
    function __construct() {
        parent::__construct();
    }
    
    public function wrt(){
        try{
            $dmnComentario = $this->getDomain();
            if($dmnComentario->getId() > 0 ){
                    $this->upd();
                }else{
                    $this->add();
                }            
        }catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    
    public function add(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $mprComentario = new ComentarioMapper();
            $mprComentario->insert($this->getDomain());
            
            $this->db->trans_commit();  
        } catch (Exception $ex) {
              $this->db->trans_rollback();
              throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    
    public function upd(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $mprComentario = new ComentarioMapper();
            $mprComentario->update($this->getDomain());
            
            $this->db->trans_commit();
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    
    public function del($id){
        try{
            $this->load->database();
            $this->db->trans_start();
            $mprComentario = new ComentarioMapper();
            $mprComentario->delete($id);
            $this->db->trans_commit();
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
}