<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainPropiedad extends BaseDomain{
    protected $id;
    protected $nombre;
    protected $fechaRegistro;
    protected $fechaUltAct;
    protected $control;
    
    function __construct($id = null) {
        $this->id = $id;
    }
    function setId($id = null){
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
    public function setFechaRegistro($fechaRegistro){
        $this->fechaRegistro = $fechaRegistro;
    }
    public function getFechaRegistro(){
       return $this->fechaRegistro; 
    }
    public function setFechaUltAct($fechaUltAct){
        $this->fechaUltAct = $fechaUltAct;
    }
    public function getFechaUltAct(){
        return $this->fechaUltAct;
    }
    function getControl() {
        return $this->control;
    }

    function setControl($control) {
        $this->control = $control;
    }


}
?>
