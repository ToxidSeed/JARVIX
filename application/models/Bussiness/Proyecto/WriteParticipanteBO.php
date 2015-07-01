<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once BUSSINESSPATH.'ProyectoBO.php';
require_once MAPPERPATH.'ParticipanteMapper.php';

class WriteParticipanteBO extends ProyectoBO{
    function __construct(){
        parent::__construct();
    }
    
    private $ProyectoId = null;
        
    public function write($ProyectoId,array $arrUsuarios = null){
          $this->ProyectoId = $ProyectoId;
          
          
          
          foreach($arrUsuarios as $record){            
              $this->_singleUpdate($record['id']);
          }
    }
    
    private function _singleUpdate($UsuarioId){
        if(!$this->checkAlreadyAdded($UsuarioId)){
            $this->addParticipante($UsuarioId);
        }
    }
    
    private function checkAlreadyAdded($UsuarioId){
          $mprParticipante = new ParticipanteMapper();
          $mprParticipante->addUnique('sysusuarioid',$UsuarioId);
          $mprParticipante->addUnique('proyectoid',$this->ProyectoId);
          $dmnParticipante = $mprParticipante->find();
          if($dmnParticipante == null){             
             return false;
          }
          
          return true;
    }
    
    private function addParticipante($UsuarioId){
        $mprParticipante = new ParticipanteMapper();
        $dmnParticipante = new DomainParticipante();
        $dmnParticipante->setSysUsuario(new DomainSysUsuario($UsuarioId));
        $dmnParticipante->setProyecto(new DomainProyecto($this->ProyectoId));
        $dmnParticipante->setFlgProyectoDefault(0);
        $mprParticipante->Insert($dmnParticipante);
    }
}
?>