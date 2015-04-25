<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainEstadoProcesoFlujo extends BaseDomain{
    protected $id;
    protected $nombre;
    protected $descripcion;
    
    function __construct($id) {
        $this->id = $id;
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }


}

