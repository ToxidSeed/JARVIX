<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';
class DomainSysUsuario extends BaseDomain{
    protected $id;
    protected $email;
    protected $nombre;
    protected $fechaRegistro;
    protected $fechaActualizacion;
    protected $passusr;
    
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

    public function getFechaActualizacion() {
        return $this->fechaActualizacion;
    }

    public function setFechaActualizacion($value) {
        $this->fechaActualizacion = $value;
    }


    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    public function getPassusr() {
        return $this->passusr;
    }

    public function setPassusr($passusr) {
        $this->passusr = $passusr;
    }



}
?>
