<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainProceso extends BaseDomain{
    protected $id;
    protected $nombre;
    protected $fechaRegistro;
    protected $aplicacion;
    protected $proyecto;
    protected $fechaUltAct;
    protected $descripcion;
    protected $estado;
    protected $rutaPrototipo;
    public function __construct($id = null) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getAplicacion() {
        return $this->aplicacion;
    }

    public function setAplicacion($aplicacion) {
        $this->aplicacion = $aplicacion;
    }
    public function getProyecto() {
        return $this->proyecto;
    }

    public function setProyecto($proyecto) {
        $this->proyecto = $proyecto;
    }

        public function getFechaUltAct() {
        return $this->fechaUltAct;
    }

    public function setFechaUltAct($fechaUltAct) {
        $this->fechaUltAct = $fechaUltAct;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
    public function getRutaPrototipo() {
        return $this->rutaPrototipo;
    }

    public function setRutaPrototipo($rutaPrototipo) {
        $this->rutaPrototipo = $rutaPrototipo;
    }



}

?>
