<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseDomain.php';

class DomainProcesoControlPropiedad extends BaseDomain{
    function __construct($id = null) {
        $this->id = $id;
    }
    
    protected $id;
    protected $procesoControl;
    protected $valor;
    protected $propiedad;
    protected $controlPropiedad;
    
    function getId() {
        return $this->id;
    }

    function getProcesoControl() {
        return $this->procesoControl;
    }

    function getValor() {
        return $this->valor;
    }

    function getControlPropiedad() {
        return $this->controlPropiedad;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProcesoControl($procesoControl) {
        $this->procesoControl = $procesoControl;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setControlPropiedad($controlPropiedad) {
        $this->controlPropiedad = $controlPropiedad;
    }
    public function getPropiedad() {
        require_once MAPPERPATH.'PropiedadMapper.php';        
        if($this->mapper == true && $this->propiedad != null && $this->propiedad->getId() != null){
            $mprPropiedad = new PropiedadMapper();
            $this->propiedad = $mprPropiedad->find($this->propiedad->getId());            
        }
        return $this->propiedad;
    }

    public function setPropiedad($propiedad) {
        $this->propiedad = $propiedad;
    }




}