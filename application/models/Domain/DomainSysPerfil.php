<?php
require_once BASEMODELPATH.'BaseDomain.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DomainSysPerfil
 *
 * @author usuario
 */
class DomainSysPerfil extends BaseDomain{
    //put your code here
    protected $id;
    protected $nombre;
    protected $fechaRegistro;
    protected $fechaActualizacion;
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getFechaActualizacion() {
        return $this->fechaActualizacion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function setFechaActualizacion($fechaActualizacion) {
        $this->fechaActualizacion = $fechaActualizacion;
    }


}
