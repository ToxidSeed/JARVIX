<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainRequerimiento extends BaseDomain{
    protected $id;
    protected $proyecto;
    protected $codigo;    
    protected $nombre;    
    protected $descripcion;
    protected $estado;
    protected $fechaRegistro;
    protected $fechaModificacion;
    protected $orden;
    
    function __construct($id = null) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getProyecto() {
        return $this->proyecto;
    }

    public function setProyecto($proyecto) {
        $this->proyecto = $proyecto;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    public function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
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
        $this->estado = $estado;
    }
    function getOrden() {
        return $this->orden;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }




}
?>
