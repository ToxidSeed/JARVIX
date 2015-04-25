<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainEstadoProcesoFlujo.php';

class EstadoProcesoFlujoMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
        'id',
        'nombre'
    );
    
    protected $tableName = 'EstadoProcesoFlujo';
    
    protected function doCreateObject(array $record = null){
        $dmnEstado = new DomainEstadoProcesoFlujo($record['ID']);
        $dmnEstado->setNombre($record['NOMBRE']);
        $dmnEstado->setDescripcion($record['DESCRIPCION']);
        return $dmnEstado;
    }
    
}