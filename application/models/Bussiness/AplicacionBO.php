<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'AplicacionMapper.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AplicacionBO extends BaseBO{
    function __construct() {
        parent::__construct();
    }
//    protected $dmnAplicacion;
//    function setDmnAplicacion(DomainAplicacion $dmnAplicacion){
//        $this->dmnAplicacion = $dmnAplicacion;
//    }
//    function getDmnAplicacion(){
//        return $this->dmnAplicacion;
//    }
    function add(){
        try{
            $this->load->database();
            $this->db->trans_start();
            $this->checkObject();
            $mprAplicacion = new AplicacionMapper();
            $mprAplicacion->insert($this->getDomain());
            $this->db->trans_commit();
        }catch(Exception $ex){
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());
        }
    }
    function update(){
        try{
            $this->load->database();
            $this->db->trans_start();
            $this->checkObject();
            $mprAplicacion = new AplicacionMapper();            
            $dmnCurrentAplicacion = $mprAplicacion->find($this->domain->getId());
            $dmnCurrentAplicacion->setNombre($this->domain->getNombre());
            $mprAplicacion->update($dmnCurrentAplicacion);
            $this->db->trans_commit();
        }catch(Exception $ex){
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());
        }
    }
    
    public function ChangeStatus(){
        try{
            $this->load->database();
            $this->db->trans_start();
            $this->checkObject();
            $mprAplicacion = new AplicacionMapper();            
            $dmnCurrentAplicacion = $mprAplicacion->find($this->domain->getId());
            $dmnCurrentAplicacion->setFechaModificacion($this->domain->getFechaModificacion());
            //Checking the current status
            $this->CheckStatus($dmnCurrentAplicacion);
            //Setting the new Status
            $this->SetNewStatus($dmnCurrentAplicacion);            
            //Saving Aplication
            $mprAplicacion->update($dmnCurrentAplicacion);
            $this->db->trans_commit();
        }catch(Exception $ex){
            $this->db->trans_rollback();    
            throw new Exception($ex->getMessage(),$ex->getCode());
        }
    }
    
    private function CheckStatus($dmnAplicacion){
        if($dmnAplicacion->getEstado()->getId() != $this->domain->getEstado()->getId()){
            throw new Exception('Los Estados no Coinciden',-1);
        }
    }
    private function SetNewStatus(DomainAplicacion $dmnCurrentAplicacion){
        //If current status equals to 0 : Inactive, then Activate!
        if($this->domain->getEstado()->getId()== 0){
            $dmnCurrentAplicacion->getEstado()->setId(1); //Setting to Active
        }else{
            $dmnCurrentAplicacion->getEstado()->setId(0); //Setting to Active
        }
    }
}

?>