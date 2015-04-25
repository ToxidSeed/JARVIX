<?php

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainEstado.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class EstadoMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
          'id',
          'nombre'
    );
      protected $uniqueValues = array(
        array('id')
    );
        
    
    
    protected $tableName = 'Estado';
    
    protected function doCreateObject(array $record = null){
        $dmnEstado = new DomainEstado($record['ID']);
        $dmnEstado->setNombre($record['NOMBRE']);
        return $dmnEstado;
    }
}
?>
