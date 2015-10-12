<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainEvento extends BaseDomain{
    protected $id;
    protected $nombre;
    protected $fechaRegistro;
    protected $fechaUltAct;
    protected $estado;
    protected $control;
    
    public function __construct($id = NULL) {
        $this->id = $id;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function getNombre(){
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
    public function setEstado(DomainEstado $dmnEstado){
        $this->estado = $dmnEstado;
    }
    public function getEstado(){
        return $this->estado;
    }
    function getControl() {
        return $this->control;
    }

    function setControl($control) {
        $this->control = $control;
    }


}
?>
