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
    protected $control;
    protected $valor;
    protected $propiedad;
    
    
    function getId() {
        return $this->id;
    }

    function getProcesoControl() {
        return $this->procesoControl;
    }

    function getValor() {
        return $this->valor;
    }
    function getControl() {
        return $this->control;
    }

    function setControl($control) {
        $this->control = $control;
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