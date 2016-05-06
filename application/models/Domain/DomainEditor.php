<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DomainEditor
 *
 * @author usuario
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainEditor  extends BaseDomain{
    //put your code here
    protected $id;
    protected $constante;
    
    function __construct($id = null) {
        $this->id = $id;
    }
    
    function getId() {
        return $this->id;
    }

    function getConstante() {
        return $this->constante;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setConstante($constante) {
        $this->constante = $constante;
    }


}
