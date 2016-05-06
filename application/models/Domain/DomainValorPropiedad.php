<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';
/**
 * Description of DomainValorPropiedad
 *
 * @author usuario
 */
class DomainValorPropiedad extends BaseDomain{
    //put your code here
    function __construct($id = null) {        
        $this->id = ($id=='null')?null:$id;
    }
    
    protected $id;
    protected $valor;
    protected $propiedad;
    protected $flgDefault;
    
    function getId() {
        return $this->id;
    }



    function getPropiedad() {
        return $this->propiedad;
    }
    function getValor() {
        return $this->valor;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setId($id) {
        $this->id = ($id=='null')?null:$id;
    }



    function setPropiedad($propiedad) {
        $this->propiedad = $propiedad;
    }
    
    
    function getFlgDefault() {
        return $this->flgDefault;
    }

    function setFlgDefault($flgDefault) {        
        //print_r($flgDefault);
        $this->flgDefault = (
                                is_null($flgDefault) 
                                || $flgDefault == 'null' 
                                || $flgDefault == false 
                                || $flgDefault == 'false'
                            )?0:1;
    }   
}