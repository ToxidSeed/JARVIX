<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';


class DomainProyecto extends BaseDomain{
    protected $id;
    protected $nombre;    
    protected $fechaRegistro;
    protected $fechaModificacion;
    protected $descripcion;
    protected $estado;
    protected $aplicacion;
    
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
    function setFechaRegistro($fechaRegistro){
        $this->fechaRegistro = $fechaRegistro;
    }   
    function getFechaRegistro(){
        return $this->fechaRegistro;
    }
    public function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    public function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }
    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getEstado() {
        require_once MAPPERPATH.'EstadoMapper.php';   
        if($this->mapper == true && $this->estado != null && $this->estado->getId() != null){            
           $mprEstado = new EstadoMapper();
           $this->estado = $mprEstado->find($this->estado->getId());
        }
        return $this->estado;
    }

    public function setEstado($estado) {
        
        //print_r($this->estado);
        
        $this->estado = $estado;
    }
    public function getAplicacion() {
        require_once MAPPERPATH.'AplicacionMapper.php';
        if($this->mapper == true && $this->estado != null && $this->estado->getId() != null){
            $mprAplicacion = new AplicacionMapper();
            $this->aplicacion = $mprAplicacion->find($this->aplicacion->getId());
        }
        return $this->aplicacion;
    }

    public function setAplicacion($aplicacion) {        
        $this->aplicacion = $aplicacion;
    }





    
}

?>
