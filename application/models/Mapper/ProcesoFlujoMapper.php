<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainProceso.php';
require_once DOMAINPATH.'DomainProcesoFlujo.php';
require_once DOMAINPATH.'DomainEstadoProcesoFlujo.php';

class ProcesoFlujoMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'id',
        'procesoid',
        'nombre',
        'descripcion',
        'estadoprocesoflujoid'
    );
    
    protected $uniqueValues = array(
        array('id')
    );
    
    protected $tableName = 'procesoflujo';
    
    protected function doCreateObject(array $record = null){
        $dmnProcesoFlujo = new DomainProcesoFlujo($record['ID']);
        $dmnProcesoFlujo->setProceso(new DomainProceso($record['PROCESOID']));
        $dmnProcesoFlujo->setNombre($record['NOMBRE']);
        $dmnProcesoFlujo->setDescripcion($record['DESCRIPCION']);
        $dmnProcesoFlujo->setEstadoProcesoFlujo(new DomainEstadoProcesoFlujo($record['ESTADOPROCESOFLUJOID']));
        
        return $dmnProcesoFlujo;
    }
    
    public function insert(DomainProcesoFlujo $dmnProcesoFlujo){
        $this->doInsert($dmnProcesoFlujo);
    }
    protected function doInsert(DomainProcesoFlujo $dmnProcesoFlujo){
        $fields['procesoid'] = $dmnProcesoFlujo->getProceso()->getId();
        $fields['nombre'] = $dmnProcesoFlujo->getNombre();
        $fields['descripcion'] = $dmnProcesoFlujo->getDescripcion();
        $fields['estadoprocesoflujoid'] = $dmnProcesoFlujo->getEstadoProcesoFlujo()->getId();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        
        $dmnProcesoFlujo->setId($this->db->insert_id());
        
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la Base de Datos Proceso Flujo Mapper',-1);
        }
    }
    public function update(DomainProcesoFlujo $dmnProcesoFlujo){
        $this->doUpdate($dmnProcesoFlujo);
    }
    protected function doUpdate(DomainProcesoFlujo $dmnProcesoFlujo){
        $fields['nombre'] = $dmnProcesoFlujo->getNombre();
        $fields['procesoid'] = $dmnProcesoFlujo->getProceso()->getId();
        $fields['descripcion'] = $dmnProcesoFlujo->getDescripcion();
        $fields['estadoprocesoflujoid'] = $dmnProcesoFlujo->getEstadoProcesoFlujo()->getId();
        $this->db->set($fields);
        $this->db->where('id',$dmnProcesoFlujo->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar el Proceso Flujo',-1);
        }
    }
}