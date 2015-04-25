<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainProcesoControl.php';
require_once DOMAINPATH.'DomainProceso.php';
require_once DOMAINPATH.'DomainTipoControl.php';

class ProcesoControlMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'id',
        'procesoid',
        'fecharegistro',
        'controlid',
        'nombre',
        'estadoprocesocontrolid'
    );
    
    protected $uniqueValues = array(
        array('id')
    );
    
    protected $tableName = 'procesocontrol';
    
    protected function doCreateObject(array $record = null){
        $dmnProcesoControl = new DomainProcesoControl($record['ID']);
        $dmnProcesoControl->setProceso(new DomainProceso($record['PROCESOID']));
        $dmnProcesoControl->setNombre($record['NOMBRE']);
        $dmnProcesoControl->setFechaRegistro($record['FECHAREGISTRO']);
        $dmnProcesoControl->setControl(new DomainTipoControl($record['CONTROLID']));
//        $dmnProcesoControl->setEstadoProcesoControl(new DomainEstadoProcesoControl($record['ESTADOPROCESOCONTROLID']));
        return $dmnProcesoControl;
    }
    
    public function insert(DomainProcesoControl $dmnProcesoControl){
        $this->doInsert($dmnProcesoControl);
    }
    
    protected function doInsert(DomainProcesoControl $dmnProcesoControl){
        $fields['procesoid'] = $dmnProcesoControl->getProceso()->getId();
        $fields['fecharegistro'] = $dmnProcesoControl->getFechaRegistro();
        $fields['controlid'] = $dmnProcesoControl->getControl()->getId();
        $fields['nombre'] = $dmnProcesoControl->getNombre();
//        $fields['estadocontrolid'] = $dmnProcesoControl->getEstadoProcesoControl()->getId();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
//        echo $this->db->last_query();
        $dmnProcesoControl->setId($this->db->insert_id());
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al insertar en la Base de Datos');
        }
    }
    
    public function update(DomainProcesoControl $dmnProcesoControl){
        $this->doUpdate($dmnProcesoControl);
    }
    
    protected function doUpdate(DomainProcesoControl $dmnProcesoControl){
        $fields['procesoid'] = $dmnProcesoControl->getProceso()->getId();
        $fields['fecharegistro'] = $dmnProcesoControl->getFechaRegistro();
        $fields['controlid'] = $dmnProcesoControl->getControl()->getId();
        $fields['nombre'] = $dmnProcesoControl->getNombre();
//        $fields['estadoprocesocontrolid'] = $dmnProcesoControl->getEstadoProcesoControl()->getId();
        $this->db->set($fields);
        $this->db->where('id',$dmnProcesoControl->getId());
        $res = $this->db->update($this->tableName);
        
//        echo $this->db->last_query();
        
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar el ProcesoControl',-1);
        }        
    }
    
    public function delete(DomainProcesoControl $dmnProcesoControl){
        $this->delete($dmnProcesoControl);
    }
    protected function doDelete(DomainProcesoControl $dmnProcesoControl){
        $this->db->where('id',$dmnProcesoControl->getId());
        $res = $this->db->delete($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Borrar un registro', -1);
        }
    }
}