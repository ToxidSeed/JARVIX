<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseDomain.php';

class DomainEntrega extends BaseDomain{
    protected $id;
    protected $proyecto;
    protected $nombre;
    protected $fecha;
    protected $alcance;
    
    function __construct($id) {
        $this->id = $id ;
    }
    
    function getId() {
        return $this->id;
    }

    function getProyecto() {
        return $this->proyecto;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getAlcance() {
        return $this->alcance;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProyectoId($proyectoId) {
        $this->proyectoId = $proyectoId;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setAlcance($alcance) {
        $this->alcance = $alcance;
    }


}