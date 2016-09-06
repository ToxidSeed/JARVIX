<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseDomain.php';

class DomainAlcance extends BaseDomain{
    protected $id;
    protected $fechaCierre;

    function __construct($id) {
        $this->id = $id;
    }
    
    function getId() {
        return $this->id;
    }

    function getFechaCierre() {
        return $this->fechaCierre;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFechaCierre($fechaCierre) {
        $this->fechaCierre = $fechaCierre;
    }


}