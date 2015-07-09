<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'RequerimientoMapper.php';
require_once MAPPERPATH.'ActualProyectoFinder.php';
/*
 *Nota mental: Los metodos CheckStatus y SetNewStatus se pueden heredar de un generico
 * especialmente diseñado para mantenimientos
 */
class RequerimientoBO extends BaseBO{
    function __construct() {
        parent::__construct();
    }
    function add(){
        try{            
            $this->load->database();
            $this->db->trans_start();            
            $this->checkObject();            
            
            //Get the current project
//            $ActualProyectoFinder = new ActualProyectoFinder();
//            $dmnProyectoUsuario = $ActualProyectoFinder->Get(1);
            //Setting the current Project
            //$this->getDomain()->setProyecto($dmnProyectoUsuario->getProyecto());
            //Save requeriment
            $mprRequerimiento = new RequerimientoMapper();            
            $mprRequerimiento->insert($this->getDomain());            
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
            
            $mprRequerimiento = new RequerimientoMapper();
            $dmnRequerimiento = $mprRequerimiento->find($this->domain->getId());
            $dmnRequerimiento->setNombre($this->domain->getNombre());            
            $dmnRequerimiento->setDescripcion($this->domain->getDescripcion());            
            $mprRequerimiento->update($dmnRequerimiento);            
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

            $mprRequerimiento = new RequerimientoMapper();
            $dmnCurrentReq = $mprRequerimiento->find($this->domain->getId());
            $this->CheckStatus($dmnCurrentReq);
            //Setting the new Status
            $this->SetNewStatus($dmnCurrentReq);            
            //Saving Aplication              
            $mprRequerimiento->update($dmnCurrentReq);
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
