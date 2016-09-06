<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainDetalleAlcance extends BaseDomain{
    protected $id;
    protected $alcance;
    protected $tipoItem;
    protected $itemId;
    
    function getId() {
        return $this->id;
    }

    function getAlcance() {
        return $this->alcance;
    }

    function getTipoItem() {
        return $this->tipoItem;
    }

    function getItemId() {
        return $this->itemId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setAlcance($alcance) {
        $this->alcance = $alcance;
    }

    function setTipoItem($tipoItem) {
        $this->tipoItem = $tipoItem;
    }

    function setItemId($itemId) {
        $this->itemId = $itemId;
    }


}
