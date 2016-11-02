<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseDomain.php';

class DomainProcesoControl extends BaseDomain{
    function __construct($id = null) {
        $this->id = $id;
    }
    protected $id;
    protected $proceso;
    protected $fechaRegistro;
    protected $control;
    protected $estadoId;
    protected $nombre;
    protected $comentarios;
    protected $alcanceCompletadoInd;
                       
    function getId() {
        return $this->id;
    }

    function getProceso() {
        return $this->proceso;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getControl() {               
        require_once MAPPERPATH.'TipoControlMapper.php';        
        if($this->mapper == true && $this->control != null && $this->control->getId() != null){
            $mprTipoControl = new TipoControlMapper();
            $this->control = $mprTipoControl->find($this->control->getId());            
        }                
        return $this->control;
    }

   
    function setId($id) {
        $this->id = $id;
    }

    function setProceso($proceso) {
        $this->proceso = $proceso;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function setControl($control) {
        $this->control = $control;
    }

   
    function getNombre() {
        return $this->nombre;
    }

    function getComentarios() {
        return $this->comentarios;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }

    function getEstadoId() {
        return $this->estadoId;
    }

    function getAlcanceCompletadoInd() {
        return $this->alcanceCompletadoInd;
    }

    function setEstadoId($estadoId) {
        $this->estadoId = $estadoId;
    }

    function setAlcanceCompletadoInd($alcanceCompletadoInd) {
        $this->alcanceCompletadoInd = $alcanceCompletadoInd;
    }




}