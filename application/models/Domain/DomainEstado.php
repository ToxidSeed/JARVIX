<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainEstado extends BaseDomain{
    protected $id;
    protected $nombre;
    protected $abreviatura;
    
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
}
?>
