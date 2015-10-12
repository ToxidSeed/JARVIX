<?php
require_once BASEMODELPATH.'BaseDomain.php';
//require_once MAPPERPATH.'TecnologiaMapper.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class DomainTipoControl extends BaseDomain{
    protected $id;
    protected $nombre;
    protected $fechaRegistro;
    protected $fechaUltAct;
    protected $estado;
    protected $tecnologia;
    
    function __construct($id = null) {
        $this->id = $id;
    }
    
    function setId($id){
        $this->id = $id;
    }
    function getId(){
        return $this->id;
    }
    function setNombre($nombre){
        $this->nombre = $nombre;
    }
    function getNombre(){
        return $this->nombre;
    }
    function setFechaRegistro($fechaRegistro){
        $this->fechaRegistro = $fechaRegistro;
    }
    function getFechaRegistro(){
        return $this->fechaRegistro;
    }
    function setFechaUltAct($fechaUltAct){
        $this->fechaUltAct = $fechaUltAct;
    }
    function getFechaUltAct(){
        return $this->fechaUltAct;
    }
    function setEstado(DomainEstado $dmnEstado){
        $this->estado = $dmnEstado;
    }
    function getEstado(){
        return $this->estado;
    }
    function getTecnologia() {
        require_once MAPPERPATH.'TecnologiaMapper.php';        
        if($this->mapper == true && 
                $this->tecnologia != null &&
                 $this->tecnologia->getId() != null ){
                $mapper = new TecnologiaMapper();
                $this->tecnologia = $mapper->find($this->tecnologia->getId());
        }
        return $this->tecnologia;
    }

    function setTecnologia($tecnologia) {
        $this->tecnologia = $tecnologia;
    }


    
}

?>
