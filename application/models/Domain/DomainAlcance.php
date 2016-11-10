<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseDomain.php';

class DomainAlcance extends BaseDomain{
    protected $id;
    protected $tipo;
    protected $item;
    protected $entrega;

    function __construct($id = null){
        $this->id = $id;
    }
    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getItem() {
        return $this->item;
    }

    function getEntrega() {
        return $this->entrega;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setItem($item) {
        $this->item = $item;
    }

    function setEntrega($entrega) {
        $this->entrega = $entrega;
    }




}
