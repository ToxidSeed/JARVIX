<?php 

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainProcesoControlPropiedad.php';
require_once DOMAINPATH.'DomainControlPropiedad.php';
require_once DOMAINPATH.'DomainProcesoControl.php';
require_once DOMAINPATH.'DomainPropiedad.php';
require_once DOMAINPATH.'DomainTipoControl.php';


class ProcesoControlPropiedadMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
        'procesocontrolpropiedad.id',
        'procesocontrolpropiedad.procesocontrolid',
        'procesocontrolpropiedad.valor',
        'procesocontrolpropiedad.propiedadid',
        'procesocontrolpropiedad.controlid'
    );
    
    protected $uniqueValues = array(
        array('id'),
        array(
            'procesocontrolid'//,
//            'controlpropiedadid'
        )
    );  
    
    protected $tableName = 'procesocontrolpropiedad';
    
    protected function doCreateObject(array $record = null){
        $dmnProcesoControlPropiedad = new DomainProcesoControlPropiedad($record['ID']);
        $dmnProcesoControlPropiedad->setProcesoControl(new DomainProcesoControl($record['PROCESOCONTROLID']));
        $dmnProcesoControlPropiedad->setControl(new DomainTipoControl($record['CONTROLID']));
        $dmnProcesoControlPropiedad->setPropiedad(new DomainPropiedad($record['PROPIEDADID']));
        $dmnProcesoControlPropiedad->setValor($record['VALOR']);
                
        return $dmnProcesoControlPropiedad;
    }
    
    public function insert(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $this->doInsert($dmnProcesoControlPropiedad);
    }
    
    protected function doInsert(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $this->load->database();
        $fields['procesocontrolid'] = $dmnProcesoControlPropiedad->getProcesoControl()->getId();
        $fields['controlid'] = $dmnProcesoControlPropiedad->getControl()->getId();
        $fields['valor'] = $dmnProcesoControlPropiedad->getValor();
        $fields['propiedadid'] = $dmnProcesoControlPropiedad->getPropiedad()->getId();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        echo $this->db->last_query();
        $dmnProcesoControlPropiedad->setId($this->db->insert_id());
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en '.$this->tableName,-1);
        }
    }
    
    public function update(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $this->doUpdate($dmnProcesoControlPropiedad);
    }
    
    protected function doUpdate(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $fields['procesocontrolid'] = $dmnProcesoControlPropiedad->getProcesoControl()->getId();
        $fields['controlid'] = $dmnProcesoControlPropiedad->getControl()->getId();
        $fields['valor'] = $dmnProcesoControlPropiedad->getValor();
//        $fields['controlpropiedadid'] = $dmnProcesoControlPropiedad->getControlPropiedad()->getId();
        $this->db->set($fields);
        $this->db->where('id',$dmnProcesoControlPropiedad->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar la tabla '.$this->tableName,-1);
        }
    }
    
    public function delete(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $this->doDelete($dmnProcesoControlPropiedad);
    }
    
    protected function doDelete(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $this->db->where('id',$dmnProcesoControlPropiedad->getId());
        $res = $this->db->delete('procesocontrolpropiedad');
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al eliminar la tabla'.$this->tableName,-1);
        }
    }
}