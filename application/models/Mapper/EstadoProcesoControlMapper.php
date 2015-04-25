<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'EstadoGeneralMapper.php';
require_once DOMAINPATH.'DomainEstadoProcesoControl.php';

class EstadoProcesoControlMapper extends EstadoGeneralMapper{
    function __construct() {
        parent::__construct();
        $this->tableName = 'EstadoProcesoControl';
        $this->dmnObject = new DomainEstadoProcesoControl();
    }
    
}