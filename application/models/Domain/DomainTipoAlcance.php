<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseDomain.php';

class DomainTipoAlcance extends BaseDomain{
    protected $id;
    protected $nombre;   
    
    const _TIPO_PROCESO = 1;
    const _TIPO_PROCESO_FLUJO = 2;
    const _TIPO_PROCESO_CONTROL = 3;
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }


}