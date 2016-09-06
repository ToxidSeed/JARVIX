<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainComentario extends BaseDomain{
    protected $id;
    protected $tipo;
    protected $texto;
    protected $IdReferencia;
    
    function __construct($id) {
        $this->id = $id;
    }
            
    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getTexto() {
        return $this->texto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setTexto($texto) {
        $this->texto = $texto;
    }
    function getIdReferencia() {
        return $this->IdReferencia;
    }

    function setIdReferencia($IdReferencia) {
        $this->IdReferencia = $IdReferencia;
    }    
}