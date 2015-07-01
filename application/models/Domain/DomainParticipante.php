<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainParticipante extends BaseDomain{
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    protected $id;
    protected $proyecto;
    protected $sysUsuario;
    protected $flgProyectoDefault;
    
    public function setId($val){
        $this->id = $val;        
    }
    public function getId(){
        return $this->id;
    }
    public function setProyecto(DomainProyecto $dmnProyecto = null){
        $this->proyecto = $dmnProyecto;
    }
    public function getProyecto(){
        return $this->proyecto;
    }
    public function setSysUsuario(DomainSysUsuario $dmnUsuario = null){
        $this->sysUsuario = $dmnUsuario;
    }
    public function getSysUsuario(){
        return $this->sysUsuario;
    }
    public function setFlgProyectoDefault($val){
        $this->flgProyectoDefault = $val;
    }
    public function getFlgProyectoDefault(){
        return $this->flgProyectoDefault;
    }
}
?>