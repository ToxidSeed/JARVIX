<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainProcesoFlujo extends BaseDomain{
    protected $id;
    protected $proceso;
    protected $nombre;
    protected $descripcion;
    protected $estado;
    protected $alcanceCompletadoInd;
    
    function __construct($id = null) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getProceso() {
        return $this->proceso;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setProceso($proceso) {
        $this->proceso = $proceso;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    function getEstado() {
        return $this->estado;
    }

    function setEstado($estadoProcesoFlujo) {
        $this->estado = $estadoProcesoFlujo;
    }

    function getAlcanceCompletadoInd() {
        return $this->alcanceCompletadoInd;
    }

    function setAlcanceCompletadoInd($alcanceCompletadoInd) {
        $this->alcanceCompletadoInd = $alcanceCompletadoInd;
    }





}
