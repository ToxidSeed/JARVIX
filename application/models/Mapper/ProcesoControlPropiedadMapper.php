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


class ProcesoControlPropiedadMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
        'procesocontrolpropiedad.id',
        'procesocontrolpropiedad.procesocontrolid',
        'procesocontrolpropiedad.valor',
        'procesocontrolpropiedad.propiedadid',
//        'procesocontrolpropiedad.controlpropiedadid'
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
//        $dmnProcesoControlPropiedad->setControlPropiedad(new DomainControlPropiedad($record['CONTROLPROPIEDADID']));        
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
        $fields['valor'] = $dmnProcesoControlPropiedad->getValor();
        $fields['propiedadid'] = $dmnProcesoControlPropiedad->getPropiedad()->getId();
//        $fields['controlpropiedadid'] = $dmnProcesoControlPropiedad->getControlPropiedad()->getId();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
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
}