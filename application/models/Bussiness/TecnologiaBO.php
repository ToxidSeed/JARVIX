<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'TecnologiaMapper.php';

/**
 * Description of TecnologiaBO
 *
 * @author usuario
 */
class TecnologiaBO extends BaseBO{
    //put your code here
    function __construct() {
        parent::__construct();
        $this->mprTecnologia = new TecnologiaMapper();
    }
    protected $mprTecnologia;
    
    public function add(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $this->checkObject();            
            $this->mprTecnologia->insert($this->getDomain());
            
            $this->db->trans_commit();
        }catch(Exception $e){
            $this->db->trans_rollback();
            throw new Exception($e->getMessage(),$e->getCode());
        }
    }
}
