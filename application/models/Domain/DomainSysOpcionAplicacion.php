<?php
require_once BASEMODELPATH.'BaseDomain.php';
require_once DOMAINPATH.'DomainSysAplicacion.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class DomainSysOpcionAplicacion extends BaseDomain{
    
    protected $id;    
    protected $sysAplicacion;
    protected $nombre;
    protected $fechaRegistro;
    protected $parent;
    protected $viewLoader;
    
    public function __construct($id = null) {
        $this->id = $id;
    }


    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
    public function setSysAplicacion(DomainSysAplicacion $dmnSysAplicacion){
        $this->sysAplicacion = $dmnSysAplicacion;
    }
    public function getSysAplicacion(){
        return $this->sysAplicacion;
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
    public function setParent(DomainSysOpcionAplicacion $dmnParent){
        $this->parent = $dmnParent;
    }
    public function getParent(){
        return $this->parent;
    }
    public function setViewLoader($viewLoader){
        $this->viewLoader = $viewLoader;
        return $this;
    }
    public function getViewLoader(){
        return $this->viewLoader;
    }
}
?>
