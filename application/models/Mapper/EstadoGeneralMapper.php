<?php

require_once BASEMODELPATH.'BaseMapper.php';

class EstadoGeneralMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $tableName = '';
    protected $dmnObject = null;
    
    function doCreateObject(array $record = null){
        $this->dmnObject->setId($record['ID']);
        $this->dmnObject->setNombre($record['NOMBRE']);
        $this->dmnObject->setDescripcion($record['DESCRIPCION']);
        return $this->dmnObject;
    }
    
}