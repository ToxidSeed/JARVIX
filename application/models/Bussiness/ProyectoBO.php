<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'ProyectoMapper.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ProyectoBO extends BaseBO{
    function __construct() {
        parent::__construct();
    }
    function add(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $this->checkObject();
            
            $mprProyecto = new ProyectoMapper();            
            $mprProyecto->insert($this->getDomain());
            
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
            
            $mprProyecto = new ProyectoMapper();
            $dmnCurrentProyecto = $mprProyecto->find($this->domain->getId());
            $dmnCurrentProyecto->setNombre($this->domain->getNombre());            
            $mprProyecto->update($dmnCurrentProyecto);            
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
              
              $mprProyecto = new ProyectoMapper();
              $dmnCurrentProyecto = $mprProyecto->find($this->domain->getId());
              $this->CheckStatus($dmnCurrentProyecto);
              //Setting the new Status
              $this->SetNewStatus($dmnCurrentProyecto);            
              //Saving Aplication              
              $mprProyecto->update($dmnCurrentProyecto);
              $this->db->trans_commit();                            
          }catch(Exception $ex){
                $this->db->trans_rollback();    
                throw new Exception($ex->getMessage(),$ex->getCode());
          }                
    }
    private function CheckStatus($domain){        
        if($domain->getEstado()->getId() != $this->domain->getEstado()->getId()){
            throw new Exception('Los Estados no Coinciden',-1);
        }
    }
    private function SetNewStatus($domain){
        if($this->domain->getEstado()->getId()== 0){
            $domain->getEstado()->setId(1); //Setting to Active
        }else{
            $domain->getEstado()->setId(0); //Setting to Active
        }
    }
}
?>