<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainTipoFlujo.php';

class TipoFlujoMapper extends BaseMapper{
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
    
    protected $tableName = 'tipoflujo';
    
    protected function doCreateObject(array $record = null){
        $dmnTipoFlujo =  new DomainTipoFlujo($record['ID']);
        $dmnTipoFlujo->setNombre($record['NOMBRE']);
        //$dmnTipoFlujo->setFlgDefault($record['FLGDEFAULT']);
        return $dmnTipoFlujo;
    }
    
//    public function insert(DomainTipoFlujo $dmnTipoFlujo){
//        $this->doInsert($dmnTipoFlujo);
//    }
//    protected function doInsert(DomainTipoFlujo $dmnTipoFlujo){
//        $fields['nombre'] = $dmnTipoFlujo->getNombre();
//        $fields['flgdefault'] = $dmnTipoFlujo->getFlgDefault();
//        $this->db->set($fields);
//        $this->db->set($fields);
//        $res  = $this->db->insert($this->tableName);
//        
//        $dmnTipoFlujo->setId($this->db->insert_id());
//        
//        if(!$res){
//            $this->db->trans_rollback();
//            throw new Exception('Error al Insertar eel tipo de flujo',-1);
//        }
//    }
    
    
}
