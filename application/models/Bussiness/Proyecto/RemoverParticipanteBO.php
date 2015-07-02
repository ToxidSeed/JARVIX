<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once BUSSINESSPATH.'ProyectoBO.php';
require_once MAPPERPATH.'ParticipanteMapper.php';
/*
 * Description of RemoverParticipanteBO
 *
 * @author usuario
 */
class RemoverParticipanteBO extends ProyectoBO{
    function __construct(){
        parent::__construct();
    }
    
    private $ProyectoId = null;
    private $dmnParticipante = null;
    
    public function quitar($ProyectoId,$arrUsuarios){
        $this->ProyectoId = $ProyectoId;
        foreach($arrUsuarios as $record){
            $this->_singleUpdate($record['id']);
        }
    }
    
    private function _singleUpdate($UsuarioId){
        if($this->verificarExistencia($UsuarioId)){
            $this->remover($UsuarioId);
        }
    }
    
    private function verificarExistencia($UsuarioId){
        $mprParticipante = new ParticipanteMapper();
        $mprParticipante->addUnique('sysusuarioid',$UsuarioId);
        $mprParticipante->addUnique('proyectoid',$this->ProyectoId);
        $this->dmnParticipante = $mprParticipante->find();
        if($this->dmnParticipante == null){             
           return false;
        }

        return true;
    }
    
    private function remover($UsuarioId){
        $mprParticipante = new ParticipanteMapper();
        $mprParticipante->Delete($this->dmnParticipante);
    }
    
}
