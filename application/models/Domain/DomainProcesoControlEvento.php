<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseDomain.php';

class DomainProcesoControlEvento extends BaseDomain{
    function __construct($id = null) {
        $this->id = $id;
    }
    
    protected $id;
    protected $procesoControl;
    protected $valor;
    protected $controlEvento;
    protected $evento;
    
    function getId() {
        return $this->id;
    }

    function getProcesoControl() {
        return $this->procesoControl;
    }

    function getValor() {
        return $this->valor;
    }

    function getControlEvento() {
        return $this->controlEvento;
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

    function setControlEvento($controlEvento) {
        $this->controlEvento = $controlEvento;
    }
    function getEvento() {
         require_once MAPPERPATH.'EventoMapper.php';        
        if($this->mapper == true && $this->evento != null && $this->evento->getId() != null){
            $mprEvento = new EventoMapper();
            $this->evento = $mprEvento->find($this->evento->getId());            
        }        
        return $this->evento;
    }

    function setEvento($evento) {
        $this->evento = $evento;
    }



}