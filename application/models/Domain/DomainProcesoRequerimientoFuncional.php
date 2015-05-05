<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';
class DomainProcesoRequerimientoFuncional extends BaseDomain{
    protected $id;
    protected $fechaRegistro;
    protected $proceso;
    protected $requerimientoFuncional;
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    function getId() {
        return $this->id;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getProceso() {
        return $this->proceso;
    }

    function getRequerimientoFuncional() {
        
        require_once MAPPERPATH.'RequerimientoMapper.php';        
        if($this->mapper == true && $this->requerimientoFuncional != null && $this->requerimientoFuncional->getId() != null){
            $mapper = new RequerimientoMapper();
            $this->requerimientoFuncional = $mapper->find($this->requerimientoFuncional->getId());            
        }        
        return $this->requerimientoFuncional;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function setProceso($proceso) {
        $this->proceso = $proceso;
    }

    function setRequerimientoFuncional($requerimientoFuncional) {
        $this->requerimientoFuncional = $requerimientoFuncional;
    }


}

?>
