<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainControlPropiedad.php';
require_once DOMAINPATH.'DomainTipoControl.php';
require_once DOMAINPATH.'DomainPropiedad.php';

class BaseFinderProperties extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
       'id',
        'controlid',
        'propiedadid'
    );
    protected $uniqueValues = array(
        array('id')
    );
    
    protected $tableName = 'ControlPropiedad';
    
    protected function doCreateObject(array $record = null){
        $dmnControlPropiedad = new DomainControlPropiedad($record['ID']);
        $dmnControlPropiedad->setControl(new DomainTipoControl($record['CONTROLID']));;
        $dmnControlPropiedad->setPropiedad(new DomainPropiedad($record['PROPIEDADID']));        
        return $dmnControlPropiedad;
    }
}
?>
