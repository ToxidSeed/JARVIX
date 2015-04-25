<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'TipoControlMapper.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TipoControlBO extends BaseBO{
    function __construct() {
        parent::__construct();
    }
    protected $dmnTipoControl;
    public function setDmnTipoControl(DomainTipoControl $dmnTipoControl){
        $this->dmnTipoControl = $dmnTipoControl;
    }
    public function getDmnTipoControl(){
        return $this->dmnTipoControl;
    }
    function add(){        
        try{            
            $this->load->database();        
            $this->db->trans_start();
            //Check Domain Object setted
            $this->checkObject(); 
            //Saving Object
            $mprTipoControl = new TipoControlMapper();
            $mprTipoControl->insert($this->dmnTipoControl);        
            $this->db->trans_commit();
        }catch(Exception $e){
            $this->db->trans_rollback();
            throw new Exception($e->getMessage());
        }
    }
    protected function checkObject(){
        if($this->dmnTipoControl == null){
            throw new Exception('El Objecto de Dominio del Tipo de Control no ha sido enviado',-1);
        }
    }
    function update(){
        try{
            $this->load->database();
            $this->db->trans_start();
            //Check Domain Object has been sent
            $this->checkObject();
            //Updatting                        
            $mprTipoControl = new TipoControlMapper();                                    
            $dmnCurrentTipoControl = $mprTipoControl->find($this->dmnTipoControl->getId());
            $dmnCurrentTipoControl->setNombre($this->dmnTipoControl->getNombre());
            $dmnCurrentTipoControl->setFechaUltAct($this->dmnTipoControl->getFechaUltAct());
            $dmnCurrentTipoControl->setEstado($this->dmnTipoControl->getEstado());
            //Updating Object
            $mprTipoControl->update($dmnCurrentTipoControl);
            $this->db->trans_commit();
        }catch(Exception $ex){
            $this->db->trans_rollback();
            throw new Exception($e->getMessage(),$ex->getCode());
        }
    }
    public function Inactivate(){
        try{
            $this->load->database();
            $this->db->trans_start();
            //Check Domain Object has been sent
            $this->checkObject();
            //Updatting                        
            $mprTipoControl = new TipoControlMapper();                                    
            $dmnCurrentTipoControl = $mprTipoControl->find($this->dmnTipoControl->getId());
            $dmnCurrentTipoControl->setFechaUltAct($this->dmnTipoControl->getFechaUltAct());
            $dmnCurrentTipoControl->setEstado($this->dmnTipoControl->getEstado());
            //Updating Status to Inactive
            $mprTipoControl->update($dmnCurrentTipoControl);            
            $this->db->trans_commit();
        }catch(Exception $ex){
            $this->db->trans_rollback();
            throw new Exception($e->getMessage(),$ex->getCode());
        }
    }
}
?>
