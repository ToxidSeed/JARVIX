<?php
require_once BASEMODELPATH.'BaseDomain.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class DomainSysAplicacion extends BaseDomain{
    protected $id;
    protected $nombre;
    protected $fechaRegistro;
    
    function __construct($id = null) {
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
}
?>
