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
    //protected $alcance;
    public function __construct($id) {
        $this->id = $id;
    }
    function getId() {
        return $this->id;
    }

    function getProyecto() {
        if($this->mapper ===true){
            require_once(MAPPERPATH.'ProyectoMapper.php');
            $mprProyectoMapper = new ProyectoMapper();
            $this->proyecto = $mprProyectoMapper->find($this->proyecto->getId());
        }        
        return $this->proyecto;
    }
  
    function getFecha() {        
        return $this->fecha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProyecto($proyecto) {
        $this->proyecto = $proyecto;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    
    function setFecha($fecha) {
        $this->fecha = $fecha;
    }




}