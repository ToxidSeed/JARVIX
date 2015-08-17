<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DomainTecnologias
 *
 * @author usuario
 */
require_once BASEMODELPATH.'BaseDomain.php';
class DomainTecnologia extends BaseDomain{
    function __construct($id = null) {
        $this->setId($id);
    }
    //put your code here
    protected $id;
    protected $nombre;
    protected $estado;
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEstado() {               
        if($this->mapper == true && $this->estado != null && $this->estado->getId() != null){
            require_once MAPPERPATH.'Estado/EstadoTecnologiaMapper.php';        
            $mprEstado = new EstadoMapper();
            $this->estado = $mprEstado->find($this->estado->getId());            
        }
        return $this->estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }


}
