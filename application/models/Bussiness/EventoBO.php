<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'EventoMapper.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class EventoBO extends BaseBO{
    function __construct() {
        parent::__construct();
    }
    protected $dmnEvento;
    function setDmnEvento(DomainEvento $dmnEvento){
        $this->dmnEvento = $dmnEvento;
    }    
    function getDmnEvento(){
        return $this->dmnEvento;
    }
    
    function add(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $this->checkObject();
            
            $mprEvento = new EventoMapper();
            $mprEvento->insert($this->getDmnEvento());
            
            $this->db->trans_commit();
        }catch(Exception $e){
            $this->db->trans_rollback();
            throw new Exception($e->getMessage(),$e->getCode());
        }
    }
    
    function update(){
        try{
           $this->load->database();
           $this->db->trans_start();
           
           $this->checkObject();
           
           $mprEvento = new EventoMapper();
           $dmnCurrentEvento = $mprEvento->find($this->dmnEvento->getId());
           $dmnCurrentEvento->setNombre($this->dmnEvento->getNombre());
           $dmnCurrentEvento->setFechaUltAct($this->dmnEvento->getFechaUltAct());
           $dmnCurrentEvento->setFechaRegistro($this->dmnEvento->getFechaRegistro());
           $mprEvento->update($dmnCurrentEvento);
           $this->db->trans_commit();
        }catch(Exception $e){
            $this->db->trans_rollback();
            throw new Exception($e->getMessage(),$ex->getCode());
        }
    }
    
     public function checkObject(){
        if($this->dmnEvento == null){
            throw new Exception('El Objecto de Dominio del Tipo de Control no ha sido enviado',-1);
        }
    }
    
}
?>
