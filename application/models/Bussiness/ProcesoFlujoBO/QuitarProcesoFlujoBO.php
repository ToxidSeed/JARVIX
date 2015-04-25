<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'ProcesoFlujoMapper.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class QuitarProcesoFlujoBO extends BaseBO{
    function __construct() {
        parent::__construct();
        
        $this->mprProcesoFlujoMapper = new ProcesoFlujoMapper();
    }
    public $records;
    private $mprProcesoFlujoMapper;
    
    function Quitar(){
        try{
              $this->load->database();
              $this->db->trans_start();           
                                         
              $this->_multiQuitar();              
              //
              $this->db->trans_commit();
        }catch(Exception $ex){
              $this->db->trans_rollback();
              throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    
    private function _multiQuitar(){        
        foreach($this->records as $dmnProcesoFlujo){
            $this->_singleQuitar($dmnProcesoFlujo);
        }
    }
    
    private function _singleQuitar(DomainProcesoFlujo $dmnProcesoFlujo){
        $curProcesoFlujo = $this->mprProcesoFlujoMapper->find($dmnProcesoFlujo->getId());
        $curProcesoFlujo->setEstadoProcesoFlujo($dmnProcesoFlujo->getEstadoProcesoFlujo());
        $this->mprProcesoFlujoMapper->update($curProcesoFlujo);        
    }
}
