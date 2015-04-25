<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainTipoFlujo extends BaseDomain{
    protected $id;
    protected $nombre;
    protected $flgDefault;
    
    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getFlgDefault() {
        return $this->flgDefault;
    }

    public function setFlgDefault($flgDefault) {
        $this->flgDefault = $flgDefault;
    }
}